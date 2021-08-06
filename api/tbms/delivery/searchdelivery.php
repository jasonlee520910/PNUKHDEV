<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$returnData=$_GET["returnData"];
	$deliCode=$_GET["deliCode"];
	
	if($apiCode!="searchdelivery"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="searchdelivery";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($deliCode==""){$json["resultMessage"]="API(odCode) ERROR";}
	else
	{
		/*$sql=" select 
					a.re_odcode, a.re_sendname, a.re_sendaddress, a.re_name, a.re_address
					, a.re_delicomp, a.re_delino, a.re_confirm
					, b.od_code, b.od_title, b.od_status 
					from ".$dbH."_release a 
					inner join ".$dbH."_order b on a.re_odcode=b.od_code 
					where a.re_delino='".$deliCode."'"; */

		//20191023 : han_delicode 추가 
		//로젠은 제거 
		/*
		$sql=" select 
				a.re_odcode, a.re_sendname, a.re_sendaddress, a.re_name, a.re_address, a.re_delicomp, a.re_delino
				, c.deliconfirm logenConfirm, c.delitype logenDeliType, c.usedate logenUseDate
				, b.od_code, b.od_title, b.od_status 
				, d.deliconfirm postConfirm, d.delitype postDeliType, d.usedate postUseDate
				from han_order b 
				inner join han_release a on a.re_odcode=b.od_code 
				left join han_delicode c on c.odcode=b.od_code
				left join han_delicode_post d on d.odcode=b.od_code
				where c.delicode='".$deliCode."' or d.delicode='".$deliCode."' ";
				*/
		$sql=" select 
				a.re_odcode, a.re_sendname, a.re_sendaddress, a.re_name, a.re_address, a.re_delicomp, a.re_delino
				, b.od_code, b.od_title, b.od_status 
				, d.deliconfirm postConfirm, d.delitype postDeliType, d.usedate postUseDate
				from han_order b 
				inner join han_release a on a.re_odcode=b.od_code 
				left join han_delicode_post d on d.odcode=b.od_code
				where d.delicode='".$deliCode."' ";

		$dt=dbone($sql);
		$od_status=$dt["OD_STATUS"];

		//if($dt["LOGENCONFIRM"]){$deliconfirm=$dt["LOGENCONFIRM"];}
		if($dt["POSTCONFIRM"]){$deliconfirm=$dt["POSTCONFIRM"];}

		//if($dt["LOGENDELITYPE"]){$delitype=$dt["LOGENDELITYPE"];}
		if($dt["POSTDELITYPE"]){$delitype=$dt["POSTDELITYPE"];}

		//$useDate=$dt["LOGENUSEDATE"];
		//if($dt["LOGENUSEDATE"]){$useDate=$dt["LOGENUSEDATE"];}
		if($dt["POSTUSEDATE"]){$useDate=$dt["POSTUSEDATE"];}

		if($od_status=="done" && $deliconfirm=="N" && $useDate) 
		{
			//if($delitype=="logen" || $delitype=="LOGEN")
			//{
				//20191023 : 기존 han_release에서 han_delicode로 테이블 변경 및  배송확인, 배송확인일 update 
				//$usql=" update ".$dbH."_delicode set deliconfirm = 'Y', confirmdate=sysdate  where delicode='".$deliCode."'";
				//dbqry($usql);
			//}
			//else if($delitype=="post" || $delitype=="POST")
			//{
				$usql=" update ".$dbH."_delicode_post set deliconfirm = 'Y', confirmdate=sysdate  where delicode='".$deliCode."'";
				dbcommit($usql);
			//}

			//20191023 : 주소에 있는 || 제거 
			$re_sendaddress=str_replace("||","",$dt["RE_SENDADDRESS"]);
			$re_address=str_replace("||","",$dt["RE_ADDRESS"]);

			$deliInfo=array(
				"odCode"=>$dt["OD_CODE"], 
				"reSendName"=>$dt["RE_SENDNAME"], 
				"reSendAddress"=>$re_sendaddress, 
				"reName"=>$dt["RE_NAME"], 
				"reAddress"=>$re_address,
				"odTitle"=>$dt["OD_TITLE"],
				"reDeliCompany"=>$delitype,
				"reDeliNo"=>$dt["RE_DELINO"]
			);

			//총카운트 재확인 
			//로젠
			/*
			$sql=" select count(deliconfirm) logenDelicnt 
					from ".$dbH."_delicode a 
					inner join ".$dbH."_order b on a.odcode=b.od_code 
					where a.deliconfirm='N' and b.od_status = 'done' ";
			
			$dt=dbone($sql);
			$logenDelicnt=$dt["LOGENDELICNT"];
			*/
			$logenDelicnt=0;
			//우체국 
			$psql=" select count(deliconfirm) postDeliCnt 
					from ".$dbH."_delicode_post a 
					inner join ".$dbH."_order b on a.odcode=b.od_code 
					where a.deliconfirm='N' and b.od_status = 'done' ";

			$pdt=dbone($psql);
			$postDeliCnt=$pdt["POSTDELICNT"];

			$deliveryCnt=intval($logenDelicnt)+intval($postDeliCnt);	

			$rdt=dbone($rsql);

			$json["apiCode"] = $apiCode;
			$json["deliInfo"] = $deliInfo;
			$json["deliveryCnt"] = $deliveryCnt;
			$json["sql"] = $sql;
			$json["rsql"] = $rsql;
			$json["returnData"] = $returnData;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
		else
		{
			$json["apiCode"] = $apiCode;
			$json["odStatus"] = $od_status;
			$json["sql"] = $sql;
			$json["returnData"] = $returnData;
			$json["resultCode"]="204";
			if($deliconfirm=="Y")
			{
				$json["resultMessage"]="이미 배송 승인된 송장입니다. ";
			}
			else if($deliconfirm=="C")
			{
				$json["resultMessage"]="배송 취소된 송장입니다.";
			}
			else
			{
				if($od_status=="done" && $deliconfirm=="N" && !$useDate) 
				{
					if($delitype=="logen" || $delitype=="LOGEN")
					{
						$json["resultMessage"]="로젠 전송에 실패한 송장입니다. 다시 재출력 해주시기 바랍니다.";
					}
					else if($delitype=="post" || $delitype=="POST")
					{
						$json["resultMessage"]="우체국 전송에 실패한 송장입니다. 다시 재출력 해주시기 바랍니다.";
					}
					else
					{
						$json["resultMessage"]="포장완료된 송장만 가능합니다. ";
					}
				}
				else
				{
					$json["resultMessage"]="포장완료된 송장만 가능합니다. ";
				}
				
			}
		}
	}
?>