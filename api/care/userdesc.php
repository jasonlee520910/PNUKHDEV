<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$me_userid=addslashes($_GET["meUserid"]);
	if($apicode!="userdesc"){$json["resultMessage"]="API코드오류";$apicode="userdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($me_userid==""){$json["resultMessage"]="아이디없음";}
	else{
		$returnData=$resjson["returnData"];

		$sql=" select a.*  from ".$dbH."_user a where me_userid='".$me_userid."' ";
		$json["sql"]=$sql;
		$dt=dbone($sql);
		if($dt["me_seq"]){
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