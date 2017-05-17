<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{
  public function login(){
    if(IS_POST){
      // 接收表单并且验证表单
      $model=D('Admin');
      if($model->validate($model->_login_validate)->create()){
        if($model->login()){
          $this->success("登陆成功",U('Index/index'));
          exit;
        }
      }
      $this->error($model->getError());
    }

    $this->display();
  }
  public function chkcode(){
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
  public function logout(){
    // 清除session
    session(null);
    $this->success("退出成功",U('login'));
  }

}


 ?>
