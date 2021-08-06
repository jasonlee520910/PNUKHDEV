<?php
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$gd_seq=$_POST["seq"];
	$addqty=$_POST["addqty"];
	if($apicode!="goodqtyupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="goodqtyupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($gd_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else if($addqty==""){$json["resultMessage"]="API(qty) ERROR";}
	else{
		if($gd_seq&&$gd_seq!="add")
		{
			$workcode=date("YmdHis").substr(intval(microtime() * 10000),0,1);
			//제품 incoming
			//1. 제품에 대한 재고량(gd_qty) 가져오기 
			$sql=" select gd_code, gd_qty from ".$dbH."_goods where gd_seq='".$gd_seq."' ";
			$dt=dbone($sql);
			$gd_code=$dt["gd_code"];
			$gh_oldqty=$dt["gd_qty"];
			$gh_qty=$gh_oldqty + $gp_goodscnt;

			//2.제품에 판매량(gd_sales)추가와 재고량(gd_qty)에 추가 하기 
			$usql=" update ".$dbH."_goods set gd_sales=gd_sales+".$gp_goodscnt.", gp_qty=gp_qty+".$gp_goodscnt.", gd_modify=now() where gd_seq='".$gd_seq."'; ";
			dbqry($usql);
			$json["제품1:usql"]=$usql;

			//3. 제품에 대한 로그 
			$isql=" insert into ".$dbH."_goodshouse (gh_odcode, gh_type, gh_code, gh_oldqty, gh_addqty, gh_qty, gh_workcode, gh_use, gh_date) values ";
			$isql.=" ('".$gh_odcode."','incoming','".$gp_goods."','".$gh_oldqty."', '".$gp_goodscnt."','".$gh_qty."','','Y',now()); ";
			//dbqry($isql);
			$json["제품1:isql"]=$isql;

			$sql=" select gd_code, gd_qty from ".$dbH."_goods where gd_seq='".$gd_seq."' ";
			$dt=dbone($sql);
			$gd_code=$dt["gd_code"];
			$oldqty=$dt["gd_qty"];
			$ghqty=$oldqty + $addqty;

			$sql=" update ".$dbH."_goods set gd_qty='".$ghqty."', gd_modify=now() where gd_seq='".$gd_seq."' ";
			dbqry($sql);

			$sql=" insert into ".$dbH."_goodshouse (gh_type, gh_code, gh_oldqty, gh_addqty, gh_qty, gh_workcode, gh_date) values	('incoming', '".$gd_code."', '".$oldqty."', '".$addqty."', '".$ghqty."', '".$workcode."', now()) ";
			dbqry($sql);
		}
		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>