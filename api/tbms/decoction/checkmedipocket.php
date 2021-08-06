<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	$stat=$_GET["stat"];
	$depart=$_GET["depart"];
	$medigroup=$_GET["medigroup"];
	$code=$_GET["code"];
	$odcode=$_GET["odcode"];
	$nextmedigroup=$_GET["nextmedigroup"];
	
			
	if($apiCode!="checkmedipocket"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="checkmedipocket";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql=" select ";
		$sql.=" (select ma_medibox_infirst from ".$dbH."_making where ma_medibox_infirst='".$code."' and ma_odcode='".$odcode."') INFIRST ";
		$sql.=" ,(select ma_medibox_inmain from ".$dbH."_making where ma_medibox_inmain='".$code."' and ma_odcode='".$odcode."') INMAIN ";
		$sql.=" ,(select ma_medibox_inafter from ".$dbH."_making where ma_medibox_inafter='".$code."' and ma_odcode='".$odcode."') INAFTER ";
		$sql.=" ,(select ma_medibox_inlast from ".$dbH."_making where ma_medibox_inlast='".$code."' and ma_odcode='".$odcode."') INLAST ";
		$sql.=" from dual ";
		$dt=dbone($sql);

		$json["1sql"] = $sql;

		$json["data"]["infirst"] = $dt["INFIRST"];
		$json["data"]["inmain"] = $dt["INMAIN"];
		$json["data"]["inafter"] = $dt["INAFTER"];
		$json["data"]["inlast"] = $dt["INLAST"];

		if($dt["INFIRST"])
		{
			$sql=" update ".$dbH."_decoction set dc_medibox_infirst='".$code."' where dc_odcode='".$odcode."'";
			$json["2sql"] = $sql;
			dbcommit($sql);
		}
		else if($dt["INMAIN"])
		{
			$sql=" update ".$dbH."_decoction set dc_medibox_inmain='".$code."' where dc_odcode='".$odcode."'";
			$json["3sql"] = $sql;
			dbcommit($sql);
		}
		else if($dt["INAFTER"])
		{
			$sql=" update ".$dbH."_decoction set dc_medibox_inafter='".$code."' where dc_odcode='".$odcode."'";
			$json["4sql"] = $sql;
			dbcommit($sql);
		}
		else if($dt["INLAST"])
		{
			$sql=" update ".$dbH."_decoction set dc_medibox_inlast='".$code."' where dc_odcode='".$odcode."'";
			$json["5sql"] = $sql;
			dbcommit($sql);
		}

		$decolist=getDecoCodeTitle("all");

		$sql1=" select
				NVL(a.ma_medibox_infirst,'')||'|'||NVL(a.ma_medibox_inmain,'')||'|'||NVL(a.ma_medibox_inafter,'')||'|'||NVL(a.ma_medibox_inlast,'') as ma_medibox,
				NVL(b.dc_medibox_infirst,'')||'|'||NVL(b.dc_medibox_inmain,'')||'|'||NVL(b.dc_medibox_inafter,'')||'|'||NVL(b.dc_medibox_inlast,'') as dc_medibox
				from ".$dbH."_making a
				inner join ".$dbH."_decoction b on a.ma_odcode=b.dc_odcode
				where a.ma_odcode='".$odcode."' ";

		$dt1=dbone($sql1);
		$json["6sql"] = $sql1;

		$json["data"]["ma_medibox"] = $dt1["MA_MEDIBOX"];
		$json["data"]["dc_medibox"] = $dt1["DC_MEDIBOX"];

		//--별전
		$ssql=" select b.rc_sweet from han_order a 
				inner join han_recipeuser b on b.rc_code=a.od_scription
				where a.od_code='".$odcode."' ";
		$sdt=dbone($ssql);
		$json["7sql"] = $ssql;
		$rc_sweet=getClob($sdt["RC_SWEET"]);
		$sweetcode="";
		if($dt1["MA_MEDIBOX"]==$dt1["DC_MEDIBOX"])
		{
			$json["data"]["chkinlast"]="";
		}
		else
		{
			if($rc_sweet)
			{
				$sarr=explode("|",$rc_sweet);
				for($i=1;$i<count($sarr);$i++)
				{
					$sarr2=explode(",",$sarr[$i]);
					$newmdcode=getNewMediCode($sarr2[0]);
					if($i>1)$sweetcode.=",";
					$sweetcode.="'".$newmdcode."'";
				}

				$msql="select LISTAGG(mm_title_kor,',') as title from han_medicine_djmedi where md_code in (".$sweetcode.")";
				$mdt=dbone($msql);

				$json["data"]["chkinlast"]="on";
				$json["data"]["chkinlasttitle"]=$mdt["TITLE"];
			}
			else
			{
				$json["data"]["chkinlast"]="";
			}
		}



		$json["data"]["decolist"]=$decolist;
		$json["data"]["depart"] = $depart;
		$json["data"]["medigroup"] = $medigroup;
		$json["data"]["code"] = $code;
		$json["data"]["odcode"] = $odcode;
		$json["data"]["nextmedigroup"] = $nextmedigroup;		

		$arr=explode("|",$dt1["MA_MEDIBOX"]);
		$uptcode="";
		for($i=0;$i<count($arr);$i++)
		{
			if($arr[$i])
			{
				$uptcode.=",'".$arr[$i]."'";
			}
		}
		$uptcode=substr($uptcode,1);
		//조제에서 스캔한  부직포 바코드 정보 
		$psql="select pt_code, pt_group, pt_name1 from ".$dbH."_pouchtag where pt_code in (".$uptcode.") and pt_use ='Y' ";
		$pres=dbqry($psql);
		$bujigpo="";
		while($pdt=dbarr($pres))
		{
			$bujigpo.=",".$pdt["PT_NAME1"]."(".$pdt["PT_CODE"].")";
		}
		$json["data"]["bujigpo"]=substr($bujigpo, 1);

		$json["sql"] = $sql;
		$json["sql1"] = $sql1;
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>