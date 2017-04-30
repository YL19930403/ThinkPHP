<?php

namespace  Admin\Controller ;

use Think\Controller ;

class  CategoryController  extends Controller {
        public function lst(){
             $catModel =  D('Category');
             $data = $catModel->getTree() ;

            $this->assign([
                'data'              =>  $data ,
                '_page_btn_link'    =>  U('category/add'),
                '_page_btn_name'    =>  '添加新分类'  ,
                '_page_title'       =>  '分类列表',
            ]);
            $this->display() ;
        }



        //删除分类及下面的子分类
        public  function  delete(){
             $cat_id =   I('get.id');
             $catModel = D('Category');
             $data['is_delete'] = 1 ;
             $_SESSION['category_id'] = $cat_id ;
             $res =   $catModel->where(['id'=>$cat_id, 'is_delete'=>0])        //['id'=>$catModel, 'is_delete'=>0]
                        ->save($data);
//             var_dump($res ); die ;
            if($res ){
                $data = [
                    'status'    => 0 ,
                    'msg'       => '删除成功',
                ];
                echo json_encode($data,true ) ;
            }else{
                $data = [
                    'status'    => 1 ,
                    'msg'       => '删除失败',
                ];
                echo json_encode($data,true ) ;
            }

        }

        //添加
    public  function  add(){
        $catModel =  D('Category');
        if(IS_POST){

                if($catModel->create(I('post.'),1)){
                    if($catModel->add()){
                        $this->success('添加成功',U('lst'));
                        exit() ;
                    }
                }
                $this->error($catModel->getError());
        }

       $catData=  $catModel->getTree();

        $this->assign([
            'catData'            => $catData ,
            '_page_btn_link'    =>  U('category/lst'),
            '_page_btn_name'    =>  '分类列表'  ,
            '_page_title'       =>  '添加分类',
        ]);
        $this->display() ;
    }

    //编辑
    public  function  edit(){
         $cat_id =  I('get.id');
         $catModel = D('Category');
        if(IS_POST) {
            if ($catModel->create(I('post.'), 2)) {
                if ($catModel->save()) {
                    $this->success('修改成功', U('category/lst'));
                    exit();
                }
            }
            $this->error($catModel->getError());
        }

         $data  =  $catModel->find($cat_id);
         $catData = $catModel->getTree();
         $children = $catModel->children($cat_id);
        $this->assign( [
                    'children'  => $children,
                     'data'  => $data ,
                    'catData'   => $catData,
                ]
        );

        $this->assign('catData',$catData);
        $this->display();
    }
}



























