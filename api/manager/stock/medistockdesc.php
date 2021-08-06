<?php  
	/// 재고관리 > 약재재고목록 > 재고수량 클릭시 상세 
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$whStock=$_GET["whStock"];
	$page=$_GET["page"];

	if($apicode!="medistockdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="medistockdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$jsql=" a left join ".$dbH."_makingtable b on b.mt_code = a.wh_table ";
		$jsql.=" left join ".$dbH."_code c on (c.cd_type='whStatusInStock' and a.wh_type='incoming' and a.wh_status=c.cd_code) ";
		$jsql.=" or (c.cd_type='whStatusOutStock' and a.wh_type='outgoing' and a.wh_status=c.cd_code)";
		$jsql.=" left join ".$dbH."_code d on d.cd_type='whStatusGeStock' and a.wh_type=d.cd_code  ";

		$wsql=" where wh_stock='".$whStock."' ";

		$pg=apipaging("wh_seq","warehouse",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.wh_indate desc) NUM ";
		$sql.=" ,b.mt_title, c.cd_name_".$language." as CNAME,d.cd_name_".$language." as DNAME ";	
		$sql.=" ,a.wh_type,a.wh_status,a.wh_code,a.wh_stock,a.wh_table,a.wh_qty,a.wh_remain,a.wh_price,a.wh_staff ";
		$sql.=" ,to_char(a.wh_date,'yyyy-mm-dd') as WH_DATE"; 
		$sql.=" from ".$dbH."_warehouse $jsql $wsql ";
		$sql.=" order by a.wh_indate desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];


		$res=dbqry($sql);

		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];

		$json["list"]=array();
		while($dt=dbarr($res))
		{
			$addarray=array(
				"mtTitle"=>$dt["MT_TITLE"], 
				"whStatusName"=>$dt["CNAME"], 
				"whTypeName"=>$dt["DNAME"],
				"whType"=>$dt["WH_TYPE"], 
				"whStatus"=>$dt["WH_STATUS"], 
				"whCode"=>$dt["WH_CODE"], 
				"whStock"=>$dt["WH_STOCK"],
				"whTable"=>$dt["WH_TABLE"],
				"whQty"=>$dt["WH_QTY"],
				"whRemain"=>$dt["WH_REMAIN"],
				"whPrice"=>$dt["WH_PRICE"], 
				"whStaff"=>$dt["WH_STAFF"], 
				"whDate"=>$dt["WH_DATE"] //입출고일 
				);
			array_push($json["list"], $addarray);
		}
		$json["whStock"]=$whStock;
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>