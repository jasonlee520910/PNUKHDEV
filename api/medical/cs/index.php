<?php
	$root="../..";
	$folder="/medical";
	include_once $root.$folder."/head.php";
	
	$json["resultCode"]="404";
	$json["resultMessage"]="MEDICAL API(apiCode) ERROR.";

	///GET, DELETE
	if($_GET["apiCode"]){
		switch($_GET["apiCode"]){
			case "noticelist":///공지사항
				include_once $root.$folder."/cs/noticelist.php";
				break;
			case "faqlist":///FAQ
				include_once $root.$folder."/cs/faqlist.php";
				break;
			case "qnalist":///QNA
				include_once $root.$folder."/cs/qnalist.php";
				break;
			case "boardlist":///게시판
				include_once $root.$folder."/cs/boardlist.php";
				break;
			case "inquirydesc":///1대1문의하기 상세보기
				include_once $root.$folder."/cs/inquirydesc.php";
				break;
			case "inquirydelete":///1대1문의하기 삭제
				include_once $root.$folder."/cs/inquirydelete.php";
				break;
			case "indexboardlist":///메인페이지index boardlist
				include_once $root.$folder."/cs/indexboardlist.php";
				break;			
				
		}
	}
	///POST
	if($_POST["apiCode"]){
		switch($_POST["apiCode"]){
			
			case "inquiryupdate": ///1대1문의하기 등록
				include_once $root.$folder."/cs/inquiryupdate.php";
				break;
			default:
					
		}
	}

	include_once $root.$folder."/tail.php";
?>
