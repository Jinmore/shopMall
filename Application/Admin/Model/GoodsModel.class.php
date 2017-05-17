<?php
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model{
  // 添加时 调用create方法允许接收的字段
  protected $insertFields='goods_name,market_price,shop_price,is_on_sale,goods_desc,
  brand_id,cat_id,type_id,is_hot,is_best,is_new,promote_price,promote_start_date,promote_end_date,sort_num,is_floor';
  protected $updateFields='id,goods_name,market_price,shop_price,is_on_sale,goods_desc,
  brand_id,cat_id,type_id,is_hot,is_best,is_new,promote_price,promote_start_date,promote_end_date,sort_num,is_floor';
  // 添加表单自动验证
  protected $_validate=array(
        array('cat_id','require','商品分类必须选择',1),
        array('goods_name','require','商品名称不能为空',1),
        array('market_price','currency','市场价格必须是货币',1),
        array('shop_price','currency','商品价格必须是货币',1)
     );
  protected function _before_insert(&$data,$options)
  {
    // 添加时间字段信息
    $data['addtime']=date('Y-m-d H:i:s',time());
    // 通过自定义函数，过滤在线编辑器特殊标签
    $data['goods_desc']=removeXSS($data['goods_desc']);
    if($_FILES['img']['error']==0){
      //  判断是否有文件上传
        $ret=uploadOne('img','goods',array(
          array(750,750),
          array(350,350),
          array(130,130),
          array(50,50)
        ));

        // 保存到数据库
        $data['img']=$ret['images'][0];
        $data['sm_img']=$ret['images'][4];
        $data['mid_img']=$ret['images'][3];
        $data['big_img']=$ret['images'][2];
        $data['mbig_img']=$ret['images'][1];


    }

  }
  // 在完成商品插入之后，获得会员价格
  protected function _after_insert($data,$option){
    // ---------处理商品属性-------------
    $attrValue=I('post.attr_value');
    $attrModel=D('goods_attr');
    if($attrValue){
       foreach($attrValue as $k=>$v){
        //  把属性值去重复，防止用户提交重复属性
        $v=array_unique($v);
         foreach($v as $k1 => $v1 ){
           $attrModel->add(array(
             'goods_id'=>$data['id'],
             'attr_value'=>$v1,
             'attr_id'=>$k
           ));
         }
       }
    }
    // ---------处理商品扩展分类----------
    // 获得提交过来的扩展id
      $ext_cat_id=I('post.ext_cat_id');
      if($ext_cat_id){
        $catModel=D('goods_cat');
        foreach($ext_cat_id as $v){
          if(empty($v))//判断一下是否为空
          continue;
          // 添加到扩展分类表中
          $catModel->add(
            array(
              'cat_id'=>$v,
              'goods_id'=>$data['id']
            )
          );
        }
      }
     //----------处理商品相册图片-------
     if(isset($_FILES['pic']))
    {
      $pics = array();
      foreach ($_FILES['pic']['name'] as $k => $v)
      {
        $pics[] = array(
          'name' => $v,
          'type' => $_FILES['pic']['type'][$k],
          'tmp_name' => $_FILES['pic']['tmp_name'][$k],
          'error' => $_FILES['pic']['error'][$k],
          'size' => $_FILES['pic']['size'][$k],
        );
      }
      $_FILES = $pics;  // 把处理好的数组赋给$_FILES，因为uploadOne函数是到$_FILES中找图片
      $gpModel = D('goods_pic');
      // 循环每个上传

      foreach ($pics as $k => $v)
      {
        if($v['error'] == 0)
        {
          $ret = uploadOne($k, 'goods', array(
            array(650, 650),
            array(350, 350),
            array(50, 50),
          ));
          if($ret['ok'] == 1)
          {
            $gpModel->add(array(
              'pic' => $ret['images'][0],
              'big_pic' => $ret['images'][1],
              'mid_pic' => $ret['images'][2],
              'sm_pic' => $ret['images'][3],
              'goods_id' => $data['id'],
            ));
          }
        }
      }
    }

    // 接收add表单提交过来的会员价格
    $mem_price=I('post.member_price');
    // -------------处理会员价格-----------
    $priceModel=D('member_price');
    foreach ($mem_price as $key => $value) {
      // 将提交过来的会员价格转型，如果是非数字，会转为0
      $v=(float)$value;
      if($v >0){
        $priceModel->add(array(
          'price' =>$v,
          'level_id'=>$key,//会员价格数组的键 即为 会员级别ID
          'goods_id'=>$data['id']
        ));
      }

    }
  }
  // --------------此方法为根据商品分类及扩展分类搜索商品id-----------
  public function getGoodsIdByCatId($cat_id){
    // 先取出所有子分类的ID
    $catModel = D('Admin/Category');
    $children = $catModel->getChilds($cat_id);
    /*************** 取出主分类或者扩展分类在这些分类中的商品 ****************/
    // 取出主分类下的商品ID
    $gids = $this->field('id')->where(array(
      'cat_id' => array('in', $children),
    ))->select();
    // 取出扩展分类下的商品的ID
    $gcModel = D('goods_cat');
    $gids1 = $gcModel->field('DISTINCT goods_id id')->where(array(
      'cat_id' => array('IN', $children)
    ))->select();
    // 把主分类的ID和扩展分类下的商品ID合并成一个二维数组【两个都不为空时合并，否则取出不为空的数组】
    if($gids && $gids1)
      $gids = array_merge($gids, $gids1);
    elseif ($gids1)
      $gids = $gids1;
    // 二维转一维并去重
    $id = array();
    foreach ($gids as $k => $v)
    {
      if(!in_array($v['id'], $id))
        $id[] = $v['id'];
    }
    return $id;

  }
  public function search(){
    // ------------------完成搜索功能--------------
    $where=array();//添加where空条件
    // 根据商品品牌id搜索
    $b_id=I('get.b_id');
    if($b_id){
     $where['a.brand_id']=array('eq',"$b_id");
    }
    // 商品名称 搜索
    $g_name=I('get.g_name');
    if($g_name){
      $where['a.goods_name']=array('like',"%$g_name%");
    }
    // 商品价格区间搜索
     $g_price1=I('get.g_price1');
     $g_price2=I('get.g_price2');
    if($g_price1 && $g_price2)
     $where['shop_price']=array('between',"$g_price1,$g_price2");
     elseif($g_price1)
     $where['shop_price']=array('egt',"$g_price1");//价格 >= $pirce1
     elseif($g_price2)
     $where['shop_price']=array('elt',"$g_price2");//价格 <= $pirce2
    //  是否上架
      $is_on=I('get.is_on');
      if($is_on)
     $where['is_on_sale']=array('eq',$is_on);
      // 按添加时间搜索
     $add_t1=I('get.add_t1');
     $add_t2=I('get.add_t2');
    if($add_t1 && $add_t2)
     $where['addtime']=array('between',"$add_t1,$add_t2");
     elseif($add_t1)
     $where['addtime']=array('egt',"$add_t1");//
     elseif($add_t2)
     $where['addtime']=array('elt',"$add_t2");//

     // 根据商品主分类搜索

     $catId = I('get.cat_id');
    if($catId)
    {
      // 先查询出这个分类ID下所有的商品ID
      $gids = $this->getGoodsIdByCatId($catId);
      // 应用到取数据的WHERE上
      if(count($gids)>=1){
        $where['a.id'] = array('in', $gids);
      }else{
        $where['a.id']=array('eq',$gids[0]);
      }
    }

     // --------------设置分页效果显示数据---------------------
    $count=$this->alias('a')->where($where)->count();
    $Page= new \Think\Page($count,6);// 实例化分页类 传入总记录数和每页显示的记录数(25)
    // 输出分页
    $Page->setConfig('prev','上一页');
    $Page->setConfig('next','下一页');
    $show=$Page->show();

    // ------------------设置排序功能-------------------
    $order_by='a.id';//设置默认排序规则 按id
    $order_way='desc';//设置默认按照id降序排列
    $ord=I('get.orderby');
    if($ord){//如果有排序数据过来
      if($ord=="id_asc"){//按照id排序
        $order_way='asc';
      }elseif($ord=='pri_asc'){//按照价格生序排序
        $order_by='shop_price';
        $order_way='asc';
      }
       elseif($ord=='pri_desc'){//按照价格降序排序
         $order_by='shop_price';
         $order_way='desc';
       }

    }



    $data=$this->order("$order_by $order_way")->
    alias('a')->
    field('a.*,b.brand_name,c.cat_name,GROUP_CONCAT(e.cat_name SEPARATOR "<br/>") as ext_cat_name')->
    join('left join __BRAND__ as b on a.brand_id=b.id
          left join __CATEGORY__ as c on a.cat_id=c.id
          left join __GOODS_CAT__ as d on a.id=d.goods_id
          left join __CATEGORY__ as e on d.cat_id=e.id')
    ->where($where)   //搜索字段
    ->limit($Page->firstRow.','.$Page->listRows) //分页功能
    ->group('a.id')
    ->select();
    return array('data'=>$data,'show'=>$show);


  }
  protected function _before_update(&$data,$options){

    $id=I('post.id');
    // ----------处理商品属性-----------
    $attrValue=I('post.attr_value');
    // 接收属性值
    $goods_attr_id=I('post.goods_attr_id');
    // 接收属性id，在隐藏域中
    $attrModel=D('goods_attr');
    $_i=0;
    foreach ($attrValue as $k => $v) {
      foreach($v as $k1=>$v1){
        // 第二中做法 直接执行 replace into sql语句
        //  $attrModel->execute('replace into p39_goods_attr values("'.$goods_attr_id[$_i].'","'.$id.'","'.$v1.'","'.$k.'")');
        if($goods_attr_id[$_i]==""){
          $attrModel->add(array(
            'goods_id'=>$id,
            'attr_value'=>$v1,
            'attr_id'=>$k
          )
          );
        }else{
          $attrModel->where(array(
            'id'=>array('eq',$goods_attr_id[$_i]),
          ))->setField('attr_value',$v1);

        }
        $_i++;
      }
    }

    // ---------处理商品扩展分类----------
    // 获得提交过来的扩展id
      $ext_cat_id=I('post.ext_cat_id');
      // 先删除原先的扩展分类
      $good_catModel=D('goods_cat');
      $good_catModel->where(array(
         'goods_id'=>array('eq',$id)
      ))->delete();
      if($ext_cat_id){
        foreach($ext_cat_id as $v){
          if(empty($v))//判断一下是否为空
          continue;
          // 添加到扩展分类表中
          $good_catModel->add(
            array(
              'cat_id'=>$v,
              'goods_id'=>$id
            )
          );
        }
      }

    // ------------处理相册图片-----------
    if(isset($_FILES['pic']))
   {
     $pics = array();
     foreach ($_FILES['pic']['name'] as $k => $v)
     {
       $pics[] = array(
         'name' => $v,
         'type' => $_FILES['pic']['type'][$k],
         'tmp_name' => $_FILES['pic']['tmp_name'][$k],
         'error' => $_FILES['pic']['error'][$k],
         'size' => $_FILES['pic']['size'][$k],
       );
     }
     $_FILES = $pics;  // 把处理好的数组赋给$_FILES，因为uploadOne函数是到$_FILES中找图片
     $gpModel = D('goods_pic');
     // 循环每个上传
     foreach ($pics as $k => $v)
     {
       if($v['error'] == 0)
       {
         $ret = uploadOne($k, 'goods', array(
           array(650, 650),
           array(350, 350),
           array(50, 50),
         ));
         if($ret['ok'] == 1)
         {
           $gpModel->add(array(
             'pic' => $ret['images'][0],
             'big_pic' => $ret['images'][1],
             'mid_pic' => $ret['images'][2],
             'sm_pic' => $ret['images'][3],
             'goods_id' => $id,
           ));
         }
       }
     }
   }
    // -------------处理会员价格----------
    // 接收add表单提交过来的会员价格
    $mem_price=I('post.member_price');
    // 实例化会员价格表
    $priceModel=D('member_price');
    // 先删除原来的会员价格
    $priceModel->where(array(
      'goods_id'=>array('eq',$id)
    ))->delete();
    // 遍历会员价格
    foreach ($mem_price as $key => $value) {
      // 将提交过来的会员价格转型，如果是非数字，会转为0
      $v=(float)$value;
      if($v >0){
        $priceModel->add(array(
          'price' =>$v,
          'level_id'=>$key,//会员价格数组的键 即为 会员级别ID
          'goods_id'=>$id
        ));
      }

    }
    // ---------------处理图片------------
    if($_FILES['img']['error']==0){
      //  判断是否有文件上传
      $oldlogo=$this->field('img,sm_img,mid_img,big_img,mbig_img')->find($id);
        // 把图片从硬盘上删除
      deleteImage($oldlogo);
      $ret=uploadOne('img','goods',array(
        array(750,750),
        array(350,350),
        array(130,130),
        array(50,50)
      ));

      // 保存到数据库
      $data['img']=$ret['images'][0];
      $data['sm_img']=$ret['images'][4];
      $data['mid_img']=$ret['images'][3];
      $data['big_img']=$ret['images'][2];
      $data['mbig_img']=$ret['images'][1];

      }
      $data['goods_desc']=removeXSS($data['goods_desc']);


  }
  // 编写删除钩子函数
  protected function _before_delete($option){
    // 获得要被删除商品的id，$option 含 商品id
    $id=$option['where']['id'];
    // ----------删除商品属性-------------
    $attrModel=D('goods_attr');
    $attrModel->where(array(
      'goods_id'=>array('eq',$id)
    ))->delete();
    // ------------处理商品扩展分类-----------
    $good_catModel=D('goods_cat');
    $good_catModel->where(array(
       'goods_id'=>array('eq',$id)
    ))->delete();
    // ------------处理相册图片----------------
    // 先从相册中取出相册所在的硬盘路径
    $gpModel=D('goods_pic');
    $pics=$gpModel->field('pic,sm_pic,mid_pic,big_pic')
    ->where(array('goods_id'=>array('eq',$id)))
    ->select();
    // 循环每个图片从硬盘上删除
    foreach($pics as $k=>$v){
      deleteImage($v);
    }
    $gpModel->where(array('goods_id'=>array('eq',$id)))->delete();
    // -------------处理商品图片---------------
    $oldlogo=$this->field('img,sm_img,mid_img,big_img,mbig_img')->find($id);
    // 把图片从硬盘上删除
    deleteImage($oldlogo);

    // 删除商品之前把会员价格也删掉
    $mem_pri=D('member_price');
    $mem_pri->where(array(
       'goods_id'=>array('eq',$id)
    ))->delete();
  }
  // -------------------前台方法----------------
  // 取出疯狂抢购商品
  public function getPromoto($limit=5){
    $today=date('Y-m-d H:i:s');
    $data=$this->field('id,mid_img,shop_price,goods_name,promote_price')->
    where(array(
      'promote_price'=>array('gt',0),
      'is_on_sale'=>array('eq','是'),
      'promote_start_date'=>array('elt',$today),
      'promote_end_date'=>array('egt',$today),
    ))->limit($limit)->order('sort_num asc')->select();
    return $data;
  }
  //  取出新品，热销 精品等 $tab  代表is_hot  is_best is_new
  public function get_Is($Tab,$limit=5){
    $data=$this->where(array(
      "$Tab"=>array('eq','是'),
      'is_on_sale'=>array('eq','是'),
    ))->limit($limit)->order('sort_num asc')->select();
    return $data;
  }


  // 取出商品会员价格即：最终购买价格，不同会员等级，价格不一样
  public function getMemberPrice($goodsId){
    // 取出商品的促销价格
    $today=date('Y-m-d H:i:s');
    $promote_price=$this->field('promote_price')->where(array(
      'id'=>array('eq',$goodsId),
      'promote_price'=>array('gt',0),
      'promote_start_date'=>array('egt',$today),
      'promote_end_date'=>array('elt',$today),
    ))->find();
    // 取出本店售价
    $mp=$this->field('shop_price')->where(array(
      'id'=>array('eq',$goodsId)
    ))->find();
    // 先判断用户是否登录了
    if(session('m_id')){
      $userid=session('m_id');
      $gmModel=D('member_price');
      $pri=$gmModel->field('price')->where(array(
        'goods_id'=>array('eq',$goodsId),
        'level_id'=>array('eq',session('level_id')),
      ))->find();
      if($pri['price']){
        if($promote_price['promote_price'])
        return min($pri['price'],$promote_price['promote_price']);
        else
        return $pri['price'];
      }else
        {
          if($promote_price['promote_price'])
            return min($promote_price['promote_price'],$mp['shop_price']);
          else
          return $mp['shop_price'];

        }

    }else
    {
       if($promote_price['promote_price'])
         return min($promote_price['promote_price'],$mp['shop_price']);
       else
       return $mp['shop_price'];
    }
  }

}


 ?>
