<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];

	if($apiCode!="orderpaymentcancel"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="orderpaymentcancel";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];

		$sql=" select ";
		$sql.=" a.od_code, a.od_keycode, b.od_status oStatus, a.od_scription  ";
		$sql.=" from ".$dbH."_order_medical ";
		$sql.=" a inner join ".$dbH."_order b on b.od_keycode=a.od_keycode ";
		$sql.=" where a.od_seq='".$seq."' and a.od_use='Y' ";
		$dt=dbone($sql);

		if($dt["oStatus"]=="paid")
		{
			$orderCode=$dt["od_code"];
			$json["orderCode"]=$orderCode;
			$json["hRoot"]=$hRoot;
			$json["hFolder"]=$hFolder;
			//include_once $hRoot.$hFolder."/hanpureCancelUpdate.php";

			if($hpOrderChk=="Y" && $hppaycancelStatus=="request")
			{
				$od_keycode=$dt["od_keycode"];
				$od_scription=$dt["od_scription"];
				//keycode
				$status="paidcancel";
				$od_use="Y";

				$sql=" update ".$dbH."_order_medical set od_status='".$status."', od_use='".$od_use."', od_modify=now() where od_keycode='".$od_keycode."' ";
				//$json["sql1"]=$sql;
				dbqry($sql);			
				$sql=" update ".$dbH."_order set od_status='".$status."', od_use='".$od_use."',od_modify=now() where od_keycode='".$od_keycode."' ";
				//$json["sql2"]=$sql;
				dbqry($sql);
				$sql=" update ".$dbH."_making set ma_status='".$status."', ma_use='".$od_use."', ma_modify=now() where ma_keycode='".$od_keycode."' ";
				//$json["sql3"]=$sql;
				dbqry($sql);
				$sql=" update ".$dbH."_decoction set dc_status='".$status."', dc_use='".$od_use."', dc_modify=now() where dc_keycode='".$od_keycode."' ";
				//$json["sql4"]=$sql;
				dbqry($sql);
				$sql=" update ".$dbH."_marking set mr_status='".$status."', mr_use='".$od_use."', mr_modify=now() where mr_keycode='".$od_keycode."' ";
				//$json["sql5"]=$sql;
				dbqry($sql);
				$sql=" update ".$dbH."_release set re_status='".$status."', re_use='".$od_use."', re_modify=now() where re_keycode='".$od_keycode."' ";
				//$json["sql6"]=$sql;
				dbqry($sql);

				//han_recipeuser
				$sql=" update ".$dbH."_recipeuser set rc_status='".$status."', rc_use='".$od_use."', rc_modify=now() where rc_code='".$od_scription."' ";
				dbqry($sql);
				$json["resultCode"]="200";

				$json["od_keycode"] = $od_keycode;
			}
			else
			{
				if($hpOrderChk=="Y" && $hppaycancelStatus=="")
				{
					$json["resultCode"]="301";//결제취소요청에 실패하였습니다.
				}
				else if($hpOrderChk=="Y" && $hppaycancelStatus=="success")
				{
					$json["resultCode"]="303";//결제취소된 주문입니다.
				}
				else
				{
					$json["resultCode"]="304";//없는 주문이거나 삭제된 주문입니다.
				}
			}

		}
		else
		{
			$json["resultCode"]="302";//취소 불가능 
		}


		$json["apiCode"] = $apiCode;
		$json["returnData"] = $returnData;
		$json["resultMessage"]="OK";

	}
?>