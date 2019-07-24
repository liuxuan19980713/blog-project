<?php  
namespace Admin\Model;
use  Frame\libs\Db;
class IndexModel{
    public function getDatas(){
        $db = Db::newObject();     
        $sql = "select * from itcast";
        return $db->fetchAllDatas($sql);
    }
}