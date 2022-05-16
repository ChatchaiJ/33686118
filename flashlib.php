<?php
	/* sign function */
	function signParam($str)
	{
		return strtoupper(hash("sha256", $str));
	}
	
	/* build post param str */
	function buildRequestParam($data_arr)
	{
		$sign = '';
		ksort($data_arr);
	        foreach($data_arr as $k => $v)
		{
			if((($v != null) || $v === 0) && ($k != 'sign'))
			{
				$sign .= $k.'='.$v.'&';
			}else{
				unset($data_arr[$k]);
			}
        	}
		$sign .= "key=" . merchantPW;
		
		$data_arr['sign'] = signParam($sign);
		
		$requestStr = '';
		foreach($data_arr as $k => $v)
		{
			$requestStr .= $k . "=" . urlencode($v) . '&';
		}
		return substr($requestStr, 0, -1);
	}
	
	/* common post funciton used for all web requests */
	function postRequest($url, $postData)
	{
		$curl = curl_init ();
		$header[] = "Content-type: application/x-www-form-urlencoded";
		$header[] = "Accept: application/json";
		$header[] = "Accept-Language: th";
		curl_setopt ( $curl, CURLOPT_URL, $url );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, false ); // SSL certificate
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt ( $curl, CURLOPT_HEADER, 0 );
		curl_setopt ( $curl, CURLOPT_HTTPHEADER, $header );
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $curl, CURLOPT_POST, true ); // post
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $postData ); // post data
		curl_setopt ( $curl, CURLOPT_TIMEOUT, 10 );
		
		$responseText = curl_exec ( $curl );
		if (curl_errno ( $curl )) {
				echo 'Errno' . curl_error ( $curl );
		}
		curl_close ( $curl );
		return $responseText;
	}

	/* common post funciton used for download attachments requests */
	function postRequestAndDownload($url, $postData, $saveDir)
	{
		$curl = curl_init ();
		$header[] = "Content-type: application/x-www-form-urlencoded";
		$header[] = "Accept: application/json";
		$header[] = "Accept-Language: th";
		curl_setopt ( $curl, CURLOPT_URL, $url );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, false ); // SSL certificate
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt ( $curl, CURLOPT_HEADER, 1 );
		curl_setopt ( $curl, CURLOPT_HTTPHEADER, $header );
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $curl, CURLOPT_POST, true ); // post
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $postData ); // post data
		curl_setopt ( $curl, CURLOPT_TIMEOUT, 10 );
		curl_setopt ( $curl, CURLINFO_HEADER_OUT, true);
		
		$responseText = curl_exec ( $curl );
		if (curl_errno ( $curl )) 
		{
			echo 'Errno' . curl_error ( $curl );
		}
		curl_close ( $curl );

		list($headers, $body) = explode("\r\n\r\n", $responseText, 2);
		//1) process header
		$header_arr = array();
		$header_tmp = explode("\n", $headers);
		foreach($header_tmp as $header_value) 
		{
			$pos = strpos($header_value, ":");
			$k = trim(substr($header_value, 0, $pos));
			$v = trim(substr($header_value, $pos+1));
			if(!empty($k))
				$header_arr[$k] = $v;
		}
		$file_name = $header_arr['Content-Disposition'];
		$file_type = $header_arr['Content-Type'];
		$file_save_name = substr($file_name, strrpos($file_name, "=")+1);

		//2) process body
		$file_content = $body;
		$filename  = $saveDir . $file_save_name;
		if(is_writable($saveDir)) 
		{
			if(!$handle  =  fopen($filename, 'w')) 
			{
         			echo  "cannot open  $filename \n" ;
         			exit;
			}
     			if(fwrite($handle,  $file_content) ===  FALSE)
			{
				echo  "cannot write file  $filename\n" ;
        			exit;
			}
    			echo  "write $filename success\n" ;
			fclose($handle);
			return true;
		} 
		else 
		{
			echo  "file $filename not writable\n" ;
		}
		return false;
	}	

	/* common post funciton used for download attachments requests */
	function postRequestAndGetAttachment($url, $postData)
	{
		$curl = curl_init ();
		$header[] = "Content-type: application/x-www-form-urlencoded";
		$header[] = "Accept: application/json";
		$header[] = "Accept-Language: th";
		curl_setopt ( $curl, CURLOPT_URL, $url );
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, false ); // SSL certificate
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt ( $curl, CURLOPT_HEADER, 1 );
		curl_setopt ( $curl, CURLOPT_HTTPHEADER, $header );
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $curl, CURLOPT_POST, true ); // post
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $postData ); // post data
		curl_setopt ( $curl, CURLOPT_TIMEOUT, 10 );
		curl_setopt ( $curl, CURLINFO_HEADER_OUT, true);
		
		$responseText = curl_exec ( $curl );
		if (curl_errno ( $curl )) 
		{
			echo 'Errno' . curl_error ( $curl );
		}
		curl_close ( $curl );

		list($headers, $body) = explode("\r\n\r\n", $responseText, 2);
		
		$header_arr = array();
		$header_tmp = explode("\n", $headers);
		foreach($header_tmp as $header_value) 
		{
			$pos = strpos($header_value, ":");
			$k = trim(substr($header_value, 0, $pos));
			$v = trim(substr($header_value, $pos+1));
			if(!empty($k))
				$header_arr[$k] = $v;
		}
		$name = $header_arr['Content-Disposition'];
		$type = $header_arr['Content-Type'];
		$save_name = substr($name, strrpos($name, "=")+1);
		$content = $body;
		return array($save_name, $type, $content);
	}	
?>

