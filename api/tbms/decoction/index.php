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
			case "decoctionlist":
				include_once $root.$folder."/decoction/decoctionlist.php";
				break;
			case "decoctionmain":
				include_once $root.$folder."/decoction/decoctionmain.php"; 
				break;
			case "orderlist":
				include_once $root.$folder."/decoction/orderlist.php"; 
				break;
			case "checkprocess":
				include_once $root.$folder."/decoction/checkprocess.php"; 
				break;
			case "checkmedipocket":
				include_once $root.$folder."/decoction/checkmedipocket.php"; 
				break;
			case "changeprocess":
				include_once $root.$folder."/decoction/changeprocess.php"; 
				break;
			case "checkboiler"://탕전기 선택
				include_once $root.$folder."/decoction/checkboiler.php"; 
				break;
			case "checkpacking"://포장기선택
				include_once $root.$folder."/decoction/checkpacking.php"; 
				break;
				
			default:
		}
	}
	//POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"])
		{
			case "checkboilerupdate": //탕전기 선택 update
				include_once $root.$folder."/decoction/checkboilerupdate.php";
				break;
			case "checkpackingupdate": //포장기 선택 update
				include_once $root.$folder."/decoction/checkpackingupdate.php";
				break;				
			case "staffupdate":
				include_once $root.$folder."/decoction/staffupdate.php";
				break;
			case "decocprocessing":
				include_once $root.$folder."/decoction/decocprocessing.php"; 
				break;
			case "decoctiondone":
				include_once $root.$folder."/decoction/decoctiondone.php"; 
				break;
		}
	}
	include_once $root.$folder."/tail.php";
?>

