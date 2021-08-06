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
			case "getstaff": //getstaff
				include_once $root.$folder."/common/getstaff.php"; 
				break;
			default:
		}
	}
	//POST
	if($_POST["apiCode"])
	{

	}

	include_once $root.$folder."/tail.php";
?>
