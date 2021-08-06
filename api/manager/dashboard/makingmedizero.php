<?php
	//약재보고서
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	$seardate=$_GET["seardate"];//년 
	$searorder=$_GET["searorder"];//order by 
	$searalign=$_GET["searalign"];//order by 


	if($apiCode!="makingmedizero"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="makingmedizero";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$searorder=($searorder) ? $searorder : "makingcapa";
		$searalign=($searalign) ? $searalign : "DESC";

		$sql=" select  ";
		$sql.=" a.db_mdcode, (b.mm_title_kor||'('||b.mm_title_chn||')') as mmTitle , sum(a.db_mdcapa) as mdcapa, sum(REPLACE(a.db_makingcapa,'P','')) as makingcapa ";
		$sql.=" from han_dashboard a ";
		$sql.=" inner join han_medicine_".$refer." b on b.md_code=a.db_mdcode and b.mm_use <>'D'  ";
		$sql.=" where to_char(a.db_oddate,'YYYY-MM-DD hh24:mi:ss') >= '".$seardate." 00:00:00' AND to_char(a.db_oddate,'YYYY-MM-DD hh24:mi:ss') <= '".$seardate." 23:59:59' ";
		$sql.=" group by a.db_mdcode, (b.mm_title_kor||'('||b.mm_title_chn||')') ";
		$sql.=" order by ".$searorder." ".$searalign;



		$res=dbqry($sql);
		$json["list"]=array();
		$medicine="";
		while($dt=dbarr($res))
		{
			$addarray=array(
				"db_mdcode"=>$dt["DB_MDCODE"], 
				"mmTitle"=>$dt["MMTITLE"], 
				"mdcapa"=>$dt["MDCAPA"], 				
				"makingcapa"=>$dt["MAKINGCAPA"]
			);

			array_push($json["list"], $addarray);
		}
		$json["sql"] = $sql;
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>