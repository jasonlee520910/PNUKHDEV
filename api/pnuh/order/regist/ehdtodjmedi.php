<?php
	$BASE_DCTIME=80;
	$re_box=0;
	//감미제 
	$dc_sugar="HD99999_01";//감미제없음 
	//살균
	$dc_sterilized="N";
	//냉각 
	$dc_cooling="N";
	//중탕 
	$dc_jungtang="N";
	//숙성
	$dc_ripen="0";//숙성안함 

	//제환관련 
	$dc_shape=""; //제형 
	$dc_binders=""; //결합제
	$dc_fineness=""; //분말도 
	$dc_millingloss="0"; //제분손실
	$dc_lossjewan="0"; //제환손실
	$dc_bindersliang="0"; //결합제
	$dc_completeliang="0"; //완성량
	$dc_completecnt="0"; //완성갯수 
	$dc_dry="0";//건조시간 

	//--------------------------------------------------------------
	///공통으로 쓰이는 데이터들 (가격)
	//--------------------------------------------------------------
	$config=setConfigPrice();
	//--------------------------------------------------------------


	//--------------------------------------------------------------
	//한의원
	//--------------------------------------------------------------
	$medical=getMedicalDoctorInfo($medicalCode, $doctorCode, $medicalName, $doctorName);
	$me_company=$medical["meCompany"];//한의원ID
	$me_userid=$medical["meUserid"];//한의사ID
	$mi_grade=$medical["miGrade"];//한의원등급 
	$mi_name=$medical["miName"];//한의원이름
	//--------------------------------------------------------------
	
	//------------------------------------------
	//조제비,탕전비,배송비,포장비,선전비,후하비,첩약배송비 
	//------------------------------------------
	$ma_price=getConfigPrice("making", $mi_grade);//조제비 
	$dc_price=getConfigPrice("decoction", $mi_grade);//탕전비
	$re_price=getConfigPrice("release", $mi_grade);//배송비 
	$packPrice=getConfigPrice("packing", $mi_grade);//포장비 
	$firstPrice=getConfigPrice("first", $mi_grade);//선전비
	$afterPrice=getConfigPrice("after", $mi_grade);//후하비  
	$cheobPrice=getConfigPrice("cheob", $mi_grade);//첩약배송비   		
	//------------------------------------------
	$json["medical"]=$medical;

	$od_code="ODD".$keyCode; //order odcode 
	$od_keycode=$keyCode; //order keycode
	$rc_code="RC".$keyCode;//recipeuser code 
	$rc_source="";//출처 

	$od_userid=$me_company;//한의원ID
	$od_staff=$me_userid;//한의사ID

	$od_sitecategory="PNUH";//부산대API:PNUH, medical:MEDICAL


		/////

		//주문일 
		//$orderDate

		//배송희망일 
		$nowDate=date("Y-m-d");
		$re_delidate=($deliveryDate) ? $deliveryDate : $nowDate;
		if($re_delidate=="0000-00-00")
		{
			$re_delidate=$nowDate;
		}
		$re_delidate=date("Y-m-d", strtotime($re_delidate));

		

		//처방명 
		$od_title=$orderTitle;


		//조제타입에 따른 
		$od_matype="decoction";
		$od_goods="N";
		if($orderTypeCode=="decoction")//탕제 
		{
			$od_matype="decoction";
		}
		else if($orderTypeCode=="medicine")//첩재
		{
			$od_matype="commercial";
			$od_goods="M";
		}
		else if($orderTypeCode=="distill")//증류
		{
			$od_matype="decoction";
		}
		else if($orderTypeCode=="powder")//산제
		{
			$od_matype="decoction";
		}
		else if($orderTypeCode=="dry")//건조탕전 
		{
			$od_matype="decoction";
		}

		//주문갯수
		if($orderCount)
		{
			if($orderCount=="0")
			{
				$od_qty="1";
			}
			else
			{
				$od_qty=$orderCount;
			}
		}
		else
		{
			$od_qty="1";
		}

		//조제지시 
		$od_request=$orderComment;
		//복약지도서
		$od_care="care01_2";//복약방법없음
		//20191031 : 복약지도 추가 
		$od_advice=$orderAdvice;
		//주문상태
		//orderStatus

		//$patientCode=$jdata["patientInfo"][0]["patientCode"];//환자코드
		//환자명
		$od_name=$patientName;
		//성별 male:남, female:여
		if(strtolower($patientGender)=="male" || strtolower($patientGender)=="female")
		{
			$od_gender=$patientGender;
		}
		else
		{
			$od_gender="none";
		}
		$od_birth=$patientBirth;//생년월일
		$od_phone=$patientPhone;//전화번호
		$od_mobile=$patientPhone;//휴대전화 
		//사상
		$od_feature="140";


		$od_chubcnt=$chubCnt;//첩수 
		$od_packcnt=$packCnt;//팩수
		$od_packcapa=$packCapa;//팩용량 


		//packageInfo
		if($packinglist)
		{
			$packingarr=explode("|", $packinglist);
			//"|poutch,PCB200421182003,알루미늄파우치(적색),https://data.hanpurmall.co.kr/imgurl,2000|medibox,RBM200421181146,[범용]한약박스(노란색),https://data.hanpurmall.co.kr/imgurl,2000|delibox,RBD190710182024,디제이포장박스,https://data.hanpurmall.co.kr/imgurl,2000"

			$od_packtype="";
			$od_packprice="0";
			$re_boxmedi="";
			$re_boxmedicapa=1;
			$re_boxmediprice="0";
			$re_boxmedibox="";
			$re_boxdeli="";
			$re_boxdeliprice="0";

			for($i=1;$i<count($packingarr);$i++)
			{
				$packingarr2=explode(",",$packingarr[$i]);
				$json["packing".$i]=$packingarr2;
				
				
				if($od_sitecategory=="MEDICAL")
				{
					$pbsql=" select pb_code,pb_type, pb_capa, pb_codeonly, pb_priceA pbPriceA,pb_priceB pbPriceB,pb_priceC pbPriceC,pb_priceD pbPriceD,pb_priceE pbPriceE 
							from ".$dbH."_packingbox 
							where pb_code='".$packingarr2[1]."' ";
				}
				else
				{
					$pbsql=" select pb_code,pb_type, pb_capa, pb_codeonly, pb_priceA pbPriceA,pb_priceB pbPriceB,pb_priceC pbPriceC,pb_priceD pbPriceD,pb_priceE pbPriceE 
							from ".$dbH."_packingbox 
							where pb_cypk='".$packingarr2[1]."' ";
				}

				$json["packingsql".$i]=$pbsql;
				$pbdt=dbone($pbsql);

				if($pbdt["PB_CODE"])
				{
					if($pbdt["PB_TYPE"]=="odPacktype")
					{
						$od_packtype=$pbdt["PB_CODE"];
						$od_packprice=$packingarr2[4];
					}
					else if($pbdt["PB_TYPE"]=="reBoxmedi")
					{
						$re_boxmedi=$pbdt["PB_CODE"];
						$re_boxmedicapa=$pbdt["PB_CAPA"];
						$re_boxmediprice=$packingarr2[4];
						$re_boxmedibox=$re_boxmedicapa;
					}
					else if($pbdt["PB_TYPE"]=="reBoxdeli")
					{
						$re_boxdeli=$pbdt["PB_CODE"];
						$re_boxdeliprice=$packingarr2[4];
					}
				}
				else
				{
					//limit 1해서 데이터 가져오기 
				}
				
			}

		}
		else
		{
			$od_packtype="";
			$od_packprice="0";
			$re_boxmedi="";
			$re_boxmedicapa=1;
			$re_boxmediprice="0";
			$re_boxmedibox="";
			$re_boxdeli="";
			$re_boxdeliprice="0";
		}

		$json["packinglist"]=$packinglist;
		$json["od_packtype"]=$od_packtype;
		$json["re_boxmedi"]=$re_boxmedi;

		//deliveryInfo
		$re_delitype=$deliType; //배송종류 direct(직배), post(택배)

		//보내는 사람 
		$re_sendtype="medical";
		$re_sendName=trim($sendName); //보내는사람
		$re_sendPhone=trim($sendPhone); //보내는사람 전화번호
		$re_sendMobile=trim($sendMobile); //보내는사람 휴대폰번호
		$re_sendZipcode=trim($sendZipcode); //보내는사람 우편번호
		$re_sendAddress=trim($sendAddress)."||".trim($sendAddressDesc);


		$re_name=trim($receiveName); //받는사람
		$re_phone=trim($receivePhone); //받는사람 전화번호
		$re_mobile=trim($receiveMobile); //받는사람 휴대폰번호
		$re_zipcode=trim($receiveZipcode); //받는사람 우편번호
		$re_address=trim($receiveAddress)."||".trim($receiveAddressDesc); //받는사람 주소
		$re_request=trim($receiveComment); //배송요구사항
		//$receiveTied; //묶음배송마스터주문코드 (부산대주문코드)


		//*****************
		//약재
		$arr=explode("|", $totalMedicine);
		$medicode=$newmedicode="";
		$mdPrice=array();
		$mdTitle=array();
		$tmpcode="";
		$rc_medicine="";
		$rc_sweet="";
		$mdWater=array();
		$language="kor";

		for($i=1;$i<count($arr);$i++)
		{
			$arr2=explode(",",$arr[$i]);

			$meditype=$arr2[0];//ehd에서 넘어온 약재타입 
			$medipk=$arr2[1];//ehd에서 넘어온 PK 
			$title=$arr2[2];//약재명
			$title=str_replace(' ','', $title);
			$capa=$arr2[7];
			$price=$arr2[8];

			if($medipk)
			{
				//뽑아온 PK 검색해서 필요한 데이터 가져오자 
				$mdsql=" select ";
				$mdsql.=" a.md_type, a.md_code, a.md_water, a.md_priceA, a.md_priceB, a.md_priceC, a.md_priceD, a.md_priceE ";
				$mdsql.=" ,b.mm_code, b.mm_title_".$language." mmTitle, b.mm_code_pk ";
				$mdsql.=" from ".$dbH."_medicine a  ";
				$mdsql.=" left join ".$dbH."_medicine_djmedi b on b.md_code=a.md_code ";
				if($od_sitecategory=="MEDICAL")
				{
					$mdsql.=" where b.mm_use <> 'D' and b.MD_CODE='".$medipk."' ";
				}
				else
				{
					$mdsql.=" where b.mm_use <> 'D' and b.MM_CODE='".$medipk."' ";
				}
				$mddt=dbone($mdsql);

				$mdWater[$mddt["MD_CODE"]]=$mddt["MD_WATER"];
				$mdPrice[$mddt["MD_CODE"]]=$price;
			}

			if($od_sitecategory=="MEDICAL")
			{
				if(strpos($mddt["MD_CODE"], $medipk) !== false)
				{
					$mdcode[$medipk]=$mddt["MD_CODE"];
					$rc_medicine.="|".$mddt["MD_CODE"].",".$capa.",".$meditype.",".$price;
				}
				else
				{
					$rc_medicine.="|*".$title."_".$medipk.",".$capa.",".$meditype.",".$price;
				}
			}
			else
			{
				if(strpos($mddt["MM_CODE"], $medipk) !== false)
				{
					$mdcode[$medipk]=$mddt["MD_CODE"];
					$rc_medicine.="|".$mddt["MD_CODE"].",".$capa.",".$meditype.",".$price;
				}
				else
				{
					$rc_medicine.="|*".$title."_".$medipk.",".$capa.",".$meditype.",".$price;
				}
			}
		}
		$json["DOO_RC_MEDICINE"]=$rc_medicine;
			
		$rc_sweet="";
		$json["sweetMedi"]=$sweetMedi;
		if($sweetMedi)
		{
			$sarr=explode("|", $sweetMedi);
			for($i=1;$i<count($sarr);$i++)
			{
				$sarr2=explode(",",$sarr[$i]);
				$meditype="inlast";//ehd에서 넘어온 약재타입 
				$medipk=$sarr2[0];//ehd에서 넘어온 PK 
				$title=$sarr2[1];//약재명
				$title=str_replace(' ','', $title);
				$capa=$sarr2[2];
				$price=$sarr2[3];
				if($medipk)
				{
					$swsql=" select ";
					$swsql.=" a.md_type, a.md_code, a.md_water, a.md_priceA, a.md_priceB, a.md_priceC, a.md_priceD, a.md_priceE ";
					$swsql.=" ,b.mm_code, b.mm_title_".$language." mmTitle, b.mm_code_pk ";
					$swsql.=" from ".$dbH."_medicine a  ";
					$swsql.=" left join ".$dbH."_medicine_djmedi b on b.md_code=a.md_code ";
					if($od_sitecategory=="MEDICAL")
					{
						$swsql.=" where b.mm_use <> 'D' and b.md_code='".$medipk."'";
					}
					else
					{
						$swsql.=" where b.mm_use <> 'D' and b.MM_CODE='".$medipk."' ";
					}
					$swdt=dbone($swsql);

					if($od_sitecategory=="MEDICAL")
					{
						if(strpos($swdt["MD_CODE"], $medipk) !== false)
						{
							$mdcode[$medipk]=$swdt["MD_CODE"];
							$rc_sweet.="|".$swdt["MD_CODE"].",".$capa.",".$meditype.",".$price;
						}
						else
						{
							$rc_sweet.="|*".$title."_".$medipk.",".$capa.",".$meditype.",".$price;
						}
					}
					else
					{
						if(strpos($swdt["MM_CODE"], $medipk) !== false)
						{
							$mdcode[$medipk]=$swdt["MD_CODE"];
							$rc_sweet.="|".$swdt["MD_CODE"].",".$capa.",".$meditype.",".$price;
						}
						else
						{
							$rc_sweet.="|*".$title."_".$medipk.",".$capa.",".$meditype.",".$price;
						}
					}


					$mdWater[$swdt["MD_CODE"]]=$swdt["MD_WATER"];
					$mdPrice[$swdt["MD_CODE"]]=$price;
					$mdTitle[$swdt["MD_CODE"]]=$swdt["MMTITLE"];
				}
			}


		}

		$json["rc_medicine"]=$rc_medicine;
		$json["rc_sweet"]=$rc_sweet;

		$json["mdWater"]=$mdWater;
		$json["mdPrice"]=$mdPrice;




		//********
		//정리된 약재와 별전을 물량 계산하자 
		//최종 정리된 약재로 물량 계산하자 
		if($rc_medicine)
		{
			$arr=explode("|",$rc_medicine);
			$meditotal=$watertotal=$mdwater=$mtprice=$mediamt=$medipricetotal=$chubprice=$chubpricetotal=0;
			for($i=1;$i<count($arr);$i++)
			{
				$arr2=explode(",",$arr[$i]);

				if(strpos($arr2[0],"*") !== false) 
				{
					$tmpWater=floatval(0);//약재가 없는건 흡수율이 0으로 셋팅 
					$tmpPrice=floatval(0);//약재가 없는건 약재비가 0으로 셋팅 
				}
				else
				{
					$tmpWater=floatval($mdWater[$arr2[0]]);
					$tmpPrice=floatval($mdPrice[$arr2[0]]);
				}

				$mediamt=floatval($od_chubcnt)*floatval($arr2[1]);//첩수*약재g = 총약재 
				$mtprice=($mediamt*$tmpPrice);
				$mdwater=($mediamt*$tmpWater)/100; //(총약재*흡수율) 나누기 100

				$chubprice=floatval($arr2[1]) * $tmpPrice;
				$chubpricetotal+=$chubprice;//첩당 약재비 

				$medipricetotal+=$mtprice;//총약재비 토탈 
				$watertotal+=$mdwater;//총물량 토탈 

				$meditotal+=$mediamt;//총토탈 약재량 
			}
		}

		
		//20191031 : 최종 정리된 별전로 물량 계산하자 
		$sweetdata="";
		if($rc_sweet)
		{
			$sarr=explode("|",$rc_sweet);
			$sweetpricetotal=0;
			$sweetdata="";
			for($i=1;$i<count($sarr);$i++)
			{
				$sarr2=explode(",",$sarr[$i]);
				if($sarr2[0])
				{
					if(strpos($sarr2[0],"*") !== false) 
					{
						$tmpWater=floatval(0);//약재가 없는건 흡수율이 0으로 셋팅 
						$tmpPrice=floatval($sarr2[3]);//약재가 없는건 약재비가 0으로 셋팅 
						if(strpos($sarr2[0], "_") !== false)//약재code에 _이 있다면 
						{
							$mdarr=explode("_",$sarr2[0]);
							$tmpTitle=$mdarr[0];
							$tmpTitle=str_replace("*","",$tmpTitle);
						}
						else
						{
							$tmpTitle="";
						}
					}
					else
					{
						$tmpWater=floatval($mdWater[$sarr2[0]]);
						$tmpPrice=floatval($mdPrice[$sarr2[0]]);
						$tmpTitle=$mdTitle[$sarr2[0]];
					}		

					$mediamt=floatval($sarr2[1]);//첩수*약재g = 총약재 
					$mtprice=($mediamt*$tmpPrice);
					$mdwater=($mediamt*$tmpWater)/100; //(총약재*흡수율) 나누기 100

					$sweetpricetotal+=$mtprice;//총약재비 토탈 
					$watertotal+=$mdwater;//총물량 토탈 
					
					$sweetdata.="|".$tmpTitle.",".$mediamt.",".$tmpPrice.",".$mtprice;
				}
				
			}
		}

		$json["dc_time"]=$dc_time;
		$json["watertotal"]=$watertotal;
		$json["od_packcnt"]=$od_packcnt;
		$json["od_packcapa"]=$od_packcapa;

		if($od_matype=="decoction")
		{
			//탕전법
			$dc_title="decoctype03";//표준(선무후문)
			//탕전시간
			$dc_time=chkVelvetTime($rc_medicine);
			//특수탕전
			if($specialDecoc)
			{
				$dc_special=$specialDecoc;
			}
			else
			{
				$dc_special="spdecoc01";
			}
			//마킹내용
			if($markType)
			{
				$mr_desc=$markType;
			}
			else
			{
				$mr_desc="marking03";
			}
		}


		//*****************************************************************
		//탕전물량
		//*****************************************************************
		$dooWater=calcDcWater($dc_time, $watertotal, $od_packcnt, $od_packcapa);
		$dcWater=$dooWater;
		
		$dcAlcohol=0;
		if(chkdcSpecial($dc_special)=="alcohol")//주수상반
		{
			$water=calcWaterAlcohol($dooWater);
			$alcohol=$dooWater - $water;
			$dcWater=$water;
			$dcAlcohol=$alcohol;
		}
		else if(chkdcSpecial($dc_special)=="distillation")//증류탕전 
		{
			$water=calcWaterDistillation($dooWater);
			$dcWater=$water;
		}
		else if(chkdcSpecial($dc_special)=="dry")//건조탕전 
		{
			$dcWater=calcWaterDry($watertotal, $od_packcnt, $od_packcapa);
		}
		//*****************************************************************

		$dc_water=$dcWater;
		$json["confirm_dcWater"]=$dcWater;
		$json["confirm_dcAlcohol"]=$dcAlcohol;


		//***********
		//가격 
		$amountdjmedi=array();
		//약재비----------------------------
		//약재비 : $chubpricetotal * $od_chubcnt = $medipricetotal
		//별전   : 0
		//감미제 : 0
		//----------------------------------
		//약재비 
		$medipricetotal=floatval($chubpricetotal) * floatval($od_chubcnt);
		//별전 
		$tgamtotal=$sweetpricetotal;
		//감미제 
		$dcSugartotal=0;
		//최종토탈약재비 
		$totalmediprice=$medipricetotal + $tgamtotal + $dcSugartotal;

		$amountdjmedi["medicine"]=$chubpricetotal.",".$od_chubcnt.",".$medipricetotal;
		//20191031 : 별전추가 
		$amountdjmedi["sweet"]=$sweetdata;
		$amountdjmedi["sugar"]="0,0,".$dcSugartotal;
		$amountdjmedi["totalmedicine"]=$totalmediprice;
		
		//포장비----------------------------
		//20190917 : 파우치, 한약박스 계산 => 수량에 상관없이 적용됨 * 1
		//----------------------------------
		$pmdcnt=1;//수량에 상관없이 하기때문에 기본1로 셋팅 
		//파우치 
		$packp=floatval($od_packprice);
		//한약박스 
		$mediboxp=floatval($re_boxmediprice);
		//배송박스 
		$deliboxp=floatval($re_boxdeliprice);
		//포장비 
		if($od_goods=="M")//첩약이면 
		{
			$packingp=0;
			$packPrice=0;
		}
		else
		{
			$packingp=floatval($packPrice);
		}
		//최종토탈포장비 
		$totalpackprice=$packp+$mediboxp+$deliboxp+$packingp;


		$amountdjmedi["poutch"]=$od_packprice.",".$pmdcnt.",".$packp;
		$amountdjmedi["medibox"]=$re_boxmediprice.",".$pmdcnt.",".$mediboxp;
		$amountdjmedi["delibox"]=$re_boxdeliprice.",".$pmdcnt.",".$deliboxp;
		$amountdjmedi["packing"]=$packPrice.",".$pmdcnt.",".$packingp;
		$amountdjmedi["dcshape"]="0,1,0";
		$amountdjmedi["totalpack"]=$totalpackprice;

		//탕전비----------------------------
		//20190917 : 탕전비 계산 => 용량에 상관없이 Class 적용됨 공식은 약재비와 같음
		//----------------------------------
		$decoctionprice=$dc_price;	
		$amountdjmedi["decoction"]=$dc_price.",1,".$decoctionprice;

		//조제비----------------------------
		//20190917 : 조제비 계산 => 팩수 * 조제비 적용
		//----------------------------------
		$makingprice=floatval($od_packcnt) * floatval($ma_price);
		//선전비
		if (strpos($rc_medicine, ",infirst,") !== false) 
		{
			$infirst=$firstPrice;	
		}
		else
		{
			$infirst=0;
		}
		//후하비 
		if (strpos($rc_medicine, ",inafter,") !== false) 
		{
			$inafter=$afterPrice;	
		}
		else
		{
			$inafter=0;
		}

		$amountdjmedi["makingprice"]=$ma_price.",".$od_packcnt.",".$makingprice;
		$amountdjmedi["infirst"]=$infirst.",1,".$infirst;
		$amountdjmedi["inafter"]=$inafter.",1,".$inafter;

		$totalmaking=$makingprice+$infirst+$inafter;
		$amountdjmedi["making"]=$totalmaking;


		//배송비----------------------------
		//20190917 : 배송비 계산 => 배송비는 약재박스 단위로 계산하는데 2개당 하나의 송장이 부착 1개일때 - 송장한개, 2개일때  송장한개, 3개일일때 송장 2개...
		//----------------------------------
		if($od_goods=="M") //첩약배송비 
		{
			$boxcnt=1;
			$boxprice=floatval($boxcnt) * floatval($cheobPrice);
			$amountdjmedi["release"]=$cheobPrice.",".$boxcnt.",".$boxprice;
			$re_boxmedibox=$re_boxmedicapa;
			$re_price=$cheobPrice;
		}
		else
		{
			$boxmax = ceil($od_packcnt / $re_boxmedicapa);//올림 
			$boxcnt = ceil($boxmax/2);
			$boxprice=floatval($boxcnt) * floatval($re_price);
			$amountdjmedi["release"]=$re_price.",".$boxcnt.",".$boxprice;
			$re_boxmedibox=$re_boxmedicapa;
		}

		//토탈금액--------------------------
		//주문금액
		//----------------------------------
		$odAmount=$totalmediprice+$totalpackprice+$decoctionprice+$makingprice+$boxprice;
		$od_amount=$odAmount;
		//10원단위 
		$od_amount=getSibdan($od_amount);
		$amountdjmedi["totalamount"]=$od_amount;
		//PHP5.4이상일경우에만 
		//$od_amountdjmedi=json_encode($amountdjmedi, JSON_UNESCAPED_UNICODE);
		$od_amountdjmedi=my_json_encode($amountdjmedi);
 

		$od_amountokchart="";
		//=========================================================

		$os_status="paid";//결제완료로..주문대기로 

		///***************************
		//clob정리
		$rc_medicine=insertClob($rc_medicine);
		$rc_sweet=insertClob($rc_sweet);

		//조제지시 
		$od_request=insertClob($od_request);
		$od_advice=insertClob($od_advice);
		$re_request=insertClob($re_request);

		//주문금액
		$od_amountdjmedi=insertClob($od_amountdjmedi);


		//insert하자 

		//주문정보등록
		$sql=" insert into ".$dbH."_order (OD_SEQ, od_code, od_keycode, od_no, od_userid, od_sitecategory, od_recipe,od_scription ,od_staff ,od_title ,od_matype, od_goods, od_qty, od_chubcnt ,od_packtype ,od_packcnt ,od_packcapa ,od_name ,od_gender, od_birth, od_feature, od_phone ,od_mobile ,od_amount, od_amountdjmedi,od_amountokchart, od_zipcode ,od_address ,od_request ,od_care ,od_advice ,od_packprice, od_status ,od_use, od_date) values ((SELECT NVL(MAX(OD_SEQ),0)+1 FROM ".$dbH."_order),'".$od_code."','".$od_keycode."','0','".$od_userid."', '".$od_sitecategory."','general', '".$rc_code."','".$od_staff."','".$od_title."','".$od_matype."','".$od_goods."', '".$od_qty."', '".$od_chubcnt."','".$od_packtype."','".$od_packcnt."','".$od_packcapa."','".$od_name."','".$od_gender."', '".$od_birth."', '".$od_feature."','".$od_phone."','".$od_mobile."','".$od_amount."',".$od_amountdjmedi.",'".$od_amountokchart."','".$od_zipcode."','".$od_address."',".$od_request.",'".$od_care."',".$od_advice.", '".$od_packprice."', '".$os_status."','Y',sysdate) ";
		$json["1.order"]=$sql;
		dbcommit($sql);
		//echo $sql."<br><Br>";


		//조제정보등록
		//han_making -> ma_medicine필드 제거 han_recipeuser 에 저장한다 
		$ma_barcode=str_replace("ODD", "MKD", $od_code);//"MKD".$datecode;
		$ma_title=$od_title;
		$sql=" insert into ".$dbH."_making (ma_odcode, ma_keycode, ma_userid, ma_barcode, ma_title,  ma_price, ma_status, ma_use, ma_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$ma_barcode."','".$ma_title."','".$ma_price."', '".$os_status."', 'Y', sysdate) ";
		$json["2.making"]=$sql;
		dbcommit($sql);
		//echo $sql."<br><Br>";

		//탕전정보등록
		$dc_barcode=str_replace("ODD", "DED", $od_code);//"DED".$datecode;
		$sql=" insert into ".$dbH."_decoction (dc_odcode, dc_keycode, dc_userid, dc_barcode, dc_sugar, dc_dry, dc_ripen,dc_jungtang,dc_title, dc_time, dc_special, dc_water,DC_ALCOHOL,  dc_sterilized, dc_cooling, dc_shape, dc_binders, dc_fineness,  dc_millingloss, dc_lossjewan, dc_bindersliang, dc_completeliang, dc_completecnt, dc_price, dc_status, dc_use, dc_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$dc_barcode."','".$dc_sugar."','".$dc_dry."','".$dc_ripen."','".$dc_jungtang."','".$dc_title."','".$dc_time."','".$dc_special."','".$dc_water."','".$dcAlcohol."','".$dc_sterilized."','".$dc_cooling."', '".$dc_shape."','".$dc_binders."','".$dc_fineness."','".$dc_millingloss."','".$dc_lossjewan."','".$dc_bindersliang."','".$dc_completeliang."', '".$dc_completecnt."', '".$dc_price."', '".$os_status."', 'Y', sysdate) ";
		$json["3.decoction"]=$sql;
		dbcommit($sql);
		//echo $sql."<br><Br>";

		//마킹정보등록
		$mr_barcode=str_replace("ODD", "MRK", $od_code);//"MRK".$datecode;
		$sql=" insert into ".$dbH."_marking (mr_odcode, mr_keycode, mr_userid, mr_barcode, mr_desc, mr_status, mr_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$mr_barcode."','".$mr_desc."', '".$os_status."', sysdate) ";
		$json["4.marking"]=$sql;
		dbcommit($sql);
		//echo $sql."<br><Br>";

		//출고정보등록
		$re_barcode=str_replace("ODD", "RED", $od_code);//"RED".$datecode;
		$sql=" insert into ".$dbH."_release (re_odcode, re_keycode, re_userid, re_barcode, re_sendtype, re_sendname, re_sendphone, re_sendmobile, re_sendzipcode, re_sendaddress, re_name, re_phone, re_delitype, re_deliexception, re_mobile, re_zipcode, re_address, re_delidate, re_request, re_boxmedi, re_boxdeli, re_price, re_box, re_boxmedibox, re_boxmediprice, re_boxdeliprice, re_status, re_use, re_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$re_barcode."','".$re_sendtype."', '".$re_sendName."','".$re_sendPhone."','".$re_sendMobile."','".$re_sendZipcode."','".$re_sendAddress."','".$re_name."','".$re_phone."','".$re_delitype."','".$re_deliexception."','".$re_mobile."','".$re_zipcode."','".$re_address."',TO_DATE('".$re_delidate."', 'YYYY-MM-DD'),".$re_request.",'".$re_boxmedi."','".$re_boxdeli."','".$re_price."','".$re_box."','".$re_boxmedibox."','".$re_boxmediprice."','".$re_boxdeliprice."','".$os_status."', 'Y', sysdate) ";
		$json["5.release"]=$sql;
		dbcommit($sql);
		//echo $sql."<br><Br>";

		//처방정보등록
		$sql=" insert into ".$dbH."_recipeuser (RC_SEQ, rc_code, rc_source, rc_userid, rc_title_".$language.", rc_medicine, rc_sweet, rc_status, rc_use, rc_date, rc_modify) values ((SELECT NVL(MAX(RC_SEQ),0)+1 FROM ".$dbH."_recipeuser),'".$rc_code."', '".$rc_source."', '".$od_userid."', '".$od_title."', ".$rc_medicine.", ".$rc_sweet.", '".$os_status."', 'Y', sysdate, sysdate) ";
		$json["6.recipeuser"]=$sql;
		dbcommit($sql);
		//echo $sql."<br><Br>";

		if($od_sitecategory=="MEDICAL")
		{
			$sql=" update ".$dbH."_order_medical set  orderStatus='done', modifyDate=sysdate where KEYCODE='".$keyCode."' ";
			dbcommit($sql);
			$json["7.medical"]=$sql;
		}
		else
		{
			$sql=" update ".$dbH."_order_client set  orderStatus='done', modifyDate=sysdate where KEYCODE='".$keyCode."' ";
			$json["7.client"]=$sql;
			dbcommit($sql);
		}



	$json["medicaltodjmedi_config"]=$config;
	$json["medicaltodjmedi"]="OK";
