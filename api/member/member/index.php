<?php
	$root="../..";
	$folder="/member";

	include_once $root.$folder."/head.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="MEMBER API(apiCode)".$_GET["apiCode"]."_".$_POST["apiCode"]." ERROR";

	/// GET, DELETE
	if($_GET["apiCode"]){
		switch($_GET["apiCode"]){
			case "loginidchk": /// st_staffid 인지 st_userid 인지 체크
				include_once $root.$folder."/member/loginidchk.php";
				break;
			case "staffdepartupdate":/// staff 파트 업데이트 
				include_once $root.$folder."/member/staffdepartupdate.php";
				break;
		}
	}

	/// POST
	if($_POST["apiCode"]){
		switch($_POST["apiCode"]){
			case "stafflogin": /// 로그인
				include_once $root.$folder."/member/stafflogin.php";
				break;				
		}
	}
	include_once $root.$folder."/tail.php";

?>
