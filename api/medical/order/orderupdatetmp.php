<?php		//주문하기(temp 말고)
		//$od_seq=$_GET["seq"];
		$json["ORDER_UPdATE"]=$od_seq;

		if($od_seq)
		{
			//처방한 데이터 뽑아서 각 테이블에 셋팅하자 !!! 
			$sql=" select ";
			$sql.=" od_code, od_keycode, od_medical, od_scription, od_staff, od_title, od_name ,od_gender, od_birth, od_feature, od_matype, od_chubcnt, od_packtype, od_packprice,  ";
			$sql.=" od_packcnt,od_packcapa,od_maprice,od_medicine,od_sweet,od_dcsugar, od_dcDry,od_dcRipen,od_dcJungtang, od_dctitle,od_dctime,od_dcspecial,od_dcwater,od_dcshape,od_dcbinders, ";
			$sql.=" od_dcfineness, od_resendname,od_resendphone,od_resendmobile,od_resendzipcode,od_resendaddress, ";
			$sql.=" od_dcmillingloss, od_dclossjewan, od_dcbindersliang, od_dccompleteliang, od_dccompletecnt,  od_dcprice, od_dcsterilized, od_dccooling, od_mrdesc, od_rename, od_rephone, ";
			$sql.=" od_remobile, od_rezipcode, od_readdress, od_delidate, od_delitype, od_reboxmedi, od_reboxmediprice, od_reboxmedibox, od_reboxdeli, od_reboxdeliprice, od_reprice, ";
			$sql.=" od_rebox,od_advice,od_request,od_delirequest,od_care,od_amount, od_amountdjmedi, od_amountokchart, od_resendtype, od_resendname, od_resendphone, od_resendmobile, od_resendzipcode, od_resendaddress ";
			$sql.=" from ".$dbH."_order_medical ";
			$sql.=" where od_seq = '".$od_seq."' ";
			$dt=dbone($sql);

			$od_code=$dt["od_code"];
			$od_keycode=$dt["od_keycode"];
			$od_userid=$dt["od_medical"];//한의원ID
			$od_staff=$dt["od_staff"];//한의사ID
			$od_title=$dt["od_title"];
			$rc_code=$dt["od_scription"];
			$rc_source="";//출처 
			
			$od_matype=$dt["od_matype"]; //조제타입 //20190610 추가 
			$od_chubcnt=$dt["od_chubcnt"];
			$od_packprice=$dt["od_packprice"];//파우치가격
			$od_packtype=$dt["od_packtype"];
			$od_packcnt=$dt["od_packcnt"];
			$od_packcapa=$dt["od_packcapa"];
			$ma_price=$dt["od_maprice"];//조제비//추가
			//약재 
			$rc_medicine = $dt["od_medicine"];
			$rc_medicine = str_replace(" ", "", $rc_medicine);
			//별전
			$rc_sweet=$dt["od_sweet"];
			$rc_sweet = str_replace(" ", "", $rc_sweet);

			$re_sendType=$dt["od_resendtype"];
			$re_sendName=$dt["od_resendname"];
			$re_sendPhone=$dt["od_resendphone"];
			$re_sendMobile=$dt["od_resendmobile"];
			$re_sendZipcode=$dt["od_resendzipcode"];
			$re_sendAddress=$dt["od_resendaddress"];

		

			$dc_sugar='HD99999_01';//$dt["od_dcsugar"];//감미제를 삭제 
			$dc_title=$dt["od_dctitle"];
			$dc_time=$dt["od_dctime"];
			$dc_special=$dt["od_dcspecial"];
			$dc_water=str_replace(",","",$dt["od_dcwater"]);
			$dc_shape=$dt["od_dcshape"]; //제형 
			$dc_binders=$dt["od_dcbinders"]; //결합제
			$dc_fineness=$dt["od_dcfineness"]; //분말도 
			$dc_millingloss=$dt["od_dcmillingloss"]; //제분손실
			$dc_lossjewan=$dt["od_dclossjewan"]; //제환손실
			$dc_bindersliang=$dt["od_dcbindersliang"]; //결합제
			$dc_completeliang=$dt["od_dccompleteliang"]; //완성량
			$dc_completecnt=$dt["od_dccompletecnt"]; //완성갯수 			
			$dc_price=$dt["od_dcprice"];//탕전비
			$dc_sterilized=$dt["od_dcsterilized"];
			$dc_cooling=$dt["od_dccooling"];
			$mr_desc=$dt["od_mrdesc"];
			$re_name=$dt["od_rename"];
			$re_phone=$dt["od_rephone"];
			$re_delitype=$dt["od_delitype"];
			$re_mobile=$dt["od_remobile"];
			$re_zipcode=$dt["od_rezipcode"];
			$re_address=$dt["od_readdress"];
			$re_delidate=$dt["od_delidate"];
			$re_boxmedi=$dt["od_reboxmedi"];
			$re_boxdeli=$dt["od_reboxdeli"];	
			$re_boxmedibox=$dt["od_reboxmedibox"];//한약박스50팩당1박스 
			$re_boxmediprice=$dt["od_reboxmediprice"];//한약박스가격
			$re_boxdeliprice=$dt["od_reboxdeliprice"];//배송포장재가격 
			$re_price=$dt["od_reprice"];//배송비
			$od_amount=$dt["od_amount"];
			$od_request=$dt["od_request"];//조제탕전요청사항 
			$od_care=$dt["od_care"];
			$od_advice=$dt["od_advice"];
			$re_request=$dt["od_delirequest"];//배송요청 사항 
			$re_box=$dt["od_rebox"];//100팩당1박스 

			//$od_name=$re_name;//환자명 
			$od_phone=$re_phone;
			$od_mobile=$re_mobile;
			$od_zipcode=$re_zipcode;
			$od_address=$re_address;

			//------------------------------------------
			//20190919 :: 환자명&성별&사상&생년월일 추가 
			$od_name=$dt["od_name"];
			$od_gender=$dt["od_gender"];
			$od_birth=$dt["od_birth"];
			$od_feature=$dt["od_feature"];
			//------------------------------------------

			$rc_seq=$dt["rcSeq"];
			//20190919 : 일단은 처방하기 하면 우리DB에 바로 저장 
			$os_status="order";
			//$os_status="paid";//결재완료(han_order_medical) & 작업대기 (han_order)

			$dc_jungtang=$dt["od_dcJungtang"];
			$dc_ripen=$dt["od_dcRipen"];
			$dc_dry=$dt["od_dcDry"];

			$od_amountdjmedi=$dt["od_amountdjmedi"];
			$od_amountokchart=$dt["od_amountokchart"];

			//주문정보업데이트
			$sql=" update ".$dbH."_order_medical set ";
			$sql.=" od_status='".$os_status."', od_modify=now() ";
			$sql.=" where od_seq='".$od_seq."' ";
			dbqry($sql);
			$json["medical"]=$sql;
			
			$od_sitecategory=($sitecategory) ? strtoupper($sitecategory) : "MEDICAL";
		
			//주문정보등록
			$sql=" insert into ".$dbH."_order (od_code, od_keycode, od_no, od_userid, od_sitecategory, od_scription ,od_staff ,od_title ,od_matype, od_chubcnt ,od_packtype ,od_packcnt ,od_packcapa ,od_name ,od_gender, od_birth, od_feature, od_phone ,od_mobile ,od_amount, od_amountdjmedi, od_amountokchart, od_zipcode ,od_address ,od_request ,od_care ,od_advice ,od_packprice, od_status ,od_use, od_date) values ('".$od_code."','".$od_keycode."','0','".$od_userid."', '".$od_sitecategory."', '".$rc_code."','".$od_staff."','".$od_title."','".$od_matype."','".$od_chubcnt."','".$od_packtype."','".$od_packcnt."','".$od_packcapa."','".$od_name."','".$od_gender."', '".$od_birth."','".$od_feature."','".$od_phone."','".$od_mobile."','".$od_amount."', '".$od_amountdjmedi."','".$od_amountokchart."', '".$od_zipcode."','".$od_address."','".$od_request."','".$od_care."','".$od_advice."', '".$od_packprice."', '".$os_status."','Y',now()) ";
			dbqry($sql);
			$json["order"]=$sql;


			//조제정보등록
			//han_making -> ma_medicine필드 제거 han_recipeuser 에 저장한다 
			$ma_barcode=str_replace("ODD", "MKD", $od_code);
			$ma_title=$od_title;
			$sql=" insert into ".$dbH."_making (ma_odcode, ma_keycode, ma_userid, ma_barcode, ma_title,  ma_price, ma_status, ma_use, ma_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$ma_barcode."','".$ma_title."','".$ma_price."', '".$os_status."', 'Y', now()) ";
			dbqry($sql);
			$json["making"]=$sql;

			//탕전정보등록
			$dc_barcode=str_replace("ODD", "DED", $od_code);
			$sql=" insert into ".$dbH."_decoction (dc_odcode, dc_keycode, dc_userid, dc_barcode, dc_dry, dc_ripen,dc_jungtang, dc_title, dc_time, dc_special, dc_water, dc_sterilized, dc_cooling, dc_sugar, dc_shape, dc_binders, dc_fineness,  dc_millingloss, dc_lossjewan, dc_bindersliang, dc_completeliang,dc_completecnt, dc_price, dc_status, dc_use, dc_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$dc_barcode."','".$dc_dry."','".$dc_ripen."','".$dc_jungtang."', '".$dc_title."','".$dc_time."','".$dc_special."','".$dc_water."','".$dc_sterilized."','".$dc_cooling."', '".$dc_sugar."','".$dc_shape."','".$dc_binders."','".$dc_fineness."','".$dc_millingloss."','".$dc_lossjewan."','".$dc_bindersliang."','".$dc_completeliang."','".$dc_completecnt."','".$dc_price."', '".$os_status."', 'Y', now()) ";
			dbqry($sql);
			$json["decoction"]=$sql;




			//마킹정보등록
			$mr_barcode=str_replace("ODD", "MRK", $od_code);
			$sql=" insert into ".$dbH."_marking (mr_odcode, mr_keycode, mr_userid, mr_printer, mr_barcode, mr_desc, mr_status, mr_date) values('".$od_code."','".$od_keycode."','".$od_userid."','','".$mr_barcode."','".$mr_desc."', '".$os_status."', now()) ";
			dbqry($sql);
			$json["marking"]=$sql;

			//출고정보등록
			$re_barcode=str_replace("ODD", "RED", $od_code);
			$sql=" insert into ".$dbH."_release (re_odcode, re_keycode, re_userid, re_barcode, re_sendtype, re_sendname, re_sendphone, re_sendmobile, re_sendzipcode, re_sendaddress, re_name, re_phone, re_delitype, re_mobile, re_zipcode, re_address, re_delidate, re_request, re_boxmedi, re_boxdeli, re_price, re_box, re_boxmedibox, re_boxmediprice, re_boxdeliprice, re_status, re_use, re_date) values('".$od_code."','".$od_keycode."','".$od_userid."','".$re_barcode."','".$re_sendType."','".$re_sendName."','".$re_sendPhone."','".$re_sendMobile."','".$re_sendZipcode."','".$re_sendAddress."','".$re_name."','".$re_phone."','".$re_delitype."','".$re_mobile."','".$re_zipcode."','".$re_address."','".$re_delidate."','".$re_request."','".$re_boxmedi."','".$re_boxdeli."','".$re_price."','".$re_box."','".$re_boxmedibox."','".$re_boxmediprice."','".$re_boxdeliprice."','".$os_status."', 'Y', now()) ";
			dbqry($sql);
			$json["release"]=$sql;

			//처방정보등록
			$sql=" insert into ".$dbH."_recipeuser (rc_code, rc_source, rc_userid, rc_title_".$language.", rc_medicine, rc_sweet, rc_status, rc_use, rc_date, rc_modify) values ('".$rc_code."', '".$rc_source."', '".$od_userid."', '".$od_title."', '".$rc_medicine."', '".$rc_sweet."', '".$os_status."', 'Y', now(), now()) ";
			dbqry($sql);
			$json["recipeuser"]=$sql;
		}	

?>
