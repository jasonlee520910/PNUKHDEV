<?php  
	/// 제품재고관리 > 제품목록 > 제품목록리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$mt_seq=$_GET["seq"];

	if($apiCode!="goodslist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodslist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$searperiodtype=$_GET["searPeriodType"];
		$searchperiod=$_GET["searchPeriod"];
		$searchstatus=$_GET["searchStatus"];
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];
		$searchmatype=$_GET["searchMatype"];

		$jsql=" a  inner join ".$dbH."_code c on c.cd_type='gdType' and a.gd_type=c.cd_code and c.cd_use ='Y' ";
		$jsql.=" left join ".$dbH."_code d on d.cd_type='gdCategory' and a.gd_category=d.cd_code and d.cd_use ='Y' ";
		$wsql=" where a.gd_use in ('Y','A') ";  ///사용전과 사용중인것만 보임

		if($searchstatus){
			$arr=explode(",",$searchstatus);
			if(count($arr)>1){
				$wsql.=" and ( ";
				for($i=1;$i<count($arr);$i++){
					if($i>1)$wsql.=" or ";
					$wsql.=" a.gd_type = '".$arr[$i]."' ";
				}
				$wsql.=" ) ";
			}
		}
		if($searchmatype){
			$wssql="";
			if(strpos($searchmatype,"kok")){
				if($wssql!="")$wssql.=" or ";
				$wssql.=" a.gd_name_kor like '%경옥고%' ";///제품명
			}
			if(strpos($searchmatype,"gbh")){
				if($wssql!="")$wssql.=" or ";
				$wssql.=" a.gd_name_kor like '%감비환%' ";///제품명
			}
			if(strpos($searchmatype,"kgd")){
				if($wssql!="")$wssql.=" or ";
				$wssql.=" a.gd_name_kor like '%공진단%' ";///제품명
			}
			if(strpos($searchmatype,"org")){
				if($wssql!="")$wssql.=" or ";
				$wssql.=" a.gd_name_kor like '(협력기관)%' ";///제품명
			}
			if(strpos($searchmatype,"nyr")){
				if($wssql!="")$wssql.=" or ";
				$wssql.=" a.gd_name_kor like '[설기획]%' ";///제품명
			}
			if(strpos($searchmatype,"sky")){
				if($wssql!="")$wssql.=" or ";
				$wssql.=" a.gd_name_kor like '%하늘체%' ";///제품명
			}
			if($wssql!=""){
				$wsql.=" and ( ".$wssql." ) ";
			}
		}
		$json["wssql"]=$searchmatype;

		if($searchtype&&$searchtype!="all"&&$searchtxt){
			$field=substr($searchtype,0,2)."_".strtolower(substr($searchtype,2,20));
			$wsql.=" and ".$field." like '%".$searchtxt."%' ";
		}

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" a.gd_code like '%".$searchtxt."%' ";///품목코드
			$wsql.=" or ";
			$wsql.=" a.gd_name_kor like '%".$searchtxt."%' ";///제품명
			$wsql.=" or ";
			$wsql.=" a.gd_name_chn like '%".$searchtxt."%' ";///제품명
			$wsql.=" or ";
			$wsql.=" a.gd_name_eng like '%".$searchtxt."%' ";///제품명
			$wsql.=" ) ";
		}

		$pg=apipaging("gd_seq","goods",$jsql,$wsql);

		$ssql=" a.gd_seq,a.gd_use,a.gd_code,a.gd_name_kor,a.gd_sales,a.gd_stable,a.gd_qty,a.gd_bomcode,a.gd_spec,a.gd_type ";
		$ssql.=" ,to_char(a.gd_modify,'yyyy-mm-dd') as GD_MODIFY "; 
		$ssql.=" ,to_char(a.gd_date,'yyyy-mm-dd') as GD_DATE "; 
		$ssql.=" ,gd_name_".$language." as GD_NAME ";
		$ssql.=" ,(select * from (select gh_date from ".$dbH."_goodshouse where gh_code=a.gd_code and gh_type='incoming' order by gh_date desc) where rownum <= 1)  as INCOMINGDATE "; 
		$ssql.=" ,(select * from (select gh_date from ".$dbH."_goodshouse where gh_code=a.gd_code and gh_type='outgoing' order by gh_date desc) where rownum <= 1)  as OUTGOINGDATE "; 
		$ssql.=" ,c.cd_name_".$language." gdType, d.cd_name_".$language." as GDCATEGORY ";

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.gd_date desc) NUM ";
		$sql.=" , $ssql ";		
		$sql.=" from ".$dbH."_goods $jsql $wsql ";
		$sql.=" order by a.gd_date desc, gd_name_".$language." ";
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
			$gdBom="-";

			if($dt["GD_BOMCODE"]!="")
			{
				$gdBom=count(explode(",",substr($dt["GD_BOMCODE"], 1,1000)))."종";
			}
			if($dt["INCOMINGDATE"]==""){$incomingdate=" - ";}else{$incomingdate=substr($dt["INCOMINGDATE"],0,16);}
			if($dt["OUTGOINGDATE"]==""){$outgoingdate=" - ";}else{$outgoingdate=substr($dt["OUTGOINGDATE"],0,16);}
			if($dt["GDCATEGORY"]==""){$gdCategory=" - ";}else{$gdCategory=$dt["GDCATEGORY"];}
			if($dt["GD_SPEC"]==""){$gdSpec=" - ";}else{$gdSpec=$dt["GD_SPEC"];}
			if($dt["GD_MODIFY"]){$gdDate=$dt["GD_MODIFY"];}else{$gdDate=$dt["GD_DATE"];}

			$addarray=array(
				"seq"=>$dt["GD_SEQ"], 
				"gdUse"=>$dt["GD_USE"], 
				"gdCode"=>$dt["GD_CODE"], 
				"gdType"=>$dt["GDTYPE"], 
				"gdTypeCode"=>$dt["GD_TYPE"], ///반제품인지 
				"gdCategory"=>$gdCategory, 
				"gdName"=>$dt["GD_NAME"], 
				"gdSpec"=>$gdSpec, ///규격
				"gdBom"=>$gdBom, ///구성
				"gdSales"=>number_format($dt["GD_SALES"]), 
				"gdStable"=>number_format($dt["GD_STABLE"]),   ///적정재고량
				"gdQty"=>number_format($dt["GD_QTY"]),  ///재고량
				"incomingDate"=>$incomingdate, 
				"outgoingDate"=>$outgoingdate, 
				"gdDate"=>$gdDate
				);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>