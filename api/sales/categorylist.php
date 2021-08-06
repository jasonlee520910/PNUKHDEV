<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	if($apicode!="categorylist"){$json["resultMessage"]="API코드오류";$apicode="categorylist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	//else if($esStaffid==""){$json["resultMessage"]="userid 없음";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$json["list"]=array();
		$sql=" select * from han_salescategory where sc_use='Y' order by field(sc_group, 'sw','sp','eq','op'), sc_code ";
		$res=dbqry($sql);
		while($dt=dbarr($res)){
			if($dt["sc_modify"]){$scDate=$dt["sc_modify"];}else{$scDate=$dt["sc_date"];}
			$addarray=array("group"=>$dt["sc_group"], "code"=>$dt["sc_code"], "titleKor"=>$dt["sc_title_kor"], "titleChn"=>$dt["sc_title_chn"], "titleEng"=>$dt["sc_title_eng"], "date"=>$scDate);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>