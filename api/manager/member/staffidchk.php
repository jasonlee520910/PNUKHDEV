<?php  
	///사용자관리 > 스탭관리 > 아이디 중복 체크
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$st_userid=$_GET["stUserId"];

	if($apiCode!="staffidchk"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="staffidchk";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($st_userid==""){$json["resultMessage"]="API(stUserId) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$jsql="";
		$wsql=" where st_userid = '".$st_userid."' ";
		$sql=" select st_seq, st_userid from ".$dbH."_staff a $jsql $wsql ";
		$dt=dbone($sql);

		$json=array(
			"apiCode"=>$apiCode,
			"seq"=>$dt["ST_SEQ"],
			"stUserId"=>$dt["ST_USERID"]
			);

		if($dt["ST_SEQ"]){
			$json["resultCode"]="200";
		}else{
			$json["resultCode"]="204";
		}
		$json["resultMessage"]="OK";
	}
?>