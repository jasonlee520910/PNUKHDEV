<?php 
	//마킹완료시 

	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$odCode=$_POST["odCode"];
	$mrPrinter=$_POST["mrPrinter"];

	if($apiCode!="markingfinishupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="markingfinishupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//- 완료되면 makingprinter, markinglog :: finishtime . mp_count update 

		//markingprinter에 있는 count를 가져오자 
		$sql="select mp_count from ".$dbH."_markingprinter where mp_code='".$mrPrinter."' ";
		$dt=dbone($sql);
		$mp_count=$dt["MP_COUNT"];

		$nowDate=date("Y-m-d H:i:s");

		//han_markingprinter table update 
		$sql=" update ".$dbH."_markingprinter set mp_finishtime=to_date('".$nowDate."','YYYY-MM-DD hh24:mi:ss') where mp_code='".$mrPrinter."' ";
		dbcommit($sql);
		$json["sql1"]=$sql;

		//han_markinglog table update  
		$sql=" update ".$dbH."_markinglog set mo_finishtime=to_date('".$nowDate."','YYYY-MM-DD hh24:mi:ss'), mo_count='".$mp_count."' where mo_code='".$mrPrinter."' and mo_odcode='".$odCode."' ";
		dbcommit($sql);
		$json["sql2"]=$sql;


		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>