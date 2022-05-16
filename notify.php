<?php

if (!isset($_POST['pno']) and !isset($_GET['pno'])) {
	$pno = 0;
} else {
	$pno = isset($_POST['pno'])?$_POST['pno']:$_GET['pno'];
}
echo	"เรียกรถรับเข้าสำหรับ พัสดุ หมายเลข #$pno";
?>
