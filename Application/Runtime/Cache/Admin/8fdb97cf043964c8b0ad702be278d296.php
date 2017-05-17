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


<div class="form-div">
    <form action="/shangcheng/index.php/Admin/Goods/list" name="searchForm" method="get">
      <p>
        <tr>
            <td class="label">商品主分类:</td>
            <?php $cat_id=I('get.cat_id')?>
            <td>
                <select name="cat_id">
                    <option value="">请选择分类：</option>
                    <?php if(is_array($catData)): foreach($catData as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>" <?php if($val['id']==$cat_id) echo "selected";?> ><?php echo (str_repeat("--",$val['level']*4)); echo ($val['cat_name']); ?></option><?php endforeach; endif; ?>
                </select>
            </td>
        </tr>
      </p>
    <p>商品品牌:
      <?php buildSelect('brand','b_id','id','brand_name',I('get.b_id'))?>
    </p>
     <p>
       商品名称:
       <input type="text" name="g_name" value="<?php echo I('get.g_name')?>" size="42">
     </p>
     <p>
       商品价格:
       <input type="text" name="g_price1" value="<?php echo I('get.g_price1')?>">
       <input type="text" name="g_price2" value="<?php echo I('get.g_price2')?>">
     </p>
    <p>
      是否上架:
      <?php $is_on=I('get.is_on')?>
      <input type="radio" name="is_on" value="" <?php if($is_on=='')echo "checked"?> >全部
      <input type="radio" name="is_on" value="1" <?php if($is_on=='1')echo "checked"?> >是
      <input type="radio" name="is_on" value="2" <?php if($is_on=='2')echo "checked"?>>否
    </p>
    <p>
      上架时间:
      <input type="text" name="add_t1" id='at1' value="<?php echo I('get.add_t1')?>">
      <input type="text" name="add_t2" id='at2' value="<?php echo I('get.add_t2')?>">
    </p>
    <p>
      <!-- <?php $orderby=I('get.orderby','id_desc')?> -->
       <input type="radio" onclick="this.parentNode.parentNode.submit()" name="orderby" value="id_asc"<?php if($orderby=='id_asc')echo 'checked'?>>按时间升序
       <input type="radio" onclick="this.parentNode.parentNode.submit()" name="orderby" value="id_desc"<?php if($orderby=='id_desc')echo 'checked'?>>按时间降序
       <input type="radio" onclick="this.parentNode.parentNode.submit()" name="orderby" value="pri_asc"<?php if($orderby=='pri_asc')echo 'checked'?>>按价格升序
       <input type="radio" onclick="this.parentNode.parentNode.submit()" name="orderby" value="pri_desc"<?php if($orderby=='pri_desc')echo 'checked'?>>按价格降序
    </p>
    <input type="submit" name="" value="搜索">
    <input type="reset" name="" value="重制">
    </form>

</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>商品分类</th>
                <th>扩展分类</th>
                <th>商品品牌</th>
                <th>商品名称</th>
                <!-- <th>货号</th> -->
                <th>市场价格</th>
                <th>本店价格</th>
                <th>是否上架</th>
                <th>商品描述</th>
                <th>商品图片</th>
                <th>上架时间</th>
                <!-- <th>精品</th>
                <th>新品</th>
                <th>热销</th> -->
                <!-- <th>推荐排序</th> -->
                <!-- <th>库存</th> -->
                <th>操作</th>
            </tr>
            <?php if(is_array($data)): foreach($data as $key=>$val): ?><tr class='setcolor'>
                <td align="center"><?php echo ($val["id"]); ?></td>
                <td align="center"><?php echo ($val["cat_name"]); ?></td>
                <td align="center"><?php echo ($val["ext_cat_name"]); ?></td>
                <td align="center"><?php echo ($val["brand_name"]); ?></td>
                <td align="center" class="first-cell"><span><?php echo ($val["goods_name"]); ?></span></td>
                <td align="center"><span><?php echo ($val["market_price"]); ?></span></td>
                <td align="center"><span><?php echo ($val["shop_price"]); ?></span></td>
                <td align="center"><?php echo ($val["is_on_sale"]); ?></td>
                <!-- <td align="center"><img src="<?php if(($val["is_best"] == 1)): ?>/shangcheng/Public/Admin/Images/yes.gif <?php else: ?> /shangcheng/Public/Admin/Images/no.gif<?php endif; ?>"/></td> -->
                <!-- <td align="center"><img src="<?php if(($val["is_new"] == 1)): ?>/shangcheng/Public/Admin/Images/yes.gif <?php else: ?> /shangcheng/Public/Admin/Images/no.gif<?php endif; ?>"/></td> -->
                <!-- <td align="center"><img src="<?php if(($val["is_hot"] == 1)): ?>/shangcheng/Public/Admin/Images/yes.gif <?php else: ?> /shangcheng/Public/Admin/Images/no.gif<?php endif; ?>"/></td> -->
                <td align="center" ><span ><?php echo ($val["goods_desc"]); ?></span></td>
                <td align="center"><span><img src="/shangcheng/Public/Uploads/<?php echo ($val[sm_img]); ?>"</span></td>
                <td align="center"><span><?php echo ($val["addtime"]); ?></span></td>
                <!-- <td align="center"><span><<?php echo ($val["goods_number"]); ?>></span></td> -->
                <td align="center">
                <a href="/shangcheng/index.php/Admin/Goods/goods_num?id=<?php echo ($val['id']); ?>" title="查看">库存量</a>
                <a href="/shangcheng/index.php/Goods/?goods_id=<<?php echo ($val["goods_id"]); ?>>" target="_blank" title="查看"><img src="/shangcheng/Public/Admin/Images/icon_view.gif" width="16" height="16" border="0" /></a>
                <a href="/shangcheng/index.php/Admin/Goods/edit?id=<?php echo ($val["id"]); ?>" title="编辑"><img src="/shangcheng/Public/Admin/Images/icon_edit.gif" width="16" height="16" border="0" /></a>
                <a href="/shangcheng/index.php/Admin/Goods/delete?id=<?php echo ($val["id"]); ?>" onclick="return confirm('确认删除吗?')" title="回收站"><img src="/shangcheng/Public/Admin/Images/icon_trash.gif" width="16" height="16" border="0" /></a></td>
            </tr><?php endforeach; endif; ?>
        </table>

    <!-- 分页开始 -->
        <table id="page-table" cellspacing="0">
            <tr>
                <td width="80%">&nbsp;</td>
                <td align="center" nowrap="true">
                    <?php echo ($show); ?>
                </td>
            </tr>
        </table>
    <!-- 分页结束 -->
    </div>
</form>
<script type="text/javascript" src="/shangcheng/Public/umeditor/third-party/jquery.min.js"></script>
<link href="/shangcheng/Public/datetimepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" charset="utf-8" src="/shangcheng/Public/datetimepicker/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/shangcheng/Public/datetimepicker/datepicker-zh_cn.js"></script>
<link rel="stylesheet" media="all" type="text/css" href="/shangcheng/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.css" />
<script type="text/javascript" src="/shangcheng/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.js"></script>
<script type="text/javascript" src="/shangcheng/Public/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>



<!-- 设置搜索时间插件 -->
<script type="text/javascript">
$.timepicker.setDefaults($.timepicker.regional['zh-CN']);
$("#at1").datepicker({ dateFormat: "yy-mm-dd" });
$("#at2").datepicker({ dateFormat: "yy-mm-dd" });

// 编辑js设置 鼠标放在列表栏 实现变色
$(function(){
   $('.setcolor').on('mouseover',function () {
      $(this).find('td').css('backgroundColor','#DEE7F5');
   });
   $('.setcolor').on('mouseout',function () {
     $(this).find('td').css('backgroundColor','#FFF');
   });
});
</script>

<div id="footer">
版权自己<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>