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


<!-- 列表 -->
<form method="post" action="" name="listForm" onsubmit="">
    <div class="list-div" id="listDiv">
        <table cellpadding="3" cellspacing="1">
            <div id="tabbody-div2">
                {{  message }}
            </div>

            <!--“   v-bind 将这个元素节点的 title 属性和 Vue 实例的 message 属性保持一致”-->
            <div id="tabbody-div3">
                <span v-bind:title="message"> 鼠标悬停几秒钟查看此处动态绑定的提示信息！</span>
            </div>

            <!-- Vue  条件与循环  -->
            <div id="app3">
                <p v-if="seen">管理中心</p>
            </div>

            <!--    v-for 指令可以绑定数组的数据来渲染一个项目列表  -->
            <div id="app4">
                <ol>
                    <li v-for="todo in todos">
                        {{ todo.text }}
                    </li>
                </ol>
            </div>

            <div id="app5">
                <p> {{  message }} </p>
                <button v-on:click="reverseMessage"> 逆转消息 </button>
            </div>

            <div id="app6">
                <p> {{ message  }} </p>
                <input v-model="message">
            </div>

            <div id="app7">
                <p>Original  message :"{{ message }}"</p>
                <p>Computeed reversed message : "{{ reversedMessage }}" </p>
            </div>

            <div id="app8">
                {{ fullName }}
            </div>

            <div id="app9">
                <p>
                    Ask  a  yes/no  question :
                    <input v-model="question" />
                </p>
                <p>{{ answer }}</p>
            </div>

            <tr>
                <th>分类名称</th>
                <th>操作</th>
            </tr>
            <?php foreach ($data as $k => $v): ?>
            <tr class="tron">
                <td><?php echo str_repeat('-', 8*$v['level']) . $v['cat_name']; ?></td>
                <td align="center">
                	<a href="<?php echo U('edit?id='.$v['id']); ?>">修改</a>

                    <a  onclick="deleteCategory(<?php echo ($v['id']); ?>)"  onclick="javascript:;">删除</a>
               </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</form>


<!--引入jquery1.8以上版本   和 layer.js   实现弹窗效果-->
<script type="text/javascript" src="/Public/layer/layer.js"></script>
<!--<script type="text/javascript" charset="utf-8" src="/Public/layer/ch-ui.admin.js"></script>-->
<script type="text/javascript" src="/Public/layer/jquery.js"></script>


<script type="text/javascript">
    function  deleteCategory(cat_id){
        layer.confirm('您确定要删除这件商品吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            $.ajax({
                type : "GET" ,
                url: "delete?id=" + cat_id ,
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

<!-- 引入行高亮显示 -->
<script type="text/javascript" src="/Public/Admin/Js/tron.js"></script>

<!--  Vue  -->
<script type="text/javascript">
    var app = new Vue({
        el : '#tabbody-div2',
        data:{
            message :'Hello World  --  Vue'
        }
    });

    var app2 = new Vue({
        el:'#tabbody-div3',
        data:{
            message:'页面加载于 ' + new  Date()
        }
    });

    //app3.seen = false     ;
    var app3 = new Vue({
        el:'#app3' ,
        data:{
            seen:true
        }
    });

//    在控制台里，输入 app4.todos.push({ text: '新项目' })，你会发现列表中添加了一个新项。
    var app4 = new Vue({
        el:'#app4'  ,
        data: {
            todos   :   [
                {text   :       '学习Vue'} ,
                {text   :       '学习PHP'},
                {text   :       '学习Laravel'}
            ]
        }
    });


//    用 v-on 指令绑定一个事件监听器，通过它调用我们 Vue 实例中定义的方法
    var app5 = new Vue({
        el:'#app5' ,
        data:{
            message : 'Hello Vue.js'
        },
        methods:{
            reverseMessage : function (){
                this.message = this.message.split('').reverse().join('') ;
            }
        }
    })

//   v-model  实现表单输入和应用状态之间的双向绑定
    var app6 = new Vue({
        el:'#app6',
        data:{
            message : 'Hello  Vue'
        }
    })

    //计算属性
    var vm = new Vue({
        el : '#app7' ,
        data:{
            message :'Hello'
        },
        computed:{
            reversedMessage : function(){
                return this.message.split('').reverse().join('')
            }
        }
    })

//    var vm = new Vue({
//        el:'#app8',
//        data:{
//            firstName : 'Foo' ,
//            lastName :  'Bar'
//        },
//        computed:{
//            fullName : function(){
//                return this.firstName + ' ' + this.lastName
//            }
//        }
//    })

    //给计算属性提供setter方法（计算属性默认只有getter方法）
   var vm = new Vue({
       el:'#app8' ,
       data:{
            firstName :'YULIANG'  ,
            lastName :'ACD'
       },
       computed:{
           fullName:{
               get:function(){
                   return this.firstName + ' ' + this.lastName
               },

               set:function (newValue){
                    var names = newValue.split(' ')
                   this.firstName = names[0]
                   this.lastName = names[names.length -1 ]
               }
           }
       }
   })




</script>

































<div id="footer"> 我的TP商城</div>
</body>
</html>