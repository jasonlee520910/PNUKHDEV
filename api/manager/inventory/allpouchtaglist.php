<?php  
	/// 자재코드관리 > 조제태그관리 > 조재태그 바코드 일괄출력
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$type=$_GET["type"];

	if($apiCode!="allpouchtaglist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="allpouchtaglist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql=" select a.pt_code, a.pt_group, b.cd_name_".$language." as cdName ";
		$sql.=" from ".$dbH."_pouchtag a ";
		$sql.=" left join han_code b on b.cd_code=a.pt_group and b.cd_type='dcType' where a.pt_use='Y' and pt_group='".$type."'";
		$sql.=" order by a.pt_group desc, a.pt_code asc ";	
		$res=dbqry($sql);

		$json["list"]=array();
		while($dt=dbarr($res))
		{
			$addarray=array(
				"pt_code"=>$dt["PT_CODE"], 
				"pt_group"=>$dt["PT_GROUP"],
				"pt_groupName"=>$dt["CDNAME"]
				);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>