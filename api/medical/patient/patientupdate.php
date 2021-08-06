<?php  
	///환자관리> 환자등록
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$seq=$_POST["seq"];

	if($apiCode!="patientupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="patientupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$me_company=$_POST["medicalid"]; //한의원번호 
		$me_chartno=$_POST["meChartno"]; //차트번호
		$me_name=$_POST["meName"];//이름
		$me_birth=$_POST["meBirth0"]."-".$_POST["meBirth1"]."-".$_POST["meBirth2"]; //생년월일
		$me_phone=$_POST["mePhone0"]."-".$_POST["mePhone1"]."-".$_POST["mePhone2"]; //연락처
		$me_mobile=$_POST["meMobile0"]."-".$_POST["meMobile1"]."-".$_POST["meMobile2"]; //휴대폰
		$me_zipcode=$_POST["meZipcode"]; //우편번호
		$me_address=$_POST["meAddress"]."||".$_POST["meAddress1"];///주소 
		$me_sex=$_POST["meSex"]; //성별
		$me_remark=$_POST["meRemark"]; //기타		

		$me_doctor=$_POST["ck_meUserId"]; //환자를등록한한의사		

		$me_userid=randno(10);
		
		if($seq)
		{			
			$sql=" update ".$dbH."_user set me_company ='".$me_company."' ,me_chartno ='".$me_chartno."',me_name ='".$me_name."',me_birth ='".$me_birth."',me_phone ='".$me_phone."',me_mobile ='".$me_mobile."',me_zipcode ='".$me_zipcode."',me_address ='".$me_address."' ,me_sex ='".$me_sex."', me_remark ='".$me_remark."', me_modify=SYSDATE where me_seq='".$seq."'";
			dbcommit($sql);		
			

		}
		else  ///신규입력
		{
			$sql2=" insert into ".$dbH."_user (me_seq,me_company,me_chartno,me_userid,me_name,me_birth,me_sex,me_phone,me_mobile,me_zipcode,me_address,me_remark,me_doctor,me_date) ";
			$sql2.=" values ((SELECT NVL(MAX(me_seq),0)+1 FROM ".$dbH."_user) ";
			$sql2.=" ,'".$me_company."','".$me_chartno."','".$me_userid."','".$me_name."','".$me_birth."','".$me_sex."','".$me_phone."','".$me_mobile."','".$me_zipcode."','".$me_address."','".$me_remark."','".$me_doctor."', SYSDATE) ";
			dbcommit($sql2);
		}
			$returnData=$_POST["returnData"];
			$json=array("apiCode"=>$apiCode,"seq"=>$seq,"returnData"=>$returnData);
			$json["sql"]=$sql;			
			$json["sql2"]=$sql2;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
	}

?>
