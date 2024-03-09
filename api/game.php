<?php

session_start();

if(!isset($_SESSION) || count($_SESSION) < 5){
	Header("Location: ../index.php");
	exit;
}
session_destroy();
?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="utf-8">
    <title>RAGEZONE Mu Legend H5 'bigpatreon'</title>
    <meta name="viewport" content="width=device-width,initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="full-screen" content="true" />
    <meta name="screen-orientation" content="portrait" />
    <meta name="x5-fullscreen" content="true" />
    <meta name="360-fullscreen" content="true" />
    <style>
        html, body {
            -ms-touch-action: none;
            background: #000000;
            padding: 0;
            border: 0;
            margin: 0;
            height: 100%;
        }
    </style>
</head>

<body>
    <div style="margin: auto;width: 100%;height: 100%;" class="egret-player"
         data-entry-class="Main"
         data-orientation="portrait"
         data-scale-mode="fixedNarrow"
         data-frame-rate="30"
         data-content-width="720"
         data-content-height="1280"
         data-show-paint-rect="false"
         data-multi-fingered="2"
         data-show-fps="false" data-show-log="false"
         data-show-fps-style="x:0,y:0,size:12,textColor:0xffffff,bgAlpha:0.9">
    </div>
<script>
    var loadScript = function (list, callback) {
        var loaded = 0;
        var loadNext = function () {
            loadSingleScript(list[loaded], function () {
                loaded++;
                if (loaded >= list.length) {
                    callback();
                }
                else {
                    loadNext();
                }
            })
        };
        loadNext();
    };

    var loadSingleScript = function (src, callback) {
        var s = document.createElement('script');
        s.async = false;
        s.src = src;
        s.addEventListener('load', function () {
            s.parentNode.removeChild(s);
            s.removeEventListener('load', arguments.callee, false);
            callback();
        }, false);
        document.body.appendChild(s);
    };

    var loadEntry = function () {
        var list = ["../ver/" + window["engineVersion"] + "/engine.js", "../ver/" + window["entryVersion"] + "/entry.min.js"];
        loadScript(list, function () {
            /**
             * {
             * "renderMode":, //Engine rendering mode, "canvas" or "webgl"
             * "audioType": 0 //Use the audio type, 0: default, 2: web audio, 3: audio
             * "antialias": //Whether the anti-aliasing is enabled in WebGL mode, true: on, false: off, defaults to false
             * "calculateCanvasScaleFactor": //a function return canvas scale factor
             * }
             **/
            egret.runEgret({
                renderMode: "webgl", audioType: 0, calculateCanvasScaleFactor: function (context) {
                    var backingStore = context.backingStorePixelRatio ||
                        context.webkitBackingStorePixelRatio ||
                        context.mozBackingStorePixelRatio ||
                        context.msBackingStorePixelRatio ||
                        context.oBackingStorePixelRatio ||
                        context.backingStorePixelRatio || 1;
                    return (window.devicePixelRatio || 1) / backingStore;
                }
            });
        });
    }

    function requestEntryVer() {

        var request = new XMLHttpRequest();
        request.open('GET', entryUrl);
        request.addEventListener("load", function () {
            if (request.status != 404) {
                var json = JSON.parse(request.response);
                window["entryVersion"] = json["entry_version"];
                window["engineVersion"] = json["engine_version"];
            }
            loadEntry();
        });
        request.addEventListener("error", function () {
            loadEntry();
        });
        request.send(null);
    }


    var jsonName = "login.json";
    var pfId = "zy";
    var params = location.href.split("?")[1];
    var qdId = "";
    if (params && params != "") {
        var temps = params.split("&");//a=b
        for(var i = 0; i< temps.length; i++)
        {
            var arr = temps[i].split("=");
            var key = arr[0];
            var value = arr[1];
            if (key == "user") {
                jsonName = "login_" + value + ".json";
            }
            if(key == "pfId"){
                pfId = value;
            } 
            if(key == "qdId"){
                qdId = value;
            }         
        }


    }
    window["jsonName"] = "login_zycs.json";
    window["hosts"] = "../";
    window["entryHosts"] = "./";
    window["pfId"] = pfId;
    window["qdId"] = qdId;
    window["gonggao"] = 1;
	window["yszcFile"] = "mk_yszc.json";
	window["isShiming"] = 1;
    var entryUrl = "https://muvuongquyen.com/" + pfId +"/api/entryVersion";
    requestEntryVer();
</script>
</body>

</html>