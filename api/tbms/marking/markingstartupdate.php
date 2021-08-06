<?php 
	//마킹에서 파우치 클릭시 log 남기기 

	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$odCode=$_POST["odCode"];
	$staffid=$_POST["staffid"];
	$mrPrinter=$_POST["mrPrinter"];

	if($apiCode!="markingstartupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="markingstartupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//han_markingprinter 테이블에 mp_odcode, mp_starttime, mp_staff , mp_finishtime='0000-00-00 00:00:00' update 
		//- han_markinglog insert 
		//- han_markingprinter 테이블에 mp_count 추가 

		$nowDate=date("Y-m-d H:i:s");

		//han_markingprinter table update 
		$sql=" update ".$dbH."_markingprinter set mp_odcode='".$odCode."', mp_staff='".$staffid."', mp_starttime=to_date('".$nowDate."','YYYY-MM-DD hh24:mi:ss'), mp_count='0', mp_finishtime=NULL where mp_code='".$mrPrinter."' ";
		dbcommit($sql);
		$json["start1"]=$sql;

		$sql="select mo_odcode from ".$dbH."_markinglog where mo_odcode ='".$odCode."'  ";
		$dt=dbone($sql);
		if($dt["MO_ODCODE"])
		{
			$sql=" update ".$dbH."_markinglog set mo_code='".$mrPrinter."', mo_starttime=to_date('".$nowDate."','YYYY-MM-DD hh24:mi:ss'), mo_count='0', mp_finishtime=NULL where mo_odcode ='".$odCode."' ";
			dbcommit($sql);
			$json["start2"]=$sql;

		}
		else
		{
			//han_markinglog table insert 
			$sql=" insert into ".$dbH."_markinglog (MO_SEQ, mo_code, mo_odcode, mo_starttime, mo_finishtime, mo_count, mo_use, mo_date) values ((SELECT NVL(MAX(MO_SEQ),0)+1 FROM ".$dbH."_markinglog),'".$mrPrinter."','".$odCode."',to_date('".$nowDate."','YYYY-MM-DD hh24:mi:ss'),NULL, '0','Y', sysdate); ";
			dbcommit($sql);
			$json["start3"]=$sql;
		}
		
		

		//$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>