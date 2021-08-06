<?php
	$root="../..";
	$folder="/manager";
	include_once $root.$folder."/head.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="MANAGER API(apiCode) ERROR";
	//GET
	switch($_GET["apiCode"])
	{
		case "textdblist"://언어>리스트
			include_once $root.$folder."/setting/textdblist.php";
			break;
		case "textdbdelete"://언어>삭제
			include_once $root.$folder."/setting/textdbdelete.php";
			break;
		case "codedelete"://코드관리>삭제
			include_once $root.$folder."/setting/codedelete.php";
			break;
		case "codedesc"://코드관리>상세
			include_once $root.$folder."/setting/codedesc.php";
			break;
		case "codelist"://코드관리>리스트
			include_once $root.$folder."/setting/codelist.php";
			break;
		case "subcodedelete"://코드관리>상세>삭제
			include_once $root.$folder."/setting/subcodedelete.php";
			break;
		case "configdesc"://기본설정 상세 
			include_once $root.$folder."/setting/configdesc.php";
			break;
	}

	//POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"])
		{
			case "textdbupdate":/// 환경설정 > 언어TextDB > 수정 
				include_once $root.$folder."/setting/textdbupdate.php";
				break;
			case "codeupdate":/// 환경설정 > 코드관리 > 수정
				include_once $root.$folder."/setting/codeupdate.php";
				break;
			case "subcodeupdate":/// 환경설정 > 코드관리 > 상세 > 수정 
				include_once $root.$folder."/setting/subcodeupdate.php";
				break;
			case "configupdate":/// 환경설정 > 기본설정 > 수정 
				include_once $root.$folder."/setting/configupdate.php";
				break;
		}
	}
	include_once $root.$folder."/tail.php";
?>
