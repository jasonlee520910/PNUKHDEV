<?php
	$root="../..";
	$folder="/medical";
	include_once $root.$folder."/head.php";
	
	$json["resultCode"]="404";
	$json["resultMessage"]="MEDICAL API(apiCode) ERROR.".$_POST["apiCode"]."";

	///GET, DELETE
	if($_GET["apiCode"]){
		switch($_GET["apiCode"]){
			case "patientlist": ///환자관리 리스트
				include_once $root.$folder."/patient/patientlist.php";
				break;
			case "patientdesc": ///환자관리 상세
				include_once $root.$folder."/patient/patientdesc.php";
				break;
			case "patientdelete": ///환자삭제
				include_once $root.$folder."/patient/patientdelete.php";
				break;
			case "medicalrecordlist": ///이전처방기록
				include_once $root.$folder."/patient/medicalrecordlist.php";
				break;
			case "againorder": ///재처방
				include_once $root.$folder."/patient/againorder.php";
				break;


				
		}
	}
	///POST
	if($_POST["apiCode"]){
		switch($_POST["apiCode"]){		
			case "patientupdate": ///환자등록&수정
				include_once $root.$folder."/patient/patientupdate.php";
				break;
			default:
			
		}
	}

	include_once $root.$folder."/tail.php";
?>
