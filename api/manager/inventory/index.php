<?php 
	$root="../..";
	$folder="/manager";
	include_once $root.$folder."/head.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="MANAGER API(apiCode) ERROR.";
	
	//GET
	switch($_GET["apiCode"])
	{

		case "mediboxlist"://약재함관리 리스트
			include_once $root.$folder."/inventory/mediboxlist.php";
			break;
		case "mediboxdesc"://약재함관리 리스트
			include_once $root.$folder."/inventory/mediboxdesc.php";
			break;
		case "mediboxdelete"://약재함관리 리스트
			include_once $root.$folder."/inventory/mediboxdelete.php";
			break;

		case "pouchtaglist"://조제태그관리 리스트
			include_once $root.$folder."/inventory/pouchtaglist.php";
			break;	
		case "pouchtagdesc"://조제태그관리 리스트
			include_once $root.$folder."/inventory/pouchtagdesc.php";
			break;	
		case "pouchtagdelete"://조제태그관리 리스트
			include_once $root.$folder."/inventory/pouchtagdelete.php";
			break;	

		case "potlist"://탕전기관리 리스트
			include_once $root.$folder."/inventory/potlist.php";
			break;	
		case "potdelete"://탕전기관리 리스트
			include_once $root.$folder."/inventory/potdelete.php";
			break;
		case "equipmentlist"://장비관리 리스트
			include_once $root.$folder."/inventory/equipmentlist.php";
			break;
		case "equipmentdelete"://장비관리 삭제 
			include_once $root.$folder."/inventory/equipmentdelete.php";
			break;
		case "equipmentcheckcode"://장비관리 장비코드 check  
			include_once $root.$folder."/inventory/equipmentcheckcode.php";
			break;
			

		case "makingtablelist"://조제대관리 리스트
			include_once $root.$folder."/inventory/makingtablelist.php";
			break;	
		case "makingtabledelete"://조제대관리 리스트
			include_once $root.$folder."/inventory/makingtabledelete.php";
			break;	

		case "packinglist"://포장재 리스트
			include_once $root.$folder."/inventory/packinglist.php";
			break;	
		case "packingdesc"://포장재 등록
			include_once $root.$folder."/inventory/packingdesc.php";
			break;	
		case "packingdelete"://포장재 삭제
			include_once $root.$folder."/inventory/packingdelete.php";
			break;	
			/* 0409 안쓰는것으로 파악됨.
		case "mediBoxchk"://약재함등록시 중복체크 (자동추가됨)
			include_once $root.$folder."/inventory/mediBoxchk.php";
			break;	
			*/
		case "mypackingdesc"://한의원에서 나의 포장재 보이기
			include_once $root.$folder."/inventory/mypackingdesc.php";
			break;	
		case "markingprinterlist"://마킹프린터
			include_once $root.$folder."/inventory/markingprinterlist.php";
			break;
		case "markingprinterdelete"://마킹프린터 삭제
			include_once $root.$folder."/inventory/markingprinterdelete.php";
			break;
		case "allpouchtaglist":
			include_once $root.$folder."/inventory/allpouchtaglist.php";
			break;
		case "packlist":  //포장기관리
			include_once $root.$folder."/inventory/packlist.php";
			break;
		case "packdelete":  //포장기삭제
			include_once $root.$folder."/inventory/packdelete.php";
			break;		
		case "mediboxchk":  //약재함 중복체크
			include_once $root.$folder."/inventory/mediboxchk.php";
			break;	

			
	}

	//POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"])
		{
			case "mediboxupdate":
				include_once $root.$folder."/inventory/mediboxupdate.php";
				break;
			case "outstockupdate":
				include_once $root.$folder."/inventory/outstockupdate.php";
				break;
			case "pouchtagupdate":
				include_once $root.$folder."/inventory/pouchtagupdate.php";
				break;
			case "potupdate":
				include_once $root.$folder."/inventory/potupdate.php";
				break;
			case "makingtableupdate":
				include_once $root.$folder."/inventory/makingtableupdate.php";
				break;
			case "packingupdate":
				include_once $root.$folder."/inventory/packingupdate.php";
				break;
			case "markingprinterupdate":  //마킹프린터update
				include_once $root.$folder."/inventory/markingprinterupdate.php";
				break;		
			case "packupdate":  //포장기 업데이트
				include_once $root.$folder."/inventory/packupdate.php";
				break;		
			case "equipmentupdate"://장비관리 등록수정 
				include_once $root.$folder."/inventory/equipmentupdate.php";
				break;
		}
	}

	include_once $root.$folder."/tail.php";
?>

