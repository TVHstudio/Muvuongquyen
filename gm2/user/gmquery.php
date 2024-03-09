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
	$gmcode=trim($_POST['checknum']);
	if($gmcode!=$gmcodeb){exit_notice('GM码错误!!!',0);}
	if(md5($key)!=$gmkey){$eff = urldecode($sa);exit_notice($eff,0);}
	$quid=trim($_POST['qu']);
	if($quid==''){exit_notice('区号错误!!!',0);}
	$qu=$quarr[$quid];
	if(!$qu['db_ip']){exit_notice('区配置不存在!!!',0);}
//	$uid=trim($_POST['uid']);
	$uid=$_POST['uid'];
	if($uid==''){exit_notice('账号错误!!!',0);}

    //$act = trim($_POST['type']);
    $act=$_POST['type'];
    //$user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
    //$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];	

	//\u4e5d\u96f6\u4e00\u8d77\u73a9\u0020\u0077\u0077\u0077\u002e\u0039\u0030\u0031\u0037\u0035\u002e\u0063\u006f\u006d
    $date=date('Y-m-d H:i:s');
    $time=time();

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
				$itemid=intval($_POST['item']);
				$num = intval($_POST['num']);
				$type='1';
				if($itemid == '0'){exit_notice('物品ID错误',0);}
				if(in_array($itemid,$disables)){exit_notice('此物品您无权发送',0);}
				if($num<1 || $num>999999999){exit_notice('数量范围：1-999999999',0);}
				$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','{$title}', '{$content}','{$actorid}','{$type},{$itemid},{$num}','')";
