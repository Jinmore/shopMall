create database php39;
use php39;
set names utf8;
-- --------------------创建商品表
create table p39_goods(
 id mediumint unsigned not null auto_increment comment 'id',
 goods_name varchar(150) not null comment '商品名称',
 market_price decimal(10,2) not null comment '市场价格',
 shop_price decimal(10,2) not null comment '本店价格',
 goods_desc longtext comment '商品描述',
 is_on_sale enum ('是','否') not null default '是' comment '是否上架',
 is_delete enum('是','否') not null default '是' comment '是否删除',
 addtime datetime not null comment '添加时间',
 img varchar(120) not null default '' comment '原始图片',
 sm_img varchar(120) not null default '' comment '小图',
 mid_img varchar(120) not null default '' comment '中图',
 big_img varchar(120) not null default '' comment '大图',
 mbig_img varchar(120) not null default '' comment '更大图',
 primary key(id),
 key shop_price(shop_price),
 key addtime(addtime),
 key is_on_sale(is_on_sale)
)engine=Innodb default charset=utf8;
更改便结构
alter table p39_goods add img varchar(120) not null default '' comment '原始图片';
alter table p39_goods add sm_img varchar(120) not null default '' comment '小图',
alter table p39_goods add  mid_img varchar(120) not null default '' comment '中图',
alter table p39_goods add  big_img varchar(120) not null default '' comment '大图',
alter table p39_goods add  mbig_img varchar(120) not null default '' comment '更大图',
alter table p39_goods add  brand_id mediumint unsigned not null default '0' comment '品牌id',
alter table p39_goods add  type_id mediumint unsigned not null default '0' comment '类型id',

--  添加几个字段
alter table p39_goods add  is_hot enum ('是','否') not null default '否' comment '是否热销';
alter table p39_goods add  is_new enum ('是','否') not null default '否' comment '是否新品';
alter table p39_goods add  is_best enum ('是','否') not null default '否' comment '是否精品';
alter table p39_goods add  promote_price decimal(10,2) not null default '0' comment '促销价格';
alter table p39_goods add  promote_start_date datetime not null comment '开始促销时间';
alter table p39_goods add  promote_end_date datetime not null comment '结束促销时间';
alter table p39_goods add  sort_num tinyint unsigned not null default '100' comment '排序依据';

alter table p39_goods add  is_floor enum ('是','否') not null default '否' comment '是否推荐到楼层';


---------------------- 创建品牌表
create table p39_brand (
  id mediumint unsigned not null auto_increment comment 'ID',
  brand_name varchar(30) not null default '' comment'品牌名字',
  brand_url  varchar(120) not null default '' comment '官方网址',
  logo varchar(150) not null default '' comment '品牌LOGO图片',
  primary key(id)
)engine=InnoDB default charset=utf8 comment '品牌';

-----------------------创建会员级别表
create table p39_member_level(
  id mediumint unsigned not null auto_increment comment 'ID',
  level_name varchar(30) not null comment '级别名称',
  jifen_bottom mediumint unsigned not null comment '积分下限',
  jifen_top mediumint unsigned not null comment '积分上限',
  primary key(id)
)engine=InnoDB default charset=utf8;

-- 创建会员价格表 存储不同会员等级的商品价格
create table p39_member_price(
  price decimal(10,2) not null comment '会员价格',
  level_id mediumint unsigned not null comment '级别id',
  goods_id mediumint unsigned not null comment '商品id',
  key level_id(level_id),
  key goods_id(goods_id)
)engine=InnoDB default charset=utf8;

-------创建商品相册
create table p39_goods_pic(
  id mediumint unsigned not null auto_increment comment '',
  pic varchar(150) not null comment '原图',
  sm_pic varchar(150) not null comment '小图',
  mid_pic varchar(150) not null comment '中图',
  big_pic varchar(150) not null comment '大图',
  goods_id mediumint unsigned not null comment '商品id',
  primary key(id),
  key goods_id(goods_id)
)engine=InnoDB default charset=utf8;

