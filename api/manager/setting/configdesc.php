<?php /// 환경설정 > 코드관리 > 기본설정 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	if($apiCode!="configdesc"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="configdesc";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$sql="select ";
		$sql.=" CF_CODE,CF_COMPANY,CF_COMPANYENG,CF_SLOGAN,CF_MAKING
				,CF_MAKINGTABLE,CF_GREETING,CF_ESTABLISH,CF_EMAIL,CF_BUSINESS1
				,CF_BUSINESS2,CF_PHONE,CF_FAX,CF_CEO,CF_CEOMOBILE
				,CF_CEOEMAIL,CF_CIO,CF_CIOMOBILE,CF_CIOEMAIL,CF_STAFF
				,CF_STAFFMOBILE,CF_STAFFEMAIL,CF_BUSINESSNO,CF_SALESNO,CF_ZIPCODE,CF_ADDRESS,CF_ADDRESSENG
				,CF_MAKINGPRICE,CF_MAKINGPRICEA,CF_MAKINGPRICEB,CF_MAKINGPRICEC,CF_MAKINGPRICED,CF_MAKINGPRICEE
				,CF_DECOCPRICE,CF_DECOCPRICEA,CF_DECOCPRICEB,CF_DECOCPRICEC,CF_DECOCPRICED,CF_DECOCPRICEE
				,CF_RELEASEPRICE,CF_RELEASEPRICEA,CF_RELEASEPRICEB,CF_RELEASEPRICEC,CF_RELEASEPRICED,CF_RELEASEPRICEE
				,CF_PACKINGPRICE,CF_PACKINGPRICEA,CF_PACKINGPRICEB,CF_PACKINGPRICEC,CF_PACKINGPRICED,CF_PACKINGPRICEE
				,CF_AFTERPRICE,CF_AFTERPRICEA,CF_AFTERPRICEB,CF_AFTERPRICEC,CF_AFTERPRICED,CF_AFTERPRICEE
				,CF_FIRSTPRICE,CF_FIRSTPRICEA,CF_FIRSTPRICEB,CF_FIRSTPRICEC,CF_FIRSTPRICED,CF_FIRSTPRICEE
				, CF_CHEOBPRICE,CF_CHEOBPRICEA,CF_CHEOBPRICEB,CF_CHEOBPRICEC,CF_CHEOBPRICED,CF_CHEOBPRICEE
				,CF_ALCOHOLPRICE,CF_ALCOHOLPRICEA,CF_ALCOHOLPRICEB,CF_ALCOHOLPRICEC,CF_ALCOHOLPRICED,CF_ALCOHOLPRICEE
				,CF_DISTILLATIONPRICE,CF_DISTILLATIONPRICEA,CF_DISTILLATIONPRICEB,CF_DISTILLATIONPRICEC,CF_DISTILLATIONPRICED,CF_DISTILLATIONPRICEE
				,CF_DRYPRICE,CF_DRYPRICEA,CF_DRYPRICEB,CF_DRYPRICEC,CF_DRYPRICED,CF_DRYPRICEE
				,CF_CHEOBBASEPRICE,CF_CHEOBBASEPRICEA,CF_CHEOBBASEPRICEB,CF_CHEOBBASEPRICEC,CF_CHEOBBASEPRICED,CF_CHEOBBASEPRICEE 
				,CF_CHEOBMAKINGPRICE,CF_CHEOBMAKINGPRICEA,CF_CHEOBMAKINGPRICEB,CF_CHEOBMAKINGPRICEC,CF_CHEOBMAKINGPRICED,CF_CHEOBMAKINGPRICEE 
				,CF_SANBASEPRICE,CF_SANBASEPRICEA,CF_SANBASEPRICEB,CF_SANBASEPRICEC,CF_SANBASEPRICED,CF_SANBASEPRICEE 
				,CF_SANMILLINGPRICE,CF_SANMILLINGPRICEA,CF_SANMILLINGPRICEB,CF_SANMILLINGPRICEC,CF_SANMILLINGPRICED,CF_SANMILLINGPRICEE 
				,CF_SANRELEASEPRICE,CF_SANRELEASEPRICEA,CF_SANRELEASEPRICEB,CF_SANRELEASEPRICEC,CF_SANRELEASEPRICED,CF_SANRELEASEPRICEE 

				,CF_BOX,CF_BOXMEDI,CF_LATITUDE,CF_LONGITUDE,CF_BUSIHOUR
				,CF_AUTHKEY ";


		$sql.="	,CF_RELEASEPRICE_POST";
		$sql.=" ,CF_BANKLIST as CFBANKLIST ";
		$sql.=" ,CF_AGREEMENT as CFAGREEMENT ";
		$sql.=" ,CF_PRIVACY as CFPRIVACY ";
		$sql.=" ,CF_COUPON as CFCOUPON ";
		$sql.=" ,CF_MAILSERVER,CF_MAILPORT,CF_MAILSENDER
				,CF_MAILID,CF_MAILPW,CF_MAILHEAD,CF_MAILTAIL,CF_NSDOMAIN1
				,CF_NSIP1,CF_NSDOMAIN2,CF_NSIP2,CF_NSDOMAIN3,CF_NSIP3
				,CF_NSDOMAIN4,CF_NSIP4,CF_DOMAIN,CF_WEBPORT,CF_FTPHOST,CF_FTPPORT,CF_FTPUSER
				,CF_FTPPASS,CF_FTPDIR,CF_DBHOST,CF_DBPORT,CF_DBNAME
				,CF_DBUSER,CF_DBPASS,CF_SMSCOMPANY,CF_SMSURL,CF_SMSID
				,CF_SMSPW,CF_SMSMOBILE,CF_SMSREMAIN,CF_SMSREURL,CF_STATUS ";
		$sql.=" from ".$dbH."_config ";
		$dt=dbone($sql);





		$json=array(
			"cf_code"=>$dt["CF_CODE"], 
			"cf_company"=>$dt["CF_COMPANY"], 
			"cf_companyeng"=>$dt["CF_COMPANYENG"],
			"cf_slogan"=>$dt["CF_SLOGAN"],
			"cf_making"=>$dt["CF_MAKING"],

			"cf_makingtable"=>$dt["CF_MAKINGTABLE"],
			"cf_greeting"=>getClob($dt["CF_GREETING"]),
			"cf_establish"=>$dt["CF_ESTABLISH"],
			"cf_email"=>$dt["CF_EMAIL"],
			"cf_business1"=>$dt["CF_BUSINESS1"],

			"cf_business2"=>$dt["CF_BUSINESS2"],
			"cf_phone"=>$dt["CF_PHONE"],
			"cf_fax"=>$dt["CF_FAX"],
			"cf_ceo"=>$dt["CF_CEO"],
			"cf_ceomobile"=>$dt["CF_CEOMOBILE"],

			"cf_ceoemail"=>$dt["CF_CEOEMAIL"],
			"cf_cio"=>$dt["CF_CIO"],
			"cf_ciomobile"=>$dt["CF_CIOMOBILE"],
			"cf_cioemail"=>$dt["CF_CIOEMAIL"],
			"cf_staff"=>$dt["CF_STAFF"],

			"cf_staffmobile"=>$dt["CF_STAFFMOBILE"],
			"cf_staffemail"=>$dt["CF_STAFFEMAIL"],
			"cf_businessno"=>$dt["CF_BUSINESSNO"],
			"cf_salesno"=>$dt["CF_SALESNO"],
			"cf_zipcode"=>$dt["CF_ZIPCODE"],

			"cf_address"=>$dt["CF_ADDRESS"],
			"cf_addresseng"=>$dt["CF_ADDRESSENG"],


			"cf_makingprice"=>$dt["CF_MAKINGPRICE"],
			"cf_makingpriceA"=>$dt["CF_MAKINGPRICEA"],
			"cf_makingpriceB"=>$dt["CF_MAKINGPRICEB"],
			"cf_makingpriceC"=>$dt["CF_MAKINGPRICEC"],
			"cf_makingpriceD"=>$dt["CF_MAKINGPRICED"],
			"cf_makingpriceE"=>$dt["CF_MAKINGPRICEE"],

			"cf_decocprice"=>$dt["CF_DECOCPRICE"],
			"cf_decocpriceA"=>$dt["CF_DECOCPRICEA"],
			"cf_decocpriceB"=>$dt["CF_DECOCPRICEB"],
			"cf_decocpriceC"=>$dt["CF_DECOCPRICEC"],
			"cf_decocpriceD"=>$dt["CF_DECOCPRICED"],
			"cf_decocpriceE"=>$dt["CF_DECOCPRICEE"],

			"cf_releaseprice"=>$dt["CF_RELEASEPRICE"],
			"cf_releasepriceA"=>$dt["CF_RELEASEPRICEA"],
			"cf_releasepriceB"=>$dt["CF_RELEASEPRICEB"],
			"cf_releasepriceC"=>$dt["CF_RELEASEPRICEC"],
			"cf_releasepriceD"=>$dt["CF_RELEASEPRICED"],
			"cf_releasepriceE"=>$dt["CF_RELEASEPRICEE"],

			"cf_firstprice"=>$dt["CF_FIRSTPRICE"],
			"cf_firstpriceA"=>$dt["CF_FIRSTPRICEA"],
			"cf_firstpriceB"=>$dt["CF_FIRSTPRICEB"],
			"cf_firstpriceC"=>$dt["CF_FIRSTPRICEC"],
			"cf_firstpriceD"=>$dt["CF_FIRSTPRICED"],
			"cf_firstpriceE"=>$dt["CF_FIRSTPRICEE"],

			"cf_afterprice"=>$dt["CF_AFTERPRICE"],
			"cf_afterpriceA"=>$dt["CF_AFTERPRICEA"],
			"cf_afterpriceB"=>$dt["CF_AFTERPRICEB"],
			"cf_afterpriceC"=>$dt["CF_AFTERPRICEC"],
			"cf_afterpriceD"=>$dt["CF_AFTERPRICED"],
			"cf_afterpriceE"=>$dt["CF_AFTERPRICEE"],

			"cf_packingprice"=>$dt["CF_PACKINGPRICE"],
			"cf_packingpriceA"=>$dt["CF_PACKINGPRICEA"],
			"cf_packingpriceB"=>$dt["CF_PACKINGPRICEB"],
			"cf_packingpriceC"=>$dt["CF_PACKINGPRICEC"],
			"cf_packingpriceD"=>$dt["CF_PACKINGPRICED"],
			"cf_packingpriceE"=>$dt["CF_PACKINGPRICEE"],

			"cf_cheobprice"=>$dt["CF_CHEOBPRICE"],
			"cf_cheobpriceA"=>$dt["CF_CHEOBPRICEA"],
			"cf_cheobpriceB"=>$dt["CF_CHEOBPRICEB"],
			"cf_cheobpriceC"=>$dt["CF_CHEOBPRICEC"],
			"cf_cheobpriceD"=>$dt["CF_CHEOBPRICED"],
			"cf_cheobpriceE"=>$dt["CF_CHEOBPRICEE"],


			//주수상반
			"cf_alcoholprice"=>$dt["CF_ALCOHOLPRICE"],
			"cf_alcoholpriceA"=>$dt["CF_ALCOHOLPRICEA"],
			"cf_alcoholpriceB"=>$dt["CF_ALCOHOLPRICEB"],
			"cf_alcoholpriceC"=>$dt["CF_ALCOHOLPRICEC"],
			"cf_alcoholpriceD"=>$dt["CF_ALCOHOLPRICED"],
			"cf_alcoholpriceE"=>$dt["CF_ALCOHOLPRICEE"],

			//증류탕전
			"cf_distillationprice"=>$dt["CF_DISTILLATIONPRICE"],
			"cf_distillationpriceA"=>$dt["CF_DISTILLATIONPRICEA"],
			"cf_distillationpriceB"=>$dt["CF_DISTILLATIONPRICEB"],
			"cf_distillationpriceC"=>$dt["CF_DISTILLATIONPRICEC"],
			"cf_distillationpriceD"=>$dt["CF_DISTILLATIONPRICED"],
			"cf_distillationpriceE"=>$dt["CF_DISTILLATIONPRICEE"],

			//건조탕전
			"cf_dryprice"=>$dt["CF_DRYPRICE"],
			"cf_drypriceA"=>$dt["CF_DRYPRICEA"],
			"cf_drypriceB"=>$dt["CF_DRYPRICEB"],
			"cf_drypriceC"=>$dt["CF_DRYPRICEC"],
			"cf_drypriceD"=>$dt["CF_DRYPRICED"],
			"cf_drypriceE"=>$dt["CF_DRYPRICEE"],


			//첩제기본비
			"cf_cheobbaseprice"=>$dt["CF_CHEOBBASEPRICE"],
			"cf_cheobbasepriceA"=>$dt["CF_CHEOBBASEPRICEA"],
			"cf_cheobbasepriceB"=>$dt["CF_CHEOBBASEPRICEB"],
			"cf_cheobbasepriceC"=>$dt["CF_CHEOBBASEPRICEC"],
			"cf_cheobbasepriceD"=>$dt["CF_CHEOBBASEPRICED"],
			"cf_cheobbasepriceE"=>$dt["CF_CHEOBBASEPRICEE"],
			//첩제조제비
			"cf_cheobmakingprice"=>$dt["CF_CHEOBMAKINGPRICE"],
			"cf_cheobmakingpriceA"=>$dt["CF_CHEOBMAKINGPRICEA"],
			"cf_cheobmakingpriceB"=>$dt["CF_CHEOBMAKINGPRICEB"],
			"cf_cheobmakingpriceC"=>$dt["CF_CHEOBMAKINGPRICEC"],
			"cf_cheobmakingpriceD"=>$dt["CF_CHEOBMAKINGPRICED"],
			"cf_cheobmakingpriceE"=>$dt["CF_CHEOBMAKINGPRICEE"],

			//산제기본비
			"cf_sanbaseprice"=>$dt["CF_SANBASEPRICE"],
			"cf_sanbasepriceA"=>$dt["CF_SANBASEPRICEA"],
			"cf_sanbasepriceB"=>$dt["CF_SANBASEPRICEB"],
			"cf_sanbasepriceC"=>$dt["CF_SANBASEPRICEC"],
			"cf_sanbasepriceD"=>$dt["CF_SANBASEPRICED"],
			"cf_sanbasepriceE"=>$dt["CF_SANBASEPRICEE"],
			//산제제분비
			"cf_sanmillingprice"=>$dt["CF_SANMILLINGPRICE"],
			"cf_sanmillingpriceA"=>$dt["CF_SANMILLINGPRICEA"],
			"cf_sanmillingpriceB"=>$dt["CF_SANMILLINGPRICEB"],
			"cf_sanmillingpriceC"=>$dt["CF_SANMILLINGPRICEC"],
			"cf_sanmillingpriceD"=>$dt["CF_SANMILLINGPRICED"],
			"cf_sanmillingpriceE"=>$dt["CF_SANMILLINGPRICEE"],
			//산제배송비 
			"cf_sanreleaseprice"=>$dt["CF_SANRELEASEPRICE"],
			"cf_sanreleasepriceA"=>$dt["CF_SANRELEASEPRICEA"],
			"cf_sanreleasepriceB"=>$dt["CF_SANRELEASEPRICEB"],
			"cf_sanreleasepriceC"=>$dt["CF_SANRELEASEPRICEC"],
			"cf_sanreleasepriceD"=>$dt["CF_SANRELEASEPRICED"],
			"cf_sanreleasepriceE"=>$dt["CF_SANRELEASEPRICEE"],


			"cf_box"=>$dt["CF_BOX"],
			"cf_boxmedi"=>$dt["CF_BOXMEDI"],
			"cf_latitude"=>$dt["CF_LATITUDE"],
			"cf_longitude"=>$dt["CF_LONGITUDE"],
			"cf_busihour"=>$dt["CF_BUSIHOUR"],

			"cf_authkey"=>$dt["CF_AUTHKEY"],
			"cf_mailserver"=>$dt["CF_MAILSERVER"],
			"cf_mailport"=>$dt["CF_MAILPORT"],
			"cf_mailsender"=>$dt["CF_MAILSENDER"],

			"cf_mailid"=>$dt["CF_MAILID"],
			"cf_mailpw"=>$dt["CF_MAILPW"],
			"cf_mailhead"=>$dt["CF_MAILHEAD"],
			"cf_mailtail"=>$dt["CF_MAILTAIL"],
			"cf_nsdomain1"=>$dt["CF_NSDOMAIN1"],

			"cf_nsip1"=>$dt["CF_NSIP1"],
			"cf_nsdomain2"=>$dt["CF_NSDOMAIN2"],
			"cf_nsip2"=>$dt["CF_NSIP2"],
			"cf_nsdomain3"=>$dt["CF_NSDOMAIN3"],
			"cf_nsip3"=>$dt["CF_NSIP3"],

			"cf_nsdomain4"=>$dt["CF_NSDOMAIN4"],
			"cf_nsip4"=>$dt["CF_NSIP4"],
			"cf_banklist"=>getClob($dt["CFBANKLIST"]),
			"cf_agreement"=>getClob($dt["CFAGREEMENT"]),
			"cf_privacy"=>getClob($dt["CFPRIVACY"]),
			"cf_coupon"=>getClob($dt["CFCOUPON"]),

			"cf_releaseprice_post"=>getClob($dt["CF_RELEASEPRICE_POST"]),		

			"cf_domain"=>$dt["CF_DOMAIN"],
			"cf_webport"=>$dt["CF_WEBPORT"],
			"cf_ftphost"=>$dt["CF_FTPHOST"],
			"cf_ftpport"=>$dt["CF_FTPPORT"],
			"cf_ftpuser"=>$dt["CF_FTPUSER"],					

			"cf_ftppass"=>$dt["CF_FTPPASS"],
			"cf_ftpdir"=>$dt["CF_FTPDIR"],
			"cf_dbhost"=>$dt["CF_DBHOST"],
			"cf_dbport"=>$dt["CF_DBPORT"],
			"cf_dbname"=>$dt["CF_DBNAME"],

			"cf_dbuser"=>$dt["CF_DBUSER"],
			"cf_dbpass"=>$dt["CF_DBPASS"],
			"cf_smscompany"=>$dt["CF_SMSCOMPANY"],
			"cf_smsurl"=>$dt["CF_SMSURL"],
			"cf_smsid"=>$dt["CF_SMSID"],

			"cf_smspw"=>$dt["CF_SMSPW"],
			"cf_smsmobile"=>$dt["CF_SMSMOBILE"],
			"cf_smsremain"=>$dt["CF_SMSREMAIN"],
			"cf_smsreurl"=>$dt["CF_SMSREURL"],
			"cf_status"=>$dt["CF_STATUS"]
		
		);

		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>