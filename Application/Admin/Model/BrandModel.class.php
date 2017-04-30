<?php

namespace  Admin\Model ;

use Think\Cache\Driver\File;
use Think\Model ;
use  Think\Page ;

class BrandModel extends  Model{
    //crate允许接收的字段

    protected  $insertFields = array('brand_name','site_url');
    protected  $updateFields =   array('id','brand_name','site_url') ;
    protected  $table = 'brand' ;
    protected  $_validate =  array(
        array('brand_name','require','品牌名称不能为空',1, 'regex', 3),      // 1 代表必须验证, 2 代表传了就验证
        array('brand_name', '1,30', '品牌名称的值最长不能超过 30 个字符！', 1, 'length', 3),
        array('site_url','1,150','官方网址最长不能超过150个字符',2, 'length',3),
    ) ;




    public function search(){
        $brandModel =  D('Brand');
        //搜索
        $where=[];
        $bn = I('get.brand_name');
        if($bn)
            $where['brand_name'] = ['like', "%$bn%"];

        $bfa = I('get.bfa');
        $bta = I('get.bta');
        if($bfa && $bta)
            $where['create_time'] = ['between', [$bfa, $bta]];
        elseif ($bfa)
            $where['create_time'] = ['egt', $bfa];
        elseif ($bta)
            $where['create_time'] = ['lgt',$bta];


        //排序
        $orderway = 'desc'  ;   //默认的排序方式
        $orderby = I('get.odby');
        if($orderby == "time_desc")
            $orderway = 'desc';
        elseif ($orderby == "time_asc")
            $orderway = "asc" ;




        $count = $brandModel->where(array('is_delete'=>0))->count();
        $Page = new  Page($count, 4);

        $Page->setConfig('next', '下一页') ;
        $Page->setConfig('prev', '上一页') ;
        $show = $Page->show() ;

        $data = $brandModel->where('is_delete = 0')->where($where)->order("create_time  $orderway")->limit($Page->firstRow, $Page->listRows)->select() ;

        return  array(
            'data' => $data ,
            'page' => $show
        );
    }

    /*
     * 通过brand  id  获取该条记录的字段信息
     * @param    $id    :   brand 表中的id
     * */
    public function getBrandInfo($id){
        $brandModel = D('Brand');
//        $map['id'] = $id ;
//        $map['is_delete']  = 0 ;
//        $data = $brandModel->where($map)->select();

        $sql = "select b.id, b.brand_name , b.site_url, b.logo, b.create_time from"
                . " tp_brand b where id={$id} and is_delete = 0 " ;
        $data = $brandModel->query($sql) ;

//        var_dump($data);die();
        return $data[0] ;
    }

    /*
     *   钩子方法
     *  @param   &$data   :  表单中要插入到数据库中的数据（按引用传递）
    */
    //该方法会在模型插入数据到数据表之前调用
    protected  function _before_insert(&$data,$options){
//        var_dump($_FILES['logo']); die();

        $data =  $this->uploadImage($data) ;
    }

//查询出Brand数据表的所有的数据
    public  function getAll(){
        $data = $this->where('is_delete = 0')->field('id,brand_name')->select() ;
        return $data ;
}


    //该方法在模型插入数据成功之后调用
//    protected function _after_insert($data,$options){
//    }
//
    protected function _before_update(&$data,$options){
        $data = $this->uploadImage($data) ;
    }
//
//    protected function _after_update($data,$options){
//    }
//
//    protected function _before_delete(&$data,$options){
//    }
//
//    protected function _after_delete($data,$options){
//    }

    /*
     *  根据brand_id 更新相应的字段
     *  @param   $brand_id  :    品牌编码
     *  @param   $column1   :   需要被更新的字段1
     *  @param   $column2   :    需要被更新的字段2
     * */
    public function updateBy($brand_id,$column1="" , $column2=""){
         $brandModel = D('Brand');
        $sql =  ' update  tp_brand set'
            . ' '.$column1.' = 1 , '.$column2.' = now()  where id = '.$brand_id.' ' ;
        $res = $brandModel->execute($sql) ;
        return $res ;
    }

    //判断图片上传的逻辑
    public  function  uploadImage($data){
        if ($_FILES['logo']['error'] == 0){
//            die("aaa");
            $upload = new \Think\Upload();
            $upload->maxsize= 1024*1024 ;  //1M
            $upload->exts = array('jpg','gif','png','jpeg');
            $upload->rootPath = './Public/Uploads/';
            $upload->savePath = 'Brand/' ;
            //上传文件
            $info =$upload->upload() ;
            if(!$info){
                //$this->error($upload->getError());
                $this->error = $upload->getError() ;  //把错误信息放到模型中
                return false ;
            }else{
//                $this->success('上传成功');
                $logo = $info['logo']['savepath'] . $info['logo']['savename'];
                $image = new \Think\Image() ;
                //打开要生成的缩略图
                $image->open('./Public/Uploads/'.$logo);
                //生成缩略图
                $image->thumb(700,700)->save('./Public/Uploads/'.$logo);

                //插入到数据库
                $data['logo'] = $logo ;
                return $data ;
            }
        }
    }

}