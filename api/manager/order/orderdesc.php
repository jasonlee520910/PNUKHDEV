<?php
	//// 주문현황>주문리스트>상세 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$seq=$_GET["seq"];

	if($apiCode!="orderdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="orderdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else
	{

		$returnData=$_GET["returnData"];

		///------------------------------------------------------------
		/// DOO :: Code 테이블 목록 보여주기 위한 쿼리 추가 
		///------------------------------------------------------------
		$hCodeList = getNewCodeTitle("dcTitle,mrDesc,reDelitype,maType,dcShape,dcBinders,dcFineness,dcJungtang,dcRipen,reSendType,meSex,mhFeature,patientType");
		///------------------------------------------------------------

		$dcTitleList = getCodeList($hCodeList, 'dcTitle');///탕전법리스트
		$dcSpecialList = getSpecial();//특수탕전리스트 
		$mrDescList = getCodeList($hCodeList, 'mrDesc');///마킹정보리스트 
		$reDelitypeList = getCodeList($hCodeList, 'reDelitype');///배송타입리스트 
		//$odCareList = getCodeList($hCodeList, 'odCare');///복약방법코드 
		//$selAdviceList = getCodeList($hCodeList, 'selAdvice');///복약지도코드 



		///조제타입  maType
		$maTypeList = getCodeList($hCodeList, 'maType');///조제타입 
		$patientTypeList=getCodeList($hCodeList, 'patientType');///환자타입 
		///제형 dcShape
		$dcShapeList = getCodeList($hCodeList, 'dcShape');///제형
		///결합제 dcBinders
		$dcBindersList = getCodeList($hCodeList, 'dcBinders');///결합제
		///분말도 dcFineness
		$dcFinenessList = getCodeList($hCodeList, 'dcFineness');///분말도
		///중탕 dcJungtang
		$dcJungtangList = getCodeList($hCodeList, 'dcJungtang');///중탕
		///숙성
		$dcRipenList=getCodeList($hCodeList, 'dcRipen');///숙성 
		///보내는사람선택 
		$reSendTypeList=getCodeList($hCodeList, 'reSendType');///보낸는사람 선택 
		$meSexList=getCodeList($hCodeList, 'meSex');///성별 

		///------------------------------------------------------------
		/// DOO :: DecocCode 테이블 목록 보여주기 위한 쿼리 추가 
		///------------------------------------------------------------
		$decoctypeList = getDecoCodeTitle();///탕전타입
		///------------------------------------------------------------
		$config=getConfigInfo();///공통으로 쓰이는 데이터들 (가격)

		//getsugar
		$dcSugarList=getSugar(); //감미제 리스트 

		//복용지시, 조제지시 
		$odAdviceList=getMemberDocx("ADVICE");
		$odCommentList=getMemberDocx("COMMENT");

		if($seq == 'write')
		{
			///------------------------------------------------------------
			/// DOO :: PackCode 테이블 목록 보여주기 위한 쿼리 추가 
			///------------------------------------------------------------
			$hPackCodeList = getPackCodeTitle('', "odPacktype,reBoxdeli,reBoxmedi");
			$reBoxmediList = getCodeList($hPackCodeList, 'reBoxmedi');///한약박스
			$reBoxdeliList = getCodeList($hPackCodeList, 'reBoxdeli');///배송포장재종류 
			$odPacktypeList = getCodeList($hPackCodeList, 'odPacktype');///파우치
			///$doctorList = array();
			$json=array(
				"decoctypeList"=>$decoctypeList,///탕전타입 (선전,일반,후하 )
				//"odCareList"=>$odCareList,///복약방법코드
				//"selAdviceList"=>$selAdviceList,///복약지도코드
				"odAdviceList"=>$odAdviceList,
				"odCommentList"=>$odCommentList,
				"dcTitleList"=>$dcTitleList,///탕전법리스트
				"dcSpecialList"=>$dcSpecialList,///특수탕전리스트
				"mrDescList"=>$mrDescList,///마킹정보리스트
				"reDelitypeList"=>$reDelitypeList, ///배송타입리스트
				"reBoxmediList"=>$reBoxmediList,///한약박스
				"reBoxdeliList"=>$reBoxdeliList,///배송포장재종류
				"odPacktypeList"=>$odPacktypeList,///파우치
				"maTypeList"=>$maTypeList,///조제타입
				"patientTypeList"=>$patientTypeList,///환자타입
				"dcShapeList"=>$dcShapeList,///제형
				"dcBindersList"=>$dcBindersList,///결합제
				"dcFinenessList"=>$dcFinenessList,///분말도
				"dcJungtangList"=>$dcJungtangList,///중탕
				"dcRipenList"=>$dcRipenList,///숙성리스트 
				//"rePotList"=>$rePotList,///항아리
				//"reStickList"=>$reStickList,///스틱
				//"rejewanBoxList"=>$rejewanBoxList,///제환박스
				"dcSugarList"=>$dcSugarList,///감미제
				"reSendTypeList"=>$reSendTypeList,///보내는사람선택
				"meSexList"=>$meSexList,///20190822 : 성별추가
				//"mhFeatureList"=>$mhFeatureList,///20190822 : 사상추가
				"config"=>$config
			);			
		}
		else
		{
			
			$jsql=" a inner join ".$dbH."_medical m on a.od_userid=m.mi_userid ";
			$jsql.=" inner join ".$dbH."_making b on a.od_code=b.ma_odcode ";
			$jsql.=" inner join ".$dbH."_decoction c on a.od_code=c.dc_odcode ";
			$jsql.=" inner join ".$dbH."_marking d on a.od_code=d.mr_odcode ";
			$jsql.=" inner join ".$dbH."_release e on a.od_code=e.re_odcode ";
			$jsql.=" inner join ".$dbH."_recipeuser r on a.od_scription=r.rc_code ";
			$jsql.=" left join ".$dbH."_code g on g.cd_type='cancelType' and a.od_canceltype=g.cd_code ";
			$jsql.=" left join ".$dbH."_code o on o.cd_code=c.dc_title  and o.cd_type='dcTitle' ";
			$jsql.=" left join ".$dbH."_code k on k.cd_code=c.dc_special  and k.cd_type='dcSpecial'  ";
			$jsql.=" left join ".$dbH."_code q on q.cd_code=d.mr_desc  and q.cd_type='mrDesc'  ";
			$jsql.=" left join ".$dbH."_code f on f.cd_code=e.re_delitype  and f.cd_type='reDelitype'   ";
			$jsql.=" left join ".$dbH."_code t on t.cd_type='maType' and a.od_matype=t.cd_code ";
			$jsql.=" left join ".$dbH."_code rp on rp.cd_type='patientType' and a.od_recipe=rp.cd_code ";
			$jsql.=" left join ".$dbH."_member z on z.me_userid=a.od_staff ";
		

			$ssql=" a.OD_SEQ, a.OD_CODE, a.OD_KEYCODE, a.OD_USERID, a.OD_QTY, a.OD_PILLCAPA, a.OD_CARE, a.OD_CANCELTYPE, a.OD_OLDODCODE , a.OD_NAME, a.OD_GENDER, a.OD_FEATURE ";
			$ssql.=" , a.OD_SITECATEGORY , a.OD_MATYPE , a.OD_ADVICEKEY, a.OD_COMMENTKEY ";
			$ssql.=" , a.OD_STAFF, a.OD_SCRIPTION, a.OD_RECIPE, a.OD_TITLE, a.OD_CHUBCNT, a.OD_PACKTYPE, a.OD_PACKPRICE, a.OD_PACKCNT, a.OD_PACKCAPA, a.OD_STATUS, a.OD_GOODS "; 
			$ssql.=" ,to_char(a.OD_BIRTH, 'yyyy-mm-dd') as ODBIRTH ";
			$ssql.=" ,to_char(a.OD_DATE, 'yyyy-mm-dd hh24:mi:ss') as ODDATE ";
			$ssql.=" , a.od_request as odRequest ";
			$ssql.=" , a.OD_ADVICE as ODADVICE ";
			$ssql.=" , a.OD_CANCELTEXT as ODCANCELTEXT ";
			$ssql.=" , a.OD_RESTARTTEXT as ODRESTARTTEXT ";
			$ssql.=" , a.OD_AMOUNTDJMEDI as ODAMOUNTDJMEDI ";
			$ssql.=" , g.cd_name_".$language." as cancelTypeName ";
			$ssql.=" , z.me_name odStaffName ";
			$ssql.=" , r.rc_seq, r.rc_source ";
			$ssql.=" , r.rc_medicine as rcMedicine ";
			$ssql.=" , r.rc_sweet as rcSweet ";
			$ssql.=" , r.rc_pillorder  ";
			$ssql.=" , m.mi_userid, m.mi_name, m.mi_zipcode, m.mi_address, m.mi_phone, m.mi_mobile, m.mi_grade  ";
			$ssql.=" , d.mr_desc ";
			$ssql.=" , q.cd_name_kor mrDesctext ";
			$ssql.=" , q.cd_value_kor as markingtxt ";
			$ssql.=" , c.DC_SHAPE, c.DC_BINDERS, c.DC_FINENESS, c.DC_MILLINGLOSS, c.DC_LOSSJEWAN, c.DC_BINDERSLIANG, c.DC_COMPLETELIANG, c.DC_COMPLETECNT "; 
			$ssql.=" , c.DC_DRY, c.DC_RIPEN, c.DC_JUNGTANG, c.DC_PRICE, c.DC_SUGAR, c.DC_TITLE, c.DC_TIME, c.DC_SPECIAL, c.DC_SPECIALPRICE, c.DC_WATER, c.DC_ALCOHOL, c.DC_STERILIZED, c.DC_COOLING ";
			$ssql.=" ,  o.cd_name_kor DCTITLETEXT, k.cd_name_kor DCSPECIALTEXT, k.CD_DESC_KOR DCSPECIALVALUE ";
			$ssql.=" , b.ma_price, b.MA_FIRSTPRICE, b.MA_AFTERPRICE ";
			$ssql.=",  t.cd_name_".$language." as maTypeName ";
			$ssql.=",  rp.cd_name_".$language." as patientTypeName ";

			$ssql.=" , e.RE_SENDTYPE, e.RE_SENDNAME, e.RE_SENDPHONE, e.RE_SENDMOBILE, e.RE_SENDZIPCODE, e.RE_SENDADDRESS  ";
			$ssql.=" , e.RE_NAME, e.RE_PHONE, e.RE_DELITYPE, e.RE_MOBILE, e.RE_ZIPCODE, e.RE_ADDRESS  ";
			$ssql.=" , e.RE_BOXMEDI, e.RE_BOXDELI, e.RE_BOXMEDIPRICE, e.RE_BOXDELIPRICE, e.RE_BOX, e.RE_PRICE  ";
			$ssql.=" , e.RE_REQUEST as REREQUEST, e.RE_PACKINGPRICE  ";
			$ssql.=" , to_char(e.RE_DELIDATE, 'yyyy-mm-dd') as REDELIDATE ";
			$ssql.=" , f.cd_name_kor reDelitypetext ";

			$wsql=" where a.od_seq = '".$seq."' ";
			$sql=" select ".$ssql." from ".$dbH."_order $jsql $wsql ";
			$dt=dbone($sql);

			///------------------------------------------------------------
			/// DOO :: PackCode 테이블 목록 보여주기 위한 쿼리 추가 
			///------------------------------------------------------------
			
			$hPackCodeList = getPackCodeTitle($dt["OD_USERID"], "odPacktype,reBoxdeli,reBoxmedi");
			$reBoxmediList = getCodeList($hPackCodeList, 'reBoxmedi');///한약박스
			$reBoxdeliList = getCodeList($hPackCodeList, 'reBoxdeli');///배송포장재종류 
			$odPacktypeList = getCodeList($hPackCodeList, 'odPacktype');///파우치

			///------------------------------------------------------------
			/// DOO :: 약재정보 빈공간 삭제 
			///------------------------------------------------------------
			$rcMedicine = getClob($dt["RCMEDICINE"]);
			$rcMedicine = str_replace(" ", "", $rcMedicine);
			///------------------------------------------------------------

			$addr=explode("||",$dt["RE_ADDRESS"]);

			$cancelTypeName = (!$dt["CANCELTYPENAME"]) ? "" : $dt["CANCELTYPENAME"];

			$sendaddr=explode("||", $dt["RE_SENDADDRESS"]);

			///20191015 : 마킹 정보 실데이터 적용 
			$txt_marking=getClob($dt["MARKINGTXT"]);
			if($txt_marking)
			{
				$markingtxt=$txt_marking;
				$markingtxt=str_replace("[od_code]",$dt["OD_CODE"],$markingtxt);///주문번호
				$markingtxt=str_replace("[re_name]",$dt["OD_NAME"],$markingtxt);///환자명
				$markingtxt=str_replace("[mi_name]",$dt["MI_NAME"],$markingtxt);///한의원 
				$markingtxt=str_replace("[patientcode]",$dt["OD_NAME"],$markingtxt);///환자명코드 
				$markingtxt=str_replace("<br/>"," + ",$markingtxt);///줄바꿈을  + 로 바꿈  
			}
			else
			{
				$markingtxt="<p>No Marking</p>";
			}


			$rc_source=$dt["RC_SOURCE"];
			$recipeChubCnt=$recipePackcnt="";
			if($rc_source)
			{
				$rsql=" select rc_chub,rc_packcnt from ".$dbH."_recipemedical where rc_code='".$rc_source."' ";
				$rdt=dbone($rsql);
				$recipeChubCnt=$rdt["RC_CHUB"];
				$recipePackcnt=$rdt["RC_PACKCNT"];
			}

			if(intval($dt["DC_ALCOHOL"])>0)
			{
				$dcspecialtext=$dt["DCSPECIALTEXT"];//."<br>".getClob($dt["DCSPECIALVALUE"])." : ".$dt["DC_ALCOHOL"]."cc";
				$dcWatertxt="물 : ".$dt["DC_WATER"]."ml <br>".getClob($dt["DCSPECIALVALUE"])." : ".$dt["DC_ALCOHOL"]."cc";
			}
			else
			{
				$dcspecialtext=$dt["DCSPECIALTEXT"];
				$dcWatertxt=$dt["DC_WATER"]."ml";
			}

			if($dt["OD_GOODS"]=="M"){$gGoodsM="첩";}else{$gGoodsM="";}
			if($gGoodsM) {$gGoodsM="<span style='padding:2px 5px;border-radius:10%;background:#FF0000;color:#fff;'>첩약</span>";//$gGoodsM="<span style='display:inline-block;width:17px;height:17px;font-size:11px;border-radius:50%;background:#FF0000;color:#fff;text-align:center;line-height:17px;'>첩</span>";
			}

			//|HD017603KR0004J,교이5bx,5,270,32
			$sugararr=explode(",",$dt["DC_SUGAR"]);
			$dcSugarCode=$sugararr[0];
			$dcSugarName=$sugararr[1];
			$dcSugarCapa=$sugararr[2];
			$dcSugarTotalCapa=$sugararr[3];
			$dcSugarPrice=$sugararr[4];

			$odAdvicekey=isEmpty($dt["OD_ADVICEKEY"])?0:$dt["OD_ADVICEKEY"];
			$odCommentkey=isEmpty($dt["OD_COMMENTKEY"])?0:$dt["OD_COMMENTKEY"];



			$json=array(
				///order
				"seq"=>$dt["OD_SEQ"], 
				"odCode"=>$dt["OD_CODE"], 
				"odKeycode"=>$dt["OD_KEYCODE"],
				"odUserid"=>$dt["OD_USERID"],
				"odRecipe"=>$dt["OD_RECIPE"],
				"odGoods"=>$dt["OD_GOODS"],
				"gGoodsM"=>$gGoodsM,
				"odAdvicekey"=>$odAdvicekey,
				"odCommentkey"=>$odCommentkey,
				"patientTypeName"=>$dt["PATIENTTYPENAME"],
				"odQty"=>$dt["OD_QTY"],
				"odPillcapa"=>$dt["OD_PILLCAPA"],
				"odCare"=>$dt["OD_CARE"], 
				"odRequest"=>getClob($dt["ODREQUEST"]), 
				"odAdvice"=>getClob($dt["ODADVICE"]),
				"odOldodcode"=>$dt["OD_OLDODCODE"],
				"odCanceltype"=>$dt["OD_CANCELTYPE"],
				"odCanceltext"=>getClob($dt["ODCANCELTEXT"]),
				"odRestarttext"=>getClob($dt["ODRESTARTTEXT"]),
				"odName"=>$dt["OD_NAME"],
				"odGender"=>$dt["OD_GENDER"],
				"odBirth"=>$dt["ODBIRTH"],
				"odFeature"=>$dt["OD_FEATURE"],
				"odSitecategory"=>$dt["OD_SITECATEGORY"],
				"odMatype"=>$dt["OD_MATYPE"],///조제타입 20190611 
				"maTypeName"=>$dt["MATYPENAME"],
				"odStaff"=>$dt["OD_STAFF"],
				"odStaffName"=>$dt["ODSTAFFNAME"],					
				"odScription"=>$dt["OD_SCRIPTION"],
				"odTitle"=>$dt["OD_TITLE"],
				"odChubcnt"=>$dt["OD_CHUBCNT"], 
				"odPacktype"=>$dt["OD_PACKTYPE"], 
				"odPackprice"=>$dt["OD_PACKPRICE"], ///파우치가격 
				"odPackcnt"=>$dt["OD_PACKCNT"],
				"odPackcapa"=>$dt["OD_PACKCAPA"],
				"odDate"=>$dt["ODDATE"], 
				"odStatus"=>$dt["OD_STATUS"], 
				"odAmountdjmedi"=>getClob($dt["ODAMOUNTDJMEDI"]),///djmedi 주문금액 json data 
				"cancelTypeName"=>$cancelTypeName, 

				///recipeuser
				"rcSeq"=>$dt["RC_SEQ"], 
				"rcMedicine"=>$rcMedicine, 
				"rcSweet"=>getClob($dt["RCSWEET"]),
				"rcPillorder"=>getClob($dt["RC_PILLORDER"]),					
				"rcSource"=>$rc_source,
				"recipeChubCnt"=>$recipeChubCnt,
				"recipePackcnt"=>$recipePackcnt,


				///medical 
				"miUserid"=>$dt["MI_USERID"], 
				"miName"=>$dt["MI_NAME"],
				"miZipcode"=>$dt["MI_ZIPCODE"],
				"miAddress"=>$dt["MI_ADDRESS"],
				"miPhone"=>$dt["MI_PHONE"],
				"miMobile"=>$dt["MI_MOBILE"],
				"miGrade"=>$dt["MI_GRADE"],
				

				
				///marking 
				"markingtxt"=>$markingtxt,
				"mrDesctext"=>getClob($dt["MRDESCTEXT"]), ///마킹text
				"mrDesc"=>$dt["MR_DESC"], 

				
				"odChartPK"=>"",///$od_chartpk, 

				///decoction 
				"dcTitletext"=>$dt["DCTITLETEXT"], ///탕전법text
				"dcSpecialtext"=>$dcspecialtext,  ///특수탕전 text
				"dcWatertxt"=>$dcWatertxt,
				"dcShape"=>$dt["DC_SHAPE"],///제형 20190611 
				"dcBinders"=>$dt["DC_BINDERS"],///결합제 20190611 
				"dcFineness"=>$dt["DC_FINENESS"],///분말도 20190611 
				"dcMillingloss"=>$dt["DC_MILLINGLOSS"],///제분손실 20190611 
				"dcLossjewan"=>$dt["DC_LOSSJEWAN"],///제환손실 20190611 
				"dcBindersliang"=>$dt["DC_BINDERSLIANG"],///결합제량 20190611 
				"dcCompleteliang"=>$dt["DC_COMPLETELIANG"],///완성량 20190611 
				"dcCompletecnt"=>$dt["DC_COMPLETECNT"],///완성량 20190611 
				"dcDry"=>$dt["DC_DRY"],///건조시간
				"dcRipen"=>$dt["DC_RIPEN"],///숙성
				"dcJungtang"=>$dt["DC_JUNGTANG"],///중탕
				"dcPrice"=>$dt["DC_PRICE"], ///탕전비

				"dcSugarCode"=>$dcSugarCode,
				"dcSugarName"=>$dcSugarName,
				"dcSugarCapa"=>$dcSugarCapa,
				"dcSugarTotalCapa"=>$dcSugarTotalCapa,
				"dcSugarPrice"=>$dcSugarPrice,

				"dcTitle"=>$dt["DC_TITLE"],
				"dcTime"=>$dt["DC_TIME"], 
				"dcSpecial"=>$dt["DC_SPECIAL"], 
				"dcSpecialPrice"=>$dt["DC_SPECIALPRICE"], 
				"dcWater"=>$dt["DC_WATER"], 
				"dcAlcohol"=>$dt["DC_ALCOHOL"],
				"dcSterilized"=>$dt["DC_STERILIZED"],
				"dcCooling"=>$dt["DC_COOLING"],
	

				"maPrice"=>$dt["MA_PRICE"], ///조제비 	
				"firstPrice"=>$dt["MA_FIRSTPRICE"], ///선전비 	
				"afterPrice"=>$dt["MA_AFTERPRICE"], ///후하비  	
				
				


				"reSendType"=>$dt["RE_SENDTYPE"],
				"reSendname"=>$dt["RE_SENDNAME"],
				"reSendphone"=>$dt["RE_SENDPHONE"],
				"reSendmobile"=>$dt["RE_SENDMOBILE"],
				"reSendzipcode"=>$dt["RE_SENDZIPCODE"],
				"reSendaddress"=>$sendaddr[0],
				"reSendaddress1"=>$sendaddr[1],
				"reName"=>$dt["RE_NAME"],
				"rePhone"=>$dt["RE_PHONE"], 
				"reDelitype"=>$dt["RE_DELITYPE"],
				"reMobile"=>$dt["RE_MOBILE"],
				"reZipcode"=>$dt["RE_ZIPCODE"], 
				"addr1"=>$addr[0],
				"addr2"=>$addr[1],
				"reAddress"=>$dt["RE_ADDRESS"],
				"reRequest"=>getClob($dt["REREQUEST"]), 
				"reBoxmedi"=>$dt["RE_BOXMEDI"],
				"reBoxdeli"=>$dt["RE_BOXDELI"], 
				"reBoxmediprice"=>$dt["RE_BOXMEDIPRICE"], ///한약박스비 
				"reBoxdeliprice"=>$dt["RE_BOXDELIPRICE"], ///배송박스비 
				"reBox"=>$dt["RE_BOX"], ///100팩당 1박스
				"reDelitypetext"=>$dt["REDELITYPETEXT"],
				"rePrice"=>$dt["RE_PRICE"], ///배송비
				"reDelidate"=>$dt["REDELIDATE"],
				"packPrice"=>$dt["RE_PACKINGPRICE"],//포장비 

				
				"decoctypeList"=>$decoctypeList,///탕전타입 (선전,일반,후하 )
				//"odCareList"=>$odCareList,///복약방법코드
				//"selAdviceList"=>$selAdviceList,///복약지도코드

				"odAdviceList"=>$odAdviceList,
				"odCommentList"=>$odCommentList,
				"dcTitleList"=>$dcTitleList,///탕전법리스트
				"dcSpecialList"=>$dcSpecialList,///특수탕전리스트
				"mrDescList"=>$mrDescList,///마킹정보리스트
				"reDelitypeList"=>$reDelitypeList, ///배송타입리스트
				"reBoxmediList"=>$reBoxmediList,///한약박스
				"reBoxdeliList"=>$reBoxdeliList,///배송포장재종류
				"odPacktypeList"=>$odPacktypeList,///파우치
				"maTypeList"=>$maTypeList,///조제타입
				"patientTypeList"=>$patientTypeList,///환자타입
				"dcShapeList"=>$dcShapeList,///제형
				"dcBindersList"=>$dcBindersList,///결합제
				"dcFinenessList"=>$dcFinenessList,///분말도
				"dcJungtangList"=>$dcJungtangList,///중탕
				"dcRipenList"=>$dcRipenList,///숙성리스트
				"dcSugarList"=>$dcSugarList,///감미제
				"reSendTypeList"=>$reSendTypeList,///보내는사람선택
				"meSexList"=>$meSexList,///20190822 : 성별추가
				//"mhFeatureList"=>$mhFeatureList,///20190822 : 사상추가
				"config"=>$config
			);
		}

		//상세페이지에서 파우치, 한약박스, 포장박스 
		$dsql=" select 
		(select PB_TITLE from han_packingbox where PB_CODE='".$dt["OD_PACKTYPE"]."' ) as packname
		,(select PB_TITLE from han_packingbox where PB_CODE='".$dt["RE_BOXDELI"]."' ) as boxdeliname
		,(select PB_TITLE from han_packingbox where PB_CODE='".$dt["RE_BOXMEDI"]."' ) as boxmediname
		,(select MIN(af_url) KEEP (DENSE_RANK FIRST ORDER BY af_no DESC) from han_file where af_fcode='".$dt["OD_PACKTYPE"]."' and af_code='packingbox' and af_use='Y') as packimg 
		, (select MIN(af_url) KEEP (DENSE_RANK FIRST ORDER BY af_no DESC) from han_file where af_fcode='".$dt["RE_BOXDELI"]."' and af_code='packingbox' and af_use='Y') as boxdeliimg 
		, (select MIN(af_url) KEEP (DENSE_RANK FIRST ORDER BY af_no DESC) from han_file where af_fcode='".$dt["RE_BOXMEDI"]."' and af_code='packingbox' and af_use='Y') as boxmediimg 
		from dual ";		
		$ddt=dbone($dsql);
		
		$json["dsql"]=$dsql;

		$json["packname"]=$ddt["PACKNAME"];
		$json["boxdeliname"]=$ddt["BOXDELINAME"];
		$json["boxmediname"]=$ddt["BOXMEDINAME"];

		$json["packimg"]=getafThumbUrl($ddt["PACKIMG"]);
		$json["boxdeliimg"]=getafThumbUrl($ddt["BOXDELIIMG"]);
		$json["boxmediimg"]=getafThumbUrl($ddt["BOXMEDIIMG"]);

		//상세 
		if(isEmpty($odAdvicekey)==false)
		{
			$dsql=" select a.MD_FILEIDX, b.AF_NAME, b.AF_URL, b.AF_SIZE from han_member_docx
					a left join han_file b on b.AF_SEQ=a.MD_FILEIDX and b.AF_USE='Y'
					where a.MD_SEQ='".$odAdvicekey."'  ";
			$ddt=dbone($dsql);
			$json["afAdviceName"]=$ddt["AF_NAME"];
			$json["afAdviceUrl"]=getafFile($ddt["AF_URL"]);
			$json["afAdviceSize"]=$ddt["AF_SIZE"];

		}

		
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
