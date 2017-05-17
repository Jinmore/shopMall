<?php
namespace Admin\Controller;
use Think\Controller;
/**
 *
 */
class GoodsController extends BaseController
{
  // 库存量方法
  public function goods_num(){
    $id=I('get.id');
    //根据商品id取出这件商品所有可选属性
    $attrModel=D('goods_attr');
    $attrData=$attrModel->alias('a')->
    join('left join __ATTRIBUTE__ b on a.attr_id=b.id')->
    where(array(
      'a.goods_id'=>array('eq',$id),
      'b.attr_type'=>array('eq','可选'),
    ))
    ->select();
    $_arr=array();
    foreach($attrData as $k=>$v){
      // 以属性名称作为下标，这样相同的属性就在一起了
      $_arr[$v['attr_name']][]=$v;
    }
    $this->assign(array(
      '_arr'=>$_arr,
      '_page_title' => '库存量',
			'_page_btn_name' => '商品列表',
			'_page_btn_link' => U('list'),
    ));
    $this->display();
  }
  // 接收ajax请求，删除商品属性
  public function ajaxDelAttr(){
    $goods_id=I('get.goods_id');
    $gaiID=I('get.gaiID');
    $attrModel=D('goods_attr');
    $attrModel->delete($gaiID);
    // 删除商品属性的同时也将删除属性对应的库存量
    // $numModel=D('goods_number');
    // $numModel->where(array(
    //   'goods_id'=>array('EXP',"=$goods_id and FIND_IN_SET($gaiID,goods_attr_id)"),
    // ))->delete();
  }
  // 处理ajax获取属性数据
  public function ajaxGetAttr()
  {
    $typeId=I('get.type_id');
    $attrModel=D('attribute');
    $data=$attrModel->where(array(
      'type_id'=>array('eq',$typeId)
    ))->select();
    echo json_encode($data);
  }
  // 处理ajax删除图片的请求
  public function ajaxDelPic(){
    $picid=I('get.picid');
    // 根据id从硬盘删除选中图片
    $gpModel=D('goods_pic');
    $pic=$gpModel->field('pic,sm_pic,mid_pic,big_pic')
                ->find($picid);
    // 从硬盘删除图拍
    deleteImage($pic);
    // 删除数据记录
    $gpModel->delete($picid);
  }
  public function add()
  {
    if (IS_POST) {
      // var_dump($_POST);die;
      $model=D('goods');
      $data=$model->create(I('post.'),1);
      if($data){
        if($model->add()){
          $this->success("添加成功",U('list'));
          exit;
        }
      }

      $error=$model->getError();
      $this->error($error);

    }
    // 实例化会员级别类
    $memModel=D('member_level');
    // 查询处所有会员级别
    $memData=$memModel->select();
    // 实例化分类模型
    $catModel=D('category');
    $catData=$catModel->search();
    // 设置页面中的信息，分配变量
		$this->assign(array(
      'catData'=>$catData,
      'memData'=>$memData,
			'_page_title' => '添加商品',
			'_page_btn_name' => '商品列表',
			'_page_btn_link' => U('list'),
		));
    $this->display();


  }
  public function list()
  {
    $data=D('goods')->search();

    $this->assign(array('show'=>$data['show'],'data'=>$data['data']));
    // 实例化分类模型
    $catModel=D('category');
    $catData=$catModel->search();
    $this->assign(array(
      'catData'=>$catData,
			'_page_title' => '商品列表',
			'_page_btn_name' => '添加商品',
			'_page_btn_link' => U('add'),
		));
    $this->display();
  }
  public function edit(){
    $id=I('get.id');
    $model=D('goods');
    if(IS_POST){
    //  var_dump($_POST);die;

      $data=$model->create(I('post.'),2);
      if($data){
        $result=$model->save($data);
        if($result !== false){
         $this->success("修改成功",U('list'));
         exit;
        }

      }
      $error=$model->getError();
      $this->error($error);

    }else{
      //  取出商品的扩展分类
      $good_catModel=D('goods_cat');
      $good_catData=$good_catModel->where(array(
        'goods_id'=>array('eq',$id)
      ))->select();

      $data=$model->find($id);
      $this->assign('data',$data);
      // 实例化商品分类
      $catModel=D('category');
      $catData=$catModel->search();
      // 实例化会员级别类
      $memModel=D('member_level');
      // 查询处所有会员级别
      $memData=$memModel->select();
      // 实例商品会员价格类
      $mpModel=D('member_price');
      $mpdata=$mpModel->where(array(
        'goods_id'=>array('eq',$id)
      ))->select();
      // $mpdata 为二维数组，为了方便把价格放到表单中，将二维数组转一纬数组
       $mp=array();
       foreach ($mpdata as $k => $v) {
         $mp[$v['level_id']]=$v['price'];
       }
      //取出商品属性
      $attrModel=D('Attribute');
      $attrData=$attrModel->alias('a')->
      field('a.id attr_id,a.attr_name,a.attr_type,a.attr_option_values,b.attr_value,b.id')
      ->join('left join __GOODS_ATTR__ as b on (a.id=b.attr_id and b.goods_id='.$id.')')
      ->where(array(
        'a.type_id'=>array('eq',$data['type_id'])
      ))
      ->select();
      // $attrData=$attrModel->field('a.*,b.attr_name,b.attr_type,b.attr_option_values')->alias('a')->
      // join('left join __ATTRIBUTE__ as b on a.attr_id=b.id')->
      // where(array(
      //   'goods_id'=>array('eq',$id)
      // ))->select();
      //取出商品 相册中现有的图片
      $gpModel=D('goods_pic');
      $gpData=$gpModel->field('id,mid_pic')
      ->where(array('goods_id'=>array('eq',$id)))
      ->select();
      $this->assign('gpData',$gpData);
      // 设置页面中的信息
  		$this->assign(array(
        'attrData'=>$attrData,
        'good_catData'=>$good_catData,
        'catData'=>$catData,
        'mp'=>$mp,
        'memData'=>$memData,
  			'_page_title' => '编辑商品',
  			'_page_btn_name' => '商品列表',
  			'_page_btn_link' => U('list'),
  		));
      $this->display();
    }

  }
  public function delete(){
    $id=I('get.id');
    $model=D('goods');
    $result=$model->delete($id);
    if($result){
      $this->success("删除成功",U('list'));
    }else{
      $this->error("删除失败".$model->getError());
    }
  }

}




 ?>
