-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 2017-05-15 08:15:08
-- 服务器版本： 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

--
-- Database: `php39`
--

-- --------------------------------------------------------

--
-- 表的结构 `p39_admin`
--

CREATE TABLE `p39_admin` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员';

--
-- 转存表中的数据 `p39_admin`
--

INSERT INTO `p39_admin` (`id`, `username`, `password`) VALUES
(1, 'root', '63a9f0ea7bb98050796b649e85481845'),
(6, 'admin', '21232f297a57a5a743894a0e4a801fc3'),
(7, 'test', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- 表的结构 `p39_admin_role`
--

CREATE TABLE `p39_admin_role` (
  `admin_id` mediumint(8) UNSIGNED NOT NULL COMMENT '管理员id',
  `role_id` mediumint(8) UNSIGNED NOT NULL COMMENT '角色id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员角色';

--
-- 转存表中的数据 `p39_admin_role`
--

INSERT INTO `p39_admin_role` (`admin_id`, `role_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 6),
(7, 3),
(7, 8),
(6, 1),
(6, 8);

-- --------------------------------------------------------

--
-- 表的结构 `p39_attribute`
--

CREATE TABLE `p39_attribute` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'ID',
  `attr_name` varchar(30) NOT NULL COMMENT '属性名称',
  `attr_type` enum('唯一','可选') NOT NULL COMMENT '属性类型',
  `attr_option_values` varchar(300) NOT NULL DEFAULT '' COMMENT '属性可选值',
  `type_id` mediumint(8) UNSIGNED NOT NULL COMMENT '所属类型ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='属性表';

--
-- 转存表中的数据 `p39_attribute`
--

INSERT INTO `p39_attribute` (`id`, `attr_name`, `attr_type`, `attr_option_values`, `type_id`) VALUES
(1, '尺寸', '可选', '3.5寸,4.5寸,5.7寸', 1),
(3, '内存', '可选', '1G,2G,4G,6G', 1),
(12, '厂家', '唯一', '华为', 1),
(13, 'cpu', '可选', '英特尔I5,英特尔I7', 3),
(14, '出版社', '唯一', '清华大学出版社,人民大学出版社,武汉大学出版社', 4),
(15, '操作系统', '可选', 'ios,window,安卓', 1),
(16, '重量', '唯一', '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `p39_brand`
--

CREATE TABLE `p39_brand` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'ID',
  `brand_name` varchar(30) NOT NULL DEFAULT '' COMMENT '品牌名称',
  `brand_url` varchar(120) NOT NULL DEFAULT '' COMMENT '官方网址',
  `logo` varchar(150) NOT NULL DEFAULT '' COMMENT '品牌LOGO图片'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='品牌';

--
-- 转存表中的数据 `p39_brand`
--

INSERT INTO `p39_brand` (`id`, `brand_name`, `brand_url`, `logo`) VALUES
(1, '苹果', 'app.com', 'Brand/2017-04-13/58eedaeb55894.jpeg'),
(2, '小米', 'mi.com', 'Brand/2017-04-13/58eedb0304b8b.jpeg'),
(3, '华为', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `p39_cart`
--

CREATE TABLE `p39_cart` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品id',
  `goods_attr_id` varchar(150) NOT NULL DEFAULT '' COMMENT '商品属性id',
  `member_id` mediumint(8) UNSIGNED NOT NULL COMMENT '会员id',
  `goods_number` mediumint(8) UNSIGNED NOT NULL COMMENT '购买的数量'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='购物车表';

--
-- 转存表中的数据 `p39_cart`
--

INSERT INTO `p39_cart` (`id`, `goods_id`, `goods_attr_id`, `member_id`, `goods_number`) VALUES
(3, 28, '', 9, 1);

-- --------------------------------------------------------

--
-- 表的结构 `p39_category`
--

CREATE TABLE `p39_category` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `cat_name` varchar(30) NOT NULL COMMENT '分类名称',
  `parent_id` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属分类ID,0顶级分类',
  `is_floor` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否推荐到楼层'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分类';

--
-- 转存表中的数据 `p39_category`
--

INSERT INTO `p39_category` (`id`, `cat_name`, `parent_id`, `is_floor`) VALUES
(21, '大家电', 0, '是'),
(22, '冰箱', 21, '是'),
(23, '洗衣机', 21, '是'),
(24, '海尔', 22, '否'),
(25, '小天鹅', 22, '否'),
(27, '数码', 0, '是'),
(28, '手机', 27, '是'),
(29, '长虹冰箱', 22, '是'),
(30, '照相机', 27, '否'),
(31, '硬盘', 27, '否'),
(32, '内存卡', 27, '否'),
(33, '数据线', 27, '否'),
(34, '空调', 21, '是'),
(35, '彩电', 21, '否'),
(36, '家庭影院', 21, '否');

-- --------------------------------------------------------

--
-- 表的结构 `p39_comment`
--

CREATE TABLE `p39_comment` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品id',
  `member_id` mediumint(8) UNSIGNED NOT NULL COMMENT '会员id',
  `addtime` datetime NOT NULL COMMENT '评论时间',
  `start` tinyint(4) NOT NULL COMMENT '评分级别',
  `content` varchar(200) NOT NULL COMMENT '评论内容',
  `click_count` smallint(5) UNSIGNED NOT NULL DEFAULT '0' COMMENT '有用的数字'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论表';

--
-- 转存表中的数据 `p39_comment`
--

INSERT INTO `p39_comment` (`id`, `goods_id`, `member_id`, `addtime`, `start`, `content`, `click_count`) VALUES
(1, 28, 9, '2017-04-22 22:22:25', 5, '', 0),
(2, 28, 9, '2017-04-22 22:24:07', 5, 'contentcontentcontentcontent', 0),
(3, 28, 9, '2017-04-22 22:24:19', 5, '111', 0),
(4, 43, 9, '2017-04-22 22:27:32', 4, '444', 0),
(5, 43, 9, '2017-04-22 22:31:05', 4, 'form', 0),
(6, 43, 9, '2017-04-22 22:44:20', 4, '4444', 0),
(7, 43, 9, '2017-04-22 22:48:23', 4, 'ffff', 0),
(8, 43, 9, '2017-04-22 22:51:02', 4, 'ff', 0),
(9, 43, 9, '2017-04-22 22:52:44', 4, '444', 0),
(10, 43, 9, '2017-04-22 22:56:47', 5, 'comment_containercomment_containercomment_container', 0),
(11, 43, 9, '2017-04-22 22:58:15', 5, '444', 0),
(12, 43, 9, '2017-04-22 23:00:15', 5, '444', 0),
(13, 43, 9, '2017-04-22 23:00:47', 5, '444', 0),
(14, 43, 9, '2017-04-22 23:01:56', 5, '444', 0),
(15, 43, 9, '2017-04-22 23:03:12', 5, '55', 0),
(16, 43, 9, '2017-04-22 23:04:09', 5, '88', 0),
(17, 43, 9, '2017-04-22 23:04:15', 5, '98', 0),
(18, 43, 9, '2017-04-22 23:04:23', 5, '87', 0),
(19, 43, 9, '2017-04-22 23:04:44', 3, '66', 0),
(20, 43, 9, '2017-04-22 23:06:46', 2, '666', 0),
(21, 43, 9, '2017-04-22 23:07:54', 2, '666', 0),
(22, 43, 9, '2017-04-22 23:08:10', 2, '77', 0),
(23, 44, 9, '2017-04-23 15:46:32', 5, '4444', 0),
(24, 44, 9, '2017-04-23 15:47:27', 5, '5555', 0),
(25, 44, 9, '2017-04-23 15:47:55', 5, '4444', 0),
(26, 44, 9, '2017-04-23 15:47:59', 5, '567', 0),
(27, 44, 9, '2017-04-23 15:48:10', 5, '56', 0),
(28, 28, 9, '2017-05-05 10:19:34', 5, 'uuuuuuu', 0);

-- --------------------------------------------------------

--
-- 表的结构 `p39_comment_reply`
--

CREATE TABLE `p39_comment_reply` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `comment_id` mediumint(8) UNSIGNED NOT NULL COMMENT '评论id',
  `member_id` mediumint(8) UNSIGNED NOT NULL COMMENT '会员id',
  `content` varchar(150) NOT NULL COMMENT '回复内容',
  `addtime` datetime NOT NULL COMMENT '回复时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='评论回复表';

-- --------------------------------------------------------

--
-- 表的结构 `p39_goods`
--

CREATE TABLE `p39_goods` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `goods_name` varchar(150) NOT NULL COMMENT '商品名称',
  `market_price` decimal(10,2) NOT NULL COMMENT '市场价格',
  `shop_price` decimal(10,2) NOT NULL COMMENT '本店价格',
  `goods_desc` longtext COMMENT '商品描述',
  `is_on_sale` enum('是','否') NOT NULL DEFAULT '是' COMMENT '是否上架',
  `is_delete` enum('是','否') NOT NULL DEFAULT '是' COMMENT '是否删除',
  `addtime` datetime NOT NULL COMMENT '添加时间',
  `img` varchar(120) DEFAULT NULL COMMENT '原始图片',
  `sm_img` varchar(120) NOT NULL DEFAULT '' COMMENT '小图',
  `mid_img` varchar(120) NOT NULL DEFAULT '' COMMENT '中图',
  `big_img` varchar(120) NOT NULL DEFAULT '' COMMENT '大图',
  `mbig_img` varchar(120) NOT NULL DEFAULT '' COMMENT '更大图',
  `brand_id` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '品牌id',
  `cat_id` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类id',
  `type_id` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '类型id',
  `is_hot` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否热销',
  `is_new` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否新品',
  `is_best` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否精品',
  `promote_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '促销价格',
  `promote_start_date` datetime NOT NULL COMMENT '开始促销时间',
  `promote_end_date` datetime NOT NULL COMMENT '结束促销时间',
  `sort_num` tinyint(3) UNSIGNED NOT NULL DEFAULT '100' COMMENT '排序依据',
  `is_floor` enum('是','否') NOT NULL DEFAULT '否' COMMENT '是否推荐到楼层'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `p39_goods`
--

INSERT INTO `p39_goods` (`id`, `goods_name`, `market_price`, `shop_price`, `goods_desc`, `is_on_sale`, `is_delete`, `addtime`, `img`, `sm_img`, `mid_img`, `big_img`, `mbig_img`, `brand_id`, `cat_id`, `type_id`, `is_hot`, `is_new`, `is_best`, `promote_price`, `promote_start_date`, `promote_end_date`, `sort_num`, `is_floor`) VALUES
(19, '56', '456.00', '1234.00', '&lt;p&gt;平的&lt;/p&gt;', '是', '是', '2017-04-13 11:32:13', NULL, '', '', '', '', 2, 25, 0, '否', '否', '否', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 100, '否'),
(21, '红米', '2311.00', '2000.00', '&lt;p&gt;miaoshu&amp;nbsp;&lt;/p&gt;', '是', '是', '2017-04-13 14:51:20', 'goods/2017-04-18/58f5c6430ac49.jpeg', 'goods/2017-04-18/thumb_3_58f5c6430ac49.jpeg', 'goods/2017-04-18/thumb_2_58f5c6430ac49.jpeg', 'goods/2017-04-18/thumb_1_58f5c6430ac49.jpeg', 'goods/2017-04-18/thumb_0_58f5c6430ac49.jpeg', 2, 22, 0, '否', '否', '否', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 100, '否'),
(27, '正式测试', '123.00', '123.00', '&lt;p&gt;miaoshu&lt;/p&gt;', '是', '是', '2017-04-13 18:52:08', NULL, '', '', '', '', 2, 28, 0, '否', '否', '否', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 100, '否'),
(28, '小天鹅冰箱', '111.00', '11.00', '', '是', '是', '2017-04-14 14:16:55', 'goods/2017-04-14/58f06957c9aff.png', 'goods/2017-04-14/thumb_3_58f06957c9aff.png', 'goods/2017-04-14/thumb_2_58f06957c9aff.png', 'goods/2017-04-14/thumb_1_58f06957c9aff.png', 'goods/2017-04-14/thumb_0_58f06957c9aff.png', 1, 22, 0, '否', '否', '否', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 100, '是'),
(31, 'ceshi', '0.00', '333.00', '', '是', '是', '2017-04-14 18:08:34', NULL, '', '', '', '', 1, 21, 0, '否', '否', '否', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 100, '否'),
(32, '555', '0.00', '555.00', '', '是', '是', '2017-04-14 18:12:22', NULL, '', '', '', '', 1, 29, 0, '否', '否', '否', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 100, '否'),
(33, 'fecs', '0.00', '333.00', '', '是', '是', '2017-04-14 18:14:29', NULL, '', '', '', '', 1, 22, 0, '否', '否', '否', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 100, '是'),
(34, 'cegggggg', '0.00', '444.00', '', '是', '是', '2017-04-14 18:15:01', NULL, '', '', '', '', 0, 24, 0, '否', '否', '否', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 100, '是'),
(35, 'ceshi 899', '0.00', '3333.00', '', '是', '是', '2017-04-14 18:24:47', NULL, '', '', '', '', 0, 21, 0, '否', '否', '否', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 100, '否'),
(36, '照相机', '456.00', '333.00', '', '是', '是', '2017-04-14 18:28:36', 'goods/2017-04-19/58f75783ef3d4.jpg', 'goods/2017-04-19/thumb_3_58f75783ef3d4.jpg', 'goods/2017-04-19/thumb_2_58f75783ef3d4.jpg', 'goods/2017-04-19/thumb_1_58f75783ef3d4.jpg', 'goods/2017-04-19/thumb_0_58f75783ef3d4.jpg', 1, 36, 0, '否', '否', '否', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 100, '是'),
(37, 'xiaomi', '22.00', '22.00', '', '是', '是', '2017-04-15 10:51:19', 'goods/2017-04-18/58f6133dc988e.jpg', 'goods/2017-04-18/thumb_3_58f6133dc988e.jpg', 'goods/2017-04-18/thumb_2_58f6133dc988e.jpg', 'goods/2017-04-18/thumb_1_58f6133dc988e.jpg', 'goods/2017-04-18/thumb_0_58f6133dc988e.jpg', 1, 21, 0, '否', '是', '否', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 100, '是'),
(38, '890', '0.00', '11.00', '', '是', '是', '2017-04-15 10:53:57', 'goods/2017-04-18/58f6132f401ce.jpg', 'goods/2017-04-18/thumb_3_58f6132f401ce.jpg', 'goods/2017-04-18/thumb_2_58f6132f401ce.jpg', 'goods/2017-04-18/thumb_1_58f6132f401ce.jpg', 'goods/2017-04-18/thumb_0_58f6132f401ce.jpg', 1, 21, 0, '是', '是', '是', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 70, '否'),
(39, '890', '0.00', '11.00', '', '是', '是', '2017-04-15 10:59:03', 'goods/2017-04-18/58f6110a2f04f.jpg', 'goods/2017-04-18/thumb_3_58f6110a2f04f.jpg', 'goods/2017-04-18/thumb_2_58f6110a2f04f.jpg', 'goods/2017-04-18/thumb_1_58f6110a2f04f.jpg', 'goods/2017-04-18/thumb_0_58f6110a2f04f.jpg', 1, 21, 0, '否', '否', '否', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 100, '否'),
(42, '索尼冰箱', '400.00', '400.00', '&lt;p&gt;发啊&lt;/p&gt;', '是', '是', '2017-04-18 20:19:25', 'goods/2017-04-18/58f610f8a7bf7.jpg', 'goods/2017-04-18/thumb_3_58f610f8a7bf7.jpg', 'goods/2017-04-18/thumb_2_58f610f8a7bf7.jpg', 'goods/2017-04-18/thumb_1_58f610f8a7bf7.jpg', 'goods/2017-04-18/thumb_0_58f610f8a7bf7.jpg', 2, 21, 0, '是', '否', '是', '40.00', '2017-04-18 00:00:00', '2017-05-18 00:00:00', 120, '是'),
(43, '红米', '30.00', '30.00', '', '是', '是', '2017-04-18 20:33:25', 'goods/2017-04-18/58f610f0aed6f.jpg', 'goods/2017-04-18/thumb_3_58f610f0aed6f.jpg', 'goods/2017-04-18/thumb_2_58f610f0aed6f.jpg', 'goods/2017-04-18/thumb_1_58f610f0aed6f.jpg', 'goods/2017-04-18/thumb_0_58f610f0aed6f.jpg', 2, 27, 3, '是', '是', '是', '30.00', '2017-04-12 00:00:00', '2017-04-12 00:00:00', 80, '是'),
(44, '测试在线编辑器', '44.00', '4.00', '&lt;p&gt;这个是在线&lt;span style=\"color:#ff0000\"&gt;编辑&lt;/span&gt;器&lt;/p&gt;', '是', '是', '2017-04-20 09:54:54', 'goods/2017-04-20/58f814ee28c1c.png', 'goods/2017-04-20/thumb_3_58f814ee28c1c.png', 'goods/2017-04-20/thumb_2_58f814ee28c1c.png', 'goods/2017-04-20/thumb_1_58f814ee28c1c.png', 'goods/2017-04-20/thumb_0_58f814ee28c1c.png', 0, 23, 1, '是', '是', '是', '0.00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 67, '是');

-- --------------------------------------------------------

--
-- 表的结构 `p39_goods_attr`
--

CREATE TABLE `p39_goods_attr` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'ID',
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品id',
  `attr_value` varchar(150) NOT NULL DEFAULT '' COMMENT '属性值',
  `attr_id` mediumint(8) UNSIGNED NOT NULL COMMENT '属性id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品属性';

--
-- 转存表中的数据 `p39_goods_attr`
--

INSERT INTO `p39_goods_attr` (`id`, `goods_id`, `attr_value`, `attr_id`) VALUES
(22, 44, '3.5寸', 1),
(23, 44, '4.5寸', 1),
(24, 44, '5.7寸', 1),
(25, 44, '2G', 3),
(26, 44, '华为', 12),
(27, 44, 'ios', 15),
(28, 44, '200g', 16),
(29, 43, '英特尔I5', 13),
(30, 43, '英特尔I7', 13);

-- --------------------------------------------------------

--
-- 表的结构 `p39_goods_cat`
--

CREATE TABLE `p39_goods_cat` (
  `cat_id` mediumint(8) UNSIGNED NOT NULL COMMENT '分类ID',
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品扩展分类';

--
-- 转存表中的数据 `p39_goods_cat`
--

INSERT INTO `p39_goods_cat` (`cat_id`, `goods_id`) VALUES
(22, 35),
(24, 35),
(27, 35),
(22, 42),
(34, 37),
(28, 34),
(22, 36),
(24, 36),
(25, 36),
(22, 44),
(28, 43);

-- --------------------------------------------------------

--
-- 表的结构 `p39_goods_number`
--

CREATE TABLE `p39_goods_number` (
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品id',
  `goods_number` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '库存量',
  `goods_attr_id` varchar(150) NOT NULL COMMENT '商品属性表的id，如果有多个就存成字符串到字段中'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库存量表';

-- --------------------------------------------------------

--
-- 表的结构 `p39_goods_pic`
--

CREATE TABLE `p39_goods_pic` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `pic` varchar(150) NOT NULL COMMENT '原图',
  `sm_pic` varchar(150) NOT NULL COMMENT '小图',
  `mid_pic` varchar(150) NOT NULL COMMENT '中图',
  `big_pic` varchar(150) NOT NULL COMMENT '大图',
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `p39_goods_pic`
--

INSERT INTO `p39_goods_pic` (`id`, `pic`, `sm_pic`, `mid_pic`, `big_pic`, `goods_id`) VALUES
(4, 'goods/2017-04-13/58ef58584dfe2.png', 'goods/2017-04-13/thumb_2_58ef58584dfe2.png', 'goods/2017-04-13/thumb_1_58ef58584dfe2.png', 'goods/2017-04-13/thumb_0_58ef58584dfe2.png', 27),
(5, 'goods/2017-04-13/58ef5858c386a.jpeg', 'goods/2017-04-13/thumb_2_58ef5858c386a.jpeg', 'goods/2017-04-13/thumb_1_58ef5858c386a.jpeg', 'goods/2017-04-13/thumb_0_58ef5858c386a.jpeg', 27),
(6, 'goods/2017-04-15/58f18aa79e901.png', 'goods/2017-04-15/thumb_2_58f18aa79e901.png', 'goods/2017-04-15/thumb_1_58f18aa79e901.png', 'goods/2017-04-15/thumb_0_58f18aa79e901.png', 37),
(7, 'goods/2017-04-15/58f18aa8222be.jpeg', 'goods/2017-04-15/thumb_2_58f18aa8222be.jpeg', 'goods/2017-04-15/thumb_1_58f18aa8222be.jpeg', 'goods/2017-04-15/thumb_0_58f18aa8222be.jpeg', 37),
(8, 'goods/2017-04-15/58f18c780182e.png', 'goods/2017-04-15/thumb_2_58f18c780182e.png', 'goods/2017-04-15/thumb_1_58f18c780182e.png', 'goods/2017-04-15/thumb_0_58f18c780182e.png', 39);

-- --------------------------------------------------------

--
-- 表的结构 `p39_member`
--

CREATE TABLE `p39_member` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `face` varchar(150) NOT NULL DEFAULT '' COMMENT '头像',
  `jifen` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '积分',
  `email` varchar(150) NOT NULL COMMENT '邮箱',
  `email_chkcode_time` int(10) UNSIGNED NOT NULL COMMENT '注册时间',
  `email_chkcode` varchar(32) NOT NULL DEFAULT '' COMMENT '邮箱验证码'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='会员表';

--
-- 转存表中的数据 `p39_member`
--

INSERT INTO `p39_member` (`id`, `username`, `password`, `face`, `jifen`, `email`, `email_chkcode_time`, `email_chkcode`) VALUES
(7, '9', '45c48cce2e2d7fbdea1afc51c7c6ad26', '', 0, '', 0, ''),
(8, 'wang', 'e08392bb89dedb8ed6fb298f8e729c15', '', 0, '', 0, ''),
(9, '90', '8613985ec49eb8f757ae6439e879bb2a', '', 20000, '', 0, ''),
(16, '000', 'c6f057b86584942e415435ffb1fa93d4', '', 0, '1032102865@qq.com', 1493962608, '');

-- --------------------------------------------------------

--
-- 表的结构 `p39_member_level`
--

CREATE TABLE `p39_member_level` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'ID',
  `level_name` varchar(30) NOT NULL COMMENT '级别名称',
  `jifen_bottom` mediumint(8) UNSIGNED NOT NULL COMMENT '积分下限',
  `jifen_top` mediumint(8) UNSIGNED NOT NULL COMMENT '积分上限'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `p39_member_level`
--

INSERT INTO `p39_member_level` (`id`, `level_name`, `jifen_bottom`, `jifen_top`) VALUES
(1, '普通会员', 0, 1000),
(2, '铜牌会员', 1000, 5000),
(3, '银牌会员', 5000, 15000),
(4, '金牌会员', 15000, 50000);

-- --------------------------------------------------------

--
-- 表的结构 `p39_member_price`
--

CREATE TABLE `p39_member_price` (
  `price` decimal(10,2) NOT NULL COMMENT '会员价格',
  `level_id` mediumint(8) UNSIGNED NOT NULL COMMENT '级别id',
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `p39_member_price`
--

INSERT INTO `p39_member_price` (`price`, `level_id`, `goods_id`) VALUES
('3.00', 1, 39),
('3.00', 2, 39),
('3.00', 3, 39),
('3.00', 4, 39),
('1.00', 1, 42),
('2.00', 2, 42),
('2.00', 3, 42),
('2.00', 4, 42),
('3.00', 1, 34),
('3.00', 2, 34),
('3.00', 3, 34),
('3.00', 4, 34),
('1.00', 1, 27),
('2.00', 2, 27),
('3.00', 3, 27),
('4.00', 4, 27);

-- --------------------------------------------------------

--
-- 表的结构 `p39_order`
--

CREATE TABLE `p39_order` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `member_id` mediumint(8) UNSIGNED NOT NULL COMMENT '会员id',
  `addtime` int(10) UNSIGNED NOT NULL COMMENT '下单时间',
  `pay_status` enum('是','否') NOT NULL DEFAULT '否' COMMENT '支付状态',
  `pay_time` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '支付时间',
  `total_price` decimal(10,2) NOT NULL COMMENT '订单总价',
  `shr_name` varchar(30) NOT NULL COMMENT '收货人姓名',
  `shr_tel` varchar(30) NOT NULL COMMENT '收货人电话',
  `shr_province` varchar(30) NOT NULL COMMENT '收货人省',
  `shr_city` varchar(30) NOT NULL COMMENT '收货人城市',
  `shr_area` varchar(30) NOT NULL COMMENT '收货人地区',
  `shr_address` varchar(30) NOT NULL COMMENT '收货人详细地址',
  `post_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发货状态0:未发货，1:已发货，2:已收获',
  `post_number` varchar(30) NOT NULL DEFAULT '' COMMENT '快递单号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单基本信息表';

--
-- 转存表中的数据 `p39_order`
--

INSERT INTO `p39_order` (`id`, `member_id`, `addtime`, `pay_status`, `pay_time`, `total_price`, `shr_name`, `shr_tel`, `shr_province`, `shr_city`, `shr_area`, `shr_address`, `post_status`, `post_number`) VALUES
(1, 9, 1492788420, '否', 0, '80.00', 'wang', '111111111', '北京', '朝阳区', '西二旗', 'beijng', 0, ''),
(2, 9, 1492788736, '否', 0, '11.00', 'wang', '2123456784', '北京', '海淀区', '西三旗', 'beijng', 0, ''),
(3, 9, 1492789542, '否', 0, '22.00', 'wang', '11111111', '天津', '东城区', '西三旗', 'fffffffff', 0, ''),
(4, 9, 1492828543, '否', 0, '11.00', 'wang', '11111111', '北京', '东城区', '西三旗', 'beijng', 0, ''),
(5, 9, 1492830810, '否', 0, '4.00', 'wang', '44444', '北京', '东城区', '西三旗', '444', 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `p39_order_goods`
--

CREATE TABLE `p39_order_goods` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `order_id` mediumint(8) UNSIGNED NOT NULL COMMENT '订单id',
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品id',
  `goods_attr_id` varchar(150) NOT NULL COMMENT '商品属性id',
  `goods_number` mediumint(8) UNSIGNED NOT NULL COMMENT '购买数量',
  `price` decimal(10,2) NOT NULL COMMENT '购买价格'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单商品表';

--
-- 转存表中的数据 `p39_order_goods`
--

INSERT INTO `p39_order_goods` (`id`, `order_id`, `goods_id`, `goods_attr_id`, `goods_number`, `price`) VALUES
(1, 1, 0, '23,25,27', 4, '4.00'),
(2, 1, 0, '24,25,27', 1, '4.00'),
(3, 1, 0, '22,25,27', 2, '4.00'),
(4, 1, 0, '30', 1, '30.00'),
(5, 1, 0, '', 1, '22.00'),
(6, 2, 28, '', 1, '11.00'),
(7, 3, 37, '', 1, '22.00'),
(8, 4, 28, '', 1, '11.00'),
(9, 5, 44, '22,25,27', 1, '4.00');

-- --------------------------------------------------------

--
-- 表的结构 `p39_privilege`
--

CREATE TABLE `p39_privilege` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `pri_name` varchar(30) NOT NULL COMMENT '权限名称',
  `module_name` varchar(30) NOT NULL DEFAULT '' COMMENT '模型名称',
  `controller_name` varchar(30) NOT NULL DEFAULT '' COMMENT '控制器名称',
  `action_name` varchar(30) NOT NULL DEFAULT '' COMMENT '方法名称',
  `parent_id` mediumint(8) UNSIGNED NOT NULL DEFAULT '0' COMMENT '上级权限id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限';

--
-- 转存表中的数据 `p39_privilege`
--

INSERT INTO `p39_privilege` (`id`, `pri_name`, `module_name`, `controller_name`, `action_name`, `parent_id`) VALUES
(4, '商品模块', 'null', 'null', 'null', 0),
(5, '商品列表', 'Admin', 'Goods', 'list', 4),
(6, '商品添加', 'Admin', 'Goods', 'add', 5),
(7, '商品修改', 'Admin', 'Goods', 'edit', 5),
(8, '商品删除', 'Admin', 'Goods', 'delete', 5),
(9, '商品分类', 'Admin', 'Category', 'lst', 4),
(10, '添加分类', 'Admin', 'Category', 'add', 9),
(11, '删除分类', 'Admin', 'Category', 'delete', 9),
(12, '修改分类', 'Admin', 'Category', 'edit', 9),
(13, '商品类型', 'Admin', 'Type', 'lst', 4),
(14, '类型添加', 'Admin', 'Type', 'add', 13),
(15, '类型修改', 'Admin', 'Type', 'edit', 13),
(16, '类型删除', 'Admin', 'Type', 'delete', 13),
(17, 'RBAC', '', '', '', 0),
(18, '权限列表', 'Admin', 'privilege', 'lst', 17),
(19, '角色列表', 'Admin', 'Role', 'lst', 17),
(20, '管理员列表', 'Admin', 'Admin', 'lst', 17),
(21, '商品品牌', 'Admin', 'Brand', 'lst', 4);

-- --------------------------------------------------------

--
-- 表的结构 `p39_role`
--

CREATE TABLE `p39_role` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `role_name` varchar(30) NOT NULL COMMENT '角色名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色';

--
-- 转存表中的数据 `p39_role`
--

INSERT INTO `p39_role` (`id`, `role_name`) VALUES
(1, '商品管理员'),
(2, '商品分类管理员'),
(3, '商品类型管理员'),
(7, '商品添加员'),
(8, '权限管理员');

-- --------------------------------------------------------

--
-- 表的结构 `p39_role_pri`
--

CREATE TABLE `p39_role_pri` (
  `pri_id` mediumint(8) UNSIGNED NOT NULL COMMENT '权限id',
  `role_id` mediumint(8) UNSIGNED NOT NULL COMMENT '角色id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限';

--
-- 转存表中的数据 `p39_role_pri`
--

INSERT INTO `p39_role_pri` (`pri_id`, `role_id`) VALUES
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(5, 7),
(6, 7),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(17, 8),
(18, 8),
(4, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 3);

-- --------------------------------------------------------

--
-- 表的结构 `p39_type`
--

CREATE TABLE `p39_type` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'ID',
  `type_name` varchar(30) NOT NULL COMMENT '类型名称'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='类型表';

--
-- 转存表中的数据 `p39_type`
--

INSERT INTO `p39_type` (`id`, `type_name`) VALUES
(1, '手机'),
(3, '笔记本'),
(4, '图书');

-- --------------------------------------------------------

--
-- 表的结构 `p39_yinxiang`
--

CREATE TABLE `p39_yinxiang` (
  `id` mediumint(8) UNSIGNED NOT NULL COMMENT 'id',
  `yx_name` varchar(150) NOT NULL COMMENT '印象名字',
  `goods_id` mediumint(8) UNSIGNED NOT NULL COMMENT '商品id',
  `yx_count` smallint(5) UNSIGNED NOT NULL DEFAULT '1' COMMENT '印象评论次数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='印象表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `p39_admin`
--
ALTER TABLE `p39_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p39_admin_role`
--
ALTER TABLE `p39_admin_role`
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `p39_attribute`
--
ALTER TABLE `p39_attribute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `p39_brand`
--
ALTER TABLE `p39_brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p39_cart`
--
ALTER TABLE `p39_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `p39_category`
--
ALTER TABLE `p39_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p39_comment`
--
ALTER TABLE `p39_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goods_id` (`goods_id`);

--
-- Indexes for table `p39_comment_reply`
--
ALTER TABLE `p39_comment_reply`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`);

--
-- Indexes for table `p39_goods`
--
ALTER TABLE `p39_goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_price` (`shop_price`),
  ADD KEY `addtime` (`addtime`),
  ADD KEY `is_on_sale` (`is_on_sale`),
  ADD KEY `brand_id` (`brand_id`),
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `is_hot` (`is_hot`),
  ADD KEY `is_new` (`is_new`),
  ADD KEY `is_best` (`is_best`),
  ADD KEY `promote_price` (`promote_price`),
  ADD KEY `promote_start_date` (`promote_start_date`),
  ADD KEY `promote_end_date` (`promote_end_date`),
  ADD KEY `sort_num` (`sort_num`);

--
-- Indexes for table `p39_goods_attr`
--
ALTER TABLE `p39_goods_attr`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goods_id` (`goods_id`),
  ADD KEY `attr_id` (`attr_id`);

--
-- Indexes for table `p39_goods_cat`
--
ALTER TABLE `p39_goods_cat`
  ADD KEY `cat_id` (`cat_id`),
  ADD KEY `goods_id` (`goods_id`);

--
-- Indexes for table `p39_goods_number`
--
ALTER TABLE `p39_goods_number`
  ADD KEY `goods_id` (`goods_id`);

--
-- Indexes for table `p39_goods_pic`
--
ALTER TABLE `p39_goods_pic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goods_id` (`goods_id`);

--
-- Indexes for table `p39_member`
--
ALTER TABLE `p39_member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p39_member_level`
--
ALTER TABLE `p39_member_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p39_member_price`
--
ALTER TABLE `p39_member_price`
  ADD KEY `level_id` (`level_id`),
  ADD KEY `goods_id` (`goods_id`);

--
-- Indexes for table `p39_order`
--
ALTER TABLE `p39_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `addtime` (`addtime`);

--
-- Indexes for table `p39_order_goods`
--
ALTER TABLE `p39_order_goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `goods_id` (`goods_id`);

--
-- Indexes for table `p39_privilege`
--
ALTER TABLE `p39_privilege`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p39_role`
--
ALTER TABLE `p39_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p39_role_pri`
--
ALTER TABLE `p39_role_pri`
  ADD KEY `pri_id` (`pri_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `p39_type`
--
ALTER TABLE `p39_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `p39_yinxiang`
--
ALTER TABLE `p39_yinxiang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goods_id` (`goods_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `p39_admin`
--
ALTER TABLE `p39_admin`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=8;
--
-- 使用表AUTO_INCREMENT `p39_attribute`
--
ALTER TABLE `p39_attribute`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=17;
--
-- 使用表AUTO_INCREMENT `p39_brand`
--
ALTER TABLE `p39_brand`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `p39_cart`
--
ALTER TABLE `p39_cart`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `p39_category`
--
ALTER TABLE `p39_category`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=37;
--
-- 使用表AUTO_INCREMENT `p39_comment`
--
ALTER TABLE `p39_comment`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=29;
--
-- 使用表AUTO_INCREMENT `p39_comment_reply`
--
ALTER TABLE `p39_comment_reply`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id';
--
-- 使用表AUTO_INCREMENT `p39_goods`
--
ALTER TABLE `p39_goods`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=45;
--
-- 使用表AUTO_INCREMENT `p39_goods_attr`
--
ALTER TABLE `p39_goods_attr`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=31;
--
-- 使用表AUTO_INCREMENT `p39_goods_pic`
--
ALTER TABLE `p39_goods_pic`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=9;
--
-- 使用表AUTO_INCREMENT `p39_member`
--
ALTER TABLE `p39_member`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=17;
--
-- 使用表AUTO_INCREMENT `p39_member_level`
--
ALTER TABLE `p39_member_level`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `p39_order`
--
ALTER TABLE `p39_order`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=6;
--
-- 使用表AUTO_INCREMENT `p39_order_goods`
--
ALTER TABLE `p39_order_goods`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=10;
--
-- 使用表AUTO_INCREMENT `p39_privilege`
--
ALTER TABLE `p39_privilege`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=22;
--
-- 使用表AUTO_INCREMENT `p39_role`
--
ALTER TABLE `p39_role`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=9;
--
-- 使用表AUTO_INCREMENT `p39_type`
--
ALTER TABLE `p39_type`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=5;
--
-- 使用表AUTO_INCREMENT `p39_yinxiang`
--
ALTER TABLE `p39_yinxiang`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
