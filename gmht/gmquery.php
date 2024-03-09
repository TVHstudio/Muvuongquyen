<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
if($_POST){
	include 'config.php';
	$gmcode=trim($_POST['checknum']);
	if($gmcode!='bigpatreon'){
		$return=array(
			'errcode'=>1,
			'info'=>'GM code is wrong',
		);
		exit(json_encode($return));
	}
	$quid=trim($_POST['qu']);
	if($quid==''){
		$return=array(
			'errcode'=>1,
			'info'=>'wrong server',
		);
		exit(json_encode($return));
	}
	$qu=$quarr[$quid];
	if(!$qu['ip']){
		$return=array(
			'errcode'=>1,
			'info'=>'Server configuration not available',
		);
		exit(json_encode($return));
	}
	$uid=trim($_POST['uid']);
	if($uid==''){
		$return=array(
			'errcode'=>1,
			'info'=>'Role ID error',
		);
		exit(json_encode($return));
	}
	$srvid=$qu['srvid'];
	$act=$_POST['type'];
	switch($act){
		case 'charge':
			$num=intval($_POST['num']);
			if(!$num){
				$return=array(
					'errcode'=>1,
					'info'=>'Deposited amount is incorrect',
				);
				exit(json_encode($return));
			}
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT `actorid` FROM `actors` WHERE `accountname` = '{$uid}'";
			
/* 			$sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$actorid = 	$row[actorid];	
			/* $uid=$row['actorid']; */
			$sql="insert into feecallback(serverid,openid,itemid,actor_id) values ('{$srvid}','{$uid}','{$num}','{$actorid}')";
			
/* 			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','Recharge','{$uid}','{$num}')"; */
            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'Deposit successful!',
				);
				exit(json_encode($return));
			break;
		case 'mail':
			$itemid=intval($_POST['item']);
			$num=intval($_POST['num']);
			$type='1';
			if(!$num){
				$return=array(
					'errcode'=>1,
					'info'=>'wrong amount',
				);
				exit(json_encode($return));
			}
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";
			
			/* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','Letter GM RAGEZONE bigpatreon', 'Gift received successfully','{$uid}','{$type},{$itemid},{$num}','')";
/* 			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2,param3,param4) VALUES ('{$srvid}','mail','{$uid}','{$type}','{$itemid}','{$num}')"; */            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'Successful!',
				);
				exit(json_encode($return));
			break;
		case 'allmail':
			$itemid=intval($_POST['item']);
			$num=intval($_POST['num']);
			$type='1';
			if(!$num){
				$return=array(
					'errcode'=>1,
					'info'=>'wrong amount',
				);
				exit(json_encode($return));
			}
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";
			
			/* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendGlobalMail','forum.ragezone.com sunucusunun tamamı için 'bigpatreon' ekleyin', 'Hepinize oyunu oynarken iyi eğlenceler dilerim！','{$type},{$itemid},{$num}','','')";
/* 			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2,param3,param4) VALUES ('{$srvid}','mail','{$uid}','{$type}','{$itemid}','{$num}')"; */            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'Successfully sent to all servers!',
				);
				exit(json_encode($return));
			break;
		case 'tc10':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";
			
			/* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','Accumulated deposit of 300K for welfare letter', '1498 Recharge card*2','{$uid}','1,340032,2',''),('{$srvid}','1','sendMail','Accumulated deposit of 300K for welfare letter', '1000 100M EXP Cards*5','{$uid}','1,340039,5',''),('{$srvid}','1','sendMail','Accumulated deposit of 300K for welfare letter', 'Awesome dragon*1','{$uid}','1,1010117,1',''),('{$srvid}','1','sendMail','Accumulated deposit of 300K for welfare letter', 'Heavenly wings*1','{$uid}','1,1081013,1',''),('{$srvid}','1','sendMail','Accumulated deposit of 300K for welfare letter', 'Ban Long Ngao Thien Giap*1','{$uid}','1,1082013,1',''),('{$srvid}','1','sendMail','Accumulated deposit of 300K for welfare letter', 'Đặc giới đế vương*1','{$uid}','1,1083013,1',''),('{$srvid}','1','sendMail','Accumulated deposit of 300K for welfare letter', 'Phuong Thien War God*1','{$uid}','1,1050003,1',''),('{$srvid}','1','sendMail','Accumulated deposit of 300K for welfare letter', 'U Minh mercenaries*1','{$uid}','1,1060003,1',''),('{$srvid}','1','sendMail','Accumulated deposit of 300K for welfare letter', 'Judgment of Ancient Dragon*1','{$uid}','1,1070005,1',''),('{$srvid}','1','sendMail','Accumulated deposit of 300K for welfare letter', 'Treasure pot card*1','{$uid}','1,340014,1','')";
/* 			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2,param3,param4) VALUES ('{$srvid}','mail','{$uid}','{$type}','{$itemid}','{$num}')"; */            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'Successful!',
				);
				exit(json_encode($return));
			break;
		case 'tc50':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";
			
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','Accumulate deposit of 1,000,000$ for welfare letter', '1498 Recharge card*3','{$uid}','1,340032,3',''),('{$srvid}','1','sendMail','Accumulate deposit of 1,000,000$ for welfare letter', '1000 100M EXP Cards*10','{$uid}','1,340039,10',''),('{$srvid}','1','sendMail','Accumulate deposit of 1,000,000$ for welfare letter', 'Awesome dragon*3','{$uid}','1,1010117,3',''),('{$srvid}','1','sendMail','Accumulate deposit of 1,000,000$ for welfare letter', 'Heavenly wings*3','{$uid}','1,1081013,3',''),('{$srvid}','1','sendMail','Accumulate deposit of 1,000,000$ for welfare letter', 'Ban Long Ngao Thien Giap*3','{$uid}','1,1082013,3',''),('{$srvid}','1','sendMail','Accumulate deposit of 1,000,000$ for welfare letter', 'Imperial special status*3','{$uid}','1,1083013,3',''),('{$srvid}','1','sendMail','Accumulate deposit of 1,000,000$ for welfare letter', 'Phuong Thien War God*3','{$uid}','1,1050003,3',''),('{$srvid}','1','sendMail','Accumulate deposit of 1,000,000$ for welfare letter', 'U Minh mercenaries*3','{$uid}','1,1060003,3',''),('{$srvid}','1','sendMail','Accumulate deposit of 1,000,000$ for welfare letter', 'Judgment of Ancient Dragon*3','{$uid}','1,1070005,3',''),('{$srvid}','1','sendMail','Accumulate deposit of 1,000,000$ for welfare letter', 'Bodyguard ring card*1','{$uid}','1,340013,1','')";
			$obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'Successful!',
				);
				exit(json_encode($return));
			break;
		case 'tc100':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";
			
			/* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','Accumulated deposit of 1,500,000$ for welfare letter', '1498$ Recharge card*5','{$uid}','1,340032,5',''),('{$srvid}','1','sendMail','Accumulated deposit of 1,500,000$ for welfare letter', '1000 100M EXP Cards*15','{$uid}','1,340039,15',''),('{$srvid}','1','sendMail','Accumulated deposit of 1,500,000$ for welfare letter', 'Awesome dragon*5','{$uid}','1,1010117,5',''),('{$srvid}','1','sendMail','Accumulated deposit of 1,500,000$ for welfare letter', 'Heavenly wings*5','{$uid}','1,1081013,5',''),('{$srvid}','1','sendMail','Accumulated deposit of 1,500,000$ for welfare letter', 'Ban Long Ngao Thien Giap*5','{$uid}','1,1082013,5',''),('{$srvid}','1','sendMail','Accumulated deposit of 1,500,000$ for welfare letter', 'Imperial special status*5','{$uid}','1,1083013,5',''),('{$srvid}','1','sendMail','Accumulated deposit of 1,500,000$ for welfare letter', 'Phuong Thien War God*5','{$uid}','1,1050003,5',''),('{$srvid}','1','sendMail','Accumulated deposit of 1,500,000$ for welfare letter', 'U Minh mercenaries*5','{$uid}','1,1060003,5',''),('{$srvid}','1','sendMail','Accumulated deposit of 1,500,000$ for welfare letter', 'Judgment of Ancient Dragon*5','{$uid}','1,1070005,5',''),('{$srvid}','1','sendMail','Accumulated deposit of 1,500,000$ for welfare letter', 'Absolute inflammation*5','{$uid}','1,1089006,5','')";
			$obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'Successful!',
				);
				exit(json_encode($return));
			break;
		case 'tc200':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";
			
			/* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','Accumulate deposit of 3,000,000$ for benefit letter', '1498$ Recharge card*10','{$uid}','1,340032,10',''),('{$srvid}','1','sendMail','Accumulate deposit of 3,000,000$ for benefit letter', '1000 Cards 100M EXP*20','{$uid}','1,340039,20',''),('{$srvid}','1','sendMail','Accumulate deposit of 3,000,000$ for benefit letter', 'Awesome dragon*10','{$uid}','1,1010117,10',''),('{$srvid}','1','sendMail','Accumulate deposit of 3,000,000$ for benefit letter', 'Heavenly wings*10','{$uid}','1,1081013,10',''),('{$srvid}','1','sendMail','Accumulate deposit of 3,000,000$ for benefit letter', 'Ban Long Ngao Thien Giap*10','{$uid}','1,1082013,10',''),('{$srvid}','1','sendMail','Accumulate deposit of 3,000,000$ for benefit letter', 'Imperial special status*10','{$uid}','1,1083013,10',''),('{$srvid}','1','sendMail','Accumulate deposit of 3,000,000$ for benefit letter', 'Phuong Thien War God*10','{$uid}','1,1050003,10',''),('{$srvid}','1','sendMail','Accumulate deposit of 3,000,000$ for benefit letter', 'U Minh mercenaries*10','{$uid}','1,1060003,10',''),('{$srvid}','1','sendMail','Accumulate deposit of 3,000,000$ for benefit letter', 'Judgment of Ancient Dragon*10','{$uid}','1,1070005,10',''),('{$srvid}','1','sendMail','Accumulate deposit of 3,000,000$ for benefit letter', 'Absolute inflammation*10','{$uid}','1,1089006,10','')";
			$obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'Successful!',
				);
				exit(json_encode($return));
			break;
		case 'tc300':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";
			
			/* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','GM Recharge 2,000 $', '1498$ Recharge card*15','{$uid}','1,340032,15',''),('{$srvid}','1','sendMail','GM Recharge 2,000 $', '1000 Cards 100M EXP*30','{$uid}','1,340039,30',''),('{$srvid}','1','sendMail','GM Recharge 2,000 $', 'naval anchor*5','{$uid}','1,1010116,5',''),('{$srvid}','1','sendMail','GM Recharge 2,000 $', 'Ocean Wings*5','{$uid}','1,1081014,5',''),('{$srvid}','1','sendMail','GM Recharge 2,000 $', 'Dragon Flame Armor*5','{$uid}','1,1082015,5',''),('{$srvid}','1','sendMail','GM Recharge 2,000 $', '蟠龙傲天戒*5','{$uid}','1,1083015,5',''),('{$srvid}','1','sendMail','GM Recharge 2,000 $', '偃月武圣*5','{$uid}','1,1050005,5',''),('{$srvid}','1','sendMail','GM Recharge 2,000 $', '天圣佣兵*5','{$uid}','1,1060005,5',''),('{$srvid}','1','sendMail','GM Recharge 2,000 $', 'Chaos Deep Kun*5','{$uid}','1,1070009,5',''),('{$srvid}','1','sendMail','GM Recharge 2,000 $', 'Dark Soul Blessing*5','{$uid}','1,1089007,5','')";
			$obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'Successful!',
				);
				exit(json_encode($return));
			break;
		case 'tc400':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";
			
			/* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','GM Recharge 3,000 $', '1498$ Recharge card*20','{$uid}','1,340032,20',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', '1000 100M EXP*50 Cards','{$uid}','1,340039,50',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'Navy anchor*10','{$uid}','1,1010116,10',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'Ocean Wings*10','{$uid}','1,1081014,10',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'Dragon Flame Armor*10','{$uid}','1,1082015,10',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'Panlong Aotian Ring*10','{$uid}','1,1083015,10',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'Yanyue Martial Saint*10','{$uid}','1,1050005,10',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'Tiansheng Mercenary*10','{$uid}','1,1060005,10',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'Chaos Deep Kun*10','{$uid}','1,1070009,10',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'Dark Soul Blessing*10','{$uid}','1,1089007,10','')";
			$obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'Successful!',
				);
				exit(json_encode($return));
			break;
		case 'tc500':
           $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";
			
			/* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','GM Recharge 3,000 $', '3 billion recharge','{$uid}','1,10009,3000',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'Junior fashion essence*1 million','{$uid}','1,1001,1000000',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'Intermediate fashion essence*1 million','{$uid}','1,1002,1000000',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'High-end fashion essence*1 million','{$uid}','1,1003,1000000',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'Dark Palace Spiritual Stone*1 million','{$uid}','1,611301,1000000',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'Dark Palace Magic Stone*1 million','{$uid}','1,611302,1000000',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'Divine Dragon Immortal Jade*300,000','{$uid}','1,1004,300000',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'Shenlong gold coin*300,000','{$uid}','1,1005,300000',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'War Spirit Ascension Pill*1 million','{$uid}','1,205002,1000000',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'War Spirit Potential Pill*1 million','{$uid}','1,205001,1000000',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'Fairy world fashion of your choice*9','{$uid}','1,211225,9',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', 'Fashion Essence Source (Fairy World)*100,000','{$uid}','1,211215,100000',''),('{$srvid}','1','sendMail','GM Recharge 3,000 $', '19 Most Powerful Heroes with Title Legends*1','{$uid}','1,888888,1','')";
			$obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'Successful!',
				);
				exit(json_encode($return));
			break;
		case 'tc1000':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";
			
			/* $sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','Accumulate deposit of 3,000,000$ for benefit letter', '100万元宝卡*200','{$uid}','1,710031,200',''),('{$srvid}','1','sendMail','Accumulate deposit of 3,000,000$ for benefit letter', '法宝温养石*100','{$uid}','1,205001,100',''),('{$srvid}','1','sendMail','Accumulate deposit of 3,000,000$ for benefit letter', '法宝淬炼石*100','{$uid}','1,205002,100',''),('{$srvid}','1','sendMail','Accumulate deposit of 3,000,000$ for benefit letter', '灵石*4000','{$uid}','1,710000,4000',''),('{$srvid}','1','sendMail','Accumulate deposit of 3,000,000$ for benefit letter', '神兵经验丹*5000','{$uid}','1,200906,5000',''),('{$srvid}','1','sendMail','Accumulate deposit of 3,000,000$ for benefit letter', '八荒六合称号*1','{$uid}','1,710018,1','')";
			$obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'Successful!',
				);
				exit(json_encode($return));
			break;
			case 'zhfh':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT actors.actorid FROM actors WHERE actors.accountname = '{$uid}'";
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$dbid=$row['actorid'];
			$time='1608568913';
			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','Sealed','{$dbid}','{$time}')";
            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'Ban successful!',
				);
				exit(json_encode($return));
			break;
		case 'fh':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT actors.actorid FROM actors WHERE actors.actorname = '{$uid}'";
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$dbid=$row['actorid'];
			$time='1608568913';
			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','Sealed','{$dbid}','{$time}')";
            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'Ban successful!',
				);
				exit(json_encode($return));
			break;
		case 'zhjf':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT actors.actorid FROM actors WHERE actors.actorname = '{$uid}'";
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$dbid=$row['actorid'];
			$time='0';
			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','Sealed','{$dbid}','{$time}')";
            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'Blocking removed successfully!',
				);
				exit(json_encode($return));
			break;
		case 'jf':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT actors.actorid FROM actors WHERE actors.actorname = '{$uid}'";
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$dbid=$row['actorid'];
			$time='0';
			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','Sealed','{$dbid}','{$time}')";
            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'Blocking removed successfully!',
				);
				exit(json_encode($return));
			break;
		case 'jy':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT actors.actorid FROM actors WHERE actors.actorname = '{$uid}'";
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$dbid=$row['actorid'];
			$time='1608568913';
			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','shutup','{$dbid}','{$time}')";
            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'Successfully banned!',
				);
				exit(json_encode($return));
			break;
		case 'jj':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'Database connection failed!',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句
			$sql="SELECT actors.actorid FROM actors WHERE actors.actorname = '{$uid}'";
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'Account does not exist!',
				);
				exit(json_encode($return));
            }else{
			$dbid=$row['actorid'];
			$time='0';
			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2) VALUES ('{$srvid}','releaseshutup','{$dbid}','{$time}')";
            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'The ban has been successfully lifted!',
				);
				exit(json_encode($return));
			break;
		case 'addvip':
				$vipfile='vip.'.$quid.'.json';
				$fp = fopen($vipfile,"a+");
				if(filesize($vipfile)>0){
					$str = fread($fp,filesize($vipfile));
					fclose($fp);
					$vipjson=json_decode($str);
					if($vipjson==null){
						$vipjson=array();
					}
				}else{
					$vipjson=array();
				}
				if(!in_array($uid,$vipjson)){
					array_push($vipjson,$uid);
					file_put_contents($vipfile,json_encode($vipjson));
					$return=array(
						'errcode'=>0,
						'info'=>'Successfully joined VIP2.'
					);
					exit(json_encode($return));
				}else{
					$return=array(
						'errcode'=>1,
						'info'=>'This character is already VIP1',
					);
					exit(json_encode($return));
				}
				break;
		    case 'unsetvip':
				$vipfile='vip.'.$quid.'.json';
				$fp = fopen($vipfile,"a+");
				if(filesize($vipfile)>0){
					$str = fread($fp,filesize($vipfile));
					fclose($fp);
					$vipjson=json_decode($str);
					if($vipjson==null){
						$vipjson=array();
					}
				}else{
					$vipjson=array();
				}
				if(in_array($uid,$vipjson)){
					array_push($vipjson,$uid);
					$key=array_search($uid,$vipjson);
					unset($vipjson[$key]);
                    file_put_contents($vipfile , json_encode($vipjson));
						$return=array(
						'errcode'=>0,
						'info'=>'He joined VIP 3.'
					);
					exit(json_encode($return));
				}else{
					$return=array(
						'errcode'=>1,
						'info'=>'This role is already VIP4',
					);
					exit(json_encode($return));
				}
				break;				
		default:
			$return=array(
				'errcode'=>1,
				'info'=>'data error',
			);
			exit(json_encode($return));
			break;
	}
}else{
	$return=array(
		'errcode'=>1,
		'info'=>'Send error',
	);
	exit(json_encode($return));
}