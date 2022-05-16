<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include "./flashenv.php";
include "./flashlib.php";

if (!isset($_POST['pno']) and !isset($_GET['pno'])) {
		echo "<html>\n<body>\n";
        echo "ERR: need tracking number\n";
        echo "</body>\n</html>\n";
        return;
}

$pno = isset($_POST['pno'])?$_POST['pno']:$_GET['pno'];

/* data definition */
define("merchantID", $mchid);
define("merchantPW", $key);
define("preprintUrl", "$api_svr/open/v1/orders/{pno}/pre_print");

function queryPrePrint($parcelNo)
{
	$parcelNo = trim($parcelNo);
    $paramArr = array(
		"mchId" => merchantID,
        "nonceStr" => time(),
	);
    $post_str = buildRequestParam($paramArr);
    $url = str_replace("{pno}", $parcelNo, preprintUrl);
    return postRequestAndGetAttachment($url, $post_str);
}
list($name, $type, $content) = queryPrePrint($pno);

if ($type == 'application/pdf') {
	header("Content-type: $type");
	header("Content-Disposition: inline; filename=$name");
	echo "$content";
} else {
	echo "<html>\n<body>\n";
	echo "ERR: Can't get preprint for $pno<br>";
	echo "</body>\n</html>\n";
}

?>
