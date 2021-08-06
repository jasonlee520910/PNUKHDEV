<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$ma_table=$_GET["maTable"];

	if($apicode!="list"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="list";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($ma_table==""){$json["resultMessage"]="API(TableNo) ERROR";}
	else{
		$sql=" select md_code, md_title_".$language." name from ".$dbH."_medicine ";
		$res=dbqry($sql);
		while($dt=dbarr($res)){
			$medi[$dt["MD_CODE"]]=$dt["NAME"];
		}

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$jsql=" a inner join ".$dbH."_making m on a.od_code=m.ma_odcode ";
		$jsql.=" inner join ".$dbH."_staff s on m.ma_staffid=s.st_staffid ";
		$jsql.=" inner join ".$dbH."_recipeuser r on a.od_scription=r.rc_code ";
		$wsql="  where a.od_use <> 'D' and m.ma_table = '".$ma_table."' and m.ma_tablestat is null ";

		$ssql="a.od_seq, a.od_code, a.od_chubcnt, m.ma_table, m.ma_title, m.ma_staffid, s.st_name, r.rc_medicine as RCMEDICINE ";
		$sql=" select $ssql from ".$dbH."_order $jsql $wsql order by a.od_date ";

		$res=dbqry($sql);
		//$json["sql"]=$sql;
		$json["list"]=array();
		while($dt=dbarr($res)){
			$arr=explode("|",getClob($dt["RCMEDICINE"]));
			$infirst=array();
			$inmain=array();
			$inafter=array();
			$infirst_capa=0;
			$inmain_capa=0;
			$inafter_capa=0;
			foreach($arr as $val){
				$arr2=explode(",",$val);
				$sql2=" select mb_code from ".$dbH."_medibox where mb_medicine='".$arr2[0]."' and  mb_table = '".$ma_table."' and mb_use='Y' ";
				$dt2=dbone($sql2);
				$mbCode=$dt2["MB_CODE"];
				$indata=array("mdCode"=>$arr2[0],"mdName"=>$medi[$arr2[0]],"mdCapa"=>$arr2[1],"mediBox"=>$mbCode);
				switch($arr2[2]){
					case "infirst":
						if($indata)array_push($infirst, $indata);
						$infirst_capa+=$arr2[1];
						break;
					case "inmain":
						if($indata)array_push($inmain, $indata);
						$inmain_capa+=$arr2[1];
						break;
					case "inafter":
						if($indata)array_push($inafter, $indata);
						$inafter_capa+=$arr2[1];
						break;
				}
			}
			$medicine=array("infirst"=>$infirst,"infirstTotal"=>$infirst_capa * $dt["OD_CHUBCNT"],"inmain"=>$inmain,"inmainTotal"=>$inmain_capa * $dt["OD_CHUBCNT"],"inafter"=>$inafter,"inafterTotal"=>$inafter_capa * $dt["OD_CHUBCNT"]);
			$addarray=array("seq"=>$dt["OD_SEQ"], "odCode"=>$dt["OD_CODE"], "maTable"=>$dt["MA_TABLE"], "maTitle"=>$dt["MA_TITLE"], "stUserid"=>$dt["MA_STAFFID"], "stName"=>$dt["ST_NAME"], "medicine"=>$medicine);
			array_push($json["list"], $addarray);
		}

		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>