<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>管理中心 - 商品列表 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
    <!-- 引入时间插件 -->
    <link href="/Public/datetimepicker/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" charset="utf-8" src="/Public/datetimepicker/jquery-ui-1.9.2.custom.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/datetimepicker/datepicker-zh_cn.js"></script>
    <link rel="stylesheet" media="all" type="text/css" href="/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.css" />
    <script type="text/javascript" src="/Public/datetimepicker/time/jquery-ui-timepicker-addon.min.js"></script>
    <script type="text/javascript" src="/Public/datetimepicker/time/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>

<!--引入vue.js-->
    <script type="text/javascript" src="/Public/Vue/vue.js"></script>


</head>
<body>
<h1>
	<?php if($_page_btn_name): ?>
    <span class="action-span"><a href="<?php echo $_page_btn_link; ?>"><?php echo $_page_btn_name; ?></a></span>
    <?php endif; ?>
    <span class="action-span1"><a href="#">管理中心</a></span>
    <span id="search_id" class="action-span1"> - <?php echo $_page_title; ?> </span>
    <div style="clear:both"></div>
</h1>

<!--  内容  -->


<div class="main-div">
    <form name="main_form" method="POST" action="/index.php/Admin/Category/edit/id/1.html">
    	<input type="hidden" name="id" value="<?php echo $data['id']; ?>" />
        <table cellspacing="1" cellpadding="3" width="100%">
        	<tr>
                <td class="label">上级分类：</td>
                <td>
                    <select name="parent_id">
                    	<option value="0">顶级分类</option>
                    	<?php foreach ($catData as $k => $v): if($v['id'] == $data['id'] || in_array($v['id'], $children)) continue ; if($v['id'] == $data['parent_id']) $select = 'selected="selected"'; else $select = ''; ?>
                    	<option <?php echo $select; ?> value="<?php echo $v['id']; ?>"><?php echo str_repeat('-', 8*$v['level']) . $v['cat_name']; ?></option>
                    	<?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="label">分类名称：</td>
                <td>
                    <input size="60" type="text" name="cat_name" value="<?php echo $data['cat_name']; ?>" />
                </td>
            </tr>
            <tr>
                <td colspan="99" align="center">
                    <input type="submit" class="button" value=" 确定 " />
                    <input type="reset" class="button" value=" 重置 " />
                </td>
            </tr>
        </table>
    </form>
</div>


<script>
</script>

<div id="footer"> 我的TP商城</div>
</body>
</html>