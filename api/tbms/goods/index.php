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
			case "goodslist":
				include_once $root.$folder."/goods/goodslist.php";
				break;
			case "goodsmain":
				include_once $root.$folder."/goods/goodsmain.php";
				break;
			case "orderlist":
				include_once $root.$folder."/goods/orderlist.php"; 
				break;
			case "checkprocess":
				include_once $root.$folder."/goods/checkprocess.php"; 
				break;
			case "changeprocess":
				include_once $root.$folder."/goods/changeprocess.php"; 
				break;
			case "orderreport":
				include_once $root.$folder."/goods/orderreport.php"; 
				break;
			case "goodsphotolist":
				include_once $root.$folder."/goods/goodsphotolist.php"; 
				break;
			case "goodsphotodelete":
				include_once $root.$folder."/goods/goodsphotodelete.php"; 
				break;
			case "goodsshipping":
				include_once $root.$folder."/goods/goodsshipping.php"; 
				break;
			case "goodsshippingupdate":
				include_once $root.$folder."/goods/goodsshippingupdate.php"; 
				break;
			default:
				
		}
	}
	//POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"])
		{
			case "staffupdate":
				include_once $root.$folder."/goods/staffupdate.php";
				break;
			case "goodsdone":
				include_once $root.$folder."/goods/goodsdone.php";
				break;
			case "goodsphoto":
				include_once $root.$folder."/goods/goodsphoto.php"; 
				break;
		}
	}
	include_once $root.$folder."/tail.php";
?>
