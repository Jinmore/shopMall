<?php
namespace Home\Model;
use Think\Model;
class CartModel extends Model{
  // 加入购物车时，允许接收的字段
  protected $insertFields='goods_id,goods_attr_id,goods_number,member_id';
  protected $_validate=array(
    array('goods_id','require','必须选择商品',1),
    // array('goods_number','chkGoodsNum','库存量不足',1,'callback')
  );
  // 检查库存量
 public function chkGoodsNum(){

 }
 public function add(){
  //  将接收到的商品属性id数组转为字符串
  sort($this->goods_attr_id,SORT_NUMERIC);//做一下升序排序
  $this->goods_attr_id=(string) implode(',',$this->goods_attr_id);
   if(session('m_id'))
   {
     $goodsNumber=$this->goods_number;
    //  先在数据库中查询这件商品是否已经在购物车
    $has=$this->field('id')->where(array(
      'member_id'=>session('m_id'),
      'goods_id'=>$this->goods_id,
      'goods_attr_id'=>$this->goods_attr_id,
    ))->find();
    // 如果已经存在就执行 数量添加就行了
    // setInc 方法 可以执行数量添加
    if($has)
    $this->where(array(
      'id'=>array('eq',$has['id']),
    ))->setInc('goods_number',$goodsNumber);
    // 如果没有，就直接添加
    else
    parent::add(array(
      'member_id'=>session('m_id'),
      'goods_id'=>$this->goods_id,
      'goods_attr_id'=> $this->goods_attr_id,
      'goods_number'=>$this->goods_number
    ));
   }
   else
   {
    //  从cookie中取出购物车的一位数组
    $data=isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();
    // 先拼一个数组下标(商品id 和 商品属性id 拼作为数组下标)
    $key=$this->goods_id.'-'.$this->goods_attr_id;
    // cookie中 判断购物车是否已经存在
    if(isset($data[$key]))
    $data[$key]+=$this->goods_number;
    else
    // 把商品添加进去
    $data[$key]=$this->goods_number;
    // 把一位数组 再存到cookie
    setcookie('cart',serialize($data),time()+3600,'/');
   }
   return true;
 }
 // 当用户登陆之后，将cookie中数据移动到数据库中
 public function  moveDataToDb(){
   $memberId=session('m_id');
   if($memberId)
   {
     //  从cookie中取出购物车的一位数组
     $data=isset($_COOKIE['cart'])?unserialize($_COOKIE['cart']):array();
     foreach($data as $k=>$v)
     {
      //  $k 是由商品id和 商品属性id拼接组成的，在这需要转为数组供下面使用
       $_k=explode('-',$k);
       //  先在数据库中查询这件商品是否已经在购物车
       $has=$this->field('id')->where(array(
         'member_id'=>$memberId,
         'goods_id'=>$_k[0],
         'goods_attr_id'=>$_k[1],
       ))->find();
       // 如果已经存在就执行 数量添加就行了
       // setInc 方法 可以执行数量添加
       if($has)
       $this->where(array(
         'id'=>array('eq',$has['id']),
       ))->setInc('goods_number',$v);
       // 如果没有，就直接添加
       else
       parent::add(array(
         'member_id'=>$memberId,
         'goods_id'=>$_k[0],
         'goods_attr_id'=>$_k[1],
         'goods_number'=>$v
       ));
     }
    //  清空cookie
    setcookie('cart','',time()-1,'/');

   }
 }
 // ----------从购物车中取出商品-------
 public function cartLst()
 {
  //  -----------先取出购物车中商品id
   $memberId=session('m_id');
   if($memberId)
   {
     $data=$this->where(array(
       'member_id'=>array('eq',$memberId),
     ))->select();
   }
   else
   {
      $_data=isset($_COOKIE['cart'])? unserialize($_COOKIE['cart']):array();
      $data=array();
      // 将cookie中的数据 转为 二维数组
      foreach($_data as $k=>$v)
      {

        $_k=explode('-',$k);
        sort($_k[1],SORT_NUMERIC);//做一下升序排序
        $data[]=array(
          'goods_id'=>$_k[0],
          'goods_attr_id'=>$_k[1],
          'goods_number'=>$v
        );
      }
   }
  //  在根据商品id 取出商品详细信息
  $gModel=D('Admin/Goods');
  $attrModel=D('Admin/Goods_attr');
  foreach($data as $k=>&$v)
  {
    // 取出商品 名称和图片
    $info=$gModel->field('goods_name,mid_img')->find($v['goods_id']);
    // 将信息添加到 $data 数组中,$v 需要引用传递
    $v['goods_name']=$info['goods_name'];
    $v['mid_img']=$info['mid_img'];
    // 计算实际的购买价格
    $v['price']=$gModel->getMemberPrice($v['goods_id']);
    // 取出商品属性名称 属性值
    // 先判断是否有属性id
    if($v['goods_attr_id'])
    {
      $v['gadata']=$attrModel->alias('a')
      ->where(array(
        'a.id'=>array('in',$v['goods_attr_id'])
      ))->field('b.attr_name,a.attr_value')
      ->join('left join __ATTRIBUTE__ b on a.attr_id=b.id')
      ->select();
    }


  }
  return $data;
 }
 // 清空购物车
 public function clear()
 {
    $this->where(array(
      'member_id'=>array('eq',session('m_id'))
    ))->delete();
 }




}

 ?>
