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

<div class="main-div">
    <form action="/shangcheng/index.php/Admin/Category/add" method="post" name="theForm" enctype="multipart/form-data">
        <table width="100%" id="general-table">
            <tr>
                <td class="label">分类名称:</td>
                <td>
                    <input type='text' name='cat_name' maxlength="20" value='' size='27' /> <font color="red">*</font>
                </td>
            </tr>
            <tr>
                <td class="label">上级分类:</td>
                <td>
                    <select name="parent_id">
                        <option value="0">顶级分类</option>
                        <?php if(is_array($data)): foreach($data as $key=>$val): ?><option value="<?php echo ($val["id"]); ?>" ><?php echo (str_repeat("--",$val['level']*4)); echo ($val['cat_name']); ?></option><?php endforeach; endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">是否推荐楼层：</td>
                <td>
                    <input type="radio" name="is_floor" value="1"  /> 是
                    <input type="radio" name="is_floor" value="2"  /> 否
                </td>
            </tr>
        </table>
        <div class="button-div">
            <input type="submit" value=" 确定 " />
            <input type="reset" value=" 重置 " />
        </div>
    </form>
</div>

<div id="footer">
版权自己<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>