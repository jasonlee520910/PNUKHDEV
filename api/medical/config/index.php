<?php
	$root="../..";
	$folder="/medical"; //TMPS
	include_once $root.$folder."/head.php";
	
	$json["resultCode"]="404";
	$json["resultMessage"]="MEDICAL API(apiCode) ERROR.";

	///GET, DELETE
	if($_GET["apiCode"]){
		switch($_GET["apiCode"]){
			case "getconfig":///
				include_once $root.$folder."/config/getconfig.php";
				break;
			case "getpacking":///
				include_once $root.$folder."/config/getpacking.php";
				break;
		}
	}
	///POST
	if($_POST["apiCode"]){
		switch($_POST["apiCode"]){
			/*
			case "hubcateupdate": ///본초분류관리 등록&수정
				include_once $root.$folder."/medicine/hubcateupdate.php";
				break;
			default:
			*/		
		}
	}

	include_once $root.$folder."/tail.php";
?>
