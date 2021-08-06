<?php  
	///약재관리 > 상극알람 > 경고내용 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="dismedilist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="dismedilist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$searchtxt=$_GET["searchTxt"];

		$jsql=" a";
		$wsql=" where a.dm_use = 'Y' ";

		if($searchtxt)  ///검색단어가 있을때
		{
			$wsql.=" and  dm_desc_eng like '%".$searchtxt."%' ";
		}

		///상극은 본초와 연관되어있으므로 medihub 테이블과 join
		$pg=apipaging("dm_seq","medi_dismatch",$jsql,$wsql);
		
		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.dm_code) NUM ";
		$sql.=" ,a.dm_seq, a.dm_code, a.dm_group, a.dm_medicine,to_char(a.dm_desc_eng) as DMDESCENG ";
		$sql.=" ,a.dm_notice_kor as dmNoticekor, to_char(a.dm_desc_".$language.") as DMDESC,a.dm_use, a.dm_date  ";
		$sql.=" from ".$dbH."_medi_dismatch  $jsql $wsql  ";
		$sql.=" group by a.dm_seq, a.dm_code, a.dm_group, a.dm_medicine,to_char(a.dm_desc_eng), a.dm_notice_kor, to_char(a.dm_desc_".$language."),a.dm_use, a.dm_date  ";
		$sql.=" order by a.dm_code ";
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
			if(!$dt["DMNOTICEKOR"]){$dmNotice="-";}else{$dmNotice=$dt["DMNOTICEKOR"];}	///경고메시지에 null 나오는것 처리
			
			$addarray=array(
				"seq"=>$dt["DM_SEQ"], 
				"dmCode"=>$dt["DM_CODE"], 
				"dmGroup"=>$dt["DM_GROUP"], 			
				"dmMeditxt"=>$dt["DMDESCENG"], ///상극약재 한글
				"dmNotice"=>$dmNotice, ///경고메시지
				"dmDate"=>$dt["DM_DATE"]
				);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>