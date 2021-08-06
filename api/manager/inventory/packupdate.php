<?php  
	/// 자재코드관리 > 포장기관리 > 등록 & 수정
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$pa_seq=$_POST["seq"];

	if($apicode!="packupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="packupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($pa_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$pa_model=$_POST["paModel"];
		$pa_title=$_POST["paTitle"];
		$pa_locate=$_POST["paLocate"];
		$pa_code=$_POST["paCode"];

		$pa_top=$_POST["paTop"];
		$pa_left=$_POST["paLeft"];	

		if($pa_code=="add")
		{
			$pa_code="PCM".date("ymdHis");
		}

		if($pa_seq&&$pa_seq!="add")
		{
			$sql=" update ".$dbH."_packing set pa_model='".$pa_model."', pa_top='".$pa_top."', pa_left='".$pa_left."', pa_title='".$pa_title."', pa_locate='".$pa_locate."', pa_staff='".$pa_staff."', pa_date=SYSDATE where pa_seq='".$pa_seq."' ";
		}
		else
		{
			$sql=" insert into ".$dbH."_packing (pa_seq,pa_code,pa_odcode,pa_model,pa_top, pa_left, pa_title,pa_locate,pa_status,pa_staff,pa_use,pa_date) values ((SELECT NVL(MAX(pa_seq),0)+1 FROM ".$dbH."_packing),'".$pa_code."','','".$pa_model."','".$pa_top."','".$pa_left."','".$pa_title."','".$pa_locate."','standby','".$pa_staff."','Y',SYSDATE) ";
		}

		dbcommit($sql);

		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["sql"]=$sql;
	}
?>