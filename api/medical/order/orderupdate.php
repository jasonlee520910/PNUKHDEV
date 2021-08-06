<?php  /// 한퓨어 소스상으로는 사용하지 않는 페이지(결재를 어떻게 하느냐에 따라 처리하기)
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apicode!="orderupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="orderupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$od_seq=$_POST["seq"];
		$returnData=$_POST["returnData"];

		if($od_seq)
		{
			///처방한 데이터 뽑아서 각 테이블에 셋팅하자 !!! 
			$sql=" select ";
			$sql.=" od_code, od_keycode, od_medical, od_scription, od_staff, od_title,  od_matype, od_chubcnt, od_packtype, od_packprice,  ";
			$sql.=" od_packcnt,od_packcapa,od_maprice,od_medicine,od_sweet,od_dcsugar, od_dcDry,od_dcRipen,od_dcJungtang, od_dctitle,od_dctime,od_dcspecial,od_dcwater,od_dcshape,od_dcbinders, ";
			$sql.=" od_dcfineness, od_resendname,od_resendphone,od_resendmobile,od_resendzipcode,od_resendaddress, ";
			$sql.=" od_dcmillingloss, od_dclossjewan, od_dcbindersliang, od_dccompleteliang, od_dccompletecnt,  od_dcprice, od_dcsterilized, od_dccooling, od_mrdesc, od_rename, od_rephone, ";
			$sql.=" od_remobile, od_rezipcode, od_readdress, od_delidate, od_delitype, od_reboxmedi, od_reboxmediprice, od_reboxmedibox, od_reboxdeli, od_reboxdeliprice, od_reprice, ";
			$sql.=" od_rebox,od_advice,od_request,od_delirequest,od_care,od_amount, od_amountdjmedi, od_amountokchart, od_resendtype, od_resendname, od_resendphone, od_resendmobile, od_resendzipcode, od_resendaddress ";
			$sql.=" from ".$dbH."_order_medical ";
			$sql.=" where od_seq = '".$od_seq."' ";
			$dt=dbone($sql);

			$od_code=$dt["OD_CODE"];
			$od_keycode=$dt["OD_KEYCODE"];
			$od_userid=$dt["OD_MEDICAL"];///한의원ID
			$od_staff=$dt["OD_STAFF"];///한의사ID
			$od_title=$dt["OD_TITLE"];
			$rc_code=$dt["OD_SCRIPTION"];
			$rc_source="";///출처 
			
			$od_matype=$dt["OD_MATYPE"]; ///조제타입 ///20190610 추가 
			$od_chubcnt=$dt["OD_CHUBCNT"];
			$od_packprice=$dt["OD_PACKPRICE"];///파우치가격
			$od_packtype=$dt["OD_PACKTYPE"];
			$od_packcnt=$dt["OD_PACKCNT"];
			$od_packcapa=$dt["OD_PACKCAPA"];
			$ma_price=$dt["OD_MAPRICE"];///조제비///추가
			///약재 
			$rc_medicine = $dt["OD_MEDICINE"];
			$rc_medicine = str_replace(" ", "", $rc_medicine);
			///별전
			$rc_sweet=$dt["OD_SWEET"];
			$rc_sweet = str_replace(" ", "", $rc_sweet);

			$re_sendType=$dt["OD_RESENDTYPE"];
			$re_sendName=$dt["OD_RESENDNAME"];
			$re_sendPhone=$dt["OD_RESENDPHONE"];
			$re_sendMobile=$dt["OD_RESENDMOBILE"];
			$re_sendZipcode=$dt["OD_RESENDZIPCODE"];
			$re_sendAddress=$dt["OD_RESENDADDRESS"];

			

			$dc_sugar=$dt["OD_DCSUGAR"];
			$dc_title=$dt["OD_DCTITLE"];
			$dc_time=$dt["OD_DCTIME"];
			$dc_special=$dt["OD_DCSPECIAL"];
			$dc_water=str_replace(",","",$dt["OD_DCWATER"]);
			$dc_shape=$dt["OD_DCSHAPE"]; ///제형 
			$dc_binders=$dt["OD_DCBINDERS"]; ///결합제
			$dc_fineness=$dt["OD_DCFINENESS"]; ///분말도 
			$dc_millingloss=$dt["OD_DCMILLINGLOSS"]; ///제분손실
			$dc_lossjewan=$dt["OD_DCLOSSJEWAN"]; ///제환손실
			$dc_bindersliang=$dt["OD_DCBINDERSLIANG"]; ///결합제
			$dc_completeliang=$dt["OD_DCCOMPLETELIANG"]; ///완성량
			$dc_completecnt=$dt["OD_DCCOMPLETECNT"]; ///완성갯수 			
			$dc_price=$dt["OD_DCPRICE"];///탕전비
			$dc_sterilized=$dt["OD_DCSTERILIZED"];
			$dc_cooling=$dt["OD_DCCOOLING"];
			$mr_desc=$dt["OD_MRDESC"];
			$re_name=$dt["OD_RENAME"];
			$re_phone=$dt["OD_REPHONE"];
			$re_delitype=$dt["OD_DELITYPE"];
			$re_mobile=$dt["OD_REMOBILE"];
			$re_zipcode=$dt["OD_REZIPCODE"];
			$re_address=$dt["OD_READDRESS"];
			$re_delidate=$dt["OD_DELIDATE"];
			$re_boxmedi=$dt["OD_REBOXMEDI"];
			$re_boxdeli=$dt["OD_REBOXDELI"];	
			$re_boxmedibox=$dt["OD_REBOXMEDIBOX"];///한약박스50팩당1박스 
			$re_boxmediprice=$dt["OD_REBOXMEDIPRICE"];///한약박스가격
			$re_boxdeliprice=$dt["OD_REBOXDELIPRICE"];///배송포장재가격 
			$re_price=$dt["OD_REPRICE"];///배송비
			$od_amount=$dt["OD_AMOUNT"];
			$od_request=$dt["OD_REQUEST"];///조제탕전요청사항 
			$od_care=$dt["OD_CARE"];
			$od_advice=$dt["OD_ADVICE"];
			$re_request=$dt["OD_DELIREQUEST"];///배송요청 사항 
			$re_box=$dt["OD_REBOX"];///100팩당1박스 

			$od_name=$re_name;///환자명 
			$od_phone=$re_phone;
			$od_mobile=$re_mobile;
			$od_zipcode=$re_zipcode;
			$od_address=$re_address;

			$rc_seq=$dt["RCSEQ"];
			$os_status="paid";///결재완료(han_order_medical) & 작업대기 (han_order)

			$dc_jungtang=$dt["OD_DCJUNGTANG"];
			$dc_ripen=$dt["OD_DCRIPEN"];
			$dc_dry=$dt["OD_DCDRY"];

			$od_amountdjmedi=$dt["OD_AMOUNTDJMEDI"];
			$od_amountokchart=$dt["OD_AMOUNTOKCHART"];

			///주문정보업데이트
			$sql=" update ".$dbH."_order_medical set ";
			$sql.=" od_status='".$os_status."', od_modify=sysdate ";
			$sql.=" where od_seq='".$od_seq."' ";
			dbqry($sql);
			$json["medical"]=$sql;
			
			$od_sitecategory=($sitecategory) ? strtoupper($sitecategory) : "MEDICAL";
		
			///주문정보등록
			$sql=" insert into ".$dbH."_order (od_seq,od_code, od_keycode, od_no, od_userid, od_sitecategory, od_scription ,od_staff ,od_title ,od_matype, od_chubcnt ,od_packtype ,od_packcnt ,od_packcapa ,od_name ,od_phone ,od_mobile ,od_amount, od_amountdjmedi, od_amountokchart, od_zipcode ,od_address ,od_request ,od_care ,od_advice ,od_packprice, od_status ,od_use, od_date) ";
			$sql.=" values ((SELECT NVL(MAX(od_seq),0)+1 FROM ".$dbH."_order),'".$od_code."','".$od_keycode."','0','".$od_userid."', '".$od_sitecategory."', '".$rc_code."','".$od_staff."','".$od_title."','".$od_matype."','".$od_chubcnt."','".$od_packtype."','".$od_packcnt."','".$od_packcapa."','".$od_name."','".$od_phone."','".$od_mobile."','".$od_amount."', '".$od_amountdjmedi."','".$od_amountokchart."', '".$od_zipcode."','".$od_address."','".$od_request."','".$od_care."','".$od_advice."', '".$od_packprice."', '".$os_status."','Y',sysdate) ";
			dbcommit($sql);
			$json["order"]=$sql;


			///조제정보등록
			///han_making -> ma_medicine필드 제거 han_recipeuser 에 저장한다 
			$ma_barcode=str_replace("ODD", "MKD", $od_code);
			$ma_title=$od_title;
			$sql=" insert into ".$dbH."_making (ma_odcode, ma_keycode, ma_userid, ma_barcode, ma_title,  ma_price, ma_status, ma_use, ma_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$ma_barcode."','".$ma_title."','".$ma_price."', '".$os_status."', 'Y', sysdate) ";
			dbcommit($sql);
			$json["making"]=$sql;

			///탕전정보등록
			$dc_barcode=str_replace("ODD", "DED", $od_code);
			$sql=" insert into ".$dbH."_decoction (dc_odcode, dc_keycode, dc_userid, dc_barcode, dc_dry, dc_ripen,dc_jungtang, dc_title, dc_time, dc_special, dc_water, dc_sterilized, dc_cooling, dc_sugar, dc_shape, dc_binders, dc_fineness,  dc_millingloss, dc_lossjewan, dc_bindersliang, dc_completeliang,dc_completecnt, dc_price, dc_status, dc_use, dc_date) ";
			$sql.=" values('".$od_code."','".$od_keycode."','".$od_userid."','".$dc_barcode."','".$dc_dry."','".$dc_ripen."','".$dc_jungtang."', '".$dc_title."','".$dc_time."','".$dc_special."','".$dc_water."','".$dc_sterilized."','".$dc_cooling."', '".$dc_sugar."','".$dc_shape."','".$dc_binders."','".$dc_fineness."','".$dc_millingloss."','".$dc_lossjewan."','".$dc_bindersliang."','".$dc_completeliang."','".$dc_completecnt."','".$dc_price."', '".$os_status."', 'Y', sysdate) ";
			dbcommit($sql);
			$json["decoction"]=$sql;




			///마킹정보등록
			$mr_barcode=str_replace("ODD", "MRK", $od_code);
			$sql=" insert into ".$dbH."_marking (mr_odcode, mr_keycode, mr_userid, mr_barcode, mr_desc, mr_status, mr_date)  ";
			$sql.=" values('".$od_code."','".$od_keycode."','".$od_userid."','".$mr_barcode."','".$mr_desc."', '".$os_status."', sysdate) ";
			dbcommit($sql);
			$json["marking"]=$sql;

			///출고정보등록
			$re_barcode=str_replace("ODD", "RED", $od_code);
			$sql=" insert into ".$dbH."_release (re_odcode, re_keycode, re_userid, re_barcode, re_sendtype, re_sendname, re_sendphone, re_sendmobile, re_sendzipcode, re_sendaddress, re_name, re_phone, re_delitype, re_mobile, re_zipcode, re_address, re_delidate, re_request, re_boxmedi, re_boxdeli, re_price, re_box, re_boxmedibox, re_boxmediprice, re_boxdeliprice, re_status, re_use, re_date) ";
			$sql.=" values('".$od_code."','".$od_keycode."','".$od_userid."','".$re_barcode."','".$re_sendType."','".$re_sendName."','".$re_sendPhone."','".$re_sendMobile."','".$re_sendZipcode."','".$re_sendAddress."','".$re_name."','".$re_phone."','".$re_delitype."','".$re_mobile."','".$re_zipcode."','".$re_address."','".$re_delidate."','".$re_request."','".$re_boxmedi."','".$re_boxdeli."','".$re_price."','".$re_box."','".$re_boxmedibox."','".$re_boxmediprice."','".$re_boxdeliprice."','".$os_status."', 'Y', sysdate) ";
			dbcommit($sql);
			$json["release"]=$sql;

			///처방정보등록
			$sql=" insert into ".$dbH."_recipeuser (rc_seq,rc_code, rc_source, rc_userid, rc_title_".$language.", rc_medicine, rc_sweet, rc_status, rc_use, rc_date, rc_modify) ";
			$sql.=" values ((SELECT NVL(MAX(rc_seq),0)+1 FROM ".$dbH."_recipeuser),'".$rc_code."', '".$rc_source."', '".$od_userid."', '".$od_title."', '".$rc_medicine."', '".$rc_sweet."', '".$os_status."', 'Y', sysdate, sysdate) ";
			dbcommit($sql);
			$json["recipeuser"]=$sql;
		}	

		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;		
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
