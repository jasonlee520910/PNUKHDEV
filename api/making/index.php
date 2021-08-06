<?php
	$root="..";
	$folder="/making";

	include_once $root.$folder."/head.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="MAKING API(apiCode) ERROR";

	//GET
	switch($_GET["apiCode"])
	{
		case "idset":
			include_once $root.$folder."/idset.php";
			break;
		case "scan":
			include_once $root.$folder."/scan.php";
			break;
		case "list":
			include_once $root.$folder."/list.php";
			break;
		case "status":
			include_once $root.$folder."/status.php";
			break;
		case "tablescan":
			include_once $root.$folder."/tablescan.php";
			break;
		case "lighton":
			include_once $root.$folder."/lighton.php";
			break;
		case "lighton1":
			include_once $root.$folder."/lighton1.php";
			break;
		case "getlog":
			include_once $root.$folder."/getlog.php";
			break;
		default:
	}
	
	//POST
	$resjson = json_decode(file_get_contents('php://input'),true);
	switch($resjson["apiCode"]){
		case "log":
			include_once $root.$folder."/log.php";
			break;
	}
	/*switch($_POST["apiCode"]){
		case "log":
			include_once $root.$folder."/log.php";
			break;
		case "logtest":
			include_once $root.$folder."/logtest.php";
			break;
	}*/
	
	include_once $root.$folder."/tail.php";

?>
