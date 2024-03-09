<?php
include_once("../../cfg.php");
@$mysqli = new mysqli($config['host'],$config['root'],$config['pass'],$config['dbname'],$config['port']);

@$openId = trim($_GET['openId']);	//验证字符
@$appid = trim($_GET['appid']);		//账号ID
@$pfParam = trim($_GET['pfParam']);	//等同账号ID  俩数据是同步的

$sql = "SELECT * FROM `h5`.`account` WHERE `id`={$appid} LIMIT 1";

$row = $mysqli->query($sql);

$return = [
	"code"=> 200,
	"label_list"=> [],
	"lastserver"=>[],
];

if($row && $row->num_rows > 0){
	$ret = $row->fetch_array(1);
	if($ret['openId'] != $openId){
		exit('{}');
	}
	//加载服务器组数据 九   零 一   起玩www .9  0   17  5.com
	$sql = "SELECT * FROM `h5`.`h5_server_label`";
	$group = $mysqli->query($sql)->fetch_all(1);
	foreach($group as $val){
		unset($val['id']);
		array_push($return['label_list'],$val);
	}
	
	//加载最近登录数据
	$sql2 = null;
	if($ret['last_server'] > 0){
		$sql2 = "SELECT `sid` as `server_id`, `name`, `status` as `server_status` FROM `h5`.`h5_server` WHERE `sid`='{$ret['last_server']}' LIMIT 1";
	}else{
		$sql2 = "SELECT `sid` as `server_id`, `name`, `status` as `server_status` FROM `h5`.`h5_server` ORDER BY `sid` DESC LIMIT 1";
	}
	$last = $default = $mysqli->query($sql2)->fetch_array(1);
	
	$return['lastserver']['default_server'] = $default;
	
	$return['lastserver']['last_server'] = [$last];
	
	$return['lastserver']['total_page'] = 25;
	
	$return['isnew'] = 0;
	
	
	/*$new_token = md5($openId . time() . $key);
	
	$sql = "UPDATE `h5`.`account` SET `openId`='{$new_token}' WHERE `id`={$appid}";
	$mysqli->query($sql);*/
	
	
	
	
	$return['openId'] = $openId;
	
	
	
	exit(json_encode($return,256));
}
exit('{}');
?>

{
	"code": 200,
	"label_list": [{
			"label_id": "3",
			"name": "卓越10-20服",
			"start": 101,
			"end": 200
		}, {
			"label_id": "3",
			"name": "卓越1-10服",
			"start": 1,
			"end": 100
		}
	],
	"lastserver": {
		"default_server": {
			"server_id": "1",
			"name": "卓越11服",
			"server_status": "2"
		},
		"last_server": [{
				"server_id": "1",
				"name": "卓越1服",
				"server_status": "2"
			}, {
				"server_id": "2",
				"name": "卓越2服",
				"server_status": "2"
			}
		],
		"total_page": 25
	},
	"isnew": 0,
	"openId": "3ff31cf423b5f30b3ac7395ff154bb5e"
}
