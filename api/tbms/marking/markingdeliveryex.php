<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odCode=$_GET["odCode"];

	if($apiCode!="markingdeliveryex"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="markingdeliveryex";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$rsql=" select ";
		$rsql.=" a.re_sendname, a.re_sendphone,a.re_sendmobile, a.re_sendzipcode, a.re_sendzipseq, a.re_sendaddress ";
		$rsql.=", a.re_name, a.re_phone, a.re_mobile, a.re_zipcode, a.re_zipseq, a.re_address, a.re_deliexception ";
		$rsql.=", a.re_request as REREQUEST ";
		$rsql.=" ,b.od_title, b.od_name, b.od_sitecategory ";
		$rsql.=", cy.orderCode cyodcode ";
		$rsql.=" from ".$dbH."_release ";
		$rsql.=" a inner join ".$dbH."_order b on b.od_keycode=a.re_keycode ";
		$rsql.=" left join ".$dbH."_order_client cy on b.od_keycode=cy.keycode ";
		$rsql.=" where a.re_odcode='".$odCode."' ";
		$rdt=dbone($rsql);

		$json["rsql"] = $rsql;

		$od_name=$rdt["OD_NAME"];//환자명 
		$json["od_name"] = $od_name;//보내는사람 
		$od_sitecategory=$rdt["OD_SITECATEGORY"];//환자명 
		$json["od_sitecategory"]=$od_sitecategory;

		$od_chartpk=$rdt["OD_CHARTPK"];//환자명 
		$json["od_chartpk"] = $od_chartpk;//보내는사람 
		$cyodcode=$rdt["CYODCODE"];//환자명 
		$json["cyodcode"] = $cyodcode;//보내는사람 


		$reSendname = $rdt["RE_SENDNAME"];//보내는사람 
		$reSendphone = $rdt["RE_SENDPHONE"];//보내는사람 전화번호 
		$reSendmobile = $rdt["RE_SENDMOBILE"];//보내는사람 휴대번호
		$reSendzipcode = $rdt["RE_SENDZIPCODE"];//보내는사람 우편번호
		$reSendzipseq = $rdt["RE_SENDZIPSEQ"];//보내는사람 우편번호 seq
		$sendaddr=explode("||",$rdt["RE_SENDADDRESS"]);
		$reSendaddress1 = $sendaddr[0];
		$reSendaddress2 = $sendaddr[1];

		$json["reSendname"] = $reSendname;//보내는사람 
		$json["reSendphone"] = $reSendphone;//보내는사람 전화번호 
		$json["reSendmobile"] = $reSendmobile;//보내는사람 휴대번호
		$json["reSendzipcode"] = $reSendzipcode;//보내는사람 우편번호
		$json["reSendzipseq"] = $reSendzipseq;//보내는사람 우편번호 seq
		$json["reSendaddress1"] = $reSendaddress1;//보내는사람 주소 
		$json["reSendaddress2"] = $reSendaddress2;//보내는사람 주소 


		$reName = $rdt["RE_NAME"];//받는사람 
		$rePhone = $rdt["RE_PHONE"];//받는사람전화번호
		$reMobile = $rdt["RE_MOBILE"];//받는사람핸드폰
		$reZipcode = $rdt["RE_ZIPCODE"];//받는사람우편번호
		$reZipseq = $rdt["RE_ZIPSEQ"];//받는사람우편번호 seq
		$reAddress = explode("||",$rdt["RE_ADDRESS"]);
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
		$reRequest=getClob($rdt["REREQUEST"]);//배송요청사항
		$json["reRequest"] = $reRequest;//배송요청사항 

		if($rdt["CYODCODE"]){$cyodcode="BK".($rdt["CYODCODE"]+10000);}else{$cyodcode="";}
		if($cyodcode){$od_chartpk=$cyodcode;}

		if($od_sitecategory=="CY" || $od_sitecategory=="OKCHART")
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
					$odTitle=$rdt["OD_TITLE"]." ".$od_name."[".$od_chartpk."]";
					$json["odTitle"] = $odTitle;//처방명 
				}
				else
				{
					$odTitle=$rdt["OD_TITLE"];
					$json["odTitle"] = $odTitle;//처방명 
				}
			}
		}
		else
		{
			$odTitle=$rdt["OD_TITLE"];
			$json["odTitle"] = $odTitle;//처방명 
		}

		$re_deliexception=$rdt["RE_DELIEXCEPTION"];
		$json["deliExName"]=getdeliexceptionName($re_deliexception);

		if(strpos($re_deliexception, ",D") !== false)//직배인경우 
		{
			$csql=" select seq from han_delicode_direct where odcode='".$odCode."'";
			$cdt=dbone($csql);

			if(!$cdt["SEQ"])
			{
				$delicode=date("ymdHis");
				$usql=" insert into han_delicode_direct (SEQ, delitype, delicode, odcode, deliconfirm, DELIVOLUME,DELIWEIGHT, inuse, indate, usedate ) ";
				$usql.=" values((SELECT NVL(MAX(SEQ),0)+1 FROM ".$dbH."_delicode_direct),'DIRECT', '".$delicode."','".$odCode."','N', '0','0','Y', sysdate, sysdate) ";
				dbqry($usql);
				$json["usql"]=$usql;
			}
		}


		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
			
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