<?php  
namespace Admin\Controller;
use Frame\libs\BaseController;
use Admin\Model\LinksModel;
class LinksController extends BaseController{
    public function index(){
        $this->isLogin();
        $arrs = LinksModel::createObj()->getIndexDatas();
        $this->smartyObj->assign('arrs',$arrs);
        $this->smartyObj->display('./Links/index.html');
    }
    public function edit(){
        $this->smartyObj->display('./Links/edit.html');
    }
    public function delete(){
      
    }
    public function add(){
        $this->smartyObj->display('./Links/add.html');
    }
}