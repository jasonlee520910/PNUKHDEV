<?php //스텝 등록/수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$code=$_POST["code"];
	$defineprocess=$_POST["defineprocess"];

	if($apiCode!="releasedone"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="releasedone";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql=" select ";
		$sql.=" a.od_matype, a.od_goods,a.od_packcnt, a.od_title, b.rc_source, c.orderCount, c.productCode ";
		$sql.=" from ".$dbH."_order ";
		$sql.=" a inner join ".$dbH."_recipeuser b on b.rc_code=a.od_scription ";
		$sql.=" left join ".$dbH."_order_client c on c.keycode=a.od_keycode ";
		$sql.=" where a.od_code='".$code."' ";
		$dt=dbone($sql);
		$od_matype=$dt["OD_MATYPE"];
		$od_goods=$dt["OD_GOODS"];
		$rc_source=$dt["RC_SOURCE"];
		$orderCount=$dt["ORDERCOUNT"];
		$od_title=$dt["OD_TITLE"];
		$od_packcnt=$dt["OD_PACKCNT"];
		$productCode=$dt["PRODUCTCODE"];

		$json["포장sql"]=$sql;

		//실속(재고), 상비(재고) 일 경우, 약속(재고),탕전(재고)
		if(($od_matype=="worthy" && $od_goods=="Y" && $rc_source) || ($od_matype=="commercial" && $od_goods=="Y" && $rc_source) || ($od_matype=="goods" && $od_goods=="Y" && $rc_source) || ($od_matype=="decoction" && $od_goods=="Y" && $rc_source)  || ($od_matype=="goods" && $od_goods=="P"))
		{
			if( ($od_matype=="decoction" && $od_goods=="Y" && $rc_source) ||  ($od_matype=="worthy" && $od_goods=="Y" && $rc_source) || ($od_matype=="commercial" && $od_goods=="Y" && $rc_source) || ($od_matype=="goods" && $od_goods=="Y" && $rc_source))
			{
				//20200113 : 주문갯수*팩수 
				//$gp_count=($orderCount) ? intval($orderCount) : 1;
				//$gp_packcnt=($od_packcnt) ? intval($od_packcnt) : 1;
				//$gp_cnt=$gp_count*$gp_packcnt;

				//20200220 : 팩수 만큼만 뺀다. 미리 첩수,팩수 주문갯수 * 팩수 했음
				$gp_packcnt=($od_packcnt) ? intval($od_packcnt) : 1; //미리 manager confirm에서 첩수, 팩수 수정했음 
				$gp_cnt=$gp_packcnt;
			}
			else
			{
				$gp_cnt=($orderCount) ? intval($orderCount) : 1;
				$gp_cnt=($gp_cnt==0) ? 1: $gp_cnt;
			}

			//1. 제품에 대한 재고량(gd_qty) 가져오기 
			if($rc_source)
			{
				$sql=" select gd_code, gd_qty from ".$dbH."_goods where gd_recipe='".$rc_source."' ";
				$dt=dbone($sql);
				$gh_oldqty=$dt["GD_QTY"];
				$gd_code=$dt["GD_CODE"];
				$gh_qty=$gh_oldqty - $gp_cnt;
			}
			else
			{
				$sql=" select gd_code, gd_qty from han_goods where gd_cypk like '%,".$productCode.",%' ";
				$dt=dbone($sql);
				$gh_oldqty=$dt["GD_QTY"];
				$gd_code=$dt["GD_CODE"];
				$gh_qty=$gh_oldqty - $gp_cnt;				
			}

			
			//2.제품에 판매량(gd_sales)추가와 재고량(gd_qty)에 차감 
			$usql=" update ".$dbH."_goods set gd_sales=gd_sales+".$gp_cnt.", gd_qty=gd_qty-".$gp_cnt.", gd_modify=sysdate where gd_code='".$gd_code."' ";
			dbcommit($usql);
			$json["제품1:usql"]=$usql;

			$gh_desc="";
			if($od_matype=="worthy")
			{
				$gh_desc="실속(재고) - ".$od_title;
			}
			else if($od_matype=="commercial")
			{
				$gh_desc="상비(재고) - ".$od_title;
			}
			else if($od_matype=="goods")
			{
				if($od_goods=="P")
				{
					$gh_desc="약속(기획) - ".$od_title;
				}
				else
				{
					$gh_desc="약속(재고) - ".$od_title;
				}
			}
			else if($od_matype=="decoction")
			{
				$gh_desc="탕제(재고) - ".$od_title;
			}

			
			$gh_addqty=$gp_cnt * (-1);//이것은 재고를 차감이니깐 여기서는 차감으로 보여야함 



			//3. 제품에 대한 로그 
			$isql=" insert into ".$dbH."_goodshouse (GH_SEQ, gh_odcode, gh_type, gh_code, gh_oldqty, gh_addqty, gh_qty, gh_desc, gh_workcode, gh_use, gh_date) values ";
			$isql.=" ((SELECT NVL(MAX(GH_SEQ),0)+1 FROM ".$dbH."_goodshouse),'".$code."','sales','".$gd_code."','".$gh_oldqty."', '".$gh_addqty."','".$gh_qty."','".$gh_desc."','','Y',sysdate) ";
			dbcommit($isql);
			$json["제품1:isql"]=$isql;
		}
		
		/*if($defineprocess == "true")
		{*/
			$sql=" update ".$dbH."_order set od_status='done' where od_code='".$code."'";
			dbcommit($sql);
			$sql=" update ".$dbH."_release set re_status='release_done', re_modify=sysdate where re_odcode='".$code."'";
			dbcommit($sql);
		/*}
		else
		{
			$sql=" update ".$dbH."_order set od_status='release_apply' where od_code='".$code."'";
			dbqry($sql);
			$sql=" update ".$dbH."_release set re_status='release_apply', re_modify=sysdate where re_odcode='".$code."'";
			dbqry($sql);
		}*/
		
				
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>