<?php ///회원가입
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$medicalid=$_GET["medicalid"];

	if($apiCode!="medicalidchk"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="medicalidchk";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		
		$wsql=" where me_loginid = '".$medicalid."' ";
		$sql=" select me_seq, me_loginid from ".$dbH."_member a $wsql ";
		$dt=dbone($sql);
		$json=array("apiCode"=>$apiCode,"seq"=>$dt["ME_SEQ"],"medicalid"=>$dt["ME_LOGINID"]);
		if($dt["ME_SEQ"]){
			$json["resultCode"]="204"; ///사용불가능
		}else{
			$json["resultCode"]="200"; ///사용가능함
		}
		$json["resultMessage"]="OK";


		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
	}
?>