---------------- 创建商品分类表
create table p39_category(
  id mediumint unsigned not null auto_increment comment 'id',
  cat_name varchar(30) not null comment '分类名称',
  parent_id mediumint unsigned not null default '0' comment '所属分类ID,0顶级分类',
  primary key(id)
)engine=InnoDB default charset=utf8 comment'分类';

alter table p39_category add  is_floor enum ('是','否') not null default '否' comment '是否推荐到楼层';


-- ------------------创建扩展分类表
create table p39_goods_cat(
  cat_id mediumint unsigned not null  comment '分类ID',
  goods_id mediumint unsigned not null comment '商品ID',
  key cat_id(cat_id),
  key goods_id(goods_id)
)engine =InnoDB default charset=utf8 comment '商品扩展分类';
------------------- 创建商品类型表
create table p39_type(
  id mediumint unsigned not null auto_increment comment 'ID',
  type_name varchar(30) not null comment '类型名称',
  primary key(id)
)engine=InnoDB default charset=utf8 comment '类型表';
create table p39_attribute(
  id mediumint unsigned not null auto_increment comment 'ID',
  attr_name varchar(30) not null  comment '属性名称',
  attr_type enum('唯一','可选') not null comment '属性类型',
  attr_option_values varchar(300) not null default '' comment '属性可选值',
  type_id mediumint unsigned not null comment '所属类型ID',
  primary key(id),
  key type_id(type_id)
)engine=InnoDB default charset=utf8 comment '属性表';
create table p39_goods_attr(
  id mediumint unsigned not null auto_increment comment 'ID',
  goods_id mediumint unsigned not null comment '商品id',
  attr_value varchar(150) not null default '' comment '属性值',
  attr_id mediumint unsigned not null  comment '属性id',
  primary key(id),
  key goods_id(goods_id),
  key attr_id(attr_id)
)engine=InnoDB default charset=utf8 comment '商品属性';
create table p39_goods_number(
  goods_id mediumint unsigned not null comment '商品id',
  goods_number mediumint unsigned not null default '0' comment '库存量',
  goods_attr_id varchar(150) not null comment '商品属性表的id，如果有多个就存成字符串到字段中',
  key goods_id(goods_id),
)engine=InnoDB default charset=utf8 comment '库存量表';

-- --------------创建RBAC 权限分配表------------
create table p39_privilege(
  id mediumint unsigned not null auto_increment comment 'id',
  pri_name varchar(30) not null comment '权限名称',
  model_name varchar(30)  not null default '' comment '模型名称',
  controller_name varchar(30) not null default '' comment '控制器名称',
  action_name varchar(30) not null default '' comment '方法名称',
  parent_id mediumint unsigned not null default '0' comment '上级权限id',
  primary key(id),
)engine=InnoDB default charset=utf8 comment '权限';

create table p39_role(
  id mediumint unsigned not null auto_increment comment 'id',
  role_name varchar(30) not null comment '角色名称',
  primary key(id)
)engine=InnoDB default charset=utf8 comment '角色';

create table p39_role_pri(
  pri_id mediumint unsigned not null comment '权限id',
  role_id mediumint unsigned not null comment '角色id',
  key pri_id(pri_id),
  key role_id(role_id)
)engine=InnoDB default charset=utf8 comment '角色权限';

create table p39_admin(
  id mediumint unsigned not null auto_increment comment 'id',
  username varchar(30) not null comment '用户名',
  password varchar(32) not null  comment '密码',
  primary key(id)
)engine=InnoDB default charset=utf8 comment '管理员';

create table p39_admin_role (
  admin_id mediumint unsigned not null comment '管理员id',
  role_id mediumint unsigned not null comment '角色id',
  key admin_id(admin_id),
  key role_id(role_id)
)engine=InnoDB default charset=utf8 comment '管理员角色';


