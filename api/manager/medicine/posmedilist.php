<?php  
	///약재관리 > 독성알람 > 독성알람 목록 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="posmedilist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="posmedilist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$searchtxt=$_GET["searchTxt"];  ///검색단어

		$jsql="a left join ".$dbH."_code c on a.po_code=c.cd_code and c.cd_type='mhPoison'  ";
		$jsql.=" left join ".$dbH."_medihub h on a.po_medicine = h.mh_code ";
		//$wsql="where a.po_code not in (100) and a.po_use<>'D' "; 
		$wsql="where a.po_code <>'100' and a.po_use<>'D' "; 

		if($searchtxt)  ///검색단어가 있을때
		{
			$wsql.=" and ( ";
			$wsql.=" po_medicine like '%".$searchtxt."%' ";///본초코드
			$wsql.=" or ";
			$wsql.=" po_code like '%".$searchtxt."%' "; ///중독코드
			$wsql.=" or ";
			$wsql.=" h.mh_title_kor like '%".$searchtxt."%' ";///본초명
			$wsql.=" ) ";
		}
		$pg=apipaging("a.po_seq","medi_poison",$jsql,$wsql);  

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.po_seq) NUM ";
		$sql.=" ,a.po_seq, a.po_code,a.po_medicine ";
		$sql.=" , h.mh_title_kor ";
		$sql.=" , c.cd_name_".$language." as cdname";
		$sql.=" from ".$dbH."_medi_poison  $jsql $wsql ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

		$res=dbqry($sql);
		
		$json["jsql"]=$pg["jsql"];
		$json["tsql"]=$pg["tsql"];
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();
	
		while($dt=dbarr($res))
		{	
			
			$addarray=array(
				"seq"=>$dt["PO_SEQ"], 
				"poCode"=>$dt["PO_CODE"], ///중독코드
				"poMedicine"=>$dt["PO_MEDICINE"], ///본초코드
				"poisiontitle"=>$dt["CDNAME"], ///중독 코드를 text로 변경
				"poMeditxt"=>$dt["MH_TITLE_KOR"] ///본초명
				);
			array_push($json["list"], $addarray);
		}

		$json["searchtxt"] =$searchtxt;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]=$addarray;
	}
?>