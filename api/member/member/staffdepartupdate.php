<?php
	/// 로그인화면에서 파트별 선택부분 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$st_loginid=$_GET["stLoginId"];
	$st_depart=$_GET["stDepart"];

	if($apiCode!="staffdepartupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="staffdepartupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($st_loginid==""){$json["resultMessage"]="API(stLoginId) ERROR";}
	else if($st_depart==""){$json["resultMessage"]="API(st_depart) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		/// update 부분은 dbcommit으로 
		$sql=" update han_staff set st_depart='".$st_depart."' where st_userid='".$st_loginid."' ";//update 할때 끝에 ; 있으면 commit이 안됨..
		dbcommit($sql);

		$sql="select st_depart, st_userid from han_staff where st_userid='".$st_loginid."' ";
		$dt=dbone($sql);

		$json["st_depart"]=$dt["ST_DEPART"];
		$json["stUserId"]=$dt["ST_USERID"];

		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>