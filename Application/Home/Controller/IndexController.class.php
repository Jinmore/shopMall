<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends NavController {
  // ajax获得商品最终购买价格
  public function ajaxGetMemberPrice(){
    $id=I('get.id');
    $gModel=D('Admin/Goods');
    echo $gModel->getMemberPrice($id);
  }
  // 接收ajax请求，处理浏览历史
   public function ajaxGetHistory(){
    $id=I('get.id');
    $data=isset($_COOKIE['displayHistory'])?unserialize($_COOKIE['displayHistory']):array();
    // 把最先浏览历史商品id 放在数组第一位
     array_unshift($data,$id);
    // 将数组元素去重复，有重复浏览商品的id时候 有用
     $data=array_unique($data);
    // 只取得6六件
    if(count($data)>6)
      $data=array_slice($data,0,6);
      // 将数组存到cookie
      // 数组元素要序列化为字符串，才能存入
      setcookie('displayHistory',serialize($data),time()+3600*24);
      // 生成商品模型：取出cookie商品id，返回给ajax，输出到页面浏览记录里
      $gModel=D('Admin/Goods');
      $data=implode(',',$data);//转为字符串，为浏览历史商品排序
      $gData=$gModel->field('id,goods_name,mid_img')->
      order("FIELD (id,$data)")->
      where(array('id'=>array('in',$data),))->select();
      echo json_encode($gData);


   }
    public function index(){
      // '_nav'设置是否显示菜单分类，1为显示
      $this->assign(array(
        '_nav'=>'1',
        '_title_name'=>'欢迎首页',
        '_description_content'=>'综合商城',
        '_key_content'=>'服装,手机',
      ));

      // 取出促销，新品，精品，热销  商品
      $goodModel=D('Admin/Goods');
      $good1=$goodModel->getPromoto();//促销商品
      $good2=$goodModel->get_Is('is_hot');//热销
      $good3=$goodModel->get_Is('is_best');//精品
      $good4=$goodModel->get_Is('is_new');//新品

      // 取出推荐楼层分类，二级分类，楼层商品
      $catModel=D('Admin/Category');
      $catFloorData=$catModel->getCatFloor();

      $this->assign(array(
        'catFloorData'=>$catFloorData,
        'good1'=>$good1,
        'good2'=>$good2,
        'good3'=>$good3,
        'good4'=>$good4,
      ));
      $this->display();
    }

  public function  goods(){

    $id=I('get.id');
    // 取出商品基本信息
    $goodModel=D('Admin/Goods');
    $info=$goodModel->find($id);
    // 实例化分类模型，取出面包屑导航
    $catModel=D('Admin/Category');
    $data=$catModel->getParentPath($info['cat_id']);

    // 取出商品的相册
    $gpicModel=D('Admin/Goods_pic');
    $gpicData=$gpicModel->where(array(
      'goods_id'=>array('eq',$id)
    ))->select();

    // 取出商品属性
    $gattrModel=D('Admin/goods_attr');
    $gattrData=$gattrModel->alias('a')
    ->where(array(
      'goods_id'=>array('eq',$id)))
      ->join('left join __ATTRIBUTE__ b on a.attr_id=b.id ')
      ->field('a.*,b.attr_name,b.attr_type')
      ->select();
      // 循环属性，将 可选属性和 唯一属性 分开来去
      $attr_sel=array();//存放可选属性
      $attr_uni=array();//存放唯一属性
      foreach($gattrData as $k=>$v){
        if($v['attr_type']=='可选'){
          $attr_sel[$v['attr_name']][]=$v;
        }else{
          $attr_uni[$v['attr_name']][]=$v;
        }
      }
      //  取出商品的会员价格
      $gpriModel=D('member_price');
      $gpriData=$gpriModel->alias('a')
      ->field('a.*,b.level_name')
      ->join('left join __MEMBER_LEVEL__ b on a.level_id=b.id')
      ->where(array(
        'goods_id'=>array('eq',$id)
      ))->select();
    $this->assign(array(
      'gpriData'=>$gpriData,
      'gpicData'=>$gpicData,
      'attr_uni'=>$attr_uni,
      'attr_sel'=>$attr_sel,
      'info'=>$info,
      'data'=>$data
    ));
    $this->display();
  }



}
