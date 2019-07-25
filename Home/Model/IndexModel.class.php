<?php

namespace Home\Model;

use Frame\libs\BaseModel;

class IndexModel extends BaseModel
{
    public function getDatas()
    {
        $sql = "select * from itcast";
        return  $this->pdoWrapper->fetchAll($sql);
    }
}
