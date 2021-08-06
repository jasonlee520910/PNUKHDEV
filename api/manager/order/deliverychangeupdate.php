<?php //택배변경(사용안함)
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odCode=$_GET["odcode"];
	$delicompchange=$_GET["delicompchange"];
	
	if($apicode!="deliverychangeupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="deliverychangeupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($odCode==""){$json["resultMessage"]="API(odCode) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];

		$sql="select 
				a.re_keycode, a.re_delicomp, a.re_deliexception, a.re_sendzipcode, a.re_sendaddress, a.re_zipcode, a.re_address
				, c.mi_zipcode, c.mi_address, d.receiveZipcode, d.receiveAddress, d.receiveAddressDesc 
				from ".$dbH."_release a 
				inner join ".$dbH."_order b on b.od_keycode=a.re_keycode 
				inner join ".$dbH."_medical c on c.mi_userid=b.od_userid 
				left join ".$dbH."_order_client d on d.keycode=a.re_keycode 
				where a.re_odcode='".$odCode."' ";
		$dt=dbone($sql);
		$re_delicomp=$dt["re_delicomp"];
		$re_deliexception=$dt["re_deliexception"];

		$re_sendzipcode=$dt["re_sendzipcode"];
		$re_sendaddress=$dt["re_sendaddress"];
		$re_zipcode=$dt["re_zipcode"];
		$re_address=$dt["re_address"];
		
		//한의원주소 
		$mi_zipcode=$dt["mi_zipcode"];
		$mi_address=$dt["mi_address"];
		//버키에서 넘어온 주소 
		$recieveZipcode=$dt["recieveZipcode"];
		$recieveAddress=$dt["recieveAddress"]."||".$dt["recieveAddressDesc"];



		if(strpos($re_deliexception, ",D") !== false)
		{
			$json["resultCode"]="399";
			$json["resultMessage"]="직배배송입니다. 변경불가합니다.";
		}
		else if(strpos($re_deliexception, ",O") !== false)
		{
			$json["resultCode"]="398";
			$json["resultMessage"]="해외배송입니다. 변경불가합니다.";
		}
		else if(strpos($re_deliexception, ",T") !== false)
		{
			$json["resultCode"]="397";
			$json["resultMessage"]="묶음배송입니다. 변경불가합니다.";
		}
		else if($re_deliexception=="N")
		{
			if(strtoupper($delicompchange)=="LOGEN")//로젠으로 변경 
			{
				include_once $root.$folder."/order/ordersummary.logen.php";

				$rsql="update ".$dbH."_release set re_delicomp='".$delicompchange."', re_delicompchk='Y' where re_odcode='".$odCode."' ";
				dbqry($rsql);

				$json["delicompName"]="로젠";
			}
			else if(strtoupper($delicompchange)=="POST")//우체국으로 변경 
			{
				$rsql="update ".$dbH."_release set  re_sendzipcode='".$mi_zipcode."',re_sendzipseq=NULL,  re_zipcode='".$recieveZipcode."', re_zipseq=NULL, re_delicomp='".$delicompchange."', re_delicompchk='Y' where re_odcode='".$odCode."' ";
				dbqry($rsql);

				$json["delicompName"]="우체국";
			}


			$asql="select re_sendzipcode, re_zipcode from ".$dbH."_release where re_odcode='".$odCode."' ";
			$adt=dbone($asql);

			$json["re_sendzipcode"]=$adt["re_sendzipcode"];
			$json["re_zipcode"]=$adt["re_zipcode"];


			$json["resultCode"]="200";
		}
		else
		{
			$json["resultCode"]="396";
		}

		//20191202 : 송장출력 로젠
		$dsql=" select delicode, deliconfirm, usedate, confirmdate, canceldate  from han_delicode where odcode='".$odCode."' and deliconfirm <> 'C' and inuse <> 'D' ";
		$ddt=dbone($dsql);
		$chkdelicode="";
		if($ddt["delicode"])//송장번호가 있다면..
		{
			$chkdelicode=$ddt["delicode"];
			$chkdeliconfirm=$ddt["deliconfirm"];
			$chkusedate=$ddt["usedate"];
			$chkconfirmdate=$ddt["confirmdate"];
			$chkcanceldate=$ddt["canceldate"];
		}
		else
		{
			//20191202 : 송장출력 우체국 
			$dsql=" select delicode, deliconfirm, usedate, confirmdate, canceldate from han_delicode_post where odcode='".$odCode."' and deliconfirm <> 'C' and inuse <> 'D' ";
			$ddt=dbone($dsql);
			$chkdelicode="";
			if($ddt["delicode"])//송장번호가 있다면..
			{
				$chkdelicode=$ddt["delicode"];
				$chkdeliconfirm=$ddt["deliconfirm"];
				$chkusedate=$ddt["usedate"];
				$chkconfirmdate=$ddt["confirmdate"];
				$chkcanceldate=$ddt["canceldate"];
			}
		}

		$json["chkdelicode"]=$chkdelicode;
		$json["delicompchange"]=$delicompchange;
		$json["reDeliexception"]=$re_deliexception;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		
		$json["resultMessage"]="OK";
	}
?>