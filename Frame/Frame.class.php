<?php
namespace Frame;
final class Frame
{
    public static function run()
    {
        self::initConfig();
        self::initPlatfom();
        self::initConst();
        self::initAutoload();
        self::initController();
    }
    private static function initConfig()
    {
        $GLOBALS['config'] = require_once(HOME_PATH . DS . "Config" . DS . "Config.php");
    }
    private static function initConst()
    {
        define('VIEW_PATH', HOME_PATH . DS . 'View' . DS);
        define('CONFIG_PATH', HOME_PATH  . 'Config' . DS);
    }
    private static function initPlatfom()
    {
        $p = isset($_GET['p']) ? $_GET['p'] : $GLOBALS['config']['DEFAULT_PLATFOM'];
        $c = isset($_GET['c']) ? $_GET['c'] : $GLOBALS['config']['DEFAULT_CONTROLLER'];
        $a = isset($_GET['a']) ? $_GET['a'] : $GLOBALS['config']['DEFAULT_ACTION'];
        define('PLATFOM', $p);
        define('CONTROLLER', $c);
        define('ACTION', $a);
    }
    private static function initAutoload()
    {
        spl_autoload_register(function ($className) {
            //通过命名空间来构建路径
            $fileName = ROOT_PATH."$className".".class.php";      
            $fileName = str_replace("\\",DS,$fileName);         
            if(file_exists($fileName)) require_once($fileName);
        });
    }
    private static function initController()
    {     
        $controlName = PLATFOM . "\Controller" . "\\" . CONTROLLER."Controller";
        $ControlObj = new $controlName();
        $A = ACTION;
        // 这里不能写死，这里就是路由的分发
        $ControlObj->$A();
    }
}
