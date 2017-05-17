<?php
return array(
	//'配置项'=>'配置值'
  // 配置静态页
  'HTML_CACHE_ON'     =>    false, // 开启静态缓存
  'HTML_CACHE_TIME'   =>    60,   // 全局静态缓存有效期（秒）
  'HTML_FILE_SUFFIX'  =>    '.shtml', // 设置静态缓存文件后缀
  'HTML_CACHE_RULES'  =>     array(  // 定义静态缓存规则
     // 定义格式1 数组方式
  'Index:index'    =>     array('index', '60')),
     // 定义格式2 字符串方)
);
