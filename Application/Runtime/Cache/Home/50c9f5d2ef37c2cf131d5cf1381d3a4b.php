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

<link rel="stylesheet" href="/Public/Home/style/login.css" type="text/css">
<!-- 页面头部 start -->
<div class="header w990 bc mt15">
  <div class="logo w990">
    <h2 class="fl"><a href= "<?php echo U('index/index')?>"><img src="/Public/Home/images/logo.png" alt="京西商城"></a></h2>
  </div>
</div>
<!-- 页面头部 end -->
<!-- 登录主体部分start -->
<div class="login w990 bc mt10">
  <div class="login_hd">
    <?php if(isset($_SESSION['uid'])) :?>
    <h2>请绑定账号,完成快速登陆认证</h2>
   <?php else :?>
    <h2>用户登录</h2>
   <?php endif;?>
    <b></b>
  </div>
  <div class="login_bd">
    <div class="login_form fl">
      <form action="" method="post">
        <ul>
          <li>
            <label for="">用户名：</label>
            <input type="text" class="txt" name="username" />
          </li>
          <li>
            <label for="">密码：</label>
            <input type="password" class="txt" name="password" />
            <a href="">忘记密码?</a>
          </li>
          <li class="checkcode">
            <label for="">验证码：</label>
            <input type="text"  name="chkcode" />
            <img src="/index.php/Home/Login/chkcode" onclick="this.src='/index.php/Home/Login/chkcode/#'+Math.random()" alt="" />
            <span>看不清？<a href="">换一张</a></span>
          </li>
          <li>
            <label for="">&nbsp;</label>
            <input type="checkbox" class="chb"  /> 保存登录信息
          </li>
          <li>
            <label for="">&nbsp;</label>
            <input type="submit" value="" class="login_btn" />
          </li>
        </ul>
      </form>

      <div class="coagent mt15">
        <dl>
          <dt>使用合作网站登录商城：</dt>
          <dd class="qq"><a href=""><span></span>QQ</a></dd>
          <dd class="weibo"><a href="http://yun.jinmore.com/weibologin/wblogin.php"><span></span>新浪微博</a></dd>
          <dd class="yi"><a href=""><span></span>网易</a></dd>
          <dd class="renren"><a href=""><span></span>人人</a></dd>
          <dd class="qihu"><a href=""><span></span>奇虎360</a></dd>
          <dd class=""><a href=""><span></span>百度</a></dd>
          <dd class="douban"><a href=""><span></span>豆瓣</a></dd>
        </dl>
      </div>
    </div>

    <div class="guide fl">
      <h3>还不是商城用户</h3>
      <p>现在免费注册成为商城用户，便能立刻享受便宜又放心的购物乐趣，心动不如行动，赶紧加入吧!</p>

      <a href="/index.php/Home/Login/regist" class="reg_btn">免费注册 >></a>
    </div>

  </div>
</div>
<!-- 登录主体部分end -->


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