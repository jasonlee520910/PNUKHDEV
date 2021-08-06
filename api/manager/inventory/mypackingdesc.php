<?php  
	///사용자관리 > 한의원관리 상세보기 > 포장재관리 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$userid=$_GET["userid"];  
	if($apiCode!="mypackingdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="mypackingdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	///else if($pb_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$hCodeList = getNewCodeTitle('pbType');
		$pbTypeList = getCodeList($hCodeList, 'pbType');///포장재분류  

		$sql=" select  ";
		$sql.=" a.pb_price, a.pb_staff, a.pb_capa, a.pb_member, a.pb_seq, a.pb_code, a.pb_type, a.pb_title, a.pb_member, a.pb_date,to_char(a.pb_desc) as pbdesc";
		$sql.=" , b.mi_name, f.af_seq,f.af_url as afUrl ";
		$sql.=" , (select cd_name_kor from han_code where cd_type='pbType' and cd_code = a.pb_type) as pbTypeName  ";
		$sql.=" from ".$dbH."_packingbox";
		$sql.=" a left join ".$dbH."_medical b on a.pb_member=b.mi_userid  ";
		$sql.=" left join ".$dbH."_file f on a.pb_code=f.af_fcode and f.af_code='packingbox' and f.af_use='Y' ";
		$sql.=" where a.pb_use='Y' and pb_member like '%".$userid."%'  "; 
		$sql.=" group by a.pb_price, a.pb_staff, a.pb_capa, a.pb_member, a.pb_seq, a.pb_code, a.pb_type, a.pb_title, a.pb_member, a.pb_date,to_char(a.pb_desc)";
		$sql.=" , b.mi_name, f.af_seq,f.af_url";	
		$sql.=" order by a.pb_code desc ";

		$res=dbqry($sql);
	
		$json["pklist"] = array();

		while($dt=dbarr($res))
		{
			$afFile=getafFile($dt["AFURL"]);
			$afThumbUrl=getafThumbUrl($dt["AFURL"]);

			$addarray=array(
				"pb_price"=>$dt["PB_PRICE"], 
				"pb_desc"=>$dt["PB_DESC"], 
				"pb_staff"=>$dt["PB_STAFF"], 
				"pb_capa"=>$dt["PB_CAPA"], 
				"pb_member"=>$dt["PB_MEMBER"], 
			
				"pb_seq"=>$dt["PB_SEQ"], 
				"pb_code"=>$dt["PB_CODE"], 
				"pb_type"=>$dt["PB_TYPE"], 
				"pb_title"=>$dt["PB_TITLE"], 
				
				"pb_date"=>$dt["PB_DATE"],
				"mi_name"=>$dt["MI_NAME"], 
				"pbTypeName"=>$dt["PBTYPENAME"],
				
				"af_seq"=>$dt["AF_SEQ"],
				"afThumbUrl"=>$afThumbUrl,
				"afFile"=>$afFile
			);
			array_push($json["pklist"], $addarray);
		}

		$json["pbTypeList"] = $pbTypeList;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>