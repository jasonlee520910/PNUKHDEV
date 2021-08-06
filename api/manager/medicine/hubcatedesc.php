<?php  
	///약재관리 > 본초분류관리 > 본초분류목록 리스트 중 상세보기
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mc_seq=$_GET["seq"];
	
	if($apiCode!="hubcatedesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="hubcatedesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mc_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$page=$_GET["page"];

		$sql=" select mc_seq,mc_code,mc_code01,mc_title01_kor,mc_title01_chn,mc_code02,mc_title02_kor,mc_title02_chn ";
		$sql.=" from ".$dbH."_medicate where mc_seq='".$mc_seq."'";
		$dt=dbone($sql);
		$json=array(
			
			"seq"=>$dt["MC_SEQ"], 
			"mcCode"=>$dt["MC_CODE"], 
			"mcCode01"=>$dt["MC_CODE01"], 
			"mcTitle01Kor"=>$dt["MC_TITLE01_KOR"], 
			"mcTitle01Chn"=>$dt["MC_TITLE01_CHN"], 
			"mcCode02"=>$dt["MC_CODE02"], 
			"mcTitle02Kor"=>$dt["MC_TITLE02_KOR"],
			"mcTitle02Chn"=>$dt["MC_TITLE02_CHN"]
			);

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>