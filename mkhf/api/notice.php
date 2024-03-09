<?php

include_once("../../cfg.php");

@$mysqli = new mysqli($config['host'],$config['root'],$config['pass'],$config['dbname'],$config['port']);

if($mysqli->connect_errno){
	exit("数据库连接错误" . $mysqli->connect_error);
}

$sql = "SELECT * FROM `h5`.`h5_notice` WHERE `id`='1'";
$row = $mysqli->query($sql);

if($row === false){
	exit(json_encode(array("code"=>0,"msg"=>$mysqli->error)));
}
$data = $row->fetch_array(1);
exit(json_encode(array("notice"=>$data['content'] )));