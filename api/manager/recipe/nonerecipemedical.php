<?php
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];
	$title=$_GET["title"];
	$cypk=$_GET["cypk"];
	$odkeycode=$_GET["odkeycode"];


	if($apiCode!="nonerecipemedical"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="nonerecipemedical";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		
		$sql=" select rc_code, rc_source, rc_sourcetit from ".$dbH."_recipemedical where rc_seq='".$seq."' ";
		$dt=dbone($sql);
		$rmCode=$dt["RC_CODE"];

		$gdcypk=explode(",", $dt["RC_SOURCE"]);
		$json["cymmcodepk1"]=$gdcypk;
		array_push($gdcypk,$cypk);
		$json["cymmcodepk2"]=$gdcypk;
		$gdcypktmp=array_unique($gdcypk);
		$json["gdcypktmp"]=$gdcypktmp;
		//array_unique  중복제거필요- 반쯤 중요함
		$gdcypk=implode(",",$gdcypktmp);
		$json["cymmcodepk3"]=$gdcypk;
		$gdcypk=str_replace(",,",",",$gdcypk.",");
		$json["cymmcodepk4"]=$gdcypk;


		$gdtitle=explode(",", $dt["RC_SOURCETIT"]);
		$json["cymmcodepk1"]=$gdtitle;
		array_push($gdtitle,$title.",");
		$json["cymmcodepk2"]=$gdtitle;
		$gdtitletmp=array_unique($gdtitle);
		$json["gdtitletmp"]=$gdtitletmp;
		//array_unique  중복제거필요- 반쯤 중요함
		$gdtitle=implode(",",$gdtitletmp);
		$json["cymmcodepk3"]=$gdtitle;
		$gdtitle=str_replace(",,",",",$gdtitle.",");
		$json["cymmcodepk4"]=$gdtitle;


		$usql=" update ".$dbH."_recipemedical ";
		$usql.=" set rc_source='".$gdcypk."' ";
		$usql.=" , rc_sourcetit='".$gdtitle."' ";
		$usql.=" where rc_seq='".$seq."' ";
		$json["cy_usql"]=$usql;
		dbcommit($usql);


		if($odkeycode)
		{
			$sql=" select ";
			$sql.=" b.rc_code, b.rc_source ";
			$sql.=" from ".$dbH."_order ";
			$sql.=" a inner join ".$dbH."_recipeuser b on b.rc_code=a.od_scription ";
			$sql.=" where a.od_keycode='".$odkeycode."' ";
			$dt=dbone($sql);
			$json["sql2"]=$sql;
			$ruCode=$dt["RC_CODE"];


			$usql=" update ".$dbH."_recipeuser ";
			$usql.=" set rc_source='".$rmCode."' ";
			$usql.=" where rc_code='".$ruCode."' ";
			$json["cy_usql"]=$usql;
			dbcommit($usql);
		}


		$sql=" select rc_code from ".$dbH."_recipemedical where rc_source like '%,".$cypk.",%' ";
		$json["sql1"]=$sql;
		$dt=dbone($sql);
		if($dt["RC_CODE"])
		{
			$json["RC_CODE"]=$dt["RC_CODE"];
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
		else
		{
			$json["resultCode"]="199";
			$json["resultMessage"]="ERR_NOT_MATCHING";//매칭실패 
		}

		$json["apiCode"]=$apiCode;


	}
?>
