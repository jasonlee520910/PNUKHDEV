<?php
	//POST
	//$resjson = json_decode(file_get_contents('php://input'),true);
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	if($apiCode!="textdblist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="textdblist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else{
		$returnData=$_GET["returnData"];
		
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];

		//------------------------------------------------------------
		$hCodeList = getNewCodeTitle('txtType');		
		$txtTypeList = getCodeList($hCodeList, 'txtType');//사이트타입   
		//------------------------------------------------------------



		$jsql="";
		$wsql=" where td_use <> 'D' ";
		$osql=" order by td_date DESC, td_name_chn ASC, td_code ASC";

		if($searchtype&&$searchtxt)
		{
			if($searchtype=="all")
			{
				$wsql.=" and (td_code like '%".$searchtxt."%'";
				$wsql.=" or td_name_kor like '%".$searchtxt."%'";
				$wsql.=" or td_name_chn like '%".$searchtxt."%'";
				$wsql.=" or td_name_eng like '%".$searchtxt."%' ) ";
			}
			else
			{
				if($searchtype=="tdCode")
				{
					$field=substr($searchtype,0,2)."_".strtolower(substr($searchtype,2,20));
				}
				else
				{
					$field=substr($searchtype,0,2)."_name_".strtolower(substr($searchtype,6,3));
				}
				$wsql.=" and ".$field." like '%".$searchtxt."%' ";
			}
		}

		if($searchtxt)
		{
			$wsql.=" and (td_code like '%".$searchtxt."%'";
			$wsql.=" or td_name_kor like '%".$searchtxt."%'";
			$wsql.=" or td_name_chn like '%".$searchtxt."%'";
			$wsql.=" or td_name_eng like '%".$searchtxt."%' ) ";
		}

		$pg=apipaging("td_seq","txtdata",$jsql,$wsql);
		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY td_type) NUM ";
		$sql.=" ,td_seq, td_code, td_type, substr(td_code,1, 1) as TYPECODE, td_name_kor, td_name_chn, td_name_eng, to_char(td_date, 'yyyy-mm-dd hh24:mi:ss') as TDDATE ";
		$sql.=" from ".$dbH."_txtdata $jsql $wsql $osql ";
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
			$kor = ($dt["TD_NAME_KOR"]) ? $dt["TD_NAME_KOR"] : "";
			$chn = ($dt["TD_NAME_CHN"]) ? $dt["TD_NAME_CHN"] : "";
			$eng = ($dt["TD_NAME_ENG"]) ? $dt["TD_NAME_ENG"] : "";
			if($dt["TD_TYPE"]==0) //TBMS
			{
				$tdTypeName=getTxtType($txtTypeList, "0");
				$typeCode="0";
			}
			else
			{
				$tdTypeName=getTxtType($txtTypeList, $dt["TYPECODE"]);
				$typeCode=$dt["TYPECODE"];
			}

			$addarray=array(
				"seq"=>$dt["TD_SEQ"], 
				"typeCode"=>$typeCode,
				"tdCode"=>$dt["TD_CODE"], 
				"tdTypeName"=>$tdTypeName, 
				"tdNameKor"=>$kor, 
				"tdNameChn"=>$chn, 
				"tdNameEng"=>$eng,
				"tdDate"=>$dt["TDDATE"]
				);
			array_push($json["list"], $addarray);
		}

		$json["txtTypeList"]=$txtTypeList;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

	//타입 
	function getTxtType($arr, $data)
	{
		$str="MANAGER";
		for($i=0;$i<count($arr);$i++)
		{
			if($arr[$i]["cdCode"]==$data)
			{
				$str=$arr[$i]["cdName"];
				break;
			}
		}
		return $str;
	}
?>