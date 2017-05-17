<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  <meta name="description" content="<?php echo ($_description_content); ?>" />
  <meta name="Keywords" content="<?php echo ($_key_content); ?>" />
	<title><?php echo ($_title_name); ?></title>
	<link rel="stylesheet" href="/Public/Home/style/base.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/global.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/header.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/bottomnav.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/footer.css" type="text/css">

	<script type="text/javascript" src="/Public/Home/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/Public/Home/js/header.js"></script>
</head>
<body>
	<!-- 顶部导航 start -->
	<div class="topnav">
		<div class="topnav_bd w1210 bc">
			<div class="topnav_left">

			</div>
			<div class="topnav_right fr">
				<ul>
					<li id="showlogin"> </li>
					<li class="line">|</li>
					<li><a href="<?php echo U('My/order')?>">我的订单</a></li>
					<li class="line">|</li>
					<li>客户服务</li>

				</ul>
			</div>
		</div>
	</div>
	<!-- 顶部导航 end -->

	<div style="clear:both;"></div>
<!-- 内容区域 -->

<link rel="stylesheet" href="/Public/Home/style/index.css" type="text/css">
<script type="text/javascript" src="/Public/Home/js/index.js"></script>

<!-- 头部 start -->
<div class="header w1210 bc mt15">
  <!-- 头部上半部分 start 包括 logo、搜索、用户中心和购物车结算 -->
  <div class="logo w1210">
    <h1 class="fl"><a href="<?php echo U('Index/index')?>"><img src="/Public/Home/images/logo.png" alt="京西商城"></a></h1>
    <!-- 头部搜索 start -->
    <div class="search fl">
      <div class="search_form">
        <div class="form_left fl"></div>
        <form action="" name="serarch" method="get" class="fl">
          <input type="text" class="txt" value="请输入商品关键字" /><input type="submit" class="btn" value="搜索" />
        </form>
        <div class="form_right fl"></div>
      </div>

      <div style="clear:both;"></div>

      <div class="hot_search">
        <strong>热门搜索:</strong>
        <a href="">D-Link无线路由</a>
        <a href="">休闲男鞋</a>
        <a href="">TCL空调</a>
        <a href="">耐克篮球鞋</a>
      </div>
    </div>
    <!-- 头部搜索 end -->

    <!-- 用户中心 start-->
    <div class="user fl">
      <dl>
        <dt>
          <em></em>
          <a href="">用户中心</a>
          <b></b>
        </dt>
        <dd>
          <div class="prompt">
            您好，请<a href="">登录</a>
          </div>
          <div class="uclist mt10">
            <ul class="list1 fl">
              <li><a href="">用户信息></a></li>
              <li><a href="">我的订单></a></li>
              <li><a href="">收货地址></a></li>
              <li><a href="">我的收藏></a></li>
            </ul>

            <ul class="fl">
              <li><a href="">我的留言></a></li>
              <li><a href="">我的红包></a></li>
              <li><a href="">我的评论></a></li>
              <li><a href="">资金管理></a></li>
            </ul>

          </div>
          <div style="clear:both;"></div>
          <div class="viewlist mt10">
            <h3>最近浏览的商品：</h3>
            <ul>
              <li><a href=""><img src="/Public/Home/images/view_list1.jpg" alt="" /></a></li>
              <li><a href=""><img src="/Public/Home/images/view_list2.jpg" alt="" /></a></li>
              <li><a href=""><img src="/Public/Home/images/view_list3.jpg" alt="" /></a></li>
            </ul>
          </div>
        </dd>
      </dl>
    </div>
    <!-- 用户中心 end-->

    <!-- 购物车 start -->
    <div class="cart fl">
      <dl>
        <dt id="cart_sm_lst">
          <a href="<?php echo U('Cart/lst')?>">去购物车结算</a>
          <b></b>
        </dt>
        <dd>
          <div class="prompt" id="cart_list">
            购物车中还没有商品，赶紧选购吧！
          </div>
        </dd>
      </dl>
    </div>
    <!-- 购物车 end -->
  </div>
  <!-- 头部上半部分 end -->

  <div style="clear:both;"></div>

  <!-- 导航条部分 start -->
  <div class="nav w1210 bc mt10">
    <!--  商品分类部分 start-->
    <div class="category fl <?php if($_nav==0) echo 'cat1'; ?> "> <!-- 非首页，需要添加cat1类 -->
      <div class="cat_hd <?php if($_nav==0) echo 'off'; ?>" >  <!-- 注意，首页在此div上只需要添加cat_hd类，非首页，默认收缩分类时添加上off类，鼠标滑过时展开菜单则将off类换成on类 -->
        <h2>全部商品分类</h2>
        <em></em>
      </div>

      <div class="cat_bd <?php if($_nav==0) echo 'none'; ?>">
        <?php foreach($catData as $k =>$v) :?>
        <div class="cat <?php if($k==0) echo 'item1';?>">
          <h3><a href=""><?php echo ($v['cat_name']); ?></a> <b></b></h3>
          <div class="cat_detail none">
            <?php foreach($v['children'] as $k1=>$v1) :?>
            <dl class="<?php if($k1==0) echo 'dl_1st';?>">
              <dt><a href=""><?php echo ($v1['cat_name']); ?></a></dt>
              <dd>
                <?php foreach($v1['children'] as $k2=>$v2) :?>
                <a href=""><?php echo ($v2['cat_name']); ?></a>
              <?php endforeach;?>
              </dd>
            </dl>
          <?php endforeach;?>
          </div>
        </div>
      <?php endforeach;?>


      </div>
    </div>
    <!--  商品分类部分 end-->

    <div class="navitems fl">
      <ul class="fl">
        <li class="current"><a href="">首页</a></li>
        <li><a href="">电脑频道</a></li>
        <li><a href="">家用电器</a></li>
        <li><a href="">品牌大全</a></li>
        <li><a href="">团购</a></li>
        <li><a href="">积分商城</a></li>
        <li><a href="">夺宝奇兵</a></li>
      </ul>
      <div class="right_corner fl"></div>
    </div>
  </div>
  <!-- 导航条部分 end -->
