<!DOCTYPE html>
<html lang="en">
<head>
  <title>Project 33686118</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.2/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
         integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
         crossorigin="anonymous">
  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

</head>
<body>
<main>

<?php

include "./flashenv.php";

if (!isset($_POST['pno']) and !isset($_GET['pno'])) {
	echo "ERR: need tracking number\n";
	echo "</main>\n</body>\n</html>\n";
	return;
}

$pno = isset($_POST['pno'])?$_POST['pno']:$_GET['pno'];

try {
    $pdo = new PDO($dsn, $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$sql = "SELECT * FROM ordersResponse where pno = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$pno]);
$row = $stmt->fetch();

if (!isset($row['id'])) {
	echo "ERR: Can't get order id for tracking number $pno\n";
	echo "</main>\n</body>\n</html>\n";
	return;
}

$ordersId = $row['ordersId'];

$sql = "SELECT * FROM orders where id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$ordersId]);
$row = $stmt->fetch();

if (!isset($row['id'])) {
	echo "ERR: Can't get order information for tracking number $pno\n";
	echo "</main>\n</body>\n</html>\n";
	return;
}

$srcName			= $row['srcName'];
$srcPhone			= $row['srcPhone'];
$srcDetailAddress	= $row['srcDetailAddress'];
$srcDistrictName	= $row['srcDistrictName'];
$srcCityName		= $row['srcCityName'];
$srcProvinceName	= $row['srcProvinceName'];
$srcPostalCode		= $row['srcPostalCode'];

$dstName			= $row['dstName'];
$dstPhone			= $row['dstPhone'];
$dstDetailAddress	= $row['dstDetailAddress'];
$dstDistrictName	= $row['dstDistrictName'];
$dstCityName		= $row['dstCityName'];
$dstProvinceName	= $row['dstProvinceName'];
$dstPostalCode		= $row['dstPostalCode'];

$expressCategory	= $row['expressCategory'];
$articleCategory	= $row['articleCategory'];

$weight				= $row['weight'];
$length				= $row['length']?$row['length']:0;
$height				= $row['height']?$row['height']:0;

$codEnabled			= $row['codEnabled'];
$codAmount			= $row['codAmount'];

$remark				= $row['remark'];
$created_date		= $row['created_date'];

?>

<div class="container mt-3 shadow-lg">
<div class="row">
<div class="py-4">
<h1>พัสดุ <?php echo "$pno"; ?></h1>
</div>

<div class="container shadow-lg py-4">
	<div class="py-2">
		<h2>ผู้ส่ง</h2>
		<?php
			echo "$srcName<br>\n";
			echo "$srcPhone<br>\n";
			echo "$srcDetailAddress $srcDistrictName $srcCityName $srcProvinceName $srcPostalCode<br>\n";
		?>
	</div>

	<div class="py-2">
		<h2>ผู้รับ</h2>
		<?php
			echo "$dstName<br>\n";
			echo "$dstPhone<br>\n";
			echo "$dstDetailAddress $srcDistrictName $srcCityName $srcProvinceName $srcPostalCode<br>\n";
		?>
	</div>

	<div class="py-2">
		<h2>พัสดุ</h2>
		<?php
			echo "น้ำหนัก: " . ($weight / 100) . " กก.<br>\n";
			echo "ขนาด : $height x $length<br>\n";
			if ($codEnabled) {
				echo "เก็บเงินปลายทาง : " . ($codAmount / 100) . " บาท<br>\n";
			} else {
				echo "ไม่เก็บเงินปลายทาง<br>\n";
			}
			echo "รับพัสดุเมื่อ : $created_date<br>\n";
		?>
	</div>
</div>

<div class="container shadow-lg py-4">
	<div class="row">
		<div class="col-10">
			<a href="show-tracking.php" role="button" type="button" class="btn btn-secondary btn-lg">
				<i class="bi bi-caret-up"></i>
				กลับ
			</a>
			<a href="preprint.php?pno=<?php echo $pno ?>" role="button" type="button" class="btn btn-primary btn-lg">
				<i class="bi bi-printer"></i>
				พิมพ์ใหญ่
			</a>
			<a href="preprint-small.php?pno=<?php echo $pno ?>" role="button" type="button" class="btn btn-primary btn-lg">
				<i class="bi bi-printer"></i>
				พิมพ์เล็ก
			</a>
			<a href="show-routes.php?pno=<?php echo $pno ?>" role="button" type="button" class="btn btn-primary btn-lg">
				<i class="bi bi-question-square"></i>
				ตรวจสอบสถานะ
			</a>
		</div>
		<div class="col-2 align-self-end">
			<button id="cancelorder" class="btn btn-danger btn-lg">
			<i class="bi bi-trash"></i>
			ยกเลิก พัสดุ
			</button>
		</div>
	</div>
</div>

<div>
<p id="demo"></p>
</div>
</main>

<script>
$("#cancelorder").on('click', function() {
  let text = "ยกเลิกพัสดุ <?php echo $pno?>?\nกด OK ถ้าต้องการยกเลิก.";
  if (confirm(text) == true) {
		window.location.href = "cancel-order.php?pno=<?php echo $pno?>";
  }
});
</script>
</body>
</html>
