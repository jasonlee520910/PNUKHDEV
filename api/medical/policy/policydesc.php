<?php  
	///개인정보처리방침 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	if($apiCode!="policydesc"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="policydesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql=" select to_char(a.PO_GROUP, 'yyyy-mm-dd') as poGroup from ".$dbH."_policy a 
				where a.PO_USE <> 'D' and ROWNUM=1 
				group by a.PO_GROUP 
				order by a.PO_GROUP desc ";
		$dt=dbone($sql);
		$poGroup=$dt["POGROUP"];

		if($poGroup)
		{
			$wsql="  select a.PO_SEQ,  a.PO_SORT, a.PO_TYPE, a.PO_CONTENTS,a.PO_LINK, b.cd_name_kor POTYPENAME 
					 from ".$dbH."_policy a 
					 left join ".$dbH."_code b on  b.cd_type='inPolicy' and b.cd_code=a.PO_TYPE and b.cd_use='Y' 
					 where to_char(PO_GROUP, 'yyyy-mm-dd')='".$poGroup."' and PO_USE='Y' 
					 order by a.PO_SORT asc ";
			$res=dbqry($wsql);

			$json["policy"]=array();
			while($wdt=dbarr($res))
			{
				$addarray=array(
					"poSeq"=>$wdt["PO_SEQ"], //seq
					"poSort"=>$wdt["PO_SORT"],
					"poType"=>$wdt["PO_TYPE"],//종류
					"poTypeName"=>$wdt["POTYPENAME"],//종류
					"poLink"=>$wdt["PO_LINK"],//종류
					"poContents"=>getClob($wdt["PO_CONTENTS"])//내용
				);
				array_push($json["policy"], $addarray);
			}
		}

		$json["sql"]=$sql;
		$json["wsql"]=$wsql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>


