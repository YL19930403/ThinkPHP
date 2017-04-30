<?php

namespace  Admin\Model ;

use Think\Model ;
use  Think\Exception ;


class  MemberLevelModel extends  Model{
    protected  $insertFields = array('id','level_name', 'bottom', 'top');
    protected  $updateFields = array('id', 'level_name', 'bottom', 'top');
    protected $table = 'tp_member_level' ;

    protected  $_validate =  array(
        array('level_name', 'require','级别名称不能为空' , 1, 'regex',3),
        array('level_name', '1,30','级别名称的值態超过30个字符',1, 'length',3),
        array('bottom', 'require', '积分下限不能为空',1,'regex',3),
        array('bottom', 'number', '积分下限必须是一个整数',1,'regex',3),
        array('top', 'require', '积分上限不能为空',1,'regex',3),
        array('top', 'number', '积分上限必须为一个整数',1,'regex',3),
    ) ;

    protected  function _before_insert(&$data,$options){

    }

    protected  function _after_insert($data,$options){

    }

    protected function _before_update(&$data,$options){

    }

    protected function _after_update($data,$options){

    }



    public  function getMemberList(){
        $mModel = D('MemberLevel');
        $data =$mModel->where('is_delete = 0')
                ->field('id, level_name, bottom, top')
                ->select();
        return $data ;
    }
}