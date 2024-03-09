<?php
error_reporting(0);
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
if($_POST){
	include 'config.php';
	$gmcode=trim($_POST['checknum']);
	if($gmcode!='90175.com'){
		$return=array(
			'errcode'=>1,
			'info'=>'GM码错误',
		);
		exit(json_encode($return));
	}
	$quid=trim($_POST['qu']);
	if($quid==''){
		$return=array(
			'errcode'=>1,
			'info'=>'区号错误',
		);
		exit(json_encode($return));
	}
	$qu=$quarr[$quid];
	if(!$qu['ip']){
		$return=array(
			'errcode'=>1,
			'info'=>'区配置不存在',
		);
		exit(json_encode($return));
	}
	$uid=trim($_POST['uid']);
	if($uid==''){
		$return=array(
			'errcode'=>1,
			'info'=>'角色ID错误',
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
					'info'=>'充值数量错误',
				);
				exit(json_encode($return));
			}
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句九零一 起玩 www.9017 5.com
			$sql="SELECT `actorid` FROM `actors` WHERE `accountname` = '{$uid}'";
			
/* 			$sql="SELECT players.dbid FROM players WHERE players.account = '{$uid}'"; */
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'账号不存在！',
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
					'info'=>'充值成功！',
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
					'info'=>'数量错误',
				);
				exit(json_encode($return));
			}
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
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
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','Thư ADM qcymw.com', 'Nhận quà thành công','{$uid}','{$type},{$itemid},{$num}','')";
/* 			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2,param3,param4) VALUES ('{$srvid}','mail','{$uid}','{$type}','{$itemid}','{$num}')"; */            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'发送成功！',
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
					'info'=>'数量错误',
				);
				exit(json_encode($return));
			}
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
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
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendGlobalMail','Thư ADM toàn server qcymw.com', 'Chúc ae chơi game vui vẻ！','{$type},{$itemid},{$num}','','')";
/* 			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2,param3,param4) VALUES ('{$srvid}','mail','{$uid}','{$type}','{$itemid}','{$num}')"; */            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'全服邮件发送成功！',
				);
				exit(json_encode($return));
			break;
		case 'tc10':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
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
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','累计充值100元福利邮件', '1498充值卡*2','{$uid}','1,340032,2',''),('{$srvid}','1','sendMail','累计充值100元福利邮件', '1000亿经验卡*5','{$uid}','1,340039,5',''),('{$srvid}','1','sendMail','累计充值100元福利邮件', '绝世屠龙*1','{$uid}','1,1010117,1',''),('{$srvid}','1','sendMail','累计充值100元福利邮件', '天权之翼*1','{$uid}','1,1081013,1',''),('{$srvid}','1','sendMail','累计充值100元福利邮件', '蟠龙傲天甲*1','{$uid}','1,1082013,1',''),('{$srvid}','1','sendMail','累计充值100元福利邮件', '帝王特戒*1','{$uid}','1,1083013,1',''),('{$srvid}','1','sendMail','累计充值100元福利邮件', '方天战神*1','{$uid}','1,1050003,1',''),('{$srvid}','1','sendMail','累计充值100元福利邮件', '幽冥佣兵*1','{$uid}','1,1060003,1',''),('{$srvid}','1','sendMail','累计充值100元福利邮件', '审判古龙*1','{$uid}','1,1070005,1',''),('{$srvid}','1','sendMail','累计充值100元福利邮件', '聚宝盆卡*1','{$uid}','1,340014,1','')";
/* 			$sql="INSERT INTO gmcmd(serverid,cmd,param1,param2,param3,param4) VALUES ('{$srvid}','mail','{$uid}','{$type}','{$itemid}','{$num}')"; */            $obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'发送成功！',
				);
				exit(json_encode($return));
			break;
		case 'tc50':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
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
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','累计充值300元福利邮件', '1498充值卡*3','{$uid}','1,340032,3',''),('{$srvid}','1','sendMail','累计充值300元福利邮件', '1000亿经验卡*10','{$uid}','1,340039,10',''),('{$srvid}','1','sendMail','累计充值300元福利邮件', '绝世屠龙*3','{$uid}','1,1010117,3',''),('{$srvid}','1','sendMail','累计充值300元福利邮件', '天权之翼*3','{$uid}','1,1081013,3',''),('{$srvid}','1','sendMail','累计充值300元福利邮件', '蟠龙傲天甲*3','{$uid}','1,1082013,3',''),('{$srvid}','1','sendMail','累计充值300元福利邮件', '帝王特戒*3','{$uid}','1,1083013,3',''),('{$srvid}','1','sendMail','累计充值300元福利邮件', '方天战神*3','{$uid}','1,1050003,3',''),('{$srvid}','1','sendMail','累计充值300元福利邮件', '幽冥佣兵*3','{$uid}','1,1060003,3',''),('{$srvid}','1','sendMail','累计充值300元福利邮件', '审判古龙*3','{$uid}','1,1070005,3',''),('{$srvid}','1','sendMail','累计充值300元福利邮件', '护身戒指卡*1','{$uid}','1,340013,1','')";
			$obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'发送成功！',
				);
				exit(json_encode($return));
			break;
		case 'tc100':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
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
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','累计充值500元福利邮件', '1498充值卡*5','{$uid}','1,340032,5',''),('{$srvid}','1','sendMail','累计充值500元福利邮件', '1000亿经验卡*15','{$uid}','1,340039,15',''),('{$srvid}','1','sendMail','累计充值500元福利邮件', '绝世屠龙*5','{$uid}','1,1010117,5',''),('{$srvid}','1','sendMail','累计充值500元福利邮件', '天权之翼*5','{$uid}','1,1081013,5',''),('{$srvid}','1','sendMail','累计充值500元福利邮件', '蟠龙傲天甲*5','{$uid}','1,1082013,5',''),('{$srvid}','1','sendMail','累计充值500元福利邮件', '帝王特戒*5','{$uid}','1,1083013,5',''),('{$srvid}','1','sendMail','累计充值500元福利邮件', '方天战神*5','{$uid}','1,1050003,5',''),('{$srvid}','1','sendMail','累计充值500元福利邮件', '幽冥佣兵*5','{$uid}','1,1060003,5',''),('{$srvid}','1','sendMail','累计充值500元福利邮件', '审判古龙*5','{$uid}','1,1070005,5',''),('{$srvid}','1','sendMail','累计充值500元福利邮件', '绝对炎域*5','{$uid}','1,1089006,5','')";
			$obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'发送成功！',
				);
				exit(json_encode($return));
			break;
		case 'tc200':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
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
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','累计充值1000元福利邮件', '1498充值卡*10','{$uid}','1,340032,10',''),('{$srvid}','1','sendMail','累计充值1000元福利邮件', '1000亿经验卡*20','{$uid}','1,340039,20',''),('{$srvid}','1','sendMail','累计充值1000元福利邮件', '绝世屠龙*10','{$uid}','1,1010117,10',''),('{$srvid}','1','sendMail','累计充值1000元福利邮件', '天权之翼*10','{$uid}','1,1081013,10',''),('{$srvid}','1','sendMail','累计充值1000元福利邮件', '蟠龙傲天甲*10','{$uid}','1,1082013,10',''),('{$srvid}','1','sendMail','累计充值1000元福利邮件', '帝王特戒*10','{$uid}','1,1083013,10',''),('{$srvid}','1','sendMail','累计充值1000元福利邮件', '方天战神*10','{$uid}','1,1050003,10',''),('{$srvid}','1','sendMail','累计充值1000元福利邮件', '幽冥佣兵*10','{$uid}','1,1060003,10',''),('{$srvid}','1','sendMail','累计充值1000元福利邮件', '审判古龙*10','{$uid}','1,1070005,10',''),('{$srvid}','1','sendMail','累计充值1000元福利邮件', '绝对炎域*10','{$uid}','1,1089006,10','')";
			$obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'发送成功！',
				);
				exit(json_encode($return));
			break;
		case 'tc300':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
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
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','累计充值2000元福利邮件', '1498充值卡*15','{$uid}','1,340032,15',''),('{$srvid}','1','sendMail','累计充值2000元福利邮件', '1000亿经验卡*30','{$uid}','1,340039,30',''),('{$srvid}','1','sendMail','累计充值2000元福利邮件', '海军船锚*5','{$uid}','1,1010116,5',''),('{$srvid}','1','sendMail','累计充值2000元福利邮件', '海洋之翼*5','{$uid}','1,1081014,5',''),('{$srvid}','1','sendMail','累计充值2000元福利邮件', '御龙烈焰甲*5','{$uid}','1,1082015,5',''),('{$srvid}','1','sendMail','累计充值2000元福利邮件', '蟠龙傲天戒*5','{$uid}','1,1083015,5',''),('{$srvid}','1','sendMail','累计充值2000元福利邮件', '偃月武圣*5','{$uid}','1,1050005,5',''),('{$srvid}','1','sendMail','累计充值2000元福利邮件', '天圣佣兵*5','{$uid}','1,1060005,5',''),('{$srvid}','1','sendMail','累计充值2000元福利邮件', '混沌深鲲*5','{$uid}','1,1070009,5',''),('{$srvid}','1','sendMail','累计充值2000元福利邮件', '黯魂庇佑*5','{$uid}','1,1089007,5','')";
			$obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'发送成功！',
				);
				exit(json_encode($return));
			break;
		case 'tc400':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
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
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','累计充值3000元福利邮件', '1498充值卡*20','{$uid}','1,340032,20',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '1000亿经验卡*50','{$uid}','1,340039,50',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '海军船锚*10','{$uid}','1,1010116,10',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '海洋之翼*10','{$uid}','1,1081014,10',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '御龙烈焰甲*10','{$uid}','1,1082015,10',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '蟠龙傲天戒*10','{$uid}','1,1083015,10',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '偃月武圣*10','{$uid}','1,1050005,10',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '天圣佣兵*10','{$uid}','1,1060005,10',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '混沌深鲲*10','{$uid}','1,1070009,10',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '黯魂庇佑*10','{$uid}','1,1089007,10','')";
			$obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'发送成功！',
				);
				exit(json_encode($return));
			break;
		case 'tc500':
           $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
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
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','累计充值3000元福利邮件', '30亿充值','{$uid}','1,10009,3000',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '初级时装精华*100万','{$uid}','1,1001,1000000',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '中级时装精华*100万','{$uid}','1,1002,1000000',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '高级时装精华*100万','{$uid}','1,1003,1000000',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '暗殿灵石*100万','{$uid}','1,611301,1000000',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '暗殿魔石*100万','{$uid}','1,611302,1000000',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '神龙仙玉*30万','{$uid}','1,1004,300000',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '神龙金币*30万','{$uid}','1,1005,300000',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '战灵飞升丹*100万','{$uid}','1,205002,1000000',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '战灵潜能丹*100万','{$uid}','1,205001,1000000',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '仙界时装自选*9','{$uid}','1,211225,9',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '时装精源(仙界)*10万','{$uid}','1,211215,100000',''),('{$srvid}','1','sendMail','累计充值3000元福利邮件', '19位称号传奇最强大英雄*1','{$uid}','1,888888,1','')";
			$obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'发送成功！',
				);
				exit(json_encode($return));
			break;
		case 'tc1000':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
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
					'info'=>'账号不存在！',
				);
				exit(json_encode($return));
            }else{
			$uid=$row['actorid'];
			$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('{$srvid}','1','sendMail','累计充值1000元福利邮件', '100万元宝卡*200','{$uid}','1,710031,200',''),('{$srvid}','1','sendMail','累计充值1000元福利邮件', '法宝温养石*100','{$uid}','1,205001,100',''),('{$srvid}','1','sendMail','累计充值1000元福利邮件', '法宝淬炼石*100','{$uid}','1,205002,100',''),('{$srvid}','1','sendMail','累计充值1000元福利邮件', '灵石*4000','{$uid}','1,710000,4000',''),('{$srvid}','1','sendMail','累计充值1000元福利邮件', '神兵经验丹*5000','{$uid}','1,200906,5000',''),('{$srvid}','1','sendMail','累计充值1000元福利邮件', '八荒六合称号*1','{$uid}','1,710018,1','')";
			$obj = mysqli_query($conn,$sql);
			mysqli_close($conn);
			}
				$return=array(
					'errcode'=>0,
					'info'=>'发送成功！',
				);
				exit(json_encode($return));
			break;
			case 'zhfh':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
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
					'info'=>'账号不存在！',
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
					'info'=>'封禁成功！',
				);
				exit(json_encode($return));
			break;
		case 'fh':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
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
					'info'=>'账号不存在！',
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
					'info'=>'封禁成功！',
				);
				exit(json_encode($return));
			break;
		case 'zhjf':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
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
					'info'=>'账号不存在！',
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
					'info'=>'解封成功！',
				);
				exit(json_encode($return));
			break;
		case 'jf':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
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
					'info'=>'账号不存在！',
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
					'info'=>'解封成功！',
				);
				exit(json_encode($return));
			break;
		case 'jy':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
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
					'info'=>'账号不存在！',
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
					'info'=>'禁言成功！',
				);
				exit(json_encode($return));
			break;
		case 'jj':
            $conn = mysqli_connect($qu['ip'],$qu['user'],$qu['pswd']);
            #判断是否连接成功
            if(!$conn){
				$return=array(
					'errcode'=>1,
					'info'=>'数据库连接失败！',
				);
				exit(json_encode($return));
            }
            //选择数据库
            mysqli_select_db($conn,$qu['db']);
            //准备sql语句 九 零一 起玩www.90 1  75.com
			$sql="SELECT actors.actorid FROM actors WHERE actors.actorname = '{$uid}'";
            $obj = mysqli_query($conn,$sql);
            $row = mysqli_fetch_assoc($obj);
            if(count($row)==0){
			mysqli_close($conn);
				$return=array(
					'errcode'=>0,
					'info'=>'账号不存在！',
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
					'info'=>'解禁成功！',
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
						'info'=>'加入VIP成功2.'
					);
					exit(json_encode($return));
				}else{
					$return=array(
						'errcode'=>1,
						'info'=>'该角色已经是VIP1了',
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
						'info'=>'加入VIP成功3.'
					);
					exit(json_encode($return));
				}else{
					$return=array(
						'errcode'=>1,
						'info'=>'该角色已经是VIP4了',
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