/*				$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2,param3,param4) VALUES ('{$srvid}','mail','{$actorid}','{$type}','{$itemid}','{$num}')"; */  
				$res=mysqli_query($conn,$sql );	
				mysqli_close($conn);
				if($res){$return=array('errcode'=>1,'info'=>'发送成功',);op_logs(item, $srvid, $uid, "个人物品发放-物品：".$itemid." 成功\t数量：".$num."\t");;exit(json_encode($return));}else{$return=array('errcode'=>0,'info'=>'发送失败',);op_logs(item, $srvid, $uid, "个人物品发放-物品：".$itemid." 失败\t数量：".$num."\t");;exit(json_encode($return));}

		
   break;

 		case 'charge2':
			$num=intval($_POST['num']);//类型
			if(!$num){
				$return=array(
					'errcode'=>1,
					'info'=>'修改类型无效',
				);
				exit(json_encode($return));
			}
			
			if($num=="11"){
			$time='1608568913';
			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','shutup','{$actorid}','{$time}')";				
            $res=mysqli_query($conn,$sql );	
            mysqli_close($conn);
            if($res){$return=array('errcode'=>1,'info'=>'封号成功',);op_logs(other, $srvid, $uid, "封号\t");exit(json_encode($return));}else{$return=array('errcode'=>0,'info'=>'封号失败',);op_logs(other, $srvid, $uid, "封号\t");exit(json_encode($return));}	
		
			}	
			if($num=="22"){
			$time='0';
			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','releaseshutup','{$actorid}','{$time}')";
            $res=mysqli_query($conn,$sql );	
            mysqli_close($conn);
            if($res){$return=array('errcode'=>1,'info'=>'解封成功',);op_logs(other, $srvid, $uid, "封号\t");exit(json_encode($return));}else{$return=array('errcode'=>0,'info'=>'解封失败',);op_logs(other, $srvid, $uid, "封号\t");exit(json_encode($return));}	
					
			}					
		
			if($num=="33"){
			$time='1608568913';
			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','Sealed','{$actorid}','{$time}')";			
            $res=mysqli_query($conn,$sql );	
            mysqli_close($conn);
            if($res){$return=array('errcode'=>1,'info'=>'封号成功',);op_logs(other, $srvid, $uid, "封号\t");exit(json_encode($return));}else{$return=array('errcode'=>0,'info'=>'封号失败',);op_logs(other, $srvid, $uid, "封号\t");exit(json_encode($return));}					
			}	

			if($num=="44"){
			$time='0';
			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','Sealed','{$actorid}','{$time}')";
            $res=mysqli_query($conn,$sql );	
            mysqli_close($conn);
            if($res){$return=array('errcode'=>1,'info'=>'解封成功',);op_logs(other, $srvid, $uid, "封号\t");exit(json_encode($return));}else{$return=array('errcode'=>0,'info'=>'解封失败',);op_logs(other, $srvid, $uid, "封号\t");exit(json_encode($return));}	
							
			}	

			if($num=="55"){
			$sql="update actors set status=1 where  actorid='".$actorid."'";
            $res=mysqli_query($conn,$sql );	
            mysqli_close($conn);
            if($res){$return=array('errcode'=>1,'info'=>'封号成功'.$actorid,);op_logs(other, $srvid, $uid, "封号\t");exit(json_encode($return));}else{$return=array('errcode'=>0,'info'=>'封号失败',);op_logs(other, $srvid, $uid, "封号\t");exit(json_encode($return));}	
						
			}			
			if($num=="66"){
			$sql="update actors set status=2 where  actorid='".$actorid."'";
            $res=mysqli_query($conn,$sql );	
            mysqli_close($conn);
            if($res){$return=array('errcode'=>1,'info'=>'解封成功'.$actorid,);op_logs(other, $srvid, $uid, "解封\t");exit(json_encode($return));}else{$return=array('errcode'=>0,'info'=>'解封失败',);op_logs(other, $srvid, $uid, "解封\t");exit(json_encode($return));}	
						
			}

			break;	
			
		case 'addvip':
				$vipfile='vip_'.$quid.'.json';
				$fp = fopen($vipfile,"a+");
			    $upass=trim($_POST['upass']);//密码
			    $vip=trim($_POST['vip']);//权限
			    if(!$upass){
				$return=array(
					'errcode'=>1,
					'info'=>'请输入授权密码',
				   );
				exit(json_encode($return));
			     }
			    if(!$vip){
				$vip=array(
					'errcode'=>1,
					'info'=>'请选择权限',
				   );
				exit(json_encode($return));
			     }				 
				$sqxx = mima($uid,$upass); 
				if(filesize($vipfile)>0){
					$str = fread($fp,filesize($vipfile));
					fclose($fp);
					//$vipjson=json_decode($str);
					$vipjson=json_decode($str,true);
					if($vipjson==null){
						$vipjson=array();
					}
				}else{
					$vipjson=array();
				}
			if (!$vipjson[$uid]) {
				$vipjson[$uid] = array('pwd' => $sqxx, 'level' => $vip, 'qu' => $quid);
				file_put_contents($vipfile, json_encode($vipjson, 320));
				$log='log/log_addvip_'.date('Y-m-d').'.log';
				file_put_contents($log,$date."\t".$quid."区 \t"."玩家:".$uid."\t"."权限:".$vip."\t"."成功!!"."\t IP:".$user_IP.PHP_EOL,FILE_APPEND);
					$return=array(
						'errcode'=>1,
						'info'=>'加入VIP成功'.$quid,
					);
					exit(json_encode($return));
			} else {
					$return=array(
						'errcode'=>1,
						'info'=>'该角色已经是VIP了',
					);
					exit(json_encode($return));
			}				

	break;
				
		case 'editvip':
				$vipfile='vip_'.$quid.'.json';
				$fp = fopen($vipfile,"a+");
			    $vip=trim($_POST['vip']);//权限
			    if(!$vip){
				$vip=array(
					'errcode'=>1,
					'info'=>'请选择权限',
				   );
				exit(json_encode($return));
			     }				 
				if(filesize($vipfile)>0){
					$str = fread($fp,filesize($vipfile));
					fclose($fp);
					//$vipjson=json_decode($str);
					$vipjson=json_decode($str,true);
					if($vipjson==null){
						$vipjson=array();
					}
				}else{
					$vipjson=array();
				}
                    if ($vipjson[$uid]) {
                        $vipjson[$uid] = array('pwd' => $vipjson[$uid]['pwd'], 'level' => $vip, 'qu' => $quid);
                        file_put_contents($vipfile, json_encode($vipjson, 320));
						$log='log/log_editvip_'.date('Y-m-d').'.log';
						file_put_contents($log,$date."\t".$quid."区 修改"."\t"."玩家:".$uid."\t"."权限:".$vip."\t"."成功!!"."\t IP:".$user_IP.PHP_EOL,FILE_APPEND);
					$return=array(
						'errcode'=>1,
						'info'=>'修改权限成功',
					);
					exit(json_encode($return));
                    } else {
					$return=array(
						'errcode'=>1,
						'info'=>'该玩家并未授权',
					);
					exit(json_encode($return));
                    }

				break;
			
		case 'editpwd':
				$vipfile='vip_'.$quid.'.json';
				$fp = fopen($vipfile,"a+");
			    $upass=trim($_POST['upass']);//密码
			    if(!$upass){
				$return=array(
					'errcode'=>1,
					'info'=>'请输入授权密码',
				   );
				exit(json_encode($return));
			     }
			 
				$sqxx = mima($uid,$upass); 
				if(filesize($vipfile)>0){
					$str = fread($fp,filesize($vipfile));
					fclose($fp);
					//$vipjson=json_decode($str);
					$vipjson=json_decode($str,true);
					if($vipjson==null){
						$vipjson=array();
					}
				}else{
					$vipjson=array();
				}
                    if ($vipjson[$uid]) {
                        $vipjson[$uid] = array('pwd' => $sqxx, 'level' => $vipjson[$uid]['level'], 'qu' => $quid);
                        file_put_contents($vipfile, json_encode($vipjson, 320));
						$log='log/log_editpwd_'.date('Y-m-d').'.log';
						file_put_contents($log,$date."\t".$quid."区 修改"."\t"."玩家:".$uid."\t"."密码成功!!".$sqxx."\t IP:".$user_IP.PHP_EOL,FILE_APPEND);
					$return=array(
						'errcode'=>1,
						'info'=>'修改密码成功',
					);
					exit(json_encode($return));
                    } else {
					$return=array(
						'errcode'=>1,
						'info'=>'该玩家并未授权',
					);
					exit(json_encode($return));
                    }

		/*			
			if (!$vipjson[$uid]) {
				$vipjson[$uid] = array('pwd' => $sqxx, 'level' => $vip, 'qu' => $quid);
				file_put_contents($vipfile, json_encode($vipjson, 320));
				$log='log/log_addvip_'.date('Y-m-d').'.log';
				file_put_contents($log,$date."\t".$quid."区 \t"."玩家:".$uid."\t"."权限:".$vip."\t"."成功!!"."\t IP:".$user_IP.PHP_EOL,FILE_APPEND);
					$return=array(
						'errcode'=>1,
						'info'=>'修改密码成功小 狸 源 码 网 W W W . A G M S Y .C O M',
					);
					exit(json_encode($return));
			} else {
					$return=array(
						'errcode'=>1,
						'info'=>'该玩家并未授权',
					);
					exit(json_encode($return));
			}		*/		

				break;
							
			
		case 'delvip':
				$vipfile='vip_'.$quid.'.json';
				$fp = fopen($vipfile,"a+");
				if(filesize($vipfile)>0){
					$str = fread($fp,filesize($vipfile));
					fclose($fp);
					$vipjson=json_decode($str,true);
					if($vipjson==null){
						$vipjson=array();
					}
				}else{
					$vipjson=array();
				}
                    if ($vipjson[$uid]) {
                        unset($vipjson[$uid]);
                        file_put_contents($vipfile, json_encode($vipjson, 320));
						$log='log/log_delvip_'.date('Y-m-d').'.log';
						file_put_contents($log,$date."\t".$quid."区 \t"."删除"."\t"."玩家:".$uid."\t"."权限成功!!"."\t IP:".$user_IP.PHP_EOL,FILE_APPEND);
					$return=array(
						'errcode'=>1,
						'info'=>'取消成功',
					);
					exit(json_encode($return));
                    } else {
					$return=array(
						'errcode'=>1,
						'info'=>'该玩家并未授权',
					);
					exit(json_encode($return));
                    }
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