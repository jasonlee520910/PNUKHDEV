<?php  //상시처방
	
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	if($apicode!="smulist"){$json["resultMessage"]="API(apiCode) ERROR_uniquesclist";$apicode="smulist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"search"=>$search,"returnData"=>$returnData);
		$searperiodtype=$_GET["searPeriodType"];
		$searchperiod=$_GET["searchPeriod"];
		$searchstatus=$_GET["searchStatus"];
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];
		$searchpop=$_GET["searchPop"];

		$jsql=" a left join ".$dbH."_recipebook b on a.rc_source=b.rb_code ";
		$jsql.=" left join ".$dbH."_member m on a.rc_userid=m.me_userid ";
		$jsql.="left join ".$dbH."_medical c on m.me_company=c.mi_userid ";
		//$wsql=" where a.rc_use <>'D' ";
		$wsql=" where a.rc_use in ('F','Y') and  a.rc_userid='1430079500' ";  //세명대 한방병원의 상시처방 (userid)

		if($search){
			$wsql.=" and mh_title_".$language." like '%".$search."%'  ";
		}


		if($searchpop)
		{
			$arr=explode("|",$searchpop);
			foreach($arr as $val)
			{
				$arr2=explode(",",$val);
				if($arr2[0]=="searchType")
				{
					if($arr2[1]=="rcSourceTxt")
					{
						$field=" b.rb_title_".$language." ";
					}
					else if($arr2[1]=="rcTitle")
					{
						$field=" a.rc_title_".$language." ";
					}
					else if($arr2[1]=="rcMedicine")
					{
						$field=" a.rc_medicine ";
					}
				}
				if($arr2[0]=="searchTxt")
				{
					$seardata=$arr2[1];
				}
			}
			if($seardata && $field)
				$wsql.=" and ".$field." like '%".$seardata."%' ";
		}

		if($searchstatus)
		{
			$search.="&searchStatus=";
			$arr=explode(",",$searchstatus);
			if(count($arr)>1)
			{
				$wsql.=" and ( ";
				for($i=1;$i<count($arr);$i++)
				{
					if($i>1)$wsql.=" or ";
					$wsql.=" rc_status = '".$arr[$i]."' ";
					$search.=",".$arr[$i];
				}
				$wsql.=" ) ";
			}
		}
/*
		if($searchtype&&$searchtype!="all"&&$searchtxt)
		{
			$field=substr($searchtype,0,2)."_".strtolower(substr($searchtype,2,20));
			//$wsql.=" and ".$field."_".$language." like '%".$searchtxt."%' "; //기존 
			$wsql.=" and (a.rc_title_".$language." like '%".$searchtxt."%' ";//이름 
			$wsql.=" and a.rc_maincure_".$language." like '%".$searchtxt."%' ";//적응증
			$wsql.=" and a.rc_efficacy_".$language." like '%".$searchtxt."%' )";//효과 
		}
*/

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" a.rc_title_".$language." like '%".$searchtxt."%' ";//처방명
			$wsql.=" ) ";
		}

		$pg=apipaging("a.rc_code","recipemember",$jsql,$wsql);
		$sql=" select distinct(a.rc_seq) rcSeq, c.mi_name, a.rc_userid, a.rc_code rcCode, a.rc_source rcSource, a.rc_sourcetit rcSourcetit, a.rc_title_".$language." rcTitle,  a.rc_detail_".$language." rcDetail, a.rc_medicine rcMedicine, a.rc_sweet rcSweet, a.rc_chub rcChub, a.rc_efficacy_".$language." rcEfficacy, a.rc_maincure_".$language." rcMaincure, a.rc_tingue_".$language." rcTingue, a.rc_pulse_".$language." rcPulse, a.rc_usage_".$language." rcUsage, a.rc_status rcStatus, a.rc_date rcDate, b.rb_seq, b.rb_title_".$language." rbSourcetxt, b.rb_index_".$language." rbIndex, m.me_company meCompany, m.me_name meName from ".$dbH."_recipemember $jsql $wsql order by rc_date desc limit ".$pg["snum"].", ".$pg["psize"];
//echo $sql;
		$res=dbqry($sql);
		//$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			//------------------------------------------------------------
			// DOO :: 약재정보 이름으로 보여지기 위한 쿼리 추가 
			//------------------------------------------------------------
			$rcMedicine = substr($dt["rcMedicine"], 1); //한자리만 자르기 
			$rcMedicine = str_replace(" ", "", $rcMedicine);//빈공간있으면 일단은 삭제
			$rcMedicineTxt = getMedicine($rcMedicine, 'list');
			//------------------------------------------------------------
			$arr=explode("|",$rcMedicine);//약재갯수(약미)
			if($dt["rcTitle"]) {$rctitle = $dt["rcTitle"];}else{$rctitle="-";}
			if($dt["rbSourcetxt"]) {$rbSourcetxt = $dt["rbSourcetxt"];}else{$rbSourcetxt="-";}
			
			$addarray = array(
					"seq"=>$dt["rcSeq"], 
					"rcCode"=>$dt["rcCode"], 
					"rcSource"=>$dt["rcSource"],  //출처 / 한의원출처
					"rcTitle"=>$rctitle,  //이름
					"rcDetail"=>$dt["rcDetail"],  //설명
					"rcSweet"=>$dt["rcSweet"],  //감미료
					"rcChub"=>$dt["rcChub"], //첩수
					"rcMedicine"=>$rcMedicine, 
					"rcMedicineTxt"=>$rcMedicineTxt,
					"rcMedicineCnt"=>count($arr), 
					"rcEfficacy"=>$dt["rcEfficacy"], //효과
					"rcMaincure"=>$dt["rcMaincure"], //적응증
					"rcTingue"=>$dt["rcTingue"], //설진단
					"rcPulse"=>$dt["rcPulse"],  //맥상
					"rcUsage"=>$dt["rcUsage"],  //복용/일법
					"rcStatus"=>$dt["rcStatus"], 
					"rbSourcetxt"=>$rbSourcetxt, 
					"rbIndex"=>$dt["rbIndex"], 
					"meCompany"=>$dt["meCompany"],  //소속
					"miName"=>$dt["mi_name"],  //한의원명
					"meName"=>$dt["meName"], 
					"rcDate"=>$dt["rcDate"]
					);
			array_push($json["list"], $addarray);
		}
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>