<?php
	//약재보고서
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	$searyear=$_GET["searyear"];//년 
	$searmonth=$_GET["searmonth"];//월 
	$searday=$_GET["searday"];//일

	$mdcode=$_GET["mdcode"];//약재코드 

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
			$start_date = date("Y-m-d", mktime(0, 0, 0, $searmonth , $searday, $searyear)); 
			$end_date = date("Y-m-d", mktime(0, 0, 0, $searmonth , $searday, $searyear)); 
		}
	}

	if($apiCode!="onemedicine"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="onemedicine";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//해당하는 년월일의 데이터를 뽑아오자!
		$sql=" select ";
		$sql.=" a.db_oddate, b.od_title, a.db_mdcapa, a.db_makingcapa, to_char(a.db_mkend, 'yyyy-mm-dd hh24:mi:ss') as dbmkend ";
		$sql.=" from han_dashboard a  ";
		$sql.=" inner join han_order b on a.db_odcode=b.od_code ";
		$sql.=" where a.db_mdcode='".$mdcode."' and to_char(a.db_oddate,'YYYY-MM-DD hh24:mi:ss') >= '".$start_date." 00:00:00' AND to_char(a.db_oddate,'YYYY-MM-DD hh24:mi:ss') <= '".$end_date." 23:59:59' ";
		$sql.=" order by a.db_oddate DESC ";

		$res=dbqry($sql);
		$json["list"]=array();
		while($dt=dbarr($res))
		{
			$addarray=array(
				"db_oddate"=>$dt["DB_ODDATE"], 
				"od_title"=>$dt["OD_TITLE"], 
				"db_mdcapa"=>$dt["DB_MDCAPA"], 				
				"db_makingcapa"=>$dt["DB_MAKINGCAPA"], //처방용량
				"db_mkend"=>$dt["DBMKEND"]//조제용량 
			);

			array_push($json["list"], $addarray);
		}

		$json["sql"] = $sql;
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>