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
}