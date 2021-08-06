<?php  
	///약재관리 > 제조사관리 > 등록
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	
	if($apiCode!="makerupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="makerupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	//else if($mi_userid==""){$json["resultMessage"]="API(userid) ERROR";}
	else
	{
		$makername=trim($_POST["makername"]);


		$sql=" select * from  ( select cd_type from ".$dbH."_maker order by cd_seq desc) where rownum <= 1 ";
		$dt=dbone($sql);

		$cd_type=$dt["CD_TYPE"]+1;

		$newcode=sprintf("%04d",$cd_type);
	
		$sql2=" insert into ".$dbH."_maker (cd_seq,cd_type,cd_name_kor,cd_use, cd_date, cd_modify)";
		$sql2.="values ((SELECT NVL(MAX(cd_seq),0)+1 FROM ".$dbH."_maker),'".$newcode."', '".$makername."','Y', SYSDATE, SYSDATE) ";

		dbcommit($sql2);
		
		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apiCode,"seq"=>$me_seq,"returnData"=>$returnData);
		$json["sql"]=$sql;
		$json["sql2"]=$sql2;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>