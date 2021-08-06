<?php  
	/// 제품재고관리 > 제품목록 > 제품목록리스트 > 반제품일경우 재고추가 버튼
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];

	if($apiCode!="goodsdescpop"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="goodsdescpop";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		function getbomCode($gdBom)
		{
			$bomCodeArr = explode(',', $gdBom);
			$bomCode=$bomCapa=array();
			foreach($bomCodeArr as $val)
			{
				$val2="";
				if($val)
				{
					$val2 = explode('|', $val);
					if($val2[1]<1){$capa=1;}else{$capa=$val2[1];}
					$bomCapa[$val2[0]]=$capa;
					$addArray=array("code"=>$val2[0],"capa"=>$capa);
					array_push($bomCode,$addArray);
				}
			}
			$addArray=array("bomCapa"=>$bomCapa);
			array_push($bomCapa,$addArray);
			$bomData=array("bomCode"=>$bomCode, "bomCapa"=>$bomCapa);
			return $bomData;
		}

		function bomCodeTxt($bomData)
		{
			$gdBomcode="";
			foreach($bomData as $val)
			{
				if($gdBomcode)$gdBomcode.=",";
				$gdBomcode.="'".$val["CODE"]."'";
			}
			return $gdBomcode;
		}

		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$jsql=" a inner join ".$dbH."_code c on c.cd_type='gdType' and a.gd_type=c.cd_code and c.cd_use='Y' ";
		$jsql.=" left join ".$dbH."_code d on d.cd_type='gdCategory' and a.gd_category=d.cd_code and d.cd_use='Y' ";
		$wsql=" where a.gd_seq='".$seq."' ";

		$sql=" select a.gd_seq , a.gd_type , a.gd_code, gd_capa, gd_loss, gd_losscapa , a.gd_name_".$language." gd_name, gd_bomcode, c.cd_name_".$language." gdTypeName , d.cd_name_".$language." gdCategory from ".$dbH."_goods $jsql $wsql ";
		$dt=dbone($sql);

		$gdSeq=$dt["GD_SEQ"];	
		$gdType=$dt["GD_TYPE"];
		$gdTypeName=$dt["GDTYPENAME"];
		$gdCode=$dt["GD_CODE"];	
		$gdName=$dt["GD_NAME"];	
		$gdCategory=$dt["GDCATEGORY"];
		$gdCapa=$dt["GD_CAPA"];	
		$gdLoss=$dt["GD_LOSS"];	
		$gdLosscapa=$dt["GD_LOSSCAPA"];	

		//bomData 추출
		$bomData=getbomCode($dt["GD_BOMCODE"]);
		$gdBomcode=bomCodeTxt($bomData["bomcode"]);

		//첫번째구성요소가 있을때
		if(count($bomData)>0 && $gdBomcode!="")
		{
			$sql2=" select a.gd_seq, a.gd_type, gd_bomcode from ".$dbH."_goods a  inner join ".$dbH."_code b on a.gd_type=b.cd_code and b.cd_type='gdType'  where gd_code in (".$gdBomcode.") order by field(gd_type, 'goods','pregoods','material','origin') ";
			$res2=dbqry($sql2);
			$bomArr=array();
			$bomcodelist=array();
		
			while($dt2=dbarr($res2))
			{
				$bomArr2=array();
				//두번째구성요소가 있을때

				if($dt2["GD_TYPE"]=="pregoods" || $dt2["GD_BOMCODE"]!="")
				{
					//bomData 추출
					$bomData2=getbomCode($dt2["GD_BOMCODE"]);
					$gdBomcode2=bomCodeTxt($bomData2["bomcode"]);
				}
			}
			
		}
		//첫번째상위구성요소
		$json=array(
			"gdTypeName"=>$dt["GDTYPENAME"],  //카테고리
			"gd_bomcode"=>$dt["GD_BOMCODE"],
			"apiCode"=>$apiCode,
			"returnData"=>$returnData,
			"seq"=>$gdSeq, 
			"gdType"=>$gdType, 
			"gdCategory"=>$gdCategory, 
			"gdCode"=>$gdCode, 
			"gdName"=>$gdName, 
			"gdCapa"=>$gdCapa, 
			"gdLoss"=>$gdLoss, 
			"gdLosscapa"=>$gdLosscapa, 
			"gdBom"=>$bomArr
		);

		$bomcode = substr($dt["GD_BOMCODE"], 1); //한자리만 자르기 
		$bomdat=getlist($bomcode);  //ETGDSH|5,FTSP004|1,FTGD001|1,ETSJHZ|2,ETSJHW|0,ETSJHZ|0
		$bomcodeList =$bomdat["bomdata"];
		$bomtotCapa =$bomdat["bomcapa"];
		$bomcodeSql =$bomdat["bomsql"];

		$json["bomcodeList"] = $bomcodeList;
		$json["bomtotCapa"] = $bomtotCapa;
		$json["bomcodeSql"] = $bomcodeSql;
		$json["bomData"]=$bomData;
		$json["gdBomcode"]=$gdBomcode;
		$json["gdBomcapa"]=$gdBomcapa;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

	function getlist($val)   //ETGDSH|9,FTZE001|3,FTYX001|4,FTXX012|5
	{
		//제품부재료를 제외한 저장되어있는 총 용량 계산 - 투입 비율 추출
		$bomcapa=0;
		$Arry = explode(',', $val);			
		$bomdata=array();
		$bomreturn=array();
		foreach($Arry as $value)
		{
			$items = explode('|', $value);

			$sql = " select a.gd_name_kor as title, a.gd_type, a.gd_loss, a.gd_losscapa, a.gd_capa, b.cd_name_kor gdname from han_goods a inner join han_code b on a.gd_type=b.cd_code and cd_type='gdType' where a.gd_code ='".$items[0]."' and a.gd_type!='origin' ";
			
			$dt2=dbone($sql);
			if($dt2["TITLE"])
			{
				if($items[1]<1){$capa=1;}else{$capa=$items[1];}
				$bomarr=array(
					"code"=>$items[0],
					"capa"=>$capa,
					"text"=>$dt2["TITLE"],
					"type"=>$dt2["GD_TYPE"],
					"name"=>$dt2["GDNAME"],
					"loss"=>$dt2["GD_LOSS"],
					"losscapa"=>$dt2["GD_LOSSCAPA"],
					"gdcapa"=>$dt2["GD_CAPA"]
					);

				//반제품의 경우만
				if($dt2["GD_TYPE"] == "pregoods")
				{
					$bomcapa=$bomcapa + $capa;
				}
			}
			else
			{
				$sql2=" select ";
				$sql2.=" a.mb_seq gd_seq, a.mb_code, b.mm_code gd_code, 1 gd_capa, b.mm_title_kor title, c.cd_name_kor gdname ";
				$sql2.=", d.md_loss gd_loss, d.md_losscapa gd_losscapa";
				$sql2.=" from han_medibox  ";
				$sql2.=" a inner join han_medicine_djmedi b on a.mb_medicine=b.md_code  ";
				$sql2.=" inner join han_medicine d on a.mb_medicine=d.md_code  ";
				$sql2.=" inner join han_code c on c.cd_code='origin' and c.cd_type='gdType' ";
				$sql2.=" where b.mm_code = '".$items[0]."' and a.mb_table='99999' ";

				$bomreturn["bomsql"]=$sql2;

				$dt3=dbone($sql2);

				if($items[1]<1){$capa=1;}else{$capa=$items[1];}
				$bomarr=array(
					"code"=>$items[0],
					"capa"=>$capa,
					"text"=>$dt3["TITLE"],
					"type"=>"origin",
					"name"=>$dt3["GDNAME"],
					"loss"=>$dt3["GD_LOSS"],
					"losscapa"=>$dt3["GD_LOSSCAPA"],
					"gdcapa"=>$dt3["GD_CAPA"]
					);
				//원재료의 경우
				$bomcapa=$bomcapa + $capa;
			}
			
			array_push($bomdata,$bomarr);
		}

		$bomreturn["bomdata"]=$bomdata;
		$bomreturn["bomcapa"]=$bomcapa;
		return $bomreturn;			
	}
?>

