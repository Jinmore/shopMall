<?php
namespace Home\Controller;
use Think\Controller;
class NavController extends Controller{
  public function __construct(){
    parent::__construct();
    // 显示首页商品三层分类
    $catModel=D('Admin/Category');
    $catData=$catModel->getNav();
    $this->assign('catData',$catData);

  }



}


 ?>
