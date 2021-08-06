<?php 
	/// 스텝확인 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];
	$code=$_GET["code"];
	$depart=$_GET["depart"];
	
	if($apiCode!="getstaff"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="getstaff";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}		
	else if($code==""){$json["resultMessage"]="API(code) ERROR";}
	else
	{		
		$sql=" select st_seq, st_depart, st_userid, st_staffid, st_login, st_name from ".$dbH."_staff where st_staffid='".$code."' ";
		$dt=dbone($sql);

		$json["data"]=array(
			"stSeq"=>$dt["ST_SEQ"],
			"stDepart"=>$dt["ST_DEPART"],			
			"stUserid"=>$dt["ST_USERID"],
			"stStaffid"=>$dt["ST_STAFFID"],
			"stLogin"=>$dt["ST_LOGIN"],				
			"stName"=>$dt["ST_NAME"]
			);
	}

	$json["apiCode"]=$apiCode;
	$json["resultCode"]="200";
	$json["resultMessage"]="OK";
?>
