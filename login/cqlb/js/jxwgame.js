
$(function(){
	//var locUrl = window.location.href;
	//if(locUrl.indexOf("?from=")>0)window.location.href=locUrl.split("?")[0];
	var ui = new Jxw($("#gameInfo").attr("game_id"),{iframe:"game_iframe",pay:true,channel:$("#channelId").val(),imgurl:$("#gameThumb").val(),passage:$("#gameShortWord").val(),close:""});
	function setIframe(){
		var iframe = document.getElementById("game_iframe");
		iframe.frameBorder = "no";
		iframe.marginwidth="0px";
		iframe.marginheight="0px" ;
		iframe.scrolling = "no";
		iframe.border="0px"
		iframe.style.position = "absolute";
		iframe.style.left = "0px";
		iframe.style.top = "0px";
		iframe.style.width = document.documentElement.clientWidth+"px";
		iframe.style.height = document.documentElement.clientHeight+"px";
	}
	setIframe();
	$(window).resize(function() {
		setIframe();
	});
	
	setTimeout(function () {
		if(/micromessenger/ig.test(navigator.userAgent.toLowerCase())){
			setIframe();
		}
	},2000);
	window.onload = function () {
		setIframe();
	}

	$(".opencode").live('click',function(){
		var id = $(this).attr('id');
		ui.showOpenCode(id);
	});
	
	var count = 0;
	
	//定时检查是否为临时用户
	var interval = null;
	var checkTmpUser = function(){
		var isor = true;
		$(".popdiv").each(function(){
				if($(this).css("display")=="block"){
						isor = false;
						//break;
				}
		});
		count = count+1;
		if(isor){
				//var url = ui.utils.getOrigin() + "/user/guestInfo.html";
		   	//ui.utils.ajax(url, function(data) {
			    //if (data&&data.code==200) {
			       //if (data.data.register_source==0) {
			       //if(interval)clearInterval(interval);
			       if ($("#isGuest").val()=="1") {
			       		goonConfirm();
			       		/*
			       		$(".mask").css("display","block");
			       		$("#confirmDialog").css("display","block");
			       		if(count==1){
				       		interval = setInterval(checkTmpUser,1000*60*3);
			       		}*/
			     	 }
			    //}
				//});
		}
		
		/*if(count==2){
			$("#zdl-btn").css('color',"#C1C1C1");
			$('#zdl-btn').removeAttr('href');//去掉a标签中的href属性
		  $('#zdl-btn').removeAttr('onclick');
		}*/
	}
	if($("#gameInfo").attr("game_id") != 10118){//红包雨不需要登录
		checkTmpUser();
	}
	
	//实名制
	if($("#ipInfo").attr("hasRegIdCard")==0&&$("#channelId").val()==0){
		var frame = document.getElementById('verifyframe');
	  if (!frame) {
	      frame = document.createElement("iframe");
	      frame.id = "verifyframe";
	      frame.className = "jxwloadingframe";
	      frame.align = "middle";
	      document.getElementsByTagName("body")[0].appendChild(frame)
	  };
	  frame.src =  ui.utils.getOrigin() + "/game/verify.html";//http://www.75zg.com/game/verify.html
	}
	
  if($("#channelId").val()==294){
  	$("#wxLogin").css("display","none");
  	$("#qqLogin2").css("display","none");
  }
	
	//interval = setInterval(checkTmpUser,1000*60*1);
	
	//登录按钮
	$("#confirm_mod").click(function(){
		var username = $("#username").val();
    var password = $("#password").val();
    if(username==''){
        showmsg("请输入账号或手机号码！");
        return false;
    }
    /*
    var pattern = /^1[34578]\d{9}$/;
    if(!pattern.test(username)){
    		showmsg('请输入正确的手机号');
        return false;
    }
    */
    if(password=='' ){
        showmsg('请输入密码！');
        return false;
    }
		//先尝试是否能登录
		var url = ui.utils.getOrigin() + "/user/login";
		ui.utils.ajaxPost(url,{'username':username,'password':password,'gameid':ui.gameid,'channel':''}, function(data) {
			if (data&&data.code==200) {
				location.reload(); 
			}else if(data&&data.code==402){
				//如果没有注册，就显示验证码框进行注册
				//$("#passwordq").css("display","block");
				$("#imgCode").css("display","block");
				$("#phoneCode").css("display","block");
				$("#confirm_mod").css("display","none");
				$("#confirm_regbtnp").css("display","block");
				//$("#passwordqp").css("display","block");
			}else{
				showmsg(data.msg);
        return false;
			}
		
		});	
		
	});
	
	//注册按钮 九零 一 起玩www .9 017 5.com
	$("#confirm_regbtn").click(function(){
		//注册并登录
		
		var username = $("#username").val();
    var password = $("#password").val();
    //var passwordq = $("#passwordq").val();
    var verify_code = $('#imgCode .regCode').val();
    var phoneCode = $('#phoneCode .phone_code').val();
    if(username==''){
        showmsg('请输入手机号！')
        return false;
    }
    var pattern = /^1[34578]\d{9}$/;
    if(!pattern.test(username)){
    		showmsg('请输入正确的手机号！');
        return false;
    }
    if(password=='' ){
        showmsg('请输入密码！');
        return false;
    }else if(password.length<6){
        showmsg('密码不得少于6位');
        return false;
    }
    /*
    if(verify_code == ''){
        showmsg('请输入验证码！');
        return false;
    }*/
    if(phoneCode == ''){
        showmsg('请输入手机验证码！');
        return false;
    }
    /*if(password!=passwordq){
    		showmsg('两次密码不一致！');
        return false;
    }*/
		//先尝试是否能登录
		var url = ui.utils.getOrigin() + "/user/reg.html";
		ui.utils.ajaxPost(url,{'phone':username,'password':password,'code':verify_code,'phoneCode':phoneCode}, function(data) {
			if (data&&data.code==200) {
				location.reload(); 
			}else{
				showmsg(data.msg);        
			}
		
		});	
	});
	
	//获取注册手机验证码
	$("#getRegCode").live('click',function(){
	    var phone =$("#username").val();
	    if(phone == ''){
	        showmsg('手机号码不存在');
	        return false;
	    }
	    var pattern = /^1[34578]\d{9}$/;
	    if(!pattern.test(phone)){
	    		alert('请输入正确的手机号！');
	        return false;
	    }
	    sendPhoneCode(phone,'getRegCode');
	});
	
	
	var draggable = $('.draggable').draggabilly({ containment: true });
	//draggable.draggabilly('disable')
		//控制圆形logo
		if($("#isGuest").val()=="1"&&$("#gameInfo").attr("game_id") != 10118){
				draggable.on("staticClick",function(){					
						goonConfirm();
				});
		}else if($("#channelId").val() ==132){
				draggable.on("staticClick",function(){					
						$("#service17u").css("display","block");
						$(".draggable").css("display","none");
				});
		}else if(getQueryString("w_token")&&getQueryString("appName")){			
				draggable.on("staticClick",function(){					
						$("#servicexiaocx").css("display","block");
						$(".draggable").css("display","none");
				});
		}else{	
				if($(".draggable").length>0){
		    		setTimeout(function () {
				        $(".draggable .ball_bg").css("opacity","0.8");
				    }, 10000);
				    mTouch('.draggable').on('tap',  function () {
				        this.style.display="none";
				        $(".gamemask").css("display","block");
				        $(".gamesite").animate({left:"0%"},10);
				        if( $(".ball_tip").hasClass('tip_popin')){
				            this.style.display="block";
				            $(".gamemask").css("display","none");
				            $(".gamesite").animate({left:"-100%"},10);
				            $(".ball_tip").removeClass('tip_popin').addClass('tip_popout');
				        }
				    });
				    mTouch('#method').on('tap',  function () {
				        $('.method-con').toggle();
				    });		    
			  }
			  if($(".sitedrawer").length>0){
				    mTouch('.sitedrawer, .gamemask').on('tap',  function () {
				        $(".draggable").css("display","block");
				        $(".gamemask").css("display","none");
				        $(".gamesite").animate({left:"-100%"},10);
				    })
				    mTouch('.sitedrawer').on('tap',  function () {
				    	//系统消息加载
				        $("#msiframe").css("display","block");
				        if($("#msiframe .libao-list").length<=0){
				        	$.getJSON('/login/cqxh/user/message.json',function(data){
							        if(data.code==200){
							        	var os = data.data;
							        	if(os.length>0){
								        	for(var i=0;i<os.length;i++){
								        		$("#mscontent").append('<section class="libao-list"><ul> <li> '+os[i].content+'<p class="authers">'+os[i].created_at+'　就想玩官方</p></li> </ul> </section>');
								        	}
							          }else{
							          	$("#mscontent").append('<section class="libao-list"><ul> <li> 暂无消息</li> </ul> </section>');
							          }
							        }
							    })
				        }
				    })
				     mTouch('#msclose').on('tap',  function () {
				        $(".msiframe").css("display","none");
				    })
				    
				    mTouch('.lqtip a').on('tap',  function () {
				        $(".draggable").css("display","block");
				        $(".gamemask").css("display","none");
				        $(".gamesite").animate({left:"-100%"},10);
				        $(".ball_tip").removeClass('tip_popout').addClass('tip_popin');
				    })
				};
		};

		if($("#channelId").val() ==338||$("#channelId").val() ==340||$("#channelId").val() ==348) {// & $("#gameInfo").attr("game_id") == 10028
        $(".draggable").css("display","none");
    }
    

    
    if(ui.utils.getAppType()=="androidapp"){
    		$("#wxLogin").css("display","none");
    }
		
		$("#quickLogin").click(function(){
				var phone_login = document.getElementById("phone_login");
				phone_login.style.display="none";
				var quick_login = document.getElementById("quick_login");
				quick_login.style.display="block";
        document.getElementById("quick_username").value = document.getElementById("account").value;
        document.getElementById("quick_password").value = document.getElementById("ppassword").value;
        
		    var quick_mod = document.getElementById('quick_mod');
		    var setKeyPlay = function(e) {
		        var username = document.getElementById("quick_username").value;
		        var password = document.getElementById("quick_password").value;
		        if(username.length<4){
				        showmsg('用户名长度至少4位')
				        return false;
				    }
				    if(username.length>20){
				        showmsg('用户名长度最多20位')
				        return false;
				    }
				    
				    if(password.length<6){
				        showmsg('密码长度至少6位');
				        return false;
				    }
				    if(password.length>20){
				        showmsg('密码长度最多20位');
				        return false;
				    }
		       	var url = ui.utils.getOrigin() + "/user/quickLogin";
						ui.utils.ajaxPost(url,{'uid':$("#userId").val(),'account':username,'password':password}, function(data) {
							if (data&&data.code==200) {
								location.reload(); 
							}else{
								showmsg(data.msg);
				        return false;
							}
						
						});	
		    };
		    quick_mod.addEventListener("click", setKeyPlay);
		
		});	
		
		if($("#gameInfo").attr("game_id") == 10460){//红包雨不需要登录
			window.addEventListener("message", function (event) {
			    var action = event && event.data && event.data.action ? event.data.action : false;
			    var data = event && event.data && event.data.data ? event.data.data : {};
			    if (!action) {
			        return false;
			    }
			
			    switch (action){
			        case 'inputLeave':
			            document.body.scrollTop = 0;
						document.documentElement.scrollTop = 0;
						break;
					default:
						break;
				}
			}, false);

		}	
	
});

