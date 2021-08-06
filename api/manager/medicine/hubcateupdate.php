<?php  //본초분류관리 등록&수정
	//POST
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];

	if($apiCode!="hubcateupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="hubcateupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$mc_seq=$_POST["seq"];
		$mc_code=$_POST["mcCode"];

		$chkval="Y";
		$sql=" select mc_code from ".$dbH."_medicate where mc_code='".$mc_code."' ";
		if($mc_seq)
		{
			$sql.=" and mc_seq <> '".$mc_seq."'";
		}
		$dt=dbone($sql);
		if($dt["mc_code"])//신규일때 분류코드 중복 체크
		{
			$chkval="N";
			$json["resultCode"]="204";
			$json["resultMessage"]="중복코드";
		}
		if($chkval=="Y")
		{
			$mc_code01=$_POST["mcCode01"];
			$mc_title01_kor=$_POST["mcTitle01Kor"];
			$mc_title01_chn=$_POST["mcTitle01Chn"];
			$mc_code02=$_POST["mcCode02"];
			$mc_title02_kor=$_POST["mcTitle02Kor"];
			$mc_title02_chn=$_POST["mcTitle02Chn"];

			if($mc_seq)
			{
				$sql=" update ".$dbH."_medicate set mc_code='".$mc_code."', mc_code01='".$mc_code01."', mc_title01_kor ='".$mc_title01_kor."', mc_title01_chn ='".$mc_title01_chn."',mc_code02='".$mc_code02."', mc_title02_kor ='".$mc_title02_kor."', mc_title02_chn ='".$mc_title02_chn."', mc_date=sysdate where mc_seq='".$mc_seq."'";
				dbcommit($sql);
			}
			else
			{
				$sql=" insert into ".$dbH."_medicate (mc_seq,mc_code, mc_code01, mc_title01_kor, mc_title01_chn, mc_code02, mc_title02_kor, mc_title02_chn, mc_date) values ((SELECT NVL(MAX(mc_seq),0)+1 FROM ".$dbH."_medicate),'".$mc_code."','".$mc_code01."','".$mc_title01_kor."','".$mc_title01_chn."','".$mc_code02."','".$mc_title02_kor."','".$mc_title02_chn."', sysdate) ";
				dbcommit($sql);

				//신규등록된 seq
				$newsql=" select mc_seq from ".$dbH."_medicate order by mc_seq desc limit 0, 1";
				$dt=dbone($newsql);
				$seq=$dt["MC_SEQ"];

			}

			$returnData=urldecode($_POST["returnData"]);
			$json=array("apiCode"=>$apiCode,"seq"=>$seq,"returnData"=>$returnData);
			$json["sql"]=$sql;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";	
		}
	}
?>
