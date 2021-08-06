<?php  
	/// 약재관리 > 약재목록 > 약재매칭시 약재코드 중복체크 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$code=$_GET["smuCode"];

	if($apiCode!="chksmumedicinecode"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="chksmumedicinecode";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($code==""){$json["resultMessage"]="API(code) ERROR";}
	else
	{
		$sql="select md_code from han_medicine_".$refer." where mm_code = '".$code."' ";
		$dt=dbone($sql);

		$json["sql"]=$sql;
		if($dt["MD_CODE"])
		{
			$json["apiCode"]=$apiCode;
			$json["resultCode"]="999";
			$json["resultMessage"]="OK";
		}
		else
		{
			$json["apiCode"]=$apiCode;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}

	}
?>