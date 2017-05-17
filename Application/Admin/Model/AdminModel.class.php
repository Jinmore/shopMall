<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model
{
	protected $insertFields = array('username','password','cpassword','chkcode');
	protected $updateFields = array('id','username','password','cpassword');
	protected $_validate = array(
		array('username', 'require', '用户名不能为空！', 1, 'regex', 3),
		array('username', '1,30', '用户名的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('username', '', '用户名已经存在', 1, 'unique', 3),
		// 第六个参数为 1 表示只验证添加时表单
		array('password', 'require', '密码不能为空！', 1, 'regex', 1),
		array('password', 'cpassword', '两次密码必须一致', 1, 'confirm', 3),
	);
	// 为登陆表单定义一个验证规则
	public $_login_validate=array(
		array('username','require','用户名不能为空',1),
		array('password','require','密码不能为空',1),
		array('chkcode','require','验证码不能为空33',1),
		array('chkcode','check_verify','验证码错误',1,'callback'),
	);
	// 验证 验证码是否正确
	public function check_verify($code,$id=''){
     $Verify=new \Think\Verify();
		 return $Verify->check($code,$id);
	}

	public function login(){
		// 从模型中获取 用户名 密码
		$username=$this->username;
		$password=$this->password;
		// 从数据库查询出用户名
		$user=$this->where(array(
			'username'=>array('eq',$username)
		))->find();
		if($user)
		{
				if($user['password']==md5($password))
				{
	      // 登陆成功，存储session
				session('id',$user['id']);
				session('username',$user['username']);
				return true;
			  }else
				{
			        $this->error="密码不正确";
		    }
		}
		else
		{
			$this->error="用户名不存储在";
			return false;
		}

	}
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
		if($username = I('get.username'))
			$where['username'] = array('like', "%$username%");
		/************************************* 翻页 ****************************************/
		$count = $this->alias('a')->where($where)->count();
		$page = new \Think\Page($count, $pageSize);
		// 配置翻页的样式
		$page->setConfig('prev', '上一页');
		$page->setConfig('next', '下一页');
		$data['page'] = $page->show();
		/************************************** 取数据 ******************************************/
		$data['data'] = $this->alias('a')->
		where($where)->group('a.id')->
		limit($page->firstRow.','.$page->listRows)->
		field('a.*,group_concat(c.role_name) role_name')->
		join('left join __ADMIN_ROLE__ b on a.id=b.admin_id and a.id=b.admin_id
		left join __ROLE__ c on b.role_id=c.id')->
		select();
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
		// 对密码进行加密
		$data['password']=md5($data['password']);
	}
	protected function _after_insert($data, $option)
	{

		$id=$data['id'];
		// 接收表单角色数据
		$roleId=I('post.role_id');
		// 实例化角色-管理员 模型
		$roleModel=D('admin_role');
		foreach($roleId as $v){
			$roleModel->add(array(
				'admin_id'=>$id,
				'role_id'=>$v,
			));
		}

	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
		$id=$option['where']['id'];
		//---------- 处理管理员角色-------
		// 先删除原来的角色，在添加进去
		$roleId=I('post.role_id');
		// 实例化角色-管理员 模型
		$roleModel=D('admin_role');
		$roleModel->where(array(
			'admin_id'=>$id,
		))->delete();
		foreach($roleId as $v){
			$roleModel->add(array(
				'admin_id'=>$id,
				'role_id'=>$v,
			));
		}
    //判断用户是否修改了密码，如果修改了 则加密
		if($data['password']){
			$data['password']=md5($data['password']);
		}else{
			unset($data['password']);
		}

	}
	// 删除前
	protected function _before_delete($option)
	{
		// 删除管理员 角色
		$id=$option['where']['id'];
		$roleModel=D('admin_role');
	  $roleModel->where(array(
		 'admin_id'=>$id,
	 ))->delete();
		// 判断管理员id 为 1则是超级管理员，不允许删除
		if($option['where']['id']==1){
			$this->error="超级管理员不能删除";
			return false;
		}
	}
	/************************************ 其他方法 ********************************************/
}
