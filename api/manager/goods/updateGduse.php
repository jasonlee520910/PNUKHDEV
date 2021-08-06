<?php  
	/// 제품재고관리 > 제품목록 > 상세보기 > 승인전이나 승인완료버튼을 누르면 바로 처리
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$gd_seq=$_GET["seq"];
	$chk=$_GET["chk"];

	if($apiCode!="updateGduse"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="updateGduse";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	//else if($gd_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$sql=" update ".$dbH."_goods set gd_use='".$chk."' where gd_seq='".$gd_seq."'";
		//echo $sql;
		dbcommit($sql);

		$returnData=urldecode($_GET["returnData"]);
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>