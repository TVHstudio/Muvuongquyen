echo off
cls

set root=%cd%

set c=%cd%\js

if exist %root%\engine.js .>%engine.js
if not exist %root%\engine.js (
cd.>%engine.js
)


set list= egret.min.js egret.web.min.js eui.min.js assetsmanager.min.js tween.min.js game.min.js socket.min.js promise.min.js
for %%i in (%list%) do (
echo "%c%\%%i"
::copy "%c%\%%i"/a+"%%i"/a "%root%\engine.js"
type "%c%\%%i" >> "%root%\engine.js"
)

del /q /s %c%\*.*

move %cd%\engine.js %c%\engine.js



