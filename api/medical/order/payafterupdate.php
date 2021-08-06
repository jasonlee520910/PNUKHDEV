<?php //결제하고 난 다음 update
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	
	if($apiCode!="payafterupdate"){$json["resultMessage"]="API코드오류2";$apiCode="payafterupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else
	{
		$json["apiCode"]=$apiCode;	

		$payinfo=json_decode($_POST["postdata"],true);

		$cartid=$payinfo["ORDERNO"];  //상품코드
		$buy_reqamt=$payinfo["BUY_REQAMT"];  //가격

		//&MID=M20170713100003  //상점아이디
		$cid=$payinfo["CID"];  //계약아이디
		$tid=$payinfo["TID"];  //거래고유번호
		$pm_paytype=$payinfo["PAY_METHOD"];  //거래방법(카드 CC)

		//han_payment update 추가  결제 성공 시만 반환 - 신용카드 (15개)	실제거래에서는 넘어온다는 가정하에....
		$pm_van_recv_key=$payinfo["VAN_RECV_KEY"];   //vpn 거래고유키
		$pm_approvno=$payinfo["APPROVNO"];  //승인번호
		$pm_approdt=$payinfo["APPRODT"]; //승인일자 (YYYYMMDD)
		$pm_approtm=$payinfo["APPROTM"]; //승인시각 (HH24MISS)
		$pm_approamt=$payinfo["APPROAMT"]; //승인금액

		$pm_van_card_mid=$payinfo["VAN_CARD_MID"]; //가맹점번호
		$pm_card_no=$payinfo["CARD_NO"]; //카드번호
		$pm_issue_code=$payinfo["ISSUE_CODE"]; //발급사코드
		$pm_issue_name=$payinfo["ISSUE_NAME"]; //발급사명
		$pm_purchase_code=$payinfo["PURCHASE_CODE"]; //매입사코드

		$pm_purchase_name=$payinfo["PURCHASE_NAME"]; //매입사명
		$pm_noint=$payinfo["NOINT"];  //무이자여부
		$pm_quota_momths=$payinfo["QUOTA_MOMTHS"]; //할부개월수
		$pm_chkeckcd=$payinfo["CHKECKCD"]; //신용카드/체크카드

		$pm_pay_key=$payinfo["PAY_KEY"]; //인증추적키


		//----------------------------------------------------------------------------------------
		
		//han_cart update
		$sql=" update ".$dbH."_cart set ct_use='Y',ct_modify=sysdate ";
		$sql.=" where ct_cartid= '".$cartid."' ";
		
		dbcommit($sql);
		
		//넘어간 값이랑 리턴된 값이 맞는지 확인하기( cartid, buy_reqamt,pm_paytype)
		$sql2=" select pm_seq from ".$dbH."_payment where pm_cartid='".$cartid."' and pm_payment = '".$buy_reqamt."' and pm_paytype ='".$pm_paytype."' ";
		$dt=dbone($sql2);

		if($dt["PM_SEQ"])//
		{
			$sql3=" update ".$dbH."_payment  set ";
			$sql3.=" pm_tradeid= '".$tid."' "; //거래고유번호
			$sql3.=" ,pm_contractid= '".$cid."' "; //계약아이디
			//$sql3.=" ,pm_payname= '".$pm_payname."' ";
			//$sql3.=" ,pm_cardbank= '".$pm_cardbank."' ";
			//$sql3.=" ,pm_account= '".$pm_account."' ";
			//$sql3.=" ,pm_confirmno= '".$pm_confirmno."' ";
			//$sql3.=" ,pm_etc='".$pm_etc."' ";
			$sql3.=" ,pm_confirmdate= sysdate ";
			$sql3.=" ,pm_modify= sysdate ";
			
			$sql3.=" ,pm_van_recv_key='".$pm_van_recv_key."' ";
			$sql3.=" ,pm_approvno='".$pm_approvno."' ";
			$sql3.=" ,pm_approdt='".$pm_approdt."' ";
			$sql3.=" ,pm_approtm='".$pm_approtm."' ";
			$sql3.=" ,pm_approamt='".$pm_approamt."' ";

			$sql3.=" ,pm_van_card_mid='".$pm_van_card_mid."' ";
			$sql3.=" ,pm_card_no='".$pm_card_no."' ";
			$sql3.=" ,pm_issue_code='".$pm_issue_code."' ";
			$sql3.=" ,pm_issue_name='".$pm_issue_name."' ";
			$sql3.=" ,pm_purchase_code='".$pm_purchase_code."' ";

			$sql3.=" ,pm_purchase_name='".$pm_purchase_name."' ";
			$sql3.=" ,pm_noint='".$pm_noint."' ";
			$sql3.=" ,pm_quota_momths='".$pm_quota_momths."' ";
			$sql3.=" ,pm_chkeckcd='".$pm_chkeckcd."' ";
			$sql3.=" ,pm_pay_key='".$pm_pay_key."' ";

			$sql3.=" ,pm_status= 'ok' ";
			$sql3.=" ,pm_use='Y' ";		
			$sql3.=" where pm_cartid='".$cartid."' ";

			dbcommit($sql3);
		}
		else
		{
			$sql3=" update ".$dbH."_payment set ";
			$sql3.=" pm_status= 'fail' ";
			$sql3.=" ,pm_use='Y' ";
			$sql3.=" where pm_cartid='".$cartid."' ";

			dbcommit($sql3);
		}


		$json["cartseq"]=$dt["PM_SEQ"];	
		$json["sql"]=$sql;	
		$json["sql3"]=$sql3;	
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>




