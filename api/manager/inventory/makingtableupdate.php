<?php  
	/// 자재코드관리 > 조제대관리 > 등록&수정
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$mt_seq=$_POST["seq"];
	if($apicode!="makingtableupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="makingtableupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mt_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$mt_code=$_POST["mtCode"];
		$returnData=$_POST["returnData"];
		if($mt_code=="add")
		{
			$sql2=" select mt_code from  ( select mt_code from ".$dbH."_makingtable order by mt_code desc) where rownum <= 1 ";
			$dt=dbone($sql2);
			$mtcode=sprintf("%05d",intval($dt["MT_CODE"]) + 1);
			$mt_code=$mtcode;
		}
		$mt_model=$_POST["mtModel"];
		$mt_title=$_POST["mtTitle"];
		$mt_locate=$_POST["mtLocate"];
		$mt_status=$_POST["mtStatus"];
		$mt_staff=$_POST["mtStaff"];
		
		if($mt_seq&&$mt_seq!="add")
		{
			$sql=" update ".$dbH."_makingtable set mt_model='".$mt_model."', mt_title='".$mt_title."', mt_locate='".$mt_locate."', mt_date=SYSDATE where mt_seq='".$mt_seq."' ";
		}
		else
		{
			$sql=" insert into ".$dbH."_makingtable (mt_seq,mt_code,mt_odcode,mt_model,mt_title,mt_locate,mt_status,mt_staff,mt_use,mt_date) values ((SELECT NVL(MAX(mt_seq),0)+1 FROM ".$dbH."_makingtable),'".$mt_code."','','".$mt_model."','".$mt_title."','".$mt_locate."','ready','','Y',SYSDATE) ";
		}
		dbcommit($sql);		
		
		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>