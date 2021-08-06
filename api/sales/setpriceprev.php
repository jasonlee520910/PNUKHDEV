<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$spStaffid=$_GET["spStaffid"];
	if($apicode!="setpriceprev"){$json["resultMessage"]="API코드오류";$apicode="setpriceprev";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($spStaffid==""){$json["resultMessage"]="userid 없음";}
	else{
		$returnData=$_GET["returnData"];
		$sql=" select * from ".$dbH."_staff a left join ".$dbH."_salesprice b on a.st_staffid=b.sp_staffid and b.sp_use='U' where a.st_staffid='".$spStaffid."' ";
		$dt=dbone($sql);
		$discount=$dt["st_discount"];
		if($dt["sp_data"]){
			$sp_data=$dt["sp_data"];
			$spData=array();
			$jsData=json_decode($sp_data,true);
			foreach($jsData as $val){
				$addarray=array(
					"code"=>$val[0]
					,"mate"=>$val[1]
					,"unit"=>$val[2]
					,"margin"=>$val[3]
					,"price"=>$val[4]);
				array_push($spData,$addarray);
			}
			$spData=json_encode($spData);
		}else{
			$sql=" select sp_data from ".$dbH."_salesprice where sp_use='Y' and sp_staffid = (select st_company from ".$dbH."_staff where st_staffid='".$spStaffid."') ";
			$dt=dbone($sql);
			$sp_data=$dt["sp_data"];
			$spData=array();
			$jsData=json_decode($sp_data,true);
			foreach($jsData as $val){
				$estiunit=intval($val[4]) * (1 - ($discount / 100));
				$price=$estiunit * (1 + (10 / 100));
				//$addarray=array($val[0],$val[1],$estiunit,0,$price);
				$addarray=array($val[0],$val[1],$estiunit,10,$price);
				array_push($spData,$addarray);
			}
			$spData=json_encode($spData);


		}

		$json=array("seq"=>$dt["sp_seq"], "stStaffid"=>$dt["st_staffid"], "stDiscount"=>$dt["st_discount"], "jsonData"=>$spData);
		$json["sql"]=$sql;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
