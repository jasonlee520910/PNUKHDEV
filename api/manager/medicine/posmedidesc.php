<?php  
	///약재관리 > 독성알람 > 독성알람 상세 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	//$page=$_GET["page"];
	$po_seq=$_GET["seq"];


	if($apiCode!="posmedidesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="posmedidesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	///else if($po_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apiCode,"returnData"=>$returnData);

		if(isset($po_seq) && $po_seq != '') ///클릭하면 상세 출력
		{
			$sql=" select ";
			$sql.=" a.po_seq,a.po_code,a.po_group,a.po_patient,a.po_usage_kor,a.po_usage_chn,a.po_uselimit,a.po_medicine";
			$sql.=",to_char(a.po_desc_kor) as podesckor,to_char(a.po_desc_chn) as podescchn,to_char(b.mh_title_kor) as mhTitle,a.po_date ";
			$sql.=" from ".$dbH."_medi_poison a left join ".$dbH."_medihub b on a.po_medicine=b.mh_code where a.po_seq='".$po_seq."' ";
			$dt=dbone($sql);		

			$json=array(
				"seq"=>$dt["PO_SEQ"], 
				"poCode"=>$dt["PO_CODE"], 
				"poGroup"=>$dt["PO_GROUP"], 
				"poPatient"=>$dt["PO_PATIENT"], 
				"poMedicine"=>$dt["PO_MEDICINE"], 
				"mhTitle"=>$dt["MHTITLE"],

				"poUsageKor"=>$dt["PO_USAGE_KOR"], 
				"poUsageChn"=>$dt["PO_USAGE_CHN"], 

				"poUselimit"=>$dt["PO_USELIMIT"], 

				"poDescKor"=>$dt["PODESCKOR"], 
				"poDescChn"=>$dt["PODESCCHN"], 
				
				"poDate"=>$dt["PO_DATE"]);
		}

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>

