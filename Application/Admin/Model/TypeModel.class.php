<?php

namespace  Admin\Model ;

use Think\Model;

class TypeModel  extends Model {
    protected $insertFields = ['type_name'];
    protected $updateFields = ['id','type_name'];

    protected $table = 'tp_type' ;

    protected  $_validate = [
        ['type_name', 'require','类型名称不能为空',1, 'regex',3],
        ['type_name','1,30','类型名称的值最长不能超过30个字符！',1,'length',3],
        ['type_name','','类型名称已存在',1,'unique',3],
    ];

    public function  search($pagesize = 20){
        $where = [] ;
        $count = $this->alias('a')->where($where)->count();

        $page = new \Think\Page($count,$pagesize) ;
        //配置翻页的样式
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');

        $data['page'] = $page->show() ;

        $data['data'] = $this->alias('a')->where($where)->group('a.id')->limit($page->firstRow . ',' . $page->listRows)->select() ;

        return $data ;

    }


    public function  _before_insert(&$data, $option){

    }


    public  function _before_update(&$data, $option){

    }

    public  function _before_delete($option){
        $attrModel =  D('Type');
        $attrModel->where(['type_id' => ['eq', $option['where']['id']]])->delete() ;
    }

}