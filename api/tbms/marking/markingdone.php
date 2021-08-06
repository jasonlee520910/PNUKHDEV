<?php //스텝 등록/수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$code=$_POST["code"];
	$defineprocess=$_POST["defineprocess"];

	if($apiCode!="markingdone"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="markingdone";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		/*if($defineprocess == "true")
		{*/
			$sql=" update ".$dbH."_order set od_status='release_apply' where od_code='".$code."'";
			dbcommit($sql);

			$sql=" update ".$dbH."_marking set mr_status='marking_done', mr_modify=sysdate where mr_odcode='".$code."'";
			dbcommit($sql);

			$sql=" update ".$dbH."_release set re_status='release_apply' where re_odcode='".$code."'";
			dbcommit($sql);
		/*}
		else
		{
			$sql=" update ".$dbH."_order set od_status='marking_apply' where od_code='".$code."'";
			dbqry($sql);

			$sql=" update ".$dbH."_marking set mr_status='marking_apply', mr_modify=sysdate where mr_odcode='".$code."'";
			dbqry($sql);

		}*/

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>