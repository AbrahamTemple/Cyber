# 图片隐藏压缩包

## 使用

- 拼接图片和压缩包为图片

``` bash
copy /b narmal.jpg+test.rar hidden.jpg
```

- 图片能用，且扩展名修改为rar也可以正常解压

## 原理

copy命令/B参数只是把两个文件的二进制数据头尾拼接

比如:

> copy /B 1.png+2.rar 3.zip

上面只是把2.rar接在了1.png后面，输出了3.zip

有的解压软件能识别3.zip，只是因为软件从头到尾扫描3.zip，看有没有zip文件头50 4B

然而假如:


``` bash
copy /B 2.zip+1.png 3.png
```

上面输出的3.png不能被大多数看图软件识别

这恰能说明做到图片藏压缩包的不是copy命令，而是解压软件本身

[文章引自](https://zhidao.baidu.com/question/488505332.html)