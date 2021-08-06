<?php 
	$root="../..";
	$folder="/manager";
	include_once $root.$folder."/head.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="MANAGER API(apiCode) ERROR.";
	
	//GET
	switch($_GET["apiCode"])
	{
		case "goodslist"://제품목록
			include_once $root.$folder."/goods/goodslist.php";
			break;
		case "goodsgoodslist"://제품목록
			include_once $root.$folder."/goods/goodsgoodslist.php";
			break;
		case "goodspoplist"://제품pop목록
			include_once $root.$folder."/goods/goodspoplist.php";
			break;
		case "goodslog"://재고입출고목록
			include_once $root.$folder."/goods/goodslog.php";
			break;
		case "goodsdesc"://제품desc
			include_once $root.$folder."/goods/goodsdesc.php";
			break;
		case "goodsdescpop"://제품desc
			include_once $root.$folder."/goods/goodsdescpop.php";
			break;
		case "goodsaddmaterial"://제품재고추가
			include_once $root.$folder."/goods/goodsaddmaterial.php";
			break;
		case "goodsdelmaterial": //제품재고에제거
			include_once $root.$folder."/goods/goodsdelmaterial.php";
			break;
		/* 0409 안쓰는것으로 파악됨.
		case "goodsdelmaterialsub": //제품재고에제거
			include_once $root.$folder."/goods/goodsdelmaterialsub.php";
			break;
		*/
		case "goodsgoodsdesc": //제품재고에제거
			include_once $root.$folder."/goods/goodsgoodsdesc.php";
			break;
		case "goodsdelete": //제품 삭제
			include_once $root.$folder."/goods/goodsdelete.php";
			break;
		/* 0409 안쓰는것으로 파악됨.
		case "goodsaddcapa": //제품 추가 용량 update
			include_once $root.$folder."/goods/goodsaddcapa.php";
			break;
		
		case "goodsoriginlist": //원재료 오른쪽 리스트 api
			include_once $root.$folder."/goods/goodsoriginlist.php";
			break;
		
		case "goodsorigindesc": //원재료 왼쪽 리스트 api
			include_once $root.$folder."/goods/goodsorigindesc.php";
			break;
		case "chkcode": //goods 제품 코드 중복체크
			include_once $root.$folder."/goods/chkcode.php";
			break;
		*/
		case "nonegoods": //원재료 왼쪽 리스트 api
			include_once $root.$folder."/goods/nonegoods.php";
			break;

		case "updateGduse": //updateGduse
			include_once $root.$folder."/goods/updateGduse.php";
			break;
		case "goodsresetcapa": //goodsresetcapa
			include_once $root.$folder."/goods/goodsresetcapa.php";
			break;
		case "goodsmedicine": //goodsmedicine
			include_once $root.$folder."/goods/goodsmedicine.php";
			break;
		case "goodsmedicinedesc": //원재료 입고 
			include_once $root.$folder."/goods/goodsmedicinedesc.php";
			break;
		case "selsuborder": //제환작업내용 
			include_once $root.$folder."/goods/selsuborder.php";
			break;
		case "goodspilllist":
			include_once $root.$folder."/goods/goodspilllist.php";
			break;
		case "goodspilldesc":
			include_once $root.$folder."/goods/goodspilldesc.php";
			break;
		case "goodsgpill":
			include_once $root.$folder."/goods/goodsgpill.php";
			break;
		case "goodssummarypill":
			include_once $root.$folder."/goods/goodssummarypill.php";
			break;
		case "goodsconfirmpill":
			include_once $root.$folder."/goods/goodsconfirmpill.php";
			break;	
	}

	//POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"])
		{
			/* 0409 안쓰는것으로 파악됨.
			case "goodsregist"://제품등록/수정
				include_once $root.$folder."/goods/goodsregist.php";
				break;
			*/
			case "goodsqtyupdate"://제품재고추가
				include_once $root.$folder."/goods/goodsqtyupdate.php";
				break;
			
			case "goodsupdate"://약속처방등록
				include_once $root.$folder."/goods/goodsupdate.php";
				break;
			case "pregoodsupdate": //리스트에서 제품추가 버튼> 반제품 등록, 로그추가
				include_once $root.$folder."/goods/pregoodsupdate.php";
				break;
			case "goodsstockupdate": // 원재료 입출고
				include_once $root.$folder."/goods/goodsstockupdate.php";
				break;

				
		}
	}

	include_once $root.$folder."/tail.php";
?>

