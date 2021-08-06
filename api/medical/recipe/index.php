<?php
	$root="../..";
	$folder="/medical"; ///TMPS
	include_once $root.$folder."/head.php";
	
	$json["resultCode"]="404";
	$json["resultMessage"]="MEDICAL API(apiCode) ERROR.";

	///GET, DELETE
	if($_GET["apiCode"]){
		switch($_GET["apiCode"]){
			case "medicalsclist":///이전처방
				include_once $root.$folder."/recipe/medicalsclist.php";
				break;
			case "medicalscdesc":///이전처방 상세
				include_once $root.$folder."/recipe/medicalscdesc.php";
				break;
			case "mediuniqsclist":///고유처방
				include_once $root.$folder."/recipe/mediuniqsclist.php";
				break;
			case "mediuniqscdesc":///고유처방 상세
				include_once $root.$folder."/recipe/mediuniqscdesc.php";
				break;
			case "uniquesclist":///추천처방리스트
				include_once $root.$folder."/recipe/uniquesclist.php";
				break;
			case "uniquescdesc":///추천처방 상세
				include_once $root.$folder."/recipe/uniquescdesc.php";
				break;
			case "resourcelist":///방제사전
				include_once $root.$folder."/recipe/resourcelist.php";
				break;
			case "resourcedesc":  ///방제사전 상세
				include_once $root.$folder."/recipe/resourcedesc.php";
				break;
			case "recipedesc": ///진료 > 추천처방 상세, 진료 > 고유처방 상세 
				include_once $root.$folder."/recipe/recipedesc.php";
				break;
			case "mediuniboxlist":
				include_once $root.$folder."/recipe/mediuniboxlist.php";
				break;
			case "uniquescboxlist":
				include_once $root.$folder."/recipe/uniquescboxlist.php";
				break;
			case "myrecipelist"://나의처방
				include_once $root.$folder."/recipe/myrecipelist.php";
				break;
			case "recommendlist"://추천처방
				include_once $root.$folder."/recipe/recommendlist.php";
				break;
			case "medicalrecipelist":
				include_once $root.$folder."/recipe/medicalrecipelist.php";
				break;

		}
	}
	///POST
	if($_POST["apiCode"]){
		switch($_POST["apiCode"]){
			case "mediuniqscupdate":///고유처방 입력
				include_once $root.$folder."/recipe/mediuniqscupdate.php";
				break;
			case "addprescriptionupdate":  ///이전처방에 있는 내용을 나의처방으로 등록하기 
				include_once $root.$folder."/recipe/addprescriptionupdate.php";
				break;
			case "myrecipeupdate"://나의처방등록
				include_once $root.$folder."/recipe/myrecipeupdate.php";
				break;
			case "myrecipedelete"://나의처방삭제 
				include_once $root.$folder."/recipe/myrecipedelete.php";
				break;
				
			default:	
		}
	}

	include_once $root.$folder."/tail.php";
?>
