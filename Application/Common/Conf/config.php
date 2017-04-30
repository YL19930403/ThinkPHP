<?php
return array(
	//'配置项'=>'配置值'

    'DB_TYPE'   =>  'mysqli',        //数据库类型
    'DB_HOST'   =>  '127.0.0.1',    //服务器地址
    'DB_NAME'   =>  'test',           //数据库名
    'DB_USER'   =>  'root',         //用户名
    'DB_PWD'   =>  'yuliang123',    //密码
    'DB_PORT'   =>  '3306',         //端口
    'DB_PARAMS'   =>  array(),      //数据库连接参数
    'DB_PREFIX'   =>  'tp_',        //数据库表前缀
    'DB_CHARSET'   =>  'utf8',      //字符集
    'DB_DEBUG'   =>  TRUE ,         //数据库调试模式，开启可以记录SQL日志



//-------------------PDO---------------------
//    'DB_TYPE'   =>  'pdo',        //数据库类型
//    'DB_USER'   =>  'root',         //用户名
//    'DB_PWD'   =>  'yuliang123',    //密码
//    'DB_PORT'   =>  '3306',         //端口
//    'DB_PARAMS'   =>  array(),      //数据库连接参数
//    'DB_PREFIX'   =>  'tp_',        //数据库表前缀
//    'DB_DEBUG'   =>  TRUE ,         //数据库调试模式，开启可以记录SQL日志
//    'DB_DSN'     => 'mysql:host=localhost;dbname=test;charset=utf8' ,


//---------------------图片配置---------------------
    'IMG_CONFIG'    => [
        'maxsize'   =>  1024*1024 ,
        'exts'      =>  array('jpg','gif','png','jpeg') ,
        'rootPath'  =>       './Public/Uploads/' ,      //上传图片的保存路径，PHP 要用的路径（硬盘上的路径）
        'viewPath'  =>      '/Public/Uploads/' ,        //显示图片时的路径  ， 浏览器用的路径

    ]

);





































