Jxw = function() {
    this.gameid = null;
    this.source = null;
    this.action = null;
    this.gameurl = null;
    this.data = null;
    this.pay = null;
    this.usemoney = null;
    this.events = {};
    this.options = {
        iframe: null,
        pay: false,
        channel:null,
        passage:null,
        imgurl:null,
        close:null
    };
    this.utils = new JxwUtils(this);
    switch (arguments.length) {
        case 0:
            break;
        case 1:
            if (typeof arguments[0] == "string") {
                this.gameid = arguments[0]
            };
            if (typeof arguments[0] == "object") this.options = this.utils.extend(this.options, arguments[0]);
            break;
        case 2:
            this.gameid = arguments[0];
            if (typeof arguments[1] == "object") this.options = this.utils.extend(this.options, arguments[1]);
            break
    };

    this.shareData = {
        imgurl: this.options.imgurl,
        link: window.location.href,
        title: this.options.passage,
        content: "123"
    };

    this.frameid = this.options.iframe;
    this.channel = this.options.channel;
    this.frameWin = null;
    this.isPay = this.options.pay;
    this.init();
    var cls = this.options.channel;
    if($("#isChannelZWY").val()!= 1&&cls !=132&&cls !=269&&cls !=340&&cls !=287&&cls !=348
    		&&(!this.utils.getQueryString("w_token"))) {//this.gameid == 10028&(this.options.channel ==112 || this.options.channel ==121)
        this.utils.loading(4000);
    }
    /*this.plusfo=null;
    if(cls==338){
    	var _this=this;
    	var urls = this.utils.getOrigin() + "/plusfo/balance?uid=" + $("#userId").val();
        this.utils.ajax(urls, function(rsos) {
            if (rsos.code == 200) {           		
            		_this.plusfo = rsos.data.balance;         
            }
        });
    }*/
};
Jxw.prototype.init = function() {
    var _this = this;
    this.source = this.utils.getParameter("source");
    this.action = this.utils.getParameter("action");
    var data = this.utils.getParameter("data");
    this.username = getUsername(this.frameid);
    if (data != null) {
        try {
            this.data = JSON.parse(decodeURIComponent(data))
        } catch (e) {
            this.data = data
        }
    };
    this.initGameBack();
    if (this.isPay) {
        this.pay = new JxwPay(this)
    };
    if (this.utils.isMobile()) {
        this.utils.changeScreen();
        window.addEventListener("orientationchange", this.utils.listenerChangeScreen);
        window.addEventListener("resize", this.utils.listenerChangeScreen)
    };
    if (this.utils.getAppType() == 'wx'){
        this.gamewx = new JxwWx(this);
    }
    this.initFrameEvents();
};
Jxw.prototype.initFrameEvents = function(){
    var _this = this;
    window.addEventListener("message",function(e){
        if(window != top && e.source && e.source == top) return;
        if (typeof e.data != "object") return;
        switch (e.data.action) {
            case "share:setShareData":
                var shareData = {
                    title: e.data.title,
                    content: e.data.content
                };
                if (e.data.imgurl)
                    shareData.imgurl = e.data.imgurl;
                _this.setShareData(shareData);
                break;
            case "share:showShareTip":
                _this.shareBranch();
                break;
        }
    })
};
Jxw.prototype.setShareData = function(shareData){
    if (shareData)
        this.shareData = this.utils.extend(this.shareData, shareData);
    if (this.app && this.app.setShareData)
        this.app.setShareData();
};
Jxw.prototype.shareBranch = function(){
    var _this = this;
		if(this.utils.getAppType() == 'wx'){
        var div;
        div = document.createElement('div');
        div.className = 'share-square';
        div.id = 'share-square';
        div.innerHTML = '<div class="share-box"><img src="../image/guide.png"><span><img class="z" src="../image/bbg.png" >发送朋友圈或朋友</span></div>';
        document.getElementsByTagName("body")[0].appendChild(div);
        div.addEventListener('click',function(){
            var sharesquare = document.getElementById('share-square');
            if(sharesquare)
                sharesquare.parentElement.removeChild(sharesquare);

        });
        _this.gamewx.setShareOk();
    }else{
        this.showAppBox();
    }
};
Jxw.prototype.showAppBox = function(){
    var jxwshare = document.getElementById('jxwshare');
    if(jxwshare){
        jxwshare.style.display = 'block';

        
        jxwshare.innerHTML = '<h3>分享</h3> <div class="close" id="shareclose"><i class="icon-close"></i></div> <div class="game-code"> <p>关注微信公众号分享你的快乐</p> <div><img src="'+$(".wxqrcode").attr('src')+'"><span>搜索“123”或者扫描二维码关注</span></div></div> <div class="quit-footer"> <p class="quitp"></div>';
    };
    var shareclose = document.getElementById('shareclose');
    if(shareclose){
        shareclose.addEventListener('click',function(){
            jxwshare.style.display = 'none';
        });
    }
};
Jxw.prototype.initGameBack = function() {
    var _this = this;
    if (typeof history["pushState"] != "function") return;
    if (localStorage.gameBackTipDate && localStorage.gameBackTipDate == this.utils.formatDate(new Date(), "yyyy-MM-dd")) return;
    history.pushState({
        title: document.title,
        url: location.href
    }, document.title, location.href);
    window.addEventListener("popstate", function(e) {
        if (history.state) return;
        _this.showGameBack()
    });

};
Jxw.prototype.showGameBack = function() {
    var _this = this;
    var quit = document.getElementById("quit");
    if (quit) {
        quit.style.display = "block"
    };
    var quitul = document.getElementById("quitul");
    var render = function(list) {
        quitul.innerHTML = '';
        var li, a, img, span;
        
        for (var i = 0; i < list.length && i < 4; i++) {
            var game = list[i];
            li = document.createElement("li");
            a = document.createElement("a");
            a.href = game.game_id+".html";
            img = document.createElement("img");
            img.src = _this.utils.getImageUrl()+game.thumb;
            img.alt = game.game_name;
            a.appendChild(img);
            span = document.createElement("span");
            span.innerHTML = game.game_name;
            a.appendChild(span);
            li.appendChild(a);
            quitul.appendChild(li)
        };
        li = document.createElement('li');
        a = document.createElement("a");
        a.href = _this.utils.getOrigin();
        img = document.createElement("img");
        img.src = '../image/more.png';
        img.alt = '123';
        a.appendChild(img);
        span = document.createElement("span");
        span.innerHTML = '更多';
        a.appendChild(span);
        li.appendChild(a);
        quitul.appendChild(li)
    };
    var quitclose = document.getElementById("quitclose");
    quitclose.addEventListener("click", function() {
        //quitul.innerHTML = '';
        //return false;
    });

     $.getJSON("/game/hot.html",{'game_id':_this.gameid}, function(data) {
        data.data && render(data.data)
    });
    var backnotip = document.getElementById("backnotip");
    if (backnotip.checked) {
        localStorage.gameBackTipDate = _this.game9g.utils.formatDate(new Date(), "yyyy-MM-dd")
    }
};
Jxw.prototype.postMessageFrame = function(data) {
    var frame = document.getElementById(this.frameid);
    if (this.frameWin) {
        this.frameWin.postMessage(data, "*")
    } else if (frame) {
        frame.contentWindow.postMessage(data, "*")
    } else {
        window.postMessage(data, "*")
    }
};
Jxw.prototype.addEventListener = function() {
    var type = arguments[0];
    var callback = arguments[1];
    var once = (arguments.length == 3 ? arguments[2] : false);
    if (!this.events[type])
        this.events[type] = [];
    this.events[type].push({
        once: once,
        callback: callback
    })
};
Jxw.prototype.dispatchEvent = function() {
    var type = arguments[0];
    var params = [];
    var i;
    if (arguments.length > 1) {
        for (i = 1; i < arguments.length; i++) {
            params.push(arguments[i])
        }
    }
    ;var list = this.events[type];
    var onces = [];
    if (list) {
        for (i = 0; i < list.length; i++) {
            var item = list[i];
            var once = item.once;
            var callback = item.callback;
            if (params.length > 0) {
                callback.apply(this, params)
            } else {
                callback.call(this)
            }
            ;if (once) {
                onces.push(i)
            }
        }
        while (onces.length > 0) {
            var index = onces.pop();
            list.splice(index, 1)
        }
    }
};
Jxw.prototype.showOpenCode = function(openid){
    var iswx = (this.utils.getAppType() == 'wx'||this.utils.getAppType()=="androidapp") ? '1' : '0;'
    var headerUserAgent = $("#headerInfo").attr("user-agent");
    var headerUserToken = $("#headerInfo").attr("access-token");
    var reqData =  {'codeId':openid,'iswx':iswx};
    if(headerUserAgent) {reqData['headerUserAgent'] = headerUserAgent;}
    if(headerUserToken) {reqData['headerUserToken'] = headerUserToken;}
    $.getJSON("http://cq.17h5.cn:188/login/cqxh/api/code.php",reqData,function(data){
        var laytan = document.getElementById('laytan');
        var html ='';		
        if(data.code==400){
            alert(data.message);
            return false;
    		}else{
             html = '<div class="laysha"> <div class="erwei"> <div class="chat"> <div class="chat_hd">领取结果<i class="close" id="open_close"></i> </div><div class="lq_succ"><div><img src="http://cq.17h5.cn:188/login/cqxh/image/psuccess.png" style="width:28px;height:28px;margin:0;padding:0" /></div> <p class="lqone">恭喜你，领取成功，礼包卡号</p> <p class="lqtwo">'+ data.data.exchange_code +'</p> <span>长按复制礼包码，去游戏中使用</span> <p style="height:27px;"></p></div> </div> </div> </div>'
        }		         
        if(!laytan){
            laytan = document.createElement("div");
            laytan.id = 'laytan';
            laytan.className = 'laytan';
            var popup = document.getElementById('popup');
            popup.appendChild(laytan);
        }
        laytan.innerHTML = html;
        laytan.style.display = "block";
        var openclose = document.getElementById('open_close');
        openclose.addEventListener('click',function(){
            laytan.parentElement.removeChild(laytan);
        });
       
    })
};
JxwPay = function(jxw) {
    this.jxw = jxw;
    this.data = null;
    this.isAppWxpay = this.jxw.utils.getAppType() == 'wx';
    this.isNativeWxpay = this.jxw.utils.getAppType() != "wx" && !this.jxw.utils.isMobile();
    if (this.jxw.utils.isWindowsWechat()) {
        this.isNativeWxpay = true
    };
    this.ui = new JxwPayUI(this.jxw);
    this.init()
};
JxwPay.prototype.init = function() {
    var _this = this;
    window.addEventListener("message", function(e) {
        if (window != top && e.source && e.source == top) return;
        if (typeof e.data != "object") return;
        switch (e.data.action) {
            case "pay":
                if (!e.data.token) {
                    alert("token参数为空");
                    return
                };
                e.data.paytype = 0;
                _this.data = e.data;
                _this.start();
                break;
            case "pay:callback":
                if (e.source == window) return;
                _this.closePayFrame(true);
                _this.payCallback(e.data.status);
                break;
            case "pay:cancel":
                if (e.source == window) return;
                _this.closePayFrame(true);
                _this.payCancel();
                break;
            case "pay:error":
                if (e.source == window) return;
                _this.closePayFrame(true);
                alert(e.data.error);
                break;
            case "pay:ipaynow":
                window.location.href = e.data.tn;
                break;
            case "pay:reload":
                window.location.reload();
                break;
            case "pay:close":
                _this.ui.hidePay();
                break;
        }
    })
};
JxwPay.prototype.start = function() {
    var _this = this;
    this.jxw.utils.waiting();

     //var url = _this.jxw.utils.getOrigin() + "/user/guestInfo.html";
     //_this.jxw.utils.ajax(url, function(data) {
		    //if (data&&data.code==200) {
		       //if (data.data.register_source==0)
		       console.log('log_4'); 
		       if ($("#isGuest").val()=="1") {
		            _this.jxw.utils.hideWait();
		            $(".mask").css("display","block");
			       		$("#confirmDialog").css("display","block");
			       		//_this.payCancel();
		            //_this.ui.showKeyPlay()
		        } else {
		        		console.log('log_5'); 
		        		var balance = $("#usageGold").val();
		            _this.ready(balance);//data.money
		        }
		    //}else {
		        //alert(data.msg)
		    //}
		//});
        
    
//    })
};
JxwPay.prototype.ready = function() {
		console.log('log_3'); 
    this.data.usemoney = arguments[0];
    this.ui.showPay(this.data)
};
JxwPay.prototype.pay = function() {
    this.ui.hidePay();
    this.jxw.utils.waiting();
    switch (this.data.paytype) {
        case 1:
            this.postAlipay();//阿里支付
            break;
        case 2:
            this.postWxpay();//扫码支付
            break;
        case 3:
            this.postWappay();//余额支付
            break;
        case 4:
            this.postWxjspay();//微信支付
            break;
        case 5:
           	this.postIpaynow();//微信wap支付
           //this.postAlipay();//微信H5支付
            break;
        case 8:
           	this.postWxApppay();//微信app支付
            break;
    }
};
JxwPay.prototype.postMessage = function(data) {
    if (this.data.fullscreen) {
        window.postMessage(data, "*")
    } else {
        this.jxw.postMessageFrame(data)
    }
};
JxwPay.prototype.payCallback = function(result) {
    this.ui.showResult(result);
    this.postMessage({
        action: "pay:callback",
        orderid: this.data.orderid,
        money: this.data.money,
        status: result,
    })
};
JxwPay.prototype.postAlipay = function() {//支付宝
    var url = this.jxw.utils.getOrigin() +  "/order/pay.html";  
    var _this = this;
    var arg=this.setOrderData();
    this.jxw.utils.ajaxPost(url,arg, function(res) {
    	
        if (res.code=="200") { 	
      			_this.jxw.utils.hideWait();
          	_this.openPayFrame(res.data.url);
        	
        }else{
        		alert(res.msg);
            return;
        }
//        
    });
};
JxwPay.prototype.postWxpay = function() {//微信扫码
    var url =this.jxw.utils.getOrigin() + "/order/pay.html";  // 
    var arg=this.setOrderData();
    	
    var _this = this;
    this.jxw.utils.ajaxPost(url,arg, function(res) {
    	  _this.jxw.utils.hideWait();
	    	if (res.code=="200") {	
       		 _this.showNativeWxpay(res,arg.orderid)
        	
        }else{
        		alert(res.msg);
            return;
        }
        
    })
};
JxwPay.prototype.postWappay = function() {
    var url = this.jxw.utils.getOrigin() +  "/recharge/cost";  
    var _this = this;
    var arg=this.setOrderData();
    this.jxw.utils.ajaxPost(url,arg, function(res) {
    		_this.jxw.utils.hideWait();
        if (res.code=="200") { 	
        	 	_this.payCallback("10000");
      			window.location.reload();
        }else{
        		alert(res.msg);
            return;
        }
//        
    });
};
JxwPay.prototype.postWxjspay = function() {//微信公众号支付
	  var _this=this;
		if(_this.jxw.utils.getQueryString("w_token")&&_this.jxw.utils.getQueryString("appName")){
	    	//小程序支付
	    	var ats="/pages/game/game?uid="+_this.data.uid+"&orderid="+_this.data.orderid+"&product="+encodeURIComponent(_this.data.product)+"&money="+_this.data.money+
	    					"&appid="+_this.data.appid+"&sign="+_this.data.sign;
	    	
	    	if (window['wx'] && window['wx'].miniProgram) {
            window['wx'].miniProgram.navigateTo({ url: ats });
        }
        else {
            _this.jxw.utils.loadJSAsync('https://res.wx.qq.com/open/js/jweixin-1.4.0.js', function () {
                window['wx'].miniProgram.navigateTo({ url: ats });
            });
        }
        _this.jxw.utils.hideWait();
        /*_this.qrscan = true;
		    var check = function() {
		        if (!_this.qrscan) return;
		        _this.checkOrder(_this.data.orderid, function(res) {
		            if (res.code=="200"&&res.data.status==10000) {
		                _this.qrscan = false;
		                _this.payCallback(res.data.status);
		                window.location.reload();
		            } else {
		                setTimeout(check, 1000);
		            }
		        })
		    };
		    check();*/
	  }else{
	  		//公众号支付
		  	var url = _this.jxw.utils.getOrigin() + "/order/wxjspay?" + "uid=" + _this.data.uid+
	    																											"&orderid=" + _this.data.orderid + 
	    																											"&product=" + encodeURIComponent(_this.data.product) + 
	    																											"&money=" + _this.data.money + 
	    																											"&sign=" + _this.data.sign + 
	    																											"&paytype=" + _this.data.paytype + 
	    																											"&appid=" + _this.data.appid;	 
		    //window.location.href = url
		    _this.jxw.utils.hideWait();
		    window.location.href = url;
		    //this.openPayFrame(url);
	  } 
    
};
JxwPay.prototype.postIpaynow = function() {
   	var url = this.jxw.utils.getOrigin() +  "/order/pay.html";  
    var _this = this;
    var arg=this.setOrderData();
    this.jxw.utils.ajaxPost(url,arg, function(res) {
    	
        if (res.code=="200") { 	
      			_this.jxw.utils.hideWait();
          	//_this.openPayFrame(res.data.url);
          	_this.showQuery(res.data.url,'23232');
          	/*
          	 if(arg.uid==149){
          	 		
          	 }else{
          	 		window.location.href = res.data.url;
          	 }*/
          	 
        	
        }else{
        		alert(res.msg);
            return;
        }
//        
    });
};
JxwPay.prototype.postWxApppay = function() {
   	var url = this.jxw.utils.getOrigin() +  "/order/pay.html";  
    var _this = this;
    var arg=this.setOrderData();
    this.jxw.utils.ajaxPost(url,arg, function(res) {
    	
        if (res.code=="200") { 	
      			_this.jxw.utils.hideWait();
          	 window.pay.wxPay(res.data.appid,res.data.partnerid,res.data.prepay_id,res.data.package,res.data.noncestr,res.data.timestamp,res.data.sign);
        	
        }else{
        		alert(res.msg);
            return;
        }
//        
    });
};
JxwPay.prototype.IPayNow = function(invoice) {
    var url = this.jxw.utils.getOrigin() + "/ipay/doipaynow.html" + "?invoice=" + invoice;
    var _this = this;
    this.jxw.utils.ajax(url, function(data) {
        if (data.error) {
            alert(data.error);
            return
        };
        _this.showQuery(data.tn,invoice);
    })
};
JxwPay.prototype.setOrderData = function(){
	var arg={
    	uid:this.data.uid,
    	orderid:this.data.orderid,
    	product:this.data.product,
    	money:this.data.money,
    	paytype:this.data.paytype,
    	appid:this.data.appid,
    	sign:this.data.sign
    };
    return arg;
}
JxwPay.prototype.showQuery = function(tn,invoice){
    var jxwquery = document.getElementById('jxwquery');
    if(!jxwquery){
        var popup = document.getElementById("popup");
        var jxwquery = document.createElement("div");
        jxwquery.className = "popdiv";
        jxwquery.id = "jxwquery";
        jxwquery.style = "width: 300px; top: 25%;";
        popup.appendChild(jxwquery)
    }
    jxwquery.style.display ='block';
    this.jxw.utils.hideWait();
    window.location.href = tn;
    var h3,span,div,img, p,a;
    h3 = document.createElement('h3');
    span = document.createElement('span');
    span.innerHTML = '支付提示';
    h3.appendChild(span);
    jxwquery.appendChild(h3);


    div = document.createElement('div');
    div.className = 'close';
    var i = document.createElement('i');
    i.className = 'icon-close';
    div.appendChild(i);
    jxwquery.appendChild(div);
    div.addEventListener('click',function(){
        if(jxwquery)
            jxwquery.parentElement.removeChild(jxwquery);
    });
    div = document.createElement('div');
    div.className = 'pay-result';
    img = document.createElement('img');
    img.src = '../image/pay_tip.png';
    div.appendChild(img);
    span = document.createElement('span');
    span.className = 'query';
    span.innerHTML = '付款完成前请不要关闭此窗口';
    div.appendChild(span);

    p = document.createElement('p');
    p.className = 'div-btn';
    p.style = 'margin-top: 15px';
    a = document.createElement('a');
    a.href = 'javascript:;';
    a.className = 'btnOrange btnBack';
    a.id = 'query_status';
    a.innerHTML = '支付完成';
    p.appendChild(a);
    div.appendChild(p);
    p.addEventListener('click',function(){
        window.location.reload();
    });
    p = document.createElement('p');
    p.className = 'div-btn';
    a = document.createElement('a');
    a.href = 'http://wpa.qq.com/msgrd?v=3&uin=774341939&site=qq&menu=yes';
    a.className = 'btnBack contact';
    span = document.createElement('span');
    span.innerHTML = '遇到问题，联系客服';
    a.appendChild(span);
    img = document.createElement('img');
    img.src = 'http://wpa.qq.com/pa?p=2:774341939:52';
    img.alt = '点击这里给我发消息';
    img.title = '点击这里给我发消息';
    a.appendChild(img);
    p.appendChild(a);
    div.appendChild(p);
    jxwquery.appendChild(div);
    /*this.qrscan = true;
    var _this = this;
    var check = function(){
        if (!_this.qrscan) return;
        var url = _this.jxw.utils.getOrigin() + "/issue/ipaynow.html?invoice=" + invoice;
        _this.jxw.utils.ajax(url, function(data) {
            if (data && data.status == 10000) {
                _this.qrscan = false;
                jxwquery.parentElement.removeChild(jxwquery);
                _this.ui.showResult(data.status);
            } else {
                if (document.getElementById("jxwquery")) setTimeout(check, 1000);
            }
        });
    };
    check();*/
};
JxwPay.prototype.openPayFrame = function(url) {
	/*
	var paydiv = document.getElementById("jxwpaydiv");
    var frame = document.getElementById("jxwpayframe");
    if (!paydiv) {
    	paydiv = document.createElement("div");
    	paydiv.id = "jxwpaydiv";
    	paydiv.className = "jxwpaydiv";
    	paydiv.innerHTML = "<div class='pclose' title='关闭'><i class='icon-close' id='pclose'></i></div>";
    	
        frame = document.createElement("iframe");
        frame.id = "jxwpayframe";
        frame.className = "jxwpayframe";
        paydiv.appendChild(frame);
        document.getElementsByTagName("body")[0].appendChild(paydiv)
    };
    frame.src = url
    paydiv.style.display = 'block';
    var close = document.getElementById('pclose');
    var _this = this;
    var closeIcon = function(e) {
        _this.closePayFrame();
        _this.jxw.pay.payCancel();
        close.removeEventListener("click", closeIcon)
    };
    close.addEventListener("click", closeIcon);
   */
    
    var frame = document.getElementById("jxwpayframe");
    if (!frame) {
        frame = document.createElement("iframe");
        frame.id = "jxwpayframe";
        frame.className = "jxwpayframe";
        document.getElementsByTagName("body")[0].appendChild(frame)
    }else{
    		frame.style.display="block";
    };
    frame.src = url;
   	this.qrscan = true;
    var _this = this;
    var check = function() {
        if (!_this.qrscan) return;
        _this.checkOrder(_this.data.orderid, function(res) {
            if (res.code=="200"&&res.data.status==10000) {
                _this.qrscan = false;
                _this.payCallback(res.data.status)
            } else {
                if (document.getElementById("jxwpayframe")) {
                    setTimeout(check, 1000)
                }
            }
        })
    };
    check();
};
JxwPay.prototype.closePayFrame = function(closePayUI) {
    var framediv = document.getElementById("jxwpaydiv");
    if (framediv) framediv.parentElement.removeChild(framediv);
    if (closePayUI) this.ui.hidePay()
};
JxwPay.prototype.checkOrder = function(order_no, callback) {
    var url =  this.jxw.utils.getOrigin() + "/order/query.html?orderid="+order_no;
    this.jxw.utils.ajax(url, function(data) {
        callback && callback.call(null, data)
    })
};
JxwPay.prototype.showNativeWxpay = function(data,orderid) {
    this.ui.hidePay();
    this.ui.showQrcode(data);
    this.qrscan = true;
    var _this = this;
    var check = function() {
        if (!_this.qrscan) return;
        _this.checkOrder(orderid, function(res) {
            if (res.code=="200"&&res.data.status==10000) {
                _this.qrscan = false;
                _this.ui.hideQrcode();
                _this.payCallback(res.data.status)
            } else {
                if (document.getElementById("jxwpayqrcode")) {
                    setTimeout(check, 1000)
                }
            }
        })
    };
    check()
};
JxwPay.prototype.payCancel = function() {
    this.postMessage({
        action: "pay:cancel",
    })
};
JxwPayUI = function(jxw) {
    this.jxw = jxw
};
JxwPayUI.prototype.showPay = function(data) {
		console.log('log_2'); 
    var _this = this;
    document.getElementById('payment').style.display = 'block';
    document.getElementById('paycon').innerHTML = data.product;
    document.getElementById('paynum').innerHTML = this.jxw.utils.formatMoney(data.money, {
        unit: false,
        space: true
    });
    var close = document.getElementById('close');
    var closeIcon = function(e) {
        _this.hidePay();
        _this.jxw.pay.payCancel();
        close.removeEventListener("click", closeIcon)
    };
    close.addEventListener("click", closeIcon);
    _this.jxw.utils.hideWait();
    var paytype = document.getElementById('paytype');
    paytype.innerHTML = "";
    var form, label, img;
    
    if(false&&_this.jxw.channel==338){//&&_this.jxw.plusfo
    	//虚拟货币支付https://www.75zg.com/v2/plusfo/balance?uid=885424&amount=600
    		var urls = _this.jxw.utils.getOrigin() + "/v2/plusfo/balance?uid=" + $("#userId").val()+"&amount="+data.money;
    		
    		$("#popupwaitplusfo").css("display","block");
    		document.getElementById('payment').style.display = 'block';
        _this.jxw.utils.ajax(urls, function(rsos) {
            if (rsos.code == 200) {           		
             
            		var n="";
				    		var stp=function(t){
				    			n=t;
				         	$("input[name='example']").removeClass("checked")
									$("#checked" + t).addClass("checked")
				       	}
				    		var vs =  rsos.data.balance;//_this.jxw.plusfo; 
				    		for(var s=0;s<vs.length;s++){
				    			var os=vs[s];
				    			var csb=os.coin_symbol;
				    			label = document.createElement("label");
					        var mhtml = "≈"+os[csb]+" "+csb+" (余额 "+os[csb+"S"]+" "+csb+")";//m+"(<em> ≈ " + vs[m] + " CNY </em>)";
					        label.innerHTML = mhtml;
					        var radio9 = document.createElement("input");
					        radio9.type = "radio";
					        radio9.id = "checked"+csb;
					        radio9.value =csb;
					        radio9.className = "radio";
					        radio9.name = "example";
					        label.style.paddingLeft="0.44rem";
					        label.appendChild(radio9);
									
					        radio9.addEventListener("click",  function(){
					        	stp(this.value);	
					        });
					        
					        img = document.createElement("img");
					        img.src = "../image/zhye.png";
					        //label.appendChild(img);
					        paytype.appendChild(label);
									if(!n)n=csb;					
				    		}
				    		$("#popupwaitplusfo").css("display","none");
				       	/*for(m in vs){
				       		label = document.createElement("label");
					        var mhtml = m+"(<em> ≈ " + vs[m] + " CNY </em>)";
					        label.innerHTML = mhtml;
					        var radio9 = document.createElement("input");
					        radio9.type = "radio";
					        radio9.id = "checked"+m;
					        radio9.value =m;
					        radio9.className = "radio";
					        radio9.name = "example";
					        label.style.paddingLeft="0.44rem";
					        label.appendChild(radio9);
									
					        radio9.addEventListener("click",  function(){
					        	stp(this.value);	
					        });
					        
					        img = document.createElement("img");
					        img.src = "../image/zhye.png";
					        //label.appendChild(img);
					        paytype.appendChild(label);
									if(!n)n=m;					
				       	}*/
				       	
				       	stp(n);
				       	var paybtn = document.getElementById('paybtn');
						    paybtn.innerHTML = "";
						    var btnPay = document.createElement("input");
						    btnPay.id = "btn";
						    btnPay.type = "button";
						    btnPay.className = "btnOrange";
						    btnPay.value = "立即支付";
						    btnPay.addEventListener("click", function(e) {
						        document.getElementById("btn").disabled = true;
						        var arg=_this.jxw.pay.setOrderData();
						        arg.paytype=9;
						        arg.asset_code=n;
						        _this.hidePay();
						        close.removeEventListener("click", closeIcon)
						        _this.jxw.utils.waiting();
						        _this.jxw.utils.ajaxPost(_this.jxw.utils.getOrigin() + "/plusfo/pay",arg, function(res) {
						        		_this.jxw.utils.hideWait();
								        if (res.code=="200") { 	
								          	 window.location.href = res.data.url;
								        	
								        }else{
								        		alert(res.msg);
								            return;
								        }
								        document.getElementById("btn").disabled = false;
								//        
								    }); 
						    });
						    paybtn.appendChild(btnPay);
				        return;    
            }
        });
    	
    	 	
    	 
    }
    else if(false&&_this.jxw.channel==340&&(_this.jxw.gameid==10383||_this.jxw.gameid==10349)){
    	label = document.createElement("label");
      label.innerHTML = "鹿角支付("+data.money+"鹿角)";
      var radio2 = document.createElement("input");
      radio2.type = "radio";
      radio2.id = "checked10";
      radio2.className = "radio";
      radio2.name = "example";
      label.appendChild(radio2);
      var setPaytype2 = function(e) {
          _this.setPayType(2)
      };
      radio2.addEventListener("click", setPaytype2);
      img = document.createElement("img");
      img.src = "../image/jygs.png";
      label.appendChild(img);
      paytype.appendChild(label);
      $("#checked10").addClass("checked");
      var paybtn = document.getElementById('paybtn');
	    paybtn.innerHTML = "";
	    var btnPay = document.createElement("input");
	    btnPay.id = "btn";
	    btnPay.type = "button";
	    btnPay.className = "btnOrange";
	    btnPay.value = "立即支付";
	    btnPay.addEventListener("click", function(e) {
	        document.getElementById("btn").disabled = true;
	        var arg=_this.jxw.pay.setOrderData();
	        arg.paytype=10;
	        _this.hidePay();
	        close.removeEventListener("click", closeIcon)
	        _this.jxw.utils.waiting();
	        _this.jxw.utils.ajaxPost(_this.jxw.utils.getOrigin() + "/lys/pay",arg, function(res) {
	        		_this.jxw.utils.hideWait();
			        if (res.code=="200") { 	
			          	 window.location.href = res.data.url;
			        	
			        }else{
			        		//alert(res.msg);
			        		_this.jxw.utils.showMsg(res.msg);
			            return;
			        }
			        document.getElementById("btn").disabled = false;
			//        
			    }); 
	    });
	    paybtn.appendChild(btnPay);
      return;    
    }
    else{
    	var needWxQrPay = $("#needWxQrPay").val();
    
	    if (_this.jxw.pay.isNativeWxpay) {//微信扫码支付 || needWxQrPay==1
	        label = document.createElement("label");
	        label.innerHTML = "微信支付";
	        var radio2 = document.createElement("input");
	        radio2.type = "radio";
	        radio2.id = "checked2";
	        radio2.className = "radio";
	        radio2.name = "example";
	        label.appendChild(radio2);
	        var setPaytype2 = function(e) {
	            _this.setPayType(2)
	        };
	        radio2.addEventListener("click", setPaytype2);
	        img = document.createElement("img");
	        img.src = "../image/wxzf.png";
	        label.appendChild(img);
	        paytype.appendChild(label);
	    };
	    if (_this.jxw.pay.isAppWxpay) {//微信支付  && needWxQrPay!=1
	    		if(data.usemoney != 0 && (data.usemoney >= data.money * 0.1) && data.money>0){
	    			label = document.createElement("label");
		        label.innerHTML = "微信支付";
		        var radio4 = document.createElement("input");
		        radio4.type = "radio";
		        radio4.id = "checked4";
		        radio4.className = "radio";
		        radio4.name = "example";
		        label.appendChild(radio4);
		        var setPaytype4 = function(e) {
		            _this.setPayType(4)
		        };
		        radio4.addEventListener("click", setPaytype4);
		        img = document.createElement("img");
		        img.src = "../image/wxzf.png";
		        label.appendChild(img);
		        paytype.appendChild(label)
	    		}else{
	    			_this.setPayType(4);
		        _this.jxw.pay.pay();
		        return;
	    		}
	        /*
	        */
	        
	    };
	    var appShowWxh5pay = $("#appShowWxpay").val();
	    if(appShowWxh5pay ==null)appShowWxh5pay==0;
	    if (!_this.jxw.pay.isAppWxpay&&_this.jxw.utils.getAppType()!="androidapp"&&_this.jxw.utils.getAppType()!="wxapppay" && _this.jxw.utils.isMobile()&&_this.jxw.channel!=4&&_this.jxw.channel!=338) {//微信H5支付 ||_this.jxw.utils.getAppType()=="androidapp"&&appShowWxh5pay==1  &&_this.jxw.channel!=340
	        label = document.createElement("label");
	        label.innerHTML = "微信支付";
	        var radio5 = document.createElement("input");
	        radio5.type = "radio";
	        radio5.id = "checked5";
	        radio5.className = "radio";
	        radio5.name = "example";
	        label.appendChild(radio5);
	        var setPaytype5 = function(e) {
	            _this.setPayType(5)
	        };
	        radio5.addEventListener("click", setPaytype5);
	        img = document.createElement("img");
	        img.src = "../image/wxzf.png";
	        label.appendChild(img);
	        paytype.appendChild(label)
	    };
	    if (_this.jxw.utils.getAppType()=="wxapppay"&&appShowWxh5pay==1) {//app微信支付
	        label = document.createElement("label");
	        label.innerHTML = "微信支付";
	        var radio8 = document.createElement("input");
	        radio8.type = "radio";
	        radio8.id = "checked8";
	        radio8.className = "radio";
	        radio8.name = "example";
	        label.appendChild(radio8);
	        var setPaytype8 = function(e) {
	            _this.setPayType(8)
	        };
	        radio8.addEventListener("click", setPaytype8);
	        img = document.createElement("img");
	        img.src = "../image/wxzf.png";
	        label.appendChild(img);
	        paytype.appendChild(label)
	    };
	    
	    
	    if (!_this.jxw.pay.isAppWxpay) {
	        label = document.createElement("label");
	        label.innerHTML = "支付宝";
	        var radio1 = document.createElement("input");
	        radio1.type = "radio";
	        radio1.id = "checked1";
	        radio1.className = "radio";
	        radio1.name = "example";
	        label.appendChild(radio1);
	        var setPaytype1 = function(e) {
	            _this.setPayType(1)
	        };
	        radio1.addEventListener("click", setPaytype1);
	        img = document.createElement("img");
	        img.src = "../image/zfb.png";
	        label.appendChild(img);
	        paytype.appendChild(label)
	    };
	    
	    if (data.usemoney != 0 && (data.usemoney >= data.money * 0.1) && data.money>0 ) {
	        label = document.createElement("label");
	        var umoney = data.usemoney * 0.1;
	        var mhtml = "账户余额(<em>" + umoney.toFixed(2) + "元</em>)";
	        label.innerHTML = mhtml;
	        var radio3 = document.createElement("input");
	        radio3.type = "radio";
	        radio3.id = "checked3";
	        radio3.className = "radio";
	        radio3.name = "example";
	        label.appendChild(radio3);
	        var setPaytype3 = function(e) {
	            _this.setPayType(3)
	        };
	        radio3.addEventListener("click", setPaytype3);
	        img = document.createElement("img");
	        img.src = "../image/zhye.png";
	        label.appendChild(img);
	        paytype.appendChild(label)
	    };
	    var paybtn = document.getElementById('paybtn');
	    paybtn.innerHTML = "";
	    var btnPay = document.createElement("input");
	    btnPay.id = "btn";
	    btnPay.type = "button";
	    btnPay.className = "btnOrange";
	    btnPay.value = "立即支付";
	    btnPay.addEventListener("click", function(e) {
	        document.getElementById("btn").disabled = true;
	        _this.jxw.pay.pay()
	    });
	    paybtn.appendChild(btnPay);
	    if(radio2){
	        setPaytype2()
	    }else if(radio4){
	        setPaytype4()
	    }else if(radio5){
	        setPaytype5()
	    }else if(radio8){
	        setPaytype8()
	    }
	    else if(radio1){
	    	 	setPaytype1();//阿里支付
	    }
	    else if(radio3){
	    	 	setPaytype3();//余额支付
	    }
    }
    
    
    
    
};
JxwPayUI.prototype.hidePay = function() {
    document.getElementById('payment').style.display = 'none';
    document.getElementById('payment_result').style.display = 'none';
    var paytype = document.getElementById("paytype");
    if (paytype) {
        paytype.innerHTML = ''
    };
    var paybtn = document.getElementById('paybtn');
    if (paybtn) {
        paybtn.innerHTML = ''
    };
    var payresult = document.getElementById('pay_result');
    if (payresult) {
        payresult.innerHTML = ''
    }
};
JxwPayUI.prototype.showResult = function(result) {
    document.getElementById('payment').style.display = 'none';
    document.getElementById("payment_result").style.display = 'block';
    var _this = this;
    if (!result) return;
    var payres = document.getElementById("pay_result");
    var img = document.createElement("img");
    var span;
    if (result == "10000") {
        img.src = "http://cq.17h5.cn:188/login/cqxh/image/psuccess.png";
        payres.appendChild(img);
        span = document.createElement("span");
        span.className = "result";
        span.innerHTML = "您的支付已成功";
        payres.appendChild(span);
        span = document.createElement("span");
        span.className = "money";
        span.innerHTML = this.jxw.utils.formatMoney(this.jxw.pay.data.money, {
            unit: false,
            space: true
        });
        payres.appendChild(span)
    } else {
        img.src = "../image/pay_fail.png";
        payres.appendChild(img);
        span = document.createElement("span");
        span.className = "result";
        span.innerHTML = "支付失败";
        payres.appendChild(span)
    };
    var p = document.createElement("p");
    p.className = "div-btn";
    var a = document.createElement("a");
    a.className = "btnOrange btnBack";
    a.href = "javascript:;";
    a.innerHTML = "返回游戏";
    var goback = function() {
        _this.hidePay();
    };
    a.addEventListener("click", goback);
    p.appendChild(a);
    payres.appendChild(p);
  
};
JxwPayUI.prototype.showKeyPlay = function() {
    var trybox = document.getElementById('trybox');
    var _this = this;
    if (trybox) {
        var url = _this.jxw.utils.getOrigin() + "/user/guestInfo.html";
        _this.jxw.utils.ajax(url, function(data) {
            if (data&&data.code==200) {
                document.getElementById("username").value = data.data.account;
                document.getElementById("password").value = data.data.password;
                trybox.style.display = 'block'
            }
        })
    };
    var confirm_mod = document.getElementById('confirm_mod');
    var setKeyPlay = function(e) {
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        var url = _this.jxw.utils.getOrigin()+ "/user/bind.html";
        _this.jxw.utils.ajaxPost(url,{uid:_this.jxw.pay.data.uid,account:username,password:password}, function(data) {
            if (data.code!=200) {
                alert(data.msg);
                return
            };
            document.getElementById('trybox').style.display = 'none';
            _this.jxw.pay.ready(0)
        })
    };
    confirm_mod.addEventListener("click", setKeyPlay);
    var tryclose = document.getElementById("tryclose");
    if (tryclose) {
        tryclose.addEventListener('click', function() {
            trybox.style.display = "none"
        })
    }
};
JxwPayUI.prototype.setPayType = function(type) {
    this.jxw.pay.data.paytype = type;
    for (var i = 1; i <= 8; i++) {
        $("#checked" + i).removeClass("checked")
    };
    $("#checked" + type).addClass("checked")
};
JxwPayUI.prototype.showQrcode = function(data) {
    var _this = this;
    var jxwpayqrcode = document.getElementById("jxwpayqrcode");
    if (!jxwpayqrcode) {
        var popup = document.getElementById("popup");
        var jxwpayqrcode = document.createElement("div");
        jxwpayqrcode.className = "popdiv";
        jxwpayqrcode.id = "jxwpayqrcode";
        jxwpayqrcode.style = "width: 300px; top: 25%;";
        popup.appendChild(jxwpayqrcode)
    };
    jxwpayqrcode.style.display = "block";
    var h3 = document.createElement("h3");
    h3.innerHTML = this.jxw.utils.getAppType() == "wx" ? "长按二维码识别完成支付" : "微信扫一扫完成支付";
    jxwpayqrcode.appendChild(h3);
    var close, closeIcon;
    close = document.createElement("div");
    close.className = "close";
    closeIcon = document.createElement("i");
    closeIcon.className = "icon-close";
    close.appendChild(closeIcon);
    var closeWxPay = function(e) {
        _this.hideQrcode();
        _this.jxw.pay.payCancel();
        close.removeEventListener("click", closeWxPay)
    };
    close.addEventListener("click", closeWxPay);
    jxwpayqrcode.appendChild(close);
    var paytable;
    paytable = document.createElement("div");
    paytable.className = "paywxtable clearfix";
    var qr = qrcode(10, 'H');
    qr.addData(data.data.url);
    qr.make();
    paytable.innerHTML = qr.createImgTag();
    jxwpayqrcode.appendChild(paytable)
};
JxwPayUI.prototype.hideQrcode = function() {
    var div = document.getElementById("jxwpayqrcode");
    if (div) div.parentElement.removeChild(div)
};
JxwApp = function(jxw){
    this.jxw = jxw;
    this.shareOK = null ;
    this.shareCancel = null ;
    this.random = null;
};
JxwApp.prototype.share = function(){
    this.random = this.jxw.utils.getRandomString(6);
    JSInterface.share(
        this.jxw.shareData.title,
        this.jxw.shareData.imgurl,
        this.jxw.shareData.link,
        this.jxw.shareData.content,
        this.random
    );
};
JxwApp.prototype.shareCallback = function(random){
    if(random == this.random){
        this.postMessage({action: "share:ok"})
    }
};


