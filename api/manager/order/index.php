<?php
	$root="../..";
	$folder="/manager";
	include_once $root.$folder."/head.php";
	
	$json["resultCode"]="404";
	$json["resultMessage"]="MANAGER API(apiCode) ERROR222".$_GET["apiCode"];

	//GET
	if($_GET["apiCode"])
	{
		switch($_GET["apiCode"])
		{
			case "orderlist":/// 주문현황>주문리스트
				include_once $root.$folder."/order/orderlist.php";
				break;
			case "orderdesc":
				include_once $root.$folder."/order/orderdesc.php";
				break;
			case "orderdecoction":
				include_once $root.$folder."/order/orderdecoction.php";
				break;
			case "orderpill":
				include_once $root.$folder."/order/orderpill.php";
				break;
			case "ordersummary":
				include_once $root.$folder."/order/ordersummary.php";
				break;			
			case "orderprint":
				include_once $root.$folder."/order/orderprint.php";
				break;
			case "orderprintpill":
				include_once $root.$folder."/order/orderprintpill.php";
				break;
			case "orderchange":
				include_once $root.$folder."/order/orderchange.php";
				break;
			case "orderreport":
				include_once $root.$folder."/order/orderreport.php";
				break;
			case "orderdelete":
				include_once $root.$folder."/order/orderdelete.php";
				break;
			case "dashboard":
				include_once $root.$folder."/order/dashboard.php";
				break;
			case "orderconfirm":
				include_once $root.$folder."/order/orderconfirm.php";
				break;			
			case "ordercanceltype":
				include_once $root.$folder."/order/ordercanceltype.php";
				break;
			case "medicinereupdate"://약재갱신 
				include_once $root.$folder."/order/medicinereupdate.php";
				break;
			case "postupdate":
				include_once $root.$folder."/order/postupdate.php";
				break;
			case "deliverylist": // 배송리스트
				include_once $root.$folder."/order/deliverylist.php";
				break;
			case "deliverytied": // 묶음배송리스트
				include_once $root.$folder."/order/deliverytied.php";
				break;
			//case "addressupdate":
			//	include_once $root.$folder."/order/addressupdate.php";
			//	break;
			case "setdeliexception":
				include_once $root.$folder."/order/setdeliexception.php";
				break;
			case "setordergoods":
				include_once $root.$folder."/order/setordergoods.php";
				break;
			case "ordergoodsprint":
				include_once $root.$folder."/order/ordergoodsprint.php";
				break;
			case "ordersubjectupdate":
				include_once $root.$folder."/order/ordersubjectupdate.php";
				break;
			case "ordermarkingupdate":
				include_once $root.$folder."/order/ordermarkingupdate.php";
				break;
			case "ordergoodsdecocupdate":
				include_once $root.$folder."/order/ordergoodsdecocupdate.php";
				break;
			case "ordergoodscommercialupdate":
				include_once $root.$folder."/order/ordergoodscommercialupdate.php";
				break;
			case "deliverydirectupdate":
				include_once $root.$folder."/order/deliverydirectupdate.php";
				break;
			//case "deliverychangeupdate":
			//	include_once $root.$folder."/order/deliverychangeupdate.php";
			//	break;
			case "ordermediboxinfoupdate":
				include_once $root.$folder."/order/ordermediboxinfoupdate.php";
				break;
			default:
		}
	}
	//POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"])
		{
			case "orderupdate":
				include_once $root.$folder."/order/orderupdate.php";
				break;
			case "orderchangeupdate":
				include_once $root.$folder."/order/orderchangeupdate.php";
				break;
			case "ordersummaryupdate":
				include_once $root.$folder."/order/ordersummaryupdate.php";
				break;
		}
	}
	include_once $root.$folder."/tail.php";
?>
