<?php
	$apicode=$resjson["apiCode"];
	$language=$resjson["language"];
	if($apicode!="categoryupdate"){$json["resultMessage"]="API코드오류";$apicode="categoryupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	//else if($spStaffid==""){$json["resultMessage"]="userid 없음";}
	else{
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		foreach($resjson["list"] as $val){
			$sql=" insert into ".$dbH."_salescategory (sc_code, sc_group, sc_title_kor, sc_title_chn, sc_title_eng, sc_use, sc_date) values('".$val["code"]."', '".$val["group"]."', '".$val["titleKor"]."', '".$val["titleChn"]."', '".$val["titleEng"]."', 'Y', now()) on duplicate key update sc_title_kor='".$val["titleKor"]."', sc_title_chn='".$val["titleChn"]."', sc_title_eng='".$val["titleEng"]."', sc_modify=now()  ";
			$sqlall.=$sql;
			dbqry($sql);
		}

		$sql=" update ".$dbH."_salesprice set sp_use='U' where sp_use='Y' ";
		dbqry($sql);

		$sql=" update ".$dbH."_estimate set es_use='U' where es_use='Y' and es_type='basic' ";
		dbqry($sql);

		$json["sql"]=$sqlall;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>