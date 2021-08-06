<?php  
	///사용자관리 > 한의사관리 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="doctorlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="doctorlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sdate = $_GET["sdate"];
		$edate = $_GET["edate"];
		$searperiodetc=$_GET["searPeriodEtc"];

		$status=$_GET["status"];
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$searperiodtype=$_GET["searPeriodType"];
		$searchperiod=$_GET["searchPeriod"];
		$searchstatus=$_GET["searchStatus"];
		$searchtype=$_GET["searchType"];
		$searchpop=$_GET["searchPop"];
		$searchtxt=$_GET["searchTxt"]; //검색하는 단어

		$search="";
		$jsql=" a left join han_medical b on b.MI_USERID=a.ME_COMPANY and b.mi_use <>'D' ";	
		$wsql=" where a.ME_USE <> 'D' "; 

		if($sdate&&$edate)
		{
			$sdate=str_replace(".","-",$sdate);//시작 날짜
			$edate=str_replace(".","-",$edate);//끝 날짜 

			///등록일
			$wsql.=" and ( ";
			$wsql.=" to_char(a.me_date, 'yyyy-mm-dd') >= '".$sdate."' and to_char(a.me_date, 'yyyy-mm-dd') <= '".$edate."' ";
			$wsql.=" ) ";

			$search.="&sdate=".$sdate."&edate=".$edate;
		}

		///단어 검색
		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" a.me_name like '%".$searchtxt."%' ";///한의사명
			$wsql.=" or ";
			$wsql.=" a.me_userid like '%".$searchtxt."%' ";///아이디
			$wsql.=" or ";
			$wsql.=" a.ME_LOGINID like '%".$searchtxt."%' ";///아이디
			$wsql.=" or ";
			$wsql.=" a.me_registno like '%".$searchtxt."%' ";///면허번호
			$wsql.=" or ";
			$wsql.=" b.mi_name like '%".$searchtxt."%' ";///한의원명
			$wsql.=" ) ";

			$search.="&searchType=".$searchtxt;
		}

		if($searchstatus){
			$search.="&searchStatus=";
			$arr=explode(",",$searchstatus);
			if(count($arr)>1){
				$wsql.=" and ( ";
				for($i=1;$i<count($arr);$i++){
					if($i>1)$wsql.=" or ";
					$wsql.=" a.me_status like '%".$arr[$i]."%' ";
					$search.=",".$arr[$i];
				}
				$wsql.=" ) ";
			}
		}

		if($searchpop)
		{
			$arr=explode("|",$searchpop);
			foreach($arr as $val)
			{
				$arr2=explode(",",$val);
				if($arr2[0] == 'searpoptxt')///관리자에서 한의원 검색시 
				{
					$wsql.=" and (";
					$wsql.=" a.me_name like '%".$arr2[1]."%' ";
					$wsql.=" or ";
					$wsql.=" a.me_registno like '%".$arr2[1]."%' ";
					$wsql.=" or ";
					$wsql.=" a.me_name like '%".$arr2[1]."%' and a.me_grade='30' "; ///한의원의 원장 이름 검색 
					$wsql.=") ";
				}
				else
				{
					if($arr2[1]!="")
					{
						$field=substr($arr2[0],0,2)."_".strtolower(substr($arr2[0],2,20));
						$wsql.=" and ".$field." like '%".$arr2[1]."%' ";
					}
					$arr2[0]=$arr2[1];
				}
			}
		}

		$pg=apipaging("a.me_seq","member",$jsql,$wsql);

		$wsql.=" ";

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.ME_DATE desc) NUM  ";
		$sql.=" , a.me_seq, a.me_userid,a.me_name, a.me_loginid,a.me_registno, a.me_email, a.me_mobile, to_char(a.me_date, 'yyyy-mm-dd') as medate, a.me_status ,b.mi_status , b.mi_name , a.me_grade ";
		$sql.=" ,(select af_URL from HAN_FILE where AF_CODE='license' and AF_FCODE=TO_CHAR(a.ME_SEQ) and AF_USE='Y') as afUrl  ";
		$sql.=" ,(select af_seq from HAN_FILE where AF_CODE='license' and AF_FCODE=TO_CHAR(a.ME_SEQ) and AF_USE='Y') as afSeq  ";
		$sql.=" from ".$dbH."_member $jsql $wsql ";
		$sql.=" order by b.MI_USERID desc, b.MI_NAME desc ,a.me_status,a.ME_DATE desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

		$res=dbqry($sql);

		$json["sql"]=$sql;
		
		$json["psql"]=$pg["psql"];  
		$json["tlast"]=$pg["tlast"];
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			/*
			$miname=($dt["MI_NAME"])?"<span style='color:#C27D0E;'>".$dt["MI_NAME"]."</span>":"일반";
			if($dt["MI_NAME"])
			{
				$me_grade=($dt["ME_GRADE"]=="30")?"<span style='color:blue;'>대표</span>":"<span style='color:#3D85C6;'>소속</span>";
			}
			else
			{
				$me_grade="";
			}
			
			$mestatusname=$miname." ".$me_grade." 한의사";
			*/

			/*--------------------------------------------------------- 
			//member 상태값 정리(20200812) 
			apply - 회원가입만 한 상태
			emailauth - 이메일 인증을 한 상태
			approve - 이메일인증은 한 상태(면허증 확인)
			request - 대표한의사가 소속 한의사를 불러오는 상태(한의사가 승인을 해야 최종적으로 소속이 됨)
			standby - 소속한의사가 한의원을 찾아 승인전 상태
			confirm - 정회원
			--------------------------------------------------------*/	

			if($dt["ME_STATUS"]=="confirm")
			{				
				$me_status="승인완료";
				$doBtn="소속한의원 삭제";
			}
			else if($dt["ME_STATUS"]=="apply")
			{			
				$me_status="이메일인증전 회원";		
				$doBtn="이메일인증하기";
			}
			else if($dt["ME_STATUS"]=="emailauth")
			{			
				$me_status="이메일인증후 회원";	
				$doBtn="면허증확인하기";
			}
			else if($dt["ME_STATUS"]=="approve")
			{		
				$me_status="면허증확인된 회원";		
				$doBtn="한의원 등록하기";
			}
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


			if(!isEmpty($dt["MI_NAME"])){$miname=$dt["MI_NAME"];}else{$miname="";}

			$afFile=getafFile($dt["AFURL"]);
			$afThumbUrl=getafThumbUrl($dt["AFURL"]);

			$meRegistno=($dt["ME_REGISTNO"])?$dt["ME_REGISTNO"]:"";
			$meEmail=($dt["ME_EMAIL"])?$dt["ME_EMAIL"]:"";
			$meMobile=($dt["ME_MOBILE"])?$dt["ME_MOBILE"]:"";
			$addarray=array(
				"meSeq"=>$dt["ME_SEQ"], 
				"meName"=>$dt["ME_NAME"], ///한의원관리고유ID
				"miName"=>$miname, ///한의원명

				"meLoginid"=>$dt["ME_LOGINID"], ///한의원 이름
				"meRegistno"=>$meRegistno,///사업자번호 		
				"meEmail"=>$meEmail, 
				"meMobile"=>$meMobile,
				"meDate"=>$dt["MEDATE"],
				"meStatus"=>$dt["ME_STATUS"],
				"meUserid"=>$dt["ME_USERID"],
					
				//"meStatusName"=>$me_status."-".$dt["ME_STATUS"],//상태
				"meStatusName"=>$me_status,//상태
				"Btn"=>$doBtn,//상테
				"afFilel"=>$afFile,

				"afSeq"=>$dt["AFSEQ"],  //이미지 seq

					
				"afThumbUrl"=>$afThumbUrl
				);
			array_push($json["list"], $addarray);
		}
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["wsql"]=$wsql;


		
	}
?>