<html>
<?php

ini_set('display_errors', 1);

include "./flashenv.php";
include "./flashlib.php";

// Try store src and dst info to database first.
// All of these info must be provided.

if ( 	!isset($_POST['srcName'])			or
		!isset($_POST['srcPhone'])			or
		!isset($_POST['srcDetailAddress'])	or
		!isset($_POST['srcDistrictName'])	or
		!isset($_POST['srcCityName'])		or
		!isset($_POST['srcProvinceName'])	or
		!isset($_POST['srcPostalCode'])		or
		!isset($_POST['dstName'])			or
		!isset($_POST['dstPhone'])			or
		!isset($_POST['dstDetailAddress'])	or
		!isset($_POST['dstDistrictName'])	or
		!isset($_POST['dstCityName'])		or
		!isset($_POST['dstProvinceName'])	or
		!isset($_POST['dstPostalCode']))	{
		echo "Needed information is not provided\n";
		exit(0);
}

$srcSaveAddress = isset($_POST['srcSaveAddress'])?$_POST['srcSaveAddress']:0;
$dstSaveAddress = isset($_POST['dstSaveAddress'])?$_POST['dstSaveAddress']:0;

$srcName			= $_POST['srcName'];
$srcPhone			= $_POST['srcPhone'];
$srcDetailAddress	= $_POST['srcDetailAddress'];
$srcDistrictName	= $_POST['srcDistrictName'];
$srcCityName		= $_POST['srcCityName'];
$srcProvinceName	= $_POST['srcProvinceName'];
$srcPostalCode		= $_POST['srcPostalCode'];

$dstName			= $_POST['dstName'];
$dstPhone			= $_POST['dstPhone'];
$dstDetailAddress	= $_POST['dstDetailAddress'];
$dstDistrictName	= $_POST['dstDistrictName'];
$dstCityName		= $_POST['dstCityName'];
$dstProvinceName	= $_POST['dstProvinceName'];
$dstPostalCode		= $_POST['dstPostalCode'];

$weight				= isset($_POST['weight'])?$_POST['weight']:100;	// set default to 1.0 kg

$codEnabled			= isset($_POST['codEnabled'])?$_POST['codEnabled']:0;
$codAmount			= isset($_POST['codAmount'])?$_POST['codAmount']:0;

try {
    $pdo = new PDO($dsn, $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if (! $srcSaveAddress and ! $dstSaveAddress) {
    echo "<h2>ไม่มีการบันทึกข้อมูล ทั้งผู้รับและผู้ส่ง</h2>\n";
} else {

    if ($srcSaveAddress) {
        $sql =  "INSERT INTO src (name, phone, detailAddress, districtName, cityName, provinceName, postalCode, created_date)" .
                " VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        $res = $stmt->execute([
                       $srcName,
                       $srcPhone,
                       $srcDetailAddress,
                       $srcDistrictName,
                       $srcCityName,
                       $srcProvinceName,
                       $srcPostalCode,
					   date('Y-m-d H:i:s')
                      ]);
        echo "<h2>บันทึกข้อมูลผู้ส่ง : " . ($res?"สำเร็จ":print_r($stmt->errorInfo(),true)) . "</h2>\n";
    }

    if ($dstSaveAddress) {
        $sql =  "INSERT INTO dst (name, phone, detailAddress, districtName, cityName, provinceName, postalCode, cod, created_date)" .
                " VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        $res = $stmt->execute([
                       $dstName,
                       $dstPhone,
                       $dstDetailAddress,
                       $dstDistrictName,
                       $dstCityName,
                       $dstProvinceName,
                       $dstPostalCode,
                       $codEnabled?$codAmount:0,
					   date('Y-m-d H:i:s')
                      ]);
        echo "<h2>บันทึกข้อมูลผู้รับ : " . ($res?"สำเร็จ":print_r($stmt->errorInfo(),true)) . "</h2>\n";
    }
}

/* data definition */
define("merchantID", $mchid);
define("merchantPW", $key);

define("orders", "$api_svr/open/v3/orders");

function createOrders($data_arr)
{
	$post_str = buildRequestParam($data_arr);
	$responseStr = postRequest(orders, $post_str);
	return $responseStr;
}

$nonceStr = time();
$outTradeNo = $nonceStr;

$orders_arr = array(
	"mchId"					=> merchantID,
	"nonceStr"				=> $nonceStr,
	"outTradeNo"			=> $outTradeNo,
	"srcName"				=> $srcName,
	"srcPhone"				=> $srcPhone,
	"srcProvinceName"		=> $srcProvinceName,
	"srcCityName"			=> $srcCityName,
	"srcDistrictName"		=> $srcDistrictName,
	"srcPostalCode"			=> $srcPostalCode,
	"srcDetailAddress"		=> $srcDetailAddress,
	"dstName"				=> $dstName,
	"dstPhone"				=> $dstPhone,
//	"dstHomePhone"			=> $dstPhone,
	"dstProvinceName"		=> $dstProvinceName,
	"dstCityName"			=> $dstCityName,
	"dstDistrictName"		=> $dstDistrictName,
	"dstPostalCode"			=> $dstPostalCode,
	"dstDetailAddress"		=> $dstDetailAddress,
	"articleCategory"		=> 1,
	"expressCategory"		=> 1,
	"weight"				=> $weight,
	"insured"				=> 0,
//	"insureDeclareValue"	=> 10000,
//	"freightInsureEnabled"	=> 1,
//	"opdInsureEnabled"		=> 1,
	"codEnabled"			=> $codEnabled,
	"codAmount"				=> $codEnabled?$codAmount:0,
	"remark"				=> ''
);

