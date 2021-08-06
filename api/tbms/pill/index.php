<?php
	$root="../..";
	$folder="/tbms";
	include_once $root.$folder."/head.php";
	include_once $root.$folder."/_common/lib/_lib.pill.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="TBMS API(apiCode) ERROR".$_GET["apiCode"];


	//GET
	if($_GET["apiCode"])
	{
		switch($_GET["apiCode"])
		{
			case "orderlist":
				include_once $root.$folder."/pill/orderlist.php"; 
				break;
			case "pilllist":
				include_once $root.$folder."/pill/pilllist.php"; 
				break;
			case "pillmain":
				include_once $root.$folder."/pill/pillmain.php"; 
				break;
			case "checkprocess":
				include_once $root.$folder."/pill/checkprocess.php"; 
				break;
			case "changeprocess":
				include_once $root.$folder."/pill/changeprocess.php"; 
				break;
			default:
		}
	}
	//POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"])
		{
			case "pilldone":
				include_once $root.$folder."/pill/pilldone.php";
				break;
			case "staffupdate":
				include_once $root.$folder."/pill/staffupdate.php";
				break;
			case "pillprocessing":
				include_once $root.$folder."/pill/pillprocessing.php"; 
				break;
			case "pilldone":
				include_once $root.$folder."/pill/pilldone.php"; 
				break;
				
		}
	}

	include_once $root.$folder."/tail.php";

?>
