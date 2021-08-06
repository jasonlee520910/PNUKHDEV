<?php  
	/// 자재코드관리 > 약재함관리 > 삭제
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mb_seq=$_GET["seq"];

	if($apicode!="mediboxdelete"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="mediboxdelete";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mb_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		///약재함에 capa가 있는지 체크
		$sql=" select mb_capacity from ".$dbH."_medibox where mb_seq='".$mb_seq."'";
		$dt=dbone($sql);
				
		if($dt["MB_CAPACITY"]==0)
		{
			$sql=" update ".$dbH."_medibox set mb_use='D', mb_modify=SYSDATE where mb_seq='".$mb_seq."'";
			dbcommit($sql);

			$returnData=$_GET["returnData"];
			$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";	
		}
		else
		{
			$json["resultCode"]="209";
			$json["resultMessage"]="1941";//재고가 있어서 삭제할수없습니다. 
		}
	}
?>