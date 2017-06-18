/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-06-19 02:21:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  `created_at` datetime NOT NULL COMMENT '添加时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2017-06-18 16:09:31', '2017-06-18 16:09:35');

-- ----------------------------
-- Table structure for attributes
-- ----------------------------
DROP TABLE IF EXISTS `attributes`;
CREATE TABLE `attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(255) NOT NULL COMMENT '属性名称',
  `attr_type` int(255) NOT NULL DEFAULT '1' COMMENT '属性类型，1：唯一、2：可选',
  `option_values` varchar(255) DEFAULT NULL COMMENT '属性可选值',
  `type_id` int(11) NOT NULL COMMENT '所属类型id',
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COMMENT='属性表';

-- ----------------------------
-- Records of attributes
-- ----------------------------
INSERT INTO `attributes` VALUES ('30', '颜色', '2', '黑色,白色,金色,银色,紫色', '13');
INSERT INTO `attributes` VALUES ('31', '存储', '2', '32GB,64GB,128GB', '13');
INSERT INTO `attributes` VALUES ('32', '内存', '1', null, '13');
INSERT INTO `attributes` VALUES ('33', '摄像头', '1', null, '13');
INSERT INTO `attributes` VALUES ('34', '电池容量', '1', null, '13');
INSERT INTO `attributes` VALUES ('35', '颜色', '2', '黑色,白色,藏青,橙色', '14');
INSERT INTO `attributes` VALUES ('36', '尺码', '2', '165,170,175,180', '14');
INSERT INTO `attributes` VALUES ('37', '材质', '1', null, '14');
INSERT INTO `attributes` VALUES ('38', '类型', '1', null, '14');
INSERT INTO `attributes` VALUES ('39', '屏幕尺寸', '1', null, '13');
INSERT INTO `attributes` VALUES ('40', '颜色', '2', '红色,蓝色,白色', '16');
INSERT INTO `attributes` VALUES ('41', '材质', '1', null, '16');
INSERT INTO `attributes` VALUES ('42', '重量', '1', null, '16');
INSERT INTO `attributes` VALUES ('43', '重量', '1', null, '15');
INSERT INTO `attributes` VALUES ('44', '啦啦啦', '2', '哼哼,哈哈', '15');

-- ----------------------------
-- Table structure for brands
-- ----------------------------
DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) NOT NULL COMMENT '品牌名称',
  `logo` varchar(255) DEFAULT NULL COMMENT '品牌logo',
  PRIMARY KEY (`id`),
  KEY `brand_name` (`brand_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='品牌表';

-- ----------------------------
-- Records of brands
-- ----------------------------
INSERT INTO `brands` VALUES ('4', '苹果', 'photo/NhwqktTWFFDodTSBQbSu9n5AXneUWtZySRtekpIK.jpeg');
INSERT INTO `brands` VALUES ('5', '三星', 'photo/0CCwWiTeFgPRCfcVYYoyn1BSkl0cJIF2z5ca9phV.jpeg');
INSERT INTO `brands` VALUES ('7', '美的', 'photo/1xu4J4DIprKgR8fhQvrHwsYI1PdAZSt9GCi3bWNy.jpeg');
INSERT INTO `brands` VALUES ('8', '红双喜', 'photo/DaUqm6cQBIZx50EoZ7WVBJRuTmzoXfaQt3lUkpLR.jpeg');
INSERT INTO `brands` VALUES ('9', '海澜之家', null);

