<?php
	///TMPS > 수기처방 > 처방하기 
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apicode!="chartupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="chartupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$od_seq=$_POST["seq"];
		$od_code=$_POST["odCode"];
		$od_keycode=$_POST["odKeycode"];
		$od_date=$_POST["odDate"];
		
		$od_save=$_POST["save"]; ///임시저장인지 체크 

		$re_delidate=$_POST["reDelidate"];

		$od_userid=$_POST["odMedical"];///한의원ID
		$od_staff=$_POST["odStaff"];///한의사ID
		$od_title=$_POST["odTitle"];
		$od_chubcnt=$_POST["odChubcnt"];
		$od_packtype=$_POST["odPacktype"];
		$od_packcnt=$_POST["odPackcnt"];
		$od_packcapa=$_POST["odPackcapa"];
		$os_status=$_POST["odStatus"];
		$od_amount=$_POST["odAmount"];

		$dc_title=$_POST["dcTitle"];
		$dc_time=$_POST["dcTime"];
		$dc_special=$_POST["dcSpecial"];
		$dc_water=str_replace(",","",$_POST["dcWater"]);
		$dc_sterilized=$_POST["dcSterilized"];
		$dc_cooling=$_POST["dcCooling"];

		$mr_desc=$_POST["mrDesc"];

		$re_name=$_POST["reName"];
		$re_phone=$_POST["rePhone"];
		$re_delitype=$_POST["reDelitype"];
		$re_mobile=$_POST["reMobile"];
		$re_zipcode=$_POST["reZipcode"];
		$re_address=$_POST["reAddress"].'||'.$_POST["reAddress1"];
		$re_request=$_POST["reRequest"];///배송요청 사항 

		$od_request=$_POST["odRequest"];///조제탕전요청사항 
		$od_care=$_POST["odCare"];
		$od_advice=$_POST["odAdvice"];

		$dc_sugar=$_POST["dcSugar"];///감미제 

		$re_boxmedi=$_POST["reBoxmedi"];
		$re_boxdeli=$_POST["reBoxdeli"];


		$medipricetotal=$_POST["medipricetotal"];///총약재비
		$sweettotal=$_POST["sweettotal"];///별전
		$dcSugartotal=$_POST["dcSugartotal"];///감미제 
		$makingprice=$_POST["makingprice"];///조제비
		$decoctionprice=$_POST["decoctionprice"];///탕전비
		$packprice=$_POST["packprice"];///포장비
		$boxprice=$_POST["boxprice"];///배송비 
		

		$rc_seq=$_POST["rcSeq"];
		///------------------------------------------------------------
		/// DOO :: 약재정보 빈공간 삭제 
		///------------------------------------------------------------
		$rc_medicine = $_POST["rcMedicine"];
		$rc_medicine = str_replace(" ", "", $rc_medicine);
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

		///추가
		$ma_price=$_POST["maPrice"];///조제비
		$dc_price=$_POST["dcPrice"];///탕전비
		$od_packprice=$_POST["odPackprice"];///파우치가격

		$re_price=$_POST["rePrice"];///배송비
		$re_box=$_POST["reBox"];///100팩당1박스 
		$re_boxmedibox=$_POST["reBoxmedibox"];///한약박스50팩당1박스 
		$re_boxmediprice=$_POST["reBoxmediprice"];///한약박스가격
		$re_boxdeliprice=$_POST["reBoxdeliprice"];///배송포장재가격 

		///20190610 추가 
		$od_matype=$_POST["maType"]; ///조제타입 

		$dc_shape=$_POST["dcShape"]; ///제형 
		$dc_binders=$_POST["dcBinders"]; ///결합제
		
		///$dc_terms=$_POST["dcTerms"]; ///탕전조건 
		$dc_millingloss=$_POST["dcMillingloss"]; ///제분손실
		$dc_lossjewan=$_POST["dcLossjewan"]; ///제환손실
		$dc_bindersliang=$_POST["dcBindersliang"]; ///결합제
		$dc_completeliang=$_POST["dcCompleteliang"]; ///완성량
		$dc_completecnt=$_POST["dcCompletecnt"]; ///완성갯수 

		
		$dc_jungtang=$_POST["dcJungtang"];
		$dc_jungtang=($dc_jungtang) ? $dc_jungtang : "N";
		$dc_ripen=$_POST["dcRipen"];
		$dc_dry=$_POST["dcDry"];

		if($od_matype=="jewan")///제환
		{
			$dc_fineness=$_POST["dcFineness"]; ///분말도 
		}
		else if($od_matype=="edextract")///농축엑기스 
		{
			$dc_fineness=$_POST["edcFineness"]; ///분말도 
		}
		else
		{
			$dc_fineness="";
		}
		
		///보내는사람 
		$re_sendType=$_POST["reSendType"];
		$re_sendName=$_POST["reSendName"];
		$re_sendPhone=$_POST["reSendPhone"];
		$re_sendMobile=$_POST["reSendMobile"];
		$re_sendZipcode=$_POST["reSendZipcode"];
		$re_sendAddress=$_POST["reSendAddress"]."||".$_POST["reSendAddress1"];
		
		if($od_save!="temp")
		{
			$os_status="charted";///처방완료 
		}
		else
		{
			$os_status="charted_temp";///임시저장 
		}
		$returnData=$_POST["returnData"];

		///20190801 주문금액 json data 
		$od_amountdjmedi=$_POST["odAmountdjmedi"];
		$od_amountokchart=$_POST["odAmountokchart"];

		if($od_seq)
		{
			///주문정보업데이트
			$sql=" update ".$dbH."_order_medical set ";
			$sql.=" od_matype='".$od_matype."', od_userid='".$od_userid."',od_packprice='".$od_packprice."' ";
			$sql.=" ,od_staff='".$od_staff."',od_title='".$od_title."',od_chubcnt='".$od_chubcnt."' ";
			$sql.=" ,od_packtype='".$od_packtype."',od_packcnt='".$od_packcnt."',od_packcapa='".$od_packcapa."',od_request='".$od_request."' ";
			$sql.=" ,od_amount='".$od_amount."' ";
			$sql.=" ,od_advice='".$od_advice."',od_care='".$od_care."',od_status='".$os_status."',od_modify=sysdate ";
			$sql.=" ,od_maprice='".$ma_price."' ";
			$sql.=" ,od_dcsugar='".$dc_sugar."', od_amountdjmedi='".$od_amountdjmedi."', od_amountokchart='".$od_amountokchart."' ";
			$sql.=" ,od_resendtype='".$re_sendType."', od_resendname='".$re_sendName."' ";
			$sql.=" ,od_resendphone='".$re_sendPhone."', od_resendmobile='".$re_sendMobile."', od_resendzipcode='".$re_sendZipcode."' ";
			$sql.=" ,od_resendaddress='".$re_sendAddress."' ";
			$sql.=" ,od_dcJungtang='".$dc_jungtang."', od_dcRipen='".$dc_ripen."',od_dcDry='".$dc_dry."'  ";
			$sql.=" ,od_dctitle='".$dc_title."',od_dcprice='".$dc_price."', od_dctime='".$dc_time."',od_dcspecial='".$dc_special."',od_dcwater='".$dc_water."' ";
			$sql.=" ,od_dcsterilized='".$dc_sterilized."',od_dccooling='".$dc_cooling."', od_dcshape='".$dc_shape."', od_dcbinders='".$dc_binders."' ";
			$sql.=" ,od_dcfineness='".$dc_fineness."' ";
			$sql.=" ,od_dcmillingloss='".$dc_millingloss."', od_dclossjewan='".$dc_lossjewan."', od_dcbindersliang='".$dc_bindersliang."' ";
			$sql.=" ,od_dccompleteliang='".$dc_completeliang."', od_dccompletecnt='".$dc_completecnt."', od_mrdesc='".$mr_desc."' ";
			$sql.=" ,od_reprice='".$re_price."',od_rebox='".$re_box."', od_reboxmedibox='".$re_boxmedibox."' ";
			$sql.=" ,od_reboxmediprice='".$re_boxmediprice."',od_reboxdeliprice='".$re_boxdeliprice."' ";
			$sql.=" ,od_rename='".$re_name."',od_rephone='".$re_phone."',od_delitype='".$re_delitype."',od_remobile='".$re_mobile."' ";
			$sql.=" ,od_rezipcode='".$re_zipcode."',od_readdress='".$re_address."' ";
			$sql.=" ,od_delidate='".$re_delidate."',od_delirequest='".$re_request."',od_reboxmedi='".$re_boxmedi."',od_reboxdeli='".$re_boxdeli."' ";
			$sql.=" ,od_medicine='".$rc_medicine."', od_sweet='".$rc_sweet."' ";
			$sql.=" where od_seq='".$od_seq."' ";
			$json["ordermedical"]=$sql;
			dbcommit($sql);

/*
update han_order_medical set  od_matype='decoction', od_userid='0319326783',od_packprice='250', od_staff='0319326783',od_title='약2',od_chubcnt='20'  ,od_packtype='PCB190817170225',od_packcnt='45',od_packcapa='120',od_request='', od_amount='23900'  ,od_advice='-',od_care='care01_2',od_status='charted_temp',od_modify=sysdate  ,od_maprice='140'  ,od_dcsugar='HD99999_01', od_amountdjmedi='{"medicine":"62,20,1250","sweet":"","sugar":"0,0,0","totalmedicine":1250,"decoction":"12000,1,12000","making":"140,45,6300","poutch":"250,1,250","medibox":"250,1,250","delibox":"0,1,0","dcshape":"0,1,0","totalpack":500,"release":"3850,1,3850","totalamount":23900}', od_amountokchart=''  ,od_resendtype='medical', od_resendname='서울한의원'  ,od_resendphone='010-9999-8888', od_resendmobile='010-5555-1212', od_resendzipcode='04547', od_resendaddress='서울특별시 중구 마른내로 115-1 (오장동)||123'  ,od_dcJungtang='N', od_dcRipen='0',od_dcDry='0'   ,od_dctitle='decoctype03',od_dcprice='12000', od_dctime='120',od_dcspecial='spdecoc01',od_dcwater='6830'  ,od_dcsterilized='',od_dccooling='', od_dcshape='', od_dcbinders='', od_dcfineness=''  ,od_dcmillingloss='0', od_dclossjewan='0', od_dcbindersliang='0'  ,od_dccompleteliang='0', od_dccompletecnt='0', od_mrdesc='marking04'  ,od_reprice='3850',od_rebox='', od_reboxmedibox='60',od_reboxmediprice='250',od_reboxdeliprice='0'  ,od_rename='서울한의원',od_rephone='010-9999-8888',od_delitype='medicalreceive',od_remobile='010-5555-4444',od_rezipcode='04547',od_readdress='서울특별시 중구 마른내로 115-1 (오장동)||123'  ,od_delidate='2020-05-19',od_delirequest='약2',od_reboxmedi='RBM200311180618',od_reboxdeli='RBD190710182024'  ,od_medicine='|HD10869_02,1.00,inmain,5|HD10363_04,2.00,inmain,10|HD10229_07,3,inmain,12.5', od_sweet=''  ,od_gender = 'none', od_name = '영희',od_birth = '', od_feature = '140'  where od_seq='1' 
*/
		}
		else
		{
			///코드변경  날짜 =>  180702 + 00000 + 0000 + 0
			$datecode=date("YmdHis");

			$keyCodeLast = getkeyCodeLast($datecode);
			$od_code="ODD".$datecode.$keyCodeLast;
			$od_keycode=$datecode.$keyCodeLast;///intval(substr(microtime(),0,4)*100);
			$rc_code="RC".$datecode.$keyCodeLast;

			///$od_date=date("Y-m-d H:i:s");  -> sysdate로 수정

			$sql=" insert into ".$dbH."_order_medical (od_seq,od_code, od_keycode, od_medical, od_userid, od_scription, od_staff, od_title,  od_matype, od_chubcnt, od_packtype, od_packprice,  od_packcnt,od_packcapa,od_maprice,od_medicine,od_sweet,od_dcsugar, od_dcDry, od_dcRipen, od_dcJungtang, od_dctitle,od_dctime,od_dcspecial,od_dcwater,od_dcshape,od_dcbinders, od_dcfineness, od_dcmillingloss, od_dclossjewan, od_dcbindersliang, od_dccompleteliang, od_dccompletecnt, od_dcprice, od_dcsterilized, od_dccooling, od_mrdesc, od_resendtype, od_resendname,od_resendphone,od_resendmobile,od_resendzipcode,od_resendaddress,od_rename, od_rephone, od_remobile, od_rezipcode, od_readdress, od_delidate, od_delitype, od_reboxmedi, od_reboxmediprice, od_reboxmedibox, od_reboxdeli, od_reboxdeliprice, od_reprice, od_rebox,od_advice,od_request,od_delirequest,od_care,od_amount, od_amountdjmedi, od_amountokchart,od_status, od_use, od_date) values ((SELECT NVL(MAX(od_seq),0)+1 FROM ".$dbH."_order_medical),'".$od_code."','".$od_keycode."','".$od_userid."','".$od_userid."','".$rc_code."','".$od_staff."','".$od_title."','".$od_matype."','".$od_chubcnt."','".$od_packtype."','".$od_packprice."','".$od_packcnt."','".$od_packcapa."','".$ma_price."','".$rc_medicine."','".$rc_sweet."','".$dc_sugar."', '".$dc_dry."','".$dc_ripen."','".$dc_jungtang."','".$dc_title."','".$dc_time."','".$dc_special."','".$dc_water."','".$dc_shape."','".$dc_binders."','".$dc_fineness."','".$dc_millingloss."','".$dc_lossjewan."','".$dc_bindersliang."','".$dc_completeliang."','".$dc_completecnt."','".$dc_price."','".$dc_sterilized."','".$dc_cooling."', '".$mr_desc."', '".$re_sendType."', '".$re_sendName."','".$re_sendPhone."','".$re_sendMobile."','".$re_sendZipcode."','".$re_sendAddress."','".$re_name."','".$re_phone."','".$re_mobile."','".$re_zipcode."','".$re_address."','".$re_delidate."','".$re_delitype."','".$re_boxmedi."','".$re_boxmediprice."','".$re_boxmedibox."','".$re_boxdeli."','".$re_boxdeliprice."','".$re_price."','".$re_box."','".$od_advice."','".$od_request."', '".$re_request."','".$od_care."','".$od_amount."','".$od_amountdjmedi."','".$od_amountokchart."','".$os_status."','Y', sysdate) ";
			$json["ordermedical"]=$sql;
			dbqry($sql);

/*
		 insert into han_order_medical (od_seq,od_code, od_keycode, od_medical, od_userid, od_scription, od_staff, od_title, od_name ,od_gender, od_birth, od_feature, od_matype, od_chubcnt, od_packtype, od_packprice,  od_packcnt,od_packcapa,od_maprice,od_medicine,od_sweet,od_dcsugar, od_dcDry, od_dcRipen, od_dcJungtang, od_dctitle,od_dctime,od_dcspecial,od_dcwater,od_dcshape,od_dcbinders, od_dcfineness, od_dcmillingloss, od_dclossjewan, od_dcbindersliang, od_dccompleteliang, od_dccompletecnt, od_dcprice, od_dcsterilized, od_dccooling, od_mrdesc, od_resendtype, od_resendname,od_resendphone,od_resendmobile,od_resendzipcode,od_resendaddress,od_rename, od_rephone, od_remobile, od_rezipcode, od_readdress, od_delidate, od_delitype, od_reboxmedi, od_reboxmediprice, od_reboxmedibox, od_reboxdeli, od_reboxdeliprice, od_reprice, od_rebox,od_advice,od_request,od_delirequest,od_care,od_amount, od_amountdjmedi, od_amountokchart,od_status, od_use, od_date) values ((SELECT NVL(MAX(cd_seq),0)+1 FROM han_code),'ODD2020051916261200001','2020051916261200001','0319326783','0319326783','RC2020051916261200001','0319326783','처방명','나환자','female', '1984-06-21','130','decoction','20','PCB191023181229','250','45','120','140','|HD10229_07,1.00,inmain,12.5|HD10869_02,2.00,inmain,5','','HD99999_01', '0','0','N','decoctype03','120','spdecoc01','6790','','','','0','0','0','0','0','12000','','', 'marking04', 'medical', '서울한의원','010-9999-8888','010-5555-1212','04547','서울특별시 중구 마른내로 115-1 (오장동)||123','서울한의원','010-9999-8888','010-5555-4444','04547','서울특별시 중구 마른내로 115-1 (오장동)||123','2020-05-19','medicalreceive','RBM200311180618','','60','RBD190710182024','','3850','','-','', '처방명','care01_2','23100','{"medicine":"22,20,450","sweet":"","sugar":"0,0,0","totalmedicine":450,"decoction":"12000,1,12000","making":"140,45,6300","poutch":"250,1,250","medibox":"250,1,250","delibox":"0,1,0","dcshape":"0,1,0","totalpack":500,"release":"3850,1,3850","totalamount":23100}','','charted_temp','Y', sysdate) 

*/

		}

		if($od_save!="temp")
		{
			///-----------------------------------------------------------------------------------------
			///한의원과 한의사 이름 가져오기 
			///-----------------------------------------------------------------------------------------
			$msql=" select a.me_name, b.mi_name from  ".$dbH."_member a inner join ".$dbH."_medical b on b.mi_userid=a.me_company where a.me_userid='".$od_staff."' ";
			$mdt=dbone($msql);
			$meName=$mdt["ME_NAME"];///한의사이름
			$miName=$mdt["MI_NAME"];///한의원명 
			///-----------------------------------------------------------------------------------------

			///-----------------------------------------------------------------------------------------
			///약재
			///-----------------------------------------------------------------------------------------
			///|HD10156_01,20.0,inmain,18.7|HD10300_01,8.0,inmain,18.7|HD10396_01,8.0,inmain,23.1|HD10261_07,8.0,inmain,27.5|HD10093_01,8.0,inmain,9.9|HD10061_05,8.0,inmain,11|HD10096_09,8.0,inmain,26.4
			$arr=explode("|",$rc_medicine);
			$medicode="";
			for($i=1;$i<count($arr);$i++)
			{
				$arr2=explode(",",$arr[$i]);
				$newmdcode=getNewMediCode($arr2[0]);

				if($i>1)$medicode.=",";
				$medicode.="'".$newmdcode."'";

				$mediCapa[$newmdcode]=($arr2[1]) ? $arr2[1] : 0;///첩당용량 
				$mediAmount[$newmdcode]=($arr2[3]) ? $arr2[3] : 0;///첩당가격  
			}
			if(substr($medicode,0, 1)==",")
			{
				$medicode=substr($medicode,1);
			}


			///|약재코드, 약재명, 원산지, 약재용 량, 약재금액
			///|HB_10001,건강,한 국,12.5,29|HB_10001,건강,한 국,12.5,29|HB_10001,건강,한 국,12.5,29|HB_10001,건강,한 국,12.5,29|HB_10001,건강,한 국,12.5,29|HB_10001,건강,한 
			$mssql=" select ";
			$mssql.=" a.md_code, a.md_title_".$language." mdTitle, b.mm_title_".$language." mmTitle, a.md_origin_".$language." mdOrigin ";
			$mssql.=" from ".$dbH."_medicine a ";
			$mssql.=" left join ".$dbH."_medicine_djmedi b on b.md_code=a.md_code ";
			$mssql.=" where a.md_use='Y' and a.md_code in (".$medicode.") ";
			$msres=dbqry($mssql);
			$medicineInfo="";
			while($msdt=dbarr($msres))
			{
				$mediName[$msdt["MD_CODE"]]=($msdt["MMTITLE"]) ? $msdt["MMTITLE"] : $msdt["MDTITLE"];
				$mediOrigin[$msdt["MD_CODE"]]=$msdt["MDORIGIN"];

				$medicineInfo.="|".$msdt["MD_CODE"].",".$mediName[$msdt["MD_CODE"]].",".$mediOrigin[$msdt["MD_CODE"]].",".$mediCapa[$msdt["MD_CODE"]].",".$mediAmount[$msdt["MD_CODE"]];
			}
				
			///-----------------------------------------------------------------------------------------
			///별전
			///-----------------------------------------------------------------------------------------
			$arr=explode("|",$rc_sweet);
			$sweetcode="";
			for($i=1;$i<count($arr);$i++)
			{
				$arr2=explode(",",$arr[$i]);
				$newmdcode=getNewMediCode($arr2[0]);

				if($i>1)$sweetcode.=",";
				$sweetcode.="'".$newmdcode."'";

				$mediCapa[$newmdcode]=($arr2[1]) ? $arr2[1] : 0;///첩당용량 
				$mediAmount[$newmdcode]=($arr2[3]) ? $arr2[3] : 0;///첩당가격  
			}
			if(substr($sweetcode,0, 1)==",")
			{
				$sweetcode=substr($sweetcode,1);
			}
			$sssql=" select ";
			$sssql.=" a.md_code, a.md_title_".$language." mdTitle, b.mm_title_".$language." mmTitle, a.md_origin_".$language." as MDORIGIN ";
			$sssql.=" from ".$dbH."_medicine a ";
			$sssql.=" left join ".$dbH."_medicine_djmedi b on b.md_code=a.md_code ";
			$sssql.=" where a.md_use='Y' and a.md_code in (".$sweetcode.") ";
			$ssres=dbqry($sssql);
			$sweetInfo="";
			while($ssdt=dbarr($ssres))
			{
				$mediName[$ssdt["MD_CODE"]]=($ssdt["MMTITLE"]) ? $ssdt["MMTITLE"] : $ssdt["MDTITLE"];
				$mediOrigin[$ssdt["MD_CODE"]]=$ssdt["MDORIGIN"];

				$sweetInfo.="|".$ssdt["MD_CODE"].",".$mediName[$ssdt["MD_CODE"]].",".$mediOrigin[$ssdt["MD_CODE"]].",".$mediCapa[$ssdt["MD_CODE"]].",".$mediAmount[$ssdt["MD_CODE"]];
			}
				
			///감미제 
			///dc_sugar
			$susql=" select ";
			$susql.=" a.md_code, a.md_title_".$language." mdTitle, b.mm_title_".$language." mmTitle, a.md_origin_".$language." mdOrigin ";
			$susql.=" from ".$dbH."_medicine a ";
			$susql.=" left join ".$dbH."_medicine_djmedi b on b.md_code=a.md_code ";
			$susql.=" where a.md_use='Y' and a.md_code = '".$dc_sugar."' ";
			$sures=dbqry($susql);
			$addmedicineInfo="";
			while($sudt=dbarr($sures))
			{
				$mediName[$sudt["MD_CODE"]]=($sudt["MMTITLE"]) ? $sudt["MMTITLE"] : $sudt["MDTITLE"];
				$mediOrigin[$sudt["MD_CODE"]]=$sudt["MDORIGIN"];

				$addmedicineInfo.="|".$sudt["MD_CODE"].",".$mediName[$sudt["MD_CODE"]].",".$mediOrigin[$sudt["MD_CODE"]].",1,".$dcSugartotal;
			}

			///-----------------------------------------------------------------------------------------
			$paymentStauts="request";

			$hoisql=" ('".$od_code."', '".$od_date."', '".$od_userid."', '".$miName."', '".$od_staff."', '".$meName."', '".$od_title."', '".$od_chubcnt."', '".$medicineInfo."', '".$addmedicineInfo."', '".$sweetInfo."', '".$od_amount."', '".$medipricetotal."', '".$dcSugartotal."', '".$sweettotal."', '".$makingprice."', '".$decoctionprice."', '".$packprice."', '".$boxprice."', '".$paymentStauts."', sysdate) ";

	/*

			///한퓨어DB에 넣을 데이터 말기 
			///orderInfo 
			$oisql=" ('".$od_keycode."','".$od_code."','".$od_date."','".$re_delidate."','".$od_userid."','".$miName."','".$od_staff."','".$meName."', '".$od_title."', '".$od_matype."', '".$od_chubcnt."', '".$od_packcnt."', '".$od_packcapa."', '0', '".$os_status."', sysdate) ";
			
			///deliveryInfo 
			$deliAddress = "[".$re_zipcode."]".str_replace("||"," ",$re_address);			
			$disql=" ('".$od_keycode."','".$re_delitype."','".$re_name."','".$re_phone."', '".$re_mobile."', '".$deliAddress."', '".$re_request."') "; 
			
			///paymentInfo
			$pisql=" ('".$od_keycode."','".$od_amount."','".$medipricetotal."','".$sweettotal."','".$dcSugartotal."','".$makingprice."','".$decoctionprice."','".$packprice."','".$boxprice."') ";
			

			///packageInfo
			$bisql=substr($bisql,1);
			

			///medicineInfo
			$misql=substr($misql,1);

		*/
		
		///	include_once $root.$folder."/hanpure/hanpureInsert.php";
	
		}
				
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
