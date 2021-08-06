<?php  
	/// 자재코드관리 > 포장재관리 > 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$pb_seq=$_GET["seq"];

	if($apiCode!="packinglist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="packinglist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$category=$_GET["category"];
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$searperiodtype=$_GET["searPeriodType"];
		$searchperiod=$_GET["searchPeriod"];
		$searchstatus=$_GET["searchStatus"];
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];

		$jsql=" a left join ".$dbH."_medical b on a.pb_member=b.mi_userid ";
		//$jsql.=" left join ".$dbH."_file f on a.pb_code=f.af_fcode and f.af_code='packingbox' and f.af_use='Y' ";
		$wsql=" where a.pb_use='Y' ";

		if($searchstatus){
			$arr=explode(",",$searchstatus);
			if(count($arr)>1){
				$wsql.=" and ( ";
				for($i=1;$i<count($arr);$i++){
					if($i>1)$wsql.=" or ";
					$wsql.=" pb_type = '".$arr[$i]."' ";
				}
				$wsql.=" ) ";
			}
		}

		if($searchtype&&$searchtype!="all"&&$searchtxt){
			$field=substr($searchtype,0,2)."_".strtolower(substr($searchtype,2,20));
			$wsql.=" and ".$field." like '%".$searchtxt."%' ";
		}

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" a.pb_code like '%".$searchtxt."%' ";///포장재코드
			$wsql.=" or ";
			$wsql.=" a.pb_title like '%".$searchtxt."%' ";///자재명
			$wsql.=" or ";
			$wsql.=" b.mi_name like '%".$searchtxt."%' ";///한의원
			$wsql.=" ) ";
		}

		$pg=apipaging("pb_code","packingbox",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.pb_code) NUM ";	
		$sql.=" ,(select * from (select af_url from ".$dbH."_file where a.pb_code=af_fcode and af_code='packingbox' and af_use='Y' order by af_seq desc) where rownum <= 1)
				as AFURL ";	
		$sql.=" ,a.pb_seq, a.pb_code, a.pb_type, a.pb_title, a.pb_member ";
		$sql.=" ,to_char(a.pb_date,'yyyy-mm-dd') as PB_DATE ";
		$sql.=" ,b.mi_name ";
		//$sql.=", f.af_url as AFURL ";
		$sql.=" ,(select cd_name_kor from ".$dbH."_code where cd_type='pbType' and cd_code = a.pb_type) as pbTypeName ";
		$sql.=" from ".$dbH."_packingbox  $jsql $wsql  ";
		$sql.=" group by a.pb_code,a.pb_seq, a.pb_type, a.pb_title, a.pb_member ,a.pb_date ,b.mi_name  ";
		$sql.=" order by a.pb_code desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

		$res=dbqry($sql);

		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			$miName = ($dt["MI_NAME"]) ? $dt["MI_NAME"] : "-";

			$afFile=getafFile($dt["AFURL"]);
			$afThumbUrl=getafThumbUrl($dt["AFURL"]);

			$addarray=array(
				"afUrl"=>$dt["AFURL"], 
				"seq"=>$dt["PB_SEQ"], 
				"pbCode"=>$dt["PB_CODE"], 
				"pbType"=>$dt["PB_TYPE"], 
				"pbTypeName"=>$dt["PBTYPENAME"], 
				"pbTitle"=>$dt["PB_TITLE"], 
				"pbMember"=>$dt["PB_MEMBER"], 
				"miName"=>$miName, 
				"pbDate"=>$dt["PB_DATE"],
				"afThumbUrl"=>$afThumbUrl,
				"afFile"=>$afFile
				);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>