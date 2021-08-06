<?php
	/// 환경설정 > 개인정보처리 > 상세
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$poGroup=$_GET["poGroup"];
	$returnData=$_GET["returnData"];

	if($apiCode!="policydesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="policydesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else{
		
		$hCodeList = getNewCodeTitle("inPolicy,bbUse");
		$inPolicyList = getCodeList($hCodeList, 'inPolicy');//개인정보방침 종류 


		$sql="  select a.PO_SEQ,  a.PO_SORT, a.PO_TYPE, a.PO_CONTENTS, a.PO_LINK, b.cd_name_kor POTYPENAME 
				 from ".$dbH."_policy a 
				 left join ".$dbH."_code b on  b.cd_type='inPolicy' and b.cd_code=a.PO_TYPE and b.cd_use='Y' 
				 where to_char(PO_GROUP, 'yyyy-mm-dd')='".$poGroup."' and PO_USE='Y' 
				 order by a.PO_SORT asc ";
		$res=dbqry($sql);

		$json["policy"]=array();
		while($dt=dbarr($res))
		{
			$addarray=array(
				"poSeq"=>$dt["PO_SEQ"], //seq
				"poSort"=>$dt["PO_SORT"],
				"poType"=>$dt["PO_TYPE"],//종류
				"poTypeName"=>$dt["POTYPENAME"],//종류
				"poContents"=>getClob($dt["PO_CONTENTS"]),///내용
				"poLinks"=>$dt["PO_LINK"]//link 
			);
			array_push($json["policy"], $addarray);
		}

		$json["poGroup"]=$poGroup;
		$json["sql"]=$sql;


		$json["inPolicyList"]=$inPolicyList;
		

		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>