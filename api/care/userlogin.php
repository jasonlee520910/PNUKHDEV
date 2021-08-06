<?php
	$apicode=$resjson["apiCode"];
	$language=$resjson["language"];
	$me_loginid=addslashes($resjson["loginId"]);
	$me_passwd=addslashes($resjson["loginPw"]);
	if($apicode!="userlogin"){$json["resultMessage"]="API코드오류";$apicode="userlogin";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($me_loginid==""){$json["resultMessage"]="아이디없음";}
	else if($me_passwd==""){$json["resultMessage"]="비밀번호없음";}
	else{
		$returnData=$resjson["returnData"];

		$sql=" select a.*  from ".$dbH."_user a where me_loginid='".$me_loginid."' and me_passwd=password('".$me_passwd."') ";
		$json["sql"]=$sql;
		$dt=dbone($sql);
		if($dt["me_seq"]){
			$sql=" update ".$dbH."_user set me_latest=now() where me_seq='".$dt["me_seq"]."'";
			dbqry($sql);
			$json=array("seq"=>$dt["me_seq"], "meUserid"=>$dt["me_userid"], "meLoginid"=>$dt["me_loginid"], "meName"=>$dt["me_name"], "meGrade"=>$dt["me_grade"], "meUse"=>$dt["me_use"]);
			$json["apiCode"]=$apicode;
			$json["returnData"]=$returnData;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}else{
			$json["resultCode"]="204";
			$json["resultMessage"]="회원정보가 없습니다";
		}
	}
?>