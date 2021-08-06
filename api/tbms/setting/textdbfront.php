<?php
	//POST
	//$resjson = json_decode(file_get_contents('php://input'),true);
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	if($apiCode!="textdbfront"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="textdbfront";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		//$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$type=$_GET["type"];
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];

		$jsql="";
		$wsql=" where td_use <> 'D' ";
		//$osql=" order by td_name_chn, td_code ";

		if($searchtype&&$searchtxt){
			if($searchtype=="all"){
				$wsql.=" and (td_code like '%".$searchtxt."%'";
				$wsql.=" or td_name_kor like '%".$searchtxt."%'";
				$wsql.=" or td_name_chn like '%".$searchtxt."%'";
				$wsql.=" or td_name_eng like '%".$searchtxt."%' ) ";
			}else{
				if($searchtype=="tdCode"){
					$field=substr($searchtype,0,2)."_".strtolower(substr($searchtype,2,20));
				}else{
					$field=substr($searchtype,0,2)."_name_".strtolower(substr($searchtype,6,3));
				}
				$wsql.=" and ".$field." like '%".$searchtxt."%' ";
			}
		}
		if($type){
			switch($type){
				case "medical":
					$wsql.=" and left(td_code,1) = '7' ";
					break;
				case "manager":
					$wsql.=" and left(td_code,1) = '1' ";
					break;
				case "care":
					$wsql.=" and left(td_code,1) = '5' ";
					break;
				case "front":
					$wsql.=" and td_type = '0' and td_code not like 'step%'"; //step으로 시작하는것은 각 makinglist, decoctionlist, markinglist, releaselist 에서 로드를 하기 땜시 제외함.
					break;
			}
		}

		//$pg=apipaging("td_seq","txtdata",$jsql,$wsql);
		//$sql=" select * from ".$dbH."_txtdata $jsql $wsql order by td_name_chn, td_date desc limit ".$pg["snum"].", ".$pg["psize"];
		$sql=" select td_code, td_name_".$language." td_name from ".$dbH."_txtdata $jsql $wsql $osql ";
		$res=dbqry($sql);
		while($dt=dbarr($res)){
			$json[$dt["td_code"]]=$dt["td_name"];
		}
		//$json["sql"]=$sql;
		$json["apiCode"]=$apicode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>