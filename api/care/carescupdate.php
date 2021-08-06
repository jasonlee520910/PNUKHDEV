<?php
	$apicode=$resjson["apiCode"];
	$language=$resjson["language"];
	$uc_userid=$resjson["meUserid"];
	if($apicode!="carescupdate"){$json["resultMessage"]="API코드오류";$apicode="carescupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($uc_userid==""){$json["resultMessage"]="아이디없음";}
	else{
		$returnData=$resjson["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$uc_seq=$resjson["seq"];
		$uc_rccode=$resjson["ucRccode"];
		$uc_odcode=$resjson["ucOdcode"];
		$uc_schedule=$resjson["ucSchedule"];
		if($uc_seq){
			$sql=" update ".$dbH."_usercare set uc_schedule='".$uc_schedule."' where uc_seq='".$me_seq."' ";
			dbqry($sql);
			$json["resultCode"]="200";
			$json["resultMessage"]="복약스케쥴이 등록 되었습니다.";
		}else{
			$sql=" insert into ".$dbH."_usercare (uc_rccode, uc_odcode , uc_userid ,uc_date) values ('".$uc_rccode."','".$uc_odcode."','".$uc_userid."',now()) ";
			dbqry($sql);
			$json["resultCode"]="200";
			$json["resultMessage"]="복약정보가 등록 되었습니다.";
		}
//echo $sql;
		$json["sql"]=$sql.$me_passwd.$me_passwd2;
	}
?>