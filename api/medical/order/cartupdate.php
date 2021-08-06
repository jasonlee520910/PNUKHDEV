<?php //han_cart  han_payment insert
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$carttype=$_POST["carttype"];//bank:무통장, card:신용카드 
	
	
	if($apiCode!="cartupdate"){$json["resultMessage"]="API코드오류2";$apiCode="cartupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="언어코드오류";}
	else
	{	
		$cartid=$_POST["totalbuyItemcd"];  //상품코드

		$totalcartorderno=$_POST["totalcartorderno"];  //keycode		
		$totaloneamount=$_POST["totaloneamount"];  // 각각 가격	

		$totalamount=$_POST["totalamount"];  // 총 가격
		$pm_hash=$_POST["hashkey"];  // hash


		//ct_paytype 결제타입로 추가(카드결제 CC) 현재는 카드결제만 해서 cc로 insert

		/* 안넘어오는 값들	
			$pm_cartid=$_POST["pm_cartid"];  	
			$pm_tradeid=$_POST["pm_tradeid"]; 
			$pm_userid=$_POST["pm_userid"]; 
			$pm_payname=$_POST["pm_payname"]; 
			$pm_cardbank=$_POST["pm_cardbank"]; 
			$pm_account=$_POST["pm_account"]; 
			$pm_confirmno=$_POST["pm_confirmno"]; 
			$pm_confirmdate=$_POST["pm_confirmdate"]; 
			$pm_status=$_POST["pm_status"]; 
			$pm_etc=$_POST["pm_etc"]; 	
		*/
		
		$onecartorderno=explode(",",$totalcartorderno);
				
		$oneamount=explode(",",$totaloneamount);
		$oneamountlen=count($oneamount);

		//-------------------------------------------
		$ct_paytype="CC";
		$pm_status="";
		$pm_cardbank="";
		$pm_account="";
		//-------------------------------------------
		//무통장 
		if($carttype=="bank")
		{
			$ct_paytype="BANK";
			$pm_payname=$_POST["pmPayname"]; 
			$pm_status="ok";
			$depositBank=$_POST["depositBank"]; 
			$bankArr=explode(",",$depositBank);
			$pm_cardbank=$bankArr[0];//은행명(농협)
			$pm_account=$bankArr[1];//계좌번호
		}

		$cartseq=$_POST["cartseq"];//결재할 seq들 
		$json["cartseq"]=$cartseq;
		//-------------------------------------------
		
		for($i=1;$i<$oneamountlen;$i++)
		{				
			$sql=" insert into ".$dbH."_cart (ct_seq,ct_cartid,ct_pdcode,ct_userid,ct_option,ct_qty,ct_price,ct_use,ct_date,ct_paytype) ";
			$sql.=" values ((SELECT NVL(MAX(ct_seq),0)+1 FROM ".$dbH."_cart) ";
			$sql.=",'".$cartid."','".$onecartorderno[$i]."','','','1','".$oneamount[$i]."','A', sysdate,'".$ct_paytype."') ";
			dbcommit($sql);		
		}
		
		//han_payment 에도 insert
		$sql3=" insert into ".$dbH."_payment ";
		$sql3.="(pm_seq,pm_cartid,pm_tradeid ";
		$sql3.=" ,pm_userid,pm_paytype,pm_payment,pm_paycheck,pm_payname,pm_cardbank ";
		$sql3.=" ,pm_account,pm_confirmno,pm_confirmdate,pm_status,pm_etc,pm_use,pm_date,pm_hash)";
		$sql3.=" values ((SELECT NVL(MAX(pm_seq),0)+1 FROM ".$dbH."_payment),'".$cartid."','".$pm_tradeid."'";
		$sql3.=" ,'".$pm_userid."','".$ct_paytype."','".$totalamount."','".$pm_paycheck."','".$pm_payname."','".$pm_cardbank."' ";
		$sql3.=" ,'".$pm_account."','".$pm_confirmno."','".$pm_confirmdate."','".$pm_status."','".$pm_etc."','A',sysdate,'".$pm_hash."') ";
		dbcommit($sql3);

		//han_payment seq 조회
		$sql5=" select pm_seq ";
		$sql5.=" from  ".$dbH."_payment where pm_cartid='".$cartid."' ";
	
		$dt=dbone($sql5);

		$json["seq"]=$dt["PM_SEQ"];	// han_payment seq

		$json["apiCode"]=$apiCode;	
		$json["hashkey"]=$pm_hash;	
		$json["sql"]=$sql;	
		$json["sql3"]=$sql3;
		$json["sql5"]=$sql5;

		

		$json["carttype"]=$carttype;//bank:무통장, card:신용카드 
		$json["_POST"]=$_POST;
		
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";		
	}
?>




