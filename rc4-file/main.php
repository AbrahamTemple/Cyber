<?php
	//脚本可能消耗的最大内存量
	ini_set('memory_limit','250M');

	//基于套接字的流的默认超时,单位秒
	ini_set('default_socket_timeout', 120);
	
	//接受的POST数据的最大大小
	ini_set('post_max_size', '200M');

	//脚本分析请求数据可能花费的最长时间
	ini_set('max_input_time', 120);

	//代码可以被执行的时间,单位秒
	ini_set('max_execution_time', 120);

	require_once('until.php');
	
	function reader($file){
		$opt = array(
			'http' => array(
				'method' => array('GET','POST'),
				'timeout' => 300,
				'header'=>array(
					"Accept-language: en",
					"Content-type: application/x-www-form-urlencoded"
				)
			)
		);
		$context = stream_context_create($opts);
		return file_get_contents($file,FALSE,$context,0,1024 * 1024 * 100);
	}
	
	function writer($file,$data){
		//防止数组绕过
		if(is_array($data)){
			echo 'Illegal array';
			die;
		}
		$opt = array(
			'http' => array(
				'method' => array('GET','POST'),
				'timeout' => 300,
				'header'=>array(
					"Accept-language: en",
					"Content-type: application/x-www-form-urlencoded"
				)
			)
		);
		$context = stream_context_create($opts);
		//LOCK_EX排它锁：只能被一个线程使用
		return file_put_contents($file,$data,LOCK_EX,$context);
	}
	
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
	
	
	
	// 解密出来看看吧
	// ecrypt('2M.mp4');
	
	decrypt('2M.mp4');
	
	// 默认情况一次请求可以稳定执行20M以内的文件
	// ecrypt('20M.rar');
	
	// decrypt('20M.rar');
	
	// 在20-30M之间并不稳定，30M以上不配置php.ini直接失败
	// ecrypt('30M.exe');
	
	// decrypt('30M.exe');
	