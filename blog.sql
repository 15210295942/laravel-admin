/*
Navicat MySQL Data Transfer

Source Server         : conle
Source Server Version : 50637
Source Host           : 139.224.232.12:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50637
File Encoding         : 65001

Date: 2018-01-02 10:07:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for blog_admin
-- ----------------------------
DROP TABLE IF EXISTS `blog_admin`;
CREATE TABLE `blog_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userName` varchar(255) NOT NULL COMMENT '用户登录昵称',
  `loginIp` varchar(255) NOT NULL DEFAULT '127.0.0.1' COMMENT '用户上次登录的ip地址',
  `psw` varchar(255) DEFAULT NULL COMMENT '用户登录密码',
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '伪删除0未删除1已删除',
  `userPhoto` varchar(255) DEFAULT NULL COMMENT '用户头像',
  `loginTime` int(11) DEFAULT NULL COMMENT '上次登录时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='博客后台登录表';

-- ----------------------------
-- Records of blog_admin
-- ----------------------------
INSERT INTO `blog_admin` VALUES ('1', 'conle', '127.0.0.1', '$2y$10$54XcwGteX6jVEBMiNS.LFucOiKKkkfpQfwi8D2fgUIcDAm6/y1.a.', '0', '/uploads/photo/conle.jpg', '1514529665');
INSERT INTO `blog_admin` VALUES ('10', '陈丽', '127.0.0.1', '$2y$10$6eY61UjNWOErNwS.BmCoy.ypFMylRhkBrya8cxm6wn5M3xGYHyptm', '0', '/uploads/photo/20171223/lCPTCKE7EUvX.jpg', null);

-- ----------------------------
-- Table structure for blog_blog
-- ----------------------------
DROP TABLE IF EXISTS `blog_blog`;
CREATE TABLE `blog_blog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `description` varchar(255) NOT NULL COMMENT '描述',
  `content` text NOT NULL COMMENT '内容',
  `image` varchar(255) DEFAULT NULL COMMENT '展示图片',
  `cate_id` int(11) NOT NULL COMMENT '分类id',
  `createTime` int(11) NOT NULL COMMENT '添加时间',
  `isDeleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '伪删除0未删除1已删除',
  PRIMARY KEY (`id`),
  KEY `title` (`title`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_blog
-- ----------------------------

-- ----------------------------
-- Table structure for blog_category
-- ----------------------------
DROP TABLE IF EXISTS `blog_category`;
CREATE TABLE `blog_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) NOT NULL COMMENT '分类名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `description` varchar(255) NOT NULL COMMENT '分类描述 父级>子集',
  `createTime` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_category
-- ----------------------------
INSERT INTO `blog_category` VALUES ('1', '博客', '0', '博客', '1514538183');

-- ----------------------------
-- Table structure for blog_menu
-- ----------------------------
DROP TABLE IF EXISTS `blog_menu`;
CREATE TABLE `blog_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `path` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '名称路径',
  `display_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '名称',
  `description` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '描述',
  `pid` int(11) unsigned DEFAULT '0' COMMENT '父级id',
  `icon` varchar(255) CHARACTER SET utf8 DEFAULT '&#xe641;' COMMENT '图标',
  `sort` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '菜单类型1     后台2...',
  `createTime` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='菜单表';

-- ----------------------------
-- Records of blog_menu
-- ----------------------------
INSERT INTO `blog_menu` VALUES ('1', '', '管理员管理', '管理员管理', '0', 'icon-computer', '1', '1', '1');
INSERT INTO `blog_menu` VALUES ('2', '/admin/list', '管理员列表', '管理员管理 > 管理员列表', '1', 'icon-text', '1', '1', '1');
INSERT INTO `blog_menu` VALUES ('3', '/admin/menu/list', '菜单列表', '管理员管理 > 菜单列表', '1', 'icon-text', '2', '1', '1');
INSERT INTO `blog_menu` VALUES ('4', '', '博客管理', '博客管理', '0', 'icon-computer', '1', '1', '1');
INSERT INTO `blog_menu` VALUES ('5', '/admin/blog/list', '博客列表', '博客管理 > 博客列表', '4', 'icon-computer', '1', '1', '1514517317');
INSERT INTO `blog_menu` VALUES ('9', null, '分类管理', '分类管理', '0', 'icon-computer', '3', '1', '1514527975');
INSERT INTO `blog_menu` VALUES ('10', '/admin/category/list', '分类列表', '分类管理 > 分类列表', '9', 'icon-text', '1', '1', '1514528778');

-- ----------------------------
-- Table structure for blog_power
-- ----------------------------
DROP TABLE IF EXISTS `blog_power`;
CREATE TABLE `blog_power` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `adminId` int(11) NOT NULL COMMENT '后台用户id',
  `menuId` int(11) NOT NULL COMMENT '菜单id ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='admin 菜单权限表';

-- ----------------------------
-- Records of blog_power
-- ----------------------------
INSERT INTO `blog_power` VALUES ('13', '1', '1');
INSERT INTO `blog_power` VALUES ('14', '1', '2');
INSERT INTO `blog_power` VALUES ('15', '1', '3');
INSERT INTO `blog_power` VALUES ('16', '1', '4');
INSERT INTO `blog_power` VALUES ('17', '1', '5');
INSERT INTO `blog_power` VALUES ('18', '1', '9');
INSERT INTO `blog_power` VALUES ('19', '1', '10');

-- ----------------------------
-- Table structure for blog_user
-- ----------------------------
DROP TABLE IF EXISTS `blog_user`;
CREATE TABLE `blog_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `userName` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `salt` varchar(255) DEFAULT NULL COMMENT '四位混淆密码字段',
  `loginIp` varchar(255) DEFAULT NULL COMMENT '登录ip',
  `loginTime` int(11) DEFAULT NULL COMMENT '上次登录的时间戳',
  `createTime` int(11) DEFAULT NULL COMMENT '创建时间',
  `isDelete` tinyint(2) DEFAULT '1' COMMENT '伪删除字段1未删除2已删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='博客前台登录表';

-- ----------------------------
-- Records of blog_user
-- ----------------------------