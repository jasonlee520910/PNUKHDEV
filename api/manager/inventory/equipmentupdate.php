<?php  
	/// 자재코드관리 > 장비관리 > 등록&수정
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$mc_seq=$_POST["seq"];
	$mcCode=strtoupper(trim($_POST["mcCode"]));

	if($apicode!="equipmentupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="equipmentupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mc_seq==""){$json["resultMessage"]="API(seq) ERROR";}	
	else
	{

		$eqGroup=$_POST["eqGroup"];
		$eqType=$_POST["eqType"];
		
		$mcTitle=$_POST["mcTitle"];
		$mcModel=$_POST["mcModel"];
		$mcLocate=$_POST["mcLocate"];
		$mcTop=$_POST["mcTop"];
		$mcLeft=$_POST["mcLeft"];
		$mcStatus=$_POST["mcStatus"];

		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		if($mcCode)
		{
			if($mc_seq&&$mc_seq!="add")
			{
				$sql=" update ".$dbH."_MACHINE set MC_GROUP='".$eqGroup."', MC_TYPE='".$eqType."', MC_TITLE='".$mcTitle."', MC_MODEL='".$mcModel."', MC_TOP='".$mcTop."', MC_LEFT='".$mcLeft."', MC_LOCATE='".$mcLocate."', MC_STATUS='".$mcStatus."', MC_DATE=SYSDATE where MC_SEQ='".$mc_seq."' ";
				dbcommit($sql);
				$json["usql"]=$sql;


				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}
			else
			{
				$ssql=" select MC_CODE from ".$dbH."_MACHINE where MC_CODE='".$mcCode."'";
				$sdt=dbone($ssql);
				$json["ssql"]=$ssql;

				if($sdt["MC_CODE"])
				{
					$json["resultCode"]="199";
					$json["resultMessage"]="등록된 장비코드 입니다.";
				}
				else
				{
					$sql=" insert into ".$dbH."_MACHINE (MC_SEQ,MC_GROUP,MC_TYPE,MC_CODE,MC_ODCODE,MC_MODEL,MC_TOP, MC_LEFT, MC_TITLE,MC_LOCATE,MC_STATUS,MC_STAFF,MC_USE,MC_DATE) values ((SELECT NVL(MAX(MC_SEQ),0)+1 FROM ".$dbH."_MACHINE),'".$eqGroup."','".$eqType."','".$mcCode."','','".$mcModel."','".$mcTop."','".$mcLeft."','".$mcTitle."','".$mcLocate."','standby','','Y',SYSDATE) ";
					dbcommit($sql);

					$json["isql"]=$sql;

					$json["resultCode"]="200";
					$json["resultMessage"]="OK";

				}
			}
		}
		else
		{
			$json["resultCode"]="199";
			$json["resultMessage"]="장비코드를 입력해 주세요.";
		}
	}
?>