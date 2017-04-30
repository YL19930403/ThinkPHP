<?php

namespace  Admin\Controller ;

use Think\Controller ;
use Think\Log ;


class  GoodsController  extends Controller {

    //显示和处理表单
   public function add(){
       /*
        Log::record('GoodsController   Add  ', 'WARN') ;    //如果Log_level 中没有指定WARN警告的 日志， 那么我们也可以强制记录：
        Log::record('GoodsController   Add 2222 ', 'WARN', true ) ;
       //write：　实时写入任何　级别的日志
       Log::write('My  Name is  YuLiang ', 'WARN') ;
    */



        if (IS_POST) {
            $goodModel = D('goods');


//            var_dump(I('post.'));die ;
            /*
             * create方法： 接收表单数据 ,并保存到模型中 。根据模型中定义的规则    验证表单
             * 第一参数 ： 要接收的数据，默认是$_POST
             * 第二个参数：表单的类型，当前是添加还是修改的表单 ， 1：添加   2：修改
             * $_POST:表单中原始的数据，I('post.') ： 过滤之后的$_POST数据，过滤XSS攻击
             * */
            //create方法默认会接受表单中所有的字段，如果用户伪造表单可能会接收到一些不该接收的字段
            //解决办法： 在模型中定义create方法允许接收的字段

            /*
             * 在TP中接收用户的数据必须使用I函数接收：
             * $GET['name'] = I('get.name')
             * $_POST['name']   = I('post.name')
             * $_POST   = I('post')
             * */
            if ($goodModel->create(I('post.', 1))) {

                if ($goodModel->add()) {
                    $this->success('操作成功', U('lst'));
                    exit;
                }
            }
            $error = $goodModel->getError() ;
            $this->error($error);
        }
        //查找出brand表中所有的品牌
       $brandAll =  $this->getBrandAll();

       //查找出所有的分类
       $catModel = D('category');
       $catData = $catModel->getTree();


       //取出所有的会员级别
        $mModel = D('MemberLevel');
        $memberList =  $mModel->getMemberList() ;

       $this->assign([
           'catData'            => $catData ,
           'memberList'         =>  $memberList,
           'brandAll'           =>  $brandAll,
           '_page_btn_link'    =>  U('goods/lst'),
           '_page_btn_name'    =>  '商品列表'  ,
           '_page_title'       =>  '添加商品',
       ]);
        $this->display() ;
   }

    public function edit(){
        $goodModel = D('Goods');
        $brandModel = D('Brand');
        $id = I('get.id');

        //查询出数据
        $data = $goodModel->where(array('id'=>$id))->find() ;
//        var_dump($data);die();
        // 根据$data 中的brand_id  去查找Brand表中的brand_name
//        $brand_id = $data['brand_id'];
//        $brand = $this->getBrandNameBy($brand_id);

        if (IS_POST) {
//            var_dump(I('post.'));die();
            if ($goodModel->create(I('post.'), 2)) {

                if (FALSE !==  $goodModel->save() ) {     //    0也是成功，只有FALSE才是失败

                    $this->success('操作成功', U('lst'));
                    exit;
                }
            }
            $error = $goodModel->getError() ;
//            var_dump($error);die();
            $this->error($error);
        }

        //查找出brand表中所有的品牌
        $brandAll =  $this->getBrandAll();
        //查找出Category 中的数据
         $catModel =  D('Category');
         $catAll  = $catModel->getTree() ;


        $this->assign('data', $data);
        $this->assign([
            'catAll'                =>  $catAll ,
            'brandAll'              =>  $brandAll ,
            '_page_btn_link'    =>  U('goods/lst'),
            '_page_btn_name'    =>  '品牌列表'  ,
            '_page_title'       =>  '编辑品牌',
        ]);
        $this->display() ;
    }


 //商品列表页
   public function lst(){
        $goodsModel =    D('Goods') ;
        $bModel = D('Brand');
       //搜索、分页、排序
       $data = $goodsModel->search();
//       var_dump($data);die();

         $this->assign($data);

       //查询出所有的Brand 数据
       $brandAll = $bModel->getAll();
//       var_dump($brandAll) ;die ;
       $this->assign($brandAll);

       $catModel = D('category');
       $catData = $catModel->getTree();

       $this->assign([
           'catData'            =>  $catData,
           '_page_btn_link'    =>  U('goods/add'),
           '_page_btn_name'    =>  '添加新商品'  ,
           '_page_title'       =>  '商品列表',
       ]);
         $this->display() ;
   }

   //删除商品
    public function delete(){
           $id =  I('get.id');

            //通过模型去删除
         $goodsModel = D('goods');
            $sql = 'update tp_goods '
                    . ' set is_delete = \'是\'   '
                    . ' where id = '.$id.' ' ;
          $res =  $goodsModel->execute($sql) ;


        if($res){

                $data = [
                    'status' => 0 ,
                    'msg'    => '删除成功'
                ];
            echo      json_encode($data) ;
        }else{
            $data = [
                'status' => 1 ,
                'msg'    => '删除失败'
            ];
            echo      json_encode($data) ;
        }
    }


    /*
     * 获取所有的brand_name
     * */
    public  function getBrandAll(){
        $brandModel = D('Brand');
        $brands = $brandModel->where('is_delete = 0')->field('id,brand_name')->select() ;
        return $brands ;
    }

    /*
     *  根据brand_id 获取某个品牌的品牌名
     * */
    public function getBrandNameBy($brand_id){
        $brandModel = D('Brand');
        $brand = $brandModel->where("id = $brand_id")->field('id, brand_name')->find() ;
        return $brand  ;
    }

    //处理获取属性的ajax请求
    public  function ajaxGetAttr(){
         $type_id =  I('get.type_id');
         $attrModel = D('Attribute');
         $attrData = $attrModel->where(['type_id'=>['eq',$type_id]])->select() ;
//         $attrData = iconv("GB2312","UTF-8",$attrData ) ;
//         $a = $attrData[0];
         echo  json_encode($attrData ,true );
    }
}



























