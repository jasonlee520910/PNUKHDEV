<?php  
	///처방관리 > 약속처방 > 약속처방 리스트
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	if($apicode!="recipegoodslist"){$json["resultMessage"]="API(apiCode) ERROR_uniquesclist";$apicode="recipegoodslist";}
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

		$jsql.="a left join ".$dbH."_member m on a.rc_userid=m.me_userid ";
		$jsql.="left join ".$dbH."_medical c on m.me_company=c.mi_userid ";
		$jsql.="left join ".$dbH."_packingbox p1 on a.rc_packtype=p1.pb_code and p1.pb_type='odPacktype' ";
		$jsql.="left join ".$dbH."_packingbox p2 on a.rc_medibox = p2.pb_code and p2.pb_type='reBoxmedi' ";
		$wsql=" where a.rc_use in ('F','Y') and  a.rc_medical='goods' ";  ///약속 goods

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
						//$field=" a.rc_title_".$language." ";
					}
					else if($arr2[1]=="rcTitle")  ///처방명
					{
						$field=" a.rc_title_".$language." ";
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

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" a.rc_title_".$language." like '%".$searchtxt."%' ";///처방명
			///$wsql.=" or ";
			///$wsql.=" a.rc_base_".$language." like '%".$searchtxt."%' ";///한의원

			$wsql.=" ) ";
		}

		$pg=apipaging("a.rc_code","recipemedical",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.rc_date desc) NUM ";
		$sql.=" ,a.rc_seq, a.rc_code as rcCode, a.rc_source, a.rc_sourcetit, a.rc_title_kor as rcTitle,to_char(a.rc_medicine) as RCMEDICINE";
		$sql.=" ,to_char(a.rc_sweet) as rcSweet, a.rc_chub as rcChub, a.rc_packcnt as rcPackCnt, a.rc_packcapa as rcPackCapa, a.rc_status as rcStatus, a.rc_date as rcDate";
		$sql.=" ,p1.pb_title as PACKTYPE, p2.pb_title as MEDIBOX ";
		$sql.=" from ".$dbH."_recipemedical $jsql $wsql order by a.rc_date desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"]; 

		$res=dbqry($sql);

		$json["searchtxt"]=$searchtxt;
		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			///------------------------------------------------------------
			/// 약재와 별전 이름만 가져오기 
			///------------------------------------------------------------
			$rcMedicine = substr($dt["RCMEDICINE"], 1); ///한자리만 자르기 ///HD10030_03,1.0,inmain,20|HD10244_07,2,inmain,167.2
			$rcMedicine = str_replace(" ", "", $rcMedicine);///빈공간있으면 일단은 삭제
			$rcMedicineName = getmmtitle($rcMedicine); ///han_medicine_djmedi mmtitle 가져오기 

			$rcSweet = substr($dt["RCSWEET"], 1); ///한자리만 자르기 ///HD10030_03,1.0,inmain,20|HD10244_07,2,inmain,167.2
			$rcSweet = str_replace(" ", "", $rcSweet);///빈공간있으면 일단은 삭제
			$rcSweetName = getmmtitle($rcSweet); ///han_medicine_djmedi mmtitle 가져오기 
			///------------------------------------------------------------

			$rcMedicineTxt=$rcMedicineName.",".$rcSweetName;
			
			if($dt["PACKTYPE"]){$packType=$dt["PACKTYPE"];}else{$packType="-";}
			if($dt["MEDIBOX"]){$rcMediBox=$dt["MEDIBOX"];}else{$rcMediBox="-";}
			if($dt["RCPACKCAPA"]){$rcPackCapa=$dt["RCPACKCAPA"];}else{$rcPackCapa="-";} 

			$sarr=explode(",", $dt["RC_SOURCE"]);
			$starr=explode(",", $dt["RC_SOURCETIT"]);
			$matching=array();

			for($i=1;$i<count($sarr)-1;$i++)
			{
				$addarray = array(
				"code"=>$sarr[$i],
				"title"=>$starr[$i],
				);
				array_push($matching, $addarray);
			}


			$arr=explode("|",$rcMedicine);///약재갯수(약미)
			$addarray = array(
				"seq"=>$dt["RC_SEQ"], 
				"rcCode"=>$dt["RCCODE"], 
				"matching"=>$matching,
				"rcChub"=>$dt["RCCHUB"], ///첩수
				"rcTitle"=>$dt["RCTITLE"],
				"rcMedicine"=>$rcMedicine, 
				"rcMedicineTxt"=>$rcMedicineTxt, ///약재정보 (약재만 뽑아서 이름만 추출 (han_medicine_djmedi mmtitle ))
				"rcMedicineCnt"=>count($arr),  ///약미
				"rcPackCnt"=>$dt["RCPACKCNT"],
				"rcPackCapa"=>$rcPackCapa, ///팩용량
				"rcPackType"=>$packType,  ///파우치
				"rcMediBox"=>$rcMediBox,  ///한약박스
				"rcStatus"=>$dt["RCSTATUS"] ///승인

				);
			array_push($json["list"], $addarray);
		}
		$json["sql"]=$sql;

		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>