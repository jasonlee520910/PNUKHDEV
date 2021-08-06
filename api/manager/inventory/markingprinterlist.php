<?php  
	/// 자재코드관리 > 마킹프린터관리 > 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];

	if($apiCode!="markingprinterlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="markingprinterlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		$searchtxt=$_GET["searchTxt"];  //검색단어
	
		$wsql=" where mp_use='Y' ";

		if($searchtxt)
		{
			$wsql.=" and ( ";
			$wsql.=" mp_code like '%".$searchtxt."%' ";///프린터코드
			$wsql.=" or ";
			$wsql.=" mp_title like '%".$searchtxt."%' ";///프린터이름
			$wsql.=" or ";
			$wsql.=" mp_ip like '%".$searchtxt."%' ";///프린터아이피
			$wsql.=" or ";
			$wsql.=" mp_port like '%".$searchtxt."%' ";///프린터포트
			$wsql.=" or ";
			$wsql.=" mp_odcode like '%".$searchtxt."%' ";///진행중주문코드
			$wsql.=" ) ";
		}

		$pg=apipaging("mp_date","markingprinter","",$wsql);
		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY mp_date) NUM ";		
		$sql.=" ,mp_seq,mp_code,mp_title,mp_ip,mp_port,mp_odcode,mp_staff,mp_status,mp_use ";
		$sql.=" ,to_char(mp_starttime,'yyyy-mm-dd hh24:mi:ss') as MP_STARTTIME ";
		$sql.=" ,to_char(mp_finishtime,'yyyy-mm-dd hh24:mi:ss') as MP_FINISHTIME ";
		$sql.=" ,to_char(mp_date,'yyyy-mm-dd') as MP_DATE ";
		$sql.=" from ".$dbH."_markingprinter $wsql  ";
		$sql.=" order by mp_date ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

///echo $sql;
		$res=dbqry($sql);
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			if($dt["MP_STARTTIME"]){$MP_STARTTIME=$dt["MP_STARTTIME"];}else{$MP_STARTTIME="-";}
			if($dt["MP_FINISHTIME"]){$MP_FINISHTIME=$dt["MP_FINISHTIME"];}else{$MP_FINISHTIME="-";}
			if($dt["MP_ODCODE"]){$MP_ODCODE=$dt["MP_ODCODE"];}else{$MP_ODCODE="-";}
			if($dt["MP_STAFF"]){$MP_STAFF=$dt["MP_STAFF"];}else{$MP_STAFF="-";}

			$addarray=array(
				"mpSeq"=>$dt["MP_SEQ"],  
				"mpCode"=>$dt["MP_CODE"],  
				"mpTitle"=>$dt["MP_TITLE"], 
				"mpIp"=>$dt["MP_IP"], 
				"mpPort"=>$dt["MP_PORT"], 
				"mpOdcode"=>$MP_ODCODE, 
				"mpStarttime"=>$MP_STARTTIME, 
				"mpFinishtime"=>$MP_FINISHTIME, 
				"mpStaff"=>$MP_STAFF, 
				"mpStatus"=>$dt["MP_STATUS"], 
				"mpUse"=>$dt["MP_USE"],
				"mpDate"=>$dt["MP_DATE"]
				);
			array_push($json["list"], $addarray);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>