</div>
<!-- 头部 end-->
<div style="clear:both;"></div>

<script type="text/javascript">
<?php $ic= C('IMG_CONFIG')?>
var viewpath="<?php echo $ic['viewPath'] ?>";
$('#cart_sm_lst').mouseover(function (){
  $.ajax({
    type:'GET',
    url:"<?php echo U('cart/ajaxCartLst')?>",
    dataType:'json',
    success:function (data)
    {

      var html="<table>";
      $(data).each(function(k,v){
         html+="<tr>";
         html+='<td><img src='+viewpath+v.mid_img+' width="40"></td>';
         html+="<td>"+v.goods_name+"</td>";
         html+="</tr>";
      });
      html+="</table>";
      $('#cart_list').html(html);
    }
  });
});

</script>


<div class="colligate w1210 bc mt10">
  <!-- 幻灯区域 start -->
  <div class="slide fl">
    <div class="area">
      <div class="slide_items">
        <ul>
          <li><a href=""><img src="/Public/Home/images/index_slide1.jpg" alt="" /></a></li>
          <li><a href=""><img src="/Public/Home/images/index_slide2.jpg" alt="" /></a></li>
          <li><a href=""><img src="/Public/Home/images/index_slide3.jpg" alt="" /></a></li>
          <li><a href=""><img src="/Public/Home/images/index_slide4.jpg" alt="" /></a></li>
          <li><a href=""><img src="/Public/Home/images/index_slide5.jpg" alt="" /></a></li>
          <li><a href=""><img src="/Public/Home/images/index_slide6.jpg" alt="" /></a></li>
        </ul>
      </div>
      <div class="slide_controls">
        <ul>
          <li class="on">1</li>
          <li>2</li>
          <li>3</li>
          <li>4</li>
          <li>5</li>
          <li>6</li>
        </ul>
      </div>
    </div>
  </div>
  <!-- 幻灯区域 end-->

  <!-- 快报区域 start-->
  <div class="coll_right fl ml10">
    <div class="ad"><a href=""><img src="/Public/Home/images/ad.jpg" alt="" /></a></div>

    <div class="news mt10">
      <h2><a href="">更多快报&nbsp;></a><strong>网站快报</strong></h2>
      <ul>
        <li class="odd"><a href="">电脑数码双11爆品抢不停</a></li>
        <li><a href="">买茶叶送武夷山旅游大奖</a></li>
        <li class="odd"><a href="">爆款手机最高直降1000</a></li>
        <li><a href="">新鲜褚橙全面包邮开售！</a></li>
        <li class="odd"><a href="">家具家装全场低至3折</a></li>
        <li><a href="">买韩束，志玲邀您看电影</a></li>
        <li class="odd"><a href="">美的先行惠双11快抢悦</a></li>
        <li><a href="">享生活 疯狂周期购！</a></li>
      </ul>

    </div>

    <div class="service mt10">
      <h2>
        <span class="title1 on"><a href="">话费</a></span>
        <span><a href="">旅行</a></span>
        <span><a href="">彩票</a></span>
        <span class="title4"><a href="">游戏</a></span>
      </h2>
      <div class="service_wrap">
        <!-- 话费 start -->
        <div class="fare">
          <form action="">
            <ul>
              <li>
                <label for="">手机号：</label>
                <input type="text" name="phone" value="请输入手机号" class="phone" />
                <p class="msg">支持移动、联通、电信</p>
              </li>
              <li>
                <label for="">面值：</label>
                <select name="" id="">
                  <option value="">10元</option>
                  <option value="">20元</option>
                  <option value="">30元</option>
                  <option value="">50元</option>
                  <option value="" selected>100元</option>
                  <option value="">200元</option>
                  <option value="">300元</option>
                  <option value="">400元</option>
                  <option value="">500元</option>
                </select>
                <strong>98.60-99.60</strong>
              </li>
              <li>
                <label for="">&nbsp;</label>
                <input type="submit" value="点击充值" class="fare_btn" /> <span><a href="">北京青春怒放独家套票</a></span>
              </li>
            </ul>
          </form>
        </div>
        <!-- 话费 start -->

        <!-- 旅行 start -->
        <div class="travel none">
          <ul>
            <li>
              <a href=""><img src="/Public/Home/images/holiday.jpg" alt="" /></a>
              <a href="" class="button">度假查询</a>
            </li>
            <li>
              <a href=""><img src="/Public/Home/images/scenic.jpg" alt="" /></a>
              <a href="" class="button">景点查询</a>
            </li>
          </ul>
        </div>
        <!-- 旅行 end -->

        <!-- 彩票 start -->
        <div class="lottery none">
          <p><img src="/Public/Home/images/lottery.jpg" alt="" /></p>
        </div>
        <!-- 彩票 end -->

        <!-- 游戏 start -->
        <div class="game none">
          <ul>
            <li><a href=""><img src="/Public/Home/images/sanguo.jpg" alt="" /></a></li>
            <li><a href=""><img src="/Public/Home/images/taohua.jpg" alt="" /></a></li>
            <li><a href=""><img src="/Public/Home/images/wulin.jpg" alt="" /></a></li>
          </ul>
        </div>
        <!-- 游戏 end -->
      </div>
    </div>

  </div>
  <!-- 快报区域 end-->
