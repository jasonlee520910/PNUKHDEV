<?php //로젠 
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odCode=$_GET["odCode"];
	$re_address=$_GET["receiverAddress"];
	$re_address_detail=$_GET["receiverAddrDetail"];
	
	if($apicode!="addressupdate"){$json["resultMessage"]="API(apiCode) ERROR2";$apicode="addressupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($odCode==""){$json["resultMessage"]="API(odCode) ERROR";}
	else if($re_address==""){$json["resultMessage"]="API(receiverAddress) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		$strAddr=$re_address;
		include_once $root."/tbms/common.php";
		include_once $root."/tbms/marking/logenrcvdivcd.php";


		$re_addrdestination=$json["DestinationCode"];//도착점코드(3)
		$re_addrroadname=$json["RoadName"];//도로명
		$re_addrclassification=$json["ClassificationCode"];//분류코드(6)
		$re_addrzipcode=$json["ZipCode"];//우편번호 
		$re_addrjeju=$json["jejuCheck"];//제주지역여부(1)
		$re_addrsea=$json["seaCheck"];//해운지역여부(1)
		$re_addrmountain=$json["mountainCheck"];//산간지역여부(1)

		$json["re_addrdestination"]=$re_addrdestination;
		$json["re_addrroadname"]=$re_addrroadname;
		$json["re_addrclassification"]=$re_addrclassification;
		$json["re_addrjeju"]=$re_addrjeju;
		$json["re_addrsea"]=$re_addrsea;
		$json["re_addrmountain"]=$re_addrmountain;

		
		if($re_addrdestination!="" && $re_addrzipcode!="")
		{
			//로젠zipseq update
			$sql2=" select zipseq from ".$dbH."_deliarea where zipcode = '".$re_addrzipcode."' limit 1 ";
			$zipdt=dbone($sql2);
			$re_zipseq=$zipdt["zipseq"];

			//20191101 : 기존주소를 가져오자 (업데이트문에서 같이 하면 안되서 일단은 수정하자)
			$asql=" select re_address from ".$dbH."_release where re_odcode='".$odCode."'";
			$adt=dbone($asql);
			$before_re_address=$adt["re_address"];

			$new_re_address=$re_address."||".$re_address_detail;

			//도착점코드 업데이트 re_addrdestination
			$sql=" update ".$dbH."_release set re_zipcode='".$re_addrzipcode."', re_zipseq='".$re_zipseq."', re_addressold='".$before_re_address."', re_address='".$new_re_address."', re_addrdestination = '".$re_addrdestination."', re_addrroadname = '".$re_addrroadname."', re_addrclassification = '".$re_addrclassification."', re_addrjeju = '".$re_addrjeju."', re_addrsea = '".$re_addrsea."', re_addrmountain = '".$re_addrmountain."', re_addresschk='Y' where re_odcode='".$odCode."'";
			dbqry($sql);
			$json["sql"]=$sql;
			$readdresschk=1;
		}
		else
		{
			$readdresschk=0;
		}

		$sql="select re_zipcode, re_address from ".$dbH."_release where re_odcode='".$odCode."'";
		$dt=dbone($sql);

		$json["zipcode"]=$dt["re_zipcode"];
		$json["re_address"]=$dt["re_address"];

		//묶음/해외/직배인경우 
		$sql=" select re_address, re_deliexception from ".$dbH."_release where re_odcode='".$odCode."'";
		$dt=dbone($sql);
		
		$json["reAddress"]=$dt["re_address"];
		$json["readdressTied"]="";
		$json["readdressOversea"]="";
		$json["readdressDirect"]="";
		$json["readdressexception"]=$dt["re_deliexception"];
		if($dt["re_deliexception"]!="N"){
			if(strpos($dt["re_deliexception"],"T")){
				$json["readdressTied"]="Y";
			}
			if(strpos($dt["re_deliexception"],"O")){
				$json["readdressOversea"]="Y";
			}
			if(strpos($dt["re_deliexception"],"D")){
				$json["readdressDirect"]="Y";
			}
			$readdressexception=1;;
			//$json["readdressexception"]=1;
		}
		//if($readdresschk==0 && $readdressexception==1){
			//$readdresschk=1;
		//}
		$json["readdresschk"]=$readdresschk;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>