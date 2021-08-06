<?php
	$root="../..";
	$folder="/tbms";
	if($_GET["apiCode"]=="orderreport" && $_GET["report"]=="Y" || $_GET["apiCode"]=="orderreportpwd")
	{
		include_once $root.$folder."/settinghead.php";
	}
	else
	{
		include_once $root.$folder."/head.php";
	}

	$json["resultCode"]="404";
	$json["resultMessage"]="TBMS API(apiCode) ERROR".$_GET["apiCode"];

	//GET
	if($_GET["apiCode"])
	{
		switch($_GET["apiCode"])
		{
			case "releaselist":
				include_once $root.$folder."/release/releaselist.php";
				break;
			case "releasemain":
				include_once $root.$folder."/release/releasemain.php";
				break;
			case "orderlist":
				include_once $root.$folder."/release/orderlist.php"; 
				break;
			case "checkprocess":
				include_once $root.$folder."/release/checkprocess.php"; 
				break;
			case "changeprocess":
				include_once $root.$folder."/release/changeprocess.php"; 
				break;
			case "releaserec":
				include_once $root.$folder."/release/releaserec.php"; 
				break;
			case "orderreport":
				include_once $root.$folder."/release/orderreport.php"; 
				break;
			case "medicinetitle":  //조제정보 추가
				include_once $root.$folder."/release/medicinetitle.php"; 
				break;
			case "releasephotolist":
				include_once $root.$folder."/release/releasephotolist.php"; 
				break;
			case "releasephotodelete":
				include_once $root.$folder."/release/releasephotodelete.php"; 
				break;
			case "orderadvice":  //복약지도서
				include_once $root.$folder."/release/orderadvice.php"; 
				break;
			case "releasedelicntupdate";
				include_once $root.$folder."/release/releasedelicntupdate.php"; 
				break;
			case "releaselabel";
				include_once $root.$folder."/release/releaselabel.php"; 
				break;
			case "orderreportpwd";
				include_once $root.$folder."/release/orderreportpwd.php"; 
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
				include_once $root.$folder."/release/staffupdate.php";
				break;
			case "releasedone":
				include_once $root.$folder."/release/releasedone.php";
				break;
			case "releasephoto":
				include_once $root.$folder."/release/releasephoto.php"; 
				break;
		}
	}
	include_once $root.$folder."/tail.php";
?>
