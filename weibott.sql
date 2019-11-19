/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 80012
Source Host           : 127.0.0.1:3306
Source Database       : weibott

Target Server Type    : MYSQL
Target Server Version : 80012
File Encoding         : 65001

Date: 2019-11-19 09:08:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for wei_admin
-- ----------------------------
DROP TABLE IF EXISTS `wei_admin`;
CREATE TABLE `wei_admin` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(50) NOT NULL,
  `login_ip` varchar(50) NOT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '状态： 1：启用 2：停用',
  `login_time` int(11) DEFAULT NULL,
  `is_delete` tinyint(1) DEFAULT '1' COMMENT '是否可以删除 1：是 0：否',
  `role_id` int(11) DEFAULT NULL COMMENT '角色id',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wei_admin
-- ----------------------------
INSERT INTO `wei_admin` VALUES ('1', 'tian', '123456', '127.0.0.1', '1', '1573715863', '1', '1', null, '1573715863', null);

-- ----------------------------
-- Table structure for wei_attention
-- ----------------------------
DROP TABLE IF EXISTS `wei_attention`;
CREATE TABLE `wei_attention` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未读',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wei_attention
-- ----------------------------
INSERT INTO `wei_attention` VALUES ('1', '1', '2', '0', null, null, null);
INSERT INTO `wei_attention` VALUES ('2', '1', '3', '0', null, null, null);
INSERT INTO `wei_attention` VALUES ('4', '1', '1', '1', '1569848439', '1569848439', null);

-- ----------------------------
-- Table structure for wei_feedback
-- ----------------------------
DROP TABLE IF EXISTS `wei_feedback`;
CREATE TABLE `wei_feedback` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `content` varchar(160) NOT NULL,
  `user_id` int(8) NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:可删除',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wei_feedback
-- ----------------------------
INSERT INTO `wei_feedback` VALUES ('1', '66666', '1', '1', '1570091286', '1570091286', null);
INSERT INTO `wei_feedback` VALUES ('2', 'dd', '4', '1', '1573635984', '1573635984', null);

-- ----------------------------
-- Table structure for wei_friend
-- ----------------------------
DROP TABLE IF EXISTS `wei_friend`;
CREATE TABLE `wei_friend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `passage_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未读',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wei_friend
-- ----------------------------
INSERT INTO `wei_friend` VALUES ('1', '2', '1', '0', '1568198555', '1568198555', null);
INSERT INTO `wei_friend` VALUES ('2', '3', '1', '0', '1568198555', '1568198555', null);

-- ----------------------------
-- Table structure for wei_menu
-- ----------------------------
DROP TABLE IF EXISTS `wei_menu`;
CREATE TABLE `wei_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ord` int(11) NOT NULL COMMENT '排序',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父菜单ID',
  `controller` varchar(20) NOT NULL COMMENT '控制器',
  `method` varchar(20) NOT NULL COMMENT '方法',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '菜单名',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态： 0：不可用 1：可用',
  `is_delete` tinyint(2) NOT NULL DEFAULT '1' COMMENT '是否删除 1：是 0：否',
  `is_hidden` tinyint(2) NOT NULL DEFAULT '0' COMMENT '是否影藏  0：否 1：是',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wei_menu
