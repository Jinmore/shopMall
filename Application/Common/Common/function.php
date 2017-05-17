<?php
// -----------邮箱验证，发送邮件--------------
function sendMail($to,$title,$content)
{
  require './PHPMailer/PHPMailerAutoload.php';
  $mail=new PHPMailer;
  $mail->IsSMTP();
  //是否发送html代码
  $mail->IsHTML(TRUE);
  $mailConfig=C('MAIL_ADDRESS');
  $mail->CharSet='UTF-8';
  $mail->SMTPAuth=TRUE;
  $mail->From=$mailConfig['Username'].'@126.com';
  $mail->FromName=$mailConfig['Username'];
  $mail->Host=$mailConfig['Host'];
  $mail->Username=$mailConfig['Username'];
  $mail->Password=$mailConfig['Password'];
  // 发邮件端口25
  $mail->Port=25;
  $mail->AddAddress($to);
  $mail->Subject=$title;
  $mail->Body=$content;
  return ($mail->Send());
}
// --------------为一个订单生成支付宝支付按钮-------
function makeAlipayBtn($orderId,$btnName='去支付宝付款')
{
   return require_once("./alipay/alipayapi.php");
}
// 编写 防止xss攻击代码，引入 htmlpurfier插件
function removeXSS($data)
{
    require_once  './htmlpurifier/HTMLPurifier.auto.php';
    $_clean_xss_config = HTMLPurifier_Config::createDefault();
    $_clean_xss_config->set('Core.Encoding', 'UTF-8');
    $_clean_xss_config->set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,p[style],br,span[style],img[width|height|alt|src]');
    $_clean_xss_config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    $_clean_xss_config->set('HTML.TargetBlank', TRUE);
    $_clean_xss_obj = new HTMLPurifier($_clean_xss_config);
    return $_clean_xss_obj->purify($data);
}
// 把显示图片的功能封装成为一个函数，方便调用，灵活修改
/**
 * $url 为要显示的图片路径
 * @param type var Description
 * @return return type
 */
function showImage($url,$width='',$height='')
{
  $ic=C('IMG_CONFIG');
  if($width){
    $width="width='$width'";
  }
  if($height){
    $height="height='$height'";
  }
  echo "<img $width $height src='{$ic['viewPath']}$url' />";
}
/**
 * undocumented function summary
 *
 * 封装上传图片函数
 *
 * @param type var Description
 * @return return type
 */
 function uploadOne($imgName, $dirName, $thumb = array())
 {
 	// 上传LOGO
 	if(isset($_FILES[$imgName]) && $_FILES[$imgName]['error'] == 0)
 	{
 		$ic = C('IMG_CONFIG');
 		$upload = new \Think\Upload(array(
 			'rootPath' => $ic['rootPath'],
 			'maxSize' => $ic['maxSize'],
 			'exts' => $ic['exts'],
 		));// 实例化上传类
 		$upload->savePath = $dirName . '/'; // 图片二级目录的名称
 		// 上传文件
 		// 上传时指定一个要上传的图片的名称，否则会把表单中所有的图片都处理，之后再想其他图片时就再找不到图片了
 		$info   =   $upload->upload(array($imgName=>$_FILES[$imgName]));
 		if(!$info)
 		{
 			return array(
 				'ok' => 0,
 				'error' => $upload->getError(),
 			);
 		}
 		else
 		{
 			$ret['ok'] = 1;
 		    $ret['images'][0] = $logoName = $info[$imgName]['savepath'] . $info[$imgName]['savename'];
 		    // 判断是否生成缩略图
 		    if($thumb)
 		    {
 		    	$image = new \Think\Image();
 		    	// 循环生成缩略图
 		    	foreach ($thumb as $k => $v)
 		    	{
 		    		$ret['images'][$k+1] = $info[$imgName]['savepath'] . 'thumb_'.$k.'_' .$info[$imgName]['savename'];
 		    		// 打开要处理的图片
 				    $image->open($ic['rootPath'].$logoName);
 				    $image->thumb($v[0], $v[1])->save($ic['rootPath'].$ret['images'][$k+1]);
 		    	}
 		    }
 		    return $ret;
 		}
 	}
 }
 // 处理 图片时，删除磁盘旧图片
 function deleteImage($image = array())
 {
 	$savePath = C('IMG_CONFIG');
 	foreach ($image as $v)
 	{
 		unlink($savePath['rootPath'] . $v);
 	}
 }
 // 制作下拉框封装函数 表名，name字段名字，value属性值，text文本值
 function buildSelect($tableName,$selectName,$valueFieldName,$textFeildName,$selectedValue='')
 {
   $model=D($tableName);
   $data=$model->field("$valueFieldName,$textFeildName")->select();
   $select="<select name='$selectName'><option value=''>请选择</option>";
   foreach ($data as $v) {
     $value=$v[$valueFieldName];
     $text=$v[$textFeildName];
     if($selectedValue && $selectedValue==$value){
        $selected='selected="selected"';
     }else{
       $selected='';
     }
     $select.='<option '.$selected.' value="'.$value.'">'.$text.'</option>';

   }
   $select.="</select>";
   echo $select;
 }
?>
