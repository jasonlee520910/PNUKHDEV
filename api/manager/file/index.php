	<?php 
	$root="../..";
	$folder="/manager";
	include_once $root.$folder."/settinghead.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="MANAGER API(apiCode) ERROR!";

	//GET
	switch($_GET["apiCode"])
	{	
	case "filedelete"://파일삭제
		include_once $root.$folder."/file/filedelete.php";
		break;
	}

	//POST
	if($_POST["apiCode"])
	{
		switch($_POST["apiCode"])
		{
		case "fileupdate": //파일등록 및 수정 
			include_once $root.$folder."/file/fileupdate.php";
			break;
		}
	}

	include_once $root.$folder."/tail.php";
?>

