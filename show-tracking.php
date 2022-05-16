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

  <script src=https://code.jquery.com/jquery-3.5.1.js></script>
  <script src=https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js></script>
  <script src=https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js></script>

  <script>
		$(document).ready(function() {
			$('#example').DataTable();
		} );
  </script>

</head>
<body>

<div class="container mt-3 shadow-lg">
<div class="row">
<div class="py-2">
<h2>รายการพัสดุ (BETA) <button type="button" class="btn btn-danger">NEW</button></h2>
</div>
<div>
  <div class="row py-2">
	<!--
    <div class="dropdown col-2">
      <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
	    <i class="bi bi-printer"></i>
        พิมพ์ใบปะหน้า
      </button>
      <ul class="dropdown-menu">
        <li><a href="#" class="dropdown-item">ขนาดใหญ่</a></li>
        <li><a href="#" class="dropdown-item">ขนาดปกติ</a></li>
      </ul>
    </div>
	-->
    <div class="col-10">
			<a href="notify.php" role="button" type="button" class="btn btn-primary">
				<i class="bi bi-telephone-outbound"></i>
        		เรียกรถเข้ารับ(คูเรียร์)
			</a>
    </div>

    <div class="col-2">
      <a href="create-order.php" role="button" type="button" class="btn btn-primary">
	    <i class="bi bi-plus-lg"></i>
        สร้างรายการ
      </a>
    </div>
  </div>
</div>

<div class="container shadow-lg">

<table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>พัสดุ</th>
                <th>สถานะ</th>
                <th>ผู้รับ</th>
                <th>เบอร์โทรฯ</th>
                <th>ที่อยู่</th>
                <th>พิมพ์</th>
                <th>COD</th>
            </tr>
        </thead>
        <tbody>
<?php

include "./flashenv.php";

try {
    $pdo = new PDO($dsn, $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$sql = "SELECT * FROM tracking";
$stmt = $pdo->query($sql);

while ($row = $stmt->fetch())
{
	$pno = $row['pno'];
	$state = $row['state'];
	$lastupdate = $row['lastupdate'];
	$dstName = $row['dstName'];
	$dstPhone = $row['dstPhone'];
	$dstAddress = $row['dstAddress'];
	$cod = $row['codEnabled']?$row['codAmount'] / 100:0;

	echo "<tr>\n";
    echo "<td><a href='show-order.php?pno=$pno'>" . $pno . "</a></td>\n";
    echo "<td>$state / $lastupdate</td>\n";
    echo "<td>$dstName</td>\n";
    echo "<td>$dstPhone</td>\n";
    echo "<td>$dstAddress</td>\n";
    echo "<td><a href='preprint.php?pno=$pno' class='button btn btn-primary' role='button'>พิมพ์</a></td>\n";
    echo "<td>$cod</td>\n";
	echo "</tr>\n";
}
?>
        </tbody>
        <tfoot>
            <tr>
                <th>พัสดุ</th>
                <th>สถานะ</th>
                <th>ผู้รับ</th>
                <th>เบอร์โทรฯ</th>
                <th>ที่อยู่</th>
                <th>พิมพ์</th>
                <th>COD</th>
            </tr>
        </tfoot>
    </table>

</div>

</body>
</html>
