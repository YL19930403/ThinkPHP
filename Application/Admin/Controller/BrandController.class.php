<?php

namespace  Admin\Controller ;

use Think\Controller ;

class  BrandController  extends Controller {
    public function add(){
        $brandModel = D('Brand');
        if(IS_POST){

            if($brandModel->create(I('post.') , 1)  ){
                
                if($brandModel->add()){
                        $this->success('添加成功', U('lst'));
                    exit() ;
                }
            }
             $error = $brandModel->getError() ;
             $this->error($error);
        }
        $this->display();
    }



    public function edit(){
        $id = I('get.id');
//        die($id);
        $brandModel = D('Brand');

//        var_dump($data);
            //提交数据

            if(IS_POST)
            {
                if($brandModel->create(I('post.'), 2))
                {
                    if($brandModel->save() !== FALSE)
                    {
                        $this->success('修改成功！', U('lst', array('p' => I('get.p', 1))));
                        exit;
                    }
                }
                $this->error($brandModel->getError());
            }

        $this->assign([
            '_page_btn_link'    =>  U('Brand/lst'),
            '_page_btn_name'    =>  '商品列表'  ,
            '_page_title'       =>  '编辑商品',
        ]);
        $data = $brandModel->getBrandInfo($id);
        $this->assign('data',$data);
        $this->display();
    }

    public function lst(){

        // M 通俗的模型 ， D 特殊化的模型
        $brandModel =  D('Brand');

        //查询数据
        $data = $brandModel->search();

        $this->assign([
            '_page_btn_link'    =>  U('Admin/Brand/add'),
            '_page_btn_name'    =>  '添加品牌'  ,
            '_page_title'       =>  '品牌列表',
        ]);

        $this->assign($data);
        $this->display();

    }

    //删除Brand
    public function  delete(){
        $brandModel =  D('Brand');
        $id = I('get.id');

        //传入需要更新的id  和 字段
       $res =  $brandModel->updateBy($id,'is_delete','delete_time');

        if($res){

            $data = [
                'status' => 0,
                'msg'    => '删除成功' ,
            ];
            echo json_encode($data, true ) ;
        }else{
            $data = [
                'status' => 1,
                'msg'    => '删除失败' ,
            ];
            echo json_decode($data, true ) ;
        }

    }
}



























