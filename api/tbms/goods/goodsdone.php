<?php //스텝 등록/수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$code=$_POST["code"];
	$defineprocess=$_POST["defineprocess"];

	if($apiCode!="goodsdone"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodsdone";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		
		//재고떨어내기 
		//제품과 구성요소 가져오기 
		$sql="select gp_goods,gp_goodscnt, gp_subgoods as GPSUBGOODS from ".$dbH."_package where gp_odcode='".$code."' ";
		$dt=dbone($sql);
		$gp_goods=$dt["GP_GOODS"];
		$gp_goodscnt=$dt["GP_GOODSCNT"];
		$gp_subgoods=getClob($dt["GPSUBGOODS"]);
		$json["package:sql"]=$sql;

		$gh_odcode=$code;
		
		//-----------------------------------------------
		// 제품 
		//-----------------------------------------------
		//제품 incoming

		//1. 제품에 대한 재고량(gd_qty) 가져오기 
		$sql=" select gd_code, gd_qty from ".$dbH."_goods where gd_code='".$gp_goods."' ";
		$dt=dbone($sql);
		$gh_oldqty=$dt["GD_QTY"];
		$json["제품1:sql"]=$sql;
		$gh_qty=$gh_oldqty + $gp_goodscnt;

		
		//2.제품에 판매량(gd_sales)추가와 재고량(gd_qty)에 추가 하기 
		$usql=" update ".$dbH."_goods set gd_sales=gd_sales+".$gp_goodscnt.", gd_qty=gd_qty+".$gp_goodscnt.", gd_modify=sysdate where gd_code='".$gp_goods."' ";
		dbcommit($usql);
		$json["제품1:usql"]=$usql;


		//3. 제품에 대한 로그 
		$isql=" insert into ".$dbH."_goodshouse (GH_SEQ, gh_odcode, gh_type, gh_code, gh_oldqty, gh_addqty, gh_qty, gh_workcode, gh_use, gh_date) values ";
		$isql.=" ((SELECT NVL(MAX(GH_SEQ),0)+1 FROM ".$dbH."_goodshouse), '".$gh_odcode."','incoming','".$gp_goods."','".$gh_oldqty."', '".$gp_goodscnt."','".$gh_qty."','','Y',sysdate) ";
		dbcommit($isql);
		$json["제품1:isql"]=$isql;
		//-----------------------------------------------
		//제품 outgoing

		//1. 제품에 대한 재고량(gd_qty) 가져오기 
		$sql=" select gd_code, gd_qty from ".$dbH."_goods where gd_code='".$gp_goods."' ";
		$dt=dbone($sql);
		$gh_oldqty=$dt["GD_QTY"];
		$gh_addqty=$gp_goodscnt * -1;
		$gh_qty=$gh_oldqty + $gh_addqty;
		
		//2.제품에 재고량(gd_qty) 빼기 
		$usql=" update ".$dbH."_goods set gd_qty=gd_qty-".$gp_goodscnt.", gd_modify=sysdate where gd_code='".$gp_goods."' ";
		dbcommit($usql);
		$json["제품2:usql"]=$usql;

		//3. 제품에 대한 로그 
		$isql=" insert into ".$dbH."_goodshouse (GH_SEQ, gh_odcode, gh_type, gh_code, gh_oldqty, gh_addqty, gh_qty, gh_workcode, gh_use, gh_date) values ";
		$isql.=" ((SELECT NVL(MAX(GH_SEQ),0)+1 FROM ".$dbH."_goodshouse),'".$gh_odcode."','sales','".$gp_goods."','".$gh_oldqty."', '".$gh_addqty."','".$gh_qty."','','Y',sysdate) ";
		dbcommit($isql);
		$json["제품2:isql"]=$isql;
		//-----------------------------------------------


		//-----------------------------------------------
		// 구성요소  
		//-----------------------------------------------
		//구성요소는 goodshose에  outgoing 추가, goods에 gd_qty  빼기 
		// 20200304 : 팀장님이 나중에 입고처리할때 한꺼번에 할꺼라 지금은 빼면 안된다고 하심..그래서 제외 
		/*
		$arrg=explode(",", $gp_subgoods);
		for($i=1;$i<count($arrg);$i++)
		{
			$arrs=explode("|",$arrg[$i]);
			$gcode=$arrs[0];
			$gcnt=$arrs[1]*$gp_goodscnt;
			$gh_addqty=$gcnt * -1;

			//1.구성요소에 대한 재고량(gd_qty) 가져오기 
			$sql=" select gd_code, gd_qty from ".$dbH."_goods where gd_code='".$gcode."' ";
			$dt=dbone($sql);
			$gh_oldqty=$dt["gd_qty"];
			$gh_qty=$gh_oldqty - $gcnt;
		
			//2.구성요소에 재고량(gd_qty) 빼기 
			$usql=" update ".$dbH."_goods set gd_qty=gd_qty-".$gcnt.", gd_modify=sysdate where gd_code='".$gcode."' ";
			dbqry($usql);
			$json["구성요소:usql".$i]=$usql;

			//3.구성요소에 대한 로그 
			$isql=" insert into ".$dbH."_goodshouse (gh_odcode, gh_type, gh_code, gh_oldqty, gh_addqty, gh_qty, gh_workcode, gh_use, gh_date) values ";
			$isql.=" ('".$gh_odcode."','sales','".$gcode."','".$gh_oldqty."', '".$gh_addqty."','".$gh_qty."','','Y',sysdate) ";
			dbqry($isql);
			$json["구성요소:isql".$i]=$isql;
		}
		*/
		//-----------------------------------------------


		//if($defineprocess == "true")
		{
			$sql=" update ".$dbH."_order set od_status='done' where od_code='".$code."'";
			dbcommit($sql);
			$sql=" update ".$dbH."_package set gp_status='goods_done', gp_modify=sysdate where gp_odcode='".$code."'";
			dbcommit($sql);
		}
		/*else
		{
			$sql=" update ".$dbH."_order set od_status='goods_apply' where od_code='".$code."'";
			dbqry($sql);
			$sql=" update ".$dbH."_package set gp_status='goods_apply', gp_modify=sysdate where gp_odcode='".$code."'";
			dbqry($sql);
		}*/
		
				
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>