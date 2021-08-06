<?php  
	///처방관리 > 나의처방 > 나의처방 리스트
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	if($apicode!="myrecipelist"){$json["resultMessage"]="API(apiCode) ERROR_uniquesclist";$apicode="myrecipelist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"search"=>$search,"returnData"=>$returnData);
		$searchtxt=$_GET["searchTxt"];

		$jsql.="a left join ".$dbH."_member m on a.RC_USERID=m.me_userid ";
		$jsql.="left join ".$dbH."_medical c on a.RC_MEMBER=c.mi_userid ";
		$wsql=" where a.rc_use in ('F','Y') and  a.rc_medical='myrecipe' ";  //나의처방만 

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" a.rc_title_".$language." like '%".$searchtxt."%' ";///처방명
			$wsql.=" or ";
			$wsql.=" c.MI_NAME like '%".$searchtxt."%' ";///한의원이름 
			$wsql.=" or ";
			$wsql.=" m.ME_NAME like '%".$searchtxt."%' ";///한의사이름  
			$wsql.=" ) ";
		}

		$pg=apipaging("a.rc_code","recipemedical",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.rc_date desc) NUM ";
		$sql.=" ,a.rc_seq, a.rc_code as rcCode, a.rc_title_kor as rcTitle ";
		$sql.=" ,a.rc_medicine as RCMEDICINE";
		$sql.=" ,a.rc_sweet as rcSweet ";
		$sql.=" , a.rc_chub as rcChub, a.rc_packcnt as rcPackCnt, a.rc_packcapa as rcPackCapa, a.rc_status as rcStatus, a.rc_date as rcDate ";
		$sql.=" , m.ME_NAME, c.MI_NAME ";
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
			$rcMedicine = substr(getClob($dt["RCMEDICINE"]), 1); ///한자리만 자르기 ///HD10030_03,1.0,inmain,20|HD10244_07,2,inmain,167.2
			$rcMedicine = str_replace(" ", "", $rcMedicine);///빈공간있으면 일단은 삭제
			$rcMedicineName = getmmtitle($rcMedicine); ///han_medicine_djmedi mmtitle 가져오기 

			$rcSweet = substr(getClob($dt["RCSWEET"]), 1); ///한자리만 자르기 ///HD10030_03,1.0,inmain,20|HD10244_07,2,inmain,167.2
			$rcSweet = str_replace(" ", "", $rcSweet);///빈공간있으면 일단은 삭제
			$rcSweetName = getmmtitle($rcSweet); ///han_medicine_djmedi mmtitle 가져오기 
			///------------------------------------------------------------

			
			$rcMedicineTxt=$rcMedicineName;
			if($rcSweetName!='-')
			{
				$rcMedicineTxt.=",".$rcSweetName;
			}
			
			if($dt["RCCHUB"]){$rcChub=$dt["RCCHUB"];}else{$rcChub="-";} 
			if($dt["RCPACKCNT"]){$rcPackCnt=$dt["RCPACKCNT"];}else{$rcPackCnt="-";} 
			if($dt["RCPACKCAPA"]){$rcPackCapa=$dt["RCPACKCAPA"];}else{$rcPackCapa="-";} 

			$arr=explode("|",$rcMedicine);///약재갯수(약미)

			$addarray = array(
				"seq"=>$dt["RC_SEQ"], 
				"rcCode"=>$dt["RCCODE"], 
				"rcTitle"=>$dt["RCTITLE"],
				"miName"=>$dt["MI_NAME"],//한의원
				"meName"=>$dt["ME_NAME"],//한의사 
				"rcChub"=>$rcChub, ///첩수
				"rcMedicine"=>$rcMedicine, 
				"rcMedicineTxt"=>$rcMedicineTxt, ///약재정보 (약재만 뽑아서 이름만 추출 (han_medicine_djmedi mmtitle ))
				"rcMedicineCnt"=>count($arr),  ///약미
				"rcPackCnt"=>$rcPackCnt,
				"rcPackCapa"=>$rcPackCapa, ///팩용량
				"rcStatus"=>$dt["RCSTATUS"] ///승인

				);
			array_push($json["list"], $addarray);
		}
		$json["sql"]=$sql;

		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>