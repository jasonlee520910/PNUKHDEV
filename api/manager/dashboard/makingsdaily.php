<?php
	//조제보고서 - 일자별
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	$gender=$_GET["gender"]; //성별 female , male
	$searyear=$_GET["searyear"];//년 
	$searmonth=$_GET["searmonth"];//월 
	$start_date = date("Y-m-d", mktime(0, 0, 0, $searmonth , 1, $searyear)); 
	$end_date = date("Y-m-d", mktime(0, 0, 0, $searmonth+1 , 0, $searyear)); 
	$age=$_GET["age"];//나이 
	if($age)
	{
		$agearry=explode(",", $age);
	}

	if($apiCode!="makingsdaily"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="makingsdaily";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		#조제보고서 일자별 
		$sql=" select  ";
		$sql.=" to_char(a.db_oddate, 'yyyy-mm-dd') as dt, ";
		$sql.=" to_char(a.db_oddate, 'dy') as week, ";
		$sql.=" count(distinct a.db_odcode) as total_cnt, ";
		$sql.=" sum(distinct abs((to_date(to_char(a.db_mkend,'yyyymmddhh24miss'),'yyyymmddhh24miss') - to_date(to_char(a.db_mkstart,'yyyymmddhh24miss'),'yyyymmddhh24miss')))*24*60*60) as total_time, ";
		$sql.=" count(a.db_mdcode) as total_medicine ";
		$sql.=" from han_dashboard a  ";
		$sql.=" where to_char(a.db_oddate,'YYYY-MM-DD hh24:mi:ss') >= '".$start_date." 00:00:00' AND to_char(a.db_oddate,'YYYY-MM-DD hh24:mi:ss') <= '".$end_date." 23:59:59' ";
		$sql.=" and a.db_mkstart is not null and a.db_mkend is not null  ";

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

		$sql.=" group by to_char(a.db_oddate, 'yyyy-mm-dd'), to_char(a.db_oddate, 'dy') ";
		$sql.=" order by to_char(a.db_oddate, 'yyyy-mm-dd') ASC ";


		$res=dbqry($sql);
		$json["list"]=array();
		while($dt=dbarr($res))
		{
			$addarray=array(
				"dt"=>$dt["DT"], 
				"week"=>$dt["WEEK"], 
				"total_cnt"=>$dt["TOTAL_CNT"], 
				"total_time"=>$dt["TOTAL_TIME"],
				"total_medicine"=>$dt["TOTAL_MEDICINE"]
			);

			array_push($json["list"], $addarray);
		}
		$json["sql"] = $sql;
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>