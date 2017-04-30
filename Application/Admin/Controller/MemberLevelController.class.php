<?php

namespace  Admin\Controller ;

use Think\Controller ;


class  MemberLevelController  extends  Controller{

    public function add(){
        $mlModel = D('MemberLevel');

        if(IS_POST){
            if($mlModel->create(I('post.') , 1)){

                if($mlModel->add()){
                    $this->success('操作成功',U('lst'));
                    exit() ;
                }
            }

            $error = $mlModel->getError() ;
            $this->error($error);
        }

        $this->display() ;

    }

    public function lst(){
        $mModel =  D('MemberLevel') ;
        $data =  $mModel->getMemberList() ;

        $this->assign('data',$data);
        $this->display();

    }


    public function delete(){
         $mModel =  D('MemberLevel');
         $member_id =    I('get.id');
         $param['is_delete'] = 1 ;
         $res = $mModel->where("id = $member_id")->save($param);
         if($res){
                    $data = [
                        'status' => 0 ,
                        'msg'    => '删除成功' ,
                    ];
             echo  json_encode($data,true ) ;
         }else{
                    $data = [
                        'status'    =>  1 ,
                        'msg'       =>  '删除失败' ,
                    ];
             echo json_encode($data,true ) ;
         }
    }

}