</div>
<!-- -综合区域 end -->

<div style="clear:both;"></div>

<!-- 导购区域 start -->
<div class="guide w1210 bc mt15">
  <!-- 导购左边区域 start -->
  <div class="guide_content fl">
    <h2>
      <span class="on">疯狂抢购</span>
      <span>热卖商品</span>
      <span>推荐商品</span>
      <span>新品上架</span>
      <span class="last">猜您喜欢</span>
    </h2>

    <div class="guide_wrap">
      <!-- 疯狂抢购 start-->
      <div class="crazy">
        <ul>
          <?php foreach($good1 as $k=>$v) :?>
          <li>
            <dl>
              <dt><a href="<?php echo U('goods?id='.$v['id'].'')?>"><img src="/Public/Uploads/<?php echo ($v['mid_img']); ?>" alt="" /></a></dt>
              <dd><a href="<?php echo U('goods?id='.$v['id'].'')?>"><?php echo ($v['goods_name']); ?></a></dd>
              <dd><span>售价：</span><strong><?php echo ($v['promote_price']); ?></strong></dd>
            </dl>
          </li>
        <?php endforeach;?>
        </ul>
      </div>
      <!-- 疯狂抢购 end-->

      <!-- 热卖商品 start -->
      <div class="hot none">
        <ul>
          <?php foreach($good2 as $v) :?>
          <li>
            <dl>
              <dt><a href="<?php echo U('goods?id='.$v['id'].'')?>"><img src="/Public/Uploads/<?php echo ($v['mid_img']); ?>" alt="" /></a></dt>
              <dd><a href="<?php echo U('goods?id='.$v['id'].'')?>"><?php echo ($v['goods_name']); ?></a></dd>
              <dd><span>售价：</span><strong><?php echo ($v['shop_price']); ?></strong></dd>
            </dl>
          </li>
        <?php endforeach;?>
        </ul>
      </div>
      <!-- 热卖商品 end -->

      <!-- 推荐商品 atart -->
      <div class="recommend none">
        <ul>
          <?php foreach($good3 as $v) :?>
          <li>
            <dl>
              <dt><a href="<?php echo U('goods?id='.$v['id'].'')?>"><img src="/Public/Uploads/<?php echo ($v['mid_img']); ?>" alt="" /></a></dt>
              <dd><a href="<?php echo U('goods?id='.$v['id'].'')?>"><?php echo ($v['goods_name']); ?></a></dd>
              <dd><span>售价：</span><strong><?php echo ($v['shop_price']); ?></strong></dd>
            </dl>
          </li>
        <?php endforeach;?>
        </ul>
      </div>
      <!-- 推荐商品 end -->

      <!-- 新品上架 start-->
      <div class="new none">
        <ul>
          <?php foreach($good4 as $v) :?>
          <li>
            <dl>
              <dt><a href="<?php echo U('goods?id='.$v['id'].'')?>"><img src="/Public/Uploads/<?php echo ($v['mid_img']); ?>" alt="" /></a></dt>
              <dd><a href="<?php echo U('goods?id='.$v['id'].'')?>"><?php echo ($v['goods_name']); ?></a></dd>
              <dd><span>售价：</span><strong><?php echo ($v['shop_price']); ?></strong></dd>
            </dl>
          </li>
        <?php endforeach;?>
        </ul>
      </div>
      <!-- 新品上架 end-->

      <!-- 猜您喜欢 start -->
      <div class="guess none">
        <ul>
          <li>
            <dl>
              <dt><a href=""><img src="/Public/Home/images/guess1.jpg" alt="" /></a></dt>
              <dd><a href="">Thinkpad USB光电鼠标</a></dd>
              <dd><span>售价：</span><strong> ￥39.00</strong></dd>
            </dl>
          </li>
          <li>
            <dl>
              <dt><a href=""><img src="/Public/Home/images/guess2.jpg" alt="" /></a></dt>
              <dd><a href="">宜客莱（ECOLA）电脑散热器</a></dd>
              <dd><span>售价：</span><strong> ￥89.00</strong></dd>
            </dl>
          </li>
          <li>
            <dl>
              <dt><a href=""><img src="/Public/Home/images/guess3.jpg" alt="" /></a></dt>
              <dd><a href="">巴黎欧莱雅男士洁面膏 100ml</a></dd>
              <dd><span>售价：</span><strong> ￥30.00</strong></dd>
            </dl>
          </li>
        </ul>
      </div>
      <!-- 猜您喜欢 end -->

    </div>

  </div>
  <!-- 导购左边区域 end -->

  <!-- 侧栏 网站首发 start-->
  <div class="sidebar fl ml10">
    <h2><strong>网站首发</strong></h2>
    <div class="sidebar_wrap">
      <dl class="first">
        <dt class="fl"><a href=""><img src="/Public/Home/images/viewsonic.jpg" alt="" /></a></dt>
        <dd><strong><a href="">ViewSonic优派N710 </a></strong> <em>首发</em></dd>
        <dd>苹果iphone 5免费送！攀高作为全球智能语音血压计领导品牌，新推出的黑金刚高端智能电子血压计，改变传统测量方式让血压测量迈入一体化时代。</dd>
      </dl>

      <dl>
        <dt class="fr"><a href=""><img src="/Public/Home/images/samsung.jpg" alt="" /></a></dt>
        <dd><strong><a href="">Samsung三星Galaxy</a></strong> <em>首发</em></dd>
        <dd>电视百科全书，360°无死角操控，感受智能新体验！双核CPU+双核GPU+MEMC运动防抖，58寸大屏打造全新视听盛宴！</dd>
      </dl>
    </div>


  </div>
  <!-- 侧栏 网站首发 end -->

