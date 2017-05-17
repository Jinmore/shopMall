<?php
namespace Admin\Model;
use Think\Model;
class CategoryModel extends Model{
// 查询商品所有分类
public function search(){
   $data=$this->select();
   return $this->tree($data);
}
// 列出商品分类树形结构
private function tree($data,$pid=0,$level=0){
  $res=array();
  foreach($data as $v){
    if($v['parent_id']==$pid){
      // 添加一个字段表示级别
      $v['level']=$level;
      $res[]=$v;
      $res=array_merge($res,$this->tree($data,$v['id'],$level+1));
    }
  }
  return $res;
}
// 获得当前分类下的所有子分类，包括当前分类
public function getChilds($cat_id){
  $data=$this->select();
  // 调用递归方法，获得当前分类下所有子分类
  $data=$this->tree($data,$cat_id);
  $res=array();
  foreach($data as $v){
    // 将子分类的id存入数组
    $res[]=$v['id'];
  }
  $res[]=$cat_id;//将当前分类id也存入数组
  return $res;
}

public function _before_delete(&$option){
  // 获得要删除分类的所有子分类id
   $children=$this->getChilds($option['where']['id']);
  //  修改原来options，将子分类的id 也加入 option中，这样子分类会一并删除
   $option['where']['id']=array(
     0=>'IN',
     1=>implode(",",$children)
   );
}

// -------------------前台方法----------------
//  取出主菜单分类
public function getNav()
{
  // 读取缓存
  $arrNav=S('arrNav');
  if($arrNav)
  return $arrNav;
   else
    {
      // 获得前台商品分类
       $navData=$this->select();
        $arrNav=array();
        foreach($navData as $k=>$v)
        {

          if($v['parent_id']==0)
          {

            foreach($navData as $k1=>$v1)
            {

              if($v1['parent_id']==$v['id'])
              {

                 foreach($navData as $k2=> $v2)
                 {

                   if($v2['parent_id']==$v1['id'])
                   {

                     $v1['children'][]=$v2;
                   }
                 }
                $v['children'][]=$v1;
              }
            }
            $arrNav[]=$v;
          }
        }
        // 设置缓存，时间为12小时
        S('arrNav',$arrNav,10);
        return $arrNav;
     }
  }
  // 取出推荐楼层分类
 public function getCatFloor()
 {

   $catFloor=$this->where(array(
     'is_floor'=>array('eq','是'),
     'parent_id'=>array('eq','0')
   ))->select();
   $goodModel=D('Admin/Goods');

  foreach($catFloor as $k=>&$v)
  {
    // --------------取出这个楼层中品牌的数据-------------
      // 先取出这个楼层下所有的商品ID
      $goodsId = $goodModel->getGoodsIdByCatId($v['id']);
      // 再取出这些商品所用到的品牌
      $v['brand'] = $goodModel->alias('a')
      ->join('LEFT JOIN __BRAND__ b ON a.brand_id=b.id')
      ->field('DISTINCT brand_id,b.brand_name,b.logo')
      ->where(array(
        'a.id' => array('in', $goodsId),
        'a.brand_id' => array('neq', 0),
      ))->limit(9)->select();

    // -------------取出未被推荐到楼层的二级分类-------------
    $catsub=$this->where(array(
      'is_floor'=>array('eq','否'),
      'parent_id'=>array('eq',$v['id']),
    ))->select();
    $v['sub']=$catsub;
    // ---------------取出被推荐到楼层的二级分类----------------
    $recsub=$this->where(array(
      'is_floor'=>array('eq','是'),
      'parent_id'=>array('eq',$v['id']),
    ))->select();
    $v['recsub']=$recsub;
    // --------------取出被推荐到楼层的二级分类下的8件商品----------
    foreach($v['recsub'] as $k1 =>&$v1)
    {
      $goodids=$goodModel->getGoodsIdByCatId($v1['id']);
      $goodids[]=0;
      $recGoods=$goodModel->where(array(
        'id'=> array('in',$goodids),
        'is_on_sale'=>array('eq','是'),
        'is_floor'=>array('eq','是')
      ))->select();
       $v1['recGoods']=$recGoods;

    }

  }

   return $catFloor;

 }
 //-------------- 商品面包屑路径----------
 public function getParentPath($catId)
 {
       $info=$this->field('id,cat_name,parent_id')->find($catId);
        static $arr=array();
       $arr[]=$info;

      if($info['parent_id'] > 0)
      {
        $this->getParentPath($info['parent_id']);
      }
      return $arr;
    }

}



 ?>