-- ----------------------------
-- Table structure for extend_sorts
-- ----------------------------
DROP TABLE IF EXISTS `extend_sorts`;
CREATE TABLE `extend_sorts` (
  `sort_id` int(11) NOT NULL COMMENT '分类id',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  KEY `sort_id` (`sort_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品扩展分类表';

-- ----------------------------
-- Records of extend_sorts
-- ----------------------------
INSERT INTO `extend_sorts` VALUES ('12', '37');
INSERT INTO `extend_sorts` VALUES ('13', '37');
INSERT INTO `extend_sorts` VALUES ('26', '34');
INSERT INTO `extend_sorts` VALUES ('27', '34');
INSERT INTO `extend_sorts` VALUES ('10', '44');
INSERT INTO `extend_sorts` VALUES ('22', '44');
INSERT INTO `extend_sorts` VALUES ('7', '45');
INSERT INTO `extend_sorts` VALUES ('20', '45');
INSERT INTO `extend_sorts` VALUES ('30', '50');

-- ----------------------------
-- Table structure for goods
-- ----------------------------
DROP TABLE IF EXISTS `goods`;
CREATE TABLE `goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '商品名称',
  `brand_id` int(11) NOT NULL COMMENT '品牌id',
  `image` varchar(255) DEFAULT NULL COMMENT '商品图片',
  `describe` varchar(255) NOT NULL COMMENT '商品描述',
  `sort_id` int(11) NOT NULL COMMENT '主分类id',
  `is_putaway` int(11) NOT NULL DEFAULT '1' COMMENT '是否上架 0：下架、1：上架',
  `type_id` int(11) NOT NULL COMMENT '类型id',
  `created_at` datetime NOT NULL COMMENT '添加时间',
  `updated_at` datetime NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE,
  KEY `describe` (`describe`) USING BTREE,
  KEY `sore_id` (`sort_id`) USING BTREE,
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='商品表';

-- ----------------------------
-- Records of goods
-- ----------------------------
INSERT INTO `goods` VALUES ('34', 'iphone7', '4', null, '<p>iphone7</p>', '28', '1', '13', '2017-05-29 18:49:12', '2017-05-29 18:49:12');
INSERT INTO `goods` VALUES ('37', '羽毛球拍子', '8', null, '<p>羽毛球拍子一支</p>', '29', '1', '16', '2017-06-10 16:59:54', '2017-06-10 16:59:54');
INSERT INTO `goods` VALUES ('44', '衬衫', '9', null, '<p>衬衫</p>', '9', '1', '14', '2017-06-11 20:43:15', '2017-06-11 20:43:15');
INSERT INTO `goods` VALUES ('45', '电风扇', '7', null, '<p>电风扇</p>', '1', '1', '15', '2017-06-11 20:43:59', '2017-06-11 20:43:59');
INSERT INTO `goods` VALUES ('50', '批量赋值', '8', 'photo/m6zsOTPLcJksNkcRcBEcGdHBTkPBNBcoggR3eQ4N.jpeg', '<p><span style=\"color: rgb(51, 51, 51); font-family: \">批量赋值</span></p>', '9', '1', '16', '2017-06-18 22:04:01', '2017-06-18 22:04:58');

-- ----------------------------
-- Table structure for goods_attrs
-- ----------------------------
DROP TABLE IF EXISTS `goods_attrs`;
CREATE TABLE `goods_attrs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attr_value` varchar(255) NOT NULL COMMENT '属性值',
  `attr_id` int(11) NOT NULL COMMENT '属性id',
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  PRIMARY KEY (`id`),
  KEY `attribute_id` (`attr_id`),
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8 COMMENT='商品属性表';

-- ----------------------------
-- Records of goods_attrs
-- ----------------------------
INSERT INTO `goods_attrs` VALUES ('81', '黑色', '30', '34');
INSERT INTO `goods_attrs` VALUES ('84', '32GB', '31', '34');
INSERT INTO `goods_attrs` VALUES ('85', '64GB', '31', '34');
INSERT INTO `goods_attrs` VALUES ('87', '2GB', '32', '34');
INSERT INTO `goods_attrs` VALUES ('88', '1200', '33', '34');
INSERT INTO `goods_attrs` VALUES ('89', '3000', '34', '34');
INSERT INTO `goods_attrs` VALUES ('90', '4.7', '39', '34');
INSERT INTO `goods_attrs` VALUES ('93', '128GB', '31', '34');
INSERT INTO `goods_attrs` VALUES ('102', '红色', '40', '37');
INSERT INTO `goods_attrs` VALUES ('103', '白色', '40', '37');
INSERT INTO `goods_attrs` VALUES ('104', '蓝色', '40', '37');
INSERT INTO `goods_attrs` VALUES ('105', '合金', '41', '37');
INSERT INTO `goods_attrs` VALUES ('106', '95g', '42', '37');
INSERT INTO `goods_attrs` VALUES ('123', '银色', '30', '34');
INSERT INTO `goods_attrs` VALUES ('146', '白色', '30', '34');
INSERT INTO `goods_attrs` VALUES ('147', '金色', '30', '34');
INSERT INTO `goods_attrs` VALUES ('148', '黑色', '35', '44');
INSERT INTO `goods_attrs` VALUES ('149', '白色', '35', '44');
INSERT INTO `goods_attrs` VALUES ('150', '橙色', '35', '44');
INSERT INTO `goods_attrs` VALUES ('151', '165', '36', '44');
INSERT INTO `goods_attrs` VALUES ('152', '170', '36', '44');
INSERT INTO `goods_attrs` VALUES ('153', '175', '36', '44');
INSERT INTO `goods_attrs` VALUES ('154', '180', '36', '44');
INSERT INTO `goods_attrs` VALUES ('155', '纯棉', '37', '44');
INSERT INTO `goods_attrs` VALUES ('156', '青年', '38', '44');
INSERT INTO `goods_attrs` VALUES ('157', '120g', '43', '45');
INSERT INTO `goods_attrs` VALUES ('159', '100kg', '43', '50');
INSERT INTO `goods_attrs` VALUES ('160', '红色', '40', '50');
INSERT INTO `goods_attrs` VALUES ('163', '批量赋值', '41', '50');
INSERT INTO `goods_attrs` VALUES ('164', '批量赋值', '42', '50');
INSERT INTO `goods_attrs` VALUES ('167', '蓝色', '40', '50');

-- ----------------------------
-- Table structure for sorts
-- ----------------------------
DROP TABLE IF EXISTS `sorts`;
CREATE TABLE `sorts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_name` varchar(255) NOT NULL COMMENT '分类名称',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级分类的id，0：顶级分类',
  PRIMARY KEY (`id`),
  KEY `sort_name` (`sort_name`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='商品分类表';

-- ----------------------------
-- Records of sorts
-- ----------------------------
INSERT INTO `sorts` VALUES ('1', '家用电器', '0');
INSERT INTO `sorts` VALUES ('7', '生活电器', '1');
INSERT INTO `sorts` VALUES ('9', '男装', '0');
INSERT INTO `sorts` VALUES ('10', '衬衫', '9');
INSERT INTO `sorts` VALUES ('12', '运动户外', '0');
INSERT INTO `sorts` VALUES ('13', '体育用品', '12');
INSERT INTO `sorts` VALUES ('20', '电风扇', '7');
INSERT INTO `sorts` VALUES ('22', '长袖衬衫', '10');
INSERT INTO `sorts` VALUES ('23', '运动服饰', '12');
INSERT INTO `sorts` VALUES ('24', '乒乓球', '13');
INSERT INTO `sorts` VALUES ('25', '篮球', '13');
INSERT INTO `sorts` VALUES ('26', '手机数码', '0');
INSERT INTO `sorts` VALUES ('27', '手机通讯', '26');
INSERT INTO `sorts` VALUES ('28', '手机', '27');
INSERT INTO `sorts` VALUES ('29', '羽毛球', '13');
INSERT INTO `sorts` VALUES ('30', '短袖衬衫', '10');

-- ----------------------------
-- Table structure for stocks
-- ----------------------------
DROP TABLE IF EXISTS `stocks`;
CREATE TABLE `stocks` (
  `goods_id` int(11) NOT NULL COMMENT '商品id',
  `stock` int(255) NOT NULL DEFAULT '0' COMMENT '库存量',
  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `goods_attr_id` varchar(255) NOT NULL COMMENT '商品属性表id，多个之间以,号隔开',
  KEY `goods_id` (`goods_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='库存量表';

-- ----------------------------
-- Records of stocks
-- ----------------------------
INSERT INTO `stocks` VALUES ('34', '111', '59.00', '81,84');
INSERT INTO `stocks` VALUES ('34', '222', '69.00', '84,123');
INSERT INTO `stocks` VALUES ('34', '333', '79.00', '81,85');
INSERT INTO `stocks` VALUES ('37', '1000', '69.00', '102');
INSERT INTO `stocks` VALUES ('37', '955', '79.00', '103');
INSERT INTO `stocks` VALUES ('37', '755', '89.00', '104');
INSERT INTO `stocks` VALUES ('45', '599', '120.00', '');
INSERT INTO `stocks` VALUES ('44', '1000', '399.00', '148,151');
INSERT INTO `stocks` VALUES ('44', '900', '388.00', '148,152');
INSERT INTO `stocks` VALUES ('44', '800', '377.00', '148,153');
INSERT INTO `stocks` VALUES ('44', '700', '366.00', '149,151');
INSERT INTO `stocks` VALUES ('44', '600', '355.00', '149,152');
INSERT INTO `stocks` VALUES ('44', '500', '344.00', '149,153');
INSERT INTO `stocks` VALUES ('44', '400', '333.00', '150,152');
INSERT INTO `stocks` VALUES ('44', '300', '322.00', '150,153');
INSERT INTO `stocks` VALUES ('44', '300', '311.00', '150,154');
INSERT INTO `stocks` VALUES ('50', '100', '100.00', '160');
INSERT INTO `stocks` VALUES ('50', '200', '200.00', '167');

-- ----------------------------
-- Table structure for types
-- ----------------------------
DROP TABLE IF EXISTS `types`;
CREATE TABLE `types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) NOT NULL COMMENT '类型名称',
  PRIMARY KEY (`id`),
  KEY `type_name` (`type_name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='类型表';

-- ----------------------------
-- Records of types
-- ----------------------------
INSERT INTO `types` VALUES ('13', '手机');
INSERT INTO `types` VALUES ('14', '服装');
INSERT INTO `types` VALUES ('15', '电器');
INSERT INTO `types` VALUES ('16', '羽毛球拍');