-- ----------------------------
INSERT INTO `wei_menu` VALUES ('1', '1', '0', 'admin', 'index', '管理员管理', '1', '1', '0', null, '1569672779', null);
INSERT INTO `wei_menu` VALUES ('5', '1', '1', 'admin', 'admin_list', '管理员列表', '1', '1', '0', '1560824533', '1569672780', null);
INSERT INTO `wei_menu` VALUES ('9', '2', '1', 'admin', 'admin_edit', '添加（编辑）管理员', '1', '1', '1', '1560825304', '1569672780', null);
INSERT INTO `wei_menu` VALUES ('10', '3', '1', ' admin', 'admin_del', '删除管理员', '1', '1', '1', '1560825451', '1569672780', null);
INSERT INTO `wei_menu` VALUES ('11', '4', '1', 'admin', 'no_del', '批量恢复管理员', '1', '1', '1', '1560825675', '1569672780', null);
INSERT INTO `wei_menu` VALUES ('41', '7', '0', 'system', 'index', '系统管理', '1', '1', '0', '1561191270', '1569672781', null);
INSERT INTO `wei_menu` VALUES ('13', '5', '1', 'admin', 'admin_status', '管理员状态', '1', '1', '1', '1560825823', '1569672780', null);
INSERT INTO `wei_menu` VALUES ('14', '2', '0', 'menu', 'index', '菜单管理', '1', '1', '0', '1560932481', '1569672780', null);
INSERT INTO `wei_menu` VALUES ('15', '1', '14', 'menu', 'menu_list', '菜单列表', '1', '1', '0', '1560932764', '1569672780', null);
INSERT INTO `wei_menu` VALUES ('56', '3', '0', 'user', 'index', '用户管理', '1', '1', '0', '1569586189', '1569673069', null);
INSERT INTO `wei_menu` VALUES ('57', '4', '0', 'passage', 'index', '文章管理', '1', '1', '0', '1569586241', '1569673069', null);
INSERT INTO `wei_menu` VALUES ('58', '1', '56', 'user', 'user_list', '用户列表', '1', '1', '0', '1569586299', '1569673069', null);
INSERT INTO `wei_menu` VALUES ('59', '1', '57', 'passage', 'passage_list', '文章列表', '1', '1', '0', '1569586337', '1569673069', null);
INSERT INTO `wei_menu` VALUES ('26', '2', '14', 'menu', 'menu_edit', '添加(编辑)菜单', '1', '1', '1', '1560933419', '1569672781', null);
INSERT INTO `wei_menu` VALUES ('27', '3', '14', 'menu', 'menu_del', '删除菜单', '1', '1', '1', '1560933467', '1569672781', null);
INSERT INTO `wei_menu` VALUES ('28', '4', '14', 'menu', 'menu_delAll', '删除全部菜单', '1', '1', '1', '1560933509', '1569672781', null);
INSERT INTO `wei_menu` VALUES ('29', '5', '14', 'menu', 'no_del', '批量恢复全部菜单', '1', '1', '1', '1560933560', '1569672781', null);
INSERT INTO `wei_menu` VALUES ('30', '6', '14', 'menu', 'menu_status', '菜单状态', '1', '1', '1', '1560933588', '1569672781', null);
INSERT INTO `wei_menu` VALUES ('36', '6', '1', 'role', 'role_list', '角色(权限)管理', '1', '1', '0', '1560934855', '1569672780', null);
INSERT INTO `wei_menu` VALUES ('37', '7', '1', 'role', 'role_edit', '添加（编辑角色）', '1', '1', '1', '1560934921', '1569672780', null);
INSERT INTO `wei_menu` VALUES ('38', '8', '1', 'role', 'role_del', '删除角色', '1', '1', '1', '1560934954', '1569672780', null);
INSERT INTO `wei_menu` VALUES ('39', '9', '1', 'role', 'no_del', '角色恢复', '1', '1', '1', '1560935012', '1569672780', null);
INSERT INTO `wei_menu` VALUES ('40', '10', '1', 'role', 'role_status', '角色状态', '1', '1', '1', '1560935050', '1569672780', null);
INSERT INTO `wei_menu` VALUES ('42', '1', '41', 'system', 'index', '系统信息', '1', '1', '0', '1561191317', '1569672781', null);
INSERT INTO `wei_menu` VALUES ('60', '2', '56', 'feedback', 'feedback_list', '反馈列表', '1', '1', '0', '1570079519', '1570079519', null);

