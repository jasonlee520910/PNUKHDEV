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
			case "pharmacydesc":
				include_once $root.$folder."/pharmacy/pharmacydesc.php"; 
				break;
			case "pharmacyupdate":
				include_once $root.$folder."/pharmacy/pharmacyupdate.php"; 
				break;
			case "pharmacytagupdate":
				include_once $root.$folder."/pharmacy/pharmacytagupdate.php"; 
				break;
			case "checkstaffid":
				include_once $root.$folder."/pharmacy/checkstaffid.php"; 
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
