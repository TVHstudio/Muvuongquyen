(function() {
    var cpSdkVersion = "20210712";
    function loadScript(url, callback) {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.onload = function() {
            callback && callback();
        };
        script.onerror = function() {
            script.parentNode.removeChild(script);
            setTimeout(function() {
                loadScript('https://muvuongquyen.com/pass4/js/jssdk/h5gamecn_cp.min.js?v='+cpSdkVersion);
            }, 1000);
        };
        script.src = url // + '?v=' + gameVersion;
        document.getElementsByTagName("head")[0].appendChild(script);
    }
    loadScript('https://muvuongquyen.com/pass4/js/jssdk/h5gamecn_cp.min.js?v='+cpSdkVersion,
        function() {
            if (!window.__sdkready) {
            	console.log('__sdkready 未就绪');
                var interval = setInterval(function() {
                    if (window.__sdkready) {
                    	console.log('__sdkready 已就绪');
                        clearInterval(interval);
                        window.__sdkready.call();
                    }
                }, 1000);
            }else{
            	console.log('__sdkready 正常调用');
            	window.__sdkready.call();
            }
        });
})();