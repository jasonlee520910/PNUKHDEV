<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	
	$stat=$_GET["stat"];
	$code=$_GET["code"];
	$returnData=$_GET["returnData"];
	$od_code=$_GET["odCode"];
	
	if($apiCode!="pharmacydesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="pharmacydesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($od_code==""){$json["resultMessage"]="API(odCode) ERROR";}
	else
	{
		$sql=" select 
					a.od_code, a.od_title, a.od_chubcnt, a.od_name, a.od_status, a.od_matype 
					, b.ma_medibox_infirst, b.ma_medibox_inmain, b.ma_medibox_inafter, b.ma_medibox_inlast, b.ma_status  
					, c.rc_medicine as RCMEDICINE
					, c.rc_sweet as RCSWEET 
					from ".$dbH."_order a 
					inner join ".$dbH."_making b on a.od_code=b.ma_odcode 
					inner join ".$dbH."_recipeuser c on a.od_scription=c.rc_code 
					where a.od_code='".$od_code."'";
		$dt=dbone($sql);

		if($dt["OD_STATUS"]=="making_apply")
		{
			//주문번호 태그시 ma_start update
			$sql ="update ".$dbH."_making set ma_start=sysdate where ma_odcode = '".$od_code."'";
			dbcommit($sql);

			//조제태그	
			$tagInfo=array();
			$pouchtag=array();
			$rcmedicine=getClob($dt["RCMEDICINE"]).getClob($dt["RCSWEET"]);
			$rcarr=explode("|",$rcmedicine);
			foreach($rcarr as $val){
				$rcarr2=explode(",",$val);
				if($rcarr2[2]){
					switch($rcarr2[2]){
						case "infirst":$addarr=array("code"=>$rcarr2[2], "name"=>"선전");break;
						case "inmain":$addarr=array("code"=>$rcarr2[2], "name"=>"일반");break;
						case "inafter":$addarr=array("code"=>$rcarr2[2], "name"=>"후히");break;
						case "inlast":$addarr=array("code"=>$rcarr2[2], "name"=>"별전");break;
					}
					array_push($pouchtag,$addarr);
				}
			}
			$pouchtag=array_unique($pouchtag);
			$json["rcMedicine"] = $rcarr;
			$json["pouchTag"] = $pouchtag;

			//약미 
			$rc_medicine=explode("|",$rcmedicine);
			$mediCount=count($rc_medicine) - 1;
			//약재총무게 
			$mediunit=0;
			foreach($rc_medicine as $val){
				$marr=explode(",",$val);
				$mediunit=$mediunit + $marr[1];
			}
			$json["mediunit"] = $mediunit;
			$mediCapa = floatval($mediunit) * floatval($dt["OD_CHUBCNT"]);

			$odinfo=array(
				"odCode"=>$dt["OD_CODE"], 
				"odTitle"=>$dt["OD_TITLE"], 
				"odName"=>$dt["OD_NAME"], 
				"odMatype"=>$dt["OD_MATYPE"],
				"maStatus"=>$dt["MA_STATUS"],
				"rcMedicine"=>$rcmedicine,
				"mediCapa"=>$mediCapa, 
				"mediCount"=>$mediCount, 
				"tagInfo"=>$tagInfo
				);

			$json["apiCode"] = $apiCode;
			$json["odinfo"] = $odinfo;
			$json["sql"] = $sql;
			$json["returnData"] = $returnData;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}else{
			$json["apiCode"] = $apiCode;
			$json["sql"] = $sql;
			$json["returnData"] = $returnData;
			$json["resultCode"]="204";
			$json["resultMessage"]="조제대기중인 작업만 가능합니다. ";
		}
	}
?>