$sql =  "INSERT INTO orders (mchId, nonceStr, outTradeNo, " .
		"srcName, srcPhone, srcProvinceName, srcCityName, srcDistrictName, srcPostalCode, srcDetailAddress, " .
		"dstName, dstPhone, dstProvinceName, dstCityName, dstDistrictName, dstPostalCode, dstDetailAddress, " .
		"articleCategory, expressCategory, weight, insured, codEnabled, codAmount, remark, created_date) " .
		"VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
	merchantID,
	$nonceStr,
	$outTradeNo,
	$srcName,
	$srcPhone,
	$srcProvinceName,
	$srcCityName,
	$srcDistrictName,
	$srcPostalCode,
	$srcDetailAddress,
	$dstName,
	$dstPhone,
	$dstProvinceName,
	$dstCityName,
	$dstDistrictName,
	$dstPostalCode,
	$dstDetailAddress,
	1,
	1,
	1000,
	0,
	$codEnabled,
	($codEnabled)?$codAmount:0,
	'',
	date('Y-m-d H:i:s')
]);

$ordersId = $pdo->lastInsertId();

$responseStr = createOrders($orders_arr); // response in json
$res = json_decode($responseStr, true);

// {"code":0,"message":"คุณยังไม่ได้กรอกข้อมูลบุคคล/บริษัทผู้รับผลประโยชน์ จึงไม่สามารถซื้อประกันได้ตอนนี้","data":null}
// {"code":1000,"message":"ตรวจสอบข้อมูลผิดพลาด","data":{"insured":["ซื้อประกันหรือไม่ ต้องระบุ"]}}
// {"code":1,"message":"success","data":{"pno":"TH47148Z139C","mchId":"AA3183","outTradeNo":"#1536749552628#","sortCode":"11N-07030-02","lineCode":null,"sortingLineCode":"P01","dstStoreName":"SHN_SP-สันทรายน้อย","earlyFlightEnabled":false,"packEnabled":false,"upcountry":false,"upcountryAmount":0,"upcountryCharge":false,"sameProvince":false,"notice":null,"srcPostalCode":"34000","dstPostalCode":"50210"}}

echo "\n<pre>$responseStr</pre><br>\n";

if ($res['code'] == 1) {	// success
	$pno				= $res['data']['pno'];
	$mchId				= $res['data']['mchId'];
	$outTradeNo 		= $res['data']['outTradeNo'];
	$sortCode 			= $res['data']['sortCode'];
	$lineCode 			= $res['data']['lineCode'];
	$sortingLineCode 	= $res['data']['sortingLineCode'];
	$dstStoreName 		= $res['data']['dstStoreName'];
	$earlyFlightEnabled = $res['data']['earlyFlightEnabled']?0:1;
	$packEnabled		= $res['data']['packEnabled']?0:1;
	$upcountry 			= $res['data']['upcountry']?0:1;
	$upcountryAmount 	= $res['data']['upcountryAmount'];
	$upcountryCharge 	= $res['data']['upcountryCharge']?0:1;
	$sameProvince 		= $res['data']['sameProvince'];
	$notice 			= $res['data']['notice'];
	$srcPostalCode 		= $res['data']['srcPostalCode'];
	$dstPostalCode 		= $res['data']['dstPostalCode'];

	$sql =  "INSERT INTO ordersResponse (ordersId, pno, mchId, outTradeNo, sortCode, dstStoreName, " .
			"sortingLineCode, earlyFlightEnabled, packEnabled, upcountryCharge, notice, created_date) " .
			"VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		$ordersId,
		$pno,
		$mchId,
		$outTradeNo,
		$sortCode,
		$dstStoreName,
		$sortingLineCode,
		$earlyFlightEnabled,
		$packEnabled,
		$upcountryCharge,
		$notice,
		date('Y-m-d H:i:s')
	]);
	$ordersResponseId = $pdo->lastInsertId();
	echo "<h2>Record OrdersResponse</h2>pno : $pno, ordersResponseId = $ordersResponseId<br>\n";

	$sql =  "INSERT INTO tracking (pno, state, dstName, dstPhone, dstAddress, codEnabled, codAmount, created_date, lastupdate) " .
			"VALUES (?,?,?,?,?,?,?,?,?)";
	$now = date('Y-m-d H:i:s');
	$state = 0;	// unknown
	$dstAddress = "$dstDetailAddress $dstDistrictName $dstCityName $dstProvinceName $dstPostalCode";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		$pno,
		$state,
		$dstName,
		$dstPhone,
		$dstAddress,
		$codEnabled,
		$codAmount,
		$now,
		$now
	]);

	$trackingId = $pdo->lastInsertId();
	echo "<h2>Record Tracking</h2>pno : $pno, trackingId = $trackingId<br>\n";

} else {
	$sql =  "INSERT INTO ordersResponse (ordersId, notice, created_date) " .
			"VALUES (?,?,?)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		$ordersId,
		$responseStr,
		date('Y-m-d H:i:s')
	]);
    echo "<h1>Record OrdersResponse failed</h1> : $responseStr<br>\n";
}

header("Location: show-tracking.php");
?>
