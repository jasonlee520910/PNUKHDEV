<?php 
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$odcode=$_POST["odcode"];
	$staffid=$_POST["staffid"];//제환사 
	$machinestat=$_POST["machinestat"];//장비상태  
	$pl_machine=$_POST["plMachine"];//장비   
	$opjson=$_POST["opjson"];//
	
	
	$returnData=$_POST["returnData"];

	if($apiCode!="pillprocessing"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="pillprocessing";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql="select OD_TITLE, OD_SCRIPTION  from han_order where OD_CODE='".$odcode."' ";
		$dt=dbone($sql);
		$od_title=$dt["OD_TITLE"];
		$od_scription=$dt["OD_SCRIPTION"];

		//order 상태값 바꾸기 
		$sql1=" update ".$dbH."_order set od_status='pill_processing' where od_code='".$odcode."'";
		dbcommit($sql1);
		$json["1order"]=$sql1;

		//recipeuser 상태값 바꾸기 
		$sql2=" update ".$dbH."_recipeuser set RC_PILLORDER=".insertClob($opjson)." where RC_CODE='".$od_scription."'";
		dbcommit($sql2);
		$json["2user"]=$sql2;

		//pill  상태값 바꾸기 
		$sql3=" update ".$dbH."_pill set PL_MACHINE='".$pl_machine."', PL_MACHINESTAT='".$machinestat."', PL_STATUS='pill_processing' where PL_ODCODE='".$odcode."'";
		dbcommit($sql3);
		$json["3pill"]=$sql3;

		
		$maarr=explode("|",$pl_machine);
		for($i=1;$i<count($maarr);$i++)
		{
			$mlarr=explode(",",$maarr[$i]);
			$mlcode=$mlarr[1];
			if($mlcode)
			{
				$musql="update han_machine set mc_odcode='".$odcode."', mc_staff='".$staffid."', mc_intime=sysdate, mc_status='ing' where MC_CODE='".$mlcode."' ";
				dbcommit($musql);

				$json[$mlcode."musql"] = $musql;

				$misql=" insert into han_machinelog (ML_SEQ, ML_CODE, ML_ODCODE, ML_TITLE, ML_STAFFID, ML_INTIME, ML_STATUS,  ML_USE, ML_DATE) values ((SELECT NVL(MAX(ML_SEQ),0)+1 FROM han_machinelog), '".$mlcode."', '".$odcode."', '".$od_title."', '".$staffid."', sysdate, 'ing','Y', sysdate) ";
				dbcommit($misql);
				$json[$mlcode."misql"] = $misql;
			}
		}

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>