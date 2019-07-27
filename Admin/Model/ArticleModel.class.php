<?php

namespace Admin\Model;

use Frame\libs\BaseModel;

class ArticleModel extends BaseModel
{
    protected $table = "category";
    protected $table1 = "article";
    public function categoryLists()
    {
        return $this->fetchAll();
    }
    # 获取无限极分类shuju
    public function getCategoryData($arr)
    {
        return $this->categoryList($arr);
    }
    # 获取连表查询的数据
    public function  fetchAllWithJoin($start,$end,$where,$flag=true)
    {
        # 构建sql语句，返回查询结果数据
            $sql = "select article.*,category.classname,user.username from {$this->table1} left join category on article.category_id=category.id left join
                user on article.user_id=user.id  where  {$where}  
                order by article.orderby asc,article.id desc limit {$start},{$end}";
        if($flag){
            return $this->pdoWrapper->fetchAll($sql);
        }else{
            return $this->pdoWrapper->rowTotal($sql);
        }
       
    }
    
}