</div>
<!-- 导购区域 end -->

<div style="clear:both;"></div>

<!--1F 电脑办公 start -->
<?php foreach($catFloorData as $k=>$v) :?>

<div class="floor1 floor w1210 bc mt10">
  <!-- 1F 左侧 start -->
  <div class="floor_left fl">
    <!-- 商品分类信息 start-->
    <div class="cate fl">
      <h2><?php echo ($v['cat_name']); ?></h2>
      <div class="cate_wrap">
        <ul>
          <?php foreach($v['sub'] as $k1=>$v1) : ?>
          <li><a href=""><b>.</b><?php echo ($v1['cat_name']); ?></a></li>
        <?php endforeach;?>
        </ul>
        <p><a href=""><img src="/Public/Home/images/notebook.jpg" alt="" /></a></p>
      </div>


    </div>
    <!-- 商品分类信息 end-->

    <!-- 商品列表信息 start-->
    <div class="goodslist fl">
      <h2>
        <?php foreach($v['recsub'] as $k2=>$v2) :?>
        <span class="<?php if($k2==0) echo 'on';?>"><?php echo ($v2['cat_name']); ?></span>

      <?php endforeach;?>
      </h2>
      <div class="goodslist_wrap">
        <?php foreach($v['recsub'] as $k2=>$v2) :?>
        <div <?php if($k2 >0) echo "class='none'";?> >
          <ul>
            <?php foreach($v2['recGoods'] as $k3=>$v3) :?>
            <li>
              <dl>
                <dt><a href="<?php echo U('goods?id='.$v3['id'].'')?>"><img src="/Public/Uploads/<?php echo ($v3['mid_img']); ?>" alt="" /></a></dt>
                <dd><a href="<?php echo U('goods?id='.$v3['id'].'')?>"><?php echo ($v3['goods_name']); ?></a></dd>
                <dd><span>售价：</span> <strong>￥<?php echo ($v3['shop_price']); ?></strong></dd>
              </dl>
            </li>
          <?php endforeach;?>
          </ul>
        </div>
        <?php endforeach;?>
      </div>
    </div>
    <!-- 商品列表信息 end-->
  </div>
  <!-- 1F 左侧 end -->

  <!-- 右侧 start -->
  <div class="sidebar fl ml10">
    <!-- 品牌旗舰店 start -->
    <div class="brand">
      <h2><a href="">更多品牌&nbsp;></a><strong>品牌旗舰店</strong></h2>
      <div class="sidebar_wrap">
        <ul>
          <?php foreach($v['brand'] as $vb) :?>
          <li><a href=""><img src="/Public/Admin/<?php echo ($vb['logo']); ?>" alt="" /></a></li>
        <?php endforeach;?>
        </ul>
      </div>
    </div>
    <!-- 品牌旗舰店 end -->

    <!-- 分类资讯 start -->
    <div class="info mt10">
      <h2><strong>分类资讯</strong></h2>
      <div class="sidebar_wrap">
        <ul>
          <li><a href=""><b>.</b>iphone 5s土豪金大量到货</a></li>
          <li><a href=""><b>.</b>三星note 3低价促销</a></li>
          <li><a href=""><b>.</b>thinkpad x240即将上市</a></li>
          <li><a href=""><b>.</b>双十一来临，众商家血拼</a></li>
        </ul>
      </div>

    </div>
    <!-- 分类资讯 end -->

    <!-- 广告 start -->
    <div class="ads mt10">
      <a href=""><img src="/Public/Home/images/canon.jpg" alt="" /></a>
    </div>
    <!-- 广告 end -->
  </div>
  <!-- 右侧 end -->

