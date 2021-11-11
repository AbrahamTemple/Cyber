<?php
	function rc4($data, $pwd) {
	    $key[]       = "";
	    $box[]       = "";
	    $pwd_length  = strlen($pwd);
	    $data_length = strlen($data);
	    $cipher      = '';
		
	    if($pwd_length == 0){
		echo 'Invalid key';
		die;
	    }
	    for ($i = 0; $i < 256; $i++) {
	        $key[$i] = ord($pwd[$i % $pwd_length]);
	        $box[$i] = $i;
	    }
	    for ($j = $i = 0; $i < 256; $i++) {
	        $j       = ($j + $box[$i] + $key[$i]) % 256;
	        $tmp     = $box[$i];
	        $box[$i] = $box[$j];
	        $box[$j] = $tmp;
	    }
	    for ($a = $j = $i = 0; $i < $data_length; $i++) {
	        $a       = ($a + 1) % 256;
	        $j       = ($j + $box[$a]) % 256;
	        $tmp     = $box[$a];
	        $box[$a] = $box[$j];
	        $box[$j] = $tmp;
	        $k = $box[(($box[$a] + $box[$j]) % 256)];
	        $cipher .= chr(ord($data[$i]) ^ $k);
	    }
	    return $cipher;
	}
	
	function is_base64($str)
	{
	     return base64_encode(base64_decode($str)) == $str ? true : false;
	}
	
	// function is_base64($match){
	// 	$base64_code="[^([A-Za-z0-9+/]{4})*([A-Za-z0-9+/]{4}|[A-Za-z0-9+/]{3}=|[A-Za-z0-9+/]{2}==)$]";
	// 	if(!preg_match($base64_code, $match)){
	// 		return false;
	// 	} else {
	// 		return true;
	// 	}
	// }
