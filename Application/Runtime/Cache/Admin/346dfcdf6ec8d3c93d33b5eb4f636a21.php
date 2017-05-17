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
<!-- 引入底部模版标签 -->

<style media="screen">
  #ul_pic_list li{ margin: 5px;list-style: none;}
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
        <form enctype="multipart/form-data" action="/shangcheng/index.php/Admin/Goods/add" method="post">
            <table width="90%" class='tab_table' align="center">
              <tr>
                  <td class="label">所属分类:</td>
                  <td>
                      <select name="cat_id">
                          <option value="">请选择分类：</option>
                          <?php if(is_array($catData)): foreach($catData as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>" ><?php echo (str_repeat("--",$val['level']*4)); echo ($val['cat_name']); ?></option><?php endforeach; endif; ?>
                      </select>
                  </td>
              </tr>
              <!-- 扩展分类的添加 -->
              <tr>
                  <td class="label">扩展分类:
                  <input type="button"  id="btn_add_cat" value="添加一个扩展"/>
                </td>
                  <td id="add_select">
                      <select name="ext_cat_id[]">
                          <option value="">请选择分类：</option>
                          <?php if(is_array($catData)): foreach($catData as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>" ><?php echo (str_repeat("--",$val['level']*4)); echo ($val['cat_name']); ?></option><?php endforeach; endif; ?>
                      </select>
                  </td>
              </tr>
              <tr>
                <td class="label">品牌名称：</td>
                <td>
                  <?php buildSelect('brand','brand_id','id','brand_name');?>
                </td>
              </tr>
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" value=""size="30" />
                    <span class="require-field">*</span></td>

                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="0" size="20" />
                    </td>
                </tr>
                <tr>
                    <td class="label">促销售价：</td>
                    <td>
                        <input type="text" name="promote_price" value="" size="20" />
                        开始时间:<input type="text"  id='at1' name="promote_start_date" value="">
                        结束时间:<input type="text" id='at2' name="promote_end_date" value="">
                    </td>
                </tr>
                 <tr>
                    <td class="label">商品图片：</td>
                    <td>
                        <input type="file" name="img" size="35" />
                    </td>
                </tr>
                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="1"/> 是
                        <input type="radio" name="is_on_sale" value="2"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否新品：</td>
                    <td>
                        <input type="radio" name="is_new" value="1"/> 是
                        <input type="radio" name="is_new" value="2"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否精品：</td>
                    <td>
                        <input type="radio" name="is_best" value="1"/> 是
                        <input type="radio" name="is_best" value="2"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否热销：</td>
                    <td>
                        <input type="radio" name="is_hot" value="1"/> 是
                        <input type="radio" name="is_hot" value="2"/> 否
                    </td>
                </tr>
                <tr>
                    <td class="label">是否推荐楼层：</td>
                    <td>
                        <input type="radio" name="is_floor" value="1"/> 是
                        <input type="radio" name="is_floor" value="2" /> 否
                    </td>
                </tr>
                <tr>
                  <td class="label">排序:</td>
                  <td><input type="text" name="sort_num" value=""></td>
                </tr>
            </table>
            <!-- 商品描述表格 -->
            <table width="90%" style="display:none;" class='tab_table' align="center">
              <tr>
                  <td>
                      <textarea name="goods_desc" id='goods_desc' cols="40" rows="3"></textarea>
                  </td>
              </tr>
            </table>
            <!-- 会员价格表格 -->
            <table width="90%" style="display:none;" class='tab_table' align="center">
              <tr>
                  <td>
                    <!-- 循环会员级别表，将会员名字，会员id 传入 -->
                    <?php foreach($memData as $k=>$m) :?>
                      <p>
                        <?php echo $m['level_name']?>
                        <!-- 将会员级别ID 存入到 会员价格数组的键中 -->
                        <input type="text" name="member_price[<?php echo $m['id'];?>]" size=8>元<br/>

                      </p>
                    <?php endforeach;?>
                  </td>
              </tr>
            </table>
            <!-- 商品属性表格 -->
            <table width="90%" style="display:none;" class='tab_table' align="center">
              <tr>
                <td>商品类型:
                  <?php buildSelect('type','type_id','id','type_name')?>
                </td>
              </tr>
              <tr>
                <td>
                  <ul id="attr_list"></ul>
                </td>
              </tr>
            </table>
            <!--商品相册表格  -->
            <table width="90%" style="display:none;" class='tab_table' align="center">
             <tr>
               <td>
                 <input type="button" id="btn_add_pic"  value="添加一张">
                 <hr>
                 <ul id="ul_pic_list"> </ul>
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
<!--引入在线编辑器需要的 js css等  -->
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

//为5个表格编写 js效果
$(function(){
  // 先为 5个切换标签绑定点击事件
  $('#tabbar-div p span').on('click',function () {
      //隐藏所有的table表
       $('.tab_table').hide();
      //  获得点击的标签下标（点的是第几个标签）
       var i=$(this).index();
      //  显示第 i 个table表
        $('.tab_table').eq(i).show();
        // 取消原按钮的选中状态
        $('.tab-front').removeClass('tab-front').addClass('tab-back');
        // 为选中的按钮添加状态
        $(this).removeClass('tab-back').addClass('tab-front');
  });
});
// 设置促销商品 时间插件
$.timepicker.setDefaults($.timepicker.regional['zh-CN']);
$("#at1").datepicker({ dateFormat: "yy-mm-dd" });
$("#at2").datepicker({ dateFormat: "yy-mm-dd" });

//-----------实现添加商品相册
$(function(){
  $('#btn_add_pic').on('click',function () {
    var file='<li><input type="file" name="pic[]" /></li>';
    $('#ul_pic_list').append(file);
  });
});
// --------------实现添加扩展分类-------
$(function(){
  $('#btn_add_cat').click(function () {
    $('#add_select').append($('#add_select').find('select').eq('0').clone());
  });
});
// --------------编写 ajax 实现添加商品属性---------
// 为下拉框绑定一个change事件
$('select[name=type_id]').change(function(){
  // 获取当前选中的类型的id
   var typeId=$(this).val();
  //  若果选择了一个类型，即typeId >0 才执行ajax请求
  if(typeId > 0){
  //  根据类型id执行ajax取出这个类型下的属性，并返回json数据
  $.ajax({
    type:'GET',
    url:"<?php echo U('ajaxGetAttr','',FALSE);?>/type_id/"+typeId,
    dataType:'json',
    success:function(data){
    //  ----把服务器返回的属性循环拼成一个html字符串-------
    var li="";
     $(data).each(function(k,v){
       li+="<li>";
      //  如果这个属性类型是可选的，就有一个+
      if(v.attr_type=='可选')
        li+="<a href='#' onclick='addNewAttr(this)' >[+]</a>";
        // 属性名称
        li+=v.attr_name+":";
        if(v.attr_option_values=="")
        {
            li+="<input type='text' name='attr_value["+v.id+"][]' />";
            }else
            {
              li+="<select name='attr_value["+v.id+"][]'><option value=''>请选择</option>";
              // 把可选值转化为数组
              var _attr=v.attr_option_values.split(',');
              // 循环每个值，制作option
              for (var i = 0; i < _attr.length; i++) {
                li+='<option value="'+_attr[i]+'">';
                li+=_attr[i];
                li+="</option>";
              }
              li+="</select>";
            }

       li+="</li>";
     });
    // 把拼好的li放入 ul标签中
    $('#attr_list').html(li);
    }
  });
}else{
  $('#attr_list').html("");
}
});
// 为商品属性的 + 号添加一个点击事件
function addNewAttr(a) {
  var li=$(a).parent();
  if($(a).text()=='[+]'){
    var newli=li.clone();
    newli.find('a').text('[-]');
    // 把新的li 放在后面
    li.after(newli);
  }else{
    li.remove();
  }

}
</script>

<div id="footer">
版权自己<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>