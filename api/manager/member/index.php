<?php
	$root="../..";
	$folder="/manager";
	include_once $root.$folder."/head.php";
	
	$json["resultCode"]="404";
	$json["resultMessage"]="MANAGER API(apiCode) ERROR.";

	//GET, DELETE
	if($_GET["apiCode"]){
		switch($_GET["apiCode"]){
			case "medicallist"://한의원리스트_MANAGER(layer-medical)
				include_once $root.$folder."/member/medicallist.php";
				break;
			case "membermedicallist"://한의원리스트_MANAGER(한의원관리)
				include_once $root.$folder."/member/membermedicallist.php";
				break;
			case "medicaldesc"://한의원정보상세
				include_once $root.$folder."/member/medicaldesc.php";
				break;
			case "medicaldelete"://한의원 삭제
				include_once $root.$folder."/member/medicaldelete.php";
				break;			
			case "memberdelete"://한의사 정보 삭제
				include_once $root.$folder."/member/memberdelete.php";
				break;
			case "medicalidchk"://한의원정보아이디중복체크(TMPS&MANAGER)
				include_once $root.$folder."/member/medicalidchk.php";
				break;
			case "medicalimg"://한의원 클릭시 해당하는 파우치,한약박스,포장박스,제환,항아리,스틱 list를 새로 받기 위해서 
				include_once $root.$folder."/member/medicalimg.php";
				break;
			case "userdesc"://환자정보 
				include_once $root.$folder."/member/userdesc.php";
				break;
			case "userlist"://한의원 총 환자리스트 
				include_once $root.$folder."/member/userlist.php";
				break;
			case "userprescriptionlist"://선택한 환자 처방내역 (과거진료리스트)
				include_once $root.$folder."/member/userprescriptionlist.php";
				break;
			case "workerchange"://조재사, 탕제사 수정 
				include_once $root.$folder."/member/workerchange.php";
				break;
			case "stafflist"://MANAGER(스텝 리스트)
				include_once $root.$folder."/member/stafflist.php";
				break;
			case "staffdesc"://MANAGER(스텝 desc)
				include_once $root.$folder."/member/staffdesc.php";
				break;
			case "staffidchk"://MANAGER(스텝 아이디체크)
				include_once $root.$folder."/member/staffidchk.php";
				break;
			case "staffdelete"://MANAGER(스텝 삭제)
				include_once $root.$folder."/member/staffdelete.php";
				break;
			case "nonemedical":
				include_once $root.$folder."/member/nonemedical.php";
				break;
			case "memberlist":
				include_once $root.$folder."/member/memberlist.php";
				break;
			case "commpacking":
				include_once $root.$folder."/member/commpacking.php";
				break;
			case "commpackingupdate":
				include_once $root.$folder."/member/commpackingupdate.php";
				break;
			case "doctorlist":
				include_once $root.$folder."/member/doctorlist.php";				
				break;

		}
	}
	//POST
	if($_POST["apiCode"]){
		switch($_POST["apiCode"]){
			/* 0409 안쓰는것으로 확인되어 일단 주석처리함
			case "medicallogin"://한의원정보로그인 
				include_once $root.$folder."/member/medicallogin.php";
				break;
			*/
			case "medicalupdate"://한의원정보등록&수정
				include_once $root.$folder."/member/medicalupdate.php";
				break;
			case "memberupdate"://한의사 등록&수정
				include_once $root.$folder."/member/memberupdate.php";
				break;
			/*  0511 안쓰는것으로 확인되어 일단 주석처리함
			case "stafflogin": //로그인(MANAGER)
				include_once $root.$folder."/member/stafflogin.php";
				break;
			*/
			case "userupdate":
				include_once $root.$folder."/member/userupdate.php";
				break;
			case "userlogin":
				include_once $root.$folder."/member/userlogin.php";
				break;
			case "customerupdate":
				include_once $root.$folder."/member/customerupdate.php";
				break;
			case "staffupdate": //스텝 등록 수정(MANAGER)
				include_once $root.$folder."/member/staffupdate.php";
				break;
			case "mydoctorupdate":   //한의사 관리 버튼
				include_once $root.$folder."/member/mydoctorupdate.php";
				break;
			case "medicaldoctorupdate":  //한의원 관리에서 버튼
				include_once $root.$folder."/member/medicaldoctorupdate.php";
				break;		

				

		}
	}
	include_once $root.$folder."/tail.php";
?>
