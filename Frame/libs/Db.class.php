<?php
namespace Frame\libs;
class Db
{
    // 私有的静态,保存对象的属性 $obj
    private static $obj=null;
    private $DB_HOST;
    private $DB_ROOT;
    private $DB_PASS;
    private $DB_CHARSET;
    private $DB_PORT;
    private $DB_DATABASE_NAME;
    private static $link;

    // 私有的构造方法，防止外界来new
    private function __construct()
    {
        $this->DB_HOST = $GLOBALS['config']['DB_HOST'];
        $this->DB_ROOT = $GLOBALS['config']['DB_ROOT'];
        $this->DB_PASS = $GLOBALS['config']['DB_PASS'];
        $this->DB_CHARSET = $GLOBALS['config']['DB_CHARSET'];
        $this->DB_DATABASE_NAME = $GLOBALS['config']['DB_DATABASE_NAME'];
        $this->DB_PORT = $GLOBALS['config']['DB_PORT'];
        $this->connect();
        $this->charset_set();
    }

    // 私有的克隆方法，防止外界通过克隆来产生对象

    private function __clone()
    { }

    // 连接数据库的方法，只在我本类中使用，所以使用private修饰符来修饰
    private function connect()
    {
        self::$link = mysqli_connect($this->DB_HOST, $this->DB_ROOT, $this->DB_PASS, $this->DB_DATABASE_NAME, $this->DB_PORT);
        if (!self::$link) {
            exit('连接失败');
        }
        return;
    }
    // 设置数据库字符集的方法，只在我本类中使用，所以使用private修饰符来修饰
    private function charset_set()
    {
        mysqli_set_charset(self::$link, $this->DB_CHARSET);
    }

    //公共的静态产生对象的方法
    public static function newObject()
    {
        // 在内部创建对象，这样可以更好的控制对象
        if (self::$obj instanceof self) {
            return self::$obj;
        }
        // self指向的就是当前类
        return self::$obj = new self();
    }
    // 定义一个公共的的删除，更新，添加的方法，因为外边需要用到我操作的结果所有这里使用public修饰
    public function delete_update_add($sql){
        # 判断传入不是更新的sql语句
        $sql = strtolower($sql);
        if(substr($sql,0,6)=='select'){
            exit('不可以执行select语句');
        }
        //把增删改的布尔结果返回出去
        return mysqli_query(self::$link,$sql);

    }
    // 定义一个私有查询方法，因为我查询的结果在类的内部还需要进一步的操作，而不是直接返回给外边，也就是说外边不需要使用
    // 所以应该使用private来修饰
    private function query($sql){
        $sql = strtolower($sql);
        if(!substr($sql,0,6)=='select'){
            exit('不可以执行非select语句');
        }
        // 把结果集返回出去作进一步的处理
        return mysqli_query(self::$link,$sql);
    }

    // 公共的获取数据库单条数据的方法

    public function fetchOneData($sql,$type=3){
        $arr = array(
            1=>MYSQLI_BOTH,
            2=>MYSQLI_NUM,
            3=>MYSQLI_ASSOC
        );
        $result = $this->query($sql);
        return mysqli_fetch_array($result,$arr[$type]);

    }
    // 公共的获取数据库多条数据的方法

    public function fetchAllDatas($sql,$type=3){
        $arr = array(
            1=>MYSQLI_BOTH,
            2=>MYSQLI_NUM,
            3=>MYSQLI_ASSOC
        );
        $result = $this->query($sql);
        return mysqli_fetch_all($result,$arr[$type]);

    }

    // 公共的获取查询总条数
    public function getAllRows($sql){
        $result = $this->query($sql);
        return mysqli_num_rows($result);
    }

    public function __destruct()
    {
        mysqli_close(self::$link);
    }
    // 定义一个公共的释放结果集的方法
    public function free_result($result){
        mysqli_free_result($result);
    }

}