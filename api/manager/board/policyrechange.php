<?php
	/// 환경설정 > 개인정보처리 > 개인정보처리방침변경 
	$json["resultCode"]="204";
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$poGroup=$_GET["poGroup"];

	if($apicode!="policyrechange"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="policyrechange";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];

		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$poNewGroup=date("Y-m-d", time());

		$sql=" insert into ".$dbH."_policy (PO_SEQ, PO_GROUP, PO_SORT, PO_LINK, PO_TYPE,  PO_CONTENTS, PO_USE, PO_DATE) 
		SELECT (SELECT NVL(MAX(PO_SEQ),0)+1 FROM ".$dbH."_policy), '".$poNewGroup."',PO_SORT, PO_LINK,PO_TYPE,PO_CONTENTS,PO_USE, sysdate FROM ".$dbH."_policy where PO_USE='Y' and to_char(PO_GROUP, 'yyyy-mm-dd')='".$poGroup."' ";
		dbcommit($sql);


		$dsql="UPDATE ".$dbH."_POLICY SET PO_USE='D' WHERE PO_GROUP = ".$poGroup;
		dbcommit($dsql);
		$json["dsql"]=$dsql;
	
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>