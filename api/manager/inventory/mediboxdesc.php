<?php  
	/// 재고관리 > 약재출고 > 약재출고시 약재바토드 스캔 란에 약재함 바코드를 읽었을경우
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$mb_seq=$_GET["seq"];
	$mb_code=$_GET["code"];
	if($apicode!="mediboxdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="mediboxdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		
		$mbTableList = getmaTableList();//조제테이블리스트

		$jsql=" a left join ".$dbH."_medicine b on a.mb_medicine=b.md_code  ";
		$jsql.=" left join ".$dbH."_makingtable c on a.mb_table=c.mt_code  ";
		//----------------------------------------------------------------------
		//세명대 약재명을 가져오기 위함
		if($refer)
			$jsql.=" inner join ".$dbH."_medicine_".$refer." r on b.md_code=r.md_code  ";
		//----------------------------------------------------------------------
		if($mb_code){
			$wsql=" where mb_code = '".$mb_code."' ";
		}else{
			$wsql=" where mb_seq = '".$mb_seq."' ";
		}
		$sql=" select a.*, b.md_title_".$language." mdTitle, b.md_origin_".$language." mdOrigin, c.mt_title ";
		//----------------------------------------------------------------------
		if($refer)
			$sql.=" , r.mm_title_".$language." mmTitle, r.mm_code ";
		//----------------------------------------------------------------------
		$sql.=" from ".$dbH."_medibox $jsql $wsql ";
		$dt=dbone($sql);

		//----------------------------------------------------------------------
		$mdTitle = ($refer) ? $dt["MMTITLE"] : $dt["MDTITLE"];//약재명
		$mbMedicine = ($refer) ? $dt["MD_CODE"] : $dt["MB_MEDICINE"];//약재코드 
		//----------------------------------------------------------------------

		$json=array(
			"seq"=>$dt["MB_SEQ"], 
			"mbCapacity"=>$dt["MB_CAPACITY"], 			
			"mbTable"=>$dt["MB_TABLE"], 
			"mbCode"=>$dt["MB_CODE"], 
			"mbDate"=>$dt["MB_DATE"], 
			"mdTitle"=>$mdTitle,//약재명
			"mbMedicine"=>$mbMedicine, //약재코드
			"mdOrigin"=>$dt["MDORIGIN"], //원산지 
			"mtTitle"=>$dt["MT_TITLE"] 
			);

		$json["mbTableList"]=$mbTableList;//조제테이블리스트 
		$json["apiCode"]=$apicode;
		$json["mb_code"]=$mb_code;//GET으로 넘겨받은 code 값을 다시 보내준다 		
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>