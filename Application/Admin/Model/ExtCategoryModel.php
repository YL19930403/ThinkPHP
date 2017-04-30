<?php

namespace  Admin\Model ;

use Think\Cache\Driver\File;
use Think\Model ;
use  Think\Page ;

class ExtCategoryModel extends  Model{
    //crate允许接收的字段

    protected  $insertFields = array('cat_id','goods_id');
    protected  $updateFields =   array('cat_id','goods_id') ;
    protected  $table = 'tp_extend_category' ;

}