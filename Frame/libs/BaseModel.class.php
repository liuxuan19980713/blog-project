<?php  
namespace Frame\libs;
use Frame\Vendors\PDOWrapper;
 class BaseModel{
    protected $pdoWrapper = null;
   public function __construct()
   {
       $this->pdoWrapper = new PDOWrapper('mysql');
   }

}