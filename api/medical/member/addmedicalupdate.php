<?php ///
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$me_loginid=$_POST["meLoginId"];
	$medicalId=$_POST["medicalid"]; ///mi_userid &  me_company
	$doctorId=$_POST["doctorId"];

	if($apiCode!="addmedicalupdate"){$json["resultMessage"]="API코드오류2";$apiCode="addmedicalupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else
	{
		///들어오는 데이터 
		$me_seq=$_POST["seq"];

		/* 한의원 정보 */
		//$mi_userid=$_POST["stUserId"]; ///한의원아이디
		$mi_name=$_POST["miName"]; ///한의원이름

		$mi_ceo=$_POST["miCeo"]; ///대표자명
		//$mi_businessno=$_POST["miBusinessno0"]."-".$_POST["miBusinessno1"]."-".$_POST["miBusinessno2"];; ///사업자번호
		$mi_businessno=$_POST["miBusinessno0"]; ///사업자번호

		$mi_address=$_POST["miAddress"]."||".$_POST["miAddress1"];///주소 
		$mi_zipcode=$_POST["miZipcode"]; ///우편번호
		$mi_phone=$_POST["miPhone0"]."-".$_POST["miPhone1"]."-".$_POST["miPhone2"];  ///전화번호
		$mi_fax=$_POST["miFax0"]."-".$_POST["miFax1"]."-".$_POST["miFax2"]; ///팩스번호

		$mi_email=$_POST["miEmail0"]; ///한의원 email

		$mi_agreedate=$_POST["agreetime2"]; //약관동의시간
		

		if($medicalId)
		{
			///의료기관정보수정			
			$sql=" update ".$dbH."_medical set  mi_name='".$mi_name."', mi_ceo='".$mi_ceo."',mi_businessno='".$mi_businessno."',mi_zipcode='".$mi_zipcode."' ";
			$sql.=" ,mi_address='".$mi_address."',mi_email='".$mi_email."',mi_phone='".$mi_phone."' ,mi_fax='".$mi_fax."' ,mi_modify=sysdate ";
			$sql.=" where mi_userid='".$medicalId."' ";
			//echo $sql;
			dbcommit($sql);			
		}
		else  //한의사등록후 나중에 한의원을 등록했을경우
		{
			$mi_userid=randno(10);

			///의료기관정보수정			
			$sql=" update ".$dbH."_member set  me_company='".$mi_userid."' ,me_modify=sysdate ";
			$sql.=" where me_userid='".$doctorId."' ";
			//echo $sql;
			dbcommit($sql);		


			$sql3=" insert into ".$dbH."_medical (mi_seq,mi_ceo,mi_email,mi_agreedate,mi_userid, mi_name, mi_businessno, mi_address, mi_zipcode, mi_phone, mi_fax, mi_status, mi_date) ";
			$sql3.=" values ((SELECT NVL(MAX(mi_seq),0)+1 FROM ".$dbH."_medical),'".$mi_ceo."','".$mi_email."','".$mi_agreedate."','".$mi_userid."','".$mi_name."','".$mi_businessno."','".$mi_address."','".$mi_zipcode."','".$mi_phone."','".$mi_fax."','apply', sysdate) ";

			//echo $sql3;
			dbcommit($sql3);			
		}

		$json["sql"]=$sql;	
		$json["sql3"]=$sql3;		
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";	
		$json["apiCode"]=$apiCode;		
	}
?>