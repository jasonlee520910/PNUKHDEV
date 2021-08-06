<?php
	$root="../..";
	$folder="/manager";
	include_once $root.$folder."/head.php";
	
	$json["resultCode"]="404";
	$json["resultMessage"]="MANAGER API(apiCode) ERROR.";

	//GET, DELETE
	if($_GET["apiCode"]){
		switch($_GET["apiCode"]){

			case "hubcatelist"://본초분류 리스트
				include_once $root.$folder."/medicine/hubcatelist.php";
				break;		
			case "hubcatedesc"://본초분류 상세
				include_once $root.$folder."/medicine/hubcatedesc.php";
				break;
			case "hubcatedelete"://본초분류 삭제
				include_once $root.$folder."/medicine/hubcatedelete.php";
				break; 
			case "hublist"://본초정보 리스트
				include_once $root.$folder."/medicine/hublist.php";
				break;
			case "hubdesc"://본초정보 상세 
				include_once $root.$folder."/medicine/hubdesc.php";
				break;
			case "hubdelete"://본초정보 삭제
				include_once $root.$folder."/medicine/hubdelete.php";
				break;
			case "hubcategory"://본초 분류1.2 옵션
				include_once $root.$folder."/medicine/hubcategory.php";
				break;
			case "medicinelist"://약재검색&약재목록
				include_once $root.$folder."/medicine/medicinelist.php";
				break;
			case "medicinedesc"://약재상세
				include_once $root.$folder."/medicine/medicinedesc.php";
				break;
			case "medicinedelete"://약재삭제
				include_once $root.$folder."/medicine/medicinedelete.php";
				break;
			case "dismedilist"://상극알람 리스트
				include_once $root.$folder."/medicine/dismedilist.php";
				break;
			case "dismedidesc"://상극알람 상세
				include_once $root.$folder."/medicine/dismedidesc.php";
				break;
			case "dismedidelete"://상극알람 삭제
				include_once $root.$folder."/medicine/dismedidelete.php";
				break;
			case "posmedilist"://독성알람 리스트
				include_once $root.$folder."/medicine/posmedilist.php";
				break;
			case "posmedidesc"://독성알람 상세
				include_once $root.$folder."/medicine/posmedidesc.php";
				break;
				/* 0409 안쓰는것으로 파악됨.
			case "posmedidelete"://독성알람 삭제
				include_once $root.$folder."/medicine/posmedidelete.php";
				break;
				*/
			case "medicinetitle"://약재구성
				include_once $root.$folder."/medicine/medicinetitle.php";
				break;
			case "medicinerecipe"://고유처방,이전처방 클릭시 
				include_once $root.$folder."/medicine/medicinerecipe.php";
				break;
			case "filedelete"://본초상세 이미지 업로드 삭제
				include_once $root.$folder."/medicine/filedelete.php";
				break;
			case "medicinesmulist"://약재목록 세명대 
				include_once $root.$folder."/medicine/medicinesmulist.php";
				break;
			case "medicinesmudesc"://약재상세 세명대 
				include_once $root.$folder."/medicine/medicinesmudesc.php";
				break;
			case "medicinesmudelete": //약재세명대 삭제 
				include_once $root.$folder."/medicine/medicinesmudelete.php";
				break;
			case "smumedicinelist": //세명대 약재목록 약재리스트(팝업)
				include_once $root.$folder."/medicine/smumedicinelist.php";
				break;
				
			case "chksmumedicinecode": //세명대 약재목록 약재코드 중복체크 
				include_once $root.$folder."/medicine/chksmumedicinecode.php";
				break;
			/* 0409 안쓰는것으로 파악됨.
			case "chkhubcode": //본초코드 중복 체크 (자동추가로 변경)
				include_once $root.$folder."/medicine/chkhubcode.php";
				break;
			case "chkmedicode": //약재코드 중복 체크 (자동추가로 변경)
				include_once $root.$folder."/medicine/chkmedicode.php";
				break;
				*/
			case "nonemedicine": //미등록된 약재 등록후 주문에 업데이트 
				include_once $root.$folder."/medicine/nonemedicine.php";
				break;
			case "medicinehanpurelist"://미등록된 약재 검색
				include_once $root.$folder."/medicine/medicinehanpurelist.php";
				break;
			case "dismatchchk":  //상극알람 중복체크
				include_once $root.$folder."/medicine/dismatchchk.php";
				break;
			case "changemedicodelist": //약재변경리스트 
				include_once $root.$folder."/medicine/changemedicodelist.php";
				break;
			case "changemedicodeupdate": //약재변경 업데이트 
				include_once $root.$folder."/medicine/changemedicodeupdate.php";
				break;
			case "makerlist": ///제조사 리스트
				include_once $root.$folder."/medicine/makerlist.php";
				break;
				/*
			case "makerdel": ///제조사 삭제
				include_once $root.$folder."/medicine/makerdel.php";
				break;
				*/
		}
	}
	//POST
	if($_POST["apiCode"]){
		switch($_POST["apiCode"]){
			case "hubcateupdate": //본초분류관리 등록&수정
				include_once $root.$folder."/medicine/hubcateupdate.php";
				break;
			case "hubupdate":  //본초관리 등록&수정
				include_once $root.$folder."/medicine/hubupdate.php";
				break;
			case "medicineupdate": //약재 등록&수정
				include_once $root.$folder."/medicine/medicineupdate.php";
				break;
			case "dismediupdate": //상극알람 등록&수정
				include_once $root.$folder."/medicine/dismediupdate.php";
				break;
				/*  0408 안쓰는것으로 확인되어 일단 주석처리함
			case "posmediupdate": //독성알람 등록&수정
				include_once $root.$folder."/medicine/posmediupdate.php";
				break;
				/*
			case "fileupdate"://본초상세 이미지 업로드 
				include_once $root.$folder."/medicine/fileupdate.php";
				break;
				**/
			case "medicinesmuupdate"://약재세명대 
				include_once $root.$folder."/medicine/medicinesmuupdate.php";
				break;
			default:
			case "makerupdate": //제조사 관리 등록
				include_once $root.$folder."/medicine/makerupdate.php";
				break;
			
		}
	}

	include_once $root.$folder."/tail.php";
?>
