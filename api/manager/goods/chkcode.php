<?php //goods 제품 코드 중복체크
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$gd_code=trim($_GET["gd_code"]);

	if($apiCode!="chkcode"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="chkcode";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($gd_code==""){$json["resultMessage"]="API(gd_code) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
	
		$wsql=" where gd_code = '".$gd_code."' ";
		$sql=" select gd_seq, gd_code from ".$dbH."_goods a $wsql ";
		$dt=dbone($sql);

		$json=array("apiCode"=>$apiCode,"seq"=>$dt["gd_seq"],"gd_code"=>$dt["gd_code"]);

		if($dt["gd_seq"]){
			$json["resultCode"]="200";
		}else{
			$json["resultCode"]="204";
		}
		$json["resultMessage"]="OK";
	}
?>