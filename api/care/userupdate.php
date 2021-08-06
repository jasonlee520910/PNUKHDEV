<?php
	$apicode=$resjson["apiCode"];
	$language=$resjson["language"];
	if($apicode!="userupdate"){$json["resultMessage"]="API코드오류";$apicode="userupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	//else if($me_loginid==""){$json["resultMessage"]="아이디없음";}
	else{
		$returnData=$resjson["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$me_seq=$resjson["seq"];
		$me_userid=$resjson["meUserId"];
		$me_email=$resjson["meEmail"];
		$me_loginid=$me_email;
		$me_name=$resjson["meName"];
		$me_zipcode=$resjson["meZipCode"];
		$me_address=$resjson["meAddress"];
		$me_phone=$resjson["mePhone"];
		$me_mobile=$resjson["meMobile"];
		$me_email=$resjson["meEmail"];
		$me_status=$resjson["meStatus"];

		$me_passwd=$resjson["mePassWd"];
		$me_passwd2=$resjson["mePassWd2"];
		if($me_seq){
			$sql=" update ".$dbH."_user set me_name='".$me_name."', me_zipcode='".$me_zipcode."', me_address='".$me_address."', me_phone='".$me_phone."', me_mobile='".$me_mobile."', me_email='".$me_email."', me_status='".$me_status."', me_modify=now() ";
			if($me_passwd&&($me_passwd==$me_passwd2)){
				$sql.=", me_passwd = password('".$me_passwd."') ";
			}
			$sql.=" where me_seq='".$me_seq."' ";
			dbqry($sql);
			$json["resultCode"]="200";
			$json["resultMessage"]="회원 정보 수정 되었습니다.";
		}else{
			$sql=" select me_seq from ".$dbH."_user where me_loginid='".$me_loginid."'";
			$dt=dbone($sql);
			if($dt["me_seq"]){
				$json["resultCode"]="204";
				$json["resultMessage"]="사용할수 없는 아이디/이메일 입니다.";
			}else{
				$me_userid=randno(15);
				$sql=" insert into ".$dbH."_user (me_userid, me_name ,me_loginid ,me_passwd ,me_zipcode ,me_address ,me_phone ,me_mobile ,me_email, me_status ,me_date) values ('".$me_userid."','".$me_name."','".$me_loginid."',password('".$me_passwd."'),'".$me_zipcode."','".$me_address."','".$me_phone."','".$me_mobile."','".$me_email."','".$me_status."',now()) ";
				dbqry($sql);
				$json["resultCode"]="200";
				$json["resultMessage"]="회원가입되었습니다.";
			}
		}
//echo $sql;
		$json["sql"]=$sql.$me_passwd.$me_passwd2;
	}
?>