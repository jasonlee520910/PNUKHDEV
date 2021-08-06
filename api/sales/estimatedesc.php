<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$esStaffid=$_GET["esStaffid"];
	if($apicode!="estimatedesc"){$json["resultMessage"]="API코드오류";$apicode="estimatedesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	//else if($esType==""){$json["resultMessage"]="type 없음";}
	//else if($esCode==""){$json["resultMessage"]="code 없음";}
	else if($esStaffid==""){$json["resultMessage"]="Staffid 없음";}
	else{
		$esType=$_GET["esType"];
		$esCode=$_GET["esCode"];
		$returnData=$_GET["returnData"];

		//분류정보
		$sql=" select sc_code, sc_title_".$language." sc_title from ".$dbH."_salescategory where sc_use='Y' ";
		$res=dbqry($sql);
		while($dt=dbarr($res)){
			$item[$dt["sc_code"]]=$dt["sc_title"];
		}
		//설정된 가격구하기
		$sql=" select sp_data from ".$dbH."_salesprice where sp_use='Y' and sp_staffid='".$esStaffid."'";
		$sqlall.=$sql;
		$dt2=dbone($sql);
		$TmpData=json_decode($dt2["sp_data"],true);
		foreach($TmpData as $val){
			//현재가격표의 가격정보
			${"unit_".$val["code"]}=$val["price"];
		}

		$sql=" select a.st_userid stuserid, a.st_name stname, b.st_name company from ".$dbH."_staff a inner join ".$dbH."_staff b on a.st_company=b.st_staffid where a.st_staffid='".$esStaffid."' ";
		$staff=dbone($sql);
		$sqlall.=$sql;
		$stName=$dtaff["stname"];
		$stCompany=$dtaff["company"];
		if($esType!="" && $esCode!="" && $esCode!="add"){
			$sql=" select * from ".$dbH."_estimate where es_code='".$esCode."' ";
			if($esType=="basic"){
				$sql.=" and es_type = '".$esType."' and es_use in ('Y','U') ";
			}else{
				$sql.=" and es_use = 'Y' ";
			}
			$sqlall.=$sql;
			$dt=dbone($sql);
			$es_type=$dt["es_type"];
			$es_data=$dt["es_data"];
			$es_code=$dt["es_code"];
			$esTitle=$dt["es_title"];
			$esAmount=$dt["es_amount"];
			$es_use=$dt["es_use"];
			// 견적 작성 시 기본견적서를 가져온 경우
			if($esType=="customer" && $es_type=="basic"){
				$esCode="";
				$esTitle="";
				$esAmount=0;

				//기본견적서에서 금액 변경
				$esData=array();
				$jsData=json_decode($es_data,true);
				foreach($jsData as $val){
					//기본견적서 정보 
					$group=$val["group"];
					$code=$val["code"];
					
					//$title=$val["title"];
					$title=$item[$val["title"]];
					
					//기본가격변경
					$unit=${"unit_".$val["code"]};
					$qty=$val["qty"];
					$price=$unit * $qty;
					$esAmount=$esAmount + $price;
					$addarray=array("group"=>$group,"code"=>$code,"title"=>$title,"unit"=>$unit,"qty"=>$qty,"price"=>$price);
					array_push($esData,$addarray);
				}
				$esData=json_encode($esData);
			}else{
				// 저장된견적서를 가져온 경우
				$esData=array();
				$es_data=$dt["es_data"];
				$jsData=json_decode($es_data,true);
				// 금액 업데이트가 있는경우
				if($es_use=="U"){
					foreach($jsData as $val){
						//기본견적서 정보 
						$group=$val["group"];
						$code=$val["code"];
						//$title=$val["title"];
						$title=$item[$val["code"]];
						$unit=${"unit_".$val["code"]};
						$qty=$val["qty"];
						$price=$unit * $qty;
						$esAmount=$esAmount + $price;
						$addarray=array("group"=>$group,"code"=>$code,"title"=>$title,"unit"=>$unit,"qty"=>$qty,"price"=>$price);
						array_push($esData,$addarray);
					}
				}else{
					// 그대로 리턴
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
				}
				$esData=json_encode($esData);

			}
		}else{
			//신규기본견적인 경우 설정된 가격표 조회
			//설정된 가격구하기
			$sql=" select sp_data from ".$dbH."_salesprice where sp_use='Y' and sp_staffid='".$esStaffid."'";
			$sqlall.=$sql;
			$dt=dbone($sql);
			$sp_data=$dt["sp_data"];
			$esData=array();
			$jsData=json_decode($dt["sp_data"],true);
			foreach($jsData as $val){
				$group=$val["group"];
				$code=$val["code"];
				//$title=$val["title"];
				$title=$item[$val["code"]];
				$unit=$val["unit"];
				$margin=$val["margin"];
				$price=$unit * 1;
				$esAmount=$esAmount + $price;
				$addarray=array("group"=>$group,"code"=>$code,"title"=>$title,"unit"=>$unit,"qty"=>1,"price"=>$price);
				array_push($esData,$addarray);
			}
			$esData=json_encode($esData);
		}

		if($dt["es_modify"]){$esDate=$dt["es_modify"];}else{$esDate=$dt["es_date"];}
		$json=array("esCode"=>$esCode, "esCustomer"=>$dt["es_customer"], "esStaffid"=>$esStaffid, "stCompany"=>$stCompany, "stName"=>$stName, "esTitle"=>$esTitle, "esAmount"=>$esAmount, "jsonData"=>$esData, "esUse"=>$dt["es_use"], "esConfirm"=>$dt["es_confirm"], "esDate"=>$eSdate);
		$json["sql"]=$sqlall;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>