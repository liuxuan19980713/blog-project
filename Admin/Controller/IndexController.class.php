<?php

namespace Admin\Controller;

use Frame\libs\BaseController;

class IndexController extends BaseController
{
  public  function index()
  {
    $this->isLogin();
    $this->smartyObj->display('./Index/index.html');
  }
  public function top()
  {
    $this->isLogin();
    $this->smartyObj->display('./Index/top.html');
  }
  public function main()
  {
    $this->isLogin();
    $this->smartyObj->display('./Index/main.html');
  }
  public function left()
  {
    $this->isLogin();
    $this->smartyObj->display('./Index/left.html');
  }
  public function center()
  {
    $this->isLogin();
    $this->smartyObj->display('./Index/center.html');
  }
}
