<?php

$env = "training";
// $env = "production";

if ($env == "production") {

	ini_set('display_errors', 0);

	$mchid = "";
	$key = "";
	$api_svr = "https://open-api.flashexpress.com";

	$dbhost = "localhost";
	$dbuser = "p33686118";
	$dbpass = "p33686118";
	$dbname = "p33686118";
	$dsn = "mysql:host=$dbhost;dbname=$dbname";

} elseif ($env == "training") {

	ini_set('display_errors', 1);

	$mchid = "";
	$key = "";
	$api_svr = "https://open-api-tra.flashexpress.com";

	$dbhost = "localhost";
	$dbuser = "p33686118";
	$dbpass = "p33686118";
	$dbname = "p33686118";
	$dsn = "mysql:host=$dbhost;dbname=$dbname";
}

?>
