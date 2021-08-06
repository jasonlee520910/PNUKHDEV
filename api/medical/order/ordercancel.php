<?php  ///주문취소 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];

	if($apiCode!="ordercancel"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="ordercancel";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];

		$sql=" select ";
		$sql.=" a.od_keycode, b.od_status oStatus  ";
		$sql.=" from ".$dbH."_order_medical ";
		$sql.=" a inner join ".$dbH."_order b on b.od_keycode=a.od_keycode ";
		$sql.=" where a.od_seq='".$seq."' and a.od_use='Y' ";
		$dt=dbone($sql);

		if($dt["OSTATUS"]=="paid" || $dt["OSTATUS"]=="order")
		{
			$od_keycode=$dt["OD_KEYCODE"];
			///keycode
			$status="medicalcancel";
			$od_use="C";

			$sql=" update ".$dbH."_order_medical set od_status='".$status."', od_use='".$od_use."', od_modify=sysdate where od_keycode='".$od_keycode."' ";
			///$json["sql1"]=$sql;
			dbcommit($sql);			
			$sql=" update ".$dbH."_order set od_status='".$status."', od_use='".$od_use."',od_modify=sysdate where od_keycode='".$od_keycode."' ";
			///$json["sql2"]=$sql;
			dbcommit($sql);
			$sql=" update ".$dbH."_making set ma_status='".$status."', ma_use='".$od_use."', ma_modify=sysdate where ma_keycode='".$od_keycode."' ";
			///$json["sql3"]=$sql;
			dbcommit($sql);
			$sql=" update ".$dbH."_decoction set dc_status='".$status."', dc_use='".$od_use."', dc_modify=sysdate where dc_keycode='".$od_keycode."' ";
			///$json["sql4"]=$sql;
			dbcommit($sql);
			$sql=" update ".$dbH."_marking set mr_status='".$status."', mr_use='".$od_use."', mr_modify=sysdate where mr_keycode='".$od_keycode."' ";
			///$json["sql5"]=$sql;
			dbcommit($sql);
			$sql=" update ".$dbH."_release set re_status='".$status."', re_use='".$od_use."', re_modify=sysdate where re_keycode='".$od_keycode."' ";
			///$json["sql6"]=$sql;
			dbcommit($sql);

			///han_recipeuser

			$json["resultCode"]="200";

			$json["od_keycode"] = $od_keycode;

		}
		else
		{
			$json["resultCode"]="302";///취소 불가능 
		}


		$json["apiCode"] = $apiCode;
		$json["returnData"] = $returnData;
		$json["resultMessage"]="OK";

	}
?>