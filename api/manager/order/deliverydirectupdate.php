<?php /// 직배변경  (바꾸기전에 송장있으면 송장취소해달라는 메세지 보임)
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odCode=$_GET["odcode"];
	
	if($apicode!="deliverydirectupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="deliverydirectupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($odCode==""){$json["resultMessage"]="API(odCode) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$directstat="N";

		$sql="select re_delicomp, re_deliexception, re_delitype from ".$dbH."_release where re_odcode='".$odCode."' ";
		$dt=dbone($sql);
		$re_delicomp=$dt["RE_DELICOMP"];
		$re_deliexception=$dt["RE_DELIEXCEPTION"];
		$re_delitype=$dt["RE_DELITYPE"];

		if(strtoupper($re_delicomp)=="POST")
		{
			$dsql="select seq from ".$dbH."_delicode_post where odcode='".$odCode."' and deliconfirm in ('N','Y') ";
			$ddt=dbone($dsql);
			if($ddt["SEQ"])
			{
				$directstat="N";
			}
			else
			{
				$directstat="Y";
			}
		}
	

		if($re_deliexception=="N")
		{
			$re_deliexception=',D';
		}
		else
		{
			if(strpos($re_deliexception, ",D") !== false)
			{

			}
			else
			{
				$re_deliexception.=',D';
			}
		}

		if($directstat=="Y")
		{	
			$rsql="update ".$dbH."_release set re_delitype='direct', re_deliexception='".$re_deliexception."', re_delino='' where re_odcode='".$odCode."' ";
			$json["rsql"]=$rsql;
			dbcommit($rsql);

			$csql=" select seq from ".$dbH."_delicode_direct where odcode='".$odCode."'";
			$cdt=dbone($csql);

			if($cdt["SEQ"])
			{
				$json["resultCode"]="498";
				$json["resultMessage"]="이미 직배입니다.";
			}
			else
			{
				$delicode=date("ymdHis");
				$usql=" insert into ".$dbH."_delicode_direct (SEQ, delitype, delicode, odcode, deliconfirm, inuse, indate, usedate ) ";
				$usql.=" values((SELECT NVL(MAX(SEQ),0)+1 FROM ".$dbH."_packinglog), 'DIRECT', '".$delicode."','".$odCode."','N', 'Y', sysdate, sysdate) ";
				dbcommit($usql);
				$json["usql"]=$usql;

				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}
			$json["reDeliexception"]=$re_deliexception;
			$json["apiCode"]=$apicode;
			$json["returnData"]=$returnData;

		}
		else
		{
			$json["resultCode"]="499";
			$json["reDeliexception"]=$re_deliexception;
			$json["apiCode"]=$apicode;
			$json["returnData"]=$returnData;
			$json["resultMessage"]="송장을 먼저 취소해 주세요.";
		}
	}
?>