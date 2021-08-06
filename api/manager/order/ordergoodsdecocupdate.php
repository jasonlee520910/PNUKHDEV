<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$rc_code=$_GET["rcCode"];
	$gd_marking=$_GET["gdMarking"];

	if($apicode!="ordergoodsdecocupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="ordergoodsdecocupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($rc_code==""){$json["resultMessage"]="API(rccode) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		
		$sql=" update ".$dbH."_recipeuser ";
		$sql.=" set rc_source='".$gd_marking."' where rc_code='".$rc_code."' ";
		dbcommit($sql);

		$json["gd_marking"]=$gd_marking;

		$osql=" select a.od_matype,a.od_goods,b.orderCount
				from han_order a
				left join han_order_client b on b.keycode=a.od_keycode
				where a.od_scription='".$rc_code."' ";
		$odt=dbone($osql);
		$od_qty=($odt["ORDERCOUNT"])?$odt["ORDERCOUNT"]:"1";
		$od_matype=$odt["OD_MATYPE"];
		$od_goods=$odt["OD_GOODS"];
		$json["od_qty"]=$od_qty;
		$json["od_matype"]=$od_matype;
		$json["od_goods"]=$od_goods;




		//if($od_matype=="goods")
		if($gd_marking)
		{
			//matype이 goods 일때만 팩수, 팩용량, 파우치, 한약박스, 배송박스 선택하게 하자.. 왜냐면 데이터가 안넘어오니깐..
			$rsql="select rc_medicine as rcmedicine,rc_sweet as rcsweet, rc_chub,rc_packcnt,rc_packtype,rc_packcapa,rc_medibox  from han_recipemedical where rc_code='".$gd_marking."'";
			$rdt=dbone($rsql);
			$rc_medicine=getClob($rdt["RCMEDICINE"]);
			$rc_sweet=getClob($rdt["RCSWEET"]);
			$od_chubcnt=$rdt["RC_CHUB"];
			$od_packcnt=$rdt["RC_PACKCNT"];
			$rc_packtype=$rdt["RC_PACKTYPE"];
			$od_packcapa=$rdt["RC_PACKCAPA"];
			$rc_medibox=$rdt["RC_MEDIBOX"];


			$json["rc_medicine"]=$rc_medicine;
			$json["rc_sweet"]=$rc_sweet;
			$json["od_chubcnt"]=$od_chubcnt;
			$json["od_packcnt"]=$od_packcnt;
			$json["rc_packtype"]=$rc_packtype;
			$json["od_packcapa"]=$od_packcapa;
			$json["rc_medibox"]=$rc_medibox;


			//파우치, 한약박스 정보 가져오기 
			$psql=" select pb_type, pb_title, pb_code, pb_codeonly, pb_priceA, pb_priceB, pb_priceC, pb_priceD, pb_priceE, pb_capa, pb_maxcnt  
					from han_packingbox where pb_code in ('".$rc_packtype."','".$rc_medibox."') ";
			$pres=dbqry($psql);
			$json["psql"]=$psql;
			while($pdt=dbarr($pres))
			{
				if($pdt["PB_TYPE"]=="odPacktype")
				{
					$odPacktype=array(
						"pb_title"=>$pdt["PB_TITLE"],
						"pb_code"=>$pdt["PB_CODE"],
						"pb_codeonly"=>$pdt["PB_CODEONLY"],
						"pb_priceA"=>$pdt["PB_PRICEA"],
						"pb_priceB"=>$pdt["PB_PRICEB"],
						"pb_priceC"=>$pdt["PB_PRICEC"],
						"pb_priceD"=>$pdt["PB_PRICED"],
						"pb_priceE"=>$pdt["PB_PRICEE"],
						"pb_capa"=>$pdt["PB_CAPA"],
						"pb_maxcnt"=>$pdt["PB_MAXCNT"]
						);
				}
				else if($pdt["PB_TYPE"]=="reBoxmedi")
				{
					$reBoxmedi=array(
						"pb_title"=>$pdt["PB_TITLE"],
						"pb_code"=>$pdt["PB_CODE"],
						"pb_codeonly"=>$pdt["PB_CODEONLY"],
						"pb_priceA"=>$pdt["PB_PRICEA"],
						"pb_priceB"=>$pdt["PB_PRICEB"],
						"pb_priceC"=>$pdt["PB_PRICEC"],
						"pb_priceD"=>$pdt["PB_PRICED"],
						"pb_priceE"=>$pdt["PB_PRICEE"],
						"pb_capa"=>$pdt["PB_CAPA"],
						"pb_maxcnt"=>$pdt["PB_MAXCNT"]
						);
				}
			}

			$hCodeList = getNewCodeTitle("mrDesc");
			$mrDescList = getCodeList($hCodeList, 'mrDesc');//마킹정보리스트 

			$json["odPacktype"]=$odPacktype;
			$json["reBoxmedi"]=$reBoxmedi;
			$json["mrDescList"]=$mrDescList;


		}
		else
		{
			$hCodeList = getNewCodeTitle("mrDesc");
			$mrDescList = getCodeList($hCodeList, 'mrDesc');//마킹정보리스트 
			$json["mrDescList"]=$mrDescList;
		}



		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
