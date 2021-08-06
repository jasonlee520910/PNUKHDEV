<?php //(TMPS 추천처방 상세) - > 안쓰는 페이지
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$rc_seq=$_GET["seq"];

	if($apiCode!="uniquescdesc"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="uniquescdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		//------------------------------------------------------------
		// DOO :: Code 테이블 목록 보여주기 위한 쿼리 추가 
		//------------------------------------------------------------
		//$hCodeList = getNewCodeTitle("rcTingue,rcPulse");
		//------------------------------------------------------------
		//$tingueList = getCodeList($hCodeList, 'rcTingue');//설진단리스트 
		//$pulseList = getCodeList($hCodeList, 'rcPulse');//맥상리스트 
		//$rcStatusList = getCodeList($hCodeList, 'rcStatus');//승인  
		//$dcTypeList = getDecoCodeTitle();//탕전타입   

		if($rc_seq)
		{
			$sql=" select a.rc_seq rcSeq, a.rc_code rcCode, a.rc_source rcSource, a.rc_title_kor rcTitlekor, a.rc_title_chn rcTitlechn,  a.rc_detail_".$language." rcDetail, a.rc_medicine rcMedicine, a.rc_sweet rcSweet, a.rc_chub rcChub, a.rc_efficacy_".$language." rcEfficacy, a.rc_maincure_".$language." rcMaincure,   a.rc_desc_".$language." rcDesc, a.rc_status rcStatus, a.rc_date rcDate ";
			$sql.=" from ".$dbH."_recipemember a  where a.rc_seq='".$rc_seq."'";
//echo $sql;
			$dt=dbone($sql);

			if($dt["RC_SEQ"]){
				$sourceTxt=$dt["RBSOURCETXT"];
				$sourceIndex=$dt["RBINDEX"];
			}else{
				$sourceTxt=$dt["RCSOURCE"];
				$sourceIndex=$dt["RCSOURCETIT"];
			}

			$medicine=array();
			//------------------------------------------------------------
			// DOO :: 약재정보 이름으로 보여지기 위한 쿼리 추가 
			//------------------------------------------------------------
			$rcMedicine = getClob($dt["RCMEDICINE"]);//substr($dt["rcMedicine"], 1); //한자리만 자르기 
			$rcMedicine = str_replace(" ", "", $rcMedicine);//빈공간있으면 일단은 삭제
		///|PM桂枝,20錢/6g/|PM甘草炙,10錢/3g/|PM麻黃去節,30錢/9g/|PM杏仁去皮尖,70個/9g/
			$arr=explode("|PM",$rcMedicine);
			for($i=1;$i<count($arr);$i++)
			{
				$arr2=explode(",",$arr[$i]);
				$arr3=explode("/",$arr2[1]);
				$addarray = array(
				"title"=>$arr2[0],
				"value"=>$arr3[0],
				"capa"=>$arr3[1]		
				);
				array_push($medicine, $addarray);
			}

			//$rcMedicineList = getMedicine($rcMedicine);
			//------------------------------------------------------------

			if($dt["RCCHUB"]) {$rcChub = $dt["RCCHUB"];}else{$rcChub="1";}
			
			$json = array(
				"seq"=>$dt["RC_SEQ"],

				"rcTitlekor"=>$dt["RCTITLEKOR"]." / ".$dt["RCTITLECHN"],
				"rcSource"=>$dt["RCSOURCE"],//출전
				"rcType"=>"탕전",//제형
				"rcMedicine"=>$medicine,//약재
				"rcEfficacy"=>getClob($dt["RCEFFICACY"]),//효능


				"arr0"=>$arr[0],//출전
				"arr1"=>$arr[1],//출전

				"arr2"=>$arr[2],//출전

				"arr3"=>$arr[3],//출전




				"rcDate"=>$dt["rcDate"]
				);
		}

		$json["search"]=$search;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>