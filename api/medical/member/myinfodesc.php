<?php ///한의원 상세
	///GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$medicalid=$_GET["medicalid"];//한의원ID 
	$meUserId=$_GET["meUserId"];//한의사ID
	

	if($apiCode!="myinfodesc"){$json["resultMessage"]="API코드오류";$apiCode="myinfodesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else
	{
		$msql="select 
			mi_seq,mi_userid, mi_name, mi_businessno, mi_address, mi_zipcode, mi_phone, mi_fax,mi_ceo,mi_email 
			from ".$dbH."_medical 
			where mi_userid='".$medicalid."' ";
		$mdt=dbone($msql);


		$mephone = explode("-", $mdt["MI_PHONE"]);
		$addr = explode("||", $mdt["MI_ADDRESS"]);

		$json=array(
			//한의원정보
			"mi_seq"=>$mdt["MI_SEQ"],
			"mi_userid"=>$mdt["MI_USERID"],
			"mi_name"=>$mdt["MI_NAME"],
			"mi_businessno"=>$mdt["MI_BUSINESSNO"],
			"miAddress"=>$addr[0],
			"miAddress1"=>$addr[1],
			"mi_zipcode"=>$mdt["MI_ZIPCODE"],
			"miPhone0"=>$mephone[0],
			"miPhone1"=>$mephone[1],
			"miPhone2"=>$mephone[2]
			);

		//한의사정보 
		$sql="select 
			me_seq, me_company,me_userid, me_name, me_loginid, me_businessmobile, me_businessemail,me_registno,me_mobile,me_email 
			from ".$dbH."_member 
			where me_userid='".$meUserId."' ";
		$dt=dbone($sql);
		$me_mobile=$dt["ME_MOBILE"];


		$json["me_mobile"]=$me_mobile;


		/*
		//한의사정보 
		$sql="select 
			me_seq, me_company,me_userid, me_name, me_loginid, me_businessmobile, me_businessemail,me_registno,me_mobile,me_email 
			from ".$dbH."_member 
			where me_userid='".$meUserId."' ";
		$dt=dbone($sql);

			$me_seq=$dt["ME_SEQ"];
			$me_company=$dt["ME_COMPANY"];
			$me_userid=$dt["ME_USERID"];
			$me_name=$dt["ME_NAME"];
			$me_loginid=$dt["ME_LOGINID"];
			$me_businessmobile=$dt["ME_BUSINESSMOBILE"];
			$me_businessemail=$dt["ME_BUSINESSEMAIL"];
			$me_registno=$dt["ME_REGISTNO"];
			$me_mobile=$dt["ME_MOBILE"];
			$me_email=$dt["ME_EMAIL"];

		//한의원정보 
		$msql="select 
			mi_seq,mi_userid, mi_name, mi_businessno, mi_address, mi_zipcode, mi_phone, mi_fax,mi_ceo,mi_email 
			from ".$dbH."_medical 
			where mi_userid='".$me_company."' ";
		$mdt=dbone($msql);

			$mi_seq=$mdt["MI_SEQ"];
			$mi_userid=$mdt["MI_USERID"];
			$mi_name=$mdt["MI_NAME"];
			$mi_businessno=$mdt["MI_BUSINESSNO"];
			$mi_address=$mdt["MI_ADDRESS"];
			$mi_zipcode=$mdt["MI_ZIPCODE"];
			$mi_phone=$mdt["MI_PHONE"];
			$mi_fax=$mdt["MI_FAX"];
			$mi_ceo=$mdt["MI_CEO"];
			$mi_email=$mdt["MI_EMAIL"];

		//정리해서 데이터 보내자 
		//한의원 
		$addr = explode("||", $mi_address);///주소 
		$phone = explode("-", $mi_phone);///전화번호 
		$fax = explode("-", $mi_fax);///팩스번호 
		$mibusinessno = explode("-", $mi_businessno);///
		$miemail = explode("@", $mi_email);						

		//한의사 
		$mebusinessemail = explode("@", $me_businessemail);///개인 이메일
		$mephone = explode("-", $me_businessmobile);///팩스번호 

		$json=array(
			//한의사 정보 
			"seq"=>$me_seq,
			"me_company"=>$me_company,
			"me_userid"=>$me_userid,
			"me_name"=>$me_name,
			"me_loginid"=>$me_loginid,
			"me_businessmobile"=>$me_businessmobile,
			"me_businessemail"=>$me_businessemail,
			"me_registno"=>$me_registno,
			"me_mobile"=>$me_mobile,
			"me_email"=>$me_email,

			"mebusinessemail0"=>$mebusinessemail[0], 
			"mebusinessemail1"=>$mebusinessemail[1], 

			"mephone0"=>$mephone[0], ///전화번호
			"mephone1"=>$mephone[1], ///전화번호
			"mephone2"=>$mephone[2], ///전화번호
			
			//한의원정보 		
			"mi_seq"=>$mi_seq,
			"mi_userid"=>$mi_userid,
			"mi_name"=>$mi_name,
			"mi_businessno"=>$mi_businessno,
			"mi_address"=>$mi_address,
			"mi_zipcode"=>$mi_zipcode,
			"mi_phone"=>$mi_phone,
			"mi_fax"=>$mi_fax,
			"mi_ceo"=>$mi_ceo,
			"mi_email"=>$mi_email,

			"mibusinessno0"=>$mibusinessno[0], 
			"mibusinessno1"=>$mibusinessno[1], 
			"mibusinessno2"=>$mibusinessno[2], 

			"miemail0"=>$miemail[0], 
			"miemail1"=>$miemail[1], 

			"miAddress"=>$addr[0], ///주소
			"miAddress1"=>$addr[1], ///주소

			"miPhone0"=>$phone[0], ///전화번호
			"miPhone1"=>$phone[1], ///전화번호
			"miPhone2"=>$phone[2], ///전화번호

			"miFax0"=>$fax[0], ///팩스번호
			"miFax1"=>$fax[1], ///팩스번호
			"miFax2"=>$fax[2] ///팩스번호
		);


		$metype=$_GET["metype"];
		
		$json["metype"]=$metype;
		$json["sql"]=$sql;
		$json["msql"]=$msql;
		$json["apiCode"]=$apiCode;
		
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";


		*/
		$json["apiCode"]=$apiCode;
		$json["returnData"]=$_GET["returnData"];
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}


?>