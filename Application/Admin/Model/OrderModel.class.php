<?php
namespace Admin\Model;
use Think\Model;
class OrderModel extends Model
{
  // 下单时允许接收的表单字段
  protected $insertFields='shr_name,shr_address,shr_tel,shr_city,shr_province,shr_area';
  // 下单验证规则
  protected $_validate=array(
    array('shr_name','require','用户姓名不能为空',1,'regex',3),
    array('shr_address','require','用户姓名不能为空',1,'regex',3),
    array('shr_tel','require','用户姓名不能为空',1,'regex',3),
    array('shr_city','require','用户姓名不能为空',1,'regex',3),
    array('shr_province','require','用户姓名不能为空',1,'regex',3),
    array('shr_area','require','用户姓名不能为空',1,'regex',3),
  );
  public function _before_insert(&$data,&$option)
  {
    $memberId=session('m_id');
    // 先判断是否登陆
    if(!$memberId)
    {
      $this->error="请先登陆";
      return false;
    }
    // 判断购物车中是否有商品
    $cartModel=D('Cart');
    $option['goods']=$goods=$cartModel->cartLst();
    if(!$goods)
    {
      $this->error="购物车中没有商品，请先添加商品";
      return false;
    }
    // 建立锁,把锁赋给模型属性，可以一直保存到下单结束
    $this->fp=fopen('./order.lock');
    flock($this->fp,LOCK_EX);
    // 生成库存量模型，检查库存量
    $gnModel=D('goods_number');
    // 获得购物车中商品总价
    $total_price=0;
    foreach($goods as $k=>$v)
    {
      $gnNumber=$gnModel->where(array(
        'goods_id'=>$v['goods_id'],
        'goods_attr_id'=>$v['goods_attr_id'],
      ))->find();
      // if($gnNumber['goods_number']< $v['goods_number'])
      // {
      //   $this->error='下单失败，原因:<strong>'.$v['goods_name'].'库存量不足';
      //   return false;
      // }
      $total_price+=$v['price']*$v['goods_number'];
    }
    // 补全其他信息
    $data['addtime']=time();
    $data['member_id']=$memberId;
    $data['total_price']=$total_price;
    // 为了确保 三个表的操作成功，开启事务
    $this->startTrans();
  }
  // 订单基本信息生成之后，$data['id'] 即为订单id
  public function _after_insert($data,$option)
  {
     $gcModel=D('order_goods');
      foreach($option['goods'] as $k=>$v)
      {
        $ret= $gcModel->add(array(
           'order_id'=>$data['id'],
           'goods_id'=>$v['goods_id'],
           'goods_attr_id'=>$v['goods_attr_id'],
           'goods_number'=>$v['goods_number'],
           'price'=>$v['price'],
         ));
      }
      if(!$ret)
      {
        $this->rollback();//事务回滚
      }
      // 下单成功，减库存
      // $gnModel=D('goods_number');
      // $gnModel->where(array(
      //   'goods_id'=>$v['goods_id'],
      //   'goods_attr_id'=>$v['goods_attr_id'],
      // ))->setDec('goods_number',$v['goods_number']);

      //提交事务
      $this->commit();
    //释放锁
    flock($this->fp,UN);
    fclose($this->fp);
    //  清空购物车
    $carModel=D('Cart');
    $carModel->clear();

  }
  public function  setPaid($orderId)
  {
    // ---------更新订单的支付状态------
    $this->where(array(
      'id'=>array('eq',$orderId)
    ))->save(array(
      'pay_time'=>time(),
      'pay_status'=>'是',
    ));
    // -----更新会员积分------
    $mem=$this->field('member_id,total_price')->find($orderId);
    $memModel=D('member');
    // 如果用D 函数生成模型，那么在修改字段时会调用这个模型的 _before_insert,
    // 但是这个功能不需要调用，所以可以用M 直接生成父类模型，就不调用钩子函数了
    $memModel->where(array(
      'id'=>array('eq',$mem['member_id'])
    ))->setInc('jifen',$mem['total_price']);
  }




}




 ?>
