<?php  //라벨출력 
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$od_code=$_GET["code"];

	if($apicode!="releaselabel"){$json["resultMessage"]="API(apicode) ERROR";$apicode="releaselabel";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//$od_code="ODD2021030514295300001";
		$sql=" select 
		a.OD_CODE, a.OD_NAME, a.OD_PACKCAPA, a.OD_PACKCNT, b.MA_STAFFID, to_char(b.MA_MODIFY, 'yyyy-mm-dd hh24:mi:ss') as maDate, c.ST_NAME, d.RE_MOBILE
		, e.PATIENTCODE, e.PATIENTGENDER, e.PATIENTBIRTH, to_char(e.ORDERDATE, 'yyyy-mm-dd') as CLIENTORDERDATE, e.WARDNO, e.ROOMNO, e.BEDNO, e.MEDIDAYS, e.MEDITYPE, e.MEDICAPA, e.MEDINAME, e.MEDIADVICE 
		from han_order 
		a inner join han_making b on b.MA_KEYCODE=a.OD_KEYCODE 
		inner join han_release d on d.RE_KEYCODE=a.OD_KEYCODE 
		left join han_staff c on c.ST_STAFFID=b.MA_STAFFID
		left join han_order_client e on e.KEYCODE=a.OD_KEYCODE
		where a.od_code='".$od_code."' ";
		$dt=dbone($sql);

		//일단은 일반처방만 작업하기 

		/*
		//일반처방
		환자명
		용량 : 팩용량 팩수
		용법 : 복약안내문 참고
		조제일자 : 조제 완료시간
		복용기간 : 조제일로부터 3개월 이내
		조제자명 : 임성한약사 making MA_STAFFID
		탕전실명:부산대학교한방병원 원외탕전실(경남 양산시 물급읍 금오로20)
		조제번호:ODD - 숫자만 
		QR
		*/

		$mobile=($dt["RE_MOBILE"])?substr($dt["RE_MOBILE"], -4):"5555";
		$code=str_replace("ODD","",$dt["OD_CODE"]);
		$key=$code."|".$mobile;
		$reportkey = djEncrypt($key, $labelAuthkey);

		//$dekey = djDecrypt($reportkey, $labelAuthkey);

		//e.PATIENTCODE , e.WARDNO, e.ROOMNO, e.BEDNO, e.MEDIDAYS, e.MEDITYPE, e.MEDICAPA, e.MEDINAME, e.MEDIADVICE 
		$diagnosisName="일반";
		$diagnosisCode="general";
		if($dt["PATIENTCODE"])
		{
			$diagnosisName=($dt["ROOMNO"]=="-" || $dt["ROOMNO"]=="") ? "외래":"입원";
			$diagnosisCode=($dt["ROOMNO"]=="-" || $dt["ROOMNO"]=="") ? "outpatient":"admission";
			
			$patientage=calcAge($dt["PATIENTBIRTH"]);
		}

		$prtDate=date("m-d H:i");
		
		$json=array(
			"odCode"=>$dt["OD_CODE"],
			"odName"=>$dt["OD_NAME"],
			"odPackcapa"=>$dt["OD_PACKCAPA"],
			"odPackcnt"=>$dt["OD_PACKCNT"],
			"maStaffid"=>$dt["MA_STAFFID"],
			"msStaffName"=>$dt["ST_NAME"],
			"diagnosisCode"=>$diagnosisCode,
			"diagnosisName"=>$diagnosisName,
			"patientcode"=>$dt["PATIENTCODE"],
			"patientgender"=>$dt["PATIENTGENDER"],
			"patientbirth"=>$dt["PATIENTBIRTH"],
			"patientage"=>$patientage,
			"wardno"=>$dt["WARDNO"],
			"roomno"=>$dt["ROOMNO"],
			"bedno"=>$dt["BEDNO"],
			"medidays"=>$dt["MEDIDAYS"],
			"meditype"=>$dt["MEDITYPE"],
			"medicapa"=>$dt["MEDICAPA"],
			"mediname"=>$dt["MEDINAME"],
			"mediadvice"=>$dt["MEDIADVICE"],
			"clientorderdate"=>$dt["CLIENTORDERDATE"],
			"prtDate"=>$prtDate,


			//"key"=>$key,
			"reportkey"=>$code,
			//"labelAuthkey"=>$labelAuthkey,
			//"dekey"=>$dekey,
			"maDate"=>$dt["MADATE"]
			);

		$json["sql"]=$sql;
		$json["apiCode"]=$apicode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}		

?>
