<?php  
	///사용자관리 > 한의원관리 > 소속 한의사 등록&수정 시 아이디 중복체크
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$me_loginid=$_GET["meLoginid"];

	if($apiCode!="medicalidchk"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicalidchk";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($me_loginid==""){$json["resultMessage"]="API(meLoginid) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$sql=" select me_seq, me_loginid from ".$dbH."_member where me_loginid = '".$me_loginid."' ";
		$dt=dbone($sql);
		$json=array("apiCode"=>$apiCode,"seq"=>$dt["ME_SEQ"],"meLoginid"=>$dt["ME_LOGINID"]);
		if($dt["ME_SEQ"]){
			$json["resultCode"]="200";
		}else{
			$json["resultCode"]="204";
		}
		$json["resultMessage"]="OK";
	}
?>