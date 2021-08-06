<?php
	$root="../..";
	$folder="/medical"; //TMPS
	include_once $root.$folder."/head.php";
	
	$json["resultCode"]="404";
	$json["resultMessage"]="MEDICAL API(apiCode) ERROR.";

	///GET, DELETE
	if($_GET["apiCode"]){
		switch($_GET["apiCode"]){
			case "hublist":///본초정보 리스트
				include_once $root.$folder."/medicine/hublist.php";
				break;
			case "hubdesc":///본초정보 상세 
				include_once $root.$folder."/medicine/hubdesc.php";
				break;
			case "medicinelist":///약재검색&약재목록
				include_once $root.$folder."/medicine/medicinelist.php";
				break;			
			case "medicinedesc":///약재 상세 
				include_once $root.$folder."/medicine/medicinedesc.php";
				break;			
			case "medicineboxlist": ///input 약재입력시 
				include_once $root.$folder."/medicine/medicineboxlist.php";
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
