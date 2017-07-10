/*
Navicat MySQL Data Transfer

Source Server         : localhost2
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-07-10 17:17:13
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES ('1', 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2017-06-18 16:09:31', '2017-06-18 16:09:35');
INSERT INTO `admins` VALUES ('4', 'user1', 'e10adc3949ba59abbe56e057f20f883e', '2017-06-25 17:22:45', '2017-06-25 17:22:45');

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles` (
  `admin_id` int(11) NOT NULL COMMENT '管理员id',
  `role_id` int(11) NOT NULL COMMENT '角色id',
  KEY `admin_id` (`admin_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员角色表';

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
INSERT INTO `admin_roles` VALUES ('4', '5');

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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COMMENT='属性表';

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='品牌表';

-- ----------------------------
-- Records of brands
-- ----------------------------
INSERT INTO `brands` VALUES ('7', '美的', 'photo/1xu4J4DIprKgR8fhQvrHwsYI1PdAZSt9GCi3bWNy.jpeg');
INSERT INTO `brands` VALUES ('8', '红双喜', 'photo/DaUqm6cQBIZx50EoZ7WVBJRuTmzoXfaQt3lUkpLR.jpeg');
INSERT INTO `brands` VALUES ('9', '海澜之家', null);
INSERT INTO `brands` VALUES ('10', '苹果', null);

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
INSERT INTO `extend_sorts` VALUES ('10', '44');
INSERT INTO `extend_sorts` VALUES ('22', '44');
INSERT INTO `extend_sorts` VALUES ('26', '34');
INSERT INTO `extend_sorts` VALUES ('27', '34');
INSERT INTO `extend_sorts` VALUES ('7', '46');
INSERT INTO `extend_sorts` VALUES ('20', '46');

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
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COMMENT='商品表';

-- ----------------------------
-- Records of goods
-- ----------------------------
INSERT INTO `goods` VALUES ('34', 'iphone7', '10', null, '<p>iphone7</p>', '28', '1', '13', '2017-05-29 18:49:12', '2017-06-24 22:14:39');
INSERT INTO `goods` VALUES ('37', '羽毛球拍子', '8', null, '<p>羽毛球拍子一支</p>', '29', '1', '16', '2017-06-10 16:59:54', '2017-06-10 16:59:54');
INSERT INTO `goods` VALUES ('44', '衬衫', '9', null, '<p>衬衫</p>', '9', '1', '14', '2017-06-11 20:43:15', '2017-06-11 20:43:15');
INSERT INTO `goods` VALUES ('46', '电风扇', '7', null, '<p>美的电风扇</p>', '1', '1', '15', '2017-06-25 17:33:18', '2017-06-25 17:33:18');

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
) ENGINE=InnoDB AUTO_INCREMENT=159 DEFAULT CHARSET=utf8 COMMENT='商品属性表';

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
INSERT INTO `goods_attrs` VALUES ('158', '125kg', '43', '46');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(255) NOT NULL COMMENT '权限名称',
  `route` varchar(255) DEFAULT NULL COMMENT '路由地址',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '上级权限id，0：顶级权限',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='权限表';

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', '商品管理', null, '0');
INSERT INTO `permissions` VALUES ('2', '商品列表', 'goods/lst', '1');
INSERT INTO `permissions` VALUES ('3', '添加商品', 'goods/add', '2');
INSERT INTO `permissions` VALUES ('7', '修改商品', 'goods/edit', '2');
INSERT INTO `permissions` VALUES ('9', '删除商品', 'goods/del', '2');
INSERT INTO `permissions` VALUES ('10', '权限管理', null, '0');
INSERT INTO `permissions` VALUES ('11', '权限列表', 'permission/lst', '10');
INSERT INTO `permissions` VALUES ('12', '添加权限', 'permissions/add', '11');
INSERT INTO `permissions` VALUES ('13', '修改权限', 'permissions/edit', '11');
INSERT INTO `permissions` VALUES ('14', '删除权限', 'permissions/del', '11');
INSERT INTO `permissions` VALUES ('15', '分类列表', 'sort/lst', '1');
INSERT INTO `permissions` VALUES ('16', '品牌列表', 'brand/lst', '1');
INSERT INTO `permissions` VALUES ('17', '类型列表', 'type/lst', '1');
INSERT INTO `permissions` VALUES ('18', '角色列表', 'role/lst', '10');
INSERT INTO `permissions` VALUES ('19', '管理列表', 'admin/lst', '10');
INSERT INTO `permissions` VALUES ('20', '商品类型属性', 'attribute/getAttr', '2');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('5', '客服');
INSERT INTO `roles` VALUES ('11', '测试角色权限');
INSERT INTO `roles` VALUES ('6', '编辑');
INSERT INTO `roles` VALUES ('7', '销售');

-- ----------------------------
-- Table structure for role_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE `role_permissions` (
  `role_id` int(11) NOT NULL COMMENT '角色id',
  `permission_id` int(11) NOT NULL COMMENT '权限id',
  KEY `permission_id` (`permission_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限表';

-- ----------------------------
-- Records of role_permissions
-- ----------------------------
INSERT INTO `role_permissions` VALUES ('11', '1');
INSERT INTO `role_permissions` VALUES ('11', '2');
INSERT INTO `role_permissions` VALUES ('11', '3');
INSERT INTO `role_permissions` VALUES ('11', '7');
INSERT INTO `role_permissions` VALUES ('11', '9');
INSERT INTO `role_permissions` VALUES ('6', '1');
INSERT INTO `role_permissions` VALUES ('6', '2');
INSERT INTO `role_permissions` VALUES ('6', '3');
INSERT INTO `role_permissions` VALUES ('6', '7');
INSERT INTO `role_permissions` VALUES ('6', '9');
INSERT INTO `role_permissions` VALUES ('6', '10');
INSERT INTO `role_permissions` VALUES ('6', '11');
INSERT INTO `role_permissions` VALUES ('6', '12');
INSERT INTO `role_permissions` VALUES ('6', '13');
INSERT INTO `role_permissions` VALUES ('6', '14');
INSERT INTO `role_permissions` VALUES ('7', '10');
INSERT INTO `role_permissions` VALUES ('7', '11');
INSERT INTO `role_permissions` VALUES ('7', '14');
INSERT INTO `role_permissions` VALUES ('5', '1');
INSERT INTO `role_permissions` VALUES ('5', '2');
INSERT INTO `role_permissions` VALUES ('5', '3');
INSERT INTO `role_permissions` VALUES ('5', '7');
INSERT INTO `role_permissions` VALUES ('5', '20');

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
INSERT INTO `stocks` VALUES ('44', '1000', '399.00', '148,151');
INSERT INTO `stocks` VALUES ('44', '900', '388.00', '148,152');
INSERT INTO `stocks` VALUES ('44', '800', '377.00', '148,153');
INSERT INTO `stocks` VALUES ('44', '700', '366.00', '149,151');
INSERT INTO `stocks` VALUES ('44', '600', '355.00', '149,152');
INSERT INTO `stocks` VALUES ('44', '500', '344.00', '149,153');
INSERT INTO `stocks` VALUES ('44', '400', '333.00', '150,152');
INSERT INTO `stocks` VALUES ('44', '300', '322.00', '150,153');
INSERT INTO `stocks` VALUES ('44', '300', '311.00', '150,154');
INSERT INTO `stocks` VALUES ('46', '1000', '125.00', '');

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
