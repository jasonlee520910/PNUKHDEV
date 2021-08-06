<?php  
	///환자관리 > 상세보기
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"]; ///

	if($apiCode!="patientdesc"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="patientdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if(!$seq){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$searchtxt=$_GET["searchTxt"]; //검색단어

		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
	
		$jsql=" a ";
		$wsql=" where a.me_seq ='".$seq."' ";


		$sql=" select ";	
		$sql.=" a.me_seq,a.ME_USERID,a.me_company,a.me_chartno,a.me_name,a.me_birth,a.me_sex,a.me_phone,a.me_mobile,a.me_remark,a.me_zipcode,a.me_address ";		
		$sql.=" ,to_char(a.me_date,'yyyy-mm-dd') as me_date ";
		$sql.=" from ".$dbH."_user $jsql $wsql  ";		

		$dt=dbone($sql);
		$json["sql"]=$sql;


		$me_birth=explode("-",$dt["ME_BIRTH"]);
		$me_phone=explode("-",$dt["ME_PHONE"]);
		$me_mobile=explode("-",$dt["ME_MOBILE"]);
		$meAddress=explode("||",$dt["ME_ADDRESS"]);	
		if($dt["ME_SEX"]=="male"){$meSexTxt="남성";}else{$meSexTxt="여성";}
		$me_company=$dt["ME_COMPANY"];
		$me_chartno=$dt["ME_CHARTNO"];
		$me_userid=$dt["ME_USERID"];
		$json=array(
			
			"seq"=>$dt["ME_SEQ"], ///seq
			"meCompany"=>$company, ///
			"meChartno"=>$me_chartno, ///차트번호
			"meName"=>$dt["ME_NAME"], ///환자명			
			"meSex"=>$dt["ME_SEX"], ///성별
			"meSexTxt"=>$meSexTxt, ///성별
			"meUserid"=>$me_userid,

			"meBirthDay"=>$me_birth[0]."-".$me_birth[1]."-".$me_birth[2], ///생년월일
			"meBirth0"=>$me_birth[0], ///생년월일
			"meBirth1"=>$me_birth[1], ///생년월일
			"meBirth2"=>$me_birth[2], ///생년월일

			"mePhone"=>$me_phone[0]."-".$me_phone[1]."-".$me_phone[2], ///연락처
			"mePhone0"=>$me_phone[0], ///연락처
			"mePhone1"=>$me_phone[1], ///연락처
			"mePhone2"=>$me_phone[2], ///연락처

			"meMobile"=>$me_mobile[0]."-".$me_mobile[1]."-".$me_mobile[2], ///휴대전화
			"meMobile0"=>$me_mobile[0], ///휴대전화
			"meMobile1"=>$me_mobile[1], ///휴대전화
			"meMobile2"=>$me_mobile[2], ///휴대전화

			"meRemark"=>getClob($dt["ME_REMARK"]), 

			"meZipcode"=>trim($dt["ME_ZIPCODE"]), 
			"meAddress"=>$meAddress[0]." ".$meAddress[1], 
			"meAddress0"=>$meAddress[0], 
			"meAddress1"=>$meAddress[1], 
	
			"meDate"=>$dt["ME_DATE"] ///
			);



		//$msql=" select * from ( select a.SEQ, a.KEYCODE, a.ORDERTITLE from han_order_medical a inner join han_order b on b.OD_KEYCODE=a.KEYCODE where a.medicalcode='".$me_company."' and a.patientcode='".$me_chartno."' and b.OD_USE<>'D' and b.OD_STATUS='done' order by a.indate desc  ) where ROWNUM = 1 ";
		//잠시임시 
		$msql=" select * from ( select a.SEQ, a.KEYCODE, a.ORDERTITLE from han_order_medical a inner join han_order b on b.OD_KEYCODE=a.KEYCODE where a.medicalcode='".$me_company."' and a.patientcode='".$me_chartno."' order by a.indate desc  ) where ROWNUM = 1 ";
		$mdt=dbone($msql);
		$lastseq=($mdt["SEQ"])?$mdt["SEQ"]:"";
		$lastkeycode=($mdt["KEYCODE"])?$mdt["KEYCODE"]:"";
		$lasttitle=($mdt["ORDERTITLE"])?$mdt["ORDERTITLE"]:"";


		$json["lastseq"]=$lastseq;
		$json["lastScript"]=$lasttitle;
		//$json["wsql"]=$wsql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}
?>