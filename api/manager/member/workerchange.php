<?php  
	///주문리스트 > 작업지시서 출력에서 스태프 변경
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$od_code=$_GET["odCode"];
	$st_depart=$_GET["depart"];
	$st_staffid=$_GET["stStaffid"];

	if($apicode!="workerchange"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="workerchange";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($od_code==""){$json["resultMessage"]="API(od_code) ERROR";}
	else if($st_depart==""){$json["resultMessage"]="API(depart) ERROR";}
	else
	{
		$returndata=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returndata);

		$gsql="select od_seq, od_goods, od_matype from han_order where od_code='".$od_code."'";
		$gdt=dbone($gsql);
		$odGoods=$gdt["OD_GOODS"];
		$odSeq=$gdt["OD_SEQ"];
		$odMatype=$gdt["od_matype"];
		
		

		switch($st_depart)
		{
		case "making":
			if($st_staffid=="임의지정")
			{
				$sql=" update ".$dbH."_making set ma_staffid=NULL where ma_odcode='".$od_code."' ";
			}
			else
			{
				$sql=" update ".$dbH."_making set ma_staffid='".$st_staffid."' where ma_odcode='".$od_code."' ";
			}
			dbcommit($sql);
			break;
		case "decoction":
			$sql=" update ".$dbH."_decoction set dc_staffid='".$st_staffid."' where dc_odcode='".$od_code."' ";
			dbcommit($sql);
			break;
		}

		if($st_staffid != 'temp')
		{
			$wsql=" where st_use <>'D' and st_staffid = '".$st_staffid."' ";
			$sql2=" select st_name from ".$dbH."_staff $wsql ";
			$dt=dbone($sql2);

			$json["stName"]=$dt["ST_NAME"];
		}

		$json["sql2"]=$sql2;
		$json["sql"]=$sql;
		$json["odCode"]=$od_code;
		$json["odSeq"]=$odSeq;
		$json["odGoods"]=$odGoods;
		$json["odMatype"]=$odMatype;
		$json["depart"]=$st_depart;
		

		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>