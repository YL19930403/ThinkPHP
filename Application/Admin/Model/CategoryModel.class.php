<?php

namespace  Admin\Model ;


use Think\Model ;
use  Think\Page ;

class CategoryModel extends  Model{
    //crate允许接收的字段
    protected  $insertFields = 'id,cat_name,parent_id,shop_price,is_delete';
    protected  $updateFields = 'id,cat_name,parent_id,shop_price,is_delete' ;
    protected  $table = 'category' ;

    protected  $_validate =  array(
        array('cat_name','require','分类名称不能为空',1),
    ) ;

    /*
     *  递归：找一个分类的所有子分类
     *  @param  $cat_id     分类id
     */

    public  function children($cat_id){
        $dModel =  D('Category') ;
        $data = $dModel->where('is_delete = 0')->select() ;
        return  $this->getChildren($data,$cat_id,true ) ;
    }

    /*
     *  在传入的数据中 递归找 $cat_id
     *  @param  $data   :   要被循环的数组
     *  @param  :    $cat_id     分类id
     * */
    public  function  getChildren($data, $cat_id, $isClear=false  ){

        static $_ret = [] ;
        if($isClear)
                $_ret = [] ;
        foreach($data as $k=>$v ){
            if($v['parent_id'] == $cat_id){
                $_ret[] = $v['id'];
                //再找这个$v的子分类
                $this->getChildren($data , $v['id']) ;
            }
        }
        return $_ret ;
    }


    /*
     *
     * */
    public  function  getTree(){
            $catModel = D('Category');
            $data = $catModel->where('is_delete = 0')->select() ;
            return   $catModel->_getTree($data) ;
    }

    public  function _getTree($data, $parent_id = 0, $level=0 ){
        static $_ret = [] ;
        foreach($data as $k=>$v ){
            if($v['parent_id'] == $parent_id){
                $v['level'] =$level ;
                $_ret[] = $v;
                $this->_getTree($data, $v['id'], $level+1) ;
            }
        }
        return $_ret ;
    }




    /*
     *   钩子方法
     *  @param   &$data   :  表单中要插入到数据库中的数据（按引用传递）
    */
    //该方法会在模型插入数据到数据表之前调用
    protected  function _before_insert(&$data,$options){


    }


    //该方法在模型插入数据成功之后调用
    protected function _after_insert($data,$options){

    }

    protected function _before_update(&$data,$options){

//       var_dump($data )  ; var_dump($options) ;        //   --- ----  在调试工具中可以看到    “ 图片”  View->Category  :   before_update--options.png
            /*
                    var_dump($data )    ：
                    array(1) {
                        ["is_delete"]   => int(1)
             */



        //先找出所有子分类的id
        $catModel =  D('Category');
        $cat_id =  $_SESSION['category_id'] ;
//        var_dump($cat_id) ;die ;
        $chilren = $catModel->children($cat_id) ;
//        var_dump($chilren)  ;die ;
        if($chilren){
//            $chilrens = implode(',',$chilren);
//            var_dump($chilrens) ;die ;

            $model =  new \Think\Model() ;
            foreach($chilren as $k=>$v ){
                $d['is_delete'] = 1 ;
                //这里会产生死循环
//                $catModel->where(['id'=>$v,'is_delete'=>0])->save($d) ;
                // 如何避免 死循环呢  --   new  父类的模型，由于在父类的模型中没有钩子方法，所以不会产生死循环
                $model->table('__CATEGORY__')->where(['id'=>$v,'is_delete'=>0])->save($d) ;
            }
        }
    }

    protected function _after_update($data,$options){

    }

    protected function _before_delete(&$data,$options){

    }

    protected function _after_delete($data,$options){

    }

}