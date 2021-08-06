<?php  
	///약재관리 > 본초분류관리 > 본초분류목록 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="hubcatelist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="hubcatelist";}
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

		$jsql=" a  ";
		$wsql=" where mc_use <>'D' ";

		$pg=apipaging("a.mc_seq","medicate",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.mc_code01, a.mc_code02) NUM ";
		$sql.=" ,a.mc_seq, a.mc_code, a.mc_code01, a.mc_title01_kor, a.mc_title01_chn, a.mc_code02, a.mc_title02_kor, a.mc_title02_chn ";
		$sql.=" from ".$dbH."_medicate $jsql $wsql  ";
		$sql.=" order by a.mc_code01, a.mc_code02 ";
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

			if($dt["MC_TITLE02_KOR"]=="" || $dt["MC_TITLE02_KOR"]==null){$MC_TITLE02_KOR="";}else{$MC_TITLE02_KOR=$dt["MC_TITLE02_KOR"];}
			if($dt["MC_TITLE02_CHN"]=="" || $dt["MC_TITLE02_CHN"]==null){$MC_TITLE02_CHN="";}else{$MC_TITLE02_CHN=$dt["MC_TITLE02_CHN"];}

			$addarray=array(
				"seq"=>$dt["MC_SEQ"], 
				"mcCode"=>$dt["MC_CODE"], 
				"mcCode01"=>$dt["MC_CODE01"], 
				"mcTitle01Kor"=>$dt["MC_TITLE01_KOR"], 
				"mcTitle01Chn"=>$dt["MC_TITLE01_CHN"], 
				"mcCode02"=>$dt["MC_CODE02"],
				"mcTitle02Kor"=>$MC_TITLE02_KOR,
				"mcTitle02Chn"=>$MC_TITLE02_CHN
				);

			array_push($json["list"], $addarray);

		}
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}
?>