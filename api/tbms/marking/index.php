<?php
	$root="../..";
	$folder="/tbms";
	if($_GET["apiCode"]=="deliverycancel")
	{
		include_once $root.$folder."/settinghead.php";
	}
	else
	{
		include_once $root.$folder."/head.php";
	}

	$json["resultCode"]="404";
	$json["resultMessage"]="TBMS API(apiCode) ERROR ".$_GET["apiCode"];

	//GET
	if($_GET["apiCode"])
	{
		switch($_GET["apiCode"])
		{
			case "markinglist":
				include_once $root.$folder."/marking/markinglist.php";
				break;
			case "markingmain":
				include_once $root.$folder."/marking/markingmain.php";
				break;
			case "orderlist":
				include_once $root.$folder."/marking/orderlist.php";
				break;
			case "checkprocess":
				include_once $root.$folder."/marking/checkprocess.php"; 
				break;
			case "changeprocess":
				include_once $root.$folder."/marking/changeprocess.php"; 
				break;
			case "markingdelivery"://로젠
				include_once $root.$folder."/marking/markingdelivery.php"; 
				break;
			case "markingdeliverypost"://우체국 
				include_once $root.$folder."/marking/markingdeliverypost.php"; 
				break;
			case "markingdeliveryex":
				include_once $root.$folder."/marking/markingdeliveryex.php"; 
				break;
			case "deliverycancel":
				include_once $root.$folder."/marking/deliverycancel.php"; 
				break;
			case "markingdeliverycnt":
				include_once $root.$folder."/marking/markingdeliverycnt.php"; 
				break;
			//case "logenslipnoupdate"://20191105 : 송장채번 
			//	include_once $root.$folder."/marking/logenslipnoupdate.php"; 
			//	break;
			//case "logenareaupdate"://20191108:로젠집배마스터 
			//	include_once $root.$folder."/marking/logenareaupdate.php"; 
			//	break;
			default:
		}
	}
	//POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"])
		{
			case "staffupdate":
				include_once $root.$folder."/marking/staffupdate.php";
				break;
			case "markingprocessing":
				include_once $root.$folder."/marking/markingprocessing.php";
				break;
			case "markingdone":
				include_once $root.$folder."/marking/markingdone.php";
				break;
			case "markingstartupdate":
				include_once $root.$folder."/marking/markingstartupdate.php";
				break;
			case "markingcountupdate":
				include_once $root.$folder."/marking/markingcountupdate.php";
				break;
			case "markingfinishupdate":
				include_once $root.$folder."/marking/markingfinishupdate.php";
				break;
		}
	}
	include_once $root.$folder."/tail.php";
?>
