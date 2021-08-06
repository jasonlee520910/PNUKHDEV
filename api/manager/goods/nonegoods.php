<?php
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];
	$title=$_GET["title"];
	$cypk=$_GET["cypk"];


	if($apiCode!="nonegoods"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="nonegoods";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		
		$sql=" select gd_cypk from ".$dbH."_goods where gd_seq='".$seq."' ";
		$dt=dbone($sql);

		$gdcypk=explode(",", $dt["GD_CYPK"]);
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


		$usql=" update ".$dbH."_goods ";
		$usql.=" set gd_cypk='".$gdcypk."' ";
		$usql.=" where gd_seq='".$seq."' ";
		$json["cy_usql"]=$usql;
		dbcommit($usql);


		$sql=" select gd_code from ".$dbH."_goods where gd_cypk like '%,".$cypk.",%' ";
		$dt=dbone($sql);
		if($dt["GD_CODE"])
		{
			$json["gd_code"]=$dt["GD_CODE"];
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
