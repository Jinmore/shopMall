<?php
namespace Home\Controller;
use Think\Controller;
class CartController extends Controller{
  public function ajaxCartLst()
  {
    $cartModel=D('Cart');
    $data=$cartModel->cartLst();
    echo json_encode($data);
  }
  public function add()
  {
    $cartModel=D('Cart');
    if(IS_POST)
    {
      if($cartModel->create(I('post.'),1))
      {
         if($cartModel->add())
         {
           $this->success("添加陈工",U('lst'));
           exit;
         }
      }
      $this->error($cartModel->getError());

    }
  }
  public function lst(){
    $cartModel=D('Cart');
    $data=$cartModel->cartLst();
    // echo "<pre>";
    // var_dump($data);die;
    // echo "</pre>";
    // var_dump($_COOKIE);die;
    $this->assign('data',$data);
    $this->display();
  }





}


 ?>
