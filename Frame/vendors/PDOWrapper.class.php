<?php

namespace Frame\Vendors;

use PDO;

class PDOWrapper
{
    private $DB_HOST;
    private $DB_ROOT;
    private $DB_PASS;
    private $DB_CHARSET;
    private $DB_PORT;
    private $DB_DATABASE_NAME;

    # 公共的方法的构造方法给PDO初始化
    public  function __construct($type)
    {
        $this->DB_HOST = $GLOBALS['config']['DB_HOST'];
        $this->DB_ROOT = $GLOBALS['config']['DB_ROOT'];
        $this->DB_PASS = $GLOBALS['config']['DB_PASS'];
        $this->DB_CHARSET = $GLOBALS['config']['DB_CHARSET'];
        $this->DB_DATABASE_NAME = $GLOBALS['config']['DB_DATABASE_NAME'];
        $this->DB_PORT = $GLOBALS['config']['DB_PORT'];
        $this->CreatePDOObj($type);
    }
    public function CreatePDOObj($type)
    {
        $dsn = "{$type}:host=" . "{$this->DB_HOST};" . "port=" . "{$this->DB_PORT};" . "dbname=" . "{$this->DB_DATABASE_NAME};" . "charset={$this->DB_CHARSET}";

        $pdo = new PDO($dsn, $this->DB_ROOT, $this->DB_PASS);
        
    }
}
