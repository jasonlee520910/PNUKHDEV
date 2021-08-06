<?php
	$adm="../..";
	include_once $adm."/_api/apihead.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="API코드오류";
	//GET
	switch($_GET["apiCode"]){
		case "tutoriallist":
			include_once $adm."/_api/tutorial/tutoriallist.php";
			break;
		case "tutorialdesc":
			include_once $adm."/_api/tutorial/tutorialdesc.php";
			break;
		case "tutorialdelete":
			include_once $adm."/_api/tutorial/tutorialdelete.php";
			break;
		case "tutorialmove":
			include_once $adm."/_api/tutorial/tutorialmove.php";
			break;
		default:
	}
	//POST
	$resjson = json_decode(file_get_contents('php://input'),true);
	switch($resjson["apiCode"]){
		case "tutorialupdate":
			include_once $adm."/_api/tutorial/tutorialupdate.php";
			break;
	}
	include_once $adm."/_api/apitail.php";
?>
