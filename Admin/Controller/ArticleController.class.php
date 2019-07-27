<?php  
namespace Admin\Controller;
use Frame\libs\BaseController;
use Admin\Model\ArticleModel;
use Frame\vendors\Page;
class ArticleController extends BaseController{
    public function index(){
        # 页面需要无限极分类的数据和连表查询的数据
        $categoryList = ArticleModel::createObj()->categoryLists();
        # 获取无限极分类的数据
        $categoryLists = ArticleModel::createObj()->categoryList($categoryList);
        
        # 获取搜索的关键字个类别
        $where = "3>2 ";
        if(!empty($_REQUEST['category_id'])) $where.="and category_id={$_REQUEST['category_id']}";

        if(!empty($_REQUEST['keyword'])){
            $where.=" and title like '%".$_REQUEST['keyword']."%'";
        }
       
        $page = isset($_GET['page'])?$_GET['page']:1;
        $pageSize = 3;
        $start = ($page-1)*$pageSize;
        $records = ArticleModel::createObj()->fetchAllWithJoin($start,$pageSize,$where,false);
        echo $records;
        if(!empty($_POST['category_id']))$parmas['category_id']= $_REQUEST['category_id'];
        if(!empty($_REQUEST['keyword'])){
            $parmas['keyword']= $_REQUEST['keyword'];
        }
        $parmas = array(
            'c'=>'Article',
            'a'=>'index'
        );
        $pageObj = new Page($records,$pageSize,$page,$parmas);
        $pageStr = $pageObj->showPage();
        # limit 用的数据
        
         
        # 获取连表分类的数据
        $articleDatas = ArticleModel::createObj()->fetchAllWithJoin($start,$pageSize,$where);
        
        $this->smartyObj->assign(
            array(
                'categoryLists'=>$categoryLists,
                'articleDatas'=>$articleDatas,
                'pageStr' =>$pageStr,
            )
        );

        $this->smartyObj->display('./Article/index.html');
    }
    public function add(){
         # 页面需要无限极分类的数据和连表查询的数据
         $categoryList = ArticleModel::createObj()->categoryLists();
         # 获取无限极分类的数据
         $categoryLists = ArticleModel::createObj()->categoryList($categoryList);
         $this->smartyObj->assign('categoryLists',$categoryLists);
         $this->smartyObj->display('./Article/add.html'); 
    }
    public function insert(){
        # 获取表单提交过来的数据
            $category_id = $_POST['category_id'];
            $title = $_POST['title'];
            $top = isset($_POST['top'])?1:0;
            $orderby = $_POST['orderby'];
            $content = $_POST['content'];
            $user_id = $_SESSION['id'];
            $addate  = time();
        # 构建sql语句
        $sql = "insert into article(category_id,user_id,title,content,orderby,top,addate)values({$category_id},'{$user_id}','{$title}','{$content}',{$orderby},{$top},{$addate})";
      
        $result = ArticleModel::createObj()->insert_delete_update($sql);
        if($result){
            $this->resultHandle('添加文章成功', 3, '?c=Article&a=index');
        }else{
            $this->resultHandle('添加文章失败', 3, '?c=Article&a=add');
        }
    }
}