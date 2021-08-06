<?php
	$root="../..";
	$folder="/medical";
	include_once $root.$folder."/head.php";
	
	$json["resultCode"]="404";
	$json["resultMessage"]="MEDICAL API(apiCode) ERROR.";

	///GET, DELETE
	if($_GET["apiCode"]){
		switch($_GET["apiCode"]){
			case "policydesc":///공지사항
				include_once $root.$folder."/policy/policydesc.php";
				break;
				
		}
	}

	include_once $root.$folder."/tail.php";
?>
