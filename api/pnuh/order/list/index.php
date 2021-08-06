<?php
	$root="../../..";
	$folder="/pnuh";
	include_once $root.$folder."/head.php";

	$json["resultCode"]="404";
	$json["resultMessage"]="list API(apiCode) ERROR";

	$apicode=$_GET["apiCode"];

	if($apicode!="orderlist"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="orderlist";}
	else
	{
		$page=$_GET["page"];
		$hCodeList = getNewCodeTitle("odStatus");

		$wsql="";

		$jsql.=" a inner join han_release b on b.re_keycode=a.keycode ";
		$jsql.=" inner join han_order c on c.od_keycode=a.keycode ";

		$pg=apipaging("a.keycode","order_cy",$jsql,$wsql);

		$sql=" select b.re_delino,b.re_delicomp,b.re_deliexception,c.od_status, a.* ";
		$sql.=" from han_order_cy ";
		$sql.=" $jsql $wsql ";
		$sql.=" order by orderCode desc , re_delino desc ";
		$sql.=" limit ".$pg["snum"].", ".$pg["psize"];
		$res=dbqry($sql);

		//$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];

		$json["orderList"]=array();

		while($dt=dbarr($res))
		{
			$re_deliexception=$dt["re_deliexception"];
			$reDelicomp=$reDelicompO=$reDelicompT="";
			if(strpos($re_deliexception, "D") !== false)
			{
				$reDelicomp="직배";
			}
			else
			{
				if($dt["re_delicomp"]=="POST" || $dt["re_delicomp"]=="post")
				{
					$reDelicomp="우체국";
				}
				else if($dt["re_delicomp"]=="CJ" || $dt["re_delicomp"]=="cj")
				{
					$reDelicomp="CJ";
				}
				else if($dt["re_delicomp"]=="DIRECT" || $dt["re_delicomp"]=="direct")
				{
					$reDelicomp="직배";
				}
				else
				{
					$reDelicomp="로젠";
				}
			}

			if(strpos($re_deliexception, "O") !== false)
			{
				$reDelicompO="해외";
			}
			if(strpos($re_deliexception, "T") !== false)
			{
				$reDelicompT="묶음";
			}


			$odStatus = getodStatus($hCodeList, $dt["od_status"]);
			$re_delino=($dt["re_delino"]) ? $dt["re_delino"] : "";

			$addarray=array(
				"deliveryCode"=>$re_delino,//송장번호
				"orderStatus"=>$odStatus,
				"keyCode"=>$dt["keycode"],  //주문코드, CY주문코드
				"orderCode"=>$dt["orderCode"],  //주문코드, CY주문코드
				"orderDate"=>$dt["orderDate"],  //주문일
				"deliveryDate"=>$dt["deliveryDate"], //배송희망일
				"medicalName"=>$dt["medicalName"], //한의원
				"doctorName"=>$dt["doctorName"], //처방자
				"orderTitle"=>$dt["orderTitle"], //처방명
				"orderType"=>$dt["orderType"],  //조제타입
				"deliveryCompany"=>$reDelicomp,  //배송회사
				"deliveryNo"=>$re_delino  //송장번호
				);
			array_push($json["orderList"], $addarray);
		}
	
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["apiCode"]=$apicode;
	}
	
	include_once $root.$folder."/tail.php";
?>
<?php
	function getodStatus($list, $status)
	{
		$chkstat=explode("_",$status);
		$substat=$chkstat[0];
		$substat2=$chkstat[1];
		$substat3=($chkstat[2]) ? $chkstat[2] : ""; //세명대 수동조제

		for($i=0;$i<count($list["odStatus"]);$i++)
		{	
			if($list["odStatus"][$i]["cdCode"] == $substat)
			{
				$statName = $list["odStatus"][$i]["cdName"];
			}
			if($list["odStatus"][$i]["cdCode"] == $substat2)
			{
				$statName2 = $list["odStatus"][$i]["cdName"];
			}
			if($list["odStatus"][$i]["cdCode"] == $substat3) 
			{
				$statName3=$list["odStatus"][$i]["cdName"];
			}
		}
		return $statName3." ".$statName." ".$statName2;

	}
?>