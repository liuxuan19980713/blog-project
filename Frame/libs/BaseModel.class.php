<?php  
namespace Frame\libs;
use Frame\Vendors\PDOWrapper;

 class BaseModel{
   protected $pdoWrapper = null;
   private $categoryDatas =array();
   public function __construct()
   {
       $this->pdoWrapper = new PDOWrapper('mysql');
   }
   # 工厂创建对象的方法
   public  static function createObj(){
     $modelName = get_called_class();
     return  new $modelName();
   }
   # 获取全部数据的方法
    public function fetchAll($where="3>2"){
     $sql = "select * from {$this->table} where {$where}";
     return $this->pdoWrapper->fetchAll($sql);
    }
    # 无限极分类数据的处理方法
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
  public function  insert_delete_update($sql){
    return $this->pdoWrapper->delete_insert_update($sql);
  }
  public function rowsCount($where='3>2'){
      $sql = "select * from {$this->table1} where  {$where}";
      return $this->pdoWrapper->rowTotal($sql);
  }

}