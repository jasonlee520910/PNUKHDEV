<?php 
	/// st_staffid 인지 st_userid 인지 체크
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$st_loginid=$_GET["stLoginId"];

	if($apiCode!="loginidchk"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="loginidchk";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($st_loginid==""){$json["resultMessage"]="API(stLoginId) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$wsql=" where st_staffid = '".$st_loginid."' ";
		$sql=" select st_seq, st_userid from ".$dbH."_staff $wsql ";
		$dt=dbone($sql);

		$json["sql"]=$sql;
		$json["seq"]=$dt["ST_SEQ"];
		$json["stUserId"]=$dt["ST_USERID"];

		if($dt["ST_SEQ"]){
			$json["resultCode"]="200";
		}else{
			$json["resultCode"]="204";
		}
		$json["resultMessage"]="OK";
		
	}
?>