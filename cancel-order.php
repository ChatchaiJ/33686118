<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include "./flashenv.php";
include "./flashlib.php";

define("merchantID", $mchid);
define("merchantPW", $key);
define("cancelOrder", "$api_svr/open/v1/orders/{pno}/cancel");

if (!isset($_POST['pno']) and !isset($_GET['pno'])) {
		echo "<html>\n<body>\n";
        echo "ERR: need tracking number\n";
        echo "</body>\n</html>\n";
        return;
}

$pno = isset($_POST['pno'])?$_POST['pno']:$_GET['pno'];

try {
    $pdo = new PDO($dsn, $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$mchId = merchantID;
$nonceStr = time();

function dbCancelOrder()
{
	global $pdo, $mchId, $nonceStr, $pno, $remark;

	$sql =  "INSERT INTO ordersCancel (mchId, nonceStr, pno, created_date)" .
                " VALUES (?,?,?,?)";
	$stmt = $pdo->prepare($sql);
	$res = $stmt->execute([
			$mchId,
			$nonceStr,
			$pno,
			date('Y-m-d H:i:s')
			]);
	$ordersCancelId = $pdo->lastInsertId();

	$sql =  "INSERT INTO ordersCancelResponse (ordersCancelId, remark, created_date)" .
                " VALUES (?,?,?)";
	$stmt = $pdo->prepare($sql);
	$res = $stmt->execute([
			$ordersCancelId,
			$remark,
			date('Y-m-d H:i:s')
			]);
}

function cancelOrder()
{
	global $pdo, $mchId, $nonceStr, $pno;

	$parcelNo = trim($pno);
	$paramArr = array(
		"mchId" => $mchId,
		"nonceStr" => $nonceStr,
	);
	$post_str = buildRequestParam($paramArr);
	$url = str_replace("{pno}", $parcelNo, cancelOrder);
	return $responseStr = postRequest($url, $post_str);
//	return json_decode($responseStr, true);
}

$remark = cancelOrder();
dbCancelOrder();

echo <<<EOT
<html>
<body>
Result: $remark
<a href="show-tracking.php">Back</a>
</body>
</html>

EOT;
?>
