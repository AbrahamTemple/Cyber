# RC4������Կ�ӽ����ļ�

## Դ��

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
				 echo $file."������ɣ���ʱ".number_format($elapsed,10,'.','').'��';
				 exit;
			 }
			 echo $file."����ʧ�ܣ����ļ��ѱ����ܹ�";
			 die;
		}
		echo $file."����ʧ�ܣ�Ŀ���ļ��Ѷ�ʧ";
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
				 echo $file."������ɣ���ʱ".number_format($elapsed,10,'.','').'��';
				 exit;
			 }
			 echo $file."����ʧ�ܣ����ļ��ѱ����ܹ�";
			 die;
		} 
		echo $file."����ʧ�ܣ�Ŀ���ļ��Ѷ�ʧ";
	}
```

## ����

��ȡ�ļ����������ݣ���RC4���ܺ���д��ԭ�ļ�

���ܹ����෴