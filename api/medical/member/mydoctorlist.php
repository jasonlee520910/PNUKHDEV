<?php

	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$medicalid=$_GET["medicalid"];
	
	if($apiCode!="mydoctorlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="mydoctorlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$jsql=" a   ";
		$wsql=" where  a.me_use<>'D' and a.me_company='".$medicalid."' and (me_status='confirm' or me_status='request' or me_status='standby' ) ";
	
		$pg=apipaging("a.me_seq","member",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (order by a.me_seq desc) NUM ";
		$sql.=" ,a.me_seq, a.me_company, a.me_registno, a.me_email,a.me_mobile,a.me_status,a.me_name,a.me_grade ";	
		$sql.=" ,to_char(a.me_date,'yyyy-mm-dd') as me_date";
		$sql.=" from ".$dbH."_member $jsql $wsql  ";
		$sql.=" order by a.me_seq desc";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

		$res=dbqry($sql);
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			/*--------------------------------------------------------- 
			//member 상태값 정리(20200812) 
			apply - 회원가입만 한 상태
			emailauth - 이메일 인증을 한 상태
			approve - 이메일인증은 한 상태
			request - 대표한의사가 소속 한의사를 불러오는 상태(한의사가 승인을 해야 최종적으로 소속이 됨)
			standby - 소속한의사가 한의원을 찾아 승인전 상태
			confirm - 정회원
			--------------------------------------------------------*/	

			if($dt["ME_STATUS"]=="confirm")
			{				
				$me_status="승인완료";
				$doBtn="소속한의사 삭제";
			}
			/*
			else if($dt["ME_STATUS"]=="apply")
			{			
				$me_status="이메일인증전 회원";		
			}
			else if($dt["ME_STATUS"]=="approve")
			{		
				$me_status="이메일인증후 회원";			
			}
			*/
			else if($dt["ME_STATUS"]=="request")
			{			
				$me_status="승인요청";	
				$doBtn="요청취소";
			}
			else if($dt["ME_STATUS"]=="standby")
			{			
				$me_status="승인대기";
				$doBtn="승인하기";
			}

			/*----------------------------------------------------------------
			승인요청 (request) -> 대표한의사가 소속한의사를 등록하고 요청을 한 경우
			승인완료 (confirm) -> 우리병원 소속 한의사
			승인대기(standby) -> 한의사가 우리 한의원에 등록하고 싶어서 요청한 경우
			//----------------------------------------------------------------*/

			if($dt["ME_GRADE"]=="30")
			{
				$Btn="";
			}
			else
			{
				$Btn="<button type='button' class='btn bg-blue color-white radius' style='font-size:12px;padding:3px 5px;height:20px;width:100px;background:#04B486;' onclick='goApproval(".$dt["ME_SEQ"].",\"".$dt["ME_STATUS"]."\");'>".$doBtn."</button>";
			}

			$addarray=array(
				"doBtn"=>$Btn,
				"statusBtn"=>$me_status,
				"seq"=>$dt["ME_SEQ"], ///seq
				"meSeq"=>$dt["ME_SEQ"], 
				"meCompany"=>$dt["ME_COMPANY"], 
				"meRegistno"=>$dt["ME_REGISTNO"],
				"meEmail"=>$dt["ME_EMAIL"], 
				"meMobile"=>$dt["ME_MOBILE"], 
				"meStatus"=>$dt["ME_STATUS"], 
				"meDate"=>$dt["ME_DATE"], 
				"meName"=>$dt["ME_NAME"] 
				
			);
			array_push($json["list"], $addarray);
		}

		$json["sql"] = $sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>