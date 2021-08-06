<?php
	//로젠 송장번호 안해도 됨 
	$root="../..";
	$folder="/tbms";
	include_once $root.$folder."/settinghead.php";

	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	if($apiCode!="logenslipnoupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="logenslipnoupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//송장번호 사용가능한 갯수가 50개 미만이면 송장번호 채번하자 
		$sql=" select count(seq) as cnt from han_delicode where inuse='A' ";
		$dt=dbone($sql);

		$total=intval($dt["cnt"]);
		$json["delicodetotal"]=$total;

		if($total<=$MIN_SLIP)
		{
			$slipQty=$SLIP_UPDATE_CNT;//송장매수 

			//송장번호 채번규칙 뽑아오기 
			$client=new SoapClient($LOGEN_SERVER_URL);
			
			$param=array('parameters' => array('userID'=>$userID,'passWord'=>$passWord,'slipQty'=>$slipQty));
			$narray = $client->__call('W_PHP_Tx_Get_SlipNo',$param);

			$nvar = $narray->W_PHP_Tx_Get_SlipNoResult; 

			$nData = explode('Ξ', $nvar);
			$values="";
			$delitype="LOGEN";
			$inuse="A";
			$delicode="";
			for($i=0;$i<count($nData)-1;$i++)
			{
				$delicode=$nData[$i];
				if($i>0)
				{
					$values.=",";
				}

				$values.="('".$delitype."','".$delicode."','".$inuse."',sysdate)";

			}

			if($values)
			{
				$isql = " insert into han_delicode (delitype, delicode, inuse, indate) values ".$values;
				dbqry($isql);

				$json["delilogenslipnoisql"]=$isql;
				$json["delilogenslipno"]="송장번호 업데이트!!";
			}
			else
			{
				$json["delilogenslipno"]="송장번호 업데이트 다시 해야함 ".$values;
			}
		}
		else
		{
			$json["delilogenslipno"]="송장번호 업데이트할 내용이 없음";
		}

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}

	include_once $root.$folder."/tail.php";

?>
