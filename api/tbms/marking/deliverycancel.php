<?php
	require_once $root.$folder."/_common/lib/SEED128.php";
	require_once $root.$folder."/_common/lib/_lib.delipost.php";

	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odCode=$_GET["odCode"];//주문번호 
	$delitype=$_GET["delitype"];//택배회사 	
	$delicode=$_GET["delicode"];//송장번호 

	if($apiCode!="deliverycancel"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="deliverycancel";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$json["odCode"] = $odCode;
		$json["delitype"] = $delitype;
		$json["delicode"] = $delicode;

		if($delitype=="POST" || $delitype=="post")
		{
			$sql=" select jsonData as JSONDATA, to_char(usedate, 'yyyy-mm-dd hh24:mi:ss') as USEDATE from han_delicode_post where odcode='".$odCode."' and delicode='".$delicode."' ";
			$dt=dbone($sql);
			$json["sql"]=$sql;
			$delijsondata=getClob($dt["JSONDATA"]);

			if($delijsondata)
			{
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

				if($ecustNo && $eapprNo)
				{
					$jsdata=json_decode($delijsondata, true);
					$json["우체국_jsdata"] = $jsdata;

					$json["epreqNo"] = $jsdata["reqNo"];//우체국택배신청번호 
					$json["epresNo"] = $jsdata["resNo"];//예약번호 
					$json["epregiNo"] = $jsdata["regiNo"];//운송장번호
					$json["epregiPoNm"] = $jsdata["regiPoNm"];//접수우체국
					$json["epresDate"] = $jsdata["resDate"];//예약일시
					$json["epprice"] = $jsdata["price"];//예약접수요금
					$json["epvTelNo"] = $jsdata["vTelNo"];//가상전화번호
					$json["eparrCnpoNm"] = $jsdata["arrCnpoNm"];//도착집중국명
					$json["epdelivPoNm"] = $jsdata["delivPoNm"];//배달우체국명
					$json["epdelivAreaCd"] = $jsdata["delivAreaCd"];//배달구구분코드 


					$epresDate=substr($jsdata["resDate"], 0, 8);

					$custNo=$ecustNo;//우체국고객번호 
					$apprNo=$eapprNo;//승인번호 
					$reqType="1";//신청구분(1:신청,2.반품)
					$reqNo=$jsdata["reqNo"];//우체국택배신청정보
					$resNo=$jsdata["resNo"];//예약번호
					$regiNo=$jsdata["regiNo"];//운송장번호
					$reqYmd=$epresDate;//신청일자
					$delYn="N";//예약취소 후 삭제여부(Y,N)

					//{"reqNo":"201912066335765873","resNo":"2019120653639075","regiNo":"6892122316034","regiPoNm":"uc7a5uc131uc6b0uccb4uad6d","resDate":"20191206131551","price":"2600","vTelNo":"05055832695","arrCnpoNm":"uc804uc8fcM","delivPoNm":"uc9c4uc548","delivAreaCd":"uc80418300105"}
					//{"reqNo":"201912066335797270","resNo":"2019120600000000","regiNo":"TESTREGINOAPI","regiPoNm":"uc7a5uc131uc6b0uccb4uad6d","resDate":"20191206134905","price":"2600","vTelNo":"","arrCnpoNm":"uc804uc8fcM","delivPoNm":"ub3d9uc804uc8fc","delivAreaCd":"uc80418515103"}
					$ResCancelArry=getResCancelCmd($custNo,$apprNo,$reqType,$reqNo,$resNo,$regiNo,$reqYmd,$delYn);
					$json["취소data"]=$ResCancelArry["data"];

					if($ResCancelArry["stat"]==true)
					{
						$ereqNo=$ResCancelArry["data"]["reqNo"];//우체국택배신청번호
						$eresNo=$ResCancelArry["data"]["resNo"];//예약번호
						$ecancelRegiNo=$ResCancelArry["data"]["cancelRegiNo"];//취소(삭제) 운송장번호
						$ecancelDate=$ResCancelArry["data"]["cancelDate"];//취소일시
						$ecanceledYn=$ResCancelArry["data"]["canceledYn"];// 취소결과 여부(Y,N,D) Y:취소,N:미취소,D:삭제
						$eregiNo=$ResCancelArry["data"]["regiNo"];//취소 후 변경된 운송장번호
						$enotCancelReason=$ResCancelArry["data"]["notcancelReason"];//미 취소 사유 

						$json["취소결과:ereqNo"]=$ereqNo;
						$json["취소결과:eresNo"]=$eresNo;
						$json["취소결과:ecancelRegiNo"]=$ecancelRegiNo;
						$json["취소결과:ecancelDate"]=$ecancelDate;
						$json["취소결과:ecanceledYn"]=$ecanceledYn;
						$json["취소결과:eregiNo"]=$eregiNo;
						$json["취소결과:enotCancelReason"]=$enotCancelReason;
					
						$jdata=array(
							"reqNo"=>$ereqNo,
							"resNo"=>$eresNo,
							"cancelRegiNo"=>$ecancelRegiNo,
							"cancelDate"=>$ecancelDate,
							"canceledYn"=>$ecanceledYn,
							"regiNo"=>$eregiNo,
							"notCancelReason"=>$enotCancelReason
							);
						$jsdata=json_encode($jdata);

						$unescaped = preg_replace_callback('/\\\\u(\w{4})/', function ($matches) {
							return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
						}, $jsdata);

						if($ecanceledYn=="Y")
						{
							//송장코드 테이블에 취소jsondata, deliconfirm=c, inuse=c, 취소된날짜 업데이트 
							$usql=" update han_delicode_post set ";
							$usql.=" canceljsonData='".$unescaped."', deliconfirm='C', canceldate=sysdate ";
							$usql.=" where odcode='".$odCode."' and delicode='".$delicode."' ";
							dbcommit($usql);
							$json["취소usql"]=$usql;

							$json["apiCode"] = $apiCode;
							$json["resultCode"]="200";
							$json["resultMessage"]="OK";
						}
						else
						{
							if($ecanceledYn=="N")
							{
								$json["apiCode"] = $apiCode;
								$json["resultCode"]="198";
								$json["resultMessage"]="취소결과:미취소(".$enotCancelReason.")";
							}
							else if($ecanceledYn=="D")
							{
								$json["apiCode"] = $apiCode;
								$json["resultCode"]="200";
								$json["resultMessage"]="취소결과:삭제(".$enotCancelReason.")";
							}
							else
							{
								$json["apiCode"] = $apiCode;
								$json["resultCode"]="197";
								$json["resultMessage"]="취소결과:실패".$ResCancelArry["data"];
							}

						}

					}
					else
					{
						$json["apiCode"] = $apiCode;
						$json["resultCode"]="197";
						$json["resultMessage"]="취소결과:".$ResCancelArry["data"];
					}

				}
				else
				{
					$json["apiCode"] = $apiCode;
					$json["resultCode"]="197";
					if($ecustNo=="" || $ecustNo==null)
					{
						$json["resultMessage"]="우체국 고객번호가 없습니다.";
					}

					if($eapprNo=="" || $eapprNo==null)
					{
						$json["resultMessage"]="우체국 계약 승인번호가 없습니다.";
					}
				}
			}
			else
			{
				$json["apiCode"] = $apiCode;
				$json["resultCode"]="197";
				$json["resultMessage"]="정보가 없습니다.";
			}

		}
		else if($delitype=="LOGEN" || $delitype=="logen")
		{
			//송장코드 테이블에 취소jsondata, deliconfirm=c, inuse=c, 취소된날짜 업데이트 
			$usql=" update han_delicode set ";
			$usql.=" deliconfirm='C', canceldate=sysdate ";
			$usql.=" where odcode='".$odCode."' and delicode='".$delicode."' ";
			dbqry($usql);
			$json["취소usql"]=$usql;

			$json["apiCode"] = $apiCode;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";

			//$json["apiCode"] = $apiCode;
			//$json["resultCode"]="199";
			//$json["resultMessage"]="준비중입니다.";
		}
		else
		{
			$json["apiCode"] = $apiCode;
			$json["resultCode"]="199";
			$json["resultMessage"]="준비중입니다.";
		}

	}
?>