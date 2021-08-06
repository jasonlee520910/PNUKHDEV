<?php  
	///약재관리 > 약재목록_디제이메디 > 약재 등록&수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apiCode!="medicineupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicineupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$md_seq=$_POST["seq"];
		$md_code=$_POST["mdCode"];

		$md_type=$_POST["mdType"]; ///별전
		$md_hub=$_POST["mhCode"]; ///본초코드
		$md_title=trim($_POST["mdTitle"]);
	
		$md_alias=$_POST["mdAlias"];
		$md_origin=$_POST["mdOrigin"]; ///원산지
		$md_maker=$_POST["mdMaker"];  ///제조사
		$md_relate=$_POST["mdRelate"];
		$md_property=$_POST["mdProperty"];
		$md_loss=$_POST["mdLoss"];///로스율

		$md_price=$_POST["mdPrice"];
		$md_priceA=$_POST["mdPriceA"];
		$md_priceB=$_POST["mdPriceB"];
		$md_priceC=$_POST["mdPriceC"];
		$md_priceD=$_POST["mdPriceD"];
		$md_priceE=$_POST["mdPriceE"];

		$md_stable=$_POST["mdStable"];
		$md_status=$_POST["mdStatus"]; ///약재상태

		$md_waterchk=$_POST["mdWaterchk"]; ///약재흡수율예외처리
		$md_water=$_POST["mdWater"]; ///흡수율
		$md_watercode=$_POST["mdWatercode"]; ///약재흡수율코드

		$md_desc=$_POST["mdDesc"];
		$md_feature=$_POST["mdFeature"];
		$md_note=$_POST["mdNote"];
		$md_interact=$_POST["mdInteract"];

		if($md_seq)
		{
			$sql=" update ".$dbH."_medicine set md_code='".$md_code."', md_type='".$md_type."', md_hub='".$md_hub."', md_title_".$language." ='".$md_title."' ";
			$sql.=" ,md_alias_".$language." ='".$md_alias."'";
			//$sql.=" ,md_origin_".$language." ='".$md_origin."' ,md_maker_".$language." ='".$md_maker."'";  //제조사와 원산지는 바꾸지 않게 수정함.
			$sql.=" ,md_relate_".$language." ='".$md_relate."' ,md_property_".$language." ='".$md_property."' ,md_price ='".$md_price."'";
			$sql.=" ,md_priceA ='".$md_priceA."',md_priceB ='".$md_priceB."',md_priceC ='".$md_priceC."', md_priceD ='".$md_priceD."', md_priceE ='".$md_priceE."'";
			$sql.=" ,md_stable='".intval($md_stable)."' ,md_status ='".$md_status."' ,md_desc_".$language." ='".$md_desc."' ";
			$sql.=" ,md_feature_".$language." ='".$md_feature."'  ,md_note_".$language." ='".$md_note."' ,md_interact_".$language." ='".$md_interact."' ";
			$sql.=" ,md_waterchk='".$md_waterchk."' , md_water='".$md_water."' , md_watercode='".$md_watercode."' , md_loss='".$md_loss."' ";
			$sql.=" ,md_modify=sysdate where md_seq='".$md_seq."'";

			dbcommit($sql);
		}
		else
		{

			//0420  새로운 형식으로 코드 변경 (HD015501CN0001A)

			//코드생성
			$sql2=" select * from  (select md_seq,md_hub,md_code,substr(md_code,3,6) as EXCODE ";
			$sql2.=" from han_medicine where md_hub='".$md_hub."' order by md_code desc) where rownum <= 1 ";

			$dt=dbone($sql2);
//echo $sql2;


			if($dt["EXCODE"])
			{
				//echo $dt["EXCODE"];//HD000101
				$NEWCODE=$dt["EXCODE"]+1;
				//echo $NEWCODE;  //102

				$NEWCODE=sprintf("%06d",$NEWCODE);
				//echo $NEWCODE;  //000102
				$NEWCODE='HD'.$NEWCODE;

			}
			else
			{
				$NEWCODE=str_replace('HB','HD', $md_hub);
				$NEWCODE=$NEWCODE."01";
			}

//echo $NEWCODE; //HD000102

			//원산지
			switch($md_origin)
			{
				case "한국":$newmdorigin="KR";break;
				case "중국":$newmdorigin="CN";break;
				case "인도네시아":$newmdorigin="ID";break;
				case "러시아":$newmdorigin="RU";break;
				case "뉴질랜드":$newmdorigin="NZ";break;
				case "인도":$newmdorigin="IN";break;
				case "베트남":$newmdorigin="VN";break;
				case "터키":$newmdorigin="TR";break;
				case "미얀마":$newmdorigin="MM";break;
			}

			//제조사

			$sql3=" select cd_type from han_maker where cd_name_kor='".$md_maker."' ";
			$dt3=dbone($sql3);

			$newmdmaker= $dt3["CD_TYPE"];


			//약재흡수율 코드
			switch($md_watercode)
			{
				case "1000":$newmdWatercode="A";break;
				case "1100":$newmdWatercode="B";break;
				case "1200":$newmdWatercode="C";break;
				case "1300":$newmdWatercode="D";break;
				case "1400":$newmdWatercode="E";break;
				case "1500":$newmdWatercode="F";break;
				case "1600":$newmdWatercode="G";break;
				case "1700":$newmdWatercode="H";break;
				case "1800":$newmdWatercode="I";break;
				case "1900":$newmdWatercode="J";break;
				case "2000":$newmdWatercode="K";break;

			}
//echo $newmdWatercode;//A

				$maincode=$NEWCODE.$newmdorigin.$newmdmaker.$newmdWatercode;
//echo $maincode;

/*

			if($dt["MD_CODE"])
			{
				if(strlen($NEWCODE)=='1')//일의 자리수는 0을 붙여준다.
				{
					$md_code=$dt["EXCODE"]."0".$NEWCODE;		
				}
				else
				{
					$md_code=$dt["EXCODE"].$NEWCODE;	
				}						
			}
			else
			{
				$md_code=str_replace("HB", "HD", $md_hub)."_01"; 		
			}				
*/
			$sql=" insert into ".$dbH."_medicine (md_seq,md_loss, md_code, md_type, md_hub, md_title_".$language.", md_alias_".$language.", md_origin_".$language.", md_maker_".$language.",md_relate_".$language.", md_property_".$language.", md_price,md_priceA,md_priceB,md_priceC,md_priceD,md_priceE, md_stable, md_status, md_waterchk, md_water, md_watercode, md_desc_".$language.", md_feature_".$language." , md_note_".$language.", md_interact_".$language.", md_date,md_modify) values ((SELECT NVL(MAX(md_seq),0)+1 FROM ".$dbH."_medicine), '".$md_loss."','".$maincode."','".$md_type."','".$md_hub."','".$md_title."','".$md_alias."','".$md_origin."','".$md_maker."','".$md_relate."','".$md_property."','".$md_price."','".$md_priceA."','".$md_priceB."','".$md_priceC."','".$md_priceD."','".$md_priceE."','".intval($md_stable)."','".$md_status."','".$md_waterchk."','".$md_water."','".$md_watercode."','".$md_desc."','".$md_feature."','".$md_note."','".$md_interact."',sysdate,sysdate) ";
		
			dbcommit($sql);

			//신규등록된 seq
			$newsql="  select * from  ( select md_seq from ".$dbH."_medicine order by md_seq desc) where rownum <= 1  ";
			$dt=dbone($newsql);
			$seq=$dt["MD_SEQ"];
		}

			$returnData=urldecode($_POST["returnData"]);
			$json["apiCode"]=$apiCode;
			$json["seq"]=$seq;
			$json["returnData"]=$returnData;

			$json["resultCode"]="200";
			$json["resultMessage"]="OK";

			$json["sql"]=$sql;
			$json["sql2"]=$sql2;			
			$json["newsql"]=$newsql;		
		
	}
?>
