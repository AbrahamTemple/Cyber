# RC4基于密钥加解密文件

## 源码

``` php
	function ecrypt($file){
		$secretKey = md5('https://github.com/AbrahamTemple');
		if(is_file($file)){
			 $start = microtime(true);
			 $context = reader($file);
			 if(!is_base64($context)){
				 $enstr  = base64_encode(rc4($context, $secretKey));
				 writer($file,$enstr);
				 $elapsed = microtime(true) - $start;
				 echo $file."加密完成，用时".number_format($elapsed,10,'.','').'秒';
				 exit;
			 }
			 echo $file."加密失败，该文件已被加密过";
			 die;
		}
		echo $file."加密失败，目标文件已丢失";
	}
	
	function decrypt($file){
		$secretKey = md5('https://github.com/AbrahamTemple');
		if(is_file($file)){
			 $start = microtime(true);
			 $context = reader($file);
			 if(is_base64($context)){
				 $destr = rc4(base64_decode($context), $secretKey);
				 writer($file,$destr);
				 $elapsed = microtime(true) - $start;
				 echo $file."解密完成，用时".number_format($elapsed,10,'.','').'秒';
				 exit;
			 }
			 echo $file."解密失败，该文件已被解密过";
			 die;
		} 
		echo $file."解密失败，目标文件已丢失";
	}
```

## 解释

读取文件的所有内容，用RC4加密后再写入原文件

解密过程相反