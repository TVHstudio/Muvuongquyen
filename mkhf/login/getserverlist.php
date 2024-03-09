<?php
include_once("../../cfg.php");
@$mysqli = new mysqli($config['host'],$config['root'],$config['pass'],$config['dbname'],$config['port']);

@$openId = trim($_GET['openId']);
@$appid = trim($_GET['appid']);
@$pfParam = trim($_GET['pfParam']);
//@$label_id = trim($_GET['label_id']);

@$start = trim($_GET['start']);
@$end = trim($_GET['end']);

$sql = "SELECT * FROM `h5`.`account` WHERE `id`={$appid} LIMIT 1";

$row = $mysqli->query($sql);

$serverlist = [
	"serverlist"=>[],
];

if($row && $row->num_rows > 0){
	$ret = $row->fetch_array(1);
	if($ret['openId'] != $openId){
		exit('{}');
	}
	$sql = "SELECT `sid` as `server_id`, `name`, `status` as `server_status` FROM `h5`.`h5_server` WHERE `sid` >= {$start} AND `sid` <= {$end}";
	$serverlist['serverlist'] = $mysqli->query($sql)->fetch_all(1);
	
	exit(json_encode($serverlist,256));
	
}
exit('{}');
?>