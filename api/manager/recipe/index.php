<?php
	$root="../..";
	$folder="/manager";
	include_once $root.$folder."/head.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="MANAGER API(apiCode) ERROR";

	//GET
	if($_GET["apiCode"])
	{
		switch($_GET["apiCode"]){
			case "forsclist":
				include_once $root.$folder."/recipe/forsclist.php";
				break;
			case "forscdesc":
				include_once $root.$folder."/recipe/forscdesc.php";
				break;
			case "forscdelete":
				include_once $root.$folder."/recipe/forscdelete.php";
				break;
			case "generalsclist": //처방관리>처방관리 리스트
				include_once $root.$folder."/recipe/generalsclist.php";
				break;
			case "generalscdesc": //처방관리>처방관리 상세
				include_once $root.$folder."/recipe/generalscdesc.php";
				break;
			case "generalscdelete":
				include_once $root.$folder."/recipe/generalscdelete.php";
				break;
			case "uniquesclist"://추천처방(TMPS)&처방관리>고유처방(TBMS)
				include_once $root.$folder."/recipe/uniquesclist.php";
				break;
			case "uniquescdesc"://추천처방
				include_once $root.$folder."/recipe/uniquescdesc.php";
				break;
			case "uniquescdelete":
				include_once $root.$folder."/recipe/uniquescdelete.php";
				break;
			case "uniquescconfirm":
				include_once $root.$folder."/recipe/uniquescconfirm.php";
				break;
			case "resourcelist":
				include_once $root.$folder."/recipe/resourcelist.php";
				break;
			case "resourcedesc":
				include_once $root.$folder."/recipe/resourcedesc.php";
				break;
			case "resourcedelete":
				include_once $root.$folder."/recipe/resourcedelete.php";
				break;
			case "resourcedelete":
				include_once $root.$folder."/recipe/resourcedelete.php";
				break;
			case "mediuniqsclist": //고유처방(TMPS)
				include_once $root.$folder."/recipe/mediuniqsclist.php";
				break;
			case "mediuniqscdesc"://고유처방
				include_once $root.$folder."/recipe/mediuniqscdesc.php";
				break;
			case "medicalsclist"://이전처방
				include_once $root.$folder."/recipe/medicalsclist.php";
				break;
			case "medicalscdesc"://이전처방
				include_once $root.$folder."/recipe/medicalscdesc.php";
				break;
			case "resourcebooklist"://처방관리>처방서적 리스트 
				include_once $root.$folder."/recipe/resourcebooklist.php";
				break;
			case "resourcebookdesc"://처방관리>처방서적 상세
				include_once $root.$folder."/recipe/resourcebookdesc.php";
				break;
			case "resourcebookdelete":
				include_once $root.$folder."/recipe/resourcebookdelete.php";
				break;
			case "smulist":  //상시처방
				include_once $root.$folder."/recipe/smulist.php";
				break;	
			case "worthylist":  //실속처방
				include_once $root.$folder."/recipe/worthylist.php";
				break;		
			case "worthydesc"://실속처방
				include_once $root.$folder."/recipe/worthydesc.php";
				break;
			case "worthydelete":  //실속처방
				include_once $root.$folder."/recipe/worthydelete.php";
				break;
			case "commerciallist":  //상용처방
				include_once $root.$folder."/recipe/commerciallist.php";
				break;				
			case "commercialdesc":   //상용처방
				include_once $root.$folder."/recipe/commercialdesc.php";
				break;				
			case "commercialdelete":   //상용처방
				include_once $root.$folder."/recipe/commercialdelete.php";
				break;		
			case "recipegoodslist":  //약속처방
				include_once $root.$folder."/recipe/recipegoodslist.php";
				break;	
			case "recipegoodsdesc":  //약속처방
				include_once $root.$folder."/recipe/recipegoodsdesc.php";
				break;	
			case "recipegoodsdelete":  //약속처방
				include_once $root.$folder."/recipe/recipegoodsdelete.php";
				break;		
			case "recipemedicallist":  //작업지시서 출력 > 약속처방 탕전 리스트 
				include_once $root.$folder."/recipe/recipemedicallist.php";
				break;		
			case "nonerecipemedical":
				include_once $root.$folder."/recipe/nonerecipemedical.php";
				break;
			case "nonecommercial":
				include_once $root.$folder."/recipe/nonecommercial.php";
				break;
			case "noneworthy":
				include_once $root.$folder."/recipe/noneworthy.php";
				break;
			case "recipegoodscypkdelete":
				include_once $root.$folder."/recipe/recipegoodscypkdelete.php";
				break;
			case "recipepilllist":
				include_once $root.$folder."/recipe/recipepilllist.php";
				break;
			case "recommendlist"://처방관리>추천처방--> recipemedical
				include_once $root.$folder."/recipe/recommendlist.php";
				break;
			case "recommenddesc"://처방관리>추천처방>추천처방상세 
				include_once $root.$folder."/recipe/recommenddesc.php";
				break;
			case "recommenddelete"://처방관리>추천처방>추천처방삭제 
				include_once $root.$folder."/recipe/recommenddelete.php";
				break;
			case "myrecipelist"://처방관리>나의처방--> recipemedical
				include_once $root.$folder."/recipe/myrecipelist.php";
				break;
			case "myrecipedesc"://처방관리>나의처방>나의처방상세 
				include_once $root.$folder."/recipe/myrecipedesc.php";
				break;
				
		}
	}
	//POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"]){
			case "forscupdate":
				include_once $root.$folder."/recipe/forscupdate.php";
				break;
			case "generalscupdate":
				include_once $root.$folder."/recipe/generalscupdate.php";
				break;
			case "uniquescupdate":
				include_once $root.$folder."/recipe/uniquescupdate.php";
				break;
			case "resourceupdate":
				include_once $root.$folder."/recipe/resourceupdate.php";
				break;
			case "mediuniqscupdate":
				include_once $root.$folder."/recipe/mediuniqscupdate.php";
				break;
			case "resourcebookupdate":
				include_once $root.$folder."/recipe/resourcebookupdate.php";
				break;
			case "worthyupdate": //실속처방
				include_once $root.$folder."/recipe/worthyupdate.php";
				break;
			case "commercialupdate": //상용처방
				include_once $root.$folder."/recipe/commercialupdate.php";
				break;				
			case "recipegoodsupdate": //약속처방
				include_once $root.$folder."/recipe/recipegoodsupdate.php";
				break;
			case "recommendupdate": //처방관리>추천처방>추천처방등록 
				include_once $root.$folder."/recipe/recommendupdate.php";
				break;

				
		}
	}
	include_once $root.$folder."/tail.php";
?>
