<?php

# You need to change this to match your working environment

$url = "http://localhost/33686118/save-order.php";

/* build post param str */
function buildRequestParam($data_arr)
{
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
    $header[] = "Accept: text/html";
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

$data_arr = array(
        "srcName" => 'หอมรวม',
        "srcPhone" => '0630101454',
        "srcProvinceName" => 'อุบลราชธานี',
        "srcCityName" => 'เมืองอุบลราชธานี',
        "srcDistrictName" => 'ในเมือง',
        "srcPostalCode" => '34000',
        "srcDetailAddress" => '68/5-6 ม.1 บ้านท่าบ่อ',
		"srcSaveAddress" => 1,
        "dstName" => 'น้ำพริกแม่อำพร',
        "dstPhone" => '0970209976',
        "dstHomePhone" => '0970220220',
        "dstProvinceName" => 'เชียงใหม่',
        "dstCityName" => 'สันทราย',
        "dstDistrictName" => 'สันพระเนตร',
        "dstPostalCode" => '50210',
        "dstDetailAddress" => '127 หมู่ 3',
		"dstSaveAddress" => 1,
		"codEnabled" => 0,
		"codAmount" => 0
);

$file = fopen("testdata.csv","r");
$src = fgetcsv($file);
while(!feof($file)) {
	$dst = fgetcsv($file);
	if (!isset($dst[0]))
		break;
	$data_arr = array(
        "srcName"			=> $src[0],
        "srcPhone"			=> $src[1],
        "srcDetailAddress"	=> $src[2],
        "srcDistrictName"	=> $src[3],
        "srcCityName"		=> $src[4],
        "srcProvinceName"	=> $src[5],
        "srcPostalCode"		=> $src[6],
		"srcSaveAddress"	=> 1,
        "dstName"			=> $dst[0],
        "dstPhone"			=> $dst[1],
        "dstDetailAddress"	=> $dst[2],
        "dstDistrictName"	=> $dst[3],
        "dstCityName"		=> $dst[4],
        "dstProvinceName"	=> $dst[5],
        "dstPostalCode"		=> $dst[6],
		"dstSaveAddress"	=> 1,
		"codEnabled"		=> 1,
		"codAmount"			=> rand(10,100)*100
	);
	$post_str = buildRequestParam($data_arr);
	echo postRequest($url, $post_str);
	$src = $dst;
}
fclose($file);

?>
