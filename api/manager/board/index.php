<?php
	$root="../..";
	$folder="/manager";
	include_once $root.$folder."/head.php";
	
	$json["resultCode"]="404";
	$json["resultMessage"]="MANAGER API(apiCode) ERROR.";

	//GET, DELETE
	if($_GET["apiCode"]){
		switch($_GET["apiCode"]){
			case "boardlist":
				include_once $root.$folder."/board/boardlist.php";
				break;
			case "boarddesc":
				include_once $root.$folder."/board/boarddesc.php";
				break;
			case "boarddelete":
				include_once $root.$folder."/board/boarddelete.php";
				break;
			case "policylist"://개인정보처리방침 
				include_once $root.$folder."/board/policylist.php";
				break;
			case "policydesc"://개인정보처리방침 
				include_once $root.$folder."/board/policydesc.php";
				break;
			case "policydelete":
				include_once $root.$folder."/board/policydelete.php";
				break;
			case "policyrechange":
				include_once $root.$folder."/board/policyrechange.php";
				break;
				

		}
	}
	//POST
	if($_POST["apiCode"]){
		switch($_POST["apiCode"]){
			case "boardupdate":
				include_once $root.$folder."/board/boardupdate.php";
				break;
			case "policyupdate":/// 개인정보처리방침
				include_once $root.$folder."/board/policyupdate.php";
				break;
			case "policyorderchange":/// 개인정보처리방침
				include_once $root.$folder."/board/policyorderchange.php";
				break;

				
				

		}
	}
	include_once $root.$folder."/tail.php";
?>
