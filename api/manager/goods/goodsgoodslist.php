<?php //제품만 가져오기 
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$mt_seq=$_GET["seq"];

	if($apiCode!="goodsgoodslist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodsgoodslist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);
		$searchpop=urldecode($_GET["searchPop"]);
		$searperiodtype=$_GET["searPeriodType"];
		$searchperiod=$_GET["searchPeriod"];
		$searchstatus=$_GET["searchStatus"];
		$searchtype=$_GET["searchType"];
		$searchtxt=$_GET["searchTxt"];
		$reData=$_GET["reData"];

		$jsql=" a  left join ".$dbH."_code c on c.cd_type='gdType' and a.gd_type=c.cd_code and c.cd_use ='Y' ";
		$jsql.=" left join ".$dbH."_code d on d.cd_type='gdCategory' and a.gd_category=d.cd_code and d.cd_use ='Y' ";
		$wsql=" where a.gd_use in ('Y','A') and a.gd_type='goods' and (a.gd_category<>'decoction' or a.gd_category is null) ";  ////사용전과 사용중인것만 보임

		if($searchpop)  //layer-medicine에서 검색했을때
		{
			$arr=explode("|",$searchpop);
			foreach($arr as $val)
			{
				if($val)
				{
					$arr2=explode(",",$val);
					$json["arr2[0]"]=$arr2[0];
					$json["arr2[1]"]=$arr2[1];
					if($arr2[0]=="searpoptxt")
					{
						$seardata=$arr2[1];
					}
				}
			}
			$json["seardata"]=$seardata;
			if($seardata)
			{
				$wsql.=" and a.gd_name_kor like '%".$seardata."%' ";
			}
		}

		$pg=apipaging("a.gd_seq","goods",$jsql,$wsql);

		$ssql="  a.GD_SEQ, a.GD_CODE, a.GD_CYPK, a.GD_BOMCODE, a.gd_name_kor gd_name, to_char(a.GD_MODIFY, 'yyyy-mm-dd hh24:mi:ss') as GDMODIFY, c.cd_name_kor gdType, d.cd_name_kor gdCategory ";
		$sql=" select * from ( ";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.gd_seq) NUM, ".$ssql." from ".$dbH."_goods $jsql $wsql order by a.gd_seq desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];


		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();
		while($dt=dbarr($res)){
			$gdBom=$gdcode=$gdGoodsTxt="";
			if($dt["GD_BOMCODE"]!="")
			{
				$arr=explode(",",$dt["GD_BOMCODE"]);
				$gdBom=(count($arr)-1)."종";
				for($i=0;$i<count($arr);$i++)
				{
					if($arr[$i])
					{
						$arr2=explode("|",$arr[$i]);
						if($gdcode!="")
						{
							$gdcode.=",";
						}
						$gdcode.="'".$arr2[0]."'";
					}
				}
				if($gdcode)
				{
					$tsql=" select LISTAGG(gd_name_kor, ',')  WITHIN GROUP (ORDER BY gd_name_kor asc) as GDNAME from ".$dbH."_goods where gd_code in (".$gdcode.") ";
					$tdt=dbone($tsql);
					$gdGoodsTxt=$tdt["GDNAME"];
					$gdGoodsTxt=str_replace(" ","",$gdGoodsTxt);
				}
				else
				{
					$gdGoodsTxt="";
				}
			}
			$gd_cypk=($dt["GD_CYPK"]) ? $dt["GD_CYPK"]:"";
			$addarray=array(
				"seq"=>$dt["GD_SEQ"], 
				"gdCode"=>$dt["GD_CODE"], 
				"gdCypk"=>$gd_cypk, //cy버키PK
				"gdName"=>$dt["GD_NAME"], 
				"gdBom"=>$gdBom, 
				"gdGoodsTxt"=>$gdGoodsTxt,
				"gdDate"=>$dt["GDMODIFY"]);
			array_push($json["list"], $addarray);
		}

		$json["tsql"]=$tsql;
		$json["reData"]=$reData;
		
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>