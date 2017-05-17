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

<form method="post" action="" name="listForm">
    <div class="list-div" id="listDiv">
        <table width="100%" cellspacing="1" cellpadding="2" id="list-table">
            <tr>
                <th>分类名称</th>
                <th>操作</th>
            </tr>
            <?php if(is_array($data)): foreach($data as $key=>$v): ?><tr align="center" class="0">
                <td align="left" class="first-cell" ><?php echo (str_repeat("--",$v['level']*4)); echo ($v['cat_name']); ?> </td>
                <td width="30%" align="center">
                <a href="/shangcheng/index.php/Admin/Category/edit/id/<?php echo ($v['id']); ?>">编辑</a> |
                <a href="/shangcheng/index.php/Admin/Category/delete/id/<?php echo ($v['id']); ?>" title="移除" onclick="return confirm('当前操作会删除子分类\n\r确认删除吗？')">移除</a>
                </td>
            </tr><?php endforeach; endif; ?>
        </table>
    </div>
</form>

<div id="footer">
版权自己<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>