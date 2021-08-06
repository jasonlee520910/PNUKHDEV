<?php  
	/// 자재코드관리 > 탕전기관리 > 등록&수정
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$bo_seq=$_POST["seq"];

	if($apicode!="potupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="potupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($bo_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$bo_code=$_POST["boCode"];
		if($bo_code=="add")
		{			
			$sql2="select * from  ( select substr(bo_code, 4,10) as BOCODE from ".$dbH."_boiler order by bo_code desc) where rownum <= 1 ";
			$dt=dbone($sql2);
			$bocode=sprintf("%010d",intval($dt["BOCODE"]) + 1);
			$bo_code="BLR".$bocode;
		}
		$bo_model=$_POST["boModel"];
		$bo_title=$_POST["boTitle"];

		$bo_top=$_POST["boTop"];
		$bo_left=$_POST["boLeft"];	

		$bo_locate=$_POST["boLocate"];
		$bo_status=$_POST["boStatus"];
		$bo_staff=$_POST["boStaff"];

		if($bo_seq&&$bo_seq!="add")
		{
			$sql=" update ".$dbH."_boiler set bo_model='".$bo_model."', bo_top='".$bo_top."', bo_left='".$bo_left."', bo_title='".$bo_title."'";
			$sql.=", bo_locate='".$bo_locate."', bo_status='".$bo_status."', bo_staff='".$bo_staff."', bo_date=SYSDATE where bo_seq='".$bo_seq."' ";
		}
		else
		{
			$sql=" insert into ".$dbH."_boiler (bo_seq,bo_code,bo_odcode,bo_model,bo_top,bo_left, bo_title,bo_locate,bo_status,bo_staff,bo_use,bo_date) ";
			$sql.=" values ((SELECT NVL(MAX(bo_seq),0)+1 FROM ".$dbH."_boiler),'".$bo_code."','','".$bo_model."','".$bo_top."','".$bo_left."','".$bo_title."','".$bo_locate."','ready','".$bo_staff."','Y',SYSDATE) ";
		}
		dbcommit($sql);

		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["sql2"]=$sql2;
		$json["sql"]=$sql;
	}
?>