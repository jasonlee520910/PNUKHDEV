<?php
	//약재보고서
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	$searyear=$_GET["searyear"];//년 
	$searmonth=$_GET["searmonth"];//월 
	$searday=$_GET["searday"];//일
	$seartime=$_GET["seartime"];//일

	$searyear1=$_GET["searyear1"];//년 
	$searmonth1=$_GET["searmonth1"];//월 
	$searday1=$_GET["searday1"];//일
	$seartime1=$_GET["seartime1"];//일

	$searchtxt=urldecode($_GET["searchtxt"]);//약재명 

	$weekly=$_GET["weekly"];//요일 
	$weekday=$_GET["weekday"];//주차 

	if($searmonth == "all")
	{
		$start_date = date("Y-m-d", mktime(0, 0, 0, 1 , 1, $searyear)); //해당년의 1월1일부터
		$end_date = date("Y-m-d", mktime(0, 0, 0, 13, 0, $searyear)); //해당년의 12월 마지막일까지 
	}
	else
	{
		if($searday == "all")
		{
			$start_date = date("Y-m-d", mktime(0, 0, 0, $searmonth , 1, $searyear)); //해당년월의 1일부터 
			$end_date = date("Y-m-d", mktime(0, 0, 0, $searmonth+1 , 0, $searyear)); //해당년월의 마지막일까지 
		}
		else
		{
			
			$start_date = date("Y-m-d H:i:s", mktime($seartime, 0, 0, $searmonth , $searday, $searyear)); 
			if($seartime1==0)
			{
				$end_date = date("Y-m-d H:i:s", mktime($seartime1, 0, 0, $searmonth1 , $searday1, $searyear1)); 
			}
			else
			{
				$end_date = date("Y-m-d H:i:s", mktime($seartime1, 59, 59, $searmonth1 , $searday1, $searyear1)); 
			}
		}
	}
	//mktime함수의 인자는 순서대로 시간, 분, 초, 월, 일, 년도 입니다.

	$json["start_date"] = $start_date;
	$json["end_date"] = $end_date;


	if($apiCode!="medicines"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicines";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//해당하는 년월일의 데이터를 뽑아오자!
		$sql=" select ";
		$sql.=" a.db_mdcode, b.mm_title_kor as mmTitle, b.mm_unit, sum(REPLACE(a.db_mdcapa,'P','')) as totalmdcapa, sum(REPLACE(a.db_makingcapa,'P','')) as totalmkcapa ";
		$sql.=" ,(select LISTAGG(mb_table, ',')  WITHIN GROUP (ORDER BY mb_table asc) from han_medibox where mb_medicine=a.db_mdcode) as mbTable  ";
		$sql.=" ,(select md_origin_kor from han_medicine where md_code=a.db_mdcode) as mdOrigin   ";
		$sql.=" from han_dashboard a ";
		$sql.=" inner join han_medicine_djmedi b on b.md_code=a.db_mdcode ";
		$sql.=" where to_char(a.db_oddate,'YYYY-MM-DD hh24:mi:ss') >= '".$start_date."' AND to_char(a.db_oddate,'YYYY-MM-DD hh24:mi:ss') <= '".$end_date."' ";

		if($searchtxt)
		{
			$sql.=" and b.mm_title_kor like '%".$searchtxt."%' ";
		}
		

		$sql.=" group by a.db_mdcode, b.mm_title_kor, b.mm_unit ";
		$sql.=" order by totalmkcapa DESC ";

		$res=dbqry($sql);
		$json["list"]=array();
		$medicine="";
		while($dt=dbarr($res))
		{
			$mm_unit=($dt["MM_UNIT"])?floatval($dt["MM_UNIT"]):0;
			$totalmkcapa=($dt["TOTALMKCAPA"])?floor($dt["TOTALMKCAPA"]):0;
			if($mm_unit>0)
			{
				$mminput=round($totalmkcapa/$mm_unit, 2);
			}
			else
			{
				$mminput=0;
			}
			$addarray=array(
				"db_mdcode"=>$dt["DB_MDCODE"], 
				"mdOrigin"=>$dt["MDORIGIN"],
				"mmTitle"=>$dt["MMTITLE"], 
				"mb_table"=>$dt["MBTABLE"],
				"mm_unit"=>$mm_unit,//단위
				"mminput"=>$mminput,//투입량 
				"totalmdcapa"=>floor($dt["TOTALMDCAPA"]), //처방용량
				"totalmkcapa"=>$totalmkcapa//조제용량 
			);

			$medicine.=",'".$dt["DB_MDCODE"]."'";

			array_push($json["list"], $addarray);
		}
		$json["sql"] = $sql;

		if($medicine)
		{
			$medicine=substr($medicine,1);

			//누적사용량을 가져오기 위함 
			$sql=" select ";
			$sql.=" a.db_mdcode, sum(REPLACE(a.db_mdcapa,'P','')) as totalmdcapa, sum(REPLACE(a.db_makingcapa,'P','')) as totalmkcapa ";
			$sql.=" from han_dashboard a ";
			$sql.=" inner join han_medicine_djmedi b on b.md_code=a.db_mdcode and b.MM_USE<>'D' ";
			$sql.=" where a.db_mdcode in (".$medicine.") ";
			$sql.=" group by a.db_mdcode ";
			$sql.=" order by decode(a.db_mdcode, ".$medicine.") ";

			$json["누적sql"] = $sql;

			$res=dbqry($sql);
			$json["totlalist"]=array();
			while($dt=dbarr($res))
			{
				$addarray=array(
					"db_mdcode"=>$dt["DB_MDCODE"], 
					"accruemdcapa"=>floor($dt["TOTALMDCAPA"]), //처방용량
					"accruemkcapa"=>floor($dt["TOTALMKCAPA"])//조제용량 
				);
				$json["totlalist"][$dt["DB_MDCODE"]]=$addarray;
			}
		}

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>