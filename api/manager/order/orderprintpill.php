<?php
	///GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$od_code=$_GET["odCode"];
	if($apicode!="orderprintpill"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="orderprintpill";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($od_code==""){$json["resultMessage"]="API(od_code) ERROR";}
	else{
		$returnData=$_GET["returnData"];

		$ssql=" a.OD_SEQ, a.OD_CODE, a.OD_KEYCODE, a.OD_TITLE, a.OD_GOODS, a.OD_USERID, a.OD_PILLCAPA, a.OD_QTY, a.OD_REQUEST, a.OD_STATUS, a.OD_MATYPE, a.OD_DATE, a.od_name, to_char(a.OD_BIRTH, 'yyyy-mm-dd') as ODBIRTH ";
		$ssql.=" ,r.RC_SOURCE, r.RC_MEDICINE,  r.RC_SWEET, r.RC_PILLORDER ";
		$ssql.=" ,p.PL_DCTITLE,p.PL_DCSPECIAL,p.PL_DCTIME,p.PL_DCWATER,p.PL_FINENESS,p.PL_MILLINGLOSS,p.PL_CONCENTRATIO,p.PL_CONCENTTIME,p.PL_BINDERS ";
		$ssql.=" ,p.PL_BINDERSLIANG,p.PL_WARMUPTEMPERATURE,p.PL_WARMUPTIME,p.PL_FERMENTTEMPERATURE,p.PL_FERMENTTIME,p.PL_SHAPE,p.PL_DRYTEMPERATURE ";
		$ssql.=" ,p.PL_DRYTIME,p.PL_LOSSPILL,p.PL_DCALCOHOL,p.PL_JUICE ";

		$wsql=" where a.od_code = '".$od_code."' ";
		
		$jsql.=" a inner join ".$dbH."_recipeuser r on a.od_scription=r.rc_code ";
		$jsql.=" inner join ".$dbH."_pill p on p.PL_ODCODE=a.OD_CODE ";

		$sql=" select ".$ssql." from ".$dbH."_order $jsql $wsql ";
		$dt=dbone($sql);

		$mrlist=getPillorderData(getClob($dt["RC_PILLORDER"]));

		$gdPilllist=$mrlist["pilllist"];
		$gdPillmedicine=$mrlist["pillmedicine"];
		$gdtotmedicapa=$mrlist["totmedicapa"];
		$gdtotmediprice=$mrlist["totmediprice"];

		//포장에 있는 work 데이터 말기 
		$packingcode="";
		foreach($gdPilllist as $key => $val)
		{
			$type=$gdPilllist[$key]["order"]["type"];
			if($type=="packing")
			{
				$pwork=$gdPilllist[$key]["order"]["order"]["work"];

				for($j=0;$j<count($pwork);$j++)
				{
					if($j>0)
					{
						$packingcode.=",";
					}
					if($pwork[$j]["code"]=="plPacking")
					{
						$packingcode.="'".$pwork[$j]["value"]."'";
					}	
	
				}


				break;
			}
		}
		
		$packinglist=getPackingData($packingcode);



		$json=array(
			//order
			"odSeq"=>$dt["OD_SEQ"],
			"odCode"=>$dt["OD_CODE"],
			"odKeycode"=>$dt["OD_KEYCODE"],
			"odStatus"=>$dt["OD_STATUS"],
			"odTitle"=>$dt["OD_TITLE"],
			"odPillcapa"=>$dt["OD_PILLCAPA"], 
			"odQty"=>$dt["OD_QTY"],
			"odGoods"=>$dt["OD_GOODS"],
			"matypeName"=>$dt["MATYPE"],
			"odDate"=>$dt["OD_DATE"],
			"odRequest"=>getClob($dt["OD_REQUEST"]),
			"packingcode"=>$packingcode,
			"packinglist"=>$packinglist,

			"gdtotmedicapa"=>$gdtotmedicapa,
			"gdtotmediprice"=>$gdtotmediprice,

			"gdPilllist"=>$gdPilllist,
			"gdPillmedicine"=>$gdPillmedicine
		);	
		
		
		$json["sql"]=$sql;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}


	function getPackingData($code)
	{
		$csql=" select
				a.GD_NAME_KOR as GDNAME, a.GD_CODE, b.AF_URL 
				from han_goods a
				left join han_file b on b.AF_FCODE=a.GD_CODE and b.AF_CODE='goods' and b.af_use='Y'
				where a.GD_CODE in (".$code.") ";
		$cres=dbqry($csql);
		$list=array();
		while($cdt=dbarr($cres))
		{
			$name=($cdt["GDNAME"])?$cdt["GDNAME"]:"";
			$code=($cdt["GD_CODE"])?$cdt["GD_CODE"]:"";
			$file=getafThumbUrl($cdt["AF_URL"]);
			$addarry=array(
				"code"=>$code,
				"name"=>$name,
				"file"=>$file
				);

			array_push($list,$addarry);
		}

		return $list;
	}
?>
