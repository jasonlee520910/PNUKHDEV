<?php
	/// 환경설정 > 코드관리 > 상세 > 서브코드 업데이트 
	$json["resultCode"]="204";
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$cd_type=$_POST["cdType"];

	if($apicode!="subcodeupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="subcodeupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($cd_type==""){$json["resultMessage"]="API(cdType) ERROR";}
	else{
		$cd_seq=$_POST["seq"];
		$cd_code=$_POST["cdCode"];
		$cd_sort=$_POST["cdSort"];
		$cd_name_kor=$_POST["cdNamekor"];
		$cd_name_chn=$_POST["cdNamechn"];
		$cd_value_kor=$_POST["cdValuekor"];
		$cd_value_chn=$_POST["cdValuechn"];
		$returnData=$_POST["returnData"];

		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		
		/// 수정이라면 
		if($cd_seq)
		{
			$sql=" update ".$dbH."_code set cd_code='".$cd_code."',cd_sort='".$cd_sort."', cd_name_kor='".$cd_name_kor."',cd_name_chn='".$cd_name_chn."',cd_value_kor='".$cd_value_kor."',cd_value_chn='".$cd_value_chn."',cd_modify=sysdate where cd_seq='".$cd_seq."'";
			dbcommit($sql);
			$json["sql"]=$sql;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
		else
		{
			$sql="select cd_seq from ".$dbH."_code where cd_type='".$cd_type."' and  cd_code='".$cd_code."' and cd_use='Y'";
			$dt=dbone($sql);
			if($dt["CD_SEQ"])
			{
				$json["resultCode"]="204";
				$json["resultMessage"]="중복코드(".$cd_code.")";
			}
			else
			{
				$sql=" select * from (";
				$sql.=" select ROW_NUMBER() OVER (ORDER BY cd_type desc) NUM ";
				$sql.=", CD_TYPE, CD_TYPE_KOR, CD_TYPE_CHN, CD_TYPE_ENG ";
				$sql.=", CD_DESC_KOR as cdDescKor ";
				$sql.=", CD_DESC_CHN as cdDescChn ";
				$sql.=", CD_DESC_ENG as cdDescEng ";
				$sql.=" from ".$dbH."_code ";
				$sql.=" where cd_type='".$cd_type."' ";
				$sql.=" ) where NUM=1 ";
				$dt=dbone($sql);

				$json["sql"]=$sql;

				$sql=" insert into ".$dbH."_code (cd_seq, cd_type,cd_type_kor,cd_type_chn,cd_type_eng,cd_desc_kor,cd_desc_chn,cd_desc_eng,cd_code,cd_sort,cd_name_kor,cd_name_chn,cd_value_kor,cd_value_chn,cd_date) values ((SELECT NVL(MAX(cd_seq),0)+1 FROM ".$dbH."_code),'".$dt["CD_TYPE"]."','".$dt["CD_TYPE_KOR"]."','".$dt["CD_TYPE_CHN"]."','".$dt["CD_TYPE_ENG"]."','".getClob(
$dt["CDDESCKOR"])."','".getClob(
$dt["CDDESCCHN"])."','".getClob(
$dt["CDDESCENG"])."','".$cd_code."','".$cd_sort."','".$cd_name_kor."','".$cd_name_chn."','".$cd_value_kor."','".$cd_value_chn."',sysdate)";
				dbcommit($sql);
				$json["isql"]=$sql;
				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}
		}
	}
?>