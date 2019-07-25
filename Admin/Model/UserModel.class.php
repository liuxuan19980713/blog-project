<?php

namespace Admin\Model;

use Frame\libs\BaseModel;

class UserModel extends BaseModel
{
    public function getIndexData($sql)
    {
        return  $this->pdoWrapper->fetchAll($sql);
    }
    public function deleteById($sql)
    {
        return $this->pdoWrapper->delete_insert_update($sql);
    }
    public  function insert($sql){

        return  $this->pdoWrapper->delete_insert_update($sql);
    }
    public function rowCount($sql){
        return $this->pdoWrapper->rowTotal($sql);
    }
    public function getEditData($sql){
        return $this->pdoWrapper->fetchOne($sql);
    }
   
}
