<?php
include 'config.php';
//session_start();
//error_reporting(0);
//header("Content-type: text/html; charset=utf-8");
//ini_set('date.timezone','Asia/Shanghai');
$time=time();
if(abs($time-(int)$_SESSION['lasttime'])<$frefresh){exit_notice('刷太快了!!!',0);}
$_SESSION['lasttime']=$time;
if($_POST){
	//include 'config.php';
	$quid=$_SESSION["quid"];
	if($quid==''){exit_notice('区号错误!!!',0);}
	$qu=$quarr[$quid];
	if(!$qu['db_ip']){exit_notice('区配置不存在!!!',0);}

	$uid=$_SESSION["uid"];	
	if($uid==''){exit_notice('角色名错误!!!',0);}
	$viplevel=$_SESSION["vip"];
	$act=$_POST['type'];
	$time=time();
    $date=date('Y-m-d H:i:s');
    $conn = @mysqli_connect($qu['db_ip'], $qu['db_user'], $qu['db_pswd']);
	if(!$conn){exit_notice('数据库连接失败!!!',0);}//mysqli_connect_error()
	
	@mysqli_query("set names utf8");	
	mysqli_select_db($conn,$qu['db_name']);
	//$sql="select * from `hero` where `name`='{$uid}' and `zoneid`='{$quid}' limit 1";
	$sql="SELECT `actorid` FROM `actors` WHERE `accountname` = '{$uid}'";
	$result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result);
	if($row['actorid']==''){
	    mysqli_close($conn);
		$return=array(
			'errcode'=>1,
			'info'=>'账号不存在！'.$uid,
		);
		exit(json_encode($return));
	}
	$actorid = 	$row[actorid];	
    if (empty($actorid)){exit_notice('账号ID不能为空',0);}
    //if(!preg_match('/^[0-9]{6}$/', $actorid)) {exit_notice('角色ID只能是6位数字',0);}
	$srvid=$qu['qu_port'];
	
	switch($act){
			case 'charge':

            $itemid=trim($_POST['num']);	
		    $num=intval($_POST['num2']);
            if (empty($num)) {exit_notice('数量不能为空',0);}
            if (!preg_match('/^[0-9]{1,9}$/', $num)) {exit_notice('数量只能是1-9位数字',0);}			

            if($itemid=="000000000"){
            $sql="update globaluser set rmb=rmb+{$num} where account='".$uid."'";
			$res=mysqli_query($conn,$sql );	
            mysqli_close($conn);
            if($res){$return=array('errcode'=>1,'info'=>'充值RMB成功',);op_logs(pay, $srvid, $uid, "成功RMB充值+".$num."\t");exit(json_encode($return));}else{$return=array('errcode'=>0,'info'=>'充值RMB失败',);op_logs(pay, $srvid, $uid, "充值RMB+".$num." 失败\t");exit(json_encode($return));}	

            }
            if($itemid=="111111111"){			
            $sql="insert into feecallback(serverid,openid,itemid,actor_id) values ('{$srvid}','{$uid}','{$num}','{$actorid}')";
            $res=mysqli_query($conn,$sql );	
            mysqli_close($conn);
            if($res){$return=array('errcode'=>1,'info'=>'充值成功',);op_logs(pay, $srvid, $uid, "成功充值+".$num."\t");exit(json_encode($return));}else{$return=array('errcode'=>0,'info'=>'充值失败',);op_logs(pay, $srvid, $uid, "充值+".$num." 失败\t");exit(json_encode($return));}			
            }

	break;

			
		case 'mail':
				if($viplevel<2){
					$return=array(
						'errcode'=>1,
						'info'=>'物品后台权限未开通.'
					);
					exit(json_encode($return));
				}		
				$itemid=intval($_POST['item']);
				$num = intval($_POST['num']);
				$type='1';				
				if($itemid == '0'){exit_notice('物品ID错误',0);}
				if(in_array($itemid,$disables)){exit_notice('此物品您无权发送',0);}
				if($num<1 || $num>999999999){exit_notice('数量范围：1-999999999',0);}
				
				$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','{$title}', '{$content}','{$actorid}','{$type},{$itemid},{$num}','')";
				$res=mysqli_query($conn,$sql );	
				mysqli_close($conn);
				if($res){$return=array('errcode'=>1,'info'=>'发送成功',);op_logs(item, $srvid, $uid, "个人物品发放-物品：".$itemid." 成功\t数量：".$num."\t");;exit(json_encode($return));}else{$return=array('errcode'=>0,'info'=>'发送失败',);op_logs(item, $srvid, $uid, "个人物品发放-物品：".$itemid." 失败\t数量：".$num."\t");;exit(json_encode($return));}

				break;
				
		default:
			$return=array(
				'errcode'=>1,
				'info'=>'数据错误',
			);
			exit(json_encode($return));
			break;
	}
}else{
	$return=array(
		'errcode'=>1,
		'info'=>'提交错误',
	);
	exit(json_encode($return));
}