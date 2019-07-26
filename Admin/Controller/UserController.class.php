<?php

namespace Admin\Controller;

use Frame\libs\BaseController;
use Admin\Model\UserModel;
use Frame\Vendors\Smarty;
use Frame\Vendors\VerificationCode;

class UserController extends BaseController
{
    public function index()
    {
        $this->isLogin();
        $modelObj = UserModel::createObj();
        $sql = "select * from user order by id desc";
        $arrs = $modelObj->getIndexData($sql);
        $this->smartyObj->assign('arrs', $arrs);
        $this->smartyObj->display('./User/index.html');
    }
    public function delete()
    {
        $this->isLogin();
        $modelObj = UserModel::createObj();
        $id = $_GET['deleteid'];
        $sql = "delete from user where id={$id}";
        $result = $modelObj->deleteById($sql);
        if ($result) {
            $this->resultHandle('删除成功', 3, '?c=User&a=index');
        } else {
            $this->resultHandle('删除失败', 3, '?c=User&a=index');
        }
    }
    public function add()
    {
        $this->isLogin();
        $this->smartyObj->display('./User/add.html');
    }
    public function insert()
    {
        $this->isLogin();
        $modelObj = UserModel::createObj();
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirmpwd = $_POST['confirmpwd'];
        $name = $_POST['name'];
        $tel = $_POST['tel'];
        $status = $_POST['status'];
        $role = $_POST['role'];
        $addate = time();
        $sql = "select * from user where username='{$username}'";
        if ($modelObj->rowCount($sql)) {
            $this->resultHandle('用户存在请重试', 3, '?c=User&a=add');
        }
        if (md5($password) != md5($confirmpwd)) {
            $this->resultHandle('两次密码不一致', 3, '?c=User&a=add');
        }
        $password = md5($password);
        // 这里应该使用循环拼接的方式会更加的灵活
        $sql = "insert into user(username,password,name,tel,status,role,last_login_time)values('{$username}','{$password}','{$name}','{$tel}','{$status}','{$role}',$addate)";
        $result = $modelObj->deleteById($sql);
        if ($result) {
            $this->resultHandle('添加成功', 3, '?c=User&a=index');
        } else {
            $this->resultHandle('添加失败', 3, '?c=User&a=add');
        }
    }
    public function edit()
    {
        $this->isLogin();
        $editId = $_GET['editid'];
        // 先从数据库中获取对应id的数据显示到界面上
        $modelObj = UserModel::createObj();
        $sql = "select * from user where id={$editId}";
        $arr = $modelObj->getEditData($sql);
        $arr['id'] = $editId;
        $this->smartyObj->assign('arr', $arr);
        $this->smartyObj->display("./User/edit.html");
    }
    public function update()
    {
        $this->isLogin();
        $updateId = $_GET['updateid'];
        die($updateId);
    }
    public function login()
    {

        $this->smartyObj->display('./User/login.html');
    }
    public function loginCheck()
    {
        // 获取用户提交的数据
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $yanzhengCode = strtolower($_POST['verify']);
        // 判断验证码输入是否正确
        if($yanzhengCode!=strtolower($_SESSION['code'])){
            $this->resultHandle('验证码不正确', 3, '?c=User&a=login');
        }
        // 判断用户的账号和密码 因为这里还要用到用户的其他数据，所以这里不能用rowCount
        $sql = "select * from user where username='{$username}' and password='{$password}'";
        $arr = UserModel::createObj()->getEditData($sql);
        if (!$arr) {
            $this->resultHandle('账号或者密码不正确', 3, '?c=User&a=index');
        }
        // 判断用户的账号状态
        if ($arr['status'] == 0) {
            $this->resultHandle('您被限制登录了,请联系管理员~', 3, '?c=User&a=login');
        }
        // 更新用户信息的状态
        # last_login_ip last_login_time login_times
        $last_login_ip = $_SERVER['REMOTE_ADDR'];
        $last_login_time = time();
        $login_times = $arr['login_times'] + 1;
        $sql = "update user set last_login_ip='{$last_login_ip}',last_login_time={$last_login_time}, login_times={$login_times} where id={$arr['id']}";
        $result = UserModel::createObj()->insert($sql);
        if (!$result) {
            $this->resultHandle('用户的信息更新失败，请重试', 3, '?c=User&a=login');
        }
        // 存储到session中
        $_SESSION['id'] = $arr['id'];
        $_SESSION['username'] = $arr['username'];
        // 跳转 登陆成功的话跳转到admin.php
        echo "登录成功，三秒后跳转到用户首页";
        header('refresh:3;url="?"');
    }
    public function verifi()
    {
        $verify = new VerificationCode();
        var_dump(($verify));
        die();
    }
    public function logout(){
        // 清除session和session文件
       unset($_SESSION['username']);
       unset($_SESSION['id']);
       session_destroy();
       header("location:?c=User&a=login");
    }
}
