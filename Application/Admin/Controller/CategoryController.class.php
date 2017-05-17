<?php
namespace Admin\Controller;
use Think\Controller;

class CategoryController extends BaseController{
  public function lst(){
    $Model=D('category');
    $data=$Model->search();
    // 设置页面信息
    $this->assign(array(
			'_page_title' => '分类列表',
			'_page_btn_name' => '添加分类',
			'_page_btn_link' => U('add'),
		));
    $this->assign('data',$data);
    $this->display();
  }
  public function delete(){
    $id=I('get.id');
    $model=D('category');

    $result=$model->delete($id);
    if($resut !== false){
      $this->success("删除成功",U('lst'));
    }else{
      $error=$model->getError();
      $this->error("删除失败",$error);
    }

  }
    public function add(){
      $model=D('category');
       if(IS_POST){
         $data=I('post.');
         $rerult=$model->create($data,1);
         if($result !==false){
           if($model->add()){
              $this->success("添加成功",U('lst'));
              exit;
           }
       }
       $this->error('添加失败，原因为:'.$model->getError());
    }
      $data=$model->search();
      $this->assign(array(
        '_page_title' => '添加分类',
  			'_page_btn_name' => '分类列表',
  			'_page_btn_link' => U('lst'),
        'data'=>$data
      ));
      $this->display();
   }
    public function edit(){
      $id=I('get.id');
      $model=D('category');
      if(IS_POST){
        if($model->create(I('post.'),2)){
          $result=$model->save();
          if($result!==false){
            $this->success("修改成功",U('lst'));
            exit;
          }
        }
        $this->error('修改失败，原因为:'.$model->getError());
      }
      // 获得所有分类的信息
      $data=$model->search();
      // 取出当前分类的所有子分类
      $children=$model->getChilds($id);
      // 获得要修改的信息
      $cat=$model->find($id);
      $this->assign(array(
        '_page_title' => '编辑分类',
  			'_page_btn_name' => '分类列表',
  			'_page_btn_link' => U('lst'),
        'children'=>$children,
        'cat'=>$cat,
        'data'=>$data
      ));
      $this->display();
    }

}

 ?>
