<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends Controller{
  public function add()
  {
    $memberId=session('m_id');
    if(!$memberId)
    {
      session('returnUrl',U('Order/add'));
      redirect(U('Login/login'));
    }
    $orderModel=D('Admin/Order');
     if(IS_POST)
     {
       if($orderModel->create(I('post.'),1))
       {
         if($order_id=$orderModel->add())
         {
            $this->success('下单成功',U('success_order?order_id='.$order_id));
            exit;
         }
       }
       $this->error($orderModel->getError());
     }
    //    取出购物车商品
    $cartModel=D('Cart');
    $data=$cartModel->cartLst();
    $this->assign(array(
      'data'=>$data,
    ));
     $this->display();
  }
  public function success_order()
  {
    // 接收下单成功传递过来的订单id,通过函数生成一个支付按钮
     $btn=makeAlipayBtn(I('get.order_id'));
     $this->assign('btn',$btn);
    //  $this->assign(array(
    //    'btn'=>$btn,
    //    '_title_name'=>'下单成功',
    //  ));
     $this->display();
  }
  // 接收支付宝发来的支付成功的消息
  public function receive()
  {
       require ("./alipay/notify_url.php");
  }



}




 ?>
