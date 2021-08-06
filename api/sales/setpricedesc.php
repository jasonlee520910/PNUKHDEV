<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$spStaffid=$_GET["spStaffid"];
	if($apicode!="setpricedesc"){$json["resultMessage"]="API코드오류";$apicode="setpricedesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else if($spStaffid==""){$json["resultMessage"]="userid 없음";}
	else{
		$returnData=$_GET["returnData"];
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;

		//분류정보
		$sql=" select sc_code, sc_title_".$language." sc_title from ".$dbH."_salescategory where sc_use='Y' ";
		$res=dbqry($sql);
		while($dt=dbarr($res)){
			$item[$dt["sc_code"]]=$dt["sc_title"];
		}

		//가격정보 초기화
		$sp_data=$spData="";
		// 사용중인 데이터 조회
		$sql=" select sp_data from ".$dbH."_salesprice where sp_use='Y' and sp_staffid = '".$spStaffid."' ";
		$dt=dbone($sql);
		// 사용중인 데이터가 있는경우
		if($dt["sp_data"]){
			$sp_data=$dt["sp_data"];
			$spData=array();
			$jsData=json_decode($sp_data,true);
			foreach($jsData as $val){
				$title=$item[$val["code"]];
				$addarray=array("group"=>$val["group"],"code"=>$val["code"],"title"=>$title,"unit"=>$val["unit"],"margin"=>$val["margin"],"price"=>$val["price"]);
				array_push($spData,$addarray);
			}
			$spData=json_encode($spData);
		}else{
			// 사용중인 데이터가 없는경우
			//마진정보 추출
			$sql=" select st_margin from ".$dbH."_staff where st_staffid='".$spStaffid."' ";
			$dt=dbone($sql);
			$stMargin=$dt["st_margin"];

			// 직전 가격정보 조회
			$sql=" select sp_data from ".$dbH."_salesprice where sp_use='U' and sp_staffid = '".$spStaffid."' ";
			$dt=dbone($sql);
			// 직전 가격정보가 있으면 마진 추출
			if($dt["sp_data"]){
				$sp_data=$dt["sp_data"];
				$jsData=json_decode($sp_data,true);
				foreach($jsData as $val){
					//${"group_".$val["code"]}=$val["group"];
					//${"code_".$val["code"]}=$val["code"];
					//${"title_".$val["code"]}=$val["group"];
					//${"unit_".$val["code"]}=$val["unit"];
					${"margin_".$val["code"]}=$val["margin"];
					//${"price_".$val["code"]}=$val["price"];
				}
			}
			//가격정보 초기화
			$sp_data=$upspData="";
			// 상위업체 가격정보 추출
			$sql=" select sp_data from ".$dbH."_salesprice where sp_use='Y' and sp_staffid = (select st_company from ".$dbH."_staff where st_staffid='".$spStaffid."') ";
			$dt=dbone($sql);
			// 상위업체 가격정보 있으면 추출
			if($dt["sp_data"]){
				$sp_data=$dt["sp_data"];
				$upspData=json_decode($sp_data,true);
			}

			$spData=array();
			//상위업체 가격정보 있으면
			if(is_array($upspData)){
				foreach($upspData as $val){
					$group=$val["group"];
					$code=$val["code"];
					$title=$item[$code];
					//상위업체 price 를 unit 로
					$unit=$val["price"];
					if(${"margin_".$code}){
						//직전 가격정보code별 마진이 있는경우
						$margin=${"margin_".$code};
					}else{
						//직전 가격정보code별 마진이 없는경우
						$margin=$stMargin;
					}
					//가격재설정
					$price=$unit * (100 + $margin) / 100;
					$addarray=array("group"=>$group,"code"=>$code,"title"=>$title,"unit"=>$unit,"margin"=>$margin,"price"=>$price);
					array_push($spData,$addarray);
				}
			}else{
				// 상위업체 가격정보 없는경우
				//본사영업관리인 경우 만 해당
				if($spStaffid=="MEM20180205182511"){
					//현재 가격 리스트 추출 직전데이터
					$sql=" select a.*, sc_title_".$language." sc_title from ".$dbH."_salescategory a where a.sc_use='Y' order by field(sc_group, 'sw','sp','eq','op'), sc_code ";
					$res=dbqry($sql);
					$spData=array();
					while($dt=dbarr($res)){
						//현재가격정보에 직전 정보가 있는경우
						if($dt["sc_code"]==${"code_".$dt["sc_code"]}){
							$unit=${"unit_".$dt["sc_code"]};
							$margin=${"margin_".$dt["sc_code"]};
						}else{
							//신규등록된 가격정보
							$unit=$dt["sc_unit"];
							$margin=$stMargin;
						}
						$price=$unit * (100 + $margin) / 100;
						$addarray=array("group"=>$dt["sc_group"],"code"=>$dt["sc_code"],"title"=>$dt["sc_title"],"unit"=>$unit,"margin"=>$margin,"price"=>$price);
						array_push($spData,$addarray);
					}
				}else{
				//본사영업관리가 아닌 경우
				}
			}

			$spData=my_json_encode($spData);
			//데이터 있는경우 디비업데이트
			if($spData!="[]"){
				$sql=" update ".$dbH."_salesprice set sp_use='D' where sp_staffid='".$spStaffid."'";
				dbqry($sql);
				$sql=" insert into ".$dbH."_salesprice (sp_staffid, sp_data, sp_use, sp_date) values('".$spStaffid."', '".$spData."', 'Y', now())  ";
				dbqry($sql);
			}
		}
		$json=array("seq"=>$dt["sp_seq"], "stStaffid"=>$dt["st_staffid"], "stDiscount"=>$dt["st_discount"], "jsonData"=>$spData);
		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
