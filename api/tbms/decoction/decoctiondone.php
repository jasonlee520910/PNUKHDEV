<?php 
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$odcode=$_POST["odcode"];
	$staffid=$_POST["staffid"];
	$returnData=$_POST["returnData"];
	$decoctionprocess=$_POST["decoctionprocess"];

	if($apiCode!="decoctiondone"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="decoctiondone";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//5. 탕전 2차(포장기)시작 작업지시서(2차 마지막) 스캔 시 
		//	 pa_outtime 현시간 저장 상태 standby(대기) 변경
		//	 탕전기 standby(대기) 변경
		// - LOG-
		// - 포장기 pa_outtime  저장 상태 end 저장

		//decoction 탕전기 코드 가져오기 
		$dsql.=" select 
				a.dc_staffid, a.dc_packingid, a.dc_boilercode, a.dc_packingcode
				, b.od_goods, b.od_code , b.od_packcnt , b.od_title
				, c.rc_source
				 from ".$dbH."_decoction a 
				 inner join ".$dbH."_order b on b.od_keycode=a.dc_keycode
				 inner join ".$dbH."_recipeuser c on c.rc_code=b.od_scription
				 where a.dc_odcode='".$odcode."' ";
		$ddt=dbone($dsql);
		$dc_staffid=$ddt["DC_STAFFID"];
		$dc_packingid=$ddt["DC_PACKINGID"];
		$dc_boilercode=$ddt["DC_BOILERCODE"];
		$dc_packingcode=$ddt["DC_PACKINGCODE"];
		$od_code=$ddt["OD_CODE"];
		$od_packcnt=$ddt["OD_PACKCNT"];
		$od_title=$ddt["OD_TITLE"];

		$od_goods=$ddt["OD_GOODS"];
		$rc_source=$ddt["RC_SOURCE"];


		$today = date("Y-m-d H:i:s");

		//탕전기 standby 로 변경 
		//$usql=" update ".$dbH."_boiler set bo_status='standby' where bo_code='".$dc_boilercode."' ";
		//dbqry($usql);
		//$json["1탕전기"]=$usql;

		//포장기 pa_outtime 현시간 , standby 변경 
		$usql=" update ".$dbH."_packing set pa_status='standby', pa_outtime=sysdate where pa_code='".$dc_packingcode."' ";
		dbqry($usql);
		$json["1탕전완료"]=$usql;

		//포장기 pa_outtime  저장 상태 end 저장
		$sql1=" update ".$dbH."_packinglog set pa_outtime=sysdate, pa_status='end' where pa_odcode='".$odcode."'";
		dbqry($sql1);
		$json["2탕전완료"]=$sql1;


		//DOO :: 20181029 decoction프로세스 true이면 db쿼리 실행 
		/*if($decoctionprocess=="true")
		{*/
			if($od_goods=="G") //사전조제 
			{
				if($rc_source)
				{

					$gp_goodscnt=$od_packcnt;//사전조제한 갯수 

					//제품 incoming
					//1. 제품에 대한 재고량(gd_qty) 가져오기 
					$sql=" select gd_seq, gd_code, gd_qty from ".$dbH."_goods where gd_recipe='".$rc_source."' ";
					$dt=dbone($sql);
					$gd_seq=$dt["GD_SEQ"];
					$gd_code=$dt["GD_CODE"];
					$gh_oldqty=$dt["GD_QTY"];
					$gh_qty=$gh_oldqty + $gp_goodscnt;

					if($gd_seq)
					{
						//2.제품에 판매량(gd_sales)추가와 재고량(gd_qty)에 추가 하기 
						$usql=" update ".$dbH."_goods set  gd_qty=gd_qty+".$gp_goodscnt.", gd_modify=sysdate where gd_seq='".$gd_seq."' ";
						dbcommit($usql);
						$json["제품1:usql"]=$usql;

						//3. 제품에 대한 로그 
						$isql=" insert into ".$dbH."_goodshouse (GH_SEQ, gh_odcode, gh_type, gh_code, gh_oldqty, gh_addqty, gh_qty, gh_desc, gh_workcode, gh_use, gh_date) values ";
						$isql.=" ((SELECT NVL(MAX(GH_SEQ),0)+1 FROM ".$dbH."_goodshouse),'".$od_code."','incoming','".$gd_code."','".$gh_oldqty."', '".$gp_goodscnt."','".$gh_qty."','(사전) - ".$od_title."','','Y',sysdate) ";
						dbcommit($isql);
						$json["제품1:isql"]=$isql;

						$sql1=" update ".$dbH."_order set od_status='done' where od_code='".$odcode."'";
						dbcommit($sql1);
						$json["제품2:isql"]=$sql1;

						$sql2=" update ".$dbH."_decoction set dc_status='decoction_done' , dc_etime=sysdate where dc_odcode='".$odcode."'";
						dbcommit($sql2);
						$json["제품3:isql"]=$sql2;

						$json["apiCode"] = $apiCode;
						$json["resultCode"]="200";
						$json["resultMessage"]="OK";
					}
					else
					{
						$json["apiCode"] = $apiCode;
						$json["resultCode"]="198";
						$json["resultMessage"]="등록된 상품이 없습니다.";
					}
				}
				else
				{
					$json["apiCode"] = $apiCode;
					$json["resultCode"]="199";
					$json["resultMessage"]="매칭된 상품이 없습니다.";
				}
			}
			else
			{
				//탕전기 사용기록로그 필요??
				$sql1=" update ".$dbH."_order set od_status='marking_apply' where od_code='".$odcode."'";
				dbcommit($sql1);
				$json["3탕전완료"]=$sql1;

				$sql2=" update ".$dbH."_decoction set dc_status='decoction_done', dc_etime=sysdate, dc_modify=sysdate where dc_odcode='".$odcode."'";
				dbcommit($sql2);
				$json["4탕전완료"]=$sql2;

				$sql3=" update ".$dbH."_marking set mr_status='marking_apply' where mr_odcode='".$odcode."'";
				dbcommit($sql3);
				$json["5탕전완료"]=$sql3;

				$json["apiCode"] = $apiCode;
				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}
		/*}
		else
		{
			$sql1=" update ".$dbH."_order set od_status='decoction_apply' where od_code='".$odcode."'";
			dbqry($sql1);

			$sql2=" update ".$dbH."_decoction set dc_status='decoction_apply' , dc_etime=sysdate where dc_odcode='".$odcode."'";
			dbqry($sql2);

			$json["apiCode"] = $apiCode;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}*/


	}
?>