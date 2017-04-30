<?php

namespace  Admin\Model ;


use Think\Model ;
use  Think\Page ;

class GoodsModel extends  Model{
    //crate允许接收的字段
    protected  $insertFields = 'goods_name,market_price,shop_price,is_on_sale,goods_desc,brand_id,cat_id';
    protected  $updateFields = 'id,goods_name,market_price,shop_price,is_on_sale,goods_desc,brand_id,cat_id' ;

    protected  $_validate =  array(
        array('cat_id','require','商品分类不能为空',1),
        array('goods_name','require','商品名称不能为空',1),      // 1 代表必须验证
        array('market_price','currency','市场价格必须是货币类型',1),
        array('shop_price','currency','本店价格必须是货币类型',1),
    ) ;


    /*
     *   钩子方法
     *  @param   &$data   :  表单中要插入到数据库中的数据（按引用传递）
    */
    //该方法会在模型插入数据到数据表之前调用
    protected  function _before_insert(&$data,$options){
//        $data['create_time'] = date('Y-m-d H:i:s',time());
//        var_dump($_POST['goods_desc']);die();

        $data['goods_desc'] = removeXss($_POST['goods_desc']) ;






        //判断有没有上传图片
//        var_dump($_FILES)  ; die() ;          //html中的图片使用file格式
         //判断图片上传的逻辑
        $data =  $this->uploadImage($data);

    }


    //该方法在模型插入数据成功之后调用
    protected function _after_insert($data,$options){
         $mp =  I('post.member_price') ;
         $mpModel =  D('member_price');
         $extModel = D('extend_category');


        /************ 处理商品属性的代码 **************/
        $attr_value =  I('post.attr_value');
        $gaModel =  D('goods_attr');
        foreach($attr_value as $k=>$v ){
            $v = array_unique($v);
            foreach($v as $k1 => $v1 ){
                $gaModel->add([
                    'goods_id'  =>  $data['id'],
                    'attr_id'   =>  $k ,
                    'attr_value' => $v1 ,
                ]) ;
            }
        }

        /************ 处理扩展分类 ***************/
        $ecid = I('post.ext_cat_id');
        if($ecid)
        {
            $gcModel = D('extend_category');
            foreach ($ecid as $k => $v)
            {
                if(empty($v))
                    continue ;
                $gcModel->add(array(
                    'cat_id' => $v,
                    'goods_id' => $data['id'],
                ));
            }
        }

         foreach($mp as $k=>$v ) {

             $_v = (float)$v;
             if ($_v > 0) {
                 $mpModel->add(array(
                     'price' => $v,
                     'level_id' => $k,
                     'goods_id' => $data['id'],
                 ));
             }
         }

         $cat_ext_id  =  I('post.');
         if(!empty($cat_ext_id['ext_cat_id'])){
              $cats = $cat_ext_id['ext_cat_id'] ;
             foreach($cats as $k=> $v ){
                 $extModel->add([
                     'cat_id'   => $v  ,
                     'goods_id' => $data['id'],
                 ]) ;
             }
         }
    }

    protected function _before_update(&$data,$options){

//        var_dump($data);
//        var_dump($options);
//        die() ;
       $data['goods_desc'] = removeXss($_POST['goods_desc']) ;
//

////
////        //上传新图片
        $data = $this->uploadImage($data, $options) ;

    }

    protected function _after_update($data,$options){

    }

    protected function _before_delete(&$data,$options){

    }

    protected function _after_delete($data,$options){

    }

