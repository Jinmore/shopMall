<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller{
  public function __construct(){
    // 必须下调用父类的构造函数
    parent::__construct();
    // 判断是否存在登陆
    if(!session('id')){
      $this->error("请先登陆",U('Login/login'));
    }
    if(CONTROLLER_NAME =='Index')
    return true;
    $priModel=D('Privilege');
    if(!$priModel->chkPri())
    $this->error('无权访问');
  }

}


 ?>
