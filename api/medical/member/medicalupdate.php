<?php ///회원가입 
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$doctorid=$_POST["doctorid"];
	$medicalId=$_POST["medicalid"]; ///mi_userid &  me_company

	if($apiCode!="medicalupdate"){$json["resultMessage"]="API코드오류2";$apiCode="medicalupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else
	{
		$json=array("apiCode"=>$apiCode);
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

		//$mi_email=$_POST["miEmail0"]."@".$_POST["miEmail1"]; ///한의원 email
		$mi_email=$_POST["miEmail0"]; ///한의원 email

		$mi_agreedate=$_POST["agreetime2"]; //약관동의시간
		
		/* 한의사 정보 */
		$json["joindata"]=$joindata=json_decode($_POST["join_jsondata"],true);
		$me_loginid=$joindata["stUserId"]; ///한의사 아이디
		$me_name=$joindata["stName"]; ///한의사 이름
		$me_passwd=$joindata["passwordDiv"]; ///한의사 비밀번호
		$me_mobile=$joindata["stMobile0"]."-".$joindata["stMobile1"]."-".$joindata["stMobile2"]; ///한의사 폰번호
		$me_email=$joindata["stEmail0"]."@".$joindata["stEmail1"]; ///한의사 email
		$me_registno=$joindata["licenseno"]; ///한의사 면허번호
		$mm_fileseq=$joindata["mmFileSeq"]; ///한의사 면허
		$meIsemail=$joindata["meIsemail"]; ///이메일수신동의여부

		if($meIsemail=="" || $meIsemail==null){$meIsemail="N";}

		if($medicalId || $doctorid)
		{
			if($medicalId)
			{
				///의료기관정보수정			
				$sql=" update ".$dbH."_medical set  mi_name='".$mi_name."', mi_businessno='".$mi_businessno."',mi_zipcode='".$mi_zipcode."' ";
				$sql.=" ,mi_address='".$mi_address."',mi_email='".$mi_email."',mi_fax='".$mi_fax."' ,mi_modify=sysdate ";
				$sql.=" where mi_userid='".$medicalId."' ";
				dbcommit($sql);
			}
			if($doctorid)
			{
				///내정보수정
				$sql2=" update ".$dbH."_member set me_name='".$me_name."',me_registno='".$me_registno."' ";
				$sql2.=" ,me_mobile='".$me_mobile."' ";
				$sql2.=" ,me_email='".$me_email."', me_modify=sysdate ";
				$sql2.=" where me_loginid='".$doctorid."' ";
				dbcommit($sql2);
			}
		}
		else
		{
			$me_grade="22";
			if($mi_name){
				/*한의원 정보 입력*/
				$mi_userid=randno(10);

				$sql3=" insert into ".$dbH."_medical (mi_seq,mi_ceo,mi_email,mi_agreedate,mi_userid, mi_name, mi_businessno, mi_address, mi_zipcode, mi_phone, mi_fax, mi_status, mi_date) ";
				$sql3.=" values ((SELECT NVL(MAX(mi_seq),0)+1 FROM ".$dbH."_medical),'".$mi_ceo."','".$mi_email."','".$mi_agreedate."','".$mi_userid."','".$mi_name."','".$mi_businessno."','".$mi_address."','".$mi_zipcode."','".$mi_phone."','".$mi_fax."','apply', sysdate) ";//이메일 인증전이고 회원가입만 한 상태 apply
				dbcommit($sql3);

				$me_grade="30";
			}

			$sql=" select count(me_loginid) cnt from ".$dbH."_member where me_loginid='".$me_loginid."'";
			$dt=dbone($sql);

		$json["logsql"]=$sql;
		$json["logCNT"]=$dt["CNT"];
		$json["me_loginid"]=$me_loginid;

			//if($dt["CNT"]>0){
			if($dt["CNT"]<=0){
				/*한의사 정보 입력*/
				$me_userid=randno(10);
				/// 회원가입시 등록하는 한의사는 me_grade 30(원장으로 등록함)
				$sql2="insert into ".$dbH."_member(me_seq,me_isemail,me_grade,me_company,me_userid, me_name, me_loginid,me_passwd, me_mobile, me_email,me_registno,me_status, me_date)";
				$sql2.=" values ((SELECT NVL(MAX(me_seq),0)+1 FROM ".$dbH."_member),'".$meIsemail."','".$me_grade."','".$mi_userid."','".$me_userid."','".$me_name."', '".$me_loginid."','".$me_passwd."','".$me_mobile."','".$me_email."','".$me_registno."','apply',sysdate) ";
				dbcommit($sql2);
			}

			//mm_fileseq
			if($mm_fileseq)
			{
				$fsql=" select ME_SEQ, ME_USERID from ".$dbH."_member where me_loginid ='".$me_loginid."' ";
				$json["fsql"]=$fsql;
				$fdt=dbone($fsql);
				if($fdt["ME_SEQ"])
				{
					$usql=" update ".$dbH."_file  set AF_FCODE='".$fdt["ME_SEQ"]."',  AF_USERID='".$fdt["ME_USERID"]."' where AF_SEQ='".$mm_fileseq."' ";
					dbcommit($usql);
					$json["usql"]=$usql;
				}
			}
		}

		
		$json["mm_fileseq"]=$mm_fileseq;
		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
		$json["sql3"]=$sql3;

		
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";		
	}
?>