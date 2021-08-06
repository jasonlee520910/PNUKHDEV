<?php
    if(isset($_SERVER['HTTP_ORIGIN'])) 
	{
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
    }

    if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
	{
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");        

        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");


			$json["apiCode"]=$_GET["apiCode"];
			$json["resultCode"]="77777";
			$json["resultMessage"]="77777sdfdsfds";

			include_once $root.$folder."/tail.php";


			
		exit(0);
    }
	include_once $root.$folder."/_define.php";
	include_once $root.$folder."/common.php";
	include_once $root.$folder."/_common/lib/_lib.php";
	include_once $root.$folder."/_common/lib/_code.lib.php";
	include_once $root.$folder."/_common/db/db.inc.php";
	$json["resultCode"]="204";


	$headers = apache_request_headers();

	if($headers["ck_authkey"] && $headers["ck_stStaffid"])
	{	
		$sql=" select st_authkey from ".$dbH."_staff where st_staffid = '".$headers["ck_stStaffid"]."' ";
		$dt=dbone($sql);
		$authkey = $dt["ST_AUTHKEY"];

		$endata = djDecrypt(urldecode($headers["ck_authkey"]), $authkey);
		
		/*if($endata == $headers["ck_stStaffid"])
		{
			
		}
		else
		{
			$json["apiCode"]=$_GET["apiCode"];
			$json["resultCode"]="9999";
			$json["resultMessage"]="MEMBER_DIFFERENT";

			include_once $root.$folder."/tail.php";
			exit;
		}*/
		
	}
	else
	{
		$json["apiCode"]=$_GET["apiCode"];
		$json["resultCode"]="9999";
		$json["resultMessage"]="MEMBER_DIFFERENT";

		include_once $root.$folder."/tail.php";
		exit;
	}
?>
