<?php
	$root="../..";
	$folder="/manager";
	include_once $root.$folder."/head.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="MANAGER API(apiCode) ERROR";

	//GET
	if($_GET["apiCode"])
	{
		switch($_GET["apiCode"])
		{
			case "ordersdaily": //주문보고서-일자별
				include_once $root.$folder."/dashboard/ordersdaily.php";
				break;
			case "ordersweekly": //주문보고서-요일별 
				include_once $root.$folder."/dashboard/ordersweekly.php";
				break;
			case "ordersweekday": //주문보고서-주간별 
				include_once $root.$folder."/dashboard/ordersweekday.php";
				break;
			case "makingsdaily": //조제보고서-일자별
				include_once $root.$folder."/dashboard/makingsdaily.php";
				break;
			case "makingsweekly": //조제보고서-요일별 
				include_once $root.$folder."/dashboard/makingsweekly.php";
				break;
			case "makingsweekday": //조제보고서-주간별  
				include_once $root.$folder."/dashboard/makingsweekday.php";
				break;
			case "recipesdaily": //처방보고서-일자별
				include_once $root.$folder."/dashboard/recipesdaily.php";
				break;
			case "recipesweekly": //처방보고서-요일별 
				include_once $root.$folder."/dashboard/recipesweekly.php";
				break;
			case "recipesweekday": //처방보고서-주간별 
				include_once $root.$folder."/dashboard/recipesweekday.php";
				break;
			case "medicines": //약재보고서
				include_once $root.$folder."/dashboard/medicines.php";
				break;
			case "makingmedizero": //조제보고서-조제약재수량이 적을 경우 
				include_once $root.$folder."/dashboard/makingmedizero.php";
				break;
			case "onemedicine":
				include_once $root.$folder."/dashboard/onemedicine.php";
				break;
				
			default:
		}
	}
	//POST
	if($_POST["apiCode"])
	{
		//switch($_POST["apiCode"])
		//{
		//	case "orderupdate":
		//		include_once $root.$folder."/order/orderupdate.php";
		//		break;
		//}
	}
	include_once $root.$folder."/tail.php";
?>
