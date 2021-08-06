<?php  
	///사용자관리 > 한의원관리 > 상세 보기 > 한의원 업데이트
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$me_loginid=$_POST["meLoginId"];

	if($apiCode!="medicalupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="medicalupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		///들어오는 데이터 
		$mi_seq=$_POST["seq"];
		$mi_seq=$_POST["seq"];
		$mi_userid=$_POST["miUserid"]; ///한의원아이디
		$mi_name=$_POST["miName"]; ///한의원이름
		$mi_businessno=$_POST["miBusinessNo"]; ///사업자번호
		$mi_address=$_POST["miAddress"]."||".$_POST["miAddress1"];///주소 
		$mi_zipcode=$_POST["miZipcode"]; ///우편번호

		$mi_zipcode=trim($mi_zipcode); ///우편번호

		$mi_phone=$_POST["miPhone0"]."-".$_POST["miPhone1"]."-".$_POST["miPhone2"];  ///전화번호
		$mi_fax=$_POST["miFax0"]."-".$_POST["miFax1"]."-".$_POST["miFax2"]; ///팩스번호

		$mi_grade=$_POST["miGrade"]; ///한의원등급
		$mi_status=$_POST["miStatus"]; ///회원상태

		$mi_delivery=$_POST["miDelivery"]; ///배송회사

		if($mi_seq)
		{
			$sql=" update ".$dbH."_medical set mi_name='".$mi_name."',mi_businessno='".$mi_businessno."',mi_zipcode='".$mi_zipcode."',mi_address='".$mi_address."',mi_phone='".$mi_phone."',mi_fax='".$mi_fax."',mi_status='".$mi_status."',mi_delivery='".$mi_delivery."',mi_grade='".$mi_grade."', mi_modify=sysdate where mi_userid='".$mi_userid."' ";
			dbcommit($sql);
		}
		else
		{
			$mi_userid=randno(10);

			$sql=" insert into ".$dbH."_medical (mi_seq,mi_name, mi_userid, mi_businessno ,mi_zipcode, mi_address ,mi_phone ,mi_fax, mi_status,mi_grade,mi_delivery, mi_date) values ((SELECT NVL(MAX(mi_seq),0)+1 FROM ".$dbH."_medical),'".$mi_name."','".$mi_userid."', '".$mi_businessno."', '".$mi_zipcode."', '".$mi_address."', '".$mi_phone."', '".$mi_fax."','".$mi_status."','".$mi_grade."','".$mi_delivery."', sysdate) ";
			dbcommit($sql);

		}

		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";		
	}
?>