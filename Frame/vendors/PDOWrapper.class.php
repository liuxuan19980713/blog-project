<?php
namespace Frame\Vendors;
use PDO;
use Exception;
class PDOWrapper
{
    private $DB_HOST;
    private $DB_ROOT;
    private $DB_PASS;
    private $DB_CHARSET;
    private $DB_PORT;
    private $DB_DATABASE_NAME;
    private $pdo = null;

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
        $this->setPDOConfig();
    }
    public function CreatePDOObj($type)
    {
        try {
            $dsn = "{$type}:host=" . "{$this->DB_HOST};" . "port=" . "{$this->DB_PORT};" . "dbname=" . "{$this->DB_DATABASE_NAME};" . "charset={$this->DB_CHARSET}";
            $this->pdo = new PDO($dsn, $this->DB_ROOT, $this->DB_PASS);
            return $this->pdo;
        } catch (Exception $e) {
            $this->errHandler($e, '数据库连接失败!');
        }
    }
    public function setPDOConfig()
    {
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function delete_insert_update($sql)
    {
        return $this->pdo->exec($sql);
    }
    private function errHandler($e, $msg)
    {
        echo  $e->getMessage();
        echo "<br>";
        die($msg);
    }
    public function fetchOne($sql)
    {
        try {
            $PDOstatement = $this->pdo->query($sql, PDO::FETCH_ASSOC);
            return $PDOstatement->fetch();
        } catch (Exception $e) {
            $this->errHandler($e, 'sql查询语句有误');
        }
    }
    public function fetchAll($sql)
    {
        try {
            $PDOstatement = $this->pdo->query($sql, PDO::FETCH_ASSOC);
            return $PDOstatement->fetchAll();
        } catch (Exception $e) {
            $this->errHandler($e, 'sql查询语句有误');
        }
    }
    public function rowTotal($sql)
    {
        try {
            $PDOstatement = $this->pdo->query($sql);
            return $PDOstatement->rowCount();
        } catch (Exception $e) {
            $this->errHandler($e, 'sql查询语句有误');
        }
    }
}
