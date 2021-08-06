<?php 
	//마킹에서 파우치 클릭시 log 남기기 

	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$odCode=$_POST["odCode"];
	$mrPrinter=$_POST["mrPrinter"];
	$odCount=$_POST["odCount"];


	if($apiCode!="markingcountupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="markingcountupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//- 카운터될때마다 han_markingprinter 테이블에 mp_count만 update 하라 

		//han_markingprinter table update 
		$sql=" update ".$dbH."_markingprinter set mp_count='".$odCount."' where mp_code='".$mrPrinter."' and mp_odcode='".$odCode."' ";
		dbcommit($sql);

		

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>