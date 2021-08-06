<?php
	//로젠 안해도됨 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$type=$_GET["type"];
	$odCode=$_GET["odCode"];
	$zipCode=$_GET["zipCode"];
	$sendtype=$_GET["sendtype"];
	$addprint=$_GET["addprint"];//송장추가출력 
	$rdelicode=$_GET["delicode"];//송장번호 -재출력 

	if($apiCode!="markingdelivery"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="markingdelivery";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$rsql=" select ";
		$rsql.=" a.re_sendname, a.re_sendphone,a.re_sendmobile, a.re_sendzipcode, a.re_sendzipseq, a.re_sendaddress ";
		$rsql.=", a.re_name, a.re_phone, a.re_mobile, a.re_zipcode, a.re_zipseq, a.re_address, a.re_request ";
		$rsql.=", a.re_addrdestination, a.re_addrroadname, a.re_addrclassification, a.re_addrjeju, a.re_addrsea, a.re_addrmountain, a.re_delino, a.re_deliexception ";
		$rsql.=" ,b.od_title, b.od_name, b.od_sitecategory, b.od_subject ";
		$rsql.=", y.od_chartpk ";
		$rsql.=", cy.orderCode cyodcode ";
		$rsql.=" from ".$dbH."_release ";
		$rsql.=" a inner join ".$dbH."_order b on b.od_keycode=a.re_keycode ";
		$rsql.=" left join ".$dbH."_order_okchart y on b.od_keycode=y.od_keycode ";
		$rsql.=" left join ".$dbH."_order_client cy on b.od_keycode=cy.keycode ";
		$rsql.=" where a.re_odcode='".$odCode."' ";
		$rdt=dbone($rsql);

		$json["rsql"] = $rsql;//보내는사람 

		$od_name=$rdt["od_name"];//환자명 
		$json["od_name"] = $od_name;//보내는사람 
		$od_sitecategory=$rdt["od_sitecategory"];//환자명 
		$json["od_sitecategory"]=$od_sitecategory;

		$od_chartpk=$rdt["od_chartpk"];//환자명 
		$json["od_chartpk"] = $od_chartpk;//보내는사람 
		$cyodcode=$rdt["cyodcode"];//환자명 
		$json["cyodcode"] = $cyodcode;//보내는사람 

		$re_delino=$rdt["re_delino"];//송장번호  
		$re_deliexception=$rdt["re_deliexception"];//예외처리 
		$json["deliExName"]=getdeliexceptionName($rdt["re_deliexception"]);

		$json["re_delino"] = $re_delino;//보내는사람 
		$json["re_deliexception"] = $re_deliexception;//보내는사람 


		$reSendname = $rdt["re_sendname"];//보내는사람 
		$reSendphone = $rdt["re_sendphone"];//보내는사람 전화번호 
		$reSendmobile = $rdt["re_sendmobile"];//보내는사람 휴대번호
		$reSendzipcode = $rdt["re_sendzipcode"];//보내는사람 우편번호
		$reSendzipseq = $rdt["re_sendzipseq"];//보내는사람 우편번호 seq
		$sendaddr=explode("||",$rdt["re_sendaddress"]);
		$reSendaddress1 = $sendaddr[0];
		$reSendaddress2 = $sendaddr[1];

		$json["reSendname"] = $reSendname;//보내는사람 
		$json["reSendphone"] = $reSendphone;//보내는사람 전화번호 
		$json["reSendmobile"] = $reSendmobile;//보내는사람 휴대번호
		$json["reSendzipcode"] = $reSendzipcode;//보내는사람 우편번호
		$json["reSendzipseq"] = $reSendzipseq;//보내는사람 우편번호 seq
		$json["reSendaddress1"] = $reSendaddress1;//보내는사람 주소 
		$json["reSendaddress2"] = $reSendaddress2;//보내는사람 주소 


		$reName = $rdt["re_name"];//받는사람 
		$rePhone = $rdt["re_phone"];//받는사람전화번호
		$reMobile = $rdt["re_mobile"];//받는사람핸드폰
		$reZipcode = $rdt["re_zipcode"];//받는사람우편번호
		$reZipseq = $rdt["re_zipseq"];//받는사람우편번호 seq
		$reAddress = explode("||",$rdt["re_address"]);
		$reAddress1=$reAddress[0];
		$reAddress2=$reAddress[1];

		$json["reName"] = $reName;//받는사람 
		$json["rePhone"] = $rePhone;//받는사람전화번호
		$json["reMobile"] = $reMobile;//받는사람핸드폰
		$json["reZipcode"] = $reZipcode;//받는사람우편번호
		$json["reZipseq"] = $reZipseq;//받는사람우편번호 seq
		$json["reAddress1"] = $reAddress1;//받는사람 주소
		$json["reAddress2"] = $reAddress2;//받는사람 주소


		//20191101 : 배송요청사항이 있으면 배송요청사항이 보이고 없으면 기본문구가 보임 
		if($rdt["re_request"])
		{
			$reRequest=$rdt["re_request"];//배송요청사항
		}
		else
		{
			$reRequest="배송전 꼭 연락 부탁드립니다. 고가의 의약품이므로 배송과정중 파손시 발송지로 연락 후 반송시켜주세요.";
		}
		$json["reRequest"] = $reRequest;//배송요청사항 

		if($rdt["od_chartpk"]){$od_chartpk="OK".$rdt["od_chartpk"];}else{$od_chartpk="";}
		if($rdt["cyodcode"]){$cyodcode="BK".($rdt["cyodcode"]+10000);}else{$cyodcode="";}
		if($cyodcode){$od_chartpk=$cyodcode;}

		/*if($od_sitecategory=="CY" || $od_sitecategory=="OKCHART")
		{
			if($od_name==$reName)//환자명이 받는사람과 같을 경우 
			{
				$odTitle="한약[".$od_chartpk."]";
				$json["odTitle"] = $odTitle;//처방명 
			}
			else
			{
				if($reName==$reSendname)
				{
					$odTitle=$rdt["od_title"]." ".$od_name."[".$od_chartpk."]";
					$json["odTitle"] = $odTitle;//처방명 
				}
				else
				{
					$odTitle=$rdt["od_title"];
					$json["odTitle"] = $odTitle;//처방명 
				}
			}
		}
		else
		{
			$odTitle=$rdt["od_title"];
			$json["odTitle"] = $odTitle;//처방명 
		}*/
		//품목
		$odTitle=($rdt["od_subject"])?$rdt["od_subject"]:"";
		$json["odTitle"] = $odTitle;//품목 

		//20191031 : 우리DB에 저장된 도착점 가져오자 
		$DestinationCode=$rdt["re_addrdestination"];//도착점코드(3)
		$jejuCheck=$rdt["re_addrjeju"];//제주지역여부(1)
		$seaCheck=$rdt["re_addrsea"];//해운지역여부(1)
		$mountainCheck=$rdt["re_addrmountain"];//산간지역여부(1)

		$json["DestinationCode"]=$DestinationCode;//도착점코드(3)
		$json["RoadName"]=$rdt["re_addrroadname"];//도로명
		$json["ClassificationCode"]=$rdt["re_addrclassification"];//분류코드(6)
		$json["ZipCode"]="";//우편번호(5)
		$json["jejuCheck"]=$jejuCheck;//제주지역여부(1)
		$json["seaCheck"]=$seaCheck;//해운지역여부(1)
		$json["mountainCheck"]=$mountainCheck;//산간지역여부(1)

		$json["LOGEN_SERVER_URL"]=$LOGEN_SERVER_URL;

		//---------------------------------------
		//20191106 : 계약단가 가져오자 
		$freightType="030";//운임구분 (010(선불) / 020(착불) / 030(신용))
		include_once $root.$folder."/marking/logenpriceamt.php";
		//---------------------------------------
		//20191030 : 받는사람 도착점 코드 가져오자
		$strAddr=$reAddress1;
		if(!$DestinationCode)
		{
			include_once $root.$folder."/marking/logenrcvdivcd.php";
		}
		//---------------------------------------
		//20191030 : 계약 영업소 정보 가져오자 
		include_once $root.$folder."/marking/logenfixcustsales.php";
		//---------------------------------------
		//20191030 : 배송영업소명 가져오자 
		include_once $root.$folder."/marking/logensalesnm.php";
		//---------------------------------------

		//업체코드
		$json["userID"]=$userID;
		//발송일
		$json["reDeliDate"]=date("Y-m-d");
		//배송예정일
		$json["reScheduleDate"]=date("Y-m-d",strtotime ("+1 days"));

		//============================================================================================
		//20191029 : 송장번호 가져오기 
		//odcode 넘어온 주문번호로 검색하여 있는지 체크 
		//============================================================================================
		if($re_delino && strpos($re_deliexception, ",T") !==false)
		{
			$delitype="";
			$delicode="";
			$deliseq="";
		}
		else
		{
			if($addprint=="R")//추가출력 
			{
				if($sendtype=="logen")
				{
					$delitype="LOGEN";
					$rsql = " select seq, delitype, delicode from han_delicode where odcode is null and inuse='A' and delitype='".$delitype."' order by seq asc limit 1 ";
					$rdt=dbone($rsql);

					if($rdt["delicode"])
					{
						$delitype=$rdt["delitype"];
						$delicode=$rdt["delicode"];
						$deliseq=$rdt["seq"];
						$json["addprint"]=$addprint;

						//송장번호 나올시에 바로 업데이트 한다. 
						$usql=" update han_delicode set ";
						$usql.=" odcode='".$odCode."', inuse='R' ";
						$usql.=" where delicode='".$delicode."' ";
						dbqry($usql);
					}
				}
				else
				{
					$sendtype="";
					$json["addprint"]=$addprint;
				}

			}
			else
			{
				if($rdelicode)
				{
					$sql=" select seq, delitype, delicode, odcode from han_delicode where odcode='".$odCode."' and delicode='".$rdelicode."' ";
				}
				else
				{
					$sql=" select seq, delitype, delicode, odcode, usedate from han_delicode where odcode='".$odCode."' and inuse='Y' and deliconfirm <> 'C' ";
				}
				$dt=dbone($sql);


				$deliseq=$delicode=$delitype="";
				if($dt["delicode"])
				{
					$delitype=$dt["delitype"];
					$delicode=$dt["delicode"];
					$deliseq=$dt["seq"];
					$usedate=$dt["usedate"];
					if($usedate)
					{
						$sendtype="relogen";
					}
					else
					{
						$sendtype="logen";
					}
				}
				else
				{	
					if($sendtype=="logen")
					{
						$delitype="LOGEN";
						$rsql = " select seq, delitype, delicode from han_delicode where odcode is null and inuse='A' and delitype='".$delitype."' order by seq asc limit 1 ";
						$rdt=dbone($rsql);

						if($rdt["delicode"])
						{
							$delitype=$rdt["delitype"];
							$delicode=$rdt["delicode"];
							$deliseq=$rdt["seq"];

							//송장번호 나올시에 바로 업데이트 한다. 
							$usql=" update han_delicode set ";
							$usql.=" odcode='".$odCode."', inuse='Y' ";
							$usql.=" where delicode='".$delicode."' ";
							dbqry($usql);
						}
					}
				}
			}
		}
		$json["deliseq"]=$deliseq;
		$json["deliType"]=$delitype;
		$json["deliCode"]=$delicode;
		//============================================================================================

		$json["sendtype"]=$sendtype;

		//---------------------------------------
		if($DestinationCode && $delicode && $sendtype=="logen")//도착점코드, 송장코드 둘다 있을때 
		{
			//로젠으로 보낼 데이터들 
			$printYn="Y";//출력여부

			$slipNo=$delicode;//송장번호 (96012340000)

			$fixCustCd=$userID;//거래처코드 (업체계약코드)

			$sndCustNm=$reSendname;//송하인명
			$sndTelNo=$reSendphone;//송)연락처
			$sndHandNo=$reSendmobile;//송)휴대폰
			$sndZipCd=$reSendzipcode;//송)하인우편번호
			$sndZipSeq=$reSendzipseq;//송)우편일련변호
			$sndCustAddr1=$reSendaddress1;//송)주소1 (서울 용산구 한강로3가)
			$sndCustAddr2=$reSendaddress2;//송)주소2 (삼구빌딩 )

			$rcvCustNm=$reName;//수하인명 (홍길동)
			$rcvTelNo=$rePhone;//수)전화 (02-xxxx-xxxx)
			$rcvHandNo=$reMobile;//수)휴대폰 (010-xxxx-xxxx)
			$rcvZipCd=$reZipcode;//수)우편번호
			$rcvZipSeq=$reZipseq;//수)우편일련번호
			$rcvCustAddr1=$reAddress1;//수)주소1 (서울 서초구 서초동)
			$rcvCustAddr2=$reAddress2;//수)주소2 (삼익빌라 xxx호)

			
			$json["freightType"]=$freightType;//운임구분 
			$json["freightName"]=getFreightName($freightType);//운임구분명 
			
			$qty="1";//박스수량 (1 (고정))
			$json["qty"]=$qty;

			$rcvBranCd=$DestinationCode;//배송지코드 (2.20 참조 (도착점코드3자리))
			$goodsNm=$odTitle;//상품명 (상품명)

			//$priceAmt="3500";//택배운임 (3000) //우리꺼에서는 release에서 re_price로 해도 될듯..근데 일단은..어떻게 할지는..물어보자 
			$json["priceAmt"]=$priceAmt;
			$priceEncry=getpriceencryption($freightType, $priceAmt);
			$json["priceEncry"]=$priceEncry;

			$extraAmt="0";//할증운임 (7.기타운임표기법의 할증운임 계산법 )
			$goodsAmt="0";//상품금액
			$airAmtType="";//제주운임구분 (항공운임이 발생하는 경우 운임구분과 동일)
			$shipAmtYn="";//해운운임구분 (010(선불) 또는 공백,단, 선착불이 착불인경우 발송 못함)
			$takeDt=date("Y-m-d");//접수일자
			$remarks="";//비고
			$fixTakeNo=$odCode;//접수번호(주문번호)

			//$jejuCheck=$gData[4];//제주지역여부(1)
			//$seaCheck=$gData[5];//해운지역여부(1)
			//$mountainCheck=$gData[6];//산간지역여부(1)
			//1) 제주(항공)여부가 Y인 경우 제주선불, 또는 제주착불을 표시해야 합니다.
			//2) 해운지역코드가 존재할 경우 (해운지역)이라고 표시해야 합니다.
			//3) 산간지역여부가 Y인 경우 (산간지역)이라고 표시해야 합니다.
			//4) 해운지역코드가 존재하고 산간지역여부가 Y인경우 (산간/해운)이라고 표시해야 합니다.
			//5) 운임구분이 착불이고 산간지역여부가 Y이면 합계금액을 표시해야 합니다.
			//   (산간지역은 송장당 500원의 산간료가 발생합니다) 
			//예) 운임구분이 착불이고 택배요금이 5,000원, 산간지역이면 합계금액에 5,500원 표기

			$param=array('parameters' => array(
					'userID'=>$userID,
					'passWord'=>$passWord,
					'printYn'=>$printYn,
					'slipNo'=>$slipNo,
					'fixCustCd'=>$fixCustCd,
					'sndCustNm'=>$sndCustNm,
					'sndTelNo'=>$sndTelNo,
					'sndHandNo'=>$sndHandNo,
					'sndZipCd'=>$sndZipCd,
					'sndZipSeq'=>$sndZipSeq,
					'sndCustAddr1'=>$sndCustAddr1,
					'sndCustAddr2'=>$sndCustAddr2,
					'rcvCustNm'=>$rcvCustNm,
					'rcvTelNo'=>$rcvTelNo,
					'rcvHandNo'=>$rcvHandNo,
					'rcvZipCd'=>$rcvZipCd,
					'rcvZipSeq'=>$rcvZipSeq,
					'rcvCustAddr1'=>$rcvCustAddr1,
					'rcvCustAddr2'=>$rcvCustAddr2,
					'freightType'=>$freightType,
					'qty'=>$qty,
					'rcvBranCd'=>$rcvBranCd,
					'goodsNm'=>$goodsNm,
					'priceAmt'=>$priceAmt,
					'extraAmt'=>$extraAmt,
					'goodsAmt'=>$goodsAmt,
					'airAmtType'=>$airAmtType,
					'shipAmtYn'=>$shipAmtYn,
					'takeDt'=>$takeDt,
					'remarks'=>$remarks,
					'fixTakeNo'=>$fixTakeNo
				));

			$json["LOGEN_송장출력데이터_param"]=$param;

			//자체시스템(쇼핑몰,ERP 등)에서 송장 출력 주문데이터 
			$client=new SoapClient($LOGEN_SERVER_URL);
			$narray = $client->__call('W_PHP_Tx_Order_Save',$param);
			$nvar = $narray->W_PHP_Tx_Order_SaveResult; 
			$json["LOGEN_송장출력주문_nvar"]=$nvar;

			if($nvar=="TRUE")
			{
				if($addprint=="R")
				{
					//송장코드 테이블에 주문번호 업데이트 
					$usql=" update han_delicode set ";
					$usql.=" usedate=sysdate ";
					$usql.=" where delicode='".$delicode."' ";
					dbqry($usql);
					$json["DOO_delicode"]=$delicode;
					$json["DOO_deliusql"]=$usql;
					//추가출력일 경우에는 release에  업데이트 안함 

				}
				else
				{
					//송장코드 테이블에 주문번호 업데이트 
					$usql=" update han_delicode set ";
					$usql.=" usedate=sysdate ";
					$usql.=" where delicode='".$delicode."' ";
					dbqry($usql);
					$json["DOO_delicode"]=$delicode;
					$json["DOO_deliusql"]=$usql;

					//20191025 : han_release에 송장코드 업데이트 
					$rusql=" update han_release set ";
					$rusql.=" re_delino='".$delicode."', re_modify=sysdate ";
					$rusql.=" where re_odcode='".$odCode."' ";
					dbqry($rusql);
					$json["DOO_delirusql"]=$rusql;
				}

				$json["sendtype"]="relogen";
				$json["apiCode"] = $apiCode;
				$json["resultCode"]="200";
				$json["resultMessage"]="OK1";
			}
			else
			{
				$json["apiCode"] = $apiCode;
				$json["resultCode"]="199";
				$json["resultMessage"]="로젠 전송 실패! 다시 출력해 주세요.";
				$json["deliCode"]="";
			}
		}
		else
		{
			if($delicode && $delitype && $deliseq)
			{
				$json["apiCode"] = $apiCode;
				$json["resultCode"]="200";
				$json["resultMessage"]="OK2".$sendtype;

				$priceEncry=getpriceencryption($freightType, $priceAmt);
				$json["priceEncry"]=$priceEncry;
				$json["freightName"]=getFreightName($freightType);//운임구분명 
			}
			else
			{
				$json["apiCode"] = $apiCode;
				if($sendtype==null)
				{
					$json["deliCode"]="";
					$json["resultCode"]="200";
					$json["resultMessage"]="OK3".$sendtype;
				}
				else
				{
					if(!$DestinationCode)
					{
						$json["resultCode"]="199";
						$json["deliCode"]="";
						$json["resultMessage"]="도착점 코드가 없습니다.";
					}
					if(!$delicode)
					{
						$json["resultCode"]="199";
						$json["deliCode"]="";
						$json["resultMessage"]="송장번호가 없습니다.";
					}
				}
			}
		}
			
	}
	function curl_post($domain,$group,$jsondata)
	{
		$apiurl=$domain.$group."/";

		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $apiurl);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsondata);
		curl_setopt($ch, CURLOPT_POSTFIELDSIZE, 0); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}

	function getFreightName($freightType)
	{
		switch($freightType)
		{
		case "010":
			return "선불";
		case "020":
			return "착불";
		case "030":
			return "신용";
		}
		return "";
	}
	function getpriceencryption($freightType, $price)
	{
		if($freightType=="020")
		{
			$newprice=$price;
		}
		else
		{
			if($price >= 11000)
			{
				$newprice=$price;
			}
			else
			{
				$price=floor($price/100)*100;//100원단위 절삭 
				$bakprice=str_pad($price, 5, "0", STR_PAD_LEFT);
				$thousand=intval(substr($bakprice, 0, 2));
				$hundred=intval(substr($bakprice, 2, 1));
				$thousandName=65+$thousand;
				$newprice="(".chr($thousandName).")".$hundred;
			}
		}

		return $newprice;
	}
	function getdeliexceptionName($re_deliexception)
	{
		$str="";
		if(strpos($re_deliexception, "O") !== false)
		{
			$str.="해외배송,";
		}
		if(strpos($re_deliexception, "T") !== false)
		{
			$str.="묶음배송,";
		}
		if(strpos($re_deliexception, "D") !== false)
		{
			$str.="직배";
		}

		return $str;
	}	
?>