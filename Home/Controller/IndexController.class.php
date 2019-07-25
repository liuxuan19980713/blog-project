<?php  
namespace Home\Controller;
use  Home\Model\IndexModel;
use Frame\libs\BaseController;

class IndexController extends BaseController{
    public  function index(){
      // 创建模型类对象
      $modelObj = new IndexModel();
      $arrs = $modelObj->getDatas();
     
      $this->smartyObj->assign('arrs',$arrs);
      $this->smartyObj->display('.'.DS.'Index'.DS.'index.html');
      }

}