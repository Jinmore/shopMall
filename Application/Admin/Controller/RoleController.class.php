<?php
namespace Admin\Controller;
use Think\Controller;
class RoleController extends BaseController
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Role');
    		if($model->create(I('post.'), 1))
    		{
    			if($id = $model->add())
    			{
    				$this->success('添加成功！', U('lst?p='.I('get.p')));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
    // 创建权限模型对象 获取所有权限
    $priModel=D('privilege');
    $priData=$priModel->getTree();

		// 设置页面中的信息
		$this->assign(array(
      'priData'=>$priData,
			'_page_title' => '添加',
			'_page_btn_name' => '列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function edit()
    {
    	$id = I('get.id');
    	if(IS_POST)
    	{
    		$model = D('Role');
    		if($model->create(I('post.'), 2))
    		{
    			if($model->save() !== FALSE)
    			{
    				$this->success('修改成功！', U('lst', array('p' => I('get.p', 1))));
    				exit;
    			}
    		}
    		$this->error($model->getError());
    	}
    	$model = M('Role');
    	$data = $model->find($id);
    	$this->assign('data', $data);
      // 创建权限模型对象 获取所有权限
      $priModel=D('privilege');
      $priData=$priModel->getTree();
      // 获得拥有的权限id
      $roleModel=D('role_pri');
      $roleData=$roleModel->where(array(
        'role_id'=>array('eq',$id)
      ))-> select();
      $_arr=array();
      foreach($roleData as $v){
        $_arr[]=$v['pri_id'];
      }
		// 设置页面中的信息
		$this->assign(array(
      '_arr'=>$_arr,
      'priData'=>$priData,
			'_page_title' => '修改',
			'_page_btn_name' => '列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Role');
    	if($model->delete(I('get.id', 0)) !== FALSE)
    	{
    		$this->success('删除成功！', U('lst', array('p' => I('get.p', 1))));
    		exit;
    	}
    	else
    	{
    		$this->error($model->getError());
    	}
    }
    public function lst()
    {
    	$model = D('Role');
    	$data = $model->search();
    	$this->assign(array(
    		'data' => $data['data'],
    		'page' => $data['page'],
    	));

		// 设置页面中的信息
		$this->assign(array(
			'_page_title' => '列表',
			'_page_btn_name' => '添加',
			'_page_btn_link' => U('add'),
		));
    	$this->display();
    }
}
