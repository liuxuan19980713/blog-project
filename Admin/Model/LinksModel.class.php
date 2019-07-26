<?php  
namespace Admin\Model;

use Frame\libs\BaseModel;

class LinksModel extends BaseModel{
   public function getIndexDatas(){
        $sql = "select * from links";
        return $this->pdoWrapper->fetchAll($sql);
   }
}