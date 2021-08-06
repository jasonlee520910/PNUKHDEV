<?php  
	///사용자관리 > 한의원관리 상세보기
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mi_userid=$_GET["userid"];

	if($apiCode!="medicaldesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicaldesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$hCodeList = getNewCodeTitle("meStatus,meGrade,miGrade,miDelivery");

		$meStatusList = getCodeList($hCodeList, 'meStatus');
		$meGradeList = getCodeList($hCodeList, 'meGrade');
		$miGradeList = getCodeList($hCodeList, 'miGrade');
		$miDeliveryList = getCodeList($hCodeList, 'miDelivery');  
		
		$returnData=$_GET["returnData"];

		///한의원 정보 가져오기 
		$sql=" select * from ".$dbH."_medical where mi_userid = '".$mi_userid."' and mi_use = 'Y' ";
		$dt=dbone($sql);

		if($dt["MI_SEQ"]) ///한의원이 사용중이거나 있으면 한의사 리스트 보여주자 
		{ 
			$addr = explode("||", $dt["MI_ADDRESS"]);///주소 
			$phone = explode("-", $dt["MI_PHONE"]);///전화번호 
			$fax = explode("-", $dt["MI_FAX"]);///팩스번호 
			$persion = ($dt["MI_PERSION"]) ? $dt["MI_PERSION"] : "-";

			///한의원 정보 
			$json=array(
				"seq"=>$dt["MI_SEQ"],
				"miGrade"=>$dt["MI_GRADE"], ///한의원등급 A,B,C,D,E
				"miStatus"=>$dt["MI_STATUS"],
				"miUserid"=>$dt["MI_USERID"],
				"miName"=>$dt["MI_NAME"],
				"miBusinessNo"=>$dt["MI_BUSINESSNO"], ///사업자번호		
				"miZipcode"=>$dt["MI_ZIPCODE"], ///우편번호
				"miDelivery"=>$dt["MI_DELIVERY"], ///배송회사

				"miAddress"=>$addr[0], ///환자주소
				"miAddress1"=>$addr[1], ///환자주소

				"miPhone0"=>$phone[0], ///전화번호
				"miPhone1"=>$phone[1], ///전화번호
				"miPhone2"=>$phone[2], ///전화번호

				"miFax0"=>$fax[0], ///팩스번호
				"miFax1"=>$fax[1], ///팩스번호
				"miFax2"=>$fax[2], ///팩스번호

				"miDeliveryList"=>$miDeliveryList,  ///배송회사('lozen','post','direct')
				"miGradeList"=>$miGradeList,  ///한의원등급 A,B,C,D,E
				"meStatusList"=>$meStatusList,///회원상태(대기,승인,탈퇴,차단)
				"meGradeList"=>$meGradeList ///소속한의사의 회원구분 (원장,한의사,간호사등)
			);

			///소속한의사 리스트 
			$sql2=" select b.me_auth, b.me_seq, b.me_userid, b.me_grade, b.me_loginid, b.me_registno, b.me_name,to_char(b.me_date, 'yyyy-mm-dd') as MIDATE ";
			$sql2.=" ,c.cd_name_".$language." as CD_NAME";
			$sql2.=" from ".$dbH."_member b";
			$sql2.=" LEFT JOIN ".$dbH."_code c ON b.me_grade = c.cd_code and c.cd_type='member' ";
			$sql2.=" where b.me_company = '".$mi_userid."' and b.me_use = 'Y' ";			
			$res=dbqry($sql2);

			$json["member"] = array();
			while($dt=dbarr($res))
			{
				$addarray=array(
					"meSeq"=>$dt["ME_SEQ"], 
					"meUserid"=>$dt["ME_USERID"], 
					"meGrade"=>$dt["ME_GRADE"], ///회원구분
					"meGradetxt"=>$dt["CD_NAME"], ///회원구분TEXT
					"meLoginid"=>$dt["ME_LOGINID"], ///사용자아이디
					"meAuth"=>$dt["ME_AUTH"], ///의사PK
					"meName"=>$dt["ME_NAME"],
					"meDate"=>$dt["MIDATE"]
				);
				array_push($json["member"], $addarray);
			}
		}
		else
		{
			///한의원 정보 
			$json=array(
				"miDeliveryList"=>$miDeliveryList,  ///배송회사('lozen','post','direct')
				"miGradeList"=>$miGradeList,  ///한의원등급 A,B,C
				"meStatusList"=>$meStatusList,///회원상태(대기,승인,탈퇴,차단)
				"meGradeList"=>$meGradeList ///소속한의사의 회원구분 (원장,한의사,간호사등)
			);
		}

		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>

