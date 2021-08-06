<?php  
	/// 제품재고관리 > 제품목록 > 제품목록리스트 > 반제품일경우 재고추가 > 등록&수정버튼
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	$st_userid=$_POST["stUserid"];  //staffid
	$gd_type=$_POST["gdType"];
	$gd_code=$_POST["gdCode"];
	$doneqty=$_POST["doneqty"];  //반제품의 완성량

	if($apicode!="pregoodsupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="pregoodsupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	//else if($st_userid==""){$json["resultMessage"]="API(stUserid) ERROR";}
	else if($gd_type==""){$json["resultMessage"]="API(gdType) ERROR";}
	else if($gd_code==""){$json["resultMessage"]="API(gdCode) ERROR";}
	else if($doneqty==""){$json["resultMessage"]="API(doneqty) ERROR";}
	else
	{
		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$gd_name=$_POST["gdName"];  //main 제품
		$typeWork=$_POST["typeWork"];  //main 제품의 생산/폐기
		$doneqty=$_POST["doneqty"];  //main 제품의 생산량
		$bomData=$_POST["bomdata"];  //구성품

		if($typeWork=="minus"){
			$gh_type="disposal";
			$doneqty = $doneqty * (-1);
			$gd_desc=$gd_name." - 폐기(".$doneqty.")";
		}else{
			$gh_type="produce";
			$gd_desc=$gd_name." - 생산(".$doneqty.")";
		}
		//main 제품 재고처리
		$jdata=goodsproc("main",$gh_type,$gd_type,$gd_code,$doneqty,$gd_desc);
	$json["jdata"][$gd_code]="main".$gh_type."_".$gd_type."_".$gd_code."_".$doneqty."_".$qty."_".$tot."_".$loss."_".$losscapa."_".$useqty."_".$gd_desc;

		//생산인경우만 구성요소 차감
		if($gh_type=="produce"){
			//구성요소 재고차감
			foreach($bomData as $val){
				$gd_type=$val[1];
				$gd_code=$val[0];
				$useqty=$val[2];
				//재고업데이트, 로그저장
				$jdata=goodsproc("sub","use",$gd_type,$gd_code,$useqty,$gd_desc);
$json["jdata"][$gd_code]="sub_use_".$gd_type."_".$gd_code."_".$doneqty."_".$qty."_".$tot."_".$loss."_".$losscapa."_".$useqty."_".$gd_desc;
			}
		}

		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		$json["sql"]=$sql;
		$json["tdata"]=$tdata;
	}
?>