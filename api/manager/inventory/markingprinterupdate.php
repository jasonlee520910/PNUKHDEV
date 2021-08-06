<?php  
	/// 자재코드관리 > 마킹프린터관리 > 등록 & 수정
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$mp_seq=$_POST["seq"];

	if($apicode!="markingprinterupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="markingprinterupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mp_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$mp_code=$_POST["mpCode"];
		$returnData=$_POST["returnData"];
		if($mp_code=="add")
		{
			$sql2=" select * from  ( select mp_code as MP_CODE from ".$dbH."_markingprinter order by mp_code desc) where rownum <= 1 ";
			$dt=dbone($sql2);
			$mpcode=sprintf("%05d",intval($dt["MP_CODE"]) + 1);
			$mp_code=$mpcode;
		}

		$mp_title=$_POST["mpTitle"];
		$mp_ip=$_POST["mpIp"];
		$mp_port=$_POST["mpPort"];

		if($mp_seq&&$mp_seq!="add")
		{
			$sql=" update ".$dbH."_markingprinter set mp_code='".$mp_code."', mp_title='".$mp_title."', mp_ip='".$mp_ip."',mp_port='".$mp_port."', mp_date=SYSDATE where mp_seq='".$mp_seq."' ";
		}
		else
		{
			$sql=" insert into ".$dbH."_markingprinter (mp_seq,mp_code,mp_title,mp_ip,mp_port,mp_use,mp_status,mp_date) values ((SELECT NVL(MAX(mp_seq),0)+1 FROM ".$dbH."_markingprinter),'".$mp_code."','".$mp_title."','".$mp_ip."','".$mp_port."','Y','ready',SYSDATE) ";
		}

		dbcommit($sql);

		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["sql"]=$sql;
		$json["sql2"]=$sql2;

	}
?>