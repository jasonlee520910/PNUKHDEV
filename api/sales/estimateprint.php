<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$esCode=$_GET["esCode"];
	if($apicode!="estimateprint"){$json["resultMessage"]="API코드오류";$apicode="estimateprint";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	//else if($esType==""){$json["resultMessage"]="type 없음";}
	else if($esCode==""){$json["resultMessage"]="code 없음";}
	else{
		$esType=$_GET["esType"];
		$returnData=$_GET["returnData"];

		//분류정보
		$sql=" select sc_code, sc_title_".$language." sc_title from ".$dbH."_salescategory where sc_use='Y' ";
		$res=dbqry($sql);
		while($dt=dbarr($res)){
			$item[$dt["sc_code"]]=$dt["sc_title"];
		}

		$sql=" select a.*, b.*, s.st_name stName, s.st_mobile stMobile, s1.st_name company from ".$dbH."_estimate a 
				inner join ".$dbH."_customer b on a.es_staffid=b.cs_company and a.es_customer=b.cs_seq 
				inner join ".$dbH."_staff s on a.es_staffid=s.st_staffid  
				inner join ".$dbH."_staff s1 on s.st_company=s1.st_staffid  
					where a.es_code='".$esCode."' ";
		$dt=dbone($sql);
		$sqlall.=$sql;
		$esData=array();
		$es_data=$dt["es_data"];
		$jsData=json_decode($es_data,true);
		foreach($jsData as $val){
			//기본견적서 정보 
			$group=$val["group"];
			$code=$val["code"];
			//$title=$val["title"];
			$title=$item[$val["code"]];
			$unit=$val["unit"];
			$qty=$val["qty"];
			$price=$val["price"];
			$esAmount=$esAmount + $price;
			$addarray=array("group"=>$group,"code"=>$code,"title"=>$title,"unit"=>$unit,"qty"=>$qty,"price"=>$price);
			array_push($esData,$addarray);
		}
		$esData=json_encode($esData);
		if($dt["es_modify"]){$esDate=$dt["es_modify"];}else{$esDate=$dt["es_date"];}
		$json=array("esCode"=>$esCode, "esCustomer"=>$dt["cs_name"], "esStaffid"=>$esStaffid, "stCompany"=>$dt["company"], "stName"=>$dt["stName"], "stMobile"=>$dt["stMobile"], "esTitle"=>$dt["es_title"], "esAmount"=>$esAmount, "jsonData"=>$esData, "esUse"=>$dt["es_use"], "esDate"=>$esDate);
		$json["sql"]=$sqlall;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>