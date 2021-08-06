<?php
	///GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odCode=$_GET["odCode"];
	
	if($apicode!="goodssummarypill"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="goodssummarypill";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($odCode==""){$json["resultMessage"]="API(od_code) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];

		//$hCodeList = getNewCodeTitle("pillShape,pillBinders,pillFineness,pillRipen,pillRatio,pillTime,pillTemperature,dcTitle,dcSpecial,pillJuice,pillOrder");
		//제환순서 
		//$pillOrderList = getCodeList($hCodeList, 'pillOrder');


		$ssql=" a.OD_SEQ, a.OD_CODE, a.OD_KEYCODE, a.OD_TITLE, a.OD_GOODS, a.OD_PILLCAPA, a.OD_QTY, a.OD_REQUEST, a.OD_STATUS ";
		$ssql.=" ,r.RC_PILLORDER ";
		$wsql=" where a.od_code = '".$odCode."' ";
		
		$jsql=" a inner join ".$dbH."_recipeuser r on a.od_scription=r.rc_code ";
		$jsql.=" inner join ".$dbH."_pill p on p.PL_KEYCODE=a.OD_KEYCODE ";

		$sql=" select ".$ssql." from ".$dbH."_order $jsql $wsql ";
		$dt=dbone($sql);

		$mrlist=getPillorderData(getClob($dt["RC_PILLORDER"]));

		if($dt["OD_GOODS"]=="G"){$gGoods="사전";}else{$gGoods="";}
		if($gGoods) {$gGoods="<span style='padding:2px 5px;border-radius:2px;background:#FF0000;color:#fff;'>".$gGoods."</span>";}

		$json=array(
			"odSeq"=>$dt["OD_SEQ"],
			"odCode"=>$dt["OD_CODE"],
			"odKeycode"=>$dt["OD_KEYCODE"],
			"odPillcapa"=>$dt["OD_PILLCAPA"],
			"odQty"=>$dt["OD_QTY"],
			"odTitle"=>$dt["OD_TITLE"],
			"gGoods"=>$gGoods,
			"odRequest"=>getClob($dt["OD_REQUEST"]),
			"odStatus"=>$dt["OD_STATUS"]

			
		);	



		$json["mrlist"]=$mrlist;
		$json["pillorder"]=$mrlist["pillorder"];
		$json["pillmedicine"]=$mrlist["pillmedicine"];
		$json["medicinecnt"]=$mrlist["rcMedicineCnt"];
		$json["totmedicapa"]=$mrlist["totmedicapa"];//총약재량
		$json["totmediprice"]=$mrlist["totmediprice"];//총약재비
		$json["pilllist"]=$mrlist["pilllist"];//orderpill 저장할 데이터들..

		$json["totmedicnt"]=count($mrlist["pillmedicine"]);
		
		
		$json["sql"]=$sql;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>