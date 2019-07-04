/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50724
Source Host           : localhost:3306
Source Database       : laravel

Target Server Type    : MYSQL
Target Server Version : 50724
File Encoding         : 65001

Date: 2019-07-03 17:56:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for blog_article
-- ----------------------------
DROP TABLE IF EXISTS `blog_article`;
CREATE TABLE `blog_article` (
  `article_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nav_id` int(10) unsigned NOT NULL COMMENT '导航类型id',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` text NOT NULL COMMENT '内容',
  `user_id` int(10) unsigned NOT NULL COMMENT '关联用户id',
  `user_no` char(19) NOT NULL DEFAULT '',
  `is_top` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶0否，1是',
  `is_fine` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为精贴0否，1是',
  `page_views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `comment_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论数量',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态0正常，1删除',
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_article
-- ----------------------------

-- ----------------------------
-- Table structure for blog_collect
-- ----------------------------
DROP TABLE IF EXISTS `blog_collect`;
CREATE TABLE `blog_collect` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `user_no` char(19) NOT NULL,
  `collect` text NOT NULL COMMENT '收藏的json 信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_collect
-- ----------------------------

-- ----------------------------
-- Table structure for blog_comment
-- ----------------------------
DROP TABLE IF EXISTS `blog_comment`;
CREATE TABLE `blog_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL COMMENT '评论人',
  `user_no` char(19) NOT NULL,
  `article_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章id',
  `reply_user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '回复对象id',
  `content` text NOT NULL COMMENT '评论内容',
  `like_user_id` varchar(255) NOT NULL DEFAULT '' COMMENT '点赞人id，英文逗号隔开',
  `like_num` int(10) NOT NULL DEFAULT '0' COMMENT '点赞数量',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态0正常，1删除',
  `is_read` int(1) NOT NULL DEFAULT '0' COMMENT '是否已读0未读，1已读',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_comment
-- ----------------------------

-- ----------------------------
-- Table structure for blog_friend
-- ----------------------------
DROP TABLE IF EXISTS `blog_friend`;
CREATE TABLE `blog_friend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `user_no` char(19) NOT NULL,
  `friend_id` int(10) NOT NULL,
  `friend_no` char(19) NOT NULL,
  `client_id` char(30) DEFAULT NULL COMMENT '好友客户端id',
  `remarks` char(40) DEFAULT NULL COMMENT '好友 备注',
  `group_id` int(10) DEFAULT NULL COMMENT 'f分组',
  `create_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_friend
-- ----------------------------

-- ----------------------------
-- Table structure for blog_link
-- ----------------------------
DROP TABLE IF EXISTS `blog_link`;
CREATE TABLE `blog_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL COMMENT '标题',
  `url` varchar(255) NOT NULL COMMENT '链接地址',
  `type` int(1) NOT NULL DEFAULT '0' COMMENT '1.友情链接，2.温馨通道,3轮播图，4小广告',
  `img` varchar(255) DEFAULT NULL COMMENT '图片',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `end_time` int(10) DEFAULT '0',
  `status` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '0正常，1删除',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_link
-- ----------------------------
INSERT INTO `blog_link` VALUES ('1', 'LayIM 3.0 - layui 旗舰之作', 'http://layim.layui.com/?from=fly', '4', null, '0', '1601481600', '0');
INSERT INTO `blog_link` VALUES ('2', 'layui', 'http://www.layui.com/', '1', null, '0', '1601481600', '0');
INSERT INTO `blog_link` VALUES ('3', '代码开源 GitHub 通道，欢迎下载指正', 'https://github.com/freees/blog', '2', null, '0', '1601481600', '0');
INSERT INTO `blog_link` VALUES ('4', '代码开源 Gitee 通道，欢迎下载指正', 'https://gitee.com/freees/blog', '2', null, '0', '1601481600', '0');

-- ----------------------------
-- Table structure for blog_navigation
-- ----------------------------
DROP TABLE IF EXISTS `blog_navigation`;
CREATE TABLE `blog_navigation` (
  `nav_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(20) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1级导航，2二级导航',
  `sort` tinyint(1) unsigned NOT NULL COMMENT '排序',
  `class_name` char(20) NOT NULL COMMENT '样式',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态0正常，1关闭',
  PRIMARY KEY (`nav_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_navigation
-- ----------------------------
INSERT INTO `blog_navigation` VALUES ('1', 'PHP', '2', '2', 'layui-badge-dot', '0');
INSERT INTO `blog_navigation` VALUES ('2', 'JAVA', '2', '3', '', '0');
INSERT INTO `blog_navigation` VALUES ('3', 'GO', '2', '4', '', '0');
INSERT INTO `blog_navigation` VALUES ('4', 'Python', '2', '5', '', '1');
INSERT INTO `blog_navigation` VALUES ('5', '前端', '2', '6', '', '0');
INSERT INTO `blog_navigation` VALUES ('6', '数据库', '2', '7', '', '0');
INSERT INTO `blog_navigation` VALUES ('7', '其他', '2', '8', '', '0');
INSERT INTO `blog_navigation` VALUES ('8', '建议', '2', '9', '', '0');
INSERT INTO `blog_navigation` VALUES ('9', '公告', '2', '10', 'layui-badge-dot', '0');

-- ----------------------------
-- Table structure for blog_user
-- ----------------------------
DROP TABLE IF EXISTS `blog_user`;
CREATE TABLE `blog_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_no` char(19) NOT NULL,
  `username` char(14) NOT NULL DEFAULT '' COMMENT '用户名',
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` char(25) NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` char(32) NOT NULL COMMENT '密码',
  `nick_name` char(20) NOT NULL DEFAULT '',
  `face_img` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `email_is_check` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '邮箱是否验证0未验证，1已验证',
  `sex` char(10) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '账号状态0正常',
  `login_token` char(40) NOT NULL DEFAULT '' COMMENT '登录token',
  `login_time` int(10) NOT NULL DEFAULT '0',
  `client_id` char(30) NOT NULL DEFAULT '',
  `signature` varchar(255) DEFAULT NULL COMMENT '个性签名',
  `area` char(50) DEFAULT NULL COMMENT '地区',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_user
-- ----------------------------
