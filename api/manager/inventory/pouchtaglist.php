<?php  
	/// 자재코드관리 > 조제태그관리 > 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	///$page=$_GET["page"];
	$pt_seq=$_GET["seq"];

	if($apiCode!="pouchtaglist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="pouchtaglist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$searperiodtype=$_GET["searPeriodType"];
		$searchperiod=$_GET["searchPeriod"];
		$searchstatus=$_GET["searchStatus"];
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];

		$jsql=" a ";
		$wsql=" where a.pt_use='Y' ";

		if($searchstatus){
			$arr=explode(",",$searchstatus);
			if(count($arr)>1){
				$wsql.=" and ( ";
				for($i=1;$i<count($arr);$i++){
					if($i>1)$wsql.=" or ";
					$wsql.=" pt_group = '".$arr[$i]."' ";
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
			$wsql.=" a.pt_code like '%".$searchtxt."%' ";///바코드
			$wsql.=" ) ";
		}

		$pg=apipaging("pt_code","pouchtag",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.pt_code desc) NUM ";		
		$sql.=" ,a.pt_seq,a.pt_group,a.pt_name1,a.pt_name2,a.pt_name3,a.pt_code";
		$sql.=" ,to_char(a.pt_date,'yyyy-mm-dd') as PTDATE"; 
		$sql.=" from ".$dbH."_pouchtag  $jsql $wsql  ";
		$sql.=" order by a.pt_code desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

		$res=dbqry($sql);

		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		/// 탕전타입
		$dcTitleList = getDecoCodeTitle('all');

		while($dt=dbarr($res))
		{
			$ptGroupName=decoctype($dt["PT_GROUP"]);

			$addarray=array(
				"seq"=>$dt["PT_SEQ"], 
				"ptCode"=>$dt["PT_CODE"], 
				"ptGroup"=>$dt["PT_GROUP"],
				"ptGroupName"=>$ptGroupName, 
				"ptName1"=>$dt["PT_NAME1"], ///태그명1
				"ptName2"=>$dt["PT_NAME2"], 
				"ptName3"=>$dt["PT_NAME3"],
				"ptDate"=>$dt["PTDATE"] 
				); 

			array_push($json["list"], $addarray);
		}

		$json["decoctypeList"]=$dcTitleList;

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";	
	}

	///ptGroup 을 선전일반후하별전으로 변환
	function decoctype($code)
	{
		switch($code){
			case "infirst":$str="선전";break;
			case "inmain":$str="일반";break;
			case "inafter":$str="후하";break;
			case "inlast":$str="별전";break;
			default:
		}
		return $str;
	}

?>