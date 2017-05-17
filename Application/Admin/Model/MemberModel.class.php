<?php
namespace Admin\Model;
use Think\Model;
class MemberModel extends Model{
  protected $insertFields=array('username','password','cpassword','chkcode','checkbox','email');
  protected $updateFields=array('id','username','password','cpassword');
  //添加和修改会员时候用的表单验证
  protected $_validate=array(
    array('checkbox','require','必须同意注册协议',1,'regex', 3),
    array('username', 'require', '用户名不能为空！', 1, 'regex', 3),
		array('username', '1,30', '用户名的值最长不能超过 30 个字符！', 1, 'length', 3),
		array('username', '', '用户名已经存在', 1, 'unique', 3),
		// 第六个参数为 1 表示只验证添加时表单
		array('password', 'require', '密码不能为空！', 1, 'regex', 1),
		array('password', 'cpassword', '两次密码必须一致', 1, 'confirm', 3),
    array('chkcode','require','验证码不能为空 ',1),
    array('chkcode','check_verify','验证码不正确，请重新输入 ',1,'callback'),
    array('email','email','请输入正确格式的邮箱',1,'regex',3),
  );
  // 为登陆表单制作一个登陆规则
  public $_login_validate=array(
    array('username','require','用户名不能为空',1),
    array('password','require','密码不能为空 ',1),
    array('chkcode','require','验证码不能为空 ',1),
    array('chkcode','check_verify','验证码不正确，请重新输入 ',1,'callback'),
  );
// 验证规则，callback 表示 自定义验证方法

  public function check_verify($code,$id=''){
    $Verify=new \Think\Verify();
    return $Verify->check($code,$id);
  }
// 验证登陆
public function login($ispass=true){
  $username=$this->username;
  $password=$this->password;
  $user=$this->where(array('username'=>array('eq',$username))
    )->find();

  //------- 判断邮箱是否验证，验证之后才能登陆
  if($user){
    if(!empty($user['email_chkcode']))
    {
      $this->error='邮箱暂未验证，请先进行验证';
      return false;
    }
    // 是否需要密码
    if($ispass)
    {
      if($user['password']==md5($password)){
        // 记录session
        session('m_id',$user['id']);
        session('m_username',$user['username']);
       // 查询出会员级别，存入session
        $meModel=D('Admin/member_level');
        $meData=$meModel->field('level_name,id')->where(array(
          'jifen_bottom'=>array('elt',$user['jifen']),
          'jifen_top'=>array('egt',$user['jifen']),
        ))->find();
       session('level_id',$meData['id']);
      // 会员登陆，将会员cookie中购物车商品信息 转移到数据库
      $cartModel=D('Home/cart');
      $cartModel->moveDataToDb();
        return true;
      }else{
        $this->error="密码不正确，请重新输入";
      }
    }else
    {
        // 记录session
        session('m_id',$user['id']);
        session('m_username',$user['username']);
       // 查询出会员级别，存入session
        $meModel=D('Admin/member_level');
        $meData=$meModel->field('level_name,id')->where(array(
          'jifen_bottom'=>array('elt',$user['jifen']),
          'jifen_top'=>array('egt',$user['jifen']),
        ))->find();
        session('level_id',$meData['id']);
        // 会员登陆，将会员cookie中购物车商品信息 转移到数据库
        $cartModel=D('Home/cart');
        $cartModel->moveDataToDb();
        return true;
    }

  }else
  {
    $this->error="用户名不存在，请重新输入";
    return false;
  }
}
protected function _before_insert(&$data, $option)
{
  // 对密码进行加密
  $data['password']=md5($data['password']);
  //-------- 生成邮箱验证码。邮箱验证--------
  $chkcode=md5(uniqid());
  $data['email_chkcode_time']=time();
  $data['email_chkcode']=$chkcode;
  // --------将微博登陆uid存储到数据库----
  if(isset($_SESSION['uid'])){
    $data['uid']=$_SESSION['uid'];
    unset($_SESSION['uid']);
  }

}
protected function _after_insert($data, $option)
{

  $content="欢迎您加入，请点击一下链接完成注册验证，<p><a href='http://www.abc.com/shangcheng/index.php/Home/login/email_chk/code/{$data['email_chkcode']}' >请点击完成注册</a></p>";
  sendMail($data['email'],'第二网欢迎您注册',$content);
}



}



 ?>
