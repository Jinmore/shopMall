<?php
return array(
	//'配置项'=>'配置值'
  'DB_TYPE'               =>  'mysqli',     // 数据库类型
  'DB_HOST'               =>  '127.0.0.1', // 服务器地址
  'DB_NAME'               =>  'php39',          // 数据库名
  'DB_USER'               =>  'root',      // 用户名
  'DB_PWD'                =>  '123',          // 密码
  'DB_PORT'               =>  '3306',        // 端口
  'DB_PREFIX'             =>  'p39_',
  'DEFAULT_FILTER'        =>  'trim,htmlspecialchars', // 默认参数过滤方法 用于I函数...
  // 图片的相关配置
  'IMG_CONFIG'=> array(
    'maxSize'   =>    1024*1024 ,// 设置附件上传大小1M
    'exts'      =>     array('jpg', 'gif', 'png', 'jpeg'),// 设置附件上传类型
    'rootPath'  =>     "./Public/Uploads/", // 设置附件上传根目录,php程序要使用的路径，
    'viewPath'  =>     "/shangcheng/Public/Uploads/",// 浏览器要使用的路径，相对网站根目录路径
  ),
  'MAIL_ADDRESS'=>array(
    'Host'=>'smtp.126.com',
    'Username'=>'i_strive',
    'Password'=>'******',
  ),

);
