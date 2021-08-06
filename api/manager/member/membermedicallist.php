<?php  
	///사용자관리 > 한의원관리 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="membermedicallist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="membermedicallist";}
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
		$jsql="  ";	
		$wsql=" where mi_use <> 'D' "; 

		if($sdate&&$edate)
		{
			$sdate=str_replace(".","-",$sdate);//시작 날짜
			$edate=str_replace(".","-",$edate);//끝 날짜 

			///등록일
			$wsql.=" and ( ";
			$wsql.=" to_char(mi_date, 'yyyy-mm-dd') >= '".$sdate."' and to_char(mi_date, 'yyyy-mm-dd') <= '".$edate."' ";
			$wsql.=" ) ";

			$search.="&sdate=".$sdate."&edate=".$edate;
		}

		///단어 검색
		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" mi_name like '%".$searchtxt."%' ";///한의원명
			//$wsql.=" or ";
			//$wsql.=" m.me_name like '%".$searchtxt."%' ";///대표자명
			$wsql.=" or ";
			$wsql.=" mi_userid like '%".$searchtxt."%' ";///아이디
			$wsql.=" or ";
			$wsql.=" mi_businessno like '%".$searchtxt."%' ";///사업자번호 
			//$wsql.=" or ";
			//$wsql.=" m.me_registno like '%".$searchtxt."%' ";///면허번호 
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
					$wsql.=" mi_status like '%".$arr[$i]."%' ";
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
					$wsql.=" mi_name like '%".$arr2[1]."%' ";
					$wsql.=" or ";
					$wsql.=" mi_businessno like '%".$arr2[1]."%' ";
					//$wsql.=" or ";
					//$wsql.=" m.me_name like '%".$arr2[1]."%' and m.me_grade='30' "; ///한의원의 원장 이름 검색 
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

		$pg=apipaging("mi_seq","medical",$jsql,$wsql);

		$wsql.="  ";

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY mi_date desc) NUM ";
		$sql.=" ,mi_seq,mi_grade, mi_userid, mi_name, mi_businessno, mi_loginid, mi_ceo, mi_zipcode, mi_address";
		$sql.=" ,mi_phone, to_char(mi_date, 'yyyy-mm-dd') as MIDATE, mi_status ";
		$sql.=" ,( select count(me_seq) from ".$dbH."_member where  me_company=mi_userid and me_use<>'D' group by me_company) MEMCNT ";
		$sql.=" from ".$dbH."_medical $jsql $wsql ";
		$sql.=" order by mi_date desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

		$res=dbqry($sql);

		$json["sql"]=$sql;
		
		$json["psql"]=$pg["psql"];  
		// select count(distinct(mi_seq)) TCNT from han_medical  a left join han_member m on mi_userid=m.me_company and m.me_use<>'D' where mi_use <> 'D' 
		$json["tlast"]=$pg["tlast"];

		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			$addr = explode("||", $dt["MI_ADDRESS"]);///주소 

			if($dt["MEMCNT"]){$memberTotal = $dt["MEMCNT"];}else{$memberTotal=" - ";}
			if($dt["MI_ZIPCODE"]){$miZipcode=$dt["MI_ZIPCODE"];}else{$miZipcode="-";}
			if($dt["MI_CEO"]){$MENAME=$dt["MI_CEO"];}else{$MENAME="-";}			

			if($dt["MI_GRADE"]=="A")
			{
				$miGradetext="A Class";
			}
			else if($dt["MI_GRADE"]=="B")
			{
				$miGradetext="B Class";
			}
			else if($dt["MI_GRADE"]=="C")
			{
				$miGradetext="C Class";
			}
			else if($dt["MI_GRADE"]=="D")
			{
				$miGradetext="D Class";
			}
			else if($dt["MI_GRADE"]=="E")
			{
				$miGradetext="E Class";
			}

			$addarray=array(
				"seq"=>$dt["MI_SEQ"], 
				"miGrade"=>$miGradetext, ///A,B,C, D, E 등급 한의원 구분
				"miUserid"=>$dt["MI_USERID"], ///한의원관리고유ID
				"miName"=>$dt["MI_NAME"], ///한의원 이름
				"miDoctor"=>$MENAME,///대표자명
				"miBusinessno"=>$dt["MI_BUSINESSNO"],///사업자번호 		
				"miLoginid"=>$dt["MI_LOGINID"], 
				"miZipcode"=>trim($miZipcode), 
				"miAddress"=>trim($addr[0].$addr[1]), ///주소
				"miPhone"=>$dt["MI_PHONE"], 
				"miStatus"=>$dt["MI_STATUS"],   //상태
				"Btn"=>$dt["MI_STATUS"],   //버튼
				"miDate"=>$dt["MIDATE"],
				"memCnt"=>$memberTotal///회원수
				
				);
			array_push($json["list"], $addarray);
		}
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>