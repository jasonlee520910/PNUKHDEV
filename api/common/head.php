<?php
	header("Access-Control-Allow-Origin: *"); 
	header("Access-Control-Allow-Methods: POST, GET, DELETE"); 
	//header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept"); 
	header("Access-Control-Allow-Headers: Content-Type, Accept"); 

	//POST
	include_once $root.$folder."/common.php";
	include_once $root.$folder."/_common/lib/_lib.php";
	//include_once $root.$folder."/_common/lib/_code.lib.php"; // DOO :: _code.lib 라이브러리 추가 
	//include_once $root.$folder."/_common/db/db.inc.php";
	$json["resultCode"]="204";
?>
