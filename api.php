<?php
//error_reporting(0);

if(!isset($_POST) || !isset($_GET['act'])){
	exit;
}

include_once("./cfg.php");

@$mysqli = new mysqli($config['host'],$config['root'],$config['pass'],$config['dbname'],$config['port']);

if($mysqli->connect_errno){
	exit("Database connection error" . $mysqli->connect_error);
}

session_start();

$type = trim($_GET['act']);

switch($type){
	case 'reg':	//注册请求
		$username = trim($_POST['username']);
		$password = md5(trim($_POST['password']));
		$password1 = md5(trim($_POST['password1']));
		$qd = trim($_POST['qd']);
		if(strlen($username) < 1){
			exit(json_encode(array("code"=>0,"msg"=>"Please fill in the correct account number")));
		}
		if(strlen($password) < 1){
			exit(json_encode(array("code"=>0,"msg"=>"Please fill in the correct password")));
		}
		if($password != $password1){
			exit(json_encode(array("code"=>0,"msg"=>"Two passwords are inconsistent")));
		}
		$sql = "SELECT * FROM `h5`.`account` WHERE `account`='{$username}'";
		$row = $mysqli->query($sql);
		if($row === false){
			exit(json_encode(array("code"=>0,"msg"=>$mysqli->error)));
		}
		if($row->num_rows > 0){
			exit(json_encode(array("code"=>0,"msg"=>"This account has been used")));
		}
		
		$token = md5($username . time() . $key);
		$sql = "INSERT INTO `h5`.`account` (`account`, `pass`, `serverindex`, `updatetime`, `qudao`, `openId`) VALUES ('{$username}', '{$password}', '1', NOW(), '{$qd}', '{$token}')";
		$row = $mysqli->query($sql);
		if($row === false){
			exit(json_encode(array("code"=>0,"msg"=>$mysqli->error)));
		}
		if($mysqli->errno){
			exit($mysqli->error);
		}
		/*$ret = array(
			"code"=>1,
			"msg"=>"success",
			"pfId"=>"mkhf",
			"gameId"=>102,
			"passId"=>$data['id'],
			"openId"=>$token,
			"nonce"=>"xW0IR4xx",
			"ts"=>time(),
			"serverUrl"=>"",
		);
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		$_SESSION['token'] = $token;
		exit(json_encode($ret));
		break;*/
		$type = "login";
	case "login":
		$username = trim($_POST['username']);
		$password = md5(trim($_POST['password']));
		if(strlen($username) < 1){
			exit(json_encode(array("code"=>0,"msg"=>"Please fill in the correct account number")));
		}
		if(strlen($password) < 1){
			exit(json_encode(array("code"=>0,"msg"=>"Please fill in the correct password")));
		}
		$sql = "SELECT * FROM `h5`.`account` WHERE `account`='{$username}' LIMIT 1";
		$row = $mysqli->query($sql);
		if($row === false){
			exit(json_encode(array("code"=>0,"msg"=>$mysqli->error)));
		}
		if($row->num_rows < 1){
			exit(json_encode(array("code"=>0,"msg"=>"Account does not exist")));	
		}
		$data = $row->fetch_array(1);
		if($data['pass'] != $password){
			exit(json_encode(array("code"=>0,"msg"=>"wrong password")));
		}
		$token = md5($username . time() . $key);
		$sql = "UPDATE `h5`.`account` SET `openId`='{$token}' WHERE `account`='{$username}'";
		$mysqli->query($sql);	
		if($mysqli->errno){
			exit($mysqli->error);
		}
		$ret = array(
			"code"=>1,
			"msg"=>"success",
			"pfId"=>"mkhf",
			"gameId"=>102,
			"passId"=>$data['id'],
			"openId"=>$token,
			"nonce"=>"xW0IR4xx",
			"ts"=>"1626946832477",
			"serverUrl"=>"undefined",
			"sign"=>"4214854f388ae885856c982c60d8060e",
		);
		$_SESSION = $ret;
		unset($_SESSION['code']);
		unset($_SESSION['msg']);
		exit(json_encode($ret));
		break;
}













?>