-- 创建会员表
create table p39_member(
  id mediumint unsigned not null auto_increment comment 'id',
  username varchar(30) not null comment '用户名',
  password varchar(32) not null comment '密码',
  face varchar(150) not null default '' comment '头像',
  jifen mediumint unsigned not null default '0' comment '积分',
  primary key(id)
)engine=InnoDB default charset=utf8 comment '会员表';
alter table p39_member add email varchar(150) not null comment '邮箱',
alter table p39_member add email_chkcode_time int unsigned not null comment '注册时间',
alter table p39_member add email_chkcode varchar(32) not null default '' comment '邮箱验证码'
-- 创建购物车表
create table p39_cart(
  id mediumint unsigned not null auto_increment comment 'id',
  goods_id mediumint unsigned not null comment '商品id',
  goods_attr_id varchar(150) not null default '' comment '商品属性id',
  member_id mediumint unsigned not null comment '会员id',
  goods_number mediumint unsigned not null comment '购买的数量',
  primary key(id),
  key member_id(member_id)
)engine=InnoDB default charset=utf8 comment '购物车表';


-- 创建订单表
create table p39_order(
  id mediumint unsigned not null auto_increment comment 'id',
  member_id mediumint unsigned not null comment '会员id',
  addtime int unsigned not null comment '下单时间',
  pay_status enum('是','否')  not null default '否' comment '支付状态',
  pay_time int unsigned not null default '0' comment '支付时间',
  total_price decimal(10,2) not null comment '订单总价',
  shr_name varchar(30) not null comment '收货人姓名',
  shr_tel varchar(30) not null comment '收货人电话',
  shr_province varchar(30) not null comment '收货人省',
  shr_city varchar(30) not null comment '收货人城市',
  shr_area varchar(30) not null comment '收货人地区',
  shr_address varchar(30) not null comment '收货人详细地址',
  post_status tinyint not null default '0' comment '发货状态0:未发货，1:已发货，2:已收获',
  post_number varchar(30) not null default ''comment '快递单号',
  primary key(id),
  key member_id(member_id),
  key addtime(addtime)
)engine=InnoDB default charset=utf8 comment '订单基本信息表';

-- 创建订单商品表
create table p39_order_goods(
id mediumint unsigned not null auto_increment comment 'id',
order_id mediumint unsigned not null comment '订单id',
goods_id mediumint unsigned not null comment '商品id',
goods_attr_id varchar(150) not null comment '商品属性id',
goods_number mediumint unsigned not null comment '购买数量',
price decimal(10,2) not null comment '购买价格',
primary key(id),
key order_id(order_id),
key goods_id(goods_id)
)engine=InnoDB default charset=utf8 comment '订单商品表';

-- 创建 评论表----
create table p39_comment(
  id mediumint unsigned not null auto_increment comment 'id',
  goods_id mediumint unsigned not null comment '商品id',
  member_id mediumint unsigned not null comment '会员id',
  addtime  datetime not null comment '评论时间',
  start tinyint not null comment '评分级别',
  content varchar(200) not null comment '评论内容',
  click_count smallint unsigned not null default '0' comment '有用的数字',
  primary key (id),
  key goods_id(goods_id)
)engine=InnoDB default charset=utf8 comment '评论表';

create table p39_comment_reply(
  id mediumint unsigned not null auto_increment comment 'id',
  comment_id mediumint unsigned not null comment '评论id',
  member_id  mediumint unsigned not null comment '会员id',
  content varchar(150) not null comment '回复内容',
  addtime datetime not null comment '回复时间',
  primary key(id),
  key comment_id(comment_id)
)engine=InnoDB default charset=utf8 comment '评论回复表';

create table p39_yinxiang(
  id mediumint unsigned not null auto_increment comment 'id',
  yx_name varchar(150) not null comment '印象名字',
  goods_id mediumint unsigned not null comment '商品id',
  yx_count smallint unsigned not null default '1' comment '印象评论次数',
  primary key(id),
  key goods_id(goods_id)
)engine=InnoDB default charset=utf8 comment '印象表';
