<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odCode=$_GET["odCode"];

	if($apiCode!="markingdeliverycnt"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="markingdeliverycnt";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$rsql=" select 
				a.od_title, a.od_packcnt, a.od_packcapa, a.od_goods, a.od_chubcnt , a.od_matype 
				, b.re_boxmedi,b.re_boxmedivol, b.re_boxmedipack, b.re_boxmedicnt, b.re_boxmedicntdata as REBOXMEDICNTDATA
				, c.pb_title
				, d.rc_source, d.rc_medicine as RCMEDICINE
				, cy.orderCode cyodcode, cy.orderCount
				from ".$dbH."_order a 
				inner join ".$dbH."_release b on b.re_keycode=a.od_keycode
				inner join ".$dbH."_recipeuser d on d.rc_code=a.od_scription 
				left join ".$dbH."_packingbox c on c.pb_code=b.re_boxmedi
				left join ".$dbH."_order_client cy on cy.keycode=a.od_keycode
				where a.od_code='".$odCode."' ";

		$rdt=dbone($rsql);

		$json["rsql"] = $rsql;//팩수
		
		$od_title=$rdt["OD_TITLE"];
		$od_packcnt=$rdt["OD_PACKCNT"];
		$od_packcapa=$rdt["OD_PACKCAPA"];
		$od_goods=$rdt["OD_GOODS"];
		$od_chubcnt=$rdt["OD_CHUBCNT"];

		$re_boxmedi=$rdt["RE_BOXMEDI"];
		$re_boxmedivol=$rdt["RE_BOXMEDIVOL"];
		$re_boxmedipack=$rdt["RE_BOXMEDIPACK"];
		$re_boxmedicnt=$rdt["RE_BOXMEDICNT"];
		$re_boxmedicntdata=getClob($rdt["REBOXMEDICNTDATA"]);

		$od_matype=$rdt["OD_MATYPE"];
		$rc_source=$rdt["RC_SOURCE"];

		$pb_title=$rdt["PB_TITLE"];

		$orderCode=$rdt["ORDERCODE"];
		$orderCount=($rdt["ORDERCOUNT"])?$rdt["ORDERCOUNT"]:"1";

		if($rdt["CYODCODE"]){$cyodcode="<span style='padding:2px 5px;border-radius:2px;background:#6699FF;color:#fff;'>BK ".($rdt["CYODCODE"]+10000)."</span>";}else{$cyodcode="";}
		if($cyodcode){$od_chartpk=$cyodcode;}


		$json["od_title"] = $od_chartpk." ".$od_title;//처방명 		
		$json["od_packcnt"] = $od_packcnt;//팩수
		$json["od_packcapa"] = $od_packcapa;//팩용량 

		$json["re_boxmedi"] = $re_boxmedi;//한약박스코드 
		$json["re_boxmedivol"] = $re_boxmedivol;//부피
		$json["re_boxmedipack"] = $re_boxmedipack;//최대팩수 
		$json["re_boxmedicnt"] = $re_boxmedicnt;//한약박스 갯수  
		$json["re_boxmedicntdata"] = $re_boxmedicntdata;//한약박스 갯수  
		

		$json["pb_title"] = $pb_title;//한약박스이름  

		$json["od_chartpk"] = $od_chartpk;//cy처방코드 
		$json["orderCode"] = $orderCode;//cy처방코드 
		$json["orderCount"] = $orderCount;//갯수

		$json["od_goods"] = $od_goods;//약재포장인지 

		if($od_goods=="M")//약재포장이면 
		{
			$rc_medicine=getClob($rdt["RCMEDICINE"]);
			$json["rc_medicine"] = $rc_medicine;
			$totmedicine=0;
			$totbujigpo=0;
			//약재무게 계산하자 
			$arr=explode("|",$rc_medicine);
			for($i=1;$i<count($arr);$i++)
			{
				$arr2=explode(",",$arr[$i]);
				//|HD10097_03,4.0,inmain,0|HD10134_01,4.0,inmain,0|HD10262_14,4.0,inmain,0|HD10233_06,4.0,inmain,99|HD10141_01,2.0,inmain,0
				$capa=floatval($arr2[1])*floatval($od_chubcnt);

				$totmedicine+=$capa;
			}
			$bujigpo=100;
			$totbujigpo=intval($bujigpo)*intval($od_chubcnt);


			$totmedicine=floatval($totmedicine)*floatval($orderCount);
			$totbujigpo=floatval($totbujigpo)*floatval($orderCount);

			$json["totmedicine"] = $totmedicine;//약재총무게 
			$json["totbujigpo"] = $totbujigpo;//부직포총 무게  

		}

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>