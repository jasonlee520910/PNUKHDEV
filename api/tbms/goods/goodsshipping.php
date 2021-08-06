<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	if($apiCode!="goodsshipping"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodsshipping";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$page=$_GET["page"];
		$today=date("Y-m-d");
		$delicomp=$_GET["delicomp"];

		$wsql=" where to_char(a.usedate, 'yyyy-mm-dd')='".$today."' and a.deliconfirm <> 'C' and a.confirmdate is null ";

		$jsql=" a inner join han_order b on b.od_code=a.odcode  ";
		$jsql.=" inner join han_release c on c.re_keycode=b.od_keycode  ";
		$jsql.=" left join han_order_client d on d.keycode=b.od_keycode  ";

		

		if($delicomp=="POST"||$delicomp=="post")
		{
			$pg=apipaging("a.delicode","delicode_post",$jsql,$wsql);
			$sql="select * from ( ";
			$sql.=" select 
					 ROW_NUMBER() OVER (ORDER BY a.usedate desc) NUM, a.delicode, d.orderCode cyodcode,b.od_seq, b.od_code, b.od_title, c.re_sendname, c.re_name, c.re_address 
					from han_delicode_post $jsql $wsql order by a.usedate desc ";
			$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];
		}
		else
		{
			$pg=apipaging("a.delicode","delicode",$jsql,$wsql);

			$sql="select * from ( ";
			$sql.=" select 
					 ROW_NUMBER() OVER (ORDER BY a.usedate desc) NUM, a.delicode, d.orderCode cyodcode, b.od_seq, b.od_code, b.od_title, c.re_sendname, c.re_name, c.re_address 
					from han_delicode $jsql $wsql order by a.usedate desc ";
			$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];
		}

		$res=dbqry($sql);

		


		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();
		while($dt=dbarr($res))
		{

			//$od_chartpk=($dt["od_chartpk"]) ? $dt["od_chartpk"] : "";
			//if($dt["od_chartpk"]){$od_chartpk="<span style='padding:2px 5px;border-radius:2px;background:#CC66CC;color:#fff;'>OK ".$dt["od_chartpk"]."</span>";}else{$od_chartpk="";}
			//if($dt["cyodcode"]){$cyodcode="<span style='padding:2px 5px;border-radius:2px;background:#6699FF;color:#fff;'>BK ".($dt["cyodcode"]+10000)."</span>";}else{$cyodcode="";}
			//if($cyodcode){$od_chartpk=$cyodcode;}
			//if(!$od_chartpk) {$od_chartpk="<span style='padding:2px 5px;border-radius:2px;background:#549E08;color:#fff;'>CY ".($dt["od_seq"]+50000)."</span>";}

			$re_address=str_replace("||"," ",$dt["re_address"]);

			$addarray=array(
				"delicode"=>$dt["DELICODE"],//송장번호
				"odChartPK"=>$od_chartpk,//버키pk 
				"od_code"=>$dt["OD_CODE"],//주문번호 
				"od_title"=>$dt["OD_TITLE"],//처방명
				"re_sendname"=>$dt["RE_SENDNAME"],  //보내는사람 
				"re_name"=>$dt["RE_NAME"],  //받는사람
				"re_address"=>$re_address //받는사람 주소 
			);
			array_push($json["list"], $addarray);			
		}

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

	}
?>