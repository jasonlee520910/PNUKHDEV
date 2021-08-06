<?php
	$root="../..";
	$folder="/medical";
	include_once $root.$folder."/head.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="Medical API(apiCode.POST:".$_POST["apiCode"]."GET:".$_GET["apiCode"].") ERROR";

	///GET, DELETE
	if($_GET["apiCode"]){
		switch($_GET["apiCode"]){
			case "medicalidchk":///한의원 아이디중복체크(
				include_once $root.$folder."/member/medicalidchk.php";
				break;
			case "myinfodesc":///
				include_once $root.$folder."/member/myinfodesc.php";
				break;
				/*
			case "joindesc":///회원가입서류
				include_once $root.$folder."/member/joindesc.php";
				break;
				*/
			case "chkpwd":///내정보 수정시 비밀번호 확인
				include_once $root.$folder."/member/chkpwd.php";
				break;
			case "dowithdraw":///탈퇴
				include_once $root.$folder."/member/dowithdraw.php";
				break;
			case "mydesc":  //한의원 mypage 상세
				include_once $root.$folder."/member/mydesc.php";
				break;			
			case "memberdocxlist"://복용지시&조제지시리스트 
				include_once $root.$folder."/member/memberdocxlist.php";
				break;	
			case "memberdocxdesc":
				include_once $root.$folder."/member/memberdocxdesc.php";
				break;
			case "memberdocxdelete":
				include_once $root.$folder."/member/memberdocxdelete.php";
				break;
			case "mydoctorlist":  //나의 한의사 리스트
				include_once $root.$folder."/member/mydoctorlist.php";
				break;
			case "medicallist":  //한의사가 한의원 검색
				include_once $root.$folder."/member/medicallist.php";
				break;
			case "ceochk":  ///대표 한의사가 한의원탈퇴시 소속한의사가 없는지 체크
				include_once $root.$folder."/member/ceochk.php";
				break;		

				
		}
	}
	///POST
	if($_POST["apiCode"]){
		switch($_POST["apiCode"]){
			case "login": ///로그인
				include_once $root.$folder."/member/login.php";
				break;
			case "medicalupdate": ///회원가입
				include_once $root.$folder."/member/medicalupdate.php";
				break;		
			case "addmedicalupdate": ///의료기관정보수정(medical)
				include_once $root.$folder."/member/addmedicalupdate.php";
				break;		
			case "findid": ///아이디찾기
				include_once $root.$folder."/member/findid.php";
				break;
			case "findpw": ///아이디찾기
				include_once $root.$folder."/member/findpw.php";
				break;
			case "addmemberupdate": ///회원정보  수정(member)
				include_once $root.$folder."/member/addmemberupdate.php";
				break;
			case "memberdocxupdate"://복용지시&조제지시 update 
				include_once $root.$folder."/member/memberdocxupdate.php";
				break;
			case "passupdate"://비밀번호 변경
				include_once $root.$folder."/member/passupdate.php";
				break;
			case "invitedoctorupdate"://대표한의사가 소속한의사 요청
				include_once $root.$folder."/member/invitedoctorupdate.php";
				break;
			case "mydoctorupdate"://한의사 상태에 따른 처리
				include_once $root.$folder."/member/mydoctorupdate.php";
				break;
			case "mymedicalupdate"://대표한의사가 승인요청한 것을 한의사가 승인함
				include_once $root.$folder."/member/mymedicalupdate.php";
				break;





				
		}
	}
	include_once $root.$folder."/tail.php";
?>
