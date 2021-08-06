<?php  //release orderlist
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odcode=$_GET["odcode"];

	if($apiCode!="releasephotolist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="releasephotolist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$json["files"] = array();

		//촬영한것 
		$gsql=" select af_seq,af_url,af_use,to_char(AF_DATE, 'yyyy-mm-dd hh24:mi:ss') as AFDATE  from ".$dbH."_file where af_code = '".$odcode."' and af_fcode like 'release_medibox%' and af_use = 'Y' order by af_seq asc ";	
		$gres=dbqry($gsql);
		while($gdt=dbarr($gres))
		{
			$afThumbUrl=getafThumbUrl($gdt["AF_URL"]);

			//여러개
			$addarray=array(
				"afseq"=>$gdt["AF_SEQ"],
				"afThumbUrl"=>$afThumbUrl,
				"afUrl"=>$gdt["AF_URL"],
				"afUse"=>$gdt["AF_USE"],
				"afDate"=>$gdt["AFDATE"]
			);
			array_push($json["files"], $addarray);
		}

		$json["gsql"] = $gsql;
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";


	}
?>