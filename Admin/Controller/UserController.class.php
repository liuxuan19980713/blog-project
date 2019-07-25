<?php

namespace Admin\Controller;

use Frame\libs\BaseController;
use Admin\Model\UserModel;
use Frame\Vendors\Smarty;

class UserController extends BaseController
{
    public function index()
        {
            $modelObj = UserModel::createObj();
            $sql = "select * from user order by id desc";
            $arrs = $modelObj->getIndexData($sql);
            $this->smartyObj->assign('arrs', $arrs);
            $this->smartyObj->display('./User/index.html');
        }
    public function delete(){
        $modelObj = UserModel::createObj();
        $id = $_GET['deleteid'];
        $sql = "delete from user where id={$id}";
        $result = $modelObj->deleteById($sql);
        if($result){
            $this->resultHandle('删除成功',3,'?c=User&a=index');
        }else{
            $this->resultHandle('删除失败',3,'?c=User&a=index');
        }
    }
    public function add(){
        $this->smartyObj->display('./User/add.html');
    }
    public function insert(){
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
        if($modelObj->rowCount($sql)){
            $this->resultHandle('用户存在请重试',3,'?c=User&a=add');
        }
        if(md5($password)!=md5($confirmpwd)){
            $this->resultHandle('两次密码不一致',3,'?c=User&a=add');
        }
        $password = md5($password);
        $sql = "insert into user(username,password,name,tel,status,role,last_login_time)values('{$username}','{$password}','{$name}','{$tel}','{$status}','{$role}',$addate)";
        $result = $modelObj->deleteById($sql);
        if($result){
            $this->resultHandle('添加成功',3,'?c=User&a=index');
        }else{
            $this->resultHandle('添加失败',3,'?c=User&a=add');
        }
    }
    public function edit(){
        $editId = $_GET['editid'];
        // 先从数据库中获取对应id的数据显示到界面上
        $modelObj = UserModel::createObj();
        $sql = "select * from user where id={$editId}";
        $arr = $modelObj->getEditData($sql);
        $arr['id'] =$editId;
        $this->smartyObj->assign('arr',$arr);
        $this->smartyObj->display("./User/edit.html");
    }
    public function update(){
        $updateId = $_GET['updateid'];
        die($updateId);
    }
}
