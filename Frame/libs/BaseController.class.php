<?php  
namespace Frame\Libs;
use Frame\Vendors\Smarty;
class BaseController{
    protected $smartyObj;
    public function __construct()
    {
        $smarty = new Smarty();
        // 设置左右边界符号 
        $smarty->left_delimiter = "{<";
        $smarty->right_delimiter = ">}";
  
        // 设置引入视图文件的文件路径
        $smarty->setTemplateDir(VIEW_PATH);
        // 设置template_c的文件路径
        $smarty->setCompileDir(sys_get_temp_dir());
        
        $this->smartyObj = $smarty;  
    }
}