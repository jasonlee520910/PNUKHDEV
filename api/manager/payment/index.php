<?php
	$root="../..";
	$folder="/manager";
	include_once $root.$folder."/head.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="MANAGER API(apiCode) ERROR";

	//GET
	if($_GET["apiCode"])
	{
		switch($_GET["apiCode"])
		{
			case "paymentdesc":
				include_once $root.$folder."/payment/paymentdesc.php";
				break;
			default:
		}
	}
	//POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"])
		{
			case "paymentupdate":
				include_once $root.$folder."/payment/paymentupdate.php";
				break;
		}
	}
	include_once $root.$folder."/tail.php";
?>
