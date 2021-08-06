<?php  
	///환자관리 > 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$medicalid=$_GET["medicalid"]; ///mi_userid &  me_company

	$listtype=$_GET["listtype"]; ///전체리스트인지 소속한의사의 환자만 부분적으로 나오는 리스트인지 (all,mine)

	$ck_meUserId=$_GET["ck_meUserId"];//처방의사ck_meUserId
	

	if($apiCode!="patientlist"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="patientlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];

		$searchtxt=$_GET["searchTxt"]; //검색단어

		$json=array("apiCode"=>$apiCode,"search"=>$search,"returnData"=>$returnData);
	

		if($listtype=="mine")  //소속한의사가 처방을 볼때
		{

			$jsql=" a ";
			$jsql.=" left join ".$dbH."_order_medical b on a.me_userid=b.patientcode ";

			$wsql=" where a.me_use <>'D'  and (a.me_doctor='".$ck_meUserId."' or b.doctorcode='".$ck_meUserId."') ";
			//$wsql=" and b.medicalcode='".$medicalid."' ";


			if($searchtxt)
			{
				$wsql.=" and ( ";
				$wsql.=" a.me_name like '%".$searchtxt."%' ";///이름
				$wsql.=" or a.me_mobile like '%".$searchtxt."%' ";///휴대폰
				$wsql.=" ) ";
			}

			$wsql.=" group by b.patientcode,b.patientname ,a.me_seq,a.me_company,a.me_chartno,a.me_name,a.me_birth,a.me_sex,a.me_phone,a.me_mobile,a.me_userid,to_char(a.me_date,'yyyy-mm-dd')";


			$pg=apipaging("a.me_seq","user",$jsql,$wsql);

			$sql=" select * from (";
			$sql.=" select row_number() over (order by b.patientcode desc) num ";	
			$sql.=" ,a.me_seq,a.me_company,a.me_chartno,a.me_name,a.me_birth,a.me_sex,a.me_phone,a.me_mobile,a.me_userid ";	
			$sql.=" ,b.patientcode,b.patientname "; 
			$sql.=" ,to_char(a.me_date,'yyyy-mm-dd') as me_date ";		
			$sql.=" from ".$dbH."_user $jsql $wsql  ";		
			$sql.=" order by b.patientcode DESC ";
			$sql.=" ) where num>".$pg["snum"]." and num<=".$pg["tlast"]; 

		}
		else
		{
			$jsql=" a ";
			$wsql=" where a.me_use <>'D' and  a.me_company ='".$medicalid."' ";

			if($searchtxt)
			{
				$wsql.=" and ( ";
				$wsql.=" a.me_name like '%".$searchtxt."%' ";///이름
				$wsql.=" or a.me_mobile like '%".$searchtxt."%' ";///휴대폰
				$wsql.=" ) ";
			}

			$pg=apipaging("a.me_seq","user",$jsql,$wsql);

			$sql=" select * from (";
			$sql.=" select row_number() over (order by a.me_seq desc) num ";	
			$sql.=" ,a.me_seq,a.me_company,a.me_chartno,a.me_name,a.me_birth,a.me_sex,a.me_phone,a.me_mobile,a.me_userid ";		
			$sql.=" ,to_char(a.me_date,'yyyy-mm-dd') as me_date ";		
			$sql.=" from ".$dbH."_user $jsql $wsql  ";		
			$sql.=" order by a.me_seq DESC ";
			$sql.=" ) where num>".$pg["snum"]." and num<=".$pg["tlast"]; 

		}

		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["search"]=$searchtxt;
		$json["list"]=array();



		while($dt=dbarr($res))
		{
			if($dt["ME_SEX"]=="male"){$ME_SEX="남자";}else{$ME_SEX="여자";}

			$addarray=array(
				"Btn"=>"<button type='button' class='btn bg-blue color-white radius' style='font-size:12px;padding:3px 5px;height:30px;background:#04B486;' onclick='reorder(".$dt['ME_USERID'].",\"".$dt['ME_NAME']."\",\"\");'>진료기록</button>",
				"seq"=>$dt["ME_SEQ"], ///seq

				"me_userid"=>$dt["ME_USERID"],			
				"meCompany"=>$dt["ME_COMPANY"], ///
				"meChartno"=>$dt["ME_CHARTNO"], ///차트번호
				"meName"=>$dt["ME_NAME"], ///환자명	
				"meSex"=>$ME_SEX, ///성별
				"meBirth"=>$dt["ME_BIRTH"], ///생년월일
				"meMobile"=>$dt["ME_MOBILE"], ///휴대전화
				"meDate"=>$dt["ME_DATE"] ///
				
					);
			array_push($json["list"], $addarray);

		}

		//$json["wsql"]=$wsql;
		$json["medicalid"]=$medicalid;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

		$json["listtype"]=$listtype;
		

	}
?>