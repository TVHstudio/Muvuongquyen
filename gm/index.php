<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/main.js"></script>
    <title>后台</title>
    <style>
        h1,h2,h3{
            text-align: center;
        }	
		html,body{font: 13px/21px Verdana, Geneva, Arial, Helvetica, sans-serif;background: #fff}
        .select1{ 
            width: 200px;
        }
        .select1>span{
            width: 100% !important;
        }

    </style>
</head>
<?php
error_reporting(0);
header("Content-type: text/html; charset=utf8");
date_default_timezone_set("PRC");
if(isset($_POST) && $_POST['submit']){
$qu = intval($_POST['qu']);
$dbconfig = array(
	1=>array(
		'db_host'			=> '127.0.0.1',	
		'db_username'		=> 'game',		
		'db_password'		=> '90175com',			
		'database1'			=> 'h5_cq_001',	
	),
	2=>array(
		'db_host'			=> '127.0.0.1',	
		'db_username'		=> 'game',		
		'db_password'		=> '90175com',			
		'database1'			=> 'h5_cq_002',	
	),
);
$conn = @mysql_connect($dbconfig[$qu]['db_host'],$dbconfig[$qu]['db_username'],$dbconfig[$qu]['db_password']) or die ("未知的异常错误,请联系管理员");
@mysql_select_db($dbconfig[$qu]['database1'],$conn) or die ("未知的异常错误,请联系管理员！");
@mysql_query("set names UTF8");

switch($_POST['submit']){
	case '充值';
		$account=trim($_POST['account']);
		$money=trim($_POST['money']);
		if(!$account){
			echo "<script>alert('请输入玩家账号！');history.go(-1)</script>";
			exit;
		}
		if(!$money){
			echo "<script>alert('请选择充值商品！');history.go(-1)</script>";
			exit;
		}
		$sql="select * from actors where accountname='".$account."'";
		$result=mysql_query($sql); 
		$row=mysql_fetch_array($result);
		if(!$row['actorid']){
			echo "<script>alert('角色不存在,发送失败！');history.go(-1)</script>";
			exit;	
		}
		$sql="insert into feecallback(serverid,openid,itemid,actor_id) values ('1','{$account}','{$money}','{$row['actorid']}')";
		$result=mysql_query($sql); 
		if($result)	{
			echo "<script>alert('充值成功！');history.go(-1)</script>";	
			exit;
		}else{	
			echo "<script>alert('充值失败！');history.go(-1)</script>";	
			exit;
		}
		break;
	case '发送物品';
		$account=trim($_POST['account']);
		$items=trim($_POST['items']);
		$num=trim($_POST['num']);
		if(!$account){
			echo "<script>alert('请输入玩家账号！');history.go(-1)</script>";
			exit;
		}
		if($items < 0 ){			
			echo "<script>alert('$items');history.go(-1)</script>";
			exit;
		}
		if(!$num && $num < 1 ){
			echo "<script>alert('请输入物品数量！');history.go(-1)</script>";
			exit;
		}
		$sql="select * from actors where accountname='".$account."'";
		$result=mysql_query($sql); 
		$row=mysql_fetch_array($result);
		if(!$row['actorid']){
			echo "<script>alert('角色不存在,发送失败！');history.go(-1)</script>";
			exit;	
		}
		$type='1';
		$sql="INSERT INTO gmcmd (serverid,cmdid,cmd,param1,param2,param3,param4,param5) VALUES ('1','1','sendMail','GM邮件', 'GM邮件','{$row['actorid']}','{$type},{$items},{$num}','')";
		$result=mysql_query($sql); 
		if($result)	{
			echo "<script>alert('物品发送成功！');history.go(-1)</script>";	
			exit;
		}else{	
			echo "<script>alert('发送失败！');history.go(-1)</script>";	
			exit;
		}		
		break;
}
}
?>
<body>
==========【后台】==========
<form name="form1" method="post" action="">
区服：<select name="qu">
			<option value="1">1区</option>
			<option value="2">2区</option>
	  </select><br>
账号：<input type="text" class="inputs" name="account" value='' placeholder='必填项'><br>
元宝：<input type="text" class="inputs" name="money" value='' placeholder='请输入元宝数量'><br>
活动说明:100=1元
        :100=首充
<br>
<input type="submit" class="submit" name="submit" value='充值'><br><br>
<div class="select1">	
        物品：<select class="mySelect" name='items'>
            <option value="">请选择物品</option>
			<?php 
				$lines=file("item.txt");
				foreach ($lines as $value) {
					$line=explode(";",$value);
					echo '<option value="'.$line[0].'">'.$line[1].'</option>';
				}
			?>			
        </select>
		数量：<input type="text" class="inputs" name="num" value='' placeholder=''>
</div><br>
<input type="submit" class="submit" name="submit" value='发送物品'><br><br>
</form>	
<script>
    $(function(){
        $('.mySelect').select2();
    })
</script>
</body>
</html>