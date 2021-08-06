<?php
	$root="../..";
	$folder="/tbms";
	include_once $root.$folder."/settinghead.php";
	$json["resultCode"]="404";
	$json["resultMessage"]="TBMS API(apiCode) ERROR";

	//GET
	switch($_GET["apiCode"])
	{
		case "textdbfront":
			include_once $root.$folder."/setting/textdbfront.php";
			break;
	}

	//POST
	if($_POST["apiCode"])
	{
		
	}
	include_once $root.$folder."/tail.php";
?>