    //判断图片上传的逻辑
    public  function  uploadImage($data, $options){
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

                //        //获取旧图片的地址，删除旧图片，
                $logo = $this->where(array('id'=>$options['where']['id'], 'is_delete'=>"否"))->field('logo')->find() ;   // $logo['logo']
                unlink('Public'.'/'.'Uploads/'.$logo['logo']) ;

                return $data ;
            }
        }else{
            return $data ;
        }
    }

    ////搜索、分页、排序
    public function search(){
        $goodsModel = new  model('Goods');

        //**************搜索****************
        $where =  [] ;

        $brand_id = I('get.brand_id');
//        die($brand_id);
        if($brand_id){
            $where['a.brand_id'] = array('eq',$brand_id);
        }

        $gn = I('get.gn') ;
        if($gn)
            $where['a.goods_name'] = array('like', "%$gn%") ;
            $fp = I('get.fp');
            $tp = I('get.tp');

            if($fp  && $tp ){
                    $where['a.shop_price'] = array('between',array($fp, $tp )) ;
            }else if ($fp){
                $where['a.shop_price']  = array('egt',$fp) ;
            }else if ($tp){
                $where['a.shop_price']  = array('elt',$tp ) ;
            }

              //是否上架
              $ios = I('get.ios');

            if ($ios)
                $where['a.is_on_sale'] = array('eq', $ios) ;
                $fa = I('get.fa');
                $ta = I('get.ta');
                if($fa && $ta )
                    $where['a.create_time'] = array('between',[$fa, $ta ]) ;
                elseif ($fa)
                    $where['a.create_time'] = array('egt',$fa) ;
                elseif($ta)
                    $where['a.create_time'] = array('elt',$ta) ;
            //主分类
             $cat_id=  I('get.cat_id');
            if($cat_id){
                // 先查询出这个分类ID下所有的商品ID
                $gids = $this->getGoodsIdByCatId($cat_id);

                $where['a.id'] = array('IN', $gids);

            }


            //排序
            $odbyby = 'a.create_time' ;      //默认的排序字段
            $orderby = 'desc' ;     //默认的排序方式
            $odby = I('get.odby');
            if($odby) {
                if ($odby == 'time_asc')
                    $orderby = 'asc';
                elseif ($odby == 'price_desc')
                    $odbyby = 'shop_price';
                elseif ($odby == 'price_asc') {
                     $odbyby = 'shop_price';
                     $orderby = 'asc';
                   }
            }



        //**************分页*************
        // 查询满足要求的总记录数
        $count = $goodsModel->where('is_delete = "否" ')->count() ;
        //实例化分页类 传入总记录数和每页显示的记录数
        $page = new \Think\Page($count, 10) ;
        // 分页显示输出

        $page->setConfig( 'next','下一页');
        $page->setConfig( 'prev','上一页');
        $show = $page->show() ;
       $data = $goodsModel->alias('a')
                            ->where('a.is_delete = "否" ')
                            ->where($where)->order('a.create_time')
                            ->field('a.*, b.brand_name, c.cat_name , group_concat(ct.cat_name  separator "<br/>")  ext_cat_name')
                            ->join('left join tp_brand  b on  a.brand_id = b.id
                                left join __CATEGORY__  c on a.cat_id = c.id 
                                 left join  tp_extend_category ext on  ext.goods_id = a.id 
                                 left join __CATEGORY__  ct  on ct.id= ext.cat_id  ')
                            ->order("$odbyby  $orderby")
                            ->group('a.id')
                            ->limit($page->firstRow, $page->listRows)
                            ->select();

        return  array(
            'data' => $data ,
            'page' => $show
        );
    }

    /**
     * 取出一个分类下所有商品的ID[即考虑主分类也考虑了扩展分类】
     *
     * @param unknown_type $catId
     */
    public  function getGoodsIdByCatId($cat_id){
        //先取出所有子分类的ID
        $catModel = D('Category');
        $extModel = D('extend_category');
        $children =  $catModel->children($cat_id);
        // 和子分类放一起
        $children[] = $cat_id ;

        /*************** 取出主分类或者扩展分类在这些分类中的商品 ****************/
        // 取出主分类下的商品ID
        $gids = $this->field('id')
                     ->where(['cat_id' => array('in', $children)])
                     ->select();

        // 取出扩展分类下的商品的ID
        $gids1 = $extModel->field('DISTINCT goods_id id')
                 ->where(['cat_id' => array('IN',$children)])
                 ->select() ;

        if(!empty($gids)  && !empty($gids1)){
            $gids = array_merge($gids, $gids1);
        }elseif ($gids1){
            $gids = $gids1;
        }

        // 二维转一维并去重
        $id = array() ;
        foreach ($gids as $k => $v ){
            if(!in_array($v['id'] , $id )){
                $id[] = $v['id'] ;
            }
        }
        return $id ;
    }

}