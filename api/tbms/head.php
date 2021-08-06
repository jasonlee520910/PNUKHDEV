<?php
//	header("Access-Control-Allow-Origin: *"); 
//	header("Access-Control-Allow-Methods: POST, GET, DELETE, OPTIONS"); 
//	//header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept"); 
//	header("Access-Control-Allow-Headers: Content-Type, Accept, ck_authkey, ck_stStaffid"); 
    if(isset($_SERVER['HTTP_ORIGIN'])) 
	{
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
    }

    if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
	{
        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if(isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

		exit(0);
    }


	//POST
	include_once $root.$folder."/common.php";
	include_once $root.$folder."/_common/lib/_lib.php";
	include_once $root.$folder."/_common/db/db.inc.php";
	$json["resultCode"]="204";

	$headers = apache_request_headers();
	$ck_authkey=$headers["ck_authkey"];
	$ck_stStaffid=$headers["ck_stStaffid"];
	//$json["ck_authkey"]=$headers["ck_authkey"];
	//$json["ck_stStaffid"]=$headers["ck_stStaffid"];


	if($ck_authkey && $ck_stStaffid)
	{
		$sql=" select st_authkey from ".$dbH."_staff where st_staffid = '".$ck_stStaffid."' ";
		$dt=dbone($sql);
		$authkey = $dt["ST_AUTHKEY"];

		$endata = djDecrypt($ck_authkey, $authkey);

		//$json["db_authkey"] = $authkey;
		//$json["db_endata"] = $endata;
		/*if($endata == $ck_stStaffid)
		{
			//$json["doo"] = "same";
		}
		else
		{
			//$json["doo"] = "id no";

			$json["apiCode"]=$_GET["apiCode"];
			$json["resultCode"]="9999";
			$json["resultMessage"]="MEMBER_DIFFERENT";

			include_once $root.$folder."/tail.php";
			exit;
		}*/
	}
	else
	{
		//$json["doo"] = "no";
		$json["apiCode"]=$_GET["apiCode"];
		$json["resultCode"]="9999";
		$json["resultMessage"]="MEMBER_DIFFERENT";

		include_once $root.$folder."/tail.php";
		exit;
	}

?>
