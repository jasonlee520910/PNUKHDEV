<?php //약재사용리스트 다운로드 페이지
	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$date=$_GET["date"];
	if($apicode!="medicineuselist"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="medicineuselist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$ssql="  a.rc_seq,a.rc_code, a.rc_userid, a.rc_title_kor rcTitle, a.rc_medicine ,b.mi_name ,o.od_name, o.od_chubcnt ,m.ma_end ";
		$jsql.=" o inner join ".$dbH."_making m on o.od_code=m.ma_odcode ";
		$jsql.=" inner join ".$dbH."_recipeuser a on a.rc_code=o.od_scription ";
		$jsql.=" inner join ".$dbH."_medical b on a.rc_userid=b.mi_userid ";		
		$wsql=" where m.ma_status='making_done' ";

		if($date)
		{
			$wsql.=" and ( ";
			$wsql.=" left(m.ma_end,10) = '".$date."' ";
			$wsql.=" ) ";
		}
			
		$sql=" select $ssql from ".$dbH."_order  $jsql $wsql order by m.ma_end desc" ;

//echo $sql;
		$res=dbqry($sql);

		$json["sql"]=$sql;
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			$medidata=explode("|",$dt["rc_medicine"]);	
			for($i=1;$i<count($medidata);$i++)
			{								
				$medicode=explode(",",$medidata[$i]);
				$medivalue=getname($medicode[0]);	
				$totalvalue=round(floatval($medicode[1])*floatval($dt["od_chubcnt"]));  //수량 = 처방량 * od_chubcnt				
				$cntvalue=round(floatval($totalvalue)*floatval($medicode[3]));   //합계금액 = 수량 * 단가				
				$value=round($cntvalue/1.1);
				$taxvalue=round($cntvalue-$value);			
		
				$addarray=array(
					"od_chubcnt"=>$dt["od_chubcnt"], 
					"rcSeq"=>$dt["rc_seq"], 
					"rcCode"=>$dt["rc_code"], 
					"rcUserid"=>$dt["rc_userid"], 
					"rcTitle"=>$dt["rcTitle"],
					"rcMedicine"=>$dt["rc_medicine"], 
					"medivalue"=>$medivalue, //약재이름
					"totalvalue"=>$totalvalue, //수량
					"medicode"=>$medicode[3], //단가
					"value"=>$value, //공급가액
					"taxvalue"=>$taxvalue, //세액
					"cntvalue"=>$cntvalue, //합계금액				
					"miName"=>$dt["mi_name"], //한의원명
					"maEnd"=>viewdate($dt["ma_end"]), //조제일
					"odName"=>$dt["od_name"]
					);

				array_push($json["list"], $addarray);
			}
		}
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

		//약재코드로 약재명(medicine_djmedi)조회
		function getname($medicode)
		{
			global $dbH;
			$medivalue="";
			if($medicode)
			{				
				$sql=" select mm_title_kor mmTitleName from ".$dbH."_medicine_djmedi where md_code= '".$medicode."' ";
				$res=dbqry($sql);	
				
				while($hub=dbarr($res))
				{					
					$medivalue.=$hub["mmTitleName"];
				}				
			}
			return $medivalue;		
		}
?>