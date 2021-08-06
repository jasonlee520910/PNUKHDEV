<?php
	//처방보고서 - 요일별 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	$gender=$_GET["gender"]; //성별 female , male
	$searyear=$_GET["searyear"];//년 
	$searmonth=$_GET["searmonth"];//월 
	$start_date = date("Y-m-d", mktime(0, 0, 0, $searmonth , 1, $searyear)); 
	$nowYear=date("Y");
	$nowMonth=date("m");
	if($searyear==$nowYear && $searmonth==$nowMonth) //같은년도,같은월이면 그전주 데이터만 보여주자 
	{
		$t=time()-((date('w')+6)%7+7)*86400;
		$end_date = date('Y-m-d',$t+86400*6);
	}
	else
	{
		$end_date=date("Y-m-d", mktime(0, 0, 0, $searmonth+1 , 0, $searyear)); 
	}

	$age=$_GET["age"];//나이 
	if($age)
	{
		$agearry=explode(",", $age);
	}

	if($apiCode!="recipesweekly"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="recipesweekly";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql=" SELECT  ";
		$sql.=" to_char(a.db_oddate, 'd') AS week_n, ";
		$sql.=" to_char(a.db_oddate, 'dy') as week, ";
		$sql.=" count(db_mdcode) as odcnt, ";
		$sql.=" sum(REPLACE(db_mdcapa,'P','')) as odcapa, ";
		$sql.=" sum(CASE WHEN db_makingcapa='P0' THEN 0 ELSE 1 END) as mkcnt, ";
		$sql.=" sum(REPLACE(db_makingcapa,'P','')) as mkcapa ";
		$sql.=" from han_dashboard a   ";
		$sql.=" where to_char(a.db_oddate,'YYYY-MM-DD hh24:mi:ss') >= '".$start_date." 00:00:00' AND to_char(a.db_oddate,'YYYY-MM-DD hh24:mi:ss') <= '".$end_date." 23:59:59' ";
		//연령별 
		if($age) 
		{
			$sql.=" and (substr(to_char(sysdate, 'yyyy-mm-dd'),1,4)-substr(a.db_birth,1,4)) >= '".$agearry[0]."' and ";
			$sql.=" (substr(to_char(sysdate, 'yyyy-mm-dd'),1,4)-substr(a.db_birth,1,4)) <= '".$agearry[1]."' ";
		}
		//성별 - 초기데이터에는 성별이 없기때문에 

		if($gender == "female") //여자
		{
			$sql.=" and (a.db_gender='2' or a.db_gender is null) ";
		}
		else if($gender == "male") //남자 
		{
			$sql.=" and (a.db_gender='1' or a.db_gender is null  )";
		}
		$sql.=" GROUP BY to_char(a.db_oddate, 'd'),to_char(a.db_oddate, 'dy') ";
		$sql.=" order by to_char(a.db_oddate, 'd') asc ";


		$res=dbqry($sql);
		$json["list"]=array();
		while($dt=dbarr($res))
		{
			$addarray=array(
				"week_n"=>$dt["WEEK_N"], 
				"week"=>$dt["WEEK"], 
				"odcnt"=>$dt["ODCNT"], 
				"odcapa"=>floor($dt["ODCAPA"]), 
				"mkcnt"=>$dt["MKCNT"],
				"mkcapa"=>floor($dt["MKCAPA"])
			);

			array_push($json["list"], $addarray);
		}
		$json["sql"] = $sql;
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>