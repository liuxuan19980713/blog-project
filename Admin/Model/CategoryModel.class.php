<?php  
namespace Admin\Model;
use Frame\libs\BaseModel;
class CategoryModel extends BaseModel{
    private $categoryDatas=array();
    public function getAllDatas($sql){
        return $this->pdoWrapper->fetchAll($sql);
    }
    // 获取无限极分类数据的方法
    public function categoryList($arrs,$id=0,$level=0){
        foreach($arrs as $arr){
            if($arr['pid']==$id){
                $arr['level'] = $level;
                $this->categoryDatas[] = $arr;
                $this->categoryList($arrs,$arr['id'],$level+1);
            }
        }
        return $this->categoryDatas;
    }
    public  function delete_insert_updata($sql){
        return $this->pdoWrapper->delete_insert_update($sql);
    }
}