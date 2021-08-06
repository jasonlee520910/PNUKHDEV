<?php
	/// 환경설정 > 코드관리 > 상세 > 수정 
	$json["resultCode"]="204";
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$cd_type=$_POST["cdType"];

	if($apicode!="codeupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="codeupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($cd_type==""){$json["resultMessage"]="API(cdType) ERROR";}
	else
	{
		$cd_type=$_POST["cdType"];
		$cd_type_kor=$_POST["cdTypeTxtkor"];
		$cd_type_chn=$_POST["cdTypeTxtchn"];
		$cd_desc_kor=$_POST["cdDesckor"];
		$cd_desc_chn=$_POST["cdDescchn"];
		$returnData=$_POST["returnData"];

		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$sql="select cd_type from ".$dbH."_code where cd_type='".$cd_type."' and cd_use='Y'";
		$dt=dbone($sql);

		if($dt["CD_TYPE"])
		{
			$sql=" update ".$dbH."_code set cd_type='".$cd_type."',cd_type_kor='".$cd_type_kor."',cd_type_chn='".$cd_type_chn."', cd_desc_kor='".$cd_desc_kor."',cd_desc_chn='".$cd_desc_chn."',cd_modify=sysdate where cd_type='".$cd_type."'";
			dbcommit($sql);
		}
		else
		{
			$sql=" insert into ".$dbH."_code (cd_seq, cd_type,cd_type_kor,cd_type_chn, cd_code, cd_desc_kor,cd_desc_chn, cd_use, cd_date) values ((SELECT NVL(MAX(cd_seq),0)+1 FROM ".$dbH."_code),'".$cd_type."','".$cd_type_kor."','".$cd_type_chn."',' ','".$cd_desc_kor."','".$cd_desc_chn."','Y', sysdate )";
			dbcommit($sql);
		}

		//" insert into han_code (cd_type,cd_type_kor,cd_type_chn, cd_code, cd_desc_kor,cd_desc_chn, cd_use, cd_date) values ('codetest','123','345','','한글','중문','Y', now())"

		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>