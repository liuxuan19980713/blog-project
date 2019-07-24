<?php  
namespace Admin\Controller;
use  Admin\Model\IndexModel;
class IndexController{
    public  function index(){

      // 创建模型类对象
      $modelObj = new IndexModel();

      $arrs = $modelObj->getDatas();
        
       include(VIEW_PATH."Index".DS."index.html");
    }
}