function shareOKCallback(random){
	if(random)
		ui.postMessageFrame({action: "share:ok"});
}
function getQueryString(name){
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return null;
}


function sendPhoneCode(phone,form){
    if(!phone) return false;
    $.getJSON('/user/sendCode',{'phone':phone},function(data){
    	
        if(data.code==200){
            SetRemainTime(data.data.timeout,form);
        }else if(data.code==400){
        		alert(data.msg);
        }
    	
//        if(data.status==1){
//            SetRemainTime(data.timeout,form);
//        }else if(data.status== -2){
//            SetRemainTime(data.timeout,form);
//        }else{
//            alert(data.msg);
//        }
    })
};

function SetRemainTime(time,form){
    var ntime = time-1;
    if(ntime>=0){
        $("#"+form).html("重新获取" + "(<strong>"+ntime+"</strong>)");
        $("#"+form).attr("disabled", "true");
        setTimeout("SetRemainTime("+ntime+",'"+form+"')",1000);
    }else{
        $("#"+form).removeAttr("disabled","false");//启用按钮
        $("#"+form).html("重新发送验证码");
    }
};

function showmsg(msg){
    if(msg == '') return false;
    $(".regeditBg .regeditSucceed").html(msg);
    $('.regeditBg').show().delay(2000).hide(0);
};

