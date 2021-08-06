<?php
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apicode!="orderchangeupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="orderchangeupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else{
		$returnData=$_POST["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$od_seq=$_POST["seq"];
		$od_code=$_POST["odCode"];
		$od_oldodcode=$_POST["odCode"];

		$re_delidate=$_POST["reDelidate"];//배송희망일 

		$od_userid=$_POST["odUserid"];
		$od_staff=$_POST["odStaff"];
		$od_title=$_POST["odTitle"];
		$od_chubcnt=($_POST["odChubcnt"])?$_POST["odChubcnt"]:0;
		$od_packtype=$_POST["odPacktype"];
		$od_packcnt=($_POST["odPackcnt"])?$_POST["odPackcnt"]:0;
		$od_packcapa=($_POST["odPackcapa"])?$_POST["odPackcapa"]:0;
		$od_status=$_POST["odStatus"];
		$od_amount=($_POST["odAmount"])?$_POST["odAmount"]:0;
		$od_restarttext=$_POST["odRestarttext"];//재시작사유 
		$restarttxt=$_POST["restarttxt"];//재시작사유 텍스트 	


		$dc_sugar=$_POST["dcSugar"];
		$dc_sugar=($dc_sugar)?$dc_sugar:"HD99999_01";
		$dc_title=$_POST["dcTitle"];
		$dc_time=$_POST["dcTime"];
		$dc_special=$_POST["dcSpecial"];
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

		$od_name=$_POST["odName"];//20191013 : 환자명 
		$od_phone=$re_phone;
		$od_mobile=$re_mobile;
		$od_zipcode=$re_zipcode;
		$od_address=$re_address;

		//20190822 :: 성별,생년월일,사상 추가 
		$od_gender=$_POST["odGender"];
		$od_birth=$_POST["odBirth"];
		$od_feature=$_POST["odFeature"];


		$od_request=$_POST["odRequest"];
		$od_care=$_POST["odCare"];
		$od_advice=$_POST["odAdvice"];

		$re_boxmedi=$_POST["reBoxmedi"];
		$re_boxdeli=$_POST["reBoxdeli"];

		$rc_seq=$_POST["rcSeq"];
		//------------------------------------------------------------
		// DOO :: 약재정보 빈공간 삭제 
		//------------------------------------------------------------
		$rc_medicine = $_POST["rcMedicine"];
		$rc_medicine = str_replace(" ", "", $rc_medicine);
		//------------------------------------------------------------
		//------------------------------------------------------------
		// DOO :: 부족약재 빈공간 삭제 
		//------------------------------------------------------------
		$rc_shortage=$_POST["rcShortage"];
		$rc_shortage = str_replace(" ", "", $rc_shortage);
		//------------------------------------------------------------
		//------------------------------------------------------------
		// DOO :: sweet 빈공간 삭제 
		//------------------------------------------------------------
		$rc_sweet=$_POST["rcSweet"];
		$rc_sweet = str_replace(" ", "", $rc_sweet);
		//------------------------------------------------------------

		$od_recipe=$_POST["odRecipe"];

		//추가
		$ma_price=$_POST["maPrice"];//조제비
		$dc_price=($_POST["dcPrice"])?$_POST["dcPrice"]:0;///탕전비
		$od_packprice=($_POST["odPackprice"])?$_POST["odPackprice"]:0;///파우치가격

		$packPrice=($_POST["packPrice"])?$_POST["packPrice"]:0;///포장비
		$firstPrice=($_POST["firstPrice"])?$_POST["firstPrice"]:0;///선전비
		$afterPrice=($_POST["afterPrice"])?$_POST["afterPrice"]:0;///후하비

		$re_price=$_POST["rePrice"];//배송비
		$re_box=$_POST["reBox"];//100팩당1박스 
		$re_boxmedibox=$_POST["reBoxmedibox"];//한약박스50팩당1박스 
		$re_boxmediprice=$_POST["reBoxmediprice"];//한약박스가격
		$re_boxdeliprice=($_POST["reBoxdeliprice"])?$_POST["reBoxdeliprice"]:0;///배송포장재가격 

		//20190610 추가 
		$od_matype=$_POST["maType"]; //조제타입 

		$dc_shape=$_POST["dcShape"]; //제형 
		$dc_binders=$_POST["dcBinders"]; //결합제
		//$dc_terms=$_POST["dcTerms"]; //탕전조건 
		$dc_millingloss=$_POST["dcMillingloss"]; //제분손실
		$dc_lossjewan=$_POST["dcLossjewan"]; //제환손실
		$dc_bindersliang=$_POST["dcBindersliang"]; //결합제
		$dc_completeliang=$_POST["dcCompleteliang"]; //완성량
		$dc_completecnt=$_POST["dcCompletecnt"]; //완성갯수 


		if($od_matype=="pill")//제환
		{
			$dc_fineness=$_POST["dcFineness"]; //분말도 
		}
		else
		{
			$dc_fineness="";
		}
		
		$dc_jungtang=($_POST["dcJungtang"])?$_POST["dcJungtang"]:"N";
		$dc_ripen=($_POST["dcRipen"])?$_POST["dcRipen"]:0;
		$dc_dry=($_POST["dcDry"])?$_POST["dcDry"]:0;


		//보내는사람 
		
		$re_sendtype=$_POST["reSendType"];
		$re_sendName=$_POST["reSendName"];
		$re_sendPhone=$_POST["reSendPhone"];
		$re_sendMobile=$_POST["reSendMobile"];
		$re_sendZipcode=trim($_POST["reSendZipcode"]);
		$re_sendAddress=$_POST["reSendAddress"]."||".$_POST["reSendAddress1"];

		//20190801 주문금액 json data 
		$od_amountdjmedi=$_POST["odAmountdjmedi"];
		$od_amountokchart=$_POST["odAmountokchart"];



		$request = "";
		if($od_request) //조제/탕전요청사항
		{
			$request .= $od_request;
		}
		if($od_restarttext) //재시작사유
		{
			$request .= "\n".$restarttxt." : ".$od_restarttext;
		}

		$status = substr($od_status,0,7);

		//작업사항
		//조제 탕전시 취소시  --> 재시작시 - 입금확인부터 : 이전 주문코드 추가, 재시작사유 추가 
		//===============================================================================
		// 주문번호 새로 생성 
		//===============================================================================
		//marking, release 일 경우에는 dc_water를 db에서 쿼리해와  주문번호를 생성하자 
		if($status=="marking" || $status=="release")
		{
			$sql = "select dc_water from ".$dbH."_decoction where dc_odcode = '".$od_oldodcode."'";
			$dt=dbone($sql);
			$dc_water = $dt["DC_WATER"];
		}
		//-------------------------------------------------------------------------------
		$sql1 = $sql;
		$dcWater=intval($dc_water);
		$dcDate = date("Y-m-d");
		$datecode=date("YmdHis");
		//$od_keycode = "ODD".$datecode;
		$keyCodeLast = getkeyCodeLast($datecode);
		$od_keycode=$datecode.$keyCodeLast;//intval(substr(microtime(),0,4)*100);
		$json["od_keycode"]=$od_keycode;
		//-------------------------------------------------------------------------------
		$sql=" select MAX(od_no+1) as addno from ".$dbH."_order where to_char(od_date,'yyyy-mm-dd') = '".$dcDate."' order by od_no desc ";
		$sql1 .= $sql;
		$dt=dbone($sql);
		if(intval($dt["ADDNO"])>0)
		{
			$odNo=intval($dt["ADDNO"]);
		}
		else
		{
			$odNo=1;
		}
		//-------------------------------------------------------------------------------
		//날짜 + seq + 물량 + 침포시간  작업시작시 처리 시작전에는 키코드사용
		//코드변경  날짜 =>  180702 + 00000 + 0000 + 0
		//$odNo=sprintf("%05d",$odNo);
		//$water=sprintf("%04d",intval($dcWater/10));//물량은 꼭 숫자로 바꾸기 
		//$melting=3;//침포시간 
		//$od_newcode = date("ymd").$odNo.$water.$melting;
		$od_code='ODD'.$od_keycode;
		$rc_code="RC".$od_keycode;
		$rc_source="";//출처 
		$$od_newcode=$datecode;
		//===============================================================================
		//상태값이 marking & release 일때만 따로 처리하자 
		//검수/마킹 취소시  --> 탕전대기 : 조제,탕전까지는 이전주문데이터들로 채우고 마킹이후부터는 새로 추가된 데이터 
		//배송불량  취소시  --> 배송재공정 : 조제,탕전,마킹까지는 이전주문데이터들로 채우고 배송 이후부터는 새로 추가된 데이터 
		if($status=="marking" || $status=="release")
		{
			if($status=="marking")
			{
				$od_status = "decoction_apply";
				$ma_status = "making_done";
				$dc_status = "decoction_apply";
				$mr_status = "decoction_apply";
				$re_status = "decoction_apply";
			}
			else
			{
				$od_status = "release_apply";
				$ma_status = "making_done";
				$dc_status = "decoction_done";
				$mr_status = "marking_done";
				$re_status = "release_apply";
			}

			//주문정보등록 
			$sql=" INSERT INTO ".$dbH."_order (OD_SEQ,od_code, od_keycode, od_no, od_userid, od_sitecategory, od_recipe, od_scription ,od_staff ,od_title , od_matype, od_chubcnt ,od_packtype ,od_packprice, od_packcnt ,od_packcapa ,od_name , od_gender, od_birth, od_feature, od_phone ,od_mobile ,od_amount,od_amountdjmedi, od_amountokchart, od_zipcode ,od_address ,od_request ,od_care ,od_advice ,od_oldodcode, od_status ,od_use,od_date) ";
			$sql.=" SELECT (SELECT NVL(MAX(OD_SEQ),0)+1 FROM ".$dbH."_order), '".$od_code."','".$od_keycode."','".$odNo."', od_userid, od_sitecategory, od_recipe,od_scription, '".$od_staff."' ,od_title ,od_matype, od_chubcnt ,od_packtype ,od_packprice, od_packcnt ,od_packcapa ,od_name ,od_gender, od_birth, od_feature, od_phone ,od_mobile ,od_amount,od_amountdjmedi, od_amountokchart, od_zipcode ,od_address ,'".$request."' ,od_care ,od_advice, '".$od_oldodcode."','".$od_status."', 'Y', sysdate ";
			$sql.=" FROM ".$dbH."_order ";
			$sql.=" WHERE od_code ='".$od_oldodcode."' ";
			//dbcommit($sql);
			$json["order1"]=$sql;
			$sql1 .= $sql;

			//조제정보등록
			//han_making -> ma_medicine필드 제거 han_recipeuser 에 저장한다 
			$ma_barcode="MKD".$od_newcode;
			$sql=" INSERT INTO ".$dbH."_making (ma_odcode, ma_keycode, ma_userid, ma_barcode, ma_title, ma_price, MA_FIRSTPRICE, MA_AFTERPRICE, ma_status, ma_use, ma_date)";
			$sql.=" SELECT '".$od_code."','".$od_keycode."',ma_userid, '".$ma_barcode."', ma_title, ma_price, MA_FIRSTPRICE, MA_AFTERPRICE, '".$ma_status."', 'Y', sysdate";
			$sql.=" FROM ".$dbH."_making ";
			$sql.=" WHERE ma_odcode ='".$od_oldodcode."' ";
			//dbcommit($sql);
			$json["making1"]=$sql;
			$sql1 .= $sql;

			//탕전정보등록
			$dc_barcode="DED".$od_newcode;
			$sql=" INSERT INTO ".$dbH."_decoction (dc_odcode, dc_keycode, dc_userid, dc_barcode, dc_medibox_infirst, dc_medibox_inmain, dc_medibox_inafter, dc_medibox_inlast, dc_boilercode,dc_pouchbox, dc_sugar,dc_dry, dc_ripen,dc_jungtang,dc_title, dc_time, dc_special, dc_water, dc_alcohol, dc_sterilized, dc_cooling, dc_shape, dc_binders, dc_fineness,  dc_millingloss, dc_lossjewan, dc_bindersliang, dc_completeliang,dc_completecnt, dc_price, dc_status, dc_use, dc_date) ";
			$sql.=" SELECT '".$od_code."','".$od_keycode."', dc_userid, '".$dc_barcode."', dc_medibox_infirst, dc_medibox_inmain, dc_medibox_inafter, dc_medibox_inlast, dc_boilercode,dc_pouchbox, dc_sugar,dc_dry, dc_ripen,dc_jungtang,dc_title, dc_time, dc_special, dc_water, dc_alcohol, dc_sterilized, dc_cooling, dc_shape, dc_binders, dc_fineness, dc_millingloss, dc_lossjewan, dc_bindersliang, dc_completeliang, dc_completecnt,dc_price,'".$dc_status."', 'Y', sysdate ";
			$sql.=" FROM ".$dbH."_decoction  ";
			$sql.=" WHERE dc_odcode ='".$od_oldodcode."' ";
			//dbcommit($sql);
			$json["decoction1"]=$sql;
			$sql1 .= $sql;

			//마킹정보등록
			$mr_barcode="MRK".$od_newcode;
			if( $status=="release" )
			{
				$sql=" INSERT INTO ".$dbH."_marking (mr_odcode, mr_keycode, mr_userid, mr_barcode, mr_desc, mr_status, mr_date) ";
				$sql.=" SELECT '".$od_code."','".$od_keycode."', mr_userid, '".$mr_barcode."', mr_desc, '".$mr_status."', sysdate ";
				$sql.=" FROM ".$dbH."_marking ";
				$sql.=" WHERE mr_odcode ='".$od_oldodcode."'";
			}
			else
			{
				$sql=" insert into ".$dbH."_marking (mr_odcode, mr_keycode, mr_userid, mr_barcode, mr_desc, mr_status, mr_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$mr_barcode."','".$mr_desc."', '".$mr_status."', sysdate) ";
			}
			//dbcommit($sql);
			$json["marking1"]=$sql;
			$sql1 .= $sql;


			//출고정보등록
			$re_barcode="RED".$od_newcode;
			$sql=" insert into ".$dbH."_release (re_odcode, re_keycode, re_userid, re_barcode, re_sendtype, re_sendname, re_sendphone, re_sendmobile, re_sendzipcode, re_sendaddress, re_name, re_phone, re_delitype, re_mobile, re_zipcode, re_address, re_delidate, re_request, re_boxmedi, re_boxdeli, re_boxmediprice, re_boxmedibox, re_boxdeliprice, re_price,RE_PACKINGPRICE,  re_box, re_status, re_use, re_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$re_barcode."','".$re_sendtype."', '".$re_sendName."','".$re_sendPhone."','".$re_sendMobile."','".$re_sendZipcode."','".$re_sendAddress."','".$re_name."','".$re_phone."','".$re_delitype."','".$re_mobile."','".$re_zipcode."','".$re_address."','".$re_delidate."','".$re_request."','".$re_boxmedi."','".$re_boxdeli."', '".$re_boxmediprice."', '".$re_boxmedibox."', '".$re_boxdeliprice."', '".$re_price."', '".$packPrice."','".$re_box."', '".$re_status."', 'Y', sysdate) ";
			//dbcommit($sql);
			$json["release1"]=$sql;
			$sql1 .= $sql;

			//재시작사유 
			$sql=" update ".$dbH."_order set od_restarttext='".$od_restarttext."', od_modify=sysdate where od_code='".$od_oldodcode."' ";
			//dbcommit($sql);
			$json["order재시작1"]=$sql;
			$sql1 .= $sql;

		}
		else
		{
			$od_sitecategory=($sitecategory) ? strtoupper($sitecategory) : "MANAGER";//사이트별 타입 저장 


			//주문정보등록
			$sql=" insert into ".$dbH."_order (OD_SEQ,od_code, od_keycode, od_no, od_userid, od_sitecategory, od_recipe, od_scription ,od_staff ,od_title , od_matype, od_chubcnt ,od_packtype , od_packprice, od_packcnt ,od_packcapa ,od_name , od_gender, od_birth, od_feature, od_phone ,od_mobile ,od_amount,od_amountdjmedi, od_amountokchart, od_zipcode ,od_address ,od_request ,od_care ,od_advice ,od_oldodcode, od_status ,od_use,od_date) values ((SELECT NVL(MAX(OD_SEQ),0)+1 FROM ".$dbH."_order),'".$od_code."','".$od_keycode."','".$odNo."','".$od_userid."', '".$od_sitecategory."', '".$od_recipe."','".$rc_code."','".$od_staff."','".$od_title."','".$od_matype."','".$od_chubcnt."','".$od_packtype."', '".$od_packprice."', '".$od_packcnt."','".$od_packcapa."','".$od_name."', '".$od_gender."', '".$od_birth."', '".$od_feature."', '".$od_phone."','".$od_mobile."','".$od_amount."','".$od_amountdjmedi."','".$od_amountokchart."','".$od_zipcode."','".$od_address."','".$request."','".$od_care."','".$od_advice."','".$od_oldodcode."','paid','Y',sysdate) ";
			dbcommit($sql);
			$json["order"]=$sql;
			$sql1 .= $sql;


			//조제정보등록
			//han_making -> ma_medicine필드 제거 han_recipeuser 에 저장한다 
			$ma_barcode="MKD".$od_newcode;
			//$ma_medicine=$rc_medicine;
			$ma_title=$od_title;
			$sql=" insert into ".$dbH."_making (ma_odcode, ma_keycode, ma_userid, ma_barcode, ma_title, ma_price, MA_FIRSTPRICE,MA_AFTERPRICE, ma_status, ma_use, ma_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$ma_barcode."','".$ma_title."','".$ma_price."', '".$firstPrice."','".$afterPrice."', 'paid', 'Y', sysdate) ";
			dbcommit($sql);
			$json["making"]=$sql;
			$sql1 .= $sql;

			//탕전정보등록
			$dc_barcode="DED".$od_newcode;
			$sql=" insert into ".$dbH."_decoction (dc_odcode, dc_keycode, dc_userid, dc_barcode, dc_medibox_infirst, dc_medibox_inmain, dc_medibox_inafter, dc_medibox_inlast, dc_boilercode,dc_pouchbox,dc_sugar, dc_dry, dc_ripen,dc_jungtang, dc_title, dc_time, dc_special, dc_water, dc_alcohol, dc_sterilized, dc_cooling, dc_shape, dc_binders, dc_fineness, dc_millingloss, dc_lossjewan, dc_bindersliang, dc_completeliang,dc_completecnt, dc_price, dc_status, dc_use, dc_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$dc_barcode."','','','','','','','".$dc_sugar."','".$dc_dry."','".$dc_ripen."','".$dc_jungtang."','".$dc_title."','".$dc_time."','".$dc_special."','".$dc_water."','".$dc_alcohol."','".$dc_sterilized."','".$dc_cooling."', '".$dc_shape."','".$dc_binders."','".$dc_fineness."','".$dc_millingloss."','".$dc_lossjewan."','".$dc_bindersliang."','".$dc_completeliang."','".$dc_completecnt."','".$dc_price."', 'paid', 'Y', sysdate) ";
			dbcommit($sql);
			$json["decoction"]=$sql;
			$sql1 .= $sql;

			//마킹정보등록
			$mr_barcode="MRK".$od_newcode;
			$sql=" insert into ".$dbH."_marking (mr_odcode, mr_keycode, mr_userid, mr_barcode, mr_desc, mr_status, mr_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$mr_barcode."','".$mr_desc."', 'paid', sysdate) ";
			dbcommit($sql);
			$json["marking"]=$sql;
			$sql1 .= $sql;


			//출고정보등록
			$re_barcode="RED".$od_newcode;
			$sql=" insert into ".$dbH."_release (re_odcode, re_keycode, re_userid, re_barcode, re_sendtype, re_sendname, re_sendphone, re_sendmobile, re_sendzipcode, re_sendaddress, re_name, re_phone, re_delitype, re_mobile, re_zipcode, re_address, re_delidate, re_request, re_boxmedi, re_boxdeli, re_boxmediprice, re_boxmedibox, re_boxdeliprice, re_price, RE_PACKINGPRICE, re_box, re_status, re_use, re_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$re_barcode."','".$re_sendtype."', '".$re_sendName."','".$re_sendPhone."','".$re_sendMobile."','".$re_sendZipcode."','".$re_sendAddress."','".$re_name."','".$re_phone."','".$re_delitype."','".$re_mobile."','".$re_zipcode."','".$re_address."','".$re_delidate."','".$re_request."','".$re_boxmedi."','".$re_boxdeli."','".$re_boxmediprice."', '".$re_boxmedibox."', '".$re_boxdeliprice."', '".$re_price."', '".$packPrice."','".$re_box."',  'paid','Y',  sysdate) ";
			dbcommit($sql);
			$json["release"]=$sql;
			$sql1 .= $sql;

			//처방정보등록
			$sql=" insert into ".$dbH."_recipeuser (RC_SEQ, rc_code, rc_source, rc_userid, rc_title_".$language.", rc_medicine, rc_sweet, rc_status, rc_use, rc_date, rc_modify) values ((SELECT NVL(MAX(RC_SEQ),0)+1 FROM ".$dbH."_recipeuser),'".$rc_code."', '".$rc_source."', '".$od_userid."', '".$od_title."', '".$rc_medicine."', '".$rc_sweet."', 'paid', 'Y', sysdate, sysdate) ";
			dbcommit($sql);
			$json["recipeuser"]=$sql;
			$sql1 .= $sql;

			//재시작사유 
			$sql=" update ".$dbH."_order set od_restarttext='".$od_restarttext."', od_modify=sysdate where od_code='".$od_oldodcode."' ";
			dbcommit($sql);
			$json["order재시작"]=$sql;
			$sql1 .= $sql;
		}

		//----------------------------------------------------------------------------------
		//약재부족 상태값 바꾸자 - shortage : 약재부족 
		//----------------------------------------------------------------------------------
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
			$sql.=" where md_status = 'use' and md_use = 'Y' and md_code in (".$shortage."); ";
			//dbcommit($sql);
		}
		//----------------------------------------------------------------------------------



		$json["sql"]=$sql1;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
