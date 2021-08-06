<?php
	$root="../..";
	$folder="/medical";
	if($_GET["apiCode"] == "textdbfront")
	{
		include_once $root.$folder."/settinghead.php";
	}
	else
	{
		include_once $root.$folder."/head.php";
	}

	$json["resultCode"]="404";
	$json["resultMessage"]="MEDICAL API(apiCode) ERROR";
	///GET
	switch($_GET["apiCode"])
	{
		case "textdbfront":
			include_once $root.$folder."/setting/textdbfront.php";
			break;
		case "textdblist":
			include_once $root.$folder."/setting/textdblist.php";
			break;
		case "textdbdelete":
			include_once $root.$folder."/setting/textdbdelete.php";
			break;

		case "codedelete":
			include_once $root.$folder."/setting/codedelete.php";
			break;
		case "codedesc":
			include_once $root.$folder."/setting/codedesc.php";
			break;
		case "codelist":
			include_once $root.$folder."/setting/codelist.php";
			break;

		case "subcodedelete":
			include_once $root.$folder."/setting/subcodedelete.php";
			break;
		case "configinfo":///기본정보조회
			include_once $root.$folder."/setting/configinfo.php";
			break;
	}

	///POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"])
		{
			case "textdbupdate":
				include_once $root.$folder."/setting/textdbupdate.php";
				break;
			case "codeupdate":
				include_once $root.$folder."/setting/codeupdate.php";
				break;
			case "subcodeupdate":
				include_once $root.$folder."/setting/subcodeupdate.php";
				break;
		}
	}
	include_once $root.$folder."/tail.php";
?>
