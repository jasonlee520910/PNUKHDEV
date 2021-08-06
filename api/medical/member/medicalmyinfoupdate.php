<?php 

/*//(TMPS)내정보수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$me_loginid=$_POST["meLoginId"];
	$medicalId=$_POST["medicalId"]; //mi_userid &  me_company

	if($apiCode!="medicalmyinfoupdate"){$json["resultMessage"]="API코드오류2";$apiCode="medicalmyinfoupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else
	{

		$mi_zipcode=$_POST["miZipcode"]; //우편번호
		$mi_address=$_POST["miAddress"]."||".$_POST["miAddress1"];//주소 
		
		$mi_phone=$_POST["miPhone0"]."-".$_POST["miPhone1"]."-".$_POST["miPhone2"];  //전화번호
		$mi_fax=$_POST["miFax0"]."-".$_POST["miFax1"]."-".$_POST["miFax2"]; //팩스번호

		/* 한의사 정보 */
		$me_businessmobile=$_POST["meBusinessmobile0"]."-".$_POST["meBusinessmobile1"]."-".$_POST["meBusinessmobile2"]; //한의사 폰번호
		$me_businessemail=$_POST["meBusinessemail"]; //한의사 email

		if($medicalId)
		{
			//myinfo 에서 정보수정할때
			$sql=" update ".$dbH."_medical set mi_zipcode='".$mi_zipcode."',mi_address='".$mi_address."',mi_phone='".$mi_phone."',mi_fax='".$mi_fax."' ,mi_modify=now() where mi_userid='".$medicalId."' ";
			dbqry($sql);

			$sql=" update ".$dbH."_member set me_businessmobile='".$me_businessmobile."', me_businessemail='".$me_businessemail."', me_modify=now() where me_company='".$medicalId."' ";
			dbqry($sql);
					
		}
		
		$json=array("apiCode"=>$apiCode);
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";		
	}
?>