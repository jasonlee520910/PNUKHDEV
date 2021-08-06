<?php
	//로젠 안해도됨 
	$root="../..";
	$folder="/tbms";
	include_once $root.$folder."/settinghead.php";

	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];

	if($apiCode!="logenareaupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="logenareaupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$updDate=date("Y-m-d");
		//집배구역 마스터
		$client=new SoapClient($LOGEN_SERVER_URL);
		
		$param=array('parameters' => array('userID'=>$userID,'passWord'=>$passWord,'updDate'=>$updDate));
		$narray = $client->__call('W_PHP_NTx_Get_Area',$param);
		$nvar = $narray->W_PHP_NTx_Get_AreaResult; 

		if($nvar)
		{
			//우편번호(3) Ξ 우편번호SEQ(3),지점코드(3),시도(10),시군구(20),동(20),리(20),섬(10),번지(20),건물(50),주소1(150),항공지역여부(1),도서지역코드(3),분류코드(4),산간지역여부(1) ≡
			$nData = explode('Ξ', $nvar);
			$values="";
			for($i=0;$i<count($nData)-1;$i++)
			{
				$zipcode=$nData[0];//우편번호
				$zipseq=$nData[1];//우편번호seq
				$branchcode=$nData[2];//지점코드
				$city=$nData[3];//시도
				$county=$nData[4];//시군구
				$dong=$nData[5];//동
				$village=$nData[6];//리
				$island=$nData[7];//섬
				$beonji=$nData[8];//번지
				$building=$nData[9];//건물
				$addr1=$nData[10];//주소1
				$airline_whether=$nData[11];//항공지역여부
				$island_whether=$nData[12];//도서지역코드
				$classification_code=$nData[13];//분류코드
				$mountains_whether=$nData[14];//산간지역여부 
				
				if($i>0)
				{
					$values.=",";
				}

				$values.="('".$branchcode."', '".$zipcode."', '".$zipseq."', '".$city."', '".$dong."', '".$village."', '".$island."', '".$beonji."', '".$building."', '".$addr1."', '".$airline_whether."', '".$island_whether."', '".$classification_code."', '".$mountains_whether."')";

			}

			if($values)
			{
				$isql = " insert into han_deliarea (branchcode, zipcode, zipseq, city, dong, village, island, beonji, building, addr1, airline_whether, island_whether, classification_code, mountains_whether ) values ".$values;
				dbqry($isql);

				$json["delilogenareasql"]=$isql;
				$json["delilogenarea"]="집배구역 마스터 업데이트!!";
			}
			else
			{
				$json["delilogenarea"]="집배구역 마스터 업데이트 다시 해야함 ".$values;
			}
		}
		else
		{
			$json["delilogenarea"]="집배구역 마스터 업데이트할 내용없음";
		}
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

	include_once $root.$folder."/tail.php";

?>
