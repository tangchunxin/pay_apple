<?php  
/**
 * @author tangchunxin
 * @final 2017022718
 */

exit();

//华南测试地址(内网/公网)，如果是服务端调用可以用内网地址
http://10.104.8.153/pay_apple/index.php
http://118.89.35.82/pay_apple/index.php



//协议规则
urlencode的格式用户信息（源格式json的）


//例子
$data = array('mod'=>'Business', 'act'=>'login', 'platform'=>'game', 'uid'=>'13671301110');
$randkey = encryptMD5($data);
$_REQUEST = array('randkey'=>$randkey, 'c_version'=>'0.0.1', 'parameter'=>json_encode($data) );



//读取kpi信息
request:
	randkey
	c_version	
	parameter 
		mod: 'Business'
		act: 'get_receipt_data'
		platform: 'gfplay'	//
		receipt:
		uid :

response:
	code //是否成功 0成功
	desc	//描述
	data:
	