<?php
	$root="../..";
	$folder="/tbms";
	include_once $root.$folder."/head.php";
	include_once $root.$folder."/_common/lib/_lib.making.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="TBMS API(apiCode) ERROR".$_GET["apiCode"];


	//GET
	if($_GET["apiCode"])
	{
		switch($_GET["apiCode"])
		{
			case "orderlist":
				include_once $root.$folder."/making/orderlist.php"; 
				break;
			case "makinglist":
				include_once $root.$folder."/making/makinglist.php"; 
				break;
			case "makingmain":
				include_once $root.$folder."/making/makingmain.php"; 
				break;
			case "checkprocess":
				include_once $root.$folder."/making/checkprocess.php"; 
				break;
			case "checkmedipocket":
				include_once $root.$folder."/making/checkmedipocket.php"; 
				break;
			case "changeprocess":
				include_once $root.$folder."/making/changeprocess.php"; 
				break;
			case "checkmedibox":
				include_once $root.$folder."/making/checkmedibox.php"; 
				break;
			case "makingapplyupdate":
				include_once $root.$folder."/making/makingapplyupdate.php"; 
				break;
			case "makingscan":
				include_once $root.$folder."/making/makingscan.php"; 
				break;
			case "makingtablestatupdate":
				include_once $root.$folder."/making/makingtablestatupdate.php"; 
				break;
			case "makingstart":  //세명대 조제시간을 알기위해 추가함(start)
				include_once $root.$folder."/making/makingstart.php"; 
				break;
			case "makingend":  //세명대 조제시간을 알기위해 추가함(end)
				include_once $root.$folder."/making/makingend.php"; 
				break;	
			case "makingcancel":
				include_once $root.$folder."/making/makingcancel.php"; 
				break;
			case "mediboxinupdate":
				include_once $root.$folder."/making/mediboxinupdate.php"; 
				break;
			case "scalemodeupdate":
				include_once $root.$folder."/making/scalemodeupdate.php"; 
				berak;
			default:
		}
	}
	//POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"])
		{
			case "makingdone":
				include_once $root.$folder."/making/makingdone.php";
				break;
			case "mediboxinlastupdate":
				include_once $root.$folder."/making/mediboxinlastupdate.php";
				break;
			case "staffupdate":
				include_once $root.$folder."/making/staffupdate.php";
				break;
			case "matableupdate":
				include_once $root.$folder."/making/matableupdate.php";
				break;
			case "medicinecapaupdate":
				include_once $root.$folder."/making/medicinecapaupdate.php";
				break;
			case "newmedicapaupdate":
				include_once $root.$folder."/making/newmedicapaupdate.php";
				break;
			case "makingtableupdate":
				include_once $root.$folder."/making/makingtableupdate.php";
				break;
		}
	}

	include_once $root.$folder."/tail.php";

?>
