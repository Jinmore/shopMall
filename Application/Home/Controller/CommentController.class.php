<?php
namespace Home\Controller;
use Think\Controller;
class  CommentController extends NavController
{
  public function add()
  {

      if(IS_POST)
      {
         $comModel=D('Admin/Comment');
         if($comModel->create(I('post.'),1))
         {

           if($comModel->add())
           {
             $this->success(array(
               'face'=>session('face'),
               'addtime'=>date('Y-m-d H:i:s'),
               'content'=>I('post.content'),
               'start'=>I('post.start'),
               'username'=>session('m_username')
             ),'',true);
           }
         }
         $this->error($comModel->getError(),'',false);
      }



  }

}



 ?>
