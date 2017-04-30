<?php

namespace  Admin\Model ;

use Think\Model ;
use  Think\Exception ;


class  MemberPriceModel extends  Model{
    protected  $insertFields = array('price','level_id', 'goods_id');
    protected  $updateFields = array('price','level_id', 'goods_id');
    protected $table = 'tp_member_price' ;




}