/*
 * 
 * JxwUtils(工具类)
 * */

JxwUtils = function(jxw) {
    this.jxw = jxw
};
JxwUtils.prototype.loading = function(time) {
    var frame = document.getElementById('jxwloadingframe');
    if (!frame) {
        frame = document.createElement("iframe");
        frame.id = "jxwloadingframe";
        frame.className = "jxwloadingframe";
        frame.align = "middle";
        document.getElementsByTagName("body")[0].appendChild(frame)
    };
   
    setTimeout(function() {
        var frame = document.getElementById('jxwloadingframe');
        if (frame) {
            frame.remove()
        }
    }, 2100)
};
JxwUtils.prototype.waiting = function() {
    var popupwait = document.getElementById("popupwait");
    popupwait.style.display="block";
    /*
    if (!popupwait) {
        popupwait = document.createElement('div');
        popupwait.id = 'popupwait';
        popupwait.className = 'popupload';
        document.getElementsByTagName('body')[0].appendChild(popupwait)
    };
    var popd = document.createElement("div");
    popd.className = "popd";
    var img = document.createElement("img");
    img.src = "../image/load.gif";
    popd.appendChild(img);
    popupwait.appendChild(popd);
    var popv = document.createElement("div");
    popv.className = "popv";
    var p = document.createElement("p");
    p.innerHTML = "正在进入安全支付环境中,请稍后...";
    popv.appendChild(p);
    var span = document.createElement("span");
    span.innerHTML = "如果长时间无反应请刷新游戏页面";
    popv.appendChild(span);
    popupwait.appendChild(popv)
    */
};
JxwUtils.prototype.hideWait = function() {
    var popupwait = document.getElementById('popupwait');
    popupwait.style.display="none";
    /*
    if (popupwait) {
        popupwait.remove();
    }
    */
};
JxwUtils.prototype.showMsg = function(msg){
    if(msg == '') return false;
    $(".regeditBg .regeditSucceed").html(msg);
    $('.regeditBg').show().delay(2000).hide(0);
};
JxwUtils.prototype.extend = function(target, options) {
    if (target == undefined || target == null) {
        return options
    } else {
        if (options) {
            for (var name in options) {
                target[name] = options[name]
            }
        };
        return target
    }
};
JxwUtils.prototype.getParameter = function(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return r[2];
    return null
};
JxwUtils.prototype.formatMoney = function(money, options) {
    if (money == "undefined" || money == "" || isNaN(money)) return;
    var defaults = {
        symbol: true,
        unit: true,
        bold: false,
        space: false
    };
    options = this.extend(defaults, options);
    var s = ((money) / 100).toFixed(2);
    if (options.bold) s = "<em>" + s + (options.unit ? "元" : "") + "</em>";
    s = (options.symbol ? "￥" : "") + s + (options.space ? " " : "");
    return s
};
JxwUtils.prototype.isMobile = function() {
    var mobileAgent = new Array("iphone", "ipod", "ipad", "android", "mobile", "blackberry", "webos", "incognito", "webmate", "nokia", "ucweb", "skyfire");
    var ua = navigator.userAgent.toLowerCase();
    for (var i = 0; i < mobileAgent.length; i++) {
        if (ua.indexOf(mobileAgent[i]) != -1) {
            return true
        }
    };
    return false
};
JxwUtils.prototype.isIOS = function() {
    return /iPhone|iPod|iPad|Mac/ig.test(navigator.userAgent)
};
JxwUtils.prototype.isAndroid = function() {
    return /android|linux/i.test(navigator.userAgent)
};
JxwUtils.prototype.getAppType = function() {
    var ua = navigator.userAgent;
    if (/(micromessenger|webbrowser)/.test(ua.toLocaleLowerCase())) {
        return "wx"
    }else if (/(wxapppay)/.test(ua.toLocaleLowerCase())) {
        return "wxapppay"
    }else if (/(android_jiuxiangwan)/.test(ua.toLocaleLowerCase())) {
        return "androidapp"
    }else {
        return "other"
    }
};
JxwUtils.prototype.isWindowsWechat = function() {
    return /WindowsWechat/ig.test(navigator.userAgent)
};
JxwUtils.prototype.h5GetPageSize = function() {
    var xScroll, yScroll;
    if (window.innerHeight && window.scrollMaxY) {
        xScroll = window.innerWidth + window.scrollMaxX;
        yScroll = window.innerHeight + window.scrollMaxY
    } else {
        if (document.body.scrollHeight > document.body.offsetHeight) {
            xScroll = document.body.scrollWidth;
            yScroll = document.body.scrollHeight
        } else {
            xScroll = document.body.offsetWidth;
            yScroll = document.body.offsetHeight
        }
    };
    var windowWidth, windowHeight;
    if (self.innerHeight) {
        if (document.documentElement.clientWidth) {
            windowWidth = document.documentElement.clientWidth
        } else {
            windowWidth = self.innerWidth
        };
        windowHeight = self.innerHeight
    } else {
        if (document.documentElement && document.documentElement.clientHeight) {
            windowWidth = document.documentElement.clientWidth;
            windowHeight = document.documentElement.clientHeight
        } else {
            if (document.body) {
                windowWidth = document.body.clientWidth;
                windowHeight = document.body.clientHeight
            }
        }
    };
    if (yScroll < windowHeight) {
        pageHeight = windowHeight
    } else {
        pageHeight = yScroll
    };
    if (xScroll < windowWidth) {
        pageWidth = xScroll
    } else {
        pageWidth = windowWidth
    };
    arrayPageSize = new Array(pageWidth, pageHeight, windowWidth, windowHeight);
    return arrayPageSize
};
JxwUtils.prototype.changeScreen = function() {
    var wh = this.h5GetPageSize();
    document.getElementById("iframe").style.width = wh[2] + 'px';
    document.getElementById("iframe").style.height = wh[3] + 'px'
};
JxwUtils.prototype.listenerChangeScreen = function() {
    setTimeout(this.changeScreen, 100)
};
JxwUtils.prototype.getOrigin = function(){
    if (window.location.origin) {
        return window.location.origin
    } else {
        return window.location.protocol + "//" + window.location.hostname + (window.location.port ? ":" + window.location.port : "")
    }
};
JxwUtils.prototype.getImageUrl = function(){
	
		return $("#gameInfo").val(); 
    
};
JxwUtils.prototype.getFullUrl = function() {
    return location.href.match(/[^#;]+/i)[0]
};
JxwUtils.prototype.getPath = function() {
    if (location.pathname) {
        return location.pathname
    } else {
        return location.href.match(/(?:http|https):\/\/[^\/]+([^?#;]+)/i)[1]
    }
};
JxwUtils.prototype.getUrlParam = function(name){
    var reg = new RegExp("(^|&)"+name+"=([^&]*)(&|$)");
    var r =  window.location.search.substr(1).match(reg);
    var strValue = "";
    if (r!=null){
        strValue= unescape(r[2]);
    }
    return strValue;
};
JxwUtils.prototype.now =function(){
    var dt = new Date();
    dt.setMilliseconds(0);
    return dt.getTime() / 1000
};
JxwUtils.prototype.getRandomString = function(len) {
    var base = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    var str = "";
    for (var i = 0; i < len; i++) {
        var n = this.getRandomInt(1, base.length) - 1;
        str += base.substr(n, 1)
    }
    ;return str
};
JxwUtils.prototype.getRandomInt = function(min, max) {
    return parseInt((Math.random() * (max - min + 1)) + min)
};
JxwUtils.prototype.getQueryString = function(name){
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return null;
};
JxwUtils.prototype.loadJSAsync = function(jsurl, callback) {
        var nodeHead = document.getElementsByTagName('head')[0];
        var nodeScript = null;
        nodeScript = document.createElement('script');
        nodeScript.setAttribute('type', 'text/javascript');
        nodeScript.setAttribute('src', jsurl);
        if (callback != null) {
            nodeScript.onload = nodeScript.onreadystatechange = function () {
                if (nodeScript.ready) {
                    return false;
                }
                if (!nodeScript.readyState || nodeScript.readyState == "loaded" || nodeScript.readyState == 'complete') {
                    nodeScript.ready = true;
                    callback(true);
                }
            };
            nodeScript.onerror = function (ev) {
                callback(false);
            };
        }
        nodeHead.appendChild(nodeScript);
    }

JxwUtils.prototype.jsonp = function(url, callback) {
    if (!url) {
        return;
    }
    var a = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j']; //定义一个数组以便产生随机函数名
    var r1 = Math.floor(Math.random() * 10);
    var r2 = Math.floor(Math.random() * 10);
    var r3 = Math.floor(Math.random() * 10);
    var name = 'getJSONP' + a[r1] + a[r2] + a[r3];
    var cbname = 'JxwSv.' + name; //作为jsonp函数的属性
    if (url.indexOf('?') === -1) {
        url += '?callback=' + cbname;
    } else {
        url += '&callback=' + cbname;
    }
    var script = document.createElement('script');
    //定义被脚本执行的回调函数
    JxwSv[name] = function (e) {
        try {
            callback && callback(e);
        }catch (e) {
            //
        }
        finally {
            //最后删除该函数与script元素
            delete JxwSv[name];
            script.parentNode.removeChild(script);
        }
    };
    script.src = url;
    document.getElementsByTagName('head')[0].appendChild(script);
};

JxwUtils.prototype.ajax = function() {
    var options = {
        method: "GET",
        url: "",
        data: null,
        type: "json",
        success: null,
        fail: null,
    };
    switch (arguments.length) {
        case 1:
            if (typeof arguments[0] == "string") options.url = arguments[0];
            if (typeof arguments[0] == "object") options = this.extend(options, arguments[0]);
            break;
        case 2:
            options.url = arguments[0];
            options.success = arguments[1];
            break
    };
    new JxwUtilsAjax(this.jxw, options.method, options.url, options.data, options.type, options.success, options.fail)
};
JxwUtils.prototype.ajaxPost = function() {
		var options = {
        method: "POST",
        url: "",
        data: null,
        type: "json",
        success: null,
        fail: null,
    };
		switch (arguments.length) {
	      case 1:
	          if (typeof arguments[0] == "string") options.url = arguments[0];
	          if (typeof arguments[0] == "object") options = this.extend(options, arguments[0]);
	          break;
	      case 2:
	          options.url = arguments[0];
	          options.success = arguments[1];
	          break
        case 3:
		        options.url = arguments[0];
		        options.data = arguments[1];
		        options.success = arguments[2];
        break
	          
	  };
   new JxwUtilsAjax(this.jxw, options.method, options.url, options.data, options.type, options.success, options.fail);
};

/*
 * 
 * JxwUtilsAjax(ajax传输类)
 * */

JxwUtilsAjax = function(jxw, method, url, data, type, success, fail) {
    this.jxw = jxw;
    this.url = url;
    this.type = type;
    this.success = success;
    this.fail = fail;
    this.xhr = null;
    this.xhr = this.createXHR();
    var _this = this;
    this.xhr.onreadystatechange = function() {
        _this.callback.apply(_this)
    };
    if (typeof data == "object" && data != null) {
        var a = [];
        for (var p in data) {
            a.push(p + "=" + encodeURIComponent(data[p]))
        };
        data = a.join("&")
    };
    try {
        this.xhr.open(method, url, true);
        if (method.toUpperCase() == "POST") {
            this.xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8")
        };
        this.xhr.send(data)
    } catch (e) {
        console.log(url);
        console.log(e)
    }
};
JxwUtilsAjax.prototype.createXHR = function() {
    if (window.XMLHttpRequest) {
        return new XMLHttpRequest()
    } else {
        return new ActiveXObject("Microsoft.XMLHTTP")
    }
};
JxwUtilsAjax.prototype.callback = function() {
    if (this.xhr.readyState == 4 && this.xhr.status == 200) {
        var data = null;
        switch (this.type) {
            case "text":
                data = this.xhr.responseText;
                break;
            case "json":
                try {
                    data = JSON.parse(this.xhr.responseText)
                } catch (e) {
                    data = this.xhr.responseText
                };
                break
        };
        this.success && this.success.call(this.xhr, data)
    } else if (this.xhr.readyState == 4 && this.xhr.status != 200) {
        this.fail && this.fail.call(this.xhr)
    }
};

/**
 * JxwWx 微信工具类
 * 
 * */
JxwWx = function(jxw){
    this.jxw = jxw;
    this.ready = false;
    this.shareOK = null ;
    this.shareCancel = null ;
    this.init();
};
JxwWx.prototype.init = function(){
    var _this = this;
    this.onReady(function(){
        _this.setShareData();
    });
    _this.initJsApi();
};
JxwWx.prototype.initJsApi = function(){
    var timestamp = this.jxw.utils.now();
    var noncestr = this.jxw.utils.getRandomString(16);
    
    var url = location.href.split('#')[0];
   	url = url.replace(/\&/g, '%26');
     /*var ejym = url.split("75zg.com")[1];
		//ejym = ejym.split("//")[1];
		url = "http://www.75zg.com"+ejym;//url.replace(ejym,"www");*/
    var ajaxUrl =  this.jxw.utils.getOrigin()+ "/share.html?noncestr=" + noncestr +"&timestamp=" + timestamp + "&url=" + encodeURIComponent(url);
    var _this = this;
    this.jxw.utils.ajax(ajaxUrl,function(data){
        if(data.code==200) {
        		//alert(location.href.split('#')[0]);
            var signature = data.data.signature;
            wx.config({
                debug: false,
                appId: data.data.appId,
                timestamp: data.data.timestamp,
                nonceStr: data.data.nonceStr,
                signature: signature,
                jsApiList: ["checkJsApi", "onMenuShareTimeline","onMenuShareAppMessage"]
            });
            wx.ready(function(){
                _this.ready = true;
                _this.jxw.dispatchEvent("wxReady")
            });
            wx.error(function(res) {});
        }
    });
};
JxwWx.prototype.onReady = function(callback) {
    if (this.ready) {
        callback && callback.call(this);
    } else {
        var _this = this;
        this.jxw.addEventListener("wxReady", function() {
            callback && callback.call(_this)
        });
    }
};
JxwWx.prototype.setShareOk = function(){
    var _this = this;
    this.shareOK = function(){
        _this.jxw.postMessageFrame({action: "share:ok"});
    }
};
JxwWx.prototype.setShareData = function() {
    var _this = this;
    var link=this.jxw.shareData.link;
    
    
    
		//var ejym = link.split("75zg.com")[1];
		
		//link = "http://www.75zg.com"+ejym;
    
    link = link.substr(0, link.indexOf('%26'));
    
    var imgYrl=this.jxw.shareData.imgurl;
    var desc = this.jxw.shareData.title;//
    var titles = this.jxw.shareData.title;
    wx.onMenuShareTimeline({
        title: titles,
        link: link,
        imgUrl: imgYrl,
        success: function() {
            _this.shareOKHandler()
        },
        cancel: function() {
            _this.shareCancelHandler()
        }
    });
    wx.onMenuShareAppMessage({
        title: window.location.title,//window.location.title, // 分享标题
        desc: desc, // 分享描述 九  零 一 起 玩www .9 01  7 5.com
        link: link, // 分享链接，该链接域名需在JS安全域名中进行登记
        imgUrl: imgYrl, // 分享图标
        success: function () {
            _this.shareOKHandler()
            // 用户确认分享后执行的回调函数
        },
        cancel: function () {
            _this.shareCancelHandler()
            // 用户取消分享后执行的回调函数
        }
    });
};
JxwWx.prototype.shareOKHandler = function(){
    this.shareOK && this.shareOK.call(null);
};
JxwWx.prototype.shareCancelHandler = function(){
    this.shareCancel && this.shareCancel.apply(this.jxw);
};

JxwCh = function(jxw){
    this.jxw = jxw;
    this.options = {};
    this.init();
};
JxwCh.prototype.init = function(){
    var url = this.jxw.utils.getOrigin() + "/getChannel.html?channel=" + this.jxw.channel;
    var _this = this;
    $.getJSON(url,'',function(res){
        if(res.status ==1)
            _this.setCHData(res.data);
    });
};

JxwCh.prototype.setCHData = function(data){
    var optiones = {
        id:data.id,
        name:data.name,
        title:data.title,
        links:data.links,
        qq:data.qq,
        group:data.group,
        logo:data.logo,
        back:data.back,
        qrcode:data.qrcode,
        isplace:data.isplace,
    };
    this.optiones = optiones;
    this.replace();
};
JxwCh.prototype.replace = function(){
    if(this.optiones.logo)
        $('.logo').attr('src',this.optiones.logo);
    if(this.optiones.qq && this.optiones.group){
        var html = this.optiones.title + 'H5游戏群(有礼包)：'+ this.optiones.qq +'<br><a class="group" href="'+ this.optiones.group +'"><img src="../image/group.png"/></a>';
        $("#addgroup").html(html);
        $('.join_qq').attr('href',this.optiones.group);
    }
    if(this.optiones.qrcode){
        $(".wxqrcode").attr('src',this.optiones.qrcode);
    }
    var text = '';//'搜索“'+ this.optiones.title +'”关注公众号'
    $('#con_switch_2 .game-code h4').html(text);
};




function setTab(name,cursel,n){
    for(i=1;i<=n;i++){
        var menu=document.getElementById(name+i);
        var con=document.getElementById("con_"+name+"_"+i);
        menu.className=i==cursel?"now":"";
        con.style.display=i==cursel?"block":"none";
        if(cursel == 2) $("#switch2").find(".hong").remove();
    }
};





function getUsername(frameid){
	var fsc = document.getElementById(frameid);
    var url = fsc.src; //获取url中"?"符后的字串
    if (url) {
       var str = url.split("?")[1]; 
       if(str){
	       var arg = str.split("&");
	       for(var i=0;i<arg.length;i++){
	    	   var strs = arg[i].split("=");   //用等号进行分隔 （因为知道只有一个参数 所以直接用等号进分隔 如果有多个参数 要用&号分隔 再用等号进行分隔）
	           if(strs[0]&&strs[0]=='username'){
	        	  return strs[1];
	           }
	       }
	     }
       
    }
    return  null;
}
String.prototype.startsWith=function(str){ 
	 if(str==null||str==""||this.length==0||str.length>this.length) 
	  return false; 
	 if(this.substr(0,str.length)==str) 
	   return true; 
	 else
	   return false; 
	 return true; 
}



