<?php
include "./config.php";
include "./saetv2.ex.class.php";

$o=new SaeTOAuthV2(WB_KEY,WB_SEC);
if(isset($_GET['code'])){
  $keys['code']=$_GET['code'];
  $keys['redirect_uri']=CALL_URL;
}


$auth=$o->getAccessToken($keys);
session_start();
$_SESSION['access_token']=$auth['access_token'];
$_SESSION['uid']=$auth['uid'];
header('location:'."http://yun.jinmore.com/index.php/Home/login/wblogin");


?>
