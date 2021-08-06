<?php
	//// 주문현황>주문리스트>수기처방입력>등록&수정 
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apicode!="orderupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="orderupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$od_seq=$_POST["seq"];
		$od_code=$_POST["odCode"];

		$re_delidate=$_POST["reDelidate"];
		$re_delidate=date("Y-m-d", strtotime($re_delidate));

		$od_userid=$_POST["odUserid"];
		$od_staff=$_POST["odStaff"];
		$od_title=$_POST["odTitle"];
		$od_chubcnt=($_POST["odChubcnt"])?$_POST["odChubcnt"]:0;
		$od_packtype=$_POST["odPacktype"];
		$od_packcnt=($_POST["odPackcnt"])?$_POST["odPackcnt"]:0;
		$od_packcapa=($_POST["odPackcapa"])?$_POST["odPackcapa"]:0;
		$os_status=$_POST["odStatus"];
		$od_amount=($_POST["odAmount"])?$_POST["odAmount"]:0;

		$dc_sugar=($_POST["dcSugarData"])?$_POST["dcSugarData"]:"";///감미제 
		//$dc_sugar=($dc_sugar)?$dc_sugar:"HD99999_01";
		//탕전 : 탕전법, 특수탕전, 탕전시간, 탕전물량
		$dc_title=$_POST["dcTitle"];
		$dc_time=$_POST["dcTime"];
		$dc_special=$_POST["dcSpecial"];
		$dc_specialprice=($_POST["dcSpecialPrice"])?$_POST["dcSpecialPrice"]:0;
		$dc_water=str_replace(",","",$_POST["dcWater"]);
		$dc_alcohol=str_replace(",","",$_POST["dcAlcohol"]);
		$dc_sterilized=($_POST["dcSterilized"])?$_POST["dcSterilized"]:"N";
		$dc_cooling=($_POST["dcCooling"])?$_POST["dcCooling"]:"N";

		$mr_desc=$_POST["mrDesc"];

		$re_name=$_POST["reName"];
		$re_phone=$_POST["rePhone"];
		$re_delitype=$_POST["reDelitype"];
		$re_mobile=$_POST["reMobile"];
		$re_zipcode=trim($_POST["reZipcode"]);
		$re_address=$_POST["reAddress"].'||'.$_POST["reAddress1"];
		$re_request=$_POST["reRequest"];

		$od_name=$_POST["odName"];///환자명 
		$od_phone=$re_phone;
		$od_mobile=$re_mobile;
		$od_zipcode=$re_zipcode;
		$od_address=$re_address;

		///20190822 :: 성별,생년월일,사상 추가 
		$od_gender=$_POST["odGender"];
		$od_birth=$_POST["odBirth"];
		$od_feature=$_POST["odFeature"];


		$od_request=insertClob($_POST["odRequest"]);
		$od_care=$_POST["odCare"];
		$od_advice=insertClob($_POST["odAdvice"]);
		$od_advicekey=($_POST["odAdvicekey"])?$_POST["odAdvicekey"]:0;

		$re_boxmedi=$_POST["reBoxmedi"];
		$re_boxdeli=$_POST["reBoxdeli"];

		///20191211 : od_goods 추가 
		$od_goods=($_POST["odGoods"])?$_POST["odGoods"]:"N";

		
		///20191217 : 갯수 
		$od_qty=($_POST["orderCnt"])?$_POST["orderCnt"]:1;

		$rc_seq=$_POST["rcSeq"];
		///------------------------------------------------------------
		/// DOO :: 약재정보 빈공간 삭제 
		///------------------------------------------------------------
		$rc_medicine = $_POST["rcMedicine"];
		$rc_medicine = str_replace(" ", "", $rc_medicine);
		$rc_medicine=insertClob($rc_medicine);
		///------------------------------------------------------------
		///------------------------------------------------------------
		/// DOO :: 부족약재 빈공간 삭제 
		///------------------------------------------------------------
		$rc_shortage=$_POST["rcShortage"];
		$rc_shortage = str_replace(" ", "", $rc_shortage);
		///------------------------------------------------------------
		///------------------------------------------------------------
		/// DOO :: sweet 빈공간 삭제 
		///------------------------------------------------------------
		$rc_sweet=$_POST["rcSweet"];
		$rc_sweet = str_replace(" ", "", $rc_sweet);
		///------------------------------------------------------------

		$returnData=$_POST["returnData"];

		$od_recipe=$_POST["odRecipe"];

		

		///추가
		$ma_price=($_POST["maPrice"])?$_POST["maPrice"]:0;///조제비
		$dc_price=($_POST["dcPrice"])?$_POST["dcPrice"]:0;///탕전비
		$od_packprice=($_POST["odPackprice"])?$_POST["odPackprice"]:0;///파우치가격

		
		$packPrice=($_POST["packPrice"])?$_POST["packPrice"]:0;///포장비
		$firstPrice=($_POST["firstPrice"])?$_POST["firstPrice"]:0;///선전비
		$afterPrice=($_POST["afterPrice"])?$_POST["afterPrice"]:0;///후하비


		$re_price=($_POST["rePrice"])?$_POST["rePrice"]:0;///배송비
		$re_box=$_POST["reBox"];///100팩당1박스 
		$re_boxmedibox=($_POST["reBoxmedibox"])?$_POST["reBoxmedibox"]:0;///한약박스50팩당1박스 
		$re_boxmediprice=($_POST["reBoxmediprice"])?$_POST["reBoxmediprice"]:0;///한약박스가격
		$re_boxdeliprice=($_POST["reBoxdeliprice"])?$_POST["reBoxdeliprice"]:0;///배송포장재가격 

		///20190610 추가 
		$od_matype=$_POST["maType"]; ///조제타입 

		$dc_shape=$_POST["dcShape"]; ///제형 
		$dc_binders=$_POST["dcBinders"]; ///결합제
		$dc_fineness=$_POST["dcFineness"]; ///분말도 
		///$dc_terms=$_POST["dcTerms"]; ///탕전조건 
		$dc_millingloss=$_POST["dcMillingloss"]; ///제분손실
		$dc_lossjewan=$_POST["dcLossjewan"]; ///제환손실
		$dc_bindersliang=$_POST["dcBindersliang"]; ///결합제
		$dc_completeliang=$_POST["dcCompleteliang"]; ///완성량
		$dc_completecnt=$_POST["dcCompletecnt"]; ///완성갯수 

		
		if($od_matype=="pill")///제환
		{
			$dc_fineness=$_POST["dcFineness"]; ///분말도 
			

			//탕전 : 탕전법, 특수탕전, 탕전시간, 탕전물량
			//$dc_title=$_POST["dcTitle"];
			//$dc_time=$_POST["dcTime"];
			//$dc_special=$_POST["dcSpecial"];
			//$dc_water=str_replace(",","",$_POST["dcWater"]);
			//$dc_alcohol=str_replace(",","",$_POST["dcAlcohol"]);

			//분쇄 : 분말도, 제분손실
			$pillFineness=$_POST["pillFineness"];

			//농축 : 농축비율, 농축시간
			$pillConcentRatio=$_POST["pillConcentRatio"];
			$pillConcentTime=$_POST["pillConcentTime"];

			//혼합 : 결합제, 결합제량
			$pillBinders=$_POST["pillBinders"];
			$pillBindersliang=$_POST["pillBindersliang"];

			//중탕 : 중탕온도, 중탕시간
			$pillWarmupTemperature=$_POST["pillWarmupTemperature"];
			$pillWarmupTime=$_POST["pillWarmupTime"];


			//숙성 : 숙성온도, 숙성시간
			$pillFermentTemperature=$_POST["pillFermentTemperature"];
			$pillFermentTime=$_POST["pillFermentTime"];

			//제형 : 제형, 제환손실
			$pillShape=$_POST["pillShape"];
			$pillLosspill=$_POST["pillLosspill"];

			//건조 : 건조온도, 건조시간
			$pillDryTemperature=$_POST["pillDryTemperature"];
			$pillDryTime=$_POST["pillDryTime"];

			//처방량
			$od_pillcapa=($_POST["odPillcapa"])?$_POST["odPillcapa"]:0;
			$od_qty=($_POST["odQty"])?$_POST["odQty"]:0;
			$dc_completecnt=$od_qty;

			//착즙
			$pillJuice=($_POST["pillJuice"])?$_POST["pillJuice"]:"N";;

			//가격..(일단은 넣어두자..)
			$pl_price=0;

			$re_boxmediprice=0;

			//제환순서
			$rcPillorder=insertClob($_POST["rcPillorder"]);

			
		}
		else
		{
			$dc_fineness="";
			$od_pillcapa=0;
			$rcPillorder=insertClob("");
			$pillJuice="N";
		}
		
		$dc_jungtang=($_POST["dcJungtang"])?$_POST["dcJungtang"]:"N";
		$dc_ripen=($_POST["dcRipen"])?$_POST["dcRipen"]:0;
		$dc_dry=($_POST["dcDry"])?$_POST["dcDry"]:0;

		///보내는사람 
		
		$re_sendtype=$_POST["reSendType"];
		$re_sendName=$_POST["reSendName"];
		$re_sendPhone=$_POST["reSendPhone"];
		$re_sendMobile=$_POST["reSendMobile"];
		$re_sendZipcode=trim($_POST["reSendZipcode"]);
		$re_sendAddress=$_POST["reSendAddress"]."||".$_POST["reSendAddress1"];

		///20190801 주문금액 json data 
		$od_amountdjmedi=$_POST["odAmountdjmedi"];
		$od_amountokchart=$_POST["odAmountokchart"];
		

		if($od_goods=="G")
		{
			$os_status="paid";
			$re_delitype=($_POST["reDelitype"])?$_POST["reDelitype"]:"direct";
			$re_name=($_POST["reName"])?$_POST["reName"]:"부산대공용";
		}
		else
		{
			$arr=explode("_",$od_status);
			if($arr[1]=="stop"){
				$proc=$arr[0];
				$od_status=$arr[0]."_start";
			}else if($os_status=="preorder"||$os_status=="order"){
				$os_status="order";
			}else if($os_status=="paid"){
				$os_status="paid";
			}else{
				$os_status="making_apply";
			}
		}
		if($od_seq)
		{
			$osql=" select OD_SITECATEGORY from ".$dbH."_order where od_seq='".$od_seq."' ";
			$odt=dbone($osql);
			$od_sitecategory=$odt["OD_SITECATEGORY"];

			
			///주문정보업데이트
			$sql=" update ".$dbH."_order set od_matype='".$od_matype."', od_userid='".$od_userid."',od_packprice='".$od_packprice."', od_recipe='".$od_recipe."', od_staff='".$od_staff."',od_goods='".$od_goods."', od_title='".$od_title."',OD_PILLCAPA='".$od_pillcapa."', od_qty='".$od_qty."', od_chubcnt='".$od_chubcnt."',od_packtype='".$od_packtype."',od_packcnt='".$od_packcnt."',od_packcapa='".$od_packcapa."',od_request=".$od_request.", od_amount='".$od_amount."', od_amountdjmedi='".$od_amountdjmedi."', od_amountokchart='".$od_amountokchart."', od_advice=".$od_advice.", od_advicekey='".$od_advicekey."', od_care='".$od_care."',od_status='".$os_status."',od_gender = '".$od_gender."', od_name = '".$od_name."',od_birth = '".$od_birth."', od_feature = '".$od_feature."', od_modify=sysdate where od_seq='".$od_seq."' ";
			dbcommit($sql);
			$json["1주문sql"]=$sql;

			if($od_sitecategory=="MEDICAL")//medical일 경우에만 
			{
				$sql=" update ".$dbH."_order_medical set ORDERADVICEKEY='".$od_advicekey."' where KEYCODE=( select od_keycode from ".$dbH."_order where od_seq='".$od_seq."') ";
				dbcommit($sql);
				$json["medicalsql"]=$sql;
			}

			///조제정보업데이트
			$ma_title=$od_title;
			$sql=" update ".$dbH."_making set ma_price='".$ma_price."', MA_FIRSTPRICE='".$firstPrice."',  MA_AFTERPRICE='".$afterPrice."', ma_title='".$ma_title."',ma_modify=sysdate where ma_keycode=( select od_keycode from ".$dbH."_order where od_seq='".$od_seq."') ";
			dbcommit($sql);
			$json["2조제sql"]=$sql;

			///탕전정보업데이트
			$sql=" update ".$dbH."_decoction set dc_sugar='".$dc_sugar."', dc_jungtang='".$dc_jungtang."', dc_ripen='".$dc_ripen."',dc_dry='".$dc_dry."', dc_title='".$dc_title."',dc_price='".$dc_price."', dc_time='".$dc_time."',dc_special='".$dc_special."', DC_SPECIALPRICE='".$dc_specialprice."', dc_water='".$dc_water."',dc_alcohol='".$dc_alcohol."', dc_sterilized='".$dc_sterilized."',dc_cooling='".$dc_cooling."', dc_shape='".$dc_shape."', dc_binders='".$dc_binders."', dc_fineness='".$dc_fineness."', dc_millingloss='".$dc_millingloss."', dc_lossjewan='".$dc_lossjewan."', dc_bindersliang='".$dc_bindersliang."', dc_completeliang='".$dc_completeliang."', dc_completecnt='".$dc_completecnt."', dc_status='".$od_status."',dc_modify=sysdate where dc_keycode=( select od_keycode from ".$dbH."_order where od_seq='".$od_seq."') ";
			dbcommit($sql);
			$json["3탕전sql"]=$sql;


			///마킹정보업데이트
			$sql=" update ".$dbH."_marking set mr_desc='".$mr_desc."', mr_status='".$od_status."', mr_modify=sysdate where mr_keycode=( select od_keycode from ".$dbH."_order where od_seq='".$od_seq."') ";
			dbcommit($sql);
			$json["4마킹sql"]=$sql;


			///출고정보업데이트
			$sql=" update ".$dbH."_release set re_price='".$re_price."',re_box='".$re_box."', re_packingprice='".$packPrice."', re_boxmedibox='".$re_boxmedibox."',re_boxmediprice='".$re_boxmediprice."',re_boxdeliprice='".$re_boxdeliprice."', re_sendtype='".$re_sendtype."', re_sendname='".$re_sendName."', re_sendphone='".$re_sendPhone."', re_sendmobile='".$re_sendMobile."', re_sendzipcode='".$re_sendZipcode."', re_sendaddress='".$re_sendAddress."', re_name='".$re_name."',re_phone='".$re_phone."',re_delitype='".$re_delitype."',re_mobile='".$re_mobile."',re_zipcode='".$re_zipcode."',re_address='".$re_address."',re_delidate=TO_DATE('".$re_delidate."', 'YYYY-MM-DD'),re_request='".$re_request."',re_boxmedi='".$re_boxmedi."',re_boxdeli='".$re_boxdeli."', re_status='".$od_status."', re_modify=sysdate where re_keycode=( select od_keycode from ".$dbH."_order where od_seq='".$od_seq."') ";
			dbcommit($sql);
			$json["5출고sql"]=$sql;

			if($od_matype=="pill")///제환
			{
				///처방정보업데이트
				$sql=" update ".$dbH."_recipeuser set rc_medicine=".$rc_medicine.", rc_sweet='".$rc_sweet."', RC_PILLORDER=".$rcPillorder.", rc_modify=sysdate where rc_seq='".$rc_seq."' ";
				dbcommit($sql);
				$json["6recipeuser"]=$sql;

				///제환정보등록 
				$sql=" update ".$dbH."_PILL set PL_PRICE='".$pl_price."', PL_DCTITLE='".$dc_title."',PL_DCSPECIAL='".$dc_special."',PL_DCTIME='".$dc_time."',PL_DCWATER='".$dc_water."',PL_DCALCOHOL='".$dc_alcohol."',PL_FINENESS='".$pillFineness."',PL_MILLINGLOSS='".$pillMillingloss."',PL_CONCENTRATIO='".$pillConcentRatio."',PL_CONCENTTIME='".$pillConcentTime."',PL_BINDERS='".$pillBinders."',PL_BINDERSLIANG='".$pillBindersliang."',PL_WARMUPTEMPERATURE='".$pillWarmupTemperature."',PL_WARMUPTIME='".$pillWarmupTime."',PL_FERMENTTEMPERATURE='".$pillFermentTemperature."',PL_FERMENTTIME='".$pillFermentTime."',PL_SHAPE='".$pillShape."',PL_LOSSPILL='".$pillLosspill."',PL_JUICE='".$pillJuice."',PL_DRYTEMPERATURE='".$pillDryTemperature."',PL_DRYTIME='".$pillDryTime."', PL_MODIFY=sysdate where PL_KEYCODE=( select od_keycode from ".$dbH."_order where od_seq='".$od_seq."') ";
				dbcommit($sql);
				$json["7pill"]=$sql;
			}
			else
			{
				///처방정보업데이트
				$sql=" update ".$dbH."_recipeuser set rc_medicine=".$rc_medicine.", rc_sweet='".$rc_sweet."', rc_modify=sysdate where rc_seq='".$rc_seq."' ";
				dbcommit($sql);
				$json["6recipeuser"]=$sql;
			}

		}else{
			///날짜 + seq + 물량 + 침포시간  작업시작시 처리 시작전에는 키코드사용
			///코드변경  날짜 =>  180702 + 00000 + 0000 + 0
			$datecode=date("YmdHis");			
			$keyCodeLast = getkeyCodeLast($datecode);
			$od_code="ODD".$datecode.$keyCodeLast;
			$od_keycode=$datecode.$keyCodeLast;
			$rc_code="RC".$datecode.$keyCodeLast;
			///20191217 : 사전조제 처방코드 
			$rc_source=($_POST["rc_source"])?$_POST["rc_source"]:"";

			$od_sitecategory=($sitecategory) ? strtoupper($sitecategory) : "MANAGER";///사이트별 타입 저장 
			

			if($od_goods=="G")
			{
				$os_status="paid";
			}
			else
			{
				$os_status="order";
			}
			
			///주문정보등록
			$sql=" insert into ".$dbH."_order (OD_SEQ, od_code, od_keycode, od_no, od_userid, od_sitecategory, od_recipe, od_scription ,od_staff ,od_title ,od_matype, od_goods, OD_PILLCAPA, od_qty, od_chubcnt ,od_packtype ,od_packcnt ,od_packcapa ,od_name ,od_gender, od_birth, od_feature, od_phone ,od_mobile ,od_amount, od_amountdjmedi, od_amountokchart, od_zipcode ,od_address ,od_request ,od_care ,od_advice ,od_packprice, od_status ,od_use, od_date) values ((SELECT NVL(MAX(OD_SEQ),0)+1 FROM ".$dbH."_order), '".$od_code."','".$od_keycode."','0','".$od_userid."', '".$od_sitecategory."','".$od_recipe."', '".$rc_code."','".$od_staff."','".$od_title."','".$od_matype."','".$od_goods."','".$od_pillcapa."','".$od_qty."','".$od_chubcnt."','".$od_packtype."','".$od_packcnt."','".$od_packcapa."','".$od_name."','".$od_gender."', '".$od_birth."','".$od_feature."','".$od_phone."','".$od_mobile."','".$od_amount."','".$od_amountdjmedi."','".$od_amountokchart."','".$od_zipcode."','".$od_address."',".$od_request.",'".$od_care."',".$od_advice.", '".$od_packprice."', '".$os_status."','Y',sysdate) ";
			dbcommit($sql);
			$json["1order"]=$sql;


			///조제정보등록
			///han_making -> ma_medicine필드 제거 han_recipeuser 에 저장한다 
			$ma_barcode="MKD".$datecode;
			///$ma_medicine=$rc_medicine;
			$ma_title=$od_title;
			$sql=" insert into ".$dbH."_making (ma_odcode, ma_keycode, ma_userid, ma_barcode, ma_title,  ma_price, MA_FIRSTPRICE, MA_AFTERPRICE, ma_status, ma_use, ma_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$ma_barcode."','".$ma_title."','".$ma_price."', '".$firstPrice."', '".$afterPrice."', '".$os_status."', 'Y', sysdate) ";
			dbcommit($sql);
			$json["2making"]=$sql;

			///탕전정보등록
			$dc_barcode="DED".$datecode;
			$sql=" insert into ".$dbH."_decoction (dc_odcode, dc_keycode, dc_userid, dc_barcode, dc_sugar, dc_dry, dc_ripen,dc_jungtang,dc_title, dc_time, dc_special, DC_SPECIALPRICE, dc_water, dc_alcohol, dc_sterilized, dc_cooling, dc_shape, dc_binders, dc_fineness,  dc_millingloss, dc_lossjewan, dc_bindersliang, dc_completeliang, dc_completecnt, dc_price, dc_status, dc_use, dc_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$dc_barcode."','".$dc_sugar."','".$dc_dry."','".$dc_ripen."','".$dc_jungtang."','".$dc_title."','".$dc_time."','".$dc_special."','".$dc_specialprice."','".$dc_water."','".$dc_alcohol."','".$dc_sterilized."','".$dc_cooling."', '".$dc_shape."','".$dc_binders."','".$dc_fineness."','".$dc_millingloss."','".$dc_lossjewan."','".$dc_bindersliang."','".$dc_completeliang."', '".$dc_completecnt."', '".$dc_price."', '".$os_status."', 'Y', sysdate) ";
			dbcommit($sql);
			$json["3decoction"]=$sql;

			///마킹정보등록
			$mr_barcode="MRK".$datecode;
			$sql=" insert into ".$dbH."_marking (mr_odcode, mr_keycode, mr_userid, mr_barcode, mr_desc, mr_status, mr_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$mr_barcode."','".$mr_desc."', '".$os_status."', sysdate) ";
			dbcommit($sql);
			$json["4marking"]=$sql;

			///출고정보등록
			$re_barcode="RED".$datecode;
			$sql=" insert into ".$dbH."_release (re_odcode, re_keycode, re_userid, re_barcode, re_sendtype, re_sendname, re_sendphone, re_sendmobile, re_sendzipcode, re_sendaddress, re_name, re_phone, re_delitype, re_mobile, re_zipcode, re_address, re_delidate, re_request, re_boxmedi, re_boxdeli, re_price, re_packingprice, re_box, re_boxmedibox, re_boxmediprice, re_boxdeliprice, re_status, re_use, re_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$re_barcode."', '".$re_sendtype."', '".$re_sendName."','".$re_sendPhone."','".$re_sendMobile."','".$re_sendZipcode."','".$re_sendAddress."','".$re_name."','".$re_phone."','".$re_delitype."','".$re_mobile."','".$re_zipcode."','".$re_address."',TO_DATE('".$re_delidate."', 'YYYY-MM-DD'),'".$re_request."','".$re_boxmedi."','".$re_boxdeli."','".$re_price."','".$packPrice."','".$re_box."','".$re_boxmedibox."','".$re_boxmediprice."','".$re_boxdeliprice."','".$os_status."', 'Y', sysdate) ";
			dbcommit($sql);
			$json["5release"]=$sql;



			if($od_matype=="pill")///제환
			{
				///처방정보등록
				$sql=" insert into ".$dbH."_recipeuser (RC_SEQ, rc_code, rc_source, rc_userid, rc_title_".$language.", rc_medicine, rc_sweet, RC_PILLORDER, rc_status, rc_use, rc_date, rc_modify) values ((SELECT NVL(MAX(RC_SEQ),0)+1 FROM ".$dbH."_recipeuser),'".$rc_code."', '".$rc_source."', '".$od_userid."', '".$od_title."', ".$rc_medicine.", '".$rc_sweet."', ".$rcPillorder.",'".$os_status."', 'Y', sysdate, sysdate) ";
				dbcommit($sql);
				$json["6recipeuser"]=$sql;


				///제환정보등록 
				$pl_barcode="PIL".$datecode;
				$sql=" insert into ".$dbH."_PILL (PL_ODCODE, PL_KEYCODE, PL_USERID, PL_BARCODE,PL_PRICE, PL_DCTITLE,PL_DCSPECIAL,PL_DCTIME,PL_DCWATER,PL_DCALCOHOL,PL_FINENESS,PL_MILLINGLOSS,PL_CONCENTRATIO,PL_CONCENTTIME,PL_BINDERS,PL_BINDERSLIANG,PL_WARMUPTEMPERATURE,PL_WARMUPTIME,PL_FERMENTTEMPERATURE,PL_FERMENTTIME,PL_SHAPE,PL_LOSSPILL,PL_DRYTEMPERATURE,PL_DRYTIME, PL_JUICE, PL_STATUS, PL_USE, PL_DATE) values('".$od_code."','".$od_keycode."','".$od_userid."','".$pl_barcode."','".$pl_price."','".$dc_title."','".$dc_special."','".$dc_time."','".$dc_water."','".$dc_alcohol."','".$pillFineness."','".$pillMillingloss."','".$pillConcentRatio."','".$pillConcentTime."','".$pillBinders."','".$pillBindersliang."','".$pillWarmupTemperature."','".$pillWarmupTime."','".$pillFermentTemperature."','".$pillFermentTime."','".$pillShape."','".$pillLosspill."','".$pillDryTemperature."','".$pillDryTime."', '".$pillJuice."','".$os_status."','Y', sysdate) ";
				dbcommit($sql);
				$json["7pill"]=$sql;

				
			}
			else
			{
				///처방정보등록
				$sql=" insert into ".$dbH."_recipeuser (RC_SEQ, rc_code, rc_source, rc_userid, rc_title_".$language.", rc_medicine, rc_sweet, rc_status, rc_use, rc_date, rc_modify) values ((SELECT NVL(MAX(RC_SEQ),0)+1 FROM ".$dbH."_recipeuser),'".$rc_code."', '".$rc_source."', '".$od_userid."', '".$od_title."', ".$rc_medicine.", '".$rc_sweet."', '".$os_status."', 'Y', sysdate, sysdate) ";
				dbcommit($sql);
				$json["6recipeuser"]=$sql;
			}
			

			///----------------------------------------------------------------------------------
			///약재부족 상태값 바꾸자 - shortage : 약재부족 
			///----------------------------------------------------------------------------------
			$arr=explode("|",$rc_shortage);
			$shortage="";
			$len=count($arr);
			if($len > 1)
			{
				for($i=1;$i<$len;$i++)
				{
					if($i == ($len-1))
						$shortage.="'".$arr[$i]."'";
					else
						$shortage.="'".$arr[$i]."',";
				}
				$sql=" update ".$dbH."_medicine set md_status = 'shortage', md_modify = sysdate ";
				$sql.=" where md_status = 'use' and md_use = 'Y' and md_code in (".$shortage.")  ";
				//dbcommit($sql);
			}
			///----------------------------------------------------------------------------------

		}


		$json["postsendtype"]=$_POST["reSendType"];
		$json["re_sendtype"]=$re_sendtype;

		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
