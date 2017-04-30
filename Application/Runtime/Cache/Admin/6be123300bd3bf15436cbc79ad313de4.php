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


<!-- 搜索 -->
<div class="form-div search_form_div">
    <form action="/index.php/Admin/Brand/lst" method="GET" name="search_form">
		<p>
			品牌名称：
	   		<input type="text" name="brand_name" size="30" value="<?php echo I('get.brand_name'); ?>" />
		</p>
		<p>
			添加时间：
			从<input type="text" id="bfa" name="bfa" value="<?php echo I('get.bfa'); ?>" size="20" />
			到 <input type="text" id="bta" name="bta" value="<?php echo I('get.bta'); ?>" size="20" />
		</p>
		<p>
			排序方式：
			<?php $obdy = I('get.odby', 'time_desc');?>
			<input onclick="this.parentNode.parentNode.submit();" type="radio" name="odby" value="time_desc" <?php if($obdy == 'time_desc') echo 'checked="checked"'; ?> /> 以添加时间降序
			<input onclick="this.parentNode.parentNode.submit();" type="radio" name="odby" value="time_asc" <?php if($obdy == 'time_asc') echo 'checked="checked"'; ?> /> 以添加时间升序
		</p>
		<p><input type="submit" value=" 搜索 " class="button" /></p>
    </form>

	<script>
		// 添加时间插件
		$.timepicker.setDefaults($.timepicker.regional['zh-CN']);  // 设置使用中文

		$("#bfa").datetimepicker();
		$("#bta").datetimepicker();
	</script>

</div>
<!-- 列表 -->
<div class="list-div" id="listDiv">
	<table cellpadding="3" cellspacing="1">
    	<tr>
            <th >品牌名称</th>
            <th >官方网址</th>
            <th >品牌Logo</th>
			<th >创建时间</th>
			<th width="60">操作</th>
        </tr>
		<?php foreach ($data as $k => $v): ?>            
			<tr class="tron">
				<td  align="center"><?php echo $v['brand_name']; ?></td>
				<td align="center"><?php echo $v['site_url']; ?></td>
				<td align="center"><?php showImg($v['logo'], 50); ?></td>
				<td align="center"><?php echo $v['create_time'] ?></td>
		        <td align="center">
		        	<a href="<?php echo U('edit?id='.$v['id'].'&p='.I('get.p')); ?>" title="编辑">编辑</a> |
	                <a href="jsvascript:;" onclick="deleteBrand(<?php echo ($v['id']); ?>)" title="移除">移除</a>
		        </td>
	        </tr>
        <?php endforeach; ?> 
		<?php if(preg_match('/\d/', $page)): ?>
        <tr><td align="right" nowrap="true" colspan="99" height="30"><?php echo $page; ?></td></tr>
        <?php endif; ?>
	</table>
</div>

<script>
</script>

<script src="/Public/Admin/Js/tron.js"></script>

<!--引入jquery1.8以上版本   和 layer.js   实现弹窗效果-->
<script type="text/javascript" src="/Public/layer/layer.js"></script>
<!--<script type="text/javascript" charset="utf-8" src="/Public/layer/ch-ui.admin.js"></script>-->
<script type="text/javascript" src="/Public/layer/jquery.js"></script>

<script type="text/javascript">
	  function  deleteBrand(brand_id){
		  layer.confirm('您确定要删除这个品牌吗？', {
			  btn: ['确定','取消'] //按钮
		  }, function(){
			  $.ajax({
				  type : "GET" ,
				  url: "delete?id=" + brand_id ,
				  async:true,
				  dataType:"json",
				  success : function(data) {
					  if(data.status == 0){
						  //删除成功
						  layer.msg(data.msg, {icon: 6});
						  location.href = location.href;
					  }else{
						  //删除失败
						  layer.msg(data.msg, {icon: 5});
					  }
				  }
			  });
		  }, function(){
			  //取消
		  });
	  }
</script>




















<div id="footer"> 我的TP商城</div>
</body>
</html>