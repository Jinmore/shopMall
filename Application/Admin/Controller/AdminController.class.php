<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends BaseController
{
    public function add()
    {
    	if(IS_POST)
    	{
    		$model = D('Admin');
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
    //  实例化角色模型，将所有角色展示在表单中
    $roleModel=D('role');
    $roleData=$roleModel->select();
		// 设置页面中的信息
		$this->assign(array(
      'roleData'=>$roleData,
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
    		$model = D('Admin');
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
    	$model = M('Admin');
    	$data = $model->find($id);
    	$this->assign('data', $data);

    //  实例化角色模型，将所有角色展示在表单中
      $roleModel=D('role');
      $roleData=$roleModel->select();
    //取出管理员拥有的角色
    $admin_roleModel=D('admin_role');
    $adminData=$admin_roleModel->where(array(
      'admin_id'=>$id,
    ))->select();
    // 将取出的id放到一纬数组中
    $_arr=array();
    foreach($adminData as $v){
      $_arr[]=$v['role_id'];
    }
		// 设置页面中的信息
		$this->assign(array(
      '_arr'=>$_arr,
      'roleData'=>$roleData,
			'_page_title' => '修改',
			'_page_btn_name' => '列表',
			'_page_btn_link' => U('lst'),
		));
		$this->display();
    }
    public function delete()
    {
    	$model = D('Admin');
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
    	$model = D('Admin');
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
