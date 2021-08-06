<?php
	//주문보고서 - 일자별
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

	if($apiCode!="ordersdaily"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="ordersdaily";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql=" SELECT ";
		$sql.=" to_char(a.od_date, 'yyyy-mm-dd') as dt, ";
		$sql.=" to_char(a.od_date, 'dy') as week, ";
		$sql.=" count(case when a.od_sitecategory = 'MANAGER' and a.od_status not like '%cancel' then 1 end) as manager_cnt, ";
		$sql.=" count(case when a.od_sitecategory = 'CLIENT' and a.od_status not like '%cancel' then 1 end) as client_cnt, ";
		$sql.=" count(case when a.od_sitecategory = 'MEDICAL' and a.od_status not like '%cancel' then 1 end) as medical_cnt, ";
		$sql.=" count(case when a.od_status like '%cancel' then 1 end) as cancel_cnt, ";
		$sql.=" count(a.od_seq) as total_cnt ";
		$sql.=" from han_order a ";
		$sql.=" where to_char(a.od_date,'YYYY-MM-DD hh24:mi:ss') >= '".$start_date." 00:00:00' AND to_char(a.od_date,'YYYY-MM-DD hh24:mi:ss') <= '".$end_date." 23:59:59' and a.od_use ='Y' ";

		//연령별 
		if($age) 
		{
			$sql.=" and (substr(to_char(sysdate, 'yyyy-mm-dd'),1,4)-substr(to_char(a.od_birth, 'yyyy-mm-dd'),1,4)) >= '".$agearry[0]."' and ";
			$sql.=" (substr(to_char(sysdate, 'yyyy-mm-dd'),1,4)-substr(to_char(a.od_birth, 'yyyy-mm-dd'),1,4)) <= '".$agearry[1]."' ";
		}
		//성별 - 초기데이터에는 성별이 없기때문에 

		if($gender == "female") //여자
		{
			$sql.=" and (a.od_gender='female' or a.od_gender ='none') ";
		}
		else if($gender == "male") //남자 
		{
			$sql.=" and (a.od_gender='male' or a.od_gender='none'  )";
		}

		$sql.=" GROUP BY to_char(a.od_date, 'yyyy-mm-dd'), to_char(a.od_date, 'dy'), substr(to_char(a.od_birth, 'yyyy-mm-dd'),1,4) ";
		$sql.=" ORDER BY to_char(a.od_date, 'yyyy-mm-dd') ASC ";

		$res=dbqry($sql);
		$json["list"]=array();
		while($dt=dbarr($res))
		{
			$addarray=array(
				"dt"=>$dt["DT"], 
				"week"=>$dt["WEEK"], 
				"total_cnt"=>$dt["TOTAL_CNT"], 
				"cy_cnt"=>$dt["CLIENT_CNT"],
				"manager_cnt"=>$dt["MANAGER_CNT"], 
				"medical_cnt"=>$dt["MEDICAL_CNT"], 
				"cancel_cnt"=>$dt["CANCEL_CNT"]
			);

			array_push($json["list"], $addarray);
		}
		$json["sql"] = $sql;
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>