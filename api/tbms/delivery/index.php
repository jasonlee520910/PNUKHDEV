<?php
	$root="../..";
	$folder="/tbms";
	include_once $root.$folder."/head.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="TBMS API(apiCode) ERROR".$_GET["apiCode"];


	//GET
	if($_GET["apiCode"])
	{
		switch($_GET["apiCode"])
		{
			case "deliverycnt":
				include_once $root.$folder."/delivery/deliverycnt.php"; 
				break;
			case "searchdelivery":
				include_once $root.$folder."/delivery/searchdelivery.php"; 
				break;
			default:
		}
	}
	//POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"])
		{
			
		}
	}

	include_once $root.$folder."/tail.php";

?>
