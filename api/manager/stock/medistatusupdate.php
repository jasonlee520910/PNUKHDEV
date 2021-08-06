<?php  
	/// 재고관리 > 약재재고목록 > 약재부족시 주문버튼 
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$md_seq=$_POST["seq"];
	if($apicode!="medistatusupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="medistatusupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($md_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		///약재 주문완료로 상태 변경  
		$sql=" update ".$dbH."_medicine set md_status='complete', md_modify=SYSDATE where md_seq = '".$md_seq."' and md_status = 'shortage' ";
		dbcommit($sql);

		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["sql"]=$sql;
	}
?>