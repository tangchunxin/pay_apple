<?php
/**
 * @author tangchunxin
 * @final  start:20170227
 */

namespace bigcat\controller;

use bigcat\inc\BaseFunction;
use bigcat\inc\CatMemcache;
use bigcat\conf\CatConstant;

use bigcat\model\PlayRecharge;
use bigcat\model\PlayRechargeFactory;
use bigcat\model\PlayRechargeListFactory;
use bigcat\model\PlayRechargeMultiFactory;


class Business
{
	private $log = './log/business.log';


///////////////////静态方法////////////////////////////
//玩家充值
	private function play_recharge($params)
	{
		global $DEBUG;
		$response = array('code' => CatConstant::OK, 'desc' => __LINE__, 'sub_code' => 0);
		$rawsqls = array();
		$itime = time();
		$data = array();
		$data_tmp = array();
		$tmp = array();

		do {
			if (empty($params['p_aid']) || !$params['p_aid']
			|| 	empty($params['recharge_amount'])
			|| 	empty($params['aid'])
			|| 	empty($params['work_url'])
			|| 	empty($params['http_url'])
			)
			{
				$response['code'] = CatConstant::ERROR; $response['desc'] = __line__; break;
			}

			if($params['recharge_amount'] <= 0 || floor($params['recharge_amount']) != $params['recharge_amount'])
			{
				$response['code'] = CatConstant::ERROR;$response['desc'] = __line__;	break;
			}

			//$mcobj = BaseFunction::getMC();

			////////////获取玩家昵称  远程游戏http协议/////////////////
			$data_request = array(
			'mod' => 'Business'
			, 'act' => 'get_user'
			, 'platform' => 'gfplay'
			, 'uid' => $params['p_aid']
			);

			$randkey = BaseFunction::encryptMD5($data_request);
			$url = $params['http_url'] . "?randkey=" . $randkey . "&c_version=0.0.1";
			$result = json_decode(BaseFunction::https_request($url, array('parameter' => json_encode($data_request))));
			if (!$result || !isset($result->code) || $result->code != 0 || (isset($result->sub_code) && $result->sub_code != 0)) {
				BaseFunction::logger($this->log, "【data_request】:\n" . var_export($data_request, true) . "\n" . __LINE__ . "\n");
				BaseFunction::logger($this->log, "【result】:\n" . var_export($result, true) . "\n" . __LINE__ . "\n");
				$response['code'] = CatConstant::ERROR; $response['desc'] = __line__; break;
			}

			$tmp['nickName'] = $result->data->obj_user->name;
			$tmp['last_amount'] = $result->data->obj_user_game->currency;

			/////////////////////给玩家充值  远程游戏 http协议////////////////////
			$data_request = array(
			'mod' => 'Business'
			, 'act' => 'checkout_open_room'
			, 'platform' => 'gfplay'
			, 'uid' => $params['p_aid']
			, 'type' => '2'
			, 'currency' => $params['recharge_amount']
			);

			$randkey = BaseFunction::encryptMD5($data_request);
			$url = $params['http_url'] . "?randkey=" . $randkey . "&c_version=0.0.1";
			$result = json_decode(BaseFunction::https_request($url, array('parameter' => json_encode($data_request))));
			if (!$result || !isset($result->code) || $result->code != 0 || (isset($result->sub_code) && $result->sub_code != 0)) {
				BaseFunction::logger($this->log, "【data_request】:\n" . var_export($data_request, true) . "\n" . __LINE__ . "\n");
				BaseFunction::logger($this->log, "【result】:\n" . var_export($result, true) . "\n" . __LINE__ . "\n");
				$response['code'] = CatConstant::ERROR; $response['desc'] = __line__; break;
			}

			////////////////////////work写充值记录  远程协议/////////////////////////////
			$data_request = array(
			'mod' => 'Business'
			, 'act' => 'pay_apple'
			, 'platform' => 'tocar'
			, 'aid' => $params['aid']
			, 'p_aid' => $params['p_aid']
			, 'nickName' => $tmp['nickName']
			, 'last_amount' => $tmp['last_amount']
			, 'recharge_amount' => $params['recharge_amount']
			);

			$randkey = BaseFunction::encryptMD5($data_request);
			$url = $params['work_url'] . "?randkey=" . $randkey . "&c_version=0.0.1";
			//BaseFunction::logger($this->log, "【result】:\n" . var_export($url, true) . "\n" . __LINE__ . "\n");
			$result = json_decode(BaseFunction::https_request($url, array('parameter' => json_encode($data_request))));
			if (!$result || !isset($result->code) || $result->code != 0 || (isset($result->sub_code) && $result->sub_code != 0))
			{
				BaseFunction::logger($this->log, "【data_request】:\n" . var_export($data_request, true) . "\n" . __LINE__ . "\n");
				BaseFunction::logger($this->log, "【result】:\n" . var_export($result, true) . "\n" . __LINE__ . "\n");
				//$response['sub_code'] = $result->sub_code;  //sub_code =2
				$response['code'] = CatConstant::ERROR; $response['desc'] = __line__; break;
			}

			$response['data'] = $data;
		} while (false);

		return $response;
	}


////////////   自己游戏 充值in app purchase////////////////////////////
//post验证协议
	public function get_receipt_data($params)
	{
		global $APPLY_PAY,$APPLY_PAY_TEST,$IAPCHECK_ISSANDBOX,$DEBUG;
		$response = array('code' => CatConstant::OK, 'desc' => __LINE__, 'sub_code' => 0);

		$data = array();
		$tmp = array();
		$data_info = '';

		do {
			if (empty($params['receipt'])
			 || empty($params['uid'])
			 )
			{
				$response['code'] = CatConstant::ERROR; $response['desc'] = __line__; break;
			}

			if ($DEBUG)
	        {
	            $url = $APPLY_PAY_TEST;  //沙盒环境
	        }
	        else
	        {
	            $url = $APPLY_PAY;   //正式环境
	        }

	        //请求苹果 二次验证
	        $data = BaseFunction::https_request_iap($url,$params['receipt']);

	        //判断返回的数据是否是对象
	        if (!is_object($data))
	        {
	            $response['code'] = CatConstant::ERROR; $response['desc'] = __line__; break;
	        }

	        //非正式环境21007   修改成沙盒环境
	        if( isset($data->status) && ($data->status == 21007 || $data->status == 21008) )
	        {
				//$url = $APPLY_PAY_TEST;  //正式环境
				if ($DEBUG)
				{
					$url = $APPLY_PAY;  //正式环境
				}
				else
				{
					$url = $APPLY_PAY_TEST;   //沙盒环境
				}
	        	$data = BaseFunction::https_request_iap($url,$params['receipt']);//生成请求的句柄文件
	        }
		    BaseFunction::logger($this->log, "【data】:\n" . var_export($data, true) . "\n" . __LINE__ . "\n");

	        //判断是否购买成功
	        if (!isset($data->status) || $data->status != 0)
	        {
	            BaseFunction::logger($this->log, "【data_status】:\n" . var_export($data->status, true) . "\n" . __LINE__ . "\n");
	            $response['code'] = CatConstant::ERROR; $response['desc'] = __line__; break;
	        }
	        else
	        {
	       		 $tmp =  array(
	                'quantity' => $data->receipt->in_app[0]->quantity,
	                'product_id' => $data->receipt->in_app[0]->product_id,
	                'transaction_id' => $data->receipt->in_app[0]->transaction_id,
	                'purchase_date' => $data->receipt->in_app[0]->purchase_date,
	       		 );
				 BaseFunction::logger($this->log, "【data_status】:\n" . var_export($data->status, true) . "\n" . __LINE__ . "\n");
				 BaseFunction::logger($this->log, "【tmp】:\n" . var_export($tmp, true) . "\n" . __LINE__ . "\n");

				 if(empty($data->receipt->in_app))
				 {
				 	BaseFunction::logger($this->log, "【in_app】:\n" . var_export('sub_code = 3,交易已经取消', true) . "\n" . __LINE__ . "\n");
				 	$response['sub_code'] = 3; $response['desc'] = __line__; break;
				 }
				 else
				 {
				 	$tmp_product = $data->receipt->in_app[0]->product_id;
				 	$tmp_product = substr($tmp_product,strrpos($tmp_product,'.')+1);
					if('diamond15' == $tmp_product)
					{
						$recharge_amount = CatConstant::PRODUCT_ID_15;
					}
					elseif('diamond60' == $tmp_product)
					{
						$recharge_amount = CatConstant::PRODUCT_ID_60;
					}
					elseif('diamond150' == $tmp_product)
					{
						$recharge_amount = CatConstant::PRODUCT_ID_150;
					}
					elseif('diamond320' == $tmp_product)
					{
						$recharge_amount = CatConstant::PRODUCT_ID_320;
					}
					else
					{
						$response['sub_code'] = 1; $response['desc'] = __line__; break;
					}

					$params['aid'] = $data->receipt->in_app[0]->transaction_id;  //订单编号作为aid字段
					$params['p_aid'] = $params['uid'];                //玩家id

					$work_url = substr($data->receipt->in_app[0]->product_id,0,strpos($data->receipt->in_app[0]->product_id,'.gfplay')) ;
					$params['work_url'] = CatConstant::WORK_URL[$work_url];    //work 模块写充值记录
					$params['http_url'] = CatConstant::HTTP_URL[$work_url];    //游戏http  模块 给玩家充钻

					//兼容沧州
					if(!empty(CatConstant::PAY_MONEY[$work_url]))
					{
						$recharge_amount = CatConstant::PAY_MONEY[$work_url][$tmp_product];
					}

					$params['recharge_amount'] = $recharge_amount;    //充值数量
					//////////////////////////调用给玩家充值/////////////////////////
					$result = $this->play_recharge($params);
					if (!$result || !isset($result['code']) || $result['code'] != 0 || (isset($result['sub_code']) && $result['sub_code']!= 0) )
					{
						BaseFunction::logger($this->log, "【result】:\n" . var_export($result, true) . "\n" . __LINE__ . "\n");

						//判断订单编号是否重复重复
						if( $result['sub_code'] == 2)
						{
							$data_info = 'get_receipt_data_repeat';  //一个描述而已,没有具体含义
							$response['sub_code'] = 2; $response['desc'] = __line__; break;
						}
						$response['code'] = CatConstant::ERROR_UPDATE; $response['desc'] = __line__; break;
					}
					else
					{
						$data_info = 'get_receipt_data_success'; //一个描述而已,没有具体含义
						BaseFunction::logger($this->log, "【result111】:\n" . var_export($result, true) . "\n" . __LINE__ . "\n");
					}
				}
	        }

			$response['data'] = $data_info;
		} while (false);
		return $response;

	}




}//





