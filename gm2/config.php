<?php
	function login_post($url, $cookie, $post){
	$ch = curl_init(); //初始化curl模块 懒人 源 码网www.lr ym w.com
	curl_setopt($ch, CURLOPT_URL, $url); //登录提交的地址
	curl_setopt($ch, CURLOPT_HEADER, 0); //是否显示头信息
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //是否自动显示返回的信息
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie); //设置cookie信息保存在指定的文件夹中
	curl_setopt($ch, CURLOPT_POST, 1); //以POST方式提交
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));//要执行的信息
	curl_exec($ch); //执行CURL
	curl_close($ch);
	}
	function mail_post($url, $cookie, $post){
	$ch = curl_init(); //初始化curl模块
	curl_setopt($ch, CURLOPT_URL, $url); //登录提交的地址
	curl_setopt($ch, CURLOPT_HEADER, 0); //是否显示头信息
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //是否自动显示返回的信息
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);//设置cookie信息保存在指定的文件夹中
	curl_setopt($ch, CURLOPT_POST, 1); //以POST方式提交
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));//要执行的信息
	curl_exec($ch); //执行CURL
	curl_close($ch);
	}
	$quarr=array(
		'1'=>array(
			'ip'=>'127.0.0.1',
			'user'=>'root',
			'pswd'=>'1999122d69e0ac3c',
			'db'=>'h5_cq_001',
			'srvid'=>'1',
		),
		'2'=>array(
			'ip'=>'127.0.0.1',
			'user'=>'root',
			'pswd'=>'1999122d69e0ac3c',
			'db'=>'h5_cq_002',
			'srvid'=>'2',
		),
		'3'=>array(
			'ip'=>'127.0.0.1',
			'user'=>'root',
			'pswd'=>'1999122d69e0ac3c',
			'db'=>'h5_cq_003',
			'srvid'=>'3',
		),	
		'4'=>array(
			'ip'=>'127.0.0.1',
			'user'=>'root',
			'pswd'=>'1999122d69e0ac3c',
			'db'=>'h5_cq_004',
			'srvid'=>'4',
		),	
		'5'=>array(
			'ip'=>'127.0.0.1',
			'user'=>'root',
			'pswd'=>'123456',
			'db'=>'actor_s5',
			'srvid'=>'5',
		),	
		'6'=>array(
			'ip'=>'127.0.0.1',
			'user'=>'root',
			'pswd'=>'123456',
			'db'=>'actor_s6',
			'srvid'=>'6',
		),			
	);