?>
<?php
function getMedicalDoctorInfo($mdcode, $docode, $mdname, $doname)
{
	global $language;
	global $dbH;
	$mi_userid="1426847626";//부산대학교한방병원
	//한의사 검사
	//$medicalCode, $doctorCode, $medicalName, $doctorName
	$sql=" select ME_SEQ, ME_USERID from ".$dbH."_member where ME_LOGINID='".$docode."' ";
	$dt=dbone($sql);

	if($dt["ME_SEQ"])
	{
		$me_userid=$dt["ME_USERID"];
	}
	else
	{
		$me_auth="";
		$me_passwd=addslashes("123123"); ///비밀번호
		$me_grade='22';//한의사로 등록 
		$me_userid=randno(10);
		$sql2=" insert into ".$dbH."_member (me_seq,me_company,me_userid,me_passwd,me_loginid,me_name,me_grade,me_auth,me_status ,me_date)";
		$sql2.="values ((SELECT NVL(MAX(me_seq),0)+1 FROM ".$dbH."_member),'".$mi_userid."', '".$me_userid."','".$me_passwd."', '".$docode."','".$doname."','".$me_grade."','".$me_auth."','confirm', SYSDATE) ";
		dbcommit($sql2);

		$nsql=" select ME_SEQ, ME_USERID from ".$dbH."_member where ME_LOGINID='".$docode."' ";
		$ndt=dbone($nsql);

		$me_userid=$ndt["ME_USERID"];

	}

	$csql=" select MI_GRADE, MI_USERID, MI_NAME from ".$dbH."_medical where MI_USERID='".$mi_userid."' ";
	$cdt=dbone($csql);
	$mi_grade=$cdt["MI_GRADE"];
	$mi_userid=$cdt["MI_USERID"];
	$mi_name=$cdt["MI_NAME"];

	$data=array(
			"meCompany"=>$mi_userid,//한의원ID
			"meUserid"=>$me_userid,//한의사ID
			"miGrade"=>$mi_grade,//한의원등급
			"miName"=>$mi_name//한의원이름
		);

	return $data;
}
?>