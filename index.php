<?php
error_reporting(0);
include 'config.ini.php';

?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>Game Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #1a1a1a;
            color: #fff;
            font-family: 'Tahoma', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .show_box {
            background-color: rgba(33, 33, 33, 0.5);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            border-radius: 15px;
            overflow: hidden;
            width: 400px;
            max-width: 100%;
            text-align: center;
            transition: transform 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .show_box:hover {
            transform: scale(1.05);
        }

        .form-group {
            padding: 30px;
            margin: 0;
        }

        .form-control {
            margin-bottom: 20px;
            background-color: rgba(58, 58, 58, 0.5);
            color: #fff;
            border: 1px solid #333;
        }

        .login-btn2,
        .login-btn,
        .btngo {
            background-color: #3498db;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            margin: 10px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease;
            position: relative;
            z-index: 3;
        }

        .login-btn2:hover,
        .login-btn:hover,
        .btngo:hover {
            background-color: #2980b9;
        }

        .background-image {
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        h2 {
            color: #3498db;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .login-message {
            color: #3498db;
            margin-top: 15px;
            font-size: 16px;
        }

        .register-link {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .register-link:hover {
            color: #2980b9;
        }

        .game-logo {
            width: 140px;
            height: auto;
            margin-bottom: 20px;
        }
    </style>
    <script type="text/javascript" src="/login/cqlb/js/jquery.min.js"></script>
    <script type="text/javascript" src="/login/cqlb/js/h5_common.js"></script>
</head>

<body class="full">
    <div id="acc" style="display:block">
        <img class="background-image" src="/login/cqlb/img/bg2.png">
        <div class="show_box" id="user_login">
            <img src="/login/cqlb/img/bg3.png" alt="Game Logo" class="game-logo">
            <form class="form-group" id="frmLogin" method="post" action="/index.php?act=login" target="_top">
                <h2 class="mt-3 mb-4">Welcome Back!</h2>
                <div class="form-group">
                    <input id="username" name="username" class="form-control" type="text" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <input id="password" name="password" class="form-control" type="password" placeholder="Enter your password" required>
                </div>
                <div class="form-group">
                    <button type="button" class="login-btn2" id="btnlogin">Login</button>
                    <p class="login-message">Don't have an account? <a href="javascript:;" class="register-link" onclick="getsjreg()">Register here</a></p>
                </div>
            </form>
        </div>
        <div class="show_box popup_bg" id="mobile_login" style="display: none;">
            <div class="phone-login">
                <form id="frmLogin2" method="post" action="/index.php?act=reg" target="_top">
                    <a href="javascript:;" class="closed_b" onclick="getzhlogin()">
                        <img src="/login/cqlb/img/h5c_closed.png">
                    </a>
                    <h2 class="mt-3 mb-4">Create Account</h2>
                    <span class="inpt"><input name="m_username" id="m_username" type="text" placeholder="Choose a username"></span>
                    <span class="inpt"><input name="m_password" id="m_password" type="password" placeholder="Create a password"></span>
                    <span class="inpt"><input name="m_password2" id="m_password2" type="password" placeholder="Re-enter your password"></span><br>
                    <button type="button" class="login-btn" id="btnreg">Register</button>
                </form>
            </div>
        </div>
        <div class="show_box popup_bg" id="mobile_go" style="display: none;">
            <div class="phone-login">
                <a href="javascript:;" class="closed_b" onclick="getzhlogin()">
                    <img src="/login/cqlb/img/h5c_closed.png">
                </a>
                <h2 class="mt-3 mb-4">Detected Users</h2>
                <span class="inpt"><input name="m_username" id="go_m_username" type="text" readonly="readonly"></span>
                <button class="login-btn btngo" id="btngo">Enter the Game</button>    
         </div>
</div>
</div>

</div>
</div>

<div id="game" style="display: none;width: 100%;height:99%;">
	<iframe id="ggg" src="" marginheight="0" marginwidth="0" style="width: 100%;height:99%;">
</iframe>
</div>
<script type="text/javascript">

var $_GET = (function(){
    var url = window.document.location.href.toString();
    var u = url.split("?");
    if(typeof(u[1]) == "string"){
        u = u[1].split("&");
        var get = {};
        for(var i in u){
            var j = u[i].split("=");
            get[j[0]] = j[1];
        }
        return get;
    } else {
        return {};
    }
})();


	/**
	 *??????Cookie????
	 */
	window.onload = function(){
		var loUser = document.getElementById('go_m_username');
		//var loPswd = document.getElementById('password');
		//??????,??????cookie?????
		if(getCookie('user') && getCookie('pswd')){
			$(".show_box").hide();
			$("#mobile_go").show();
		  loUser.value = getCookie('user');
		  //loPswd.value = getCookie('pswd');
		}else{
		  loUser.value = "";
		  //loPswd.value = "";
		}
	 };

    /**
     * ?????????
     */
    $("#btngo").click(function() {
	               $.post("/api.php?act=login", {
                    "username": getCookie('user'),
                    "password": getCookie('pswd')
                },
                function(data) {
                    data = JSON.parse(data);
                    if (data.code < 1) {
                        alert(data.msg);
                    } else {
						document.getElementById("acc").style.display = 'none';
						document.getElementById("game").style.display = 'block';
						
						let url = "./api/game.php?";
						
						delete data['code'];
						delete data['msg'];
						
						for(let k in data){
							url += `${k}=${data[k]}&`;
						}
						window.location = url;
                    }
                });

    });

    function getzhlogin() {
        $(".show_box").hide();
        $("#user_login").show();
    }

    function getsjreg() {
        $(".show_box").hide();
        $("#mobile_login").show();
    }

    //??
    $("#btnlogin").click(function() {
        checkLoginForm();
    });
    //???? ?? ???www.90 175.com
    function checkLoginForm() {
        var lvUsername = $("#username").val();
        var lvPWD = $("#password").val();
        if (lvUsername == "") {
            alert("Please enter username!");
        } else if (lvUsername.length < 4) {
            alert("The length of the username must not be less than 4 characters!");
        } else if (!funcChina(lvUsername)) {
            alert("Username cannot contain Chinese characters!");
        } else if (checkUserName(lvUsername)) {
            alert("Username can only consist of letters and numbers!");
        } else if (lvPWD == "" || lvPWD == "Parolan  Gir") {
            alert("Enter Your Password!");
        } else if (lvPWD.length < 6) {
            alert("Password length must not be less than 6 characters!");
        } else {
            $.post("/api.php?act=login", {
                    "username": lvUsername,
                    "password": lvPWD
                },
                function(data) {
                    
                    data = JSON.parse(data);
                    if (data.code < 1) {
                        alert(data.msg);
                    } else {
						setCookie('user',lvUsername,365); 
						setCookie('pswd',lvPWD,365); 
						document.getElementById("acc").style.display = 'none';
						document.getElementById("game").style.display = 'block';
						let url = "./api/game.php?";
						
						delete data['code'];
						delete data['msg'];
						
						for(let k in data){
							url += `${k}=${data[k]}&`;
						}
						window.location = url;
						//document.getElementById("ggg").src = url;
                    }
                });
        }
    }

    /**
     * ?????
     */
    $("#btnreg").click(function() {
        $("#type").val("1");
        checkRegForm();
    });
	var qd = "";//??
    function checkRegForm() {
        var lvUsername = $("#m_username").val();
        var lvPWD = $("#m_password").val();
        var lvPWD2 = $("#m_password2").val();

        if (!lvPWD) {
            alert("Please enter password!");
            return false;
        } else if (lvPWD != lvPWD2) {
            alert("The password entered twice is different!");
            return false;
        } else if (lvUsername == lvPWD) {
            alert("Account and password cannot be the same!");
            return false;
        } else if (lvUsername == "") {
            alert("Please enter username!");
            return false;
        } else if (lvUsername.length < 4) {
            alert("The length of the username must not be less than 4 characters!");
        } else if (!funcChina(lvUsername)) {
            alert("Username cannot contain Chinese characters!");
        } else if (checkUserName(lvUsername)) {
            alert("Username can only consist of letters and numbers!");
        } else if (lvPWD == "" || lvPWD == "Enter Your Password") {
            alert("Enter Your Password!");
        } else if (lvPWD.length < 6) {
            alert("Password length must not be less than 6 characters!");
        } else {
            $.post("/api.php?act=reg", {
                    "username": lvUsername,
                    "password": lvPWD,
                    "password1": lvPWD2,
					"qd": qd
                },
                function(data) {
                    data = JSON.parse(data);
                    if (data.code < 1) {
                        alert(data.msg);
                    } else {
						//???????cookie
						setCookie('user',lvUsername,365); 
						setCookie('pswd',lvPWD,365);
						setCookie('qd',qd,365); 		
						document.getElementById("acc").style.display = 'none';
						document.getElementById("game").style.display = 'block';
						
						let url = "./api/game.php?";
						
						delete data['code'];
						delete data['msg'];
						
						for(let k in data){
							url += `${k}=${data[k]}&`;
						}
						window.location = url;
						//document.getElementById("ggg").src = url;
                    }
                });
        }
    }
	/**
	 * ??cookie
	 */
  function setCookie(name,value,day){
    var date = new Date();
    date.setDate(date.getDate() + day);
    document.cookie = name + '=' + value + ';expires='+ date;
  };
  
  //??cookie
  function getCookie(name){
    var reg = RegExp(name+'=([^;]+)');
    var arr = document.cookie.match(reg);
    if(arr){
      return arr[1];
    }else{
      return '';
    }
  };
  
  //??cookie
  function delCookie(name){
    setCookie(name,null,-1);
  };
</script>
</body>
</html>