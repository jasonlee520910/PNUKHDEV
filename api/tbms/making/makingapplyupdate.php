<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	
	$stat=$_GET["stat"];
	$proc=$_GET["proc"];
	$code=$_GET["code"];
	$returnData=$_GET["returnData"];
	$medi=$_GET["medi"];
	
	if($apiCode!="makingapplyupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="makingapplyupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($code==""){$json["resultMessage"]="API(code) ERROR";}
	else
	{
		$chkstat=explode("_",$stat);

		$sql=" update ".$dbH."_order set od_status='".$stat."' where od_code='".$code."' ";		
		dbcommit($sql);

		//20190822 : ma_staffid도 null 
		//20191113:ma_pharmacist=null,
		$sql=" update ".$dbH."_making set ma_tablestat = null, ma_table = null, ma_staffid=null, ma_pharmacist=null, ma_status='".$stat."' where ma_odcode='".$code."' ";
		dbcommit($sql);
		
		
		$sql=" select ";
		$sql.=" a.od_code, b.rc_code ";
		$sql.=" ,b.rc_medicine as RCMEDICINE ";
		$sql.=" ,b.rc_sweet as RCSWEET  ";
		$sql.=" from ".$dbH."_order a ";
		$sql.=" inner join ".$dbH."_recipeuser b on a.od_scription=b.rc_code ";
		$sql.=" where a.od_code='".$code."' ";
		$dt=dbone($sql);
		$od_code=$dt["OD_CODE"];
		$rc_code=$dt["RC_CODE"];
		$rc_medicine=getClob($dt["RCMEDICINE"]);
		$rc_sweet=getClob($dt["RCSWEET"]);

		if($rc_medicine)
		{
			$finishmedi="";
			$mediarry=explode("|",$rc_medicine);			
			for($i=1;$i<count($mediarry);$i++)
			{
				$arr=explode(",",$mediarry[$i]);
				$finishmedi.="|".$arr[0].",".$arr[1].",".$arr[2].",".$arr[3];
			}
			if(!$finishmedi) $finishmedi=$rc_medicine;
		}

		if($rc_sweet)
		{
			$finishsweet="";
			$sweetarry=explode("|",$rc_sweet);			
			for($i=1;$i<count($sweetarry);$i++)
			{
				$arr=explode(",",$sweetarry[$i]);
				$finishsweet.="|".$arr[0].",".$arr[1].",".$arr[2].",".$arr[3];
			}
			if(!$finishsweet) $finishsweet=$rc_sweet;
		}

		$sql=" update ".$dbH."_recipeuser set rc_medicine='".$finishmedi."', rc_sweet='".$finishsweet."', rc_modify=sysdate where rc_code='".$rc_code."' ";
		dbcommit($sql);

		$json["apiCode"] = $apiCode;
		$json["returnData"] = $returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>