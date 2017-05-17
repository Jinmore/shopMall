<?php
namespace Admin\Model;
use Think\Model;
class RoleModel extends Model
{
	protected $insertFields = array('role_name');
	protected $updateFields = array('id','role_name');
	protected $_validate = array(
		array('role_name', 'require', '角色名称不能为空！', 1, 'regex', 3),
		array('role_name', '1,30', '角色名称的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('role_name', '', '角色名称不能重复', 1, 'unique', 3),
	);
	public function search($pageSize = 20)
	{
		/**************************************** 搜索 ****************************************/
		$where = array();
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
		field("a.*,GROUP_CONCAT(c.pri_name) pri_name")->
		join('left join __ROLE_PRI__ as b on a.id=b.role_id and a.id=b.role_id
		left join __PRIVILEGE__ as c on b.pri_id=c.id')->
		select();
		return $data;
	}
	// 添加前
	protected function _before_insert(&$data, $option)
	{
	}
	protected function _after_insert($data, $option)
	{
		$priId=I('post.pri_id');
		$role_priModel=D('role_pri');
		foreach($priId as $v){
			$role_priModel->add(array(
				'role_id'=>$data['id'],
				'pri_id'=>$v
			));
		}

	}
	// 修改前
	protected function _before_update(&$data, $option)
	{
		$id=$option['where']['id'];
		$priId=I('post.pri_id');
		$role_priModel=D('role_pri');
		// 先删除原来权限再添加
		$role_priModel->where(array(
			'role_id'=>array('eq',$id)
		))->delete();
		foreach($priId as $v){
			$role_priModel->add(array(
				'role_id'=>$id,
				'pri_id'=>$v
			));
		}
	}
	// 删除前
	protected function _before_delete($option)
	{
		$id=$option['where']['id'];
		// 删除角色权限
		$role_priModel=D('role_pri');
		$role_priModel->where(array(
			'role_id'=>array('eq',$id)
		))->delete();

	}
	/************************************ 其他方法 ********************************************/
}
