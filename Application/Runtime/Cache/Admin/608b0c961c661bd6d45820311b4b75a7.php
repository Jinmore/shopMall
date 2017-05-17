<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/shangcheng/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/shangcheng/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
<!-- 引入时间插件 -->

</head>
<body>
<h1>
    <span class="action-span"><a href="<?php echo $_page_btn_link;?>"><?php echo $_page_btn_name;?></a></span>
    <span class="action-span1">管理中心</span>
    <span id="search_id" class="action-span1"><?php echo $_page_title;?></span>
    <div style="clear:both"></div>
</h1>
<!-- 内容区域 -->

<style media="screen">
#ul_pic_list li{margin:5px;list-style-type:none;}
#old_pic_list li{float:left;width:150px;height:150px;margin:5px;list-style-type:none;}
#attr_list li{margin: 5px;list-style: none;}

</style>

<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" >通用信息</span>
            <span class="tab-back" >商品描述</span>
            <span class="tab-back" >会员价格</span>
            <span class="tab-back" >商品属性</span>
            <span class="tab-back" >商品相册</span>
        </p>
    </div>
    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/shangcheng/index.php/Admin/Goods/edit" method="post">
          <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>"><!--id隐藏区域-->

            <table width="90%" class='tab_table' align="center">
              <tr>
                  <td class="label">所属分类:</td>
                  <td>
                      <select name="cat_id">
                          <option value="">请选择分类：</option>
                          <?php if(is_array($catData)): foreach($catData as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>" <?php if($val[id]==$data['cat_id']) echo "selected"; ?>><?php echo (str_repeat("--",$val['level']*4)); echo ($val['cat_name']); ?></option><?php endforeach; endif; ?>
                      </select>
                  </td>
              </tr>
              <!-- 扩展分类的修改 -->
              <tr>
                  <td class="label">扩展分类:
                  <input type="button"  id="btn_add_cat" value="添加一个扩展"/>
                </td>
                  <td id="add_select">
                    <?php if($good_catData) :?>
                    <?php foreach($good_catData as $v) :?>
                      <select name="ext_cat_id[]">
                          <option value="">请选择分类：</option>
                          <?php if(is_array($catData)): foreach($catData as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>"  <?php if($v['cat_id']==$val['id'])echo "selected";?>><?php echo (str_repeat("--",$val['level']*4)); echo ($val['cat_name']); ?></option><?php endforeach; endif; ?>
                      </select>
                    <?php endforeach;?>
                  <?php else :?>
                    <select name="ext_cat_id[]">
                        <option value="">请选择分类：</option>
                        <?php if(is_array($catData)): foreach($catData as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>"  <?php if($v['cat_id']==$val['id'])echo "selected";?>><?php echo (str_repeat("--",$val['level']*4)); echo ($val['cat_name']); ?></option><?php endforeach; endif; ?>
                    </select>
                  <?php endif;?>
                  </td>
              </tr>
              <tr>
                <td class="label">品牌名称：</td>
                <td>
                  <?php buildSelect('brand','brand_id','id','brand_name',$data['brand_id']);?>
                </td>
              </tr>
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value="<?php echo ($data["goods_name"]); ?>"size="30" />
                    <span class="require-field">*</span></td>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="<?php echo ($data["shop_price"]); ?>" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="1"<?php if($data['is_on_sale']=='是') echo "checked";?>/> 是
                        <input type="radio" name="is_on_sale" value="2"<?php if($data['is_on_sale']=='否') echo "checked";?>/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="<?php echo ($data['market_price']); ?>" size="20" />
                    </td>
                </tr>
                <tr>
                    <td class="label">促销售价：</td>
                    <td>
                        <input type="text" name="promote_price" value="<?php echo ($data['promote_price']); ?>" size="20" />
                        开始时间:<input type="text"  id='at1' name="promote_start_date" value="<?php echo ($data['promote_start_date']); ?>">
                        结束时间:<input type="text" id='at2' name="promote_end_date" value="<?php echo ($data['promote_end_date']); ?>">
                    </td>
                </tr>
                 <tr>
                    <td class="label">商品图片：</td>
                    <td>
                        <input type="file" name="img" size="35" /><br/>
                        <img src="/shangcheng/Public/Uploads/<?php echo ($data["sm_img"]); ?>">
                    </td>
                </tr>
                <tr>
                    <td class="label">是否新品：</td>
                    <td>
                        <input type="radio" name="is_new" value="1" <?php if($data['is_new']=='是') echo "checked";?> /> 是
                        <input type="radio" name="is_new" value="2" <?php if($data['is_new']=='否') echo "checked";?> /> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否精品：</td>
                    <td>
                        <input type="radio" name="is_best" value="1" <?php if($data['is_best']=='是') echo "checked";?>/> 是
                        <input type="radio" name="is_best" value="2" <?php if($data['is_best']=='否') echo "checked";?> /> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否热销：</td>
                    <td>
                        <input type="radio" name="is_hot" value="1" <?php if($data['is_hot']=='是') echo "checked";?> /> 是
                        <input type="radio" name="is_hot" value="2" <?php if($data['is_hot']=='否') echo "checked";?> /> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否推荐楼层：</td>
                    <td>
                        <input type="radio" name="is_floor" value="1" <?php if($data['is_floor']=='是') echo "checked";?> /> 是
                        <input type="radio" name="is_floor" value="2" <?php if($data['is_floor']=='否') echo "checked";?> /> 否
                    </td>
                </tr>
                <tr>
                  <td class="label">排序:</td>
                  <td><input type="text" name="sort_num" value="<?php echo ($data['sort_num']); ?>"></td>
                </tr>
            </table>
            <!-- 商品描述表格 -->
          <table width="100%" style="display:none;" class="tab_table" align="center">
            <tr>
                <td>
                    <textarea name="goods_desc" id='goods_desc' cols="40" rows="3"><?php echo ($data["goods_desc"]); ?></textarea>
                </td>
            </tr>
          </table>
          <!-- 会员价格表格 -->
          <table width="90%" style="display:none;" class='tab_table' align="center">
            <tr>
              <td>

                  <?php foreach($memData as $k=>$m) :?>
                    <p>
                      <?php echo $m['level_name']?>
                      <!-- 将会员级别ID 存入到 会员价格数组的键中 -->
                      <input type="text" name="member_price[<?php echo $m['id'];?>]" value="<?php echo ($mp[$m['id']]); ?>" size=8>元<br/>

                    </p>
                  <?php endforeach;?>
              </td>
            </tr>
          </table>
          <!-- 商品属性表-->
          <table width="90%" style="display:none;" class='tab_table' align="center">
            <tr>
              <td>商品类型:
                <?php buildSelect('type','type_id','id','type_name',$data['type_id'])?>
              </td>
            </tr>
            <tr>
              <td>
                <ul id="attr_list">
                <!-- 循环所有的属性 -->
                <?php $attrId=array(); foreach($attrData as $k=>$v) : if(in_array($v['attr_id'],$attrId)) $opt="-"; else{ $opt="+"; $attrId[]=$v['attr_id']; } ?>
                  <li>
                    <!-- 添加一个隐藏区，存储商品属性id -->
                    <input type="hidden" name="goods_attr_id[]" value="<?php echo ($v['id']); ?>" />
                    <?php if($v['attr_type']=='可选') :?>
                    <a href='#' onclick="addNewAttr(this)">[<?php echo $opt;?>]</a>
                  <?php endif;?>
                  <?php echo $v['attr_name'].":"?>
                  <?php if($v['attr_option_values']=="") :?>
                    <input type="text" name='attr_value[<?php echo ($v['attr_id']); ?>][]' value="<?php echo ($v['attr_value']); ?>"/>
                <?php else: ?>
                  <?php $_attr=explode(',',$v['attr_option_values']);?>
                  <select name='attr_value[<?php echo ($v['attr_id']); ?>][]'>
                    <option value="">请选择</option>
                    <?php foreach($_attr as $k1=>$v1) :?>
                      <option value="<?php echo $v1;?>" <?php if($v['attr_value']==$v1) echo "selected";?>><?php echo $v1;?></option>
                    <?php endforeach;?>
                  </select>
                <?php endif;?>


                  </li>
                <?php endforeach;?>
              </ul>
              </td>
            </tr>
          </table>
          <!--商品相册表  -->
          <table width="90%" style="display:none;" class='tab_table' align="center">
           <tr>
             <td>
               <input type="button" id="btn_add_pic"  value="添加一张"/>
               <hr/>
               <ul id="ul_pic_list"> </ul>
               <hr/>
               <ul id="old_pic_list">
                     <?php foreach($gpData as $v) :?>
                    <li>
                     <input pic_id="<?php echo $v['id']; ?>" class="btn_del_pic" type="button" value="删除" /><br />
                     <img src="/shangcheng/Public/Uploads/<?php echo ($v['mid_pic']); ?>" width="120">
                   </li>
                   <?php endforeach ;?>

               </ul>
             </td>
           </tr>
          </table>
            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>
        </form>
    </div>
</div>


<link href="/shangcheng/Public/umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/shangcheng/Public/umeditor/third-party/jquery.min.js"></script>
<script type="text/javascript" src="/shangcheng/Public/umeditor/third-party/template.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/shangcheng/Public/umeditor/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/shangcheng/Public/umeditor/umeditor.min.js"></script>
<script type="text/javascript" src="/shangcheng/Public/umeditor/lang/zh-cn/zh-cn.js"></script>

<!-- 引入时间插件 -->
<link href="/shangcheng/Public/datetimepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8" src="/shangcheng/Public/datetimepicker/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/shangcheng/Public/datetimepicker/datepicker-zh_cn.js"></script>
<link rel="stylesheet" media="all" type="text/css" href="/shangcheng/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.css" />
<script type="text/javascript" src="/shangcheng/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="/shangcheng/Public/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>

<script type="text/javascript" style="width:1000px;height:240px;">
  var um = UM.getEditor('goods_desc',{initialFrameWidth:"100%",initialFrameHeight:"300"});

  /******** 切换的代码 *******/
  $("#tabbar-div p span").click(function(){
  	// 点击的第几个按钮
  	var i = $(this).index();
  	// 先隐藏所有的table
  	$(".tab_table").hide();
  	// 显示第i个table
  	$(".tab_table").eq(i).show();
  	// 先取消原按钮的选中状态
  	$(".tab-front").removeClass("tab-front").addClass("tab-back");
  	// 设置当前按钮选中
  	$(this).removeClass("tab-back").addClass("tab-front");
  });
// ------------时间插件--------
// 设置促销商品 时间插件
$.timepicker.setDefaults($.timepicker.regional['zh-CN']);
$("#at1").datepicker();
$("#at2").datepicker();
  // ------------添加一张图片------------
  $(function(){
    $('#btn_add_pic').click(function(){
      var file='<li><input  type="file" name="pic[]"/></li>';
      $('#ul_pic_list').append(file);
    });
  });
  // ---------编写 js 删除图片----------
  $('.btn_del_pic').click(function(){
    if(confirm("确认要删除吗？")){
      // 先选中删除按钮所在的li标签
      var li=$(this).parent();
      // 从这个按钮上获取pic_id 属性
      var pid=$(this).attr('pic_id');

      // 编写 ajax代码请求 删除图片
      $.ajax({
        type:"GET",
        url:"<?php echo U('ajaxDelPic','',FALSE);?>/picid/"+pid,
        success:function (data) {
          li.remove();
        }
      })
    }
  });
// -----------------添加扩展分类 js------------
 $(function(){
   $('#btn_add_cat').click(function(){

     var newselect=$('#add_select').find('select').eq('0').clone();
     $('#add_select').append(newselect);
    //  去除新的克隆的下拉框选中状态
     newselect.find('option:selected').removeAttr('selected');


   });
 });
 // -------------编写ajax获得商品属性----------
 $('select[name=type_id]').change(function(){
     //  获得类型id
     var typeId=$(this).val();
    //  根据类型id获得商品属性列表
    $.ajax({
      type:'GET',
      url:"<?php echo U('ajaxGetAttr','',FALSE)?>/type_id/"+typeId,
      dataType:'json',
      success:function (data) {
        var li="";
        $(data).each(function(k,v){
          li+="<li>";
          if(v.attr_type=='可选')
          li+="<a href='#' onclick='addNewAttr(this)'>[+]</a>";
          // 属性名称
          li+=v.attr_name+" : ";
          if(v.attr_option_values==""){
            li+="<input type='text' name='attr_value["+v.id+"][]' />";
          }else{
            var _attrValue=v.attr_option_values.split(",");
            li+="<select name='attr_value["+v.id+"][]'><option value=''>请选择</option>";
            for(var i=0;i< _attrValue.length;i++){
               li+="<option value='"+_attrValue[i]+"'>";
               li+=_attrValue[i];
               li+="</option>";
            }
            li+="</select>";
          }
          li+='</li>';
        });
        // 将li 添加到页面中
        $('#attr_list').html(li);
      }
    });
 });
 // 执行 + 号 添加属性
 function addNewAttr(a) {
   var li=$(a).parent();
   if($(a).text()=='[+]'){
     var newli=li.clone();
    // 克隆的a标签 text文本变为 【-】
     newli.find('a').text('[-]');
    //  将克隆出来的隐藏域id清空,防止克隆出来的属性id重复
    newli.find("input[name='goods_attr_id[]']").val("");
    // 将新添加的默认属性修改为 ：为请选择
     newli.find('option:selected').removeAttr('selected');
     li.after(newli);
   }else{
    // 先获取要删除属性的id
    var gaiID=li.find("input[name='goods_attr_id[]']").val();
     if(gaiID=="")
       li.remove();
     else{
       if(confirm("确定要删除吗？删除之后，相关的库存量也会一起删除")){
         $.ajax({
           type:"GET",
           url:"<?php echo U('ajaxDelAttr?goods_id='.$data['id'],'',FALSE) ?>/gaiID/"+gaiID,
           success:function(data){
             li.remove();
           }
         });
       }

     }
   }
 }

</script>

<div id="footer">
版权自己<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>