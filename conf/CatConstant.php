<?php
/**
 * @author xuqiang76@163.com
 * @final 20160929
 */

namespace bigcat\conf;

class CatConstant
{

	const C_VERSION = '0.0.1';
	const CONF_VERSION = '0.0.1';
	const SECRET = 'Keep it simple stupid!';
	const CDKEY  = 'God bless you!';
	const LOG_FILE = './log/business.log';
	const CACHE_TYPE = '\bigcat\inc\CatMemcache';
	const C_VERSION_CHECK = true;
	const STR_OBJ = 1; //缓存字符串rad 验证


	const OK = 0;
	const ERROR = 1;
	const ERROR_MC = 2;
	const ERROR_INIT = 3;
	const ERROR_UPDATE = 4;
	const ERROR_VERIFY = 5;
	const ERROR_ARGUMENT = 6;
	const ERROR_VERSION = 7;

	const MODELS = array('Business' => '\bigcat\controller\Business');
	const UNCHECK_C_CERSION_ACT = array('Business' => [
													   'get_receipt_data'
		                                               ]);
	const UNCHECK_VERIFIED_ACT = array('Business' => ['get_receipt_data'

													 ]);

	const SUB_DESC = array(
						'Business_get_receipt_data' => array('sub_code_1'=>'购买数量错误','sub_code_2'=>'订单号重复,该交易已完成','sub_code_3'=>'交易已经取消')

						);
    //app store  购买的钻石
	const PRODUCT_ID_15 = 3;
	const PRODUCT_ID_60 = 12;
	const PRODUCT_ID_150 = 32;
	const PRODUCT_ID_320 = 70;

	//兼容 沧州苹果支付
	const PAY_MONEY = array(
							'cangzhou'=>array('diamond15'=>15,'diamond60'=>32,'diamond150'=>66,'diamond320'=>150)   //10钻  20钻 ....
							,'tianjin'=>array('diamond15'=>6,'diamond60'=>15,'diamond150'=>33,'diamond320'=>70)   //10钻  20钻 ....
							,'langfang'=>array('diamond15'=>6,'diamond60'=>12,'diamond150'=>25,'diamond320'=>55)   //10钻  20钻 ....
							,'wenan'=>array('diamond15'=>6,'diamond60'=>12,'diamond150'=>25,'diamond320'=>55)   //10钻  20钻 ....
							,'baodingnew'=>array('diamond15'=>6,'diamond60'=>15,'diamond150'=>33,'diamond320'=>70)   //10钻  20钻 ....

		);

	//游戏http 玩家充值
	const HTTP_URL = array('cn' => 'http://118.89.47.192/mahjong/game_s_http/index.php'  //四川http  118.89.47.192

							,'na' => 'http://na.gfplay.cn/mahjong/game_s_http/index.php'  //北美华人 http 45.113.70.128

							,'sx' => 'http://sx.gfplay.cn:81/mahjong/game_s_http/index.php'  //陕西http  118.89.21.55

							,'cd' => 'http://chengdecdn.gfplay.cn/mahjong/game_s_http_chengde/index.php'  //承德http  211.159.149.156

							,'baoding' => 'http://baodingcdn.gfplay.cn/mahjong/game_s_http_new/index.php'  //保定
							
							,'baodingnew' => 'http://baodingcdn.gfplay.cn/mahjong/game_s_http_newnew/index.php'  //保定newnew

							,'lishui' => 'http://lishui.gfplay.cn:82/mahjong/game_s_http/index.php'  //丽水http

							,'xj' => 'http://xinji.gfplay.cn:83/mahjong/game_s_http/index.php'  //辛集http

							,'dezhou' => 'http://dezhou.gfplay.cn:83/mahjong/game_s_http_dezhou/index.php'  //德州http

							,'hb' => 'http://hbcdn.gfplay.cn/mahjong/game_s_http/index.php'  //河北全集http

							,'jiamusi1' => 'http://jiamusicdn.gfplay.cn/mahjong/game_s_http_jiamusi_new/index.php'  //佳木斯http

							,'chifeng' => 'http://chifengcdn.gfplay.cn/mahjong/game_s_http_chifeng/index.php'  //赤峰

							,'cangzhou' => 'http://cangzhou.linfiy.com/mahjong/game_s_http_cangzhou/index.php'  //沧州

							,'tianjin' => 'http://tianjin.linfiy.com/mahjong/game_s_http_tianjin/index.php'  //天津

							,'langfang' => 'http://langfang.linfiy.com/mahjong/game_s_http_langfang/index.php'  //廊坊
							
							,'wenan' => 'http://langfang.linfiy.com/mahjong/game_s_http_langfang/index.php'  //廊坊

							);
	//work 玩家充值记录
	const WORK_URL = array('cn' => 'http://work.linfiy.com/mahjong/game_agent/big_agent/index.php'  //四川  118.89.35.82

							,'na' => 'http://na.gfplay.cn/mahjong/game_agent/big_agent/index.php'  //北美 华人  45.113.70.128

							,'sx' => 'http://work.linfiy.com/mahjong/game_agent/big_agent_sx/index.php'  //陕西  118.89.35.82

							,'cd' => 'http://work.linfiy.com/mahjong/game_agent/big_agent_chengde/index.php'  //承德  118.89.35.82

							,'baoding' => 'http://work.linfiy.com/mahjong/game_agent/big_agent_baoding/index.php'  //保定
							
							,'baodingnew' => 'http://work.linfiy.com/mahjong/game_agent/city_agent_baodingnew/index.php'  //保定

							,'lishui' => 'http://work.linfiy.com/mahjong/game_agent/big_agent_lishui/index.php'  //丽水

							,'xj' => 'http://work.linfiy.com/mahjong/game_agent/big_agent_xinji/index.php'  //辛集

							,'dezhou' => 'http://work.linfiy.com/mahjong/game_agent/big_agent_dezhou/index.php'  //德州

							,'hb' => 'http://work.linfiy.com/mahjong/game_agent/big_agent_hb/index.php'  //河北全集

							,'jiamusi1' => 'http://work.linfiy.com/mahjong/game_agent/fair_agent_jiamusi/index.php'  //佳木斯

							,'chifeng' => 'http://work.linfiy.com/mahjong/game_agent/fair_agent_chifeng/index.php'  //赤峰

							,'cangzhou' => 'http://work.linfiy.com/mahjong/game_agent/city_agent/index.php'  //沧州

							,'tianjin' => 'http://work.linfiy.com/mahjong/game_agent/city_agent_tianjin/index.php'  //tainjin

							,'langfang' => 'http://work.linfiy.com/mahjong/game_agent/city_agent_langfang/index.php'  //廊坊

							,'wenan' => 'http://work.linfiy.com/mahjong/game_agent/city_agent_langfang/index.php'  //廊坊

							);

}
