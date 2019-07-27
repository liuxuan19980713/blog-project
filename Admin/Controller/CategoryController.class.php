<?php   
namespace Admin\Controller;

use Frame\libs\BaseController;
use Admin\Model\CategoryModel;

class CategoryController extends BaseController{
    public function  index(){
        $sql = "select * from category2 order by id asc";
        $arrs = CategoryModel::createObj()->getAllDatas($sql);    
        // 把原始数据给model，让model给我无限极分类的数据
        $categoryList = CategoryModel::createObj()->categoryList($arrs);
        $this->smartyObj->assign('arrs',$categoryList);
        $this->smartyObj->display('./Category/index.html');
    }
    public function add(){
        $sql = "select * from category2 order by id asc";
        $categoryList = CategoryModel::createObj()->categoryList(CategoryModel::createObj()->getAllDatas($sql));
        $this->smartyObj->assign('arrs',$categoryList);
        $this->smartyObj->display('./Category/add.html');
    }
    public  function insert(){
        $classname = $_POST['classname'];
        $orderby = $_POST['orderby'];
        $pid = $_POST['pid'];
        $sql = "insert into category2(classname,orderby,pid)values('{$classname}',{$orderby},{$pid})";
        $result = CategoryModel::createObj()->delete_insert_updata($sql);
        if($result){
            $this->resultHandle('插入成功', 3, '?c=Category&a=index');
        }else{
            $this->resultHandle('插入失败，请重试', 3, '?c=Category&a=add');
        }
    }
}