<?php
//error_reporting(0);
header("Content-type: text/html; charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');
session_start();
//==================================================
$key='// 版本 2023 Powered by 酷乐资源屋 www.klres.com';
//==================================================
//仅供本地学习娱乐使用
//仅供本地学习娱乐使用
//仅供本地学习娱乐使用
//==================================================

    $_SESSION['gmbt'] ='奇迹H5';
	$gmbt = '奇迹H5';  //标题	
	$gmcodeb = 'klres.com';  //GM码
	$gmkey="533ccbb5a735295886c2b31a0405ec15";
	$sa="%2F%2F%20%E7%89%88%E6%9C%AC%202022%20Powered%20by%20%E9%80%B8%E4%BA%91%E6%BA%90%E7%A0%81%E7%BD%91%20QQ%E7%BE%A4144819695%20%E8%AF%B7%E5%8B%BF%E4%BF%AE%E6%94%B9";
	$disables=array();
	$vip='tlbb_';
	$frefresh=5;//防刷新间隔 秒
    $title   = 'GM发福利啦！！！';
    $content = '尊敬的大陆勇士福利已到账请查收！！！';
	$yzfvip=array(//自行修改VIP权限
	'1'=>'VIP1只充值',   
	'2'=>'VIP2充值+邮件',
	);		

			
	$quarr=array(
		'1'=>array(
			'name'=>'奇迹一区',
			'qu_port'=>'1',			//区服的ID
			'db_ip'=>'127.0.0.1',
			'db_port'=>3306,
			'db_name'=>'h5_mu_001',
			'db_user'=>'root',
			'db_pswd'=>'gudanboke',
            'hidde'=>false
		),
      	'2'=>array(
			'name'=>'乾坤二区',
			'qu_port'=>'2',			//区服的ID
			'db_ip'=>'127.0.0.1',
			'db_port'=>3306,
			'db_name'=>'h5_mu_002',
			'db_user'=>'root',
			'db_pswd'=>'gudanboke',
            'hidde'=>true
		),
      	'3'=>array(
			'name'=>'苍穹三区',
			'qu_port'=>'3',			//区服的ID
			'db_ip'=>'127.0.0.1',
			'db_port'=>3306,
			'db_name'=>'h5_mu_003',
			'db_user'=>'root',
			'db_pswd'=>'gudanboke',
            'hidde'=>true
		),
        '4'=>array(
			'name'=>'雄霸四区',
			'qu_port'=>'4',			//区服的ID
			'db_ip'=>'127.0.0.1',
			'db_port'=>3306,
			'db_name'=>'h5_mu_004',
			'db_user'=>'root',
			'db_pswd'=>'gudanboke',
            'hidde'=>true
		),
        '5'=>array(
			'name'=>'中秋五区',
			'qu_port'=>'5',			//区服的ID
			'db_ip'=>'127.0.0.1',
			'db_port'=>3306,
			'db_name'=>'h5_mu_005',
			'db_user'=>'root',
			'db_pswd'=>'gudanboke',
            'hidde'=>true
		),    
        '6'=>array(
			'name'=>'轩辕六区',
			'qu_port'=>'6',			//区服的ID
			'db_ip'=>'127.0.0.1',
			'db_port'=>3306,
			'db_name'=>'h5_mu_006',
			'db_user'=>'root',
			'db_pswd'=>'gudanboke',
            'hidde'=>true
		),      
	);

	

	
include_once 'conn.php';	