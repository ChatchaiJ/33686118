<?php

include "./flashenv.php";
include "./flashlib.php";

define("merchantID", $mchid);
define("merchantPW", $key);

define("ordersRoutes", "$api_svr/open/v1/orders/{pno}/routes");

if (!isset($_POST['pno']) and !isset($_GET['pno'])) {
                echo "<html>\n<body>\n";
        echo "ERR: need tracking number\n";
        echo "</body>\n</html>\n";
        return;
}

$pno = isset($_POST['pno'])?$_POST['pno']:$_GET['pno'];

$mchId = merchantID;
$nonceStr = time();

/*
	Check orders routes
*/

function queryRoutes($parcelNo)
{
	global $mchId, $nonceStr;

	$parcelNo = trim($parcelNo);
	$paramArr = array(
		"mchId"		=> $mchId,
		"nonceStr"	=> $nonceStr,
	);

	$post_str = buildRequestParam($paramArr);
	$url = str_replace("{pno}", $parcelNo, ordersRoutes);
	$responseStr = postRequest($url, $post_str);
	return $responseStr;
	// return json_decode($responseStr, true);
}

$res = queryRoutes($pno);

echo <<<EOT
<html>
<body>
<pre>
$res
</pre>
<p>
<a href="show-order.php?pno=$pno">Back</a>
</p>
</body>
</html>
EOT;

?>
