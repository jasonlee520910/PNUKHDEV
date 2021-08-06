<?php
	require_once $root.$folder."/_common/lib/SEED128.php";
	require_once $root.$folder."/_common/lib/_lib.delipost.php";

	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odCode=$_GET["odCode"];
	$sendtype=$_GET["sendtype"];	
	$addprint=$_GET["addprint"];//송장추가출력 
	$rdelicode=$_GET["delicode"];//송장번호 

	if($apiCode!="markingdeliverypost"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="markingdeliverypost";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$rsql=" select ";
		$rsql.=" a.re_sendname, a.re_sendphone,a.re_sendmobile, a.re_sendzipcode, a.re_sendzipseq, a.re_sendaddress ";
		$rsql.=", a.re_name, a.re_phone, a.re_mobile, a.re_zipcode, a.re_zipseq, a.re_address, a.re_boxmedicnt  ";
		$rsql.=", a.re_boxmedicntdata as REBOXMEDICNTDATA ";
		$rsql.=", a.re_request as REREQUEST ";
		$rsql.=", a.re_delino, a.re_deliexception ";
		$rsql.=", a.re_boxmedivol, a.re_boxmedipack ";
		$rsql.=" ,b.od_title, b.od_name, b.od_sitecategory, b.od_subject, b.od_packcnt, b.od_packcapa ";
		$rsql.=", cy.orderCode cyodcode ";
		$rsql.=", m.mi_name ";
		$rsql.=" from ".$dbH."_release ";
		$rsql.=" a inner join ".$dbH."_order b on b.od_keycode=a.re_keycode ";
		$rsql.=" left join ".$dbH."_order_client cy on b.od_keycode=cy.keycode ";
		$rsql.=" inner join ".$dbH."_medical m on b.od_userid=m.mi_userid ";
		$rsql.=" where a.re_odcode='".$odCode."' ";
		$rdt=dbone($rsql);

		//한약박스 부피 
		$re_boxmedivol=$rdt["RE_BOXMEDIVOL"];
		//우체국 한약박스 갯수 
		$re_boxmedicnt=$rdt["RE_BOXMEDICNT"];

		//한약박스 갯수 data 
		$re_boxmedicntdata=json_decode(getClob($rdt["REBOXMEDICNTDATA"]), true);

		//han_delicode_post
		$psql=" select count(seq) cnt from ".$dbH."_delicode_post where odcode='".$odCode."' and deliconfirm <> 'C' ";
		$pdt=dbone($psql);
		$postcnt=0;
		if($pdt["CNT"])
		{
			$postcnt=$pdt["CNT"];
		}

		$json["reBoxmedicnt"] = $re_boxmedicnt;
		$json["re_boxmedivol"] = $re_boxmedivol;
		$json["re_boxmedicntdata"] = $re_boxmedicntdata;
		$json["postcnt"] = $postcnt;

		$i=($postcnt>=$re_boxmedicnt) ? 0 : $postcnt;
		$postweight=$re_boxmedicntdata[$i]["weikg"];
		$json["send_i"] = $i;
		$json["send_weight"] = ($postweight)?$postweight:2;


		$reSendname = $rdt["RE_SENDNAME"];//보내는사람 
		$reSendphone = $rdt["RE_SENDPHONE"];//보내는사람 전화번호 
		$reSendmobile = ($rdt["RE_SENDMOBILE"])?$rdt["RE_SENDMOBILE"]:"";//보내는사람 휴대번호
		$reSendzipcode = $rdt["RE_SENDZIPCODE"];//보내는사람 우편번호
		$sendaddr=explode("||",$rdt["RE_SENDADDRESS"]);
		$reSendaddress1 = $sendaddr[0];
		$reSendaddress2 = $sendaddr[1];

		$json["reSendname"] = $reSendname;//보내는사람 
		$json["reSendphone"] = $reSendphone;//보내는사람 전화번호 
		$json["reSendmobile"] = $reSendmobile;//보내는사람 휴대번호
		$json["reSendzipcode"] = $reSendzipcode;//보내는사람 우편번호
		$json["reSendaddress1"] = $reSendaddress1;//보내는사람 주소 
		$json["reSendaddress2"] = $reSendaddress2;//보내는사람 주소 


		$reName = $rdt["RE_NAME"];//받는사람 
		$rePhone = ($rdt["RE_PHONE"]) ? $rdt["RE_PHONE"]:"";//받는사람전화번호
		$reMobile = $rdt["RE_MOBILE"];//받는사람핸드폰
		$reZipcode = $rdt["RE_ZIPCODE"];//받는사람우편번호
		$reAddress = explode("||",$rdt["RE_ADDRESS"]);
		$reAddress1=$reAddress[0];
		$reAddress2=$reAddress[1];

		$json["reName"] = $reName;//받는사람 
		$json["rePhone"] = $rePhone;//받는사람전화번호
		$json["reMobile"] = $reMobile;//받는사람핸드폰
		$json["reZipcode"] = $reZipcode;//받는사람우편번호
		$json["reAddress1"] = $reAddress1;//받는사람 주소
		$json["reAddress2"] = $reAddress2;//받는사람 주소

		$re_delino=$rdt["RE_DELINO"];//송장번호  
		$re_deliexception=($rdt["RE_DELIEXCEPTION"])?$rdt["RE_DELIEXCEPTION"]:"N";//예외처리 
		$json["deliExName"]=getdeliexceptionName($rdt["RE_DELIEXCEPTION"]);

		$json["re_delino"] = $re_delino;//보내는사람 
		$json["re_deliexception"] = $re_deliexception;//보내는사람 

		
		//20191101 : 배송요청사항이 있으면 배송요청사항이 보이고 없으면 기본문구가 보임 
		$re_request=getClob($rdt["REREQUEST"]);
		if($re_request)
		{
			$reRequest=$re_request;//배송요청사항
		}
		else
		{
			$reRequest="배송전 꼭 연락 부탁드립니다. 고가의 의약품이므로 배송과정중 파손시 발송지로 연락 후 반송시켜주세요.";
		}
		$json["reRequest"] = $reRequest;//배송요청사항 

		
		//주문번호 
		$json["odCode"] = $odCode;

		//신청일 
		$json["epostDate"]=date("Y/m/d");

		$json["sendtype"]=$sendtype;
		//주문자 

		$json["miName"]=$rdt["MI_NAME"];
		$od_sitecategory=$rdt["OD_SITECATEGORY"];//사이트 
		$json["od_sitecategory"]=$od_sitecategory;
		$od_name=$rdt["od_name"];//환자명 

		if($rdt["CYODCODE"]){$cyodcode="BK".($rdt["CYODCODE"]+10000);}else{$cyodcode="";}
		if($cyodcode){$od_chartpk=$cyodcode;}

		//품목
		$odTitle=($rdt["OD_SUBJECT"])?$rdt["OD_SUBJECT"]:"";
		$json["odTitle"] = $odTitle;//품목

		//----------------------------------------------------
		//고객번호 조회 
		//----------------------------------------------------
		$custArry=getCustNo();
		if($custArry["stat"]==true)
		{
			$ecustNo=trim($custArry["data"]);
		}
		else
		{
			$ecustNo="";
			$json["고객번호에러"] = $custArry["data"];
		}
		$json["ecustNo"] = $ecustNo;

		if($ecustNo)
		{
			//----------------------------------------------------
			//계약승인번호 조회 
			//----------------------------------------------------
			$apprArry=getApprNo($ecustNo);
			if($apprArry["stat"]==true)
			{
				$eapprNo=trim($apprArry["data"]["apprNo"]);
				$epayTypeCd=trim($apprArry["data"]["payTypeCd"]);
				$epayTypeNm=trim($apprArry["data"]["payTypeNm"]);
				$epostNm=trim($apprArry["data"]["postNm"]);
			}
			else
			{
				$eapprNo=$epayTypeCd=$epayTypeNm=$epostNm="";
				$json["계약승인번호에러"] = $apprArry["data"];
			}
			$json["eapprNo"] = $eapprNo;
			$json["epayTypeCd"] = $epayTypeCd;
			$json["epayTypeNm"] = $epayTypeNm;
			$json["epostNm"] = $epostNm;

			//----------------------------------------------------
			//공급지정보 조회 - 일단은 청연걸로 하자.. 한의별로 바꿔야함..
			//----------------------------------------------------
			$officeArry=getOfficeInfo($ecustNo);
			if($officeArry["stat"]==true)
			{
				$eofficeSer=trim($officeArry["data"]["officeSer"]);
				$eofficeNm=trim($officeArry["data"]["officeNm"]);
				$eofficeZip=trim($officeArry["data"]["officeZip"]);
				$eofficeAddr=trim($officeArry["data"]["officeAddr"]);
				$eofficeTelno=trim($officeArry["data"]["officeTelno"]);
				$econtactNm=trim($officeArry["data"]["contactNm"]);
			}
			else
			{
				$eofficeSer=$eofficeNm=$eofficeZip=$eofficeAddr=$eofficeTelno=$econtactNm="";
				$json["공급지정보에러"] = $officeArry["data"];
			}
			$json["eofficeSer"] = $eofficeSer;
			$json["eofficeNm"] = $eofficeNm;
			$json["eofficeZip"] = $eofficeZip;
			$json["eofficeAddr"] = $eofficeAddr;
			$json["eofficeTelno"] = $eofficeTelno;
			$json["econtactNm"] = $econtactNm;

		
			//----------------------------------------------------
			//집배코드조회 
			//----------------------------------------------------
			$areaArry=getDelivArea($reZipcode,$reAddress1);
			if($areaArry["stat"]==true)
			{
				$earrCnpoNm=trim($areaArry["data"]["arrCnpoNm"]);
				$edelivPoNm=trim($areaArry["data"]["delivPoNm"]);
				$edelivAreaCd=trim($areaArry["data"]["delivAreaCd"]);
			}
			else
			{
				$earrCnpoNm=$edelivPoNm=$edelivAreaCd="";
				$json["집배코드조회에러"] = $areaArry["data"];
			}
			$json["earrCnpoNm"] = $earrCnpoNm;
			$json["edelivPoNm"] = $edelivPoNm;
			$json["edelivAreaCd"] = $edelivAreaCd;			
			//----------------------------------------------------
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
					if($sendtype=="epost")
					{
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
						$sql=" select seq, delitype, delicode, odcode, jsonData as JSONDATA from han_delicode_post where odcode='".$odCode."' and delicode='".$rdelicode."' ";
					//}
					//else
					//{
						//$sql=" select seq, delitype, delicode, odcode, jsonData from han_delicode_post where odcode='".$odCode."' and inuse='Y' and deliconfirm <> 'C' ";
					//}
						$dt=dbone($sql);
						$json["우체국송장체크_sql"]=$sql;
						$json["우체국송장체크_delicode"]=$rdelicode;
						
						$deliseq=$delicode=$delitype="";
						if($dt["DELICODE"])
						{
							$delitype=$dt["DELITYPE"];
							$delicode=$dt["DELICODE"];
							$deliseq=$dt["SEQ"];
							$sendtype="repost";
							$json["sendtype"]=$sendtype;
							$json["delicode"]=$delicode;


							$jsdata=json_decode(getClob($dt["JSONDATA"]), true);
							$json["우체국_jsdata"] = $jsdata;

							$json["epreqNo"] = $jsdata["reqNo"];
							$json["epresNo"] = $jsdata["resNo"];
							$json["epregiNo"] = $jsdata["regiNo"];
							$json["epregiPoNm"] = $jsdata["regiPoNm"];
							$json["epresDate"] = $jsdata["resDate"];
							$json["epprice"] = $jsdata["price"];
							$json["epvTelNo"] = $jsdata["vTelNo"];
							$json["eparrCnpoNm"] = $jsdata["arrCnpoNm"];
							$json["epdelivPoNm"] = $jsdata["delivPoNm"];
							$json["epdelivAreaCd"] = $jsdata["delivAreaCd"];

						}
					}
				}
			}

			//택배신청
			if($ecustNo && $eapprNo && $eofficeSer && $epayTypeCd && $sendtype=="epost")
			{
				//택배신청
				$custNo=$ecustNo;		//우체국 고객번호
				$reqType="1";			//신청구분* (1:신규발송 / 2:반품)
				$officeSer=$eofficeSer;	//공급지(반품처) 코드 기 등록된 공급지코드
				$weight=$postweight;//무게(kg)* (1~30kg, 정수 ※ 미입력 시 default값 : 2kg )
				$volume=$re_boxmedivol;//부피(cm)* ( cm (60,80,100,120,140,160) ※ 미입력 시 default값 : 60cm )
				
				$ordCompNm="부산대 원외탕전실";//고객주문처명
				$json["ordCompNm"]=$ordCompNm;
				
				$ordNm=$reSendname;//주문자명
				$ordZip=$reSendzipcode;//주문자우편번호
				$ordAddr1=$reSendaddress1;//주문자우편번호주소
				$ordAddr2=$reSendaddress2;//주문자상세주소
				$ordTel=str_replace("-","",$reSendphone);//주문자전화번호
				$ordMob=str_replace("-","",$reSendmobile);//주문자핸드폰번호

				$recNm=$reName;//수취인(반품인) 명
				$recZip=$reZipcode;//수취인(반품인) 우편번호
				$recAddr1=$reAddress1;//수취인(반품인) 주소
				$recAddr2=trim($reAddress2);//수취인(반품인) 상세주소
				$len=strlen($recAddr2);
				if($len<1)
				{
					$recAddr2=$reAddress2.".";//수취인(반품인) 상세주소
				}
				else
				{
					$recAddr2=$reAddress2;//수취인(반품인) 상세주소
				}
				

				$recTel=str_replace("-","",$rePhone);//수취인(반품인) 전화번호
				$recMob=str_replace("-","",$reMobile);//수취인(반품인) 이동통신 

				$apprNo=$eapprNo;//승인번호

				if($epayTypeCd=="10" || $epayTypeCd=="12")//10(즉납)/12(후납)
				{
					$payType="1";//요금납부구분 * (1:일반(즉납or후납) / 2:수취인부담 )
				}
				else
				{
					$payType="2";
				}
				$microYn="N";//초소형택배구분(Y/N)*  (초소형계약 시만 사용 (무게 2kg미만))
				$contCd="027";//주요내용품코드* ( 027 의료/건강식품 )

				$goodsNm=$odTitle;//상품명 
				$goodsCd="";//상품코드 g
				$oodsMdl="";//상품모델 
				$goodsSize="";//상품사이즈 
				$goodsColor="";//색상 

				$qty="1";//수량 
				$orderNo=$odCode;//주문번호
				$delivMsg=$reRequest;//배송(반품)메세지
				$retReason="";//반품사유 (반품인 경우)
				$retVisitYmd="";//반품희망방문일 (YYYYMMDD) (반품인 경우 필수) 

				$testYn="Y";//테스트 신청 여부* //데브에서만 Y로 바꾸자 
				$printYn="Y";//자체출력여부 


				$postdata="custNo=".$custNo."&reqType=".$reqType."&officeSer=".$officeSer."&weight=".$weight."&volume=".$volume."&ordCompNm=".$ordCompNm."&ordNm=".$ordNm."&ordZip=".$ordZip."&ordAddr1=".$ordAddr1."&ordAddr2=".$ordAddr2."&ordTel=".$ordTel."&ordMob=".$ordMob."&recNm=".$recNm."&recZip=".$recZip."&recAddr1=".$recAddr1."&recAddr2=".$recAddr2."&recTel=".$recTel."&recMob=".$recMob."&apprNo=".$apprNo."&payType=".$payType."&microYn=".$microYn."&contCd=".$contCd."&goodsNm=".$goodsNm."&goodsCd=".$goodsCd."&oodsMdl=".$oodsMdl."&goodsSize=".$goodsSize."&goodsColor=".$goodsColor."&qty=".$qty."&orderNo=".$orderNo."&delivMsg=".$delivMsg."&retReason=".$retReason."&retVisitYmd=".$retVisitYmd."&testYn=".$testYn."&printYn=".$printYn;

				$json["postdata"]=$postdata;
				$orderArry=InsertOrder($postdata);

				if($orderArry["stat"]==true)
				{
					$epreqNo=trim($orderArry["data"]["reqNo"]);//우체국택배신청번호 (건당부여)
					$epresNo=trim($orderArry["data"]["resNo"]);//예약번호 (일자당 부여) 
					$epregiNo=trim($orderArry["data"]["regiNo"]);//운송장번호 
					$epregiPoNm =trim($orderArry["data"]["regiPoNm"]);//접수우체국 
					$epresDate=trim($orderArry["data"]["resDate"]);//예약일시 
					$epprice=trim($orderArry["data"]["price"]);//예상접수요금 
					$epvTelNo=trim($orderArry["data"]["vTelNo"]);//가상전화번호 
					$eparrCnpoNm=trim($orderArry["data"]["arrCnpoNm"]);//도착집중국명
					$epdelivPoNm=trim($orderArry["data"]["delivPoNm"]);//배달우체국명
					$epdelivAreaCd=trim($orderArry["data"]["delivAreaCd"]);//배달구구분코드

					$json["epreqNo"] = $epreqNo;
					$json["epresNo"] = $epresNo;
					$json["epregiNo"] = $epregiNo;
					$json["epregiPoNm"] = $epregiPoNm;
					$json["epresDate"] = $epresDate;
					$json["epprice"] = $epprice;
					$json["epvTelNo"] = $epvTelNo;
					$json["eparrCnpoNm"] = $eparrCnpoNm;
					$json["epdelivPoNm"] = $epdelivPoNm;
					$json["epdelivAreaCd"] = $epdelivAreaCd;

					$jdata=array("reqNo"=>$epreqNo,"resNo"=>$epresNo,"regiNo"=>$epregiNo,"regiPoNm"=>$epregiPoNm,"resDate"=>$epresDate,"price"=>$epprice,"vTelNo"=>$epvTelNo, "arrCnpoNm"=>$eparrCnpoNm,"delivPoNm"=>$epdelivPoNm,"delivAreaCd"=>$epdelivAreaCd);
					$jsdata=json_encode($jdata);

					$unescaped = preg_replace_callback('/\\\\u(\w{4})/', function ($matches) {
						return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
					}, $jsdata);

					if($addprint=="R")
					{
						//송장코드 테이블에 주문번호 업데이트 
						$usql=" insert into han_delicode_post (SEQ, delitype, delicode, odcode, delivolume, deliweight, deliconfirm, jsonData, inuse, indate, usedate ) ";
						$usql.=" values((SELECT NVL(MAX(SEQ),0)+1 FROM ".$dbH."_delicode_post), 'POST', '".$epregiNo."','".$odCode."', '".$volume."', '".$weight."','N', '".$unescaped."','R', sysdate, sysdate) ";
						dbcommit($usql);
						$json["DOO_delicode"]=$epregiNo;
						$json["DOO_deliusql"]=$usql;
					}
					else
					{
						//송장코드 테이블에 주문번호 업데이트 
						$usql=" insert into han_delicode_post (SEQ, delitype, delicode, odcode, delivolume, deliweight, deliconfirm, jsonData, inuse, indate, usedate ) ";
						$usql.=" values((SELECT NVL(MAX(SEQ),0)+1 FROM ".$dbH."_delicode_post), 'POST', '".$epregiNo."','".$odCode."','".$volume."', '".$weight."','N', '".$unescaped."','Y', sysdate, sysdate) ";
						dbcommit($usql);
						$json["DOO_delicode"]=$epregiNo;
						$json["DOO_deliusql"]=$usql;

						//20191025 : han_release에 송장코드 업데이트 
						$rusql=" update han_release set ";
						$rusql.=" re_delino='".$epregiNo."' ";
						$rusql.=" where re_odcode='".$odCode."' ";
						dbcommit($rusql);
						$json["DOO_delirusql"]=$rusql;
					}
					
					$delicode=$epregiNo;//송장번호 


					//han_delicode_post
					$ppsql=" select count(seq) cnt from ".$dbH."_delicode_post where odcode='".$odCode."' and deliconfirm <> 'C' ";
					$ppdt=dbone($ppsql);
					$postcnt=0;
					if($ppdt["cnt"])
					{
						$postcnt=$ppdt["cnt"];
					}

					$json["postcnt"] = $postcnt;
					$json["delicode"] = $delicode;
					$json["apiCode"] = $apiCode;
					$json["resultCode"]="200";
					$json["resultMessage"]="OK4".$sendtype;
					$json["sendtype"]="repost";
				}
				else
				{
					$json["delicode"] = "";
					$json["apiCode"] = $apiCode;
					$json["resultCode"]="199";
					$json["resultMessage"]="우체국 전송 실패! (".$orderArry["data"].")";
				}

			}
			else
			{
				if($delicode && $delitype && $deliseq)
				{
					$json["apiCode"] = $apiCode;
					$json["resultCode"]="200";
					$json["resultMessage"]="OK5".$sendtype;
				}
				else
				{
					if($ecustNo && $eapprNo && $eofficeSer && $epayTypeCd && $sendtype==null)
					{
						$json["deliCode"]="";
						$json["apiCode"] = $apiCode;
						$json["resultCode"]="200";
						$json["resultMessage"]="OK6".$sendtype;
					}
					else
					{
						$json["apiCode"] = $apiCode;
						$json["resultCode"]="199";
						$json["resultMessage"]="우체국 정보 에러";
						$json["delicode"] = "";
						if(!$ecustNo)
						{
							$json["resultMessage"]="우체국 고객 정보 에러(ecustNo)";
						}

						if(!$eapprNo)
						{
							$json["resultMessage"]="우체국 계약 정보 에러(eapprNo)";
						}

						if(!$eofficeSer)
						{
							$json["resultMessage"]="우체국 공급지 정보 에러(eofficeSer)";
						}

						if(!$epayTypeCd)
						{
							$json["resultMessage"]="우체국 계약 정보 에러(epayTypeCd)";
						}
					}
				}
			}
		}
		else
		{
			$json["apiCode"] = $apiCode;
			$json["resultCode"]="199";
			$json["resultMessage"]=$custArry["data"];
		}

		
	}
	
?>
<?php
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