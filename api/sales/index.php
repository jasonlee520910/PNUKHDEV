<?php
	$adm="../..";
	include_once $adm."/_api/apihead.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="API코드오류".$_GET["apiCode"];
	//GET
	switch($_GET["apiCode"]){
		case "setpricedesc":
			include_once $adm."/_api/sales/setpricedesc.php";
			break;
		case "setpriceprev":
			include_once $adm."/_api/sales/setpriceprev.php";
			break;
		case "estimatelist":
			include_once $adm."/_api/sales/estimatelist.php";
			break;
		case "estimatedesc":
			include_once $adm."/_api/sales/estimatedesc.php";
			break;
		case "estimatedelete":
			include_once $adm."/_api/sales/estimatedelete.php";
			break;
		case "estimatebasic":
			include_once $adm."/_api/sales/estimatebasic.php";
			break;
		case "estimateconfirm":
			include_once $adm."/_api/sales/estimateconfirm.php";
			break;
		case "estimateprint":
			include_once $adm."/_api/sales/estimateprint.php";
			break;

			
		case "categorylist":
			include_once $adm."/_api/sales/categorylist.php";
			break;
		case "categorydesc":
			include_once $adm."/_api/sales/categorydesc.php";
			break;
		case "categorydelete":
			include_once $adm."/_api/sales/categorydelete.php";
			break;
		default:
	}
	//POST
	$resjson = json_decode(file_get_contents('php://input'),true);
	switch($resjson["apiCode"]){
		case "setpriceupdate":
			include_once $adm."/_api/sales/setpriceupdate.php";
			break;
		case "estimateupdate":
			include_once $adm."/_api/sales/estimateupdate.php";
			break;
		case "categoryupdate":
			include_once $adm."/_api/sales/categoryupdate.php";
			break;
	}
	include_once $adm."/_api/apitail.php";
?>
