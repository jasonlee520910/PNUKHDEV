<?php  
	///주문현황 > 주문리스트 > 처방내용 상세보기 > 약재리스트 중에 약재변경업데이트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odKeycode=$_GET["odKeycode"];
	$medicode=$_GET["medicode"];
	$newmedicode=$_GET["newmedicode"];
	
	if($apiCode!="changemedicodeupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="changemedicodeupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($medicode==""){$json["resultMessage"]="API(medicode) ERROR";}
	else if($newmedicode==""){$json["resultMessage"]="API(newmedicode) ERROR";}
	else
	{
		$json["odKeycode"]=$odKeycode;
		$json["medicode"]=$medicode;
		$json["newmedicode"]=$newmedicode;

		$msql="select md_type from han_medicine where md_code='".$newmedicode."'";
		$mdt=dbone($msql);
		$md_type=$mdt["MD_TYPE"];
		$json["msql"]=$msql;

		if($md_type=="medicine")
		{
			$sql=" select a.od_scription, b.rc_medicine from ".$dbH."_order a ";
			$sql.="	inner join ".$dbH."_recipeuser b on b.rc_code=a.od_scription ";
			$sql.="	where a.od_keycode='".$odKeycode."' ";

			$dt=dbone($sql);

			$od_scription=$dt["OD_SCRIPTION"];
			$rc_medicine=getClob($dt["RC_MEDICINE"]);

			$arr=explode("|",$rc_medicine);
			$json["rc_medicine"]=$rc_medicine;
			$newmedicine="";
			//|HD10293_01,6.0,inmain,0|HD10112_01,6.0,inmain,99|HD10124_04,4.0,inmain,0|HD10126_01,4.0,inmain,0|HD10036_03,4.0,inmain,0|HD10234_15,4.0,inmain,0|HD10262_01,4.0,inmain,0|HD10058_01,4.0,inmain,17|HD10008_01,4.0,inmain,99|HD10233_06,4.0,inmain,99|HD10474_01,4.0,inmain,99|HD10230_01,4.0,inmain,99|HD10030_04,3.0,inmain,0|HD10265_01,2.0,inmain,0|HD10216_01,2.0,inmain,0
			for($i=1;$i<count($arr);$i++)
			{
				$arr2=explode(",",$arr[$i]);
				$newmdcode=getNewMediCode($arr2[0]);
				if($medicode==$newmdcode)
				{
					$newmedicine.="|".$newmedicode.",".$arr2[1].",".$arr2[2].",".$arr2[3];
				}
				else
				{
					$newmedicine.="|".$newmdcode.",".$arr2[1].",".$arr2[2].",".$arr2[3];
				}
			}

			if($newmedicine)
			{
				$usql=" update ".$dbH."_recipeuser set rc_medicine='".$newmedicine."' where rc_code='".$od_scription."' ";
				dbcommit($usql);
				//echo $usql;
				$json["usql"]=$usql;

				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}
			else
			{
				$json["resultCode"]="199";
				$json["resultMessage"]="약재 변경에 실패하였습니다.";
			}
		}
		else
		{
			$json["resultCode"]="199";
			$json["resultMessage"]="선택하신 약재는 약재가 아닙니다. 다시 선택해 주세요.";
		}
		

		$json["md_type"]=$md_type;
		$json["newmedicine"]=$newmedicine;
		$json["apiCode"]=$apiCode;

	
	}
?>
