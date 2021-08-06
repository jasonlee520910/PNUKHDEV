<?php  //결제되고 난뒤 
	$root="..";
	include_once($root."/_Inc/_define.php");  //$NET_URL_API_MEDICAL 가져오기

	function curl_post($domain,$url,$code,$data)
	{
		$language=$_COOKIE["ck_language"];
		if(!$language){$language="kor";}
		$url=$domain."".$url."/";
		$post_data["apiCode"]=$code;
		$post_data["language"]=$language;
		$post_data["postdata"]=$data;
		//var_dump($post_data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1); //0이 default 값이며 POST 통신을 위해 1로 설정해야 함
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); //POST로 보낼 데이터 지정하기
		curl_setopt($ch, CURLOPT_POSTFIELDSIZE, 0); //이 값을 0으로 해야 알아서 &post_data 크기를 측정하는듯
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('ck_authkey:'.urlencode($_COOKIE["ck_authkey"]), 'ck_stStaffid:'.$_COOKIE["ck_stStaffid"]));
		$result = curl_exec($ch);
		curl_close ($ch);
		return $result;
	}

	
	$RESULT_CODE = $_POST["RESULT_CODE"];
	$RESULT_MSG = $_POST["RESULT_MSG"];
	$DRESULT_CODE = $_POST["DRESULT_CODE"];
	$DRESULT_MSG = $_POST["DRESULT_MSG"];

	$result_array = Array();
	$PAY_INFO = Array();

	$PAY_INFO["PAY_METHOD"] = $_POST["PAY_METHOD"];							//VA:가상계좌  CC:신용카드                

	if($RESULT_CODE == "EC0000") { // 성공시

		if($PAY_INFO["PAY_METHOD"] == "CC"){
			$PAY_INFO["MSG_CODE"] = "1000";									//승인코드
		}else if($PAY_INFO["PAY_METHOD"] == "BA"){
			$PAY_INFO["MSG_CODE"] = "2000";
		}else if($PAY_INFO["PAY_METHOD"] == "VA"){
			$PAY_INFO["MSG_CODE"] = "3000";
		}
		
		$PAY_INFO["MID"] = $_POST["MID"];									//상점ID      
		//결제하는 상점이 다수일 경우 pgcs.cfg설정파일의 KEY_STORE_TYPE항목을 ETC로 변경 후
		//결제진행 하고자하는 상점정보를 MID, API_KEY를 payInfo에 넣어준다.
		//$PAY_INFO["MID"] = "";
		//$PAY_INFO["API_KEY"] = "";           
		$PAY_INFO["CID"] = $_POST["CID"];									//계약ID                       
		$PAY_INFO["TID"] = $_POST["TID"];									//원거래번호                   
		$PAY_INFO["ORDERNO"] = $_POST["ORDERNO"];							//주문번호                     
		$PAY_INFO["BUYER_NM"] = $_POST["BUYER_NM"];							//구매자명                     
		$PAY_INFO["BUYER_EMAIL"] = $_POST["BUYER_EMAIL"];					//구매자E-MAIL                 
		$PAY_INFO["BUY_REQAMT"] = $_POST["BUY_REQAMT"];						//상품금액                     
		$PAY_INFO["BANK_CD"] = $_POST["BANK_CD"];							//선택한 은행코드              
		$PAY_INFO["TRBEGIN"] = $_POST["TRBEGIN"];							//입금시작일                   
		$PAY_INFO["TREND"] = $_POST["TREND"];								//입금종료일                   
		$PAY_INFO["CATR_ISSUE_YN"] = $_POST["CATR_ISSUE_YN"];				//현금영수증 발급 여부코드 목록
		$PAY_INFO["CATR_ISSUE_METHOD"] = $_POST["CATR_ISSUE_METHOD"];		//현금영수증 발급수단          
		$PAY_INFO["CATR_ISSUE_TYPE"] = $_POST["CATR_ISSUE_TYPE"];			//현금영수증 발급 용도         
		$PAY_INFO["CATR_ISSUE_CONTENTS"] = $_POST["CATR_ISSUE_CONTENTS"];	//현금영수증 발급 내용         
		$PAY_INFO["CORP_TYPE"] = $_POST["CORP_TYPE"];						//고객유형(법인/개인)          
		$PAY_INFO["CURRENCY_TYPE"] = $_POST["CURRENCY_TYPE"];				//통화유형                     
		$PAY_INFO["RESERVED01"] = $_POST["RESERVED01"];						//예약필드1
		$CARTSEQ=$_POST["RESERVED01"];
		$PAY_INFO["RESERVED02"] = $_POST["RESERVED02"];						//예약필드2                    
		$PAY_INFO["PAYMENT_TYPE"] = $_POST["PAYMENT_TYPE"];					//ISP/SMPI/XMPI/KMPI/KBAPP/LOCAL01/LOCAL02
		$PAY_INFO["PAY_KEY"] = $_POST["PAY_KEY"];							//인증추적키
		$PAY_INFO["BANK_NM"] = $_POST["BANK_NM"];							//은행명
		$PAY_INFO["ESCR_FLAG"] = $_POST["ESCR_FLAG"];						//에스크로 적용여부
			
		// 승인응답 --------------------------------------------------------------------------
		if($PAY_INFO["PAY_METHOD"] == "CC"){
			//$run = "java -jar /home/T-PGCS/bin/ccPayHandler-1.0.0.jar";
			$run = "java -jar /PG/web/bin/ccPayHandler-1.0.3.jar";
			//$path="/home/T-PGCS/config/pgcs.cfg";
			$path = "/PG/web/config/pgcs.cfg";
		} else if($PAY_INFO["PAY_METHOD"] == "BA"){
			//$run = "java -jar /home/T-PGCS/bin/ccPayHandler-1.0.0.jar";
			$run = "java -jar /PG/web/bin/baPayHandler-1.0.3.jar";
			$path = "/PG/web/config/pgcs.cfg";
		} else if($PAY_INFO["PAY_METHOD"] == "VA"){
			$run = "java -jar /PG/web/bin/vaPayHandler-1.0.3.jar";
			$path = "/PG/web/config/pgcs.cfg";
		}
		$arg = http_build_query($PAY_INFO);
		$flag = "PAY";
		$space=" ";
		$cmd=$run.$space.escapeshellarg($PAY_INFO["PAY_METHOD"]).$space.escapeshellarg($flag).$space."\"".$arg."\"".$space.escapeshellarg($path);
		//echo $cmd;

		$payresult = exec($cmd);
		
		parse_str($payresult, $result_array);


	} else { // 실패시
		$result_array["RESULT_CODE"] = $RESULT_CODE;
		$result_array["RESULT_MSG"] = $RESULT_MSG;
		$result_array["DRESULT_CODE"] = $DRESULT_CODE;
		$result_array["DRESULT_MSG"] = $DRESULT_MSG;
	}

	
	//var_dump($_POST);
	//var_dump($payresult);
	//var_dump($result_array);
	//$result=curl_get($NET_URL_API_MANAGER, "setting","textdbfront","type=manager");
	//var_dump($result);
	//$jdata=json_decode($result,true);
	//var_dump($jdata);
	//header("Location:/Payment/");

	//echo json_encode($PAY_INFO);
	$result=curl_post($NET_URL_API_MEDICAL, "order","payafterupdate",json_encode($PAY_INFO)); //callapi("POST","/medical/order/",getdata("payafterupdate"));   
	//var_dump($result);

	$result=json_decode($result,true);


	if($result["apiCode"]=="payafterupdate")  
	{
		if($result["resultCode"]=="200")
		{
				$cartseq=array("cartseq"=>$CARTSEQ, "carttype"=>"card");
				$result2=curl_post($NET_URL_API_MEDICAL, "order","orderpayment",($cartseq)); //callapi("POST","/medical/order/",getdata("orderpayment")); 
				$result2=json_decode($result2,true);
				//var_dump($result2);
				//echo "<br><br>";

				if($result2["apiCode"]=="orderpayment")  
				{	
						if($result2["resultCode"]=="200")
						{
							echo "<script>alert('결재가 완료되었습니다.');</script>";
							echo "<script>location.replace('/Payment/')</script>" ;
						}
						else if($result2["resultCode"]=="199")
						{
							echo "<script>alert('결재할 데이터가 없습니다. 다시 확인해 주시기 바랍니다.');</script>";
							
						}	
				}
		}
		else
		{		
			echo "<script>alert('결제가 정상적으로 이루어지지 않았습니다.');</script>";	
		}
	
	}
	else
	{		
		echo "<script>alert('".$result."');</script>";	
	}

?>
