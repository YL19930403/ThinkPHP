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

<body>

<style>
    #cat_list {background:#EEEEEE ;}
    #cat_list li{margin: 5px ;}
</style>


<div class="tab-div">
    <div id="tabbar-div">
        <p>
            <span class="tab-front" >通用信息</span>
            <span class="tab-back" >会员价格</span>
            <span class="tab-back" >商品描述</span>
            <span class="tab-back" >商品属性</span>
            <span class="tab-back" >商品相册</span>
        </p>
    </div>



    <div id="tabbody-div">
        <form enctype="multipart/form-data" action="/index.php/Admin/goods/add.html" method="post">



            <table width="90%" id="general-table" align="center">
                <tr>
                    <td class="label">主分类</td>
                    <td>
                        <select name="cat_id">
                            <option value="">--请选择--</option>
                            <?php  foreach($catData as $k=>$v) :?>
                            <option value="<?php  echo $v['id'] ;?>">  <?php  echo str_repeat('-',8*$v['cat_level']) . $v['cat_name'] ;?></option>
                            <?php  endforeach ;?>
                        </select>
                    </td>
                </tr>


                <tr >
                    <td class="label" >扩展分类  <input  onclick="$('#cat_list').append($('#cat_list').find('li').eq(0).clone());" type="button"  id="btn_add_cat"  value="添加一个" /></td>
                    <td >
                        <ul id="cat_list">
                            <li>
                                <select name="ext_cat_id[]">
                                    <option value="">--请选择--</option>
                                    <?php  foreach($catData as $k=>$v) :?>
                                    <option value="<?php  echo $v['id'] ;?>">  <?php  echo str_repeat('-',8*$v['cat_level']) . $v['cat_name'] ;?></option>
                                    <?php  endforeach ;?>
                                </select>
                            </li>
                        </ul>
                    </td>
                </tr>

                <tr>
                    <td class="label">商品品牌：</td>
                    <td>
                        <select name="brand_id" >
                            <option name="" value="">--请选择--</option>
                            <?php if(is_array($brandAll)): foreach($brandAll as $key=>$vo): ?><option name="brand_id" value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["brand_name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                    </td>
                </tr>

                <tr><td></td></tr>
            </table>


            <!--商品描述-->
            <table width="90%" class="tab_table" align="center">
                <tr>
                    <td class="label">商品描述：</td>
                    <td>
                        <textarea id="goods_desc" name="goods_desc"></textarea>
                    </td>
                </tr>
                <tr><td></td></tr>
            </table>
            <!--会员价格-->
            <table  width="90%" class="tab_table" align="center">
                <tr>
                    <td  class="label">会员价格</td>
                    <td>
                        <?php foreach ($memberList as $k=>$v):?>
                        <?php echo $v['level_name']; ?> : ￥<input  type="text" name="member_price[<?php echo $v['id'] ;?>]"  size="8"/> <br/>
                        <?php endforeach ; ?>
                    </td>

                </tr>
                <tr><td></td></tr>
            </table>
            <!--商品属性-->
            <table  width="90%" class="tab_table" align="center">
                <tr>
                    <td class="label">商品名称：</td>
                    <td><input type="text" name="goods_name" size="60" />
                        <span class="require-field">*</span></td>
                </tr>

                <tr>
                    <td class="label">市场售价：</td>
                    <td>
                        <input type="text" name="market_price" value="0" size="20" />
                        <span class="require-field">*</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">本店售价：</td>
                    <td>
                        <input type="text" name="shop_price" value="0" size="20"/>
                        <span class="require-field">*</span>
                    </td>
                </tr>


                <tr>
                    <td class="label">是否上架：</td>
                    <td>
                        <input type="radio" name="is_on_sale" value="是" checked="checked" /> 是
                        <input type="radio" name="is_on_sale" value="否" /> 否
                    </td>
                </tr>
                <tr><td></td></tr>
            </table>
            <!--商品相册-->
            <table  width="90%" class="tab_table" align="center">
                <tr>
                    <td class="label">LOGO：</td>
                    <td><input type="file" name="logo" size="60" /></td>
                </tr>
                <tr><td class="label" >
                        商品类型：<?php  buildSelect('Type','type_id','id','type_name') ;?>
                </td></tr>

                <tr><td>
                    <ul id="attr_list"></ul>
                </td></tr>
            </table>

            <div class="button-div">
                <input type="submit" value=" 确定 " class="button"/>
                <input type="reset" value=" 重置 " class="button" />
            </div>


        </form>
    </div>
</div>

<div id="footer">
共执行 9 个查询，用时 0.025161 秒，Gzip 已禁用，内存占用 3.258 MB<br />
<a href="http://blog.sina.com.cn/yuliangdeweibo" target="_blank">个人博客</a>
</div>
</body>
</html>

<!--导入在线编辑器 -->
<link href="/Public/umeditor1_2_2-utf8-php/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/Public/umeditor1_2_2-utf8-php/third-party/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/umeditor1_2_2-utf8-php/umeditor.min.js"></script>
<script>
UM.getEditor('goods_desc', {
	initialFrameWidth : "100%",
	initialFrameHeight : 350
});


    $('#tabbar-div p span').click(function(){
         var i = $(this).index() ;
        $(".tab_table").hide();
        $(".tab_table").eq(i).show() ;
        //隐藏其他4 个
//        $(".tab_table").eq(i).siblings().hide();
        //样式切换
        $(".tab-front").removeClass("tab-front").addClass("tab-back") ;
        $(this).removeClass("tab-back").addClass("tab-front") ;
    });
</script>


<script type="text/javascript">
    <!--根据name 来获取元素-->
    $("select[name=type_id]").change(function () {
        var  type_id = $(this).val() ;
        if(type_id > 0) {
            //根据类型id 执行AJAX取出   这个类型下的属性，并获取返回的JSON数据
            $.ajax({
                type: "GET",
                url: "<?php echo U('ajaxGetAttr','',FALSE ) ;?>/type_id/" + type_id,
                dataType: "json",
                success: function (data) {

                    var li = "";
                    //吧服务器返回的属性循环平成一个html 字符串，并显示在页面中
                    $(data).each(function (k, v) {

                        li += '<li>';
                        //如果属性的类型为可选的，那么就在前面评一个 "+"
                        if (v.attr_type == '可选') {
//                         li += '<a href="">[+]</a>' ;
                            li += '<a onclick="addNewAttr(this);" href="#">[+]</a>';
                            //属性名称
                            li += v.attr_name + ' ： ';
                            //如果属性有可选值就做下拉框，否则做文本框
                            if (v.attr_option_values == "") {
                                li += '<input type="text" name="attr_value['+v.id+'][]" />';
                            } else {
//                            li += '<select><option value=""> 请选择....</option>'  ;
                                li += '<select name="attr_value['+ v.id + '][]"><option value="">请选择...</option>';
                                //把可选值根据 ， 转化为数组  :  钢制脚,塑料脚,木质脚

                                var attrs = v.attr_option_values.split(",");
                                for (var i = 0; i < attrs.length; i++) {
                                    li += '<option value="' + attrs[i] + '">';
                                    li += attrs[i];
                                    li += '</option>';
                                }
                                li += '</select>';
                            }
                        }
                        li += '</li>'
                    });
                    $('#attr_list').html(li);
                }
            });
        }
        else
            $("#attr_list").html('');
    });



    <!--点击属性的 +  -->s
    function  addNewAttr(a){
        //   $(a)   将原生的dom对象 转变为  jquery对象
        var  li = $(a).parent() ;

        if($(a).text() == '[+]'){
            var  newLi = li.clone() ;

            //  +  变   -
            newLi.find("a").text('[-]');

            li.after(newLi);
        }else{

            li.remove();
        }

    }
</script>




























<div id="footer"> 我的TP商城</div>
</body>
</html>