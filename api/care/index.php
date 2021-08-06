<?php
	$adm="../..";
	include_once $adm."/_api/apihead.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="API코드오류.";
	//GET
	switch($_GET["apiCode"]){
		case "userdesc":
			include_once $adm."/_api/care/userdesc.php";
			break;
		case "recipedesc":
			include_once $adm."/_api/care/recipedesc.php";
			break;
		case "caresclist":
			include_once $adm."/_api/care/caresclist.php";
			break;
		case "carescdesc":
			include_once $adm."/_api/care/carescdesc.php";
			break;
		case "caremedicine":
			include_once $adm."/_api/care/caremedicine.php";
			break;
		case "caredecoction":
			include_once $adm."/_api/care/caredecoction.php";
			break;
		case "carestart":
			include_once $adm."/_api/care/carestart.php";
			break;
		case "careschedule":
			include_once $adm."/_api/care/careschedule.php";
			break;
		case "careschedesc":
			include_once $adm."/_api/care/careschedesc.php";
			break;
		case "carechkschedule":
			include_once $adm."/_api/care/carechkschedule.php";
			break;
		case "careconfirm":
			include_once $adm."/_api/care/careconfirm.php";
			break;
		case "carescheperiod":
			include_once $adm."/_api/care/carescheperiod.php";
			break;
		default:
	}
	//POST
	$resjson = json_decode(file_get_contents('php://input'),true);
	switch($resjson["apiCode"]){
		case "userupdate":
			include_once $adm."/_api/care/userupdate.php";
			break;
		case "userlogin":
			include_once $adm."/_api/care/userlogin.php";
			break;
		case "carescupdate":
			include_once $adm."/_api/care/carescupdate.php";
			break;
		default:
	}
	include_once $adm."/_api/apitail.php";
?>
