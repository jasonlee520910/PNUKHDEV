<?php  
	///주문리스트 > 수기처방입력 > 한의원 검색 버튼 눌렀을 경우 
	///자재코드관리 > 포장재관리 > 포장재추가 > 한의원 검색 버튼을 눌렀을경우 	
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apicode!="medicallist"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="medicallist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$status=$_GET["status"];
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$searperiodtype=$_GET["searPeriodType"];
		$searchperiod=$_GET["searchPeriod"];
		$searchstatus=$_GET["searchStatus"];
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];
		$searchpop=$_GET["searchPop"];

		$jsql=" a ";
		$wsql="  where a.mi_use <> 'D' and a.mi_status ='confirm' ";  //승인된 한의원만 나온다.
		if($status=="inuse"){
			$wsql.=" and a.mi_use = 'Y' and a.mi_status not in('reject','standby') ";
		}

		if($searchstatus){
			$search.="&searchStatus=";
			$arr=explode(",",$searchstatus);
			if(count($arr)>1){
				$wsql.=" and ( ";
				for($i=1;$i<count($arr);$i++){
					if($i>1)$wsql.=" or ";
					$wsql.=" a.mi_status like '%".$arr[$i]."%' ";
					$search.=",".$arr[$i];
				}
				$wsql.=" ) ";
			}
		}

		if($searperiodtype&&$searchperiod){
			$arr=explode(",",$searchperiod);
			if(count($arr)>1){
				$wsql.=" and substr(a.mi_date,1,10) > '".$arr[0]."' and substr(a.mi_date,1,10) < '".$arr[1]."' ";
			}
		}
		if($searchtype&&$searchtype!="all"&&$searchtxt){
			$field=substr($searchtype,0,2)."_".strtolower(substr($searchtype,2,20));
			$wsql.=" and ".$field." like '%".$searchtxt."%' ";
		}

		if($searchpop)
		{
			$arr=explode("|",$searchpop);
			foreach($arr as $val)
			{
				$arr2=explode(",",$val);
				if($arr2[0] == 'searpoptxt')//관리자에서 한의원 검색시 
				{
					$wsql.=" and (";
					$wsql.=" a.mi_name like '%".$arr2[1]."%' ";
					$wsql.=" or ";
					$wsql.=" a.mi_businessno like '%".$arr2[1]."%' ";
					$wsql.=" or ";
					$wsql.=" m.me_name like '%".$arr2[1]."%' and m.me_grade='30' "; //한의원의 원장 이름 검색 
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

		$pg=apipaging("a.mi_seq","medical",$jsql,$wsql); 

		$jsql.=" left join ".$dbH."_member m on a.mi_userid=m.me_company and m.me_use <> 'D'  ";


		$sql="select * from ( ";
		$sql.=" select  ";
		$sql.=" ROW_NUMBER() OVER (ORDER BY a.MI_DATE desc) NUM,  ";
		$sql.=" a.mi_userid, a.mi_grade, a.mi_name, a.mi_businessno, a.mi_zipcode, a.mi_address, a.mi_phone, a.mi_mobile ";
		$sql.=" , (select me_name as mi_person from han_member where me_company=a.mi_userid and me_use<>'D' and me_grade = '30' and ROWNUM = '1') as mi_persion ";
		$sql.=" , (select LISTAGG(CONCAT(CONCAT(me_name, '|'), me_userid),',') from han_member where me_company=a.mi_userid and me_use<>'D' and me_grade in ('22', '30')) mi_doctor ";
		$sql.=" from han_medical ";
		$sql.=" $jsql ";
		$sql.=" $wsql ";
		$sql.=" group by a.mi_userid, a.mi_grade, a.mi_name, a.mi_businessno, a.mi_zipcode, a.mi_address, a.mi_phone, a.mi_mobile, a.mi_date  ";
		$sql.=" order by a.mi_date desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

		$res=dbqry($sql);

		$json["pg"]=$pg;
		$json["sql"]=$sql;
		$json["tsql"]=$pg["tsql"];
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			$persion=($dt["MI_PERSION"]) ? $dt["MI_PERSION"] : "-";
			$businessno=($dt["MI_BUSINESSNO"]) ? $dt["MI_BUSINESSNO"] : "-";
			$addarray=array(
				//"seq"=>$dt["MI_SEQ"], 
				//"miLoginid"=>$dt["MI_LOGINID"], 
				"miUserid"=>$dt["MI_USERID"], //한의원관리고유ID
				"miName"=>$dt["MI_NAME"], //한의원 이름
				"miBusinessno"=>$businessno,//사업자번호 
				"miDoctor"=>$dt["MI_DOCTOR"],//의사 
				"miPersion"=>$persion,//담당자
				"miZipcode"=>$dt["MI_ZIPCODE"],
				"miAddress"=>$dt["MI_ADDRESS"], 
				"miPhone"=>$dt["MI_PHONE"], 
				"miMobile"=>$dt["MI_MOBILE"], 	
				"miGrade"=>$dt["MI_GRADE"]//,//한의원등급 20190917 
				//"miStatus"=>$dt["MI_STATUS"], 
				//"miDate"=>$dt["MI_DATE"],
				//"memCnt"=>$dt["MEMCNT"],
				//"meName"=>$me_name
				);
			array_push($json["list"], $addarray);
		}
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>