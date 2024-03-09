<?php
header("Content-type:text/html;charset=utf-8");  
ini_set('date.timezone','Asia/Shanghai');
include_once("../../cfg.php");
@$openId = trim($_GET['openId']);//渠道ID
@$appid = trim($_GET['appid']);
@$pfParam = trim($_GET['pfParam']);
@$serverId = trim($_GET['serverId']);
@$payName = trim($_GET['payName']);
@$itemid = trim($_GET['itemid']);
 
$qufu=$server_list[$serverId];
$qufu_db=$qufu["dbname"];
 
$data = [
    "code"=>"200",
    "msg"=>urlencode ("Activation successful"),
];
 
 
@$mysqli = new mysqli($config['host'],$config['root'],$config['pass'],$config['dbname'],$config['port']);
 
//第一步查询用户信息
 
$sql = "SELECT * FROM `h5`.`account` WHERE `id`={$appid} LIMIT 1";
 
$row = $mysqli->query($sql);
if($row && $row->num_rows > 0){
    $ret = $row->fetch_array(1);
    $account=$ret['account'];
 
    $sql="SELECT `actorid` FROM $qufu_db.`actors` WHERE `accountname` = '${account}'";
    $row = $mysqli->query($sql);
	
    $sqlrmb="SELECT `rmb` FROM $qufu_db.`globaluser` WHERE `account` = '${account}'";
    $rowrmb = $mysqli->query($sqlrmb);
	$accrmb=$rowrmb->fetch_array(1)['rmb'];
	
    if($row && $row->num_rows > 0){
        $actorid=$row->fetch_array(1)['actorid'];
		if(strpos($payName,'Top-up') !== false){$stak="top up";}else{$stak="Activation";}
		//充值：
			if(600==$itemid){$rmb=6;}	//6$	
			if(1200==$itemid){$rmb=12;}	//12$	
			if(3000==$itemid){$rmb=30;}	//30$	
			if(6000==$itemid){$rmb=60;}	//60$	
			if(10000==$itemid){$rmb=98;}	//98$	
			if(20000==$itemid){$rmb=198;}	//198$	
			if(50000==$itemid){$rmb=488;}	//488$	
			if(100000==$itemid){$rmb=988;}	//988$	
			if(150000==$itemid){$rmb=1498;}	//1498$	
		
		//其他 其他的 自己按照编号添加
			if(1000==$itemid){$rmb=10;}//首冲
			if(3100==$itemid){$rmb=31;}
			if(6800==$itemid){$rmb=68;}
			if(9800==$itemid){$rmb=98;}
			if(2800==$itemid){$rmb=28;}
			if(8800==$itemid){$rmb=88;}
			if(100==$itemid){$rmb=1;}
			if(300==$itemid){$rmb=3;}
			if(700==$itemid){$rmb=7;}
			if(900==$itemid){$rmb=9;}
			if(1100==$itemid){$rmb=11;}
			if(6900==$itemid){$rmb=69;}
			if(12800==$itemid){$rmb=128;}
			if(20600==$itemid){$rmb=206;}
			if(3000==$itemid){$rmb=30;}
			if(6000==$itemid){$rmb=60;}
			if(10000==$itemid){$rmb=100;}
			if(20000==$itemid){$rmb=200;}
			if(50000==$itemid){$rmb=500;}
			if(100000==$itemid){$rmb=1000;}
			if(150000==$itemid){$rmb=1500;}
			if(600==$itemid){$rmb=6;}
			if(1200==$itemid){$rmb=12;}
			if(110==$itemid){$rmb=1;}
			if(9900==$itemid){$rmb=99;}
			if(101==$itemid){$rmb=1;}
			if(601==$itemid){$rmb=6;}
			if(1500==$itemid){$rmb=15;}
			if(1800==$itemid){$rmb=18;}
			if(602==$itemid){$rmb=6;}
			if(3001==$itemid){$rmb=30;}
			if(6801==$itemid){$rmb=68;}
			if(9801==$itemid){$rmb=98;}
			if(32801==$itemid){$rmb=328;}
			if(64805==$itemid){$rmb=648;}
			if(12801==$itemid){$rmb=128;}
			if(12802==$itemid){$rmb=128;}
			if(12803==$itemid){$rmb=128;}
			if(12804==$itemid){$rmb=128;}
			if(12805==$itemid){$rmb=128;}
			if(64801==$itemid){$rmb=648;}
			if(64802==$itemid){$rmb=648;}
			if(64803==$itemid){$rmb=648;}
			if(64804==$itemid){$rmb=648;}
			if(9802==$itemid){$rmb=98;}
			if(16800==$itemid){$rmb=168;}

            if($rmb>0){
            if($accrmb>=$rmb){
			//添加	
            $sql="insert into $qufu_db.feecallback(serverid,openid,itemid,actor_id) values ('{$serverId}','{$account}','{$itemid}','{$actorid}')";
            $mysqli->query($sql);		
			//减少账户余额 
            $sqlrmb = "UPDATE $qufu_db.`globaluser` SET `rmb`=rmb-{$rmb} WHERE `account`='${account}'";
            $mysqli->query($sqlrmb);			
            $tips=$payName.$stak."Success! Consumption:".$rmb."Remaining:".($accrmb-$rmb)."Platform currency";
            $status=1;			
			}else{
			$tips="Insufficient account balance! ! ! Remaining:".$accrmb."Platform currency";
            $status=1;
		
			}}
			
            if($status==1)	{
			$data['code'] = "500";
			$data['msg'] = urlencode ($tips);					
			}else{
			$data['code'] = "500";
			$data['msg'] = urlencode ($payName."In-app purchases are not available yet! Serial number:".$itemid);				
			}


    }else{
       $data['code'] = "500";
       $data['msg'] = urlencode ("role does not exist");
    }
     
}else{
    $data['code'] = "500";
    $data['msg'] = urlencode ("Account does not exist");
}
 
exit(urldecode(json_encode($data)));
?>