<?php 
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$odcode=$_POST["odcode"];
	$outcapa=$_POST["outcapa"];//산출량 
	$opjson=$_POST["opjson"];
	$pilltype=$_POST["pilltype"];
	$pl_machine=$_POST["plMachine"];//장비   
	
	
	$returnData=$_POST["returnData"];

	if($apiCode!="pilldone"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="pilldone";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql="select  OD_SCRIPTION  from han_order where OD_CODE='".$odcode."' ";
		$dt=dbone($sql);
		$od_scription=$dt["OD_SCRIPTION"];

		//장비관련 업데이트
		$maarr=explode("|",$pl_machine);
		for($i=1;$i<count($maarr);$i++)
		{
			$mlarr=explode(",",$maarr[$i]);
			$mlcode=$mlarr[1];
			if($mlcode)
			{
				$musql="update han_machine set MC_OUTTIME=sysdate, mc_status='standby' where MC_CODE='".$mlcode."' ";
				dbcommit($musql);

				$json[$mlcode."musql"] = $musql;

				$misql=" update han_machinelog set ML_CAPA='".$outcapa."', ML_OUTTIME=sysdate, ML_STATUS='done'  where ML_CODE='".$mlcode."' and ML_ODCODE='".$odcode."' ";
				dbcommit($misql);
				$json[$mlcode."misql"] = $misql;
			}
		}

		//일단은 업데이트 하지 않는다. 
		//recipeuser 상태값 바꾸기 
		//$sql2=" update ".$dbH."_recipeuser set RC_PILLORDER=".insertClob($opjson)." where RC_CODE='".$od_scription."'";
		//dbcommit($sql2);
		//$json["2user"]=$sql2;

		//pillorder 

		///제환순서
		$gdPillorder=json_decode($opjson, true);
		$gdPilllist=$gdPillorder["pilllist"];

		$repillorder=array();
		$nextType=get_next_key_array($gdPilllist, $pilltype);
		if(!$nextType)
		{
			$nextType=$pilltype;
		}


		$json["num"]=$num;
		$json["nextType"]=$nextType;
		$json["pilltype"]=$pilltype;

		if($nextType==$pilltype) //done 
		{
			//order 상태값 바꾸기 
			$sql1=" update ".$dbH."_order set od_status='pill_done' where od_code='".$odcode."'";
			dbcommit($sql1);
			$json["1order"]=$sql1;

			$sql3=" update ".$dbH."_pill set PL_MACHINESTAT='done', PL_STATUS='pill_done', PL_END=sysdate  where PL_ODCODE='".$odcode."'";
			dbcommit($sql3);
			$json["3pill"]=$sql3;
		}
		else
		{
			$machinestat=$nextType."_apply";
			$sql3=" update ".$dbH."_pill set PL_MACHINE='', PL_MACHINESTAT='".$machinestat."' where PL_ODCODE='".$odcode."'";
			dbcommit($sql3);
			$json["3pill"]=$sql3;
		}
	
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

	function get_next_key_array($array,$key)
	{
		$keys = array_keys($array);
		$position = array_search($key, $keys);
		if (isset($keys[$position + 1])) {
			$nextKey = $keys[$position + 1];
		}
		return $nextKey;
	}
?>