<?php
namespace Home\Controller;
use Think\Controller;

class LoginController extends Controller{
  // ajax 判断登陆状态
  public function ajaxlogin(){
       if(session('m_id')){
         echo json_encode(array(
           'login'=>1,
           'username'=>session('m_username')
         ));
       }else
       {
         echo json_encode(array(
           'login'=>0
         ));
       }
  }
  public  function  login(){
    $member=D('Admin/Member');
    if(IS_POST){
      if($member->validate($member->_login_validate)->create())
      {
        if($member->login()){
          $url=U('/');
          // 如果session有一个登陆之后要跳转的地址，就存在session中
          $returnUrl=session('returnUrl');
          if($returnUrl)
          {
            session('returnUrl',null);
            $url=$returnUrl;
          }
          $this->success("登陆成功",$url,1);
          exit;
        }
      }
       $this->error($member->getError());
    }
    $this->display();

  }
  // -----------微博登陆--------------
  public function wblogin()
  {
    $member=D('Admin/Member');
    $m=$member->field('username')->where(array(
      'uid'=>$_SESSION['uid'],
    ))->find();
    //如果客户已经绑定账号
    if($m)
    {
      if($member->login(false))
      {
        $url=U('/');
        // 如果session有一个登陆之后要跳转的地址，就存在session中
        $returnUrl=session('returnUrl');
        if($returnUrl)
        {
          session('returnUrl',null);
          $url=$returnUrl;
        }
        $this->success("登陆成功",$url,1);
        exit;
      }
    }else
    {
      // 让客户登陆账号完成绑定
      redirect(U('login'));
    }


  }
  // 生成验证码
  public function chkcode()
  {
    // 配置验证码
    $vconfig=array(
      'fontSize'  =>  20,              // 验证码字体大小(px)
      'useCurve'  =>  false,            // 是否画混淆曲线
      'useNoise'  =>  false,            // 是否添加杂点
      'imageH'    =>  40,               // 验证码图片高度
      'imageW'    =>  148,               // 验证码图片宽度
      'length'    =>  2,               // 验证码位数
    );
    $capModel=new \Think\Verify($vconfig);
    $capModel->entry();
  }
  public function logout()
  {
    session(null);
    redirect('login/login');
    // $this->success();
  }
  public function regist()
  {
   if(IS_POST){
     $mem=D('Admin/Member');
    if($mem->create(I('post.'),1)){
      if($mem->add()){
        $this->success("注册成功,请登陆邮箱进行邮箱验证！",U('login'));
        exit;
      }
    }
    $this->error($mem->getError());
  }
  $this->display();
}
public function email_chk()
{
  // 接收验证码
  $emailcode=I('get.code');
  $model=D('Admin/member');
  $info=$model->field('id,email,email_chkcode_time')->where(array(
    'email_chkcode'=>$emailcode,
  ))->find();
  //var_dump($info);die;
  if($info)
  {
    if((time()-$info['email_chkcode_time']) > 86400)
    {
      $model->delete($info['id']);
      $this->error('验证码已经过期，账号已经删除',U('regist'));
    }
    else
    {
      $model->where(array(
        'id'=>array('eq',$info['id'])
      ))->setField('email_chkcode','');
      $this->success('验证成功，请登陆',U('login'));
      exit;
    }
  }
  else
  {
    $this->error('参数错误',U(''));
  }

}




}



?>
