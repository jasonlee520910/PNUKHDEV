<?php  
	/// 자재코드관리 > 조제태그관리 > 상세(바코드출력)
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$pt_seq=$_GET["seq"];
	if($apicode!="pouchtagdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="pouchtagdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($pt_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$jsql=" a ";
		$wsql=" where pt_seq = '".$pt_seq."' ";
		$sql=" select a.* from ".$dbH."_pouchtag $jsql $wsql ";
		$dt=dbone($sql);

		$json=array(
			"seq"=>$dt["PT_SEQ"], 
			"ptCode"=>$dt["PT_CODE"], 
			"ptGroup"=>$dt["PT_GROUP"], 
			"ptName1"=>$dt["PT_NAME1"], 
			"ptName2"=>$dt["PT_NAME2"], 
			"ptName3"=>$dt["PT_NAME3"], 
			"ptDate"=>$dt["PT_DATE"]
			);

		$json["apiCode"]=$apicode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>