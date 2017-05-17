<?php
namespace Admin\Model;
use Think\Model;
class CommentModel extends Model
{
   protected $insertFields='goods_id,content,start';
   protected $_validate=array(
     array('content','1,150','内容必须是1-150个字符',1,'length'),
     array('start','1,2,3,4,5','也不合法',1,'in'),
     array('goods_id','require','参数无效',1),
   );
   public function _before_insert(&$data,$option)
   {
     $memberId=session('m_id');
     if(!$memberId)
     {
       $this->error='请先登陆';
       return false;
     }
     $data['addtime']=date('Y-m-d H:i:s');
     $data['member_id']=$memberId;


   }



}


 ?>
