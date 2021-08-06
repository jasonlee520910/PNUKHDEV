<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$sd_sccode=$_GET["scCode"];
	if($apicode!="categorydesc"){$json["resultMessage"]="API코드오류";$apicode="categorydesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($sd_sccode==""){$json["resultMessage"]="code 없음";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$json["list"]=array();
		$sql=" select sd_seq, sc_code, sd_device_".$language." device, sd_title_".$language." title, sd_cnt from han_salesdesc a inner join han_salescategory b on a.sd_sccode=b.sc_code where a.sd_use='Y' and a.sd_sccode='".$sd_sccode."' order by a.sd_sort asc ";
		$res=dbqry($sql);
		while($dt=dbarr($res)){
			$addarray=array("seq"=>$dt["sd_seq"], "category"=>$dt["sc_code"], "device"=>$dt["device"], "title"=>$dt["title"], "cnt"=>$dt["sd_cnt"]);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>