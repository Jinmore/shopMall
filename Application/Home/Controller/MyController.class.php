<?php
namespace Home\Controller;
use Think\Controller;
// -----个人中心控制器----------
class MyController extends NavController
{
  public function __construct()
  {
    parent::__construct();
   $memberId=session('m_id');
   if(!$memberId)
   {
     session('returnUrl',U('My/'.ACTION_NAME));
     redirect(U('Login/login'));
   }
  }
  public function order()
  {
     $this->display();
  }


}

 ?>