-- ----------------------------
-- Table structure for wei_passage
-- ----------------------------
DROP TABLE IF EXISTS `wei_passage`;
CREATE TABLE `wei_passage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父文章id',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '发表内容',
  `imagesB` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '发表的图片(原图)',
  `imagesS` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '缩略图',
  `type` tinyint(1) DEFAULT '0' COMMENT '类型：0：文章  1：评论 2：转发',
  `is_delete` tinyint(1) DEFAULT '1',
  `status` tinyint(1) DEFAULT '1',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wei_passage
-- ----------------------------
INSERT INTO `wei_passage` VALUES ('21', '0', '1、医院里，一孕妇难产，医生灵机一动，给她服用了益生菌。<br/><br/>2、300斤的某女没看到她老公躺在沙发上，一屁股把他坐死了。法律并没有追究她的责任，因为法不责重。<br/><br/>3、两个老人去养老院。。。<br/><br/>70岁的老人进去了，90岁老人没进去。<br/>工作人员：“对不起，大爷，我们不接受儿女健在的老人。您的资料显示，你有一个儿子。”<br/>90岁老人：“操，刚刚进去的就是我儿子！&nbsp”<br/>4、和哥们去一个经常去的小饭馆吃饭，因为经常去所以特别熟！吃完饭结账时104块钱，我和老板说：打个把零抹了吧？<br/>[em_19][em_19]', '', null, '0', '1', '1', '1', '1569676699', '1569676699', null);
INSERT INTO `wei_passage` VALUES ('22', '21', '66666', null, null, '2', '1', '1', '1', '1569676903', '1569676903', null);
INSERT INTO `wei_passage` VALUES ('23', '22', '5555', null, null, '1', '1', '1', '1', '1569678884', '1569678884', null);
INSERT INTO `wei_passage` VALUES ('25', '0', 'LLLLLLLLLLL', '/user_uploads//1/big/20190929\\1eac2d1d379a1566d1f8cd11962b2eb0.jpg,/user_uploads//1/big/20190929\\51b8d19e40a7e99deb1ad00f981c01d8.jpg', '/user_uploads/1/small/20190929/1569732314287909.jpg,/user_uploads/1/small/20190929/1569732344533213.jpg', '0', '1', '1', '1', '1569732357', '1569732357', null);
INSERT INTO `wei_passage` VALUES ('26', '25', '好看', null, null, '2', '1', '1', '1', '1569810324', '1569810324', null);
INSERT INTO `wei_passage` VALUES ('32', '0', '666666', '', '', '0', '1', '1', '1', '1570090680', '1570090680', null);
INSERT INTO `wei_passage` VALUES ('33', '0', '是', '', '', '0', '1', '1', '1', '1573545208', '1573545208', null);
INSERT INTO `wei_passage` VALUES ('34', '0', '是', '', '', '0', '1', '1', '1', '1573545211', '1573545211', null);
INSERT INTO `wei_passage` VALUES ('35', '0', '凤凰涅槃，浴火重生！小凤凰夺冠S9啦！&nbsp为感谢贴吧粉丝在S9期间对小凤凰的支持，小凤凰给大家撒礼品~&nbsp回复本贴，每300楼抽取一楼送出100元Q币！每1W楼抽取一楼送出1000元Q币！&nbsp注：所有抽取楼层...', '', '', '0', '1', '1', '1', '1573545221', '1573545221', null);
INSERT INTO `wei_passage` VALUES ('38', '0', '有没有寒假出来打工的可以联系我', '', '', '0', '1', '1', '1', '1573546026', '1573546026', null);
INSERT INTO `wei_passage` VALUES ('39', '38', '我', null, null, '1', '1', '1', '1', '1573546038', '1573546038', null);
INSERT INTO `wei_passage` VALUES ('40', '38', 'kuai', null, null, '2', '1', '1', '1', '1573573073', '1573573073', null);
INSERT INTO `wei_passage` VALUES ('43', '0', '上单：鳄鱼。开大有凤凰的翅膀，旁边都是火焰&nbsp打野：盲僧。Q是一只凤凰，盾牌是凤', '', '', '0', '1', '1', '1', '1573638932', '1573638932', null);
INSERT INTO `wei_passage` VALUES ('46', '44', '加油，FPX！', null, null, '1', '1', '1', '1', '1573641267', '1573641267', null);
INSERT INTO `wei_passage` VALUES ('48', '0', '2019英雄联盟全球总决赛进行中，FPX专属战队印记在本贴领取~&nbspS9的战火燃起，FPX', '/user_uploads//1/big/20191113\\7b1ceda191188d911cccb79a8bb6c084.jpg', '/user_uploads/1/small/20191113/1573647469091358.jpg', '0', '1', '1', '1', '1573647471', '1573647471', null);
INSERT INTO `wei_passage` VALUES ('49', '0', '骂lwx的你们都取关吧！他说错什么了吗', '/user_uploads//1/big/20191113\\caa3e2c6a025792e580feb14d669a4b6.jpg', '/user_uploads/1/small/20191113/1573647622333924.jpg', '0', '1', '1', '1', '1573647625', '1573647625', null);
INSERT INTO `wei_passage` VALUES ('50', '49', 'fpx加油', null, null, '1', '1', '1', '1', '1573647638', '1573647638', null);
INSERT INTO `wei_passage` VALUES ('51', '49', 'fpx加油[em_13]', null, null, '1', '1', '1', '1', '1573647657', '1573647657', null);
INSERT INTO `wei_passage` VALUES ('52', '0', '回顾这次bo5，FPX真的是一场打的比一场好，每个人都打出了自己最极限的水平，相信每个小伙伴看的都是热血沸腾吧毕竟LPL已经两连冠了，现在的我们可以大声说我们LPL是第一赛区了。<br/>而在赛后，FPX的双C也接受了媒体的采访。而在采访中doinb的一番话却让人落泪，doinb表示“我终于证明了自己，之前有很多人说我这种中单不能拿冠军，现在我做到了，谢谢我的队友”，确实doinb一路走来不容易，提到最强中单的时候，他都是被忽视的对象，而现在他是一名“真正的世界冠军中单”，他成功了。<br/>除此之外，doinb还谈到了他的老婆，硬币哥表示“之前自己已经准备要退役了，但是我的老婆跟我说，让我在打一年，不给自己留遗憾，如果没有他就没有现在的我，谢谢”。<br/>不得不说，看到FPX的夺冠，小米还是很感动的。眼角有泪划过，现在没人敢说我们LPL不行了，我们就是第一赛区。', '/user_uploads//1/big/20191113\\2ef7d5531866dd8ff003b8490f5aab8b.jpg,/user_uploads//1/big/20191113\\2c683c98c706962fb165f0fa2ab42e91.jpg', '/user_uploads/1/small/20191113/1573647780188381.jpg,/user_uploads/1/small/20191113/1573647784267003.jpg', '0', '1', '1', '1', '1573647786', '1573647786', null);

-- ----------------------------
-- Table structure for wei_praise
-- ----------------------------
DROP TABLE IF EXISTS `wei_praise`;
CREATE TABLE `wei_praise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `p_user_id` int(11) NOT NULL COMMENT '原博主id',
  `passage_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '读 ：0：未读  1：已读',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wei_praise
-- ----------------------------
INSERT INTO `wei_praise` VALUES ('13', '1', '1', '22', '1', '1569676953', '1569676953', null);
INSERT INTO `wei_praise` VALUES ('14', '1', '1', '40', '1', '1573607300', '1573607300', null);
INSERT INTO `wei_praise` VALUES ('15', '1', '1', '44', '1', '1573640415', '1573640415', null);
INSERT INTO `wei_praise` VALUES ('16', '1', '1', '45', '1', '1573641338', '1573641338', null);

-- ----------------------------
-- Table structure for wei_role
-- ----------------------------
DROP TABLE IF EXISTS `wei_role`;
CREATE TABLE `wei_role` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL COMMENT '角色名',
  `right` text NOT NULL COMMENT '权限',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  `delete_time` int(11) DEFAULT NULL COMMENT '删除时间',
  `is_delete` tinyint(2) DEFAULT '1' COMMENT '是否删除 1：是 0：否',
  `status` int(2) DEFAULT '1' COMMENT '状态：0：禁用 1：可用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wei_role
-- ----------------------------
INSERT INTO `wei_role` VALUES ('1', '超级管理员', '[\"1\",\"5\",\"9\",\"10\",\"11\",\"13\",\"36\",\"37\",\"38\",\"39\",\"40\",\"41\",\"42\",\"14\",\"15\",\"26\",\"27\",\"28\",\"29\",\"30\",\"56\",\"58\",\"60\",\"57\",\"59\"]', null, '1570079538', null, '1', '1');
INSERT INTO `wei_role` VALUES ('5', '普通管理员', '[\"2\",\"6\",\"3\",\"7\"]', '1561019681', '1561036249', null, '1', '0');

-- ----------------------------
-- Table structure for wei_tread
-- ----------------------------
DROP TABLE IF EXISTS `wei_tread`;
CREATE TABLE `wei_tread` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `p_user_id` int(11) NOT NULL COMMENT '原博主id',
  `passage_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未读',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wei_tread
