<?php
// 引入账号配置文件和核心类文件
include "./config.php";
include 'saetv2.ex.class.php';
// 实例化oauth类
$o=new SaeTOAuthV2(WB_KEY,WB_SEC);
// 获得接口地址
$auth=$o->getAuthorizeURL(CALL_URL);

header("location:".$auth);


 ?>
