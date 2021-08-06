<?php  /// 환경설정 > 코드관리 > 기본설정 > 수정
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	
	if($apicode!="configupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="configupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$cf_code=$_POST["cf_code"];
		$cf_company=$_POST["cf_company"];
		$cf_companyeng=$_POST["cf_companyeng"];
		$cf_slogan=$_POST["cf_slogan"];
		$cf_making=$_POST["cf_making"];
		
		$cf_makingtable=$_POST["cf_makingtable"];
		$cf_greeting=$_POST["cf_greeting"];
		$cf_establish=$_POST["cf_establish"];
		$cf_email=$_POST["cf_email"];
		$cf_business1=$_POST["cf_business1"];

		$cf_business2=$_POST["cf_business2"];
		$cf_phone=$_POST["cf_phone"];
		$cf_fax=$_POST["cf_fax"];
		$cf_ceo=$_POST["cf_ceo"];
		$cf_ceomobile=$_POST["cf_ceomobile"];

		$cf_ceoemail=$_POST["cf_ceoemail"];
		$cf_cio=$_POST["cf_cio"];
		$cf_ciomobile=$_POST["cf_ciomobile"];
		$cf_cioemail=$_POST["cf_cioemail"];
		$cf_staff=$_POST["cf_staff"];

		$cf_staffmobile=$_POST["cf_staffmobile"];
		$cf_staffemail=$_POST["cf_staffemail"];
		$cf_businessno=$_POST["cf_businessno"];
		$cf_salesno=$_POST["cf_salesno"];
		$cf_zipcode=$_POST["cf_zipcode"];

		$cf_address=$_POST["cf_address"];
		$cf_addresseng=$_POST["cf_addresseng"];


		$cf_makingprice=$_POST["cf_makingprice"];
		$cf_makingpriceA=$_POST["cf_makingpriceA"];
		$cf_makingpriceB=$_POST["cf_makingpriceB"];
		$cf_makingpriceC=$_POST["cf_makingpriceC"];
		$cf_makingpriceD=$_POST["cf_makingpriceD"];
		$cf_makingpriceE=$_POST["cf_makingpriceE"];

		$cf_decocprice=$_POST["cf_decocprice"];
		$cf_decocpriceA=$_POST["cf_decocpriceA"];
		$cf_decocpriceB=$_POST["cf_decocpriceB"];
		$cf_decocpriceC=$_POST["cf_decocpriceC"];
		$cf_decocpriceD=$_POST["cf_decocpriceD"];
		$cf_decocpriceE=$_POST["cf_decocpriceE"];

		$cf_releaseprice=$_POST["cf_releaseprice"];
		$cf_releasepriceA=$_POST["cf_releasepriceA"];
		$cf_releasepriceB=$_POST["cf_releasepriceB"];
		$cf_releasepriceC=$_POST["cf_releasepriceC"];
		$cf_releasepriceD=$_POST["cf_releasepriceD"];
		$cf_releasepriceE=$_POST["cf_releasepriceE"];

		$cf_packingprice=$_POST["cf_packingprice"];
		$cf_packingpriceA=$_POST["cf_packingpriceA"];
		$cf_packingpriceB=$_POST["cf_packingpriceB"];
		$cf_packingpriceC=$_POST["cf_packingpriceC"];
		$cf_packingpriceD=$_POST["cf_packingpriceD"];
		$cf_packingpriceE=$_POST["cf_packingpriceE"];

		$cf_afterprice=$_POST["cf_afterprice"];
		$cf_afterpriceA=$_POST["cf_afterpriceA"];
		$cf_afterpriceB=$_POST["cf_afterpriceB"];
		$cf_afterpriceC=$_POST["cf_afterpriceC"];
		$cf_afterpriceD=$_POST["cf_afterpriceD"];
		$cf_afterpriceE=$_POST["cf_afterpriceE"];


		$cf_firstprice=$_POST["cf_firstprice"];
		$cf_firstpriceA=$_POST["cf_firstpriceA"];
		$cf_firstpriceB=$_POST["cf_firstpriceB"];
		$cf_firstpriceC=$_POST["cf_firstpriceC"];
		$cf_firstpriceD=$_POST["cf_firstpriceD"];
		$cf_firstpriceE=$_POST["cf_firstpriceE"];


		$cf_cheobprice=$_POST["cf_cheobprice"];
		$cf_cheobpriceA=$_POST["cf_cheobpriceA"];
		$cf_cheobpriceB=$_POST["cf_cheobpriceB"];
		$cf_cheobpriceC=$_POST["cf_cheobpriceC"];
		$cf_cheobpriceD=$_POST["cf_cheobpriceD"];
		$cf_cheobpriceE=$_POST["cf_cheobpriceE"];

		//주수상반
		$cf_alcoholprice=$_POST["cf_alcoholprice"];
		$cf_alcoholpriceA=$_POST["cf_alcoholpriceA"];
		$cf_alcoholpriceB=$_POST["cf_alcoholpriceB"];
		$cf_alcoholpriceC=$_POST["cf_alcoholpriceC"];
		$cf_alcoholpriceD=$_POST["cf_alcoholpriceD"];
		$cf_alcoholpriceE=$_POST["cf_alcoholpriceE"];

		//증류탕전
		$cf_distillationprice=$_POST["cf_distillationprice"];
		$cf_distillationpriceA=$_POST["cf_distillationpriceA"];
		$cf_distillationpriceB=$_POST["cf_distillationpriceB"];
		$cf_distillationpriceC=$_POST["cf_distillationpriceC"];
		$cf_distillationpriceD=$_POST["cf_distillationpriceD"];
		$cf_distillationpriceE=$_POST["cf_distillationpriceE"];

		//건조탕전
		$cf_dryprice=$_POST["cf_dryprice"];
		$cf_drypriceA=$_POST["cf_drypriceA"];
		$cf_drypriceB=$_POST["cf_drypriceB"];
		$cf_drypriceC=$_POST["cf_drypriceC"];
		$cf_drypriceD=$_POST["cf_drypriceD"];
		$cf_drypriceE=$_POST["cf_drypriceE"];

		//첩제기본비
		$cf_cheobbaseprice=$_POST["cf_cheobbaseprice"];
		$cf_cheobbasepriceA=$_POST["cf_cheobbasepriceA"];
		$cf_cheobbasepriceB=$_POST["cf_cheobbasepriceB"];
		$cf_cheobbasepriceC=$_POST["cf_cheobbasepriceC"];
		$cf_cheobbasepriceD=$_POST["cf_cheobbasepriceD"];
		$cf_cheobbasepriceE=$_POST["cf_cheobbasepriceE"];

		//첩제조제비
		$cf_cheobmakingprice=$_POST["cf_cheobmakingprice"];
		$cf_cheobmakingpriceA=$_POST["cf_cheobmakingpriceA"];
		$cf_cheobmakingpriceB=$_POST["cf_cheobmakingpriceB"];
		$cf_cheobmakingpriceC=$_POST["cf_cheobmakingpriceC"];
		$cf_cheobmakingpriceD=$_POST["cf_cheobmakingpriceD"];
		$cf_cheobmakingpriceE=$_POST["cf_cheobmakingpriceE"];

		//산제기본비
		$cf_sanbaseprice=$_POST["cf_sanbaseprice"];
		$cf_sanbasepriceA=$_POST["cf_sanbasepriceA"];
		$cf_sanbasepriceB=$_POST["cf_sanbasepriceB"];
		$cf_sanbasepriceC=$_POST["cf_sanbasepriceC"];
		$cf_sanbasepriceD=$_POST["cf_sanbasepriceD"];
		$cf_sanbasepriceE=$_POST["cf_sanbasepriceE"];
		//산제제분비
		$cf_sanmillingprice=$_POST["cf_sanmillingprice"];
		$cf_sanmillingpriceA=$_POST["cf_sanmillingpriceA"];
		$cf_sanmillingpriceB=$_POST["cf_sanmillingpriceB"];
		$cf_sanmillingpriceC=$_POST["cf_sanmillingpriceC"];
		$cf_sanmillingpriceD=$_POST["cf_sanmillingpriceD"];
		$cf_sanmillingpriceE=$_POST["cf_sanmillingpriceE"];
		//산제배송비 
		$cf_sanreleaseprice=$_POST["cf_sanreleaseprice"];
		$cf_sanreleasepriceA=$_POST["cf_sanreleasepriceA"];
		$cf_sanreleasepriceB=$_POST["cf_sanreleasepriceB"];
		$cf_sanreleasepriceC=$_POST["cf_sanreleasepriceC"];
		$cf_sanreleasepriceD=$_POST["cf_sanreleasepriceD"];
		$cf_sanreleasepriceE=$_POST["cf_sanreleasepriceE"];

	

		$cf_box=$_POST["cf_box"];
		$cf_boxmedi=$_POST["cf_boxmedi"];
		$cf_latitude=$_POST["cf_latitude"];
		$cf_longitude=$_POST["cf_longitude"];
		$cf_busihour=$_POST["cf_busihour"];

		$cf_authkey=$_POST["cf_authkey"];
		$cf_banklist=$_POST["cf_banklist"];
		$cf_mailserver=$_POST["cf_mailserver"];
		$cf_mailport=$_POST["cf_mailport"];
		$cf_mailsender=$_POST["cf_mailsender"];

		$cf_mailid=$_POST["cf_mailid"];
		$cf_mailpw=$_POST["cf_mailpw"];
		$cf_mailhead=$_POST["cf_mailhead"];
		$cf_mailtail=$_POST["cf_mailtail"];
		$cf_nsdomain1=$_POST["cf_nsdomain1"];

		$cf_nsip1=$_POST["cf_nsip1"];
		$cf_nsdomain2=$_POST["cf_nsdomain2"];
		$cf_nsip2=$_POST["cf_nsip2"];
		$cf_nsdomain3=$_POST["cf_nsdomain3"];
		$cf_nsip3=$_POST["cf_nsip3"];

		$cf_nsdomain4=$_POST["cf_nsdomain4"];
		$cf_nsip4=$_POST["cf_nsip4"];
		$cf_agreement=$_POST["cf_agreement"];
		$cf_privacy=$_POST["cf_privacy"];
		$cf_coupon=$_POST["cf_coupon"];

		$cf_domain=$_POST["cf_domain"];
		$cf_webport=$_POST["cf_webport"];
		$cf_ftphost=$_POST["cf_ftphost"];
		$cf_ftpport=$_POST["cf_ftpport"];
		$cf_ftpuser=$_POST["cf_ftpuser"];

		$cf_ftppass=$_POST["cf_ftppass"];
		$cf_ftpdir=$_POST["cf_ftpdir"];
		$cf_dbhost=$_POST["cf_dbhost"];
		$cf_dbport=$_POST["cf_dbport"];
		$cf_dbname=$_POST["cf_dbname"];

		$cf_dbuser=$_POST["cf_dbuser"];
		$cf_dbpass=$_POST["cf_dbpass"];
		$cf_smscompany=$_POST["cf_smscompany"];
		$cf_smsurl=$_POST["cf_smsurl"];
		$cf_smsid=$_POST["cf_smsid"];

		$cf_smspw=$_POST["cf_smspw"];
		$cf_smsmobile=$_POST["cf_smsmobile"];
		$cf_smsremain=$_POST["cf_smsremain"];
		$cf_smsreurl=$_POST["cf_smsreurl"];
		$cf_status=$_POST["cf_status"];

		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$sql=" update ".$dbH."_config set 				
			cf_code='".$cf_code."',
			cf_company='".$cf_company."',
			cf_companyeng='".$cf_companyeng."',
			cf_slogan='".$cf_slogan."',
			cf_making='".$cf_making."',

			cf_makingtable='".$cf_makingtable."',
			cf_greeting='".$cf_greeting."',
			cf_establish='".$cf_establish."',
			cf_email='".$cf_email."',
			cf_business1='".$cf_business1."',

			cf_business2='".$cf_business2."',
			cf_phone='".$cf_phone."',
			cf_fax='".$cf_fax."',
			cf_ceo='".$cf_ceo."',
			cf_ceomobile='".$cf_ceomobile."',

			cf_ceoemail='".$cf_ceoemail."',
			cf_cio='".$cf_cio."',
			cf_ciomobile='".$cf_ciomobile."',
			cf_cioemail='".$cf_cioemail."',
			cf_staff='".$cf_staff."',

			cf_staffmobile='".$cf_staffmobile."',
			cf_staffemail='".$cf_staffemail."',
			cf_businessno='".$cf_businessno."',
			cf_salesno='".$cf_salesno."',
			cf_zipcode='".$cf_zipcode."',

			cf_address='".$cf_address."',
			cf_addresseng='".$cf_addresseng."',


			cf_makingprice='".$cf_makingprice."',
			cf_makingpriceA='".$cf_makingpriceA."',
			cf_makingpriceB='".$cf_makingpriceB."',
			cf_makingpriceC='".$cf_makingpriceC."',
			cf_makingpriceD='".$cf_makingpriceD."',
			cf_makingpriceE='".$cf_makingpriceE."',

			cf_decocprice='".$cf_decocprice."',
			cf_decocpriceA='".$cf_decocpriceA."',
			cf_decocpriceB='".$cf_decocpriceB."',
			cf_decocpriceC='".$cf_decocpriceC."',
			cf_decocpriceD='".$cf_decocpriceD."',
			cf_decocpriceE='".$cf_decocpriceE."',

			cf_releaseprice='".$cf_releaseprice."',
			cf_releasepriceA='".$cf_releasepriceA."',
			cf_releasepriceB='".$cf_releasepriceB."',
			cf_releasepriceC='".$cf_releasepriceC."',
			cf_releasepriceD='".$cf_releasepriceD."',
			cf_releasepriceE='".$cf_releasepriceE."',

			cf_firstprice='".$cf_firstprice."',
			cf_firstpriceA='".$cf_firstpriceA."',
			cf_firstpriceB='".$cf_firstpriceB."',
			cf_firstpriceC='".$cf_firstpriceC."',
			cf_firstpriceD='".$cf_firstpriceD."',
			cf_firstpriceE='".$cf_firstpriceE."',

			
			cf_afterprice='".$cf_afterprice."',
			cf_afterpriceA='".$cf_afterpriceA."',
			cf_afterpriceB='".$cf_afterpriceB."',
			cf_afterpriceC='".$cf_afterpriceC."',
			cf_afterpriceD='".$cf_afterpriceD."',
			cf_afterpriceE='".$cf_afterpriceE."',

			cf_packingprice='".$cf_packingprice."',
			cf_packingpriceA='".$cf_packingpriceA."',
			cf_packingpriceB='".$cf_packingpriceB."',
			cf_packingpriceC='".$cf_packingpriceC."',
			cf_packingpriceD='".$cf_packingpriceD."',
			cf_packingpriceE='".$cf_packingpriceE."',

			cf_cheobprice='".$cf_cheobprice."',
			cf_cheobpriceA='".$cf_cheobpriceA."',
			cf_cheobpriceB='".$cf_cheobpriceB."',
			cf_cheobpriceC='".$cf_cheobpriceC."',
			cf_cheobpriceD='".$cf_cheobpriceD."',
			cf_cheobpriceE='".$cf_cheobpriceE."',

			cf_alcoholprice='".$cf_alcoholprice."',
			cf_alcoholpriceA='".$cf_alcoholpriceA."',
			cf_alcoholpriceB='".$cf_alcoholpriceB."',
			cf_alcoholpriceC='".$cf_alcoholpriceC."',
			cf_alcoholpriceD='".$cf_alcoholpriceD."',
			cf_alcoholpriceE='".$cf_alcoholpriceE."',


			cf_distillationprice='".$cf_distillationprice."',
			cf_distillationpriceA='".$cf_distillationpriceA."',
			cf_distillationpriceB='".$cf_distillationpriceB."',
			cf_distillationpriceC='".$cf_distillationpriceC."',
			cf_distillationpriceD='".$cf_distillationpriceD."',
			cf_distillationpriceE='".$cf_distillationpriceE."',

			cf_dryprice='".$cf_dryprice."',
			cf_drypriceA='".$cf_drypriceA."',
			cf_drypriceB='".$cf_drypriceB."',
			cf_drypriceC='".$cf_drypriceC."',
			cf_drypriceD='".$cf_drypriceD."',
			cf_drypriceE='".$cf_drypriceE."',

			cf_cheobbaseprice='".$cf_cheobbaseprice."',
			cf_cheobbasepriceA='".$cf_cheobbasepriceA."',
			cf_cheobbasepriceB='".$cf_cheobbasepriceB."',
			cf_cheobbasepriceC='".$cf_cheobbasepriceC."',
			cf_cheobbasepriceD='".$cf_cheobbasepriceD."',
			cf_cheobbasepriceE='".$cf_cheobbasepriceE."',

			cf_cheobmakingprice='".$cf_cheobmakingprice."',
			cf_cheobmakingpriceA='".$cf_cheobmakingpriceA."',
			cf_cheobmakingpriceB='".$cf_cheobmakingpriceB."',
			cf_cheobmakingpriceC='".$cf_cheobmakingpriceC."',
			cf_cheobmakingpriceD='".$cf_cheobmakingpriceD."',
			cf_cheobmakingpriceE='".$cf_cheobmakingpriceE."',

			cf_sanbaseprice='".$cf_sanbaseprice."',
			cf_sanbasepriceA='".$cf_sanbasepriceA."',
			cf_sanbasepriceB='".$cf_sanbasepriceB."',
			cf_sanbasepriceC='".$cf_sanbasepriceC."',
			cf_sanbasepriceD='".$cf_sanbasepriceD."',
			cf_sanbasepriceE='".$cf_sanbasepriceE."',

			cf_sanmillingprice='".$cf_sanmillingprice."',
			cf_sanmillingpriceA='".$cf_sanmillingpriceA."',
			cf_sanmillingpriceB='".$cf_sanmillingpriceB."',
			cf_sanmillingpriceC='".$cf_sanmillingpriceC."',
			cf_sanmillingpriceD='".$cf_sanmillingpriceD."',
			cf_sanmillingpriceE='".$cf_sanmillingpriceE."',

			cf_sanreleaseprice='".$cf_sanreleaseprice."',
			cf_sanreleasepriceA='".$cf_sanreleasepriceA."',
			cf_sanreleasepriceB='".$cf_sanreleasepriceB."',
			cf_sanreleasepriceC='".$cf_sanreleasepriceC."',
			cf_sanreleasepriceD='".$cf_sanreleasepriceD."',
			cf_sanreleasepriceE='".$cf_sanreleasepriceE."',

		
			cf_box='".$cf_box."',
			cf_boxmedi='".$cf_boxmedi."',
			cf_latitude='".$cf_latitude."',
			cf_longitude='".$cf_longitude."',
			cf_busihour='".$cf_busihour."',

			cf_authkey='".$cf_authkey."',
			cf_banklist='".$cf_banklist."',
			cf_mailserver='".$cf_mailserver."',
			cf_mailport='".$cf_mailport."',
			cf_mailsender='".$cf_mailsender."',

			cf_mailid='".$cf_mailid."',
			cf_mailpw='".$cf_mailpw."',
			cf_mailhead='".$cf_mailhead."',
			cf_mailtail='".$cf_mailtail."',
			cf_nsdomain1='".$cf_nsdomain1."',

			cf_nsip1='".$cf_nsip1."',
			cf_nsdomain2='".$cf_nsdomain2."',
			cf_nsip2='".$cf_nsip2."',
			cf_nsdomain3='".$cf_nsdomain3."',
			cf_nsip3='".$cf_nsip3."',

			cf_nsdomain4='".$cf_nsdomain4."',
			cf_nsip4='".$cf_nsip4."',
			cf_agreement='".$cf_agreement."',
			cf_privacy='".$cf_privacy."',
			cf_coupon='".$cf_coupon."',

			cf_domain='".$cf_domain."',
			cf_webport='".$cf_webport."',
			cf_ftphost='".$cf_ftphost."',
			cf_ftpport='".$cf_ftpport."',
			cf_ftpuser='".$cf_ftpuser."',

			cf_ftppass='".$cf_ftppass."',
			cf_ftpdir='".$cf_ftpdir."',
			cf_dbhost='".$cf_dbhost."',
			cf_dbport='".$cf_dbport."',
			cf_dbname='".$cf_dbname."',

			cf_dbuser='".$cf_dbuser."',
			cf_dbpass='".$cf_dbpass."',
			cf_smscompany='".$cf_smscompany."',
			cf_smsurl='".$cf_smsurl."',
			cf_smsid='".$cf_smsid."',

			cf_smspw='".$cf_smspw."',
			cf_smsmobile='".$cf_smsmobile."',
			cf_smsremain='".$cf_smsremain."',
			cf_smsreurl='".$cf_smsreurl."',
			cf_status='".$cf_status."',
					
			cf_modify=sysdate";
			dbcommit($sql);

		$json["sql"]=$sql;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>