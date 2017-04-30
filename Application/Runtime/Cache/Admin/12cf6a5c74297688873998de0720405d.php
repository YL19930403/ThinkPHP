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


<!-- 搜索表单 -->
<div class="form-div">
    <form action="/index.php/Admin/Goods/lst" method="GET" name="searchForm">
        <p>
            主分类：
            <?php
 $catId = I('get.cat_id'); ?>

            <select name="cat_id">
                <option value="">--请选择--</option>
                <?php  foreach($catData as $k=>$v) : if($v['id'] == $catId) $select = 'selected="selected"' ; else $select = '' ; ?>
                <option  <?php  echo $select ; ?> value="<?php  echo $v['id'] ;?>">  <?php  echo str_repeat('-',8*$v['cat_level']) . $v['cat_name'] ;?></option>
                <?php  endforeach ;?>
            </select>
        </p>
        <p>
            品牌：
              <?php  buildSelect('brand', 'brand_id','id','brand_name') ; ?>
        </p>
		<P>
			商品名称：
			<input value="<?php echo I('get.gn'); ?>" type="text" name="gn" size="60" />
		</P>
		<P>
			价　　格：
			从<input value="<?php echo I('get.fp'); ?>" type="text" name="fp" size="8" />
			到 <input value="<?php echo I('get.tp'); ?>" type="text" name="tp" size="8" />
		</P>
		<P>
			是否上架：
			<?php $ios = I('get.ios'); ?>
			<input type="radio" name="ios" value="" <?php if($ios == '') echo 'checked="checked"'; ?> /> 全部
			<input type="radio" name="ios" value="是" <?php if($ios == '是') echo 'checked="checked"'; ?> /> 上架
			<input type="radio" name="ios" value="否" <?php if($ios == '否') echo 'checked="checked"'; ?> /> 下架
		</P>
		<P>
			添加时间：
			从<input type="text" id="fa" name="fa" value="<?php echo I('get.fa'); ?>" size="20" />
			到 <input type="text" id="ta" name="ta" value="<?php echo I('get.ta'); ?>" size="20" />
		</P>
		<p>
			排序方式：
			<?php $obdy = I('get.odby', 'time_desc'); ?>
			<input onclick="this.parentNode.parentNode.submit();" type="radio" name="odby" value="time_desc" <?php if($obdy == 'time_desc') echo 'checked="checked"'; ?> /> 以添加时间降序
			<input onclick="this.parentNode.parentNode.submit();" type="radio" name="odby" value="time_asc" <?php if($obdy == 'time_asc') echo 'checked="checked"'; ?> /> 以添加时间升序
			<input onclick="this.parentNode.parentNode.submit();" type="radio" name="odby" value="price_desc" <?php if($obdy == 'price_desc') echo 'checked="checked"'; ?> /> 以价格降序
			<input onclick="this.parentNode.parentNode.submit();" type="radio" name="odby" value="price_asc" <?php if($obdy == 'price_asc') echo 'checked="checked"'; ?> /> 以价格升序
		</p>
		<P>
			<input type="submit" value="搜索" />
		</P>
    </form>
</div>

<!-- 商品列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <tr>
                <th>编号</th>
                <th>主分类</th>
                <th>扩展分类</th>
                <th>品牌名称</th>
                <th>商品名称</th>
                <th>logo</th>
                <th>市场价格</th>
                <th>本店价格</th>
                <th>上架</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
            <?php foreach ($data as $k => $v): ?>
            <tr class="tron">
                <td align="center"><?php echo $v['id']; ?></td>
                <td align="center"><?php echo $v['cat_name']; ?></td>
                <td align="center"><?php echo $v['ext_cat_name']; ?></td>
                <td align="center"><?php echo $v['brand_name']; ?></td>
                <td align="center" class="first-cell"><span><?php echo $v['goods_name']; ?></span></td>
                <td align="center"><?php  showImg($v['logo']) ;?> </td>
                <td align="center"><?php echo $v['market_price']; ?></td>
                <td align="center"><?php echo $v['shop_price']; ?></td>
                <td align="center"><?php echo $v['is_on_sale']; ?></td>
                <td align="center"><?php echo $v['create_time']; ?></td>
                <td align="center">
                	<a href=<?php echo U('edit?id='.$v['id']); ?>>修改</a>
                	<a  onclick="deleteGood(<?php echo ($v['id']); ?>)"  onclick="javascript:;">删除</a>
               </td>
            </tr>
            <?php endforeach; ?>
        </table>

    <!-- 分页开始 -->
        <table id="page-table" cellspacing="0">
            <tr>
                <td width="80%">&nbsp;</td>
                <td align="center" nowrap="true">
                    <?php echo $page ; ?>
                </td>
            </tr>
        </table>
    <!-- 分页结束 -->
    </div>
</form>


<script>
// 添加时间插件
$.timepicker.setDefaults($.timepicker.regional['zh-CN']);  // 设置使用中文

$("#fa").datetimepicker();
$("#ta").datetimepicker();
</script>
<!-- 引入行高亮显示 -->
<script type="text/javascript" src="/Public/Admin/Js/tron.js"></script>

<!--引入jquery1.8以上版本   和 layer.js   实现弹窗效果-->
<script type="text/javascript" src="/Public/layer/layer.js"></script>
<!--<script type="text/javascript" charset="utf-8" src="/Public/layer/ch-ui.admin.js"></script>-->
<script type="text/javascript" src="/Public/layer/jquery.js"></script>

<script type="text/javascript">
    function deleteGood(goods_id){

        layer.confirm('您确定要删除这件商品吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                type : "GET" ,
                url: "delete?id=" + goods_id ,
                async:true,
                dataType:"json",
                success : function(data) {
                    if(data.status == 0){
                        //删除成功
                        location.href = location.href;
                        layer.msg(data.msg, {icon: 6});
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