</div>
<?php endforeach;?>
<!--1F 电脑办公 start -->




<div style="clear:both;"></div>

<!-- 底部导航 start -->
<div class="bottomnav w1210 bc mt10">
  <div class="bnav1">
    <h3><b></b> <em>购物指南</em></h3>
    <ul>
      <li><a href="">购物流程</a></li>
      <li><a href="">会员介绍</a></li>
      <li><a href="">团购/机票/充值/点卡</a></li>
      <li><a href="">常见问题</a></li>
      <li><a href="">大家电</a></li>
      <li><a href="">联系客服</a></li>
    </ul>
  </div>

  <div class="bnav2">
    <h3><b></b> <em>配送方式</em></h3>
    <ul>
      <li><a href="">上门自提</a></li>
      <li><a href="">快速运输</a></li>
      <li><a href="">特快专递（EMS）</a></li>
      <li><a href="">如何送礼</a></li>
      <li><a href="">海外购物</a></li>
    </ul>
  </div>


  <div class="bnav3">
    <h3><b></b> <em>支付方式</em></h3>
    <ul>
      <li><a href="">货到付款</a></li>
      <li><a href="">在线支付</a></li>
      <li><a href="">分期付款</a></li>
      <li><a href="">邮局汇款</a></li>
      <li><a href="">公司转账</a></li>
    </ul>
  </div>

  <div class="bnav4">
    <h3><b></b> <em>售后服务</em></h3>
    <ul>
      <li><a href="">退换货政策</a></li>
      <li><a href="">退换货流程</a></li>
      <li><a href="">价格保护</a></li>
      <li><a href="">退款说明</a></li>
      <li><a href="">返修/退换货</a></li>
      <li><a href="">退款申请</a></li>
    </ul>
  </div>

  <div class="bnav5">
    <h3><b></b> <em>特色服务</em></h3>
    <ul>
      <li><a href="">夺宝岛</a></li>
      <li><a href="">DIY装机</a></li>
      <li><a href="">延保服务</a></li>
      <li><a href="">家电下乡</a></li>
      <li><a href="">京东礼品卡</a></li>
      <li><a href="">能效补贴</a></li>
    </ul>
  </div>
</div>
<!-- 底部导航 end -->



  <div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt10">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号
		</p>
		<p class="auth">
			<a href=""><img src="/Public/Home/images/xin.png" alt="" /></a>
			<a href=""><img src="/Public/Home/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="/Public/Home/images/police.jpg" alt="" /></a>
			<a href=""><img src="/Public/Home/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->

</body>
</html>
<script type="text/javascript">
// ajax判断登陆状态
	$.ajax({
		type:'GET',
		url:"<?php echo U('login/ajaxlogin')?>",
		dataType:'json',
		success:function(data){
      if(data.login==1){
				var li='您好，欢迎'+data.username+'[<a href="<?php echo U('login/logout')?>">退出</a>]';
			}else{
				var li="您好，欢迎来到商城，[<a href='<?php echo U("login/login")?>'>登陆</a>][<a href='<?php echo U("login/regist")?>'>免费注册</a>]";
			}
     $('#showlogin').html(li);
		}
	});
</script>