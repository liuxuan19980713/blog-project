<?php
namespace Frame\vendors;
//定义最终的Pager类
final class Page
{
	//私有的成员属性
	private $records;	//总记录数
	private $pages;		//总页数
	private $pagesize;	//每页显示多少条记录
	private $page;		//当前页码
	private $url;		//链接地址
	private $first;		//首页
	private $last;		//尾页
	private $prev;		//上一页
	private $next;		//下一页

	//构造方法
	public function __construct($records,$pagesize,$page,$params=array())
	{
		$this->records	= $records;
		$this->pagesize	= $pagesize;
		$this->pages	= $this->getPages();
		$this->page		= $page;
		$this->url		= $this->getUrl($params);
		$this->first	= $this->getFirst();
		$this->last		= $this->getLast();
		$this->prev		= $this->getPrev();
		$this->next		= $this->getNext();
	}

	//获取链接地址
	private function getUrl($params=array())
	{
		foreach($params as $key=>$value)
		{
			$arr[] = "$key=$value";
		}
		return "?".implode("&",$arr)."&page=";
	}

	//获取总页数
	private function getPages()
	{
		return ceil($this->records/$this->pagesize);
	}

	//获取首页
	private function getFirst()
	{
		if($this->page==1){
			return "[首页]";
		}else{
			return "[<a href='{$this->url}1'>首页</a>]";
		}
	}

	//获取尾页
	private function getLast()
	{
		if($this->page==$this->pages){
			return "[尾页]";
		}else{
			return "[<a href='{$this->url}{$this->pages}'>尾页</a>]";
		}
	}

	//获取上一页
	private function getPrev()
	{
		if($this->page==1)
		{
			return "[上一页]";
		}else
		{
			return "[<a href='{$this->url}".($this->page-1)."'>上一页</a>]";
		}
	}

	//获取下一页
	private function getNext()
	{
		if($this->page==$this->pages)
		{
			return "[下一页]";
		}else
		{
			return "[<a href='{$this->url}".($this->page+1)."'>下一页</a>]";
		}
	}

	//显示分页
	public function showPage()
	{
		if($this->pages>1)
		{
			$str = "共有{$this->records}条记录，每页显示{$this->pagesize}条记录，";
			$str .= "当前{$this->page}/{$this->pages} ";
			$str .= "{$this->first} {$this->prev} {$this->next} {$this->last}";
			return $str;
		}else
		{
			return "共有{$this->records}条记录";
		}
	}
}