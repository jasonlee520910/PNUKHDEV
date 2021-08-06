<?php  
	///사용자관리 > 스탭관리 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="stafflist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="stafflist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		///기간선택 
		$sdate = $_GET["sdate"];
		$edate = $_GET["edate"];
		$searperiodetc=$_GET["searPeriodEtc"];
		$searchtxt=$_GET["searchTxt"]; ///검색하는 단어

		$search="";
		$jsql=" a  ";
		$wsql="  where a.st_use <>'D'  and a.st_auth<>'djmedi' ";

		///기간선택 
		if($sdate&&$edate)
		{
			$sdate=str_replace(".","-",$sdate);///시작 날짜
			$edate=str_replace(".","-",$edate);///끝 날짜 

			///등록일
			$wsql.=" and ( ";
			$wsql.=" to_char(a.st_date, 'yyyy-mm-dd') >= '".$sdate."' and to_char(a.st_date, 'yyyy-mm-dd') <= '".$edate."' ";
			$wsql.=" ) ";

			$search.="&sdate=".$sdate."&edate=".$edate;
		}

		///단어 검색
		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" a.st_name like '%".$searchtxt."%' ";///이름
			$wsql.=" or ";
			$wsql.=" a.st_staffid like '%".$searchtxt."%' ";///사원코드
			$wsql.=" or ";
			$wsql.=" a.st_userid like '%".$searchtxt."%' ";///아이디
			$wsql.=" or ";
			$wsql.=" a.st_depart like '%".$searchtxt."%' ";///소속 
			$wsql.=" ) ";

			$search.="&searchType=".$searchtxt;
		}

		$pg=apipaging("st_seq","staff",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.st_seq desc) NUM ";
		$sql.=" ,a.st_seq, a.st_staffid, a.st_userid, a.st_name, a.st_depart, a.st_mobile, a.st_status ";
		$sql.=" ,a.st_auth,to_char(a.st_date,'yyyy-mm-dd') as STDATE ";	
		$sql.=" ,(select * from  ( select af_url from han_file where af_use='Y' and af_code='staff' and af_fcode='staff' and af_userid=a.st_staffid ";
		$sql.=" order by af_no desc) where rownum <= 1)  as  stPhoto ";
		$sql.=" ,(select * from  ( select af_url from han_file where af_use='Y' and af_code='staff' and af_fcode='signature' and af_userid=a.st_staffid ";
		$sql.=" order by af_no desc) where rownum <= 1)  as  stSignature ";
		$sql.=" from ".$dbH."_staff $jsql $wsql ";
		$sql.=" order by a.st_seq desc ";
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
			$addarray=array(
				"seq"=>$dt["ST_SEQ"], 
				"stAuth"=>$dt["ST_AUTH"],  ///권한
				"stStaffid"=>$dt["ST_STAFFID"], 
				"stUserid"=>$dt["ST_USERID"],
				"stName"=>$dt["ST_NAME"],  
				"stDepart"=>$dt["ST_DEPART"], 
				"stMobile"=>$dt["ST_MOBILE"], 
				"stStatus"=>$dt["ST_STATUS"], 
				"stPhoto"=>$dt["STPHOTO"], 
				"stSignature"=>$dt["STSIGNATURE"], 
				"stDate"=>$dt["STDATE"]
				);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>