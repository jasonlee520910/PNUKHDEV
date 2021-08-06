<?php
	$root="../..";
	$folder="/common";
	include_once $root.$folder."/head.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="COMMON API(apiCode) ERROR";

	//GET
	if($_GET["apiCode"])
	{
		switch($_GET["apiCode"])
		{
			case "sendemail": //메일보내기
				include_once $root.$folder."/mailer/send.smtp.php";
				break;


				
			default:
		}
	}
	//POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"])
		{
			case "sendchk": //인증확인하기
				include_once $root.$folder."/mailer/sendchk.php";
				break;
			case "mestatusupdate": //인증update 승인
				include_once $root.$folder."/mailer/mestatusupdate.php";
				break;
		}
	}
	include_once $root.$folder."/tail.php";
?>