-- ----------------------------
INSERT INTO `wei_tread` VALUES ('2', '1', '1', '22', '1', '1569678994', '1569678994', null);

-- ----------------------------
-- Table structure for wei_user
-- ----------------------------
DROP TABLE IF EXISTS `wei_user`;
CREATE TABLE `wei_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `avatar_url` text COMMENT '头像',
  `user_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(50) NOT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '性别：0：男 1：女  2：外星人',
  `phone` char(11) DEFAULT NULL,
  `qq` varchar(11) DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `birthday` date DEFAULT NULL COMMENT '生日',
  `motto` varchar(255) DEFAULT NULL COMMENT '座右铭',
  `is_delete` tinyint(1) NOT NULL DEFAULT '1' COMMENT '可删除：1：不可 0：可',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `delete_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of wei_user
-- ----------------------------
INSERT INTO `wei_user` VALUES ('1', '/user_avatar/20190812\\920daf32fe76fa875a19c60ffcfaa2a5.jpg', 'lala', 'e10adc3949ba59abbe56e057f20f883e', '2', '13512345678', '1234567892', '1047918241@qq.com', '2019-08-08', '123dddddddddd', '1', '1', null, '1569641304', null);
INSERT INTO `wei_user` VALUES ('2', '/user_avatar/20190812\\920daf32fe76fa875a19c60ffcfaa2a5.jpg', 'ssssss', 'e10adc3949ba59abbe56e057f20f883e', '0', '13512345678', '1234567891', '123456789@qq.com', '2017-06-20', 'ddsssssssssss', '1', '1', '1564971573', '1564971573', null);
INSERT INTO `wei_user` VALUES ('3', '/user_avatar/20190812\\920daf32fe76fa875a19c60ffcfaa2a5.jpg', 'nunu', 'e10adc3949ba59abbe56e057f20f883e', '0', '13566612345', '1234567891', '1555555@qq.com', '2019-08-12', 'dddddddddd', '1', '1', '1565184206', '1569640734', null);
INSERT INTO `wei_user` VALUES ('4', '/user_avatar/20191113\\6b1743818d55b299cb1d70097a1927a2.jpg', 'haha', 'e10adc3949ba59abbe56e057f20f883e', '0', '13512345677', null, '151514554@qq.com', '2019-11-05', 'sssssssssssssssss', '1', '1', '1573633449', '1573636227', null);
INSERT INTO `wei_user` VALUES ('5', null, 'jiajia', 'e10adc3949ba59abbe56e057f20f883e', '0', '13546512344', '126299', '44894984@qq.com', '2019-11-14', 'aaaaaaaadd', '1', '1', '1573638231', '1573638231', null);