//知道了
function closeConfirm(){
		$(".mask").css("display","none");
		$("#confirmDialog").css("display","none");
}

//现在就去
function goonConfirm(){
		//event.stopPropagation();
		$("#confirmDialog").css("display","none");
		$("#trybox").css("display","block");
		$("#imgCode").css("display","none");
		$("#phoneCode").css("display","none");
		$("#confirm_mod").css("display","block");
		$("#confirm_regbtnp").css("display","none");
		//$("#passwordqp").css("display","none");
		$(".mask").css("display","block");
		
		var tryclose = document.getElementById("tryclose");
		tryclose.parentNode.style.display="none";
		/*
    if (tryclose) {
        tryclose.addEventListener('click', function() {
            trybox.style.display = "none"
            $(".mask").css("display","none");
        })
    }*/
    /*
    $(document).off('click');
    setTimeout(function(){
         $(document).click(function(){
			    	var _con = $("#trybox");   // 设置目标区域
					  if(!_con.is(event.target) && _con.has(event.target).length === 0){ // Mark 1
								$("#trybox").css("display","none");
				        $(".mask").css("display","none");
				         $(document).off('click');
					  }			 
			        
			    })
    }, 0);*/
   
}


function phone_login(){
	var phone_login = document.getElementById("phone_login");
	phone_login.style.display="block";
	var quick_login = document.getElementById("quick_login");
	quick_login.style.display="none";
	$("#imgCode").css("display","none");
	$("#phoneCode").css("display","none");
	$("#confirm_mod").css("display","block");
	$("#confirm_regbtnp").css("display","none");
}

