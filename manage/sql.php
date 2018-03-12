<?php
exit();

//SET FOREIGN_KEY_CHECKS = 0;

/*------- CREATE SQL---------*/
CREATE TABLE `agent_buy` (
  `buy_aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长id',
  `aid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '代理ID',
  `money` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '购钻金额',
  `buy_amount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '购钻数量',
  `buy_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '购钻来源(1:支付宝   2:手动购钻 3:代理返利  4:活动奖励 5:充值奖励)',
  `activity_info` varchar(512) NOT NULL DEFAULT '' COMMENT '详情(如有活动奖励钻,需说明详细情况)',
  `handler` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '操作人id',
  `buy_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '购钻时间',
  `month` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '月份',
  PRIMARY KEY (`buy_aid`),
  KEY `month` (`month`) USING BTREE,
  KEY `handler_month_buy_status` (`handler`,`month`,`buy_status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COMMENT='代理购钻表'


/*------- CREATE SQL---------*/
CREATE TABLE `agent_info` (
  `aid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '代理ID',
  `wx_id` char(32) NOT NULL DEFAULT '' COMMENT '微信ID',
  `name` char(32) NOT NULL DEFAULT '' COMMENT '代理姓名',
  `provinces` char(32) NOT NULL DEFAULT '' COMMENT '所在省份',
  `city` char(32) NOT NULL DEFAULT '' COMMENT '所在城市',
  `p_aid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '推荐人ID',
  `opend_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '开通代理的方式(1:默认,审核通过方式  2:直接开通代理)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '审核状态(1:待审核通过  2:通过  3:拒绝,直接删除)',
  `audit_eid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '审核人id',
  `info` varchar(512) NOT NULL DEFAULT '' COMMENT '备注',
  `last_amount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '剩余钻数',
  `init_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '加入时间',
  `month` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '格式化时间201611',
  PRIMARY KEY (`aid`),
  KEY `status` (`status`),
  KEY `audit_opend_status_month` (`audit_eid`,`opend_status`,`month`) USING BTREE,
  KEY `p_aid` (`p_aid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='代理信息表'

/*------- CREATE SQL---------*/
CREATE TABLE `agent_return` (
  `return_aid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长id',
  `aid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '代理ID',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '领取状态(1:待结算  2:已领取)',
  `month` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '返利月份',
  PRIMARY KEY (`return_aid`),
  UNIQUE KEY `aid_month` (`aid`,`month`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='代理返利表'

/*------- CREATE SQL---------*/
CREATE TABLE `play_recharge` (
  `play_rid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长id\n',
  `play_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '玩家id\n',
  `play_name` char(32) NOT NULL DEFAULT '' COMMENT '玩家昵称 ',
  `last_amount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '玩家剩余钻数',
  `recharge_amount` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '玩家充值钻数',
  `play_sum_amount` int(11) unsigned NOT NULL COMMENT '充值后钻数量',
  `aid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '充钻的代理ID',
  `recharge_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '充值时间',
  PRIMARY KEY (`play_rid`),
  KEY `recharge_time` (`recharge_time`) USING BTREE,
  KEY `aid` (`aid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='玩家充值表'

/*------- CREATE SQL---------*/
CREATE TABLE `service_note` (
  `sid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长id',
  `name` char(32) NOT NULL DEFAULT '' COMMENT '姓名',
  `tel` bigint(20) NOT NULL DEFAULT '0' COMMENT '联系方式',
  `a_p_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '玩家id代理ID(手机号)',
  `user_type` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '身份(1:代理   2:玩家)',
  `area` char(32) NOT NULL DEFAULT '' COMMENT '地区',
  `complain_consult` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '投诉/咨询(1:投诉   2:咨询)',
  `info` varchar(512) NOT NULL DEFAULT '' COMMENT '具体内容',
  `answer` varchar(512) NOT NULL DEFAULT '' COMMENT '问题解答',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '处理状态(1:流转中  2:处理中   3:已完成)',
  `problem_types` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '问题类型(1:系统问题   2:财务问题  3:运营问题  4:其他)',
  `submit_uid` bigint(20) NOT NULL DEFAULT '0' COMMENT '提交人id',
  `solver_uid` bigint(20) NOT NULL DEFAULT '0' COMMENT '处理人id',
  `receive_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '接待时间',
  `over_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '处理完成时间',
  PRIMARY KEY (`sid`),
  KEY `a_p_id` (`a_p_id`),
  KEY `complain_consult_status` (`complain_consult`,`status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='客户服务记录表'

/*------- CREATE SQL---------*/
CREATE TABLE `user` (
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '员工ID',
  `service_name` char(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '部门(1:拓展部  2:客服  )',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '预留状态',
  `init_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='客服人员信息表'