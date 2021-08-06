<?php 
	///약재관리 > 약재목록 왼쪽 등록&수정
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$seq=$_POST["seq"];
	$mdCode=$_POST["mdCode"];
	$mmCode=$_POST["mm_code"];  ///청연코드
	///$smuCode=$_POST["smuCode"];  ///djmedi 코드값을 그대로 받지 않고 코드를 따로 받음
	$smuNameKor=$_POST["smuNameKor"];
	$smuNameChn=$_POST["smuNameChn"];
	$mm_use=$_POST["mm_use"];
	$md_stable=$_POST["md_stable"]; ///적정수량

	$md_price=$_POST["md_price"];
	$md_priceA=$_POST["md_priceA"];
	$md_priceB=$_POST["md_priceB"];
	$md_priceC=$_POST["md_priceC"];
	$md_priceD=$_POST["md_priceD"];
	$md_priceE=$_POST["md_priceE"];

	
	$md_maker=$_POST["md_maker"];
	$md_origin=$_POST["md_origin"];

	if($apiCode!="medicinesmuupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicinesmuupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mmCode==""){$json["resultMessage"]="API(mmCode) ERROR";}
	else
	{
		if($seq)///수정 
		{
			$sql=" update ".$dbH."_medicine_".$refer." set md_code = '".$mdCode."', mm_code = '".$mmCode."', mm_title_kor = '".$smuNameKor."'";
			$sql.=", mm_title_chn = '".$smuNameChn."', mm_use = '".$mm_use."', mm_modify = SYSDATE where mm_seq='".$seq."' ";	

			dbcommit($sql);

			$sql1=" update ".$dbH."_medicine set md_price = '".$md_price."',md_priceA = '".$md_priceA."',md_priceB = '".$md_priceB."',md_priceC = '".$md_priceC."'";
			$sql1.=", md_priceD = '".$md_priceD."', md_priceE = '".$md_priceE."', md_maker_".$language." = '".$md_maker."' ";
			$sql1.=", md_origin_".$language." = '".$md_origin."', md_stable = '".$md_stable."' where  md_code = '".$mdCode."'";

			dbcommit($sql1);

			$json=array("apiCode"=>$apiCode,"seq"=>$seq,"returnData"=>$returnData);
			$json["sql1"]=$sql1;
			$json["sql"]=$sql;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
		else  ///신규입력
		{
			$sql=" select count(mm_seq) CNT from han_medicine_".$refer." where mm_code ='".$mmCode."' and mm_use = 'Y' " ;
			$dt=dbone($sql);

			///등록된 약재코드가 없다면 
			if(intval($dt["CNT"]) <= 0)
			{
				///,원지(감초자/신흥/중국),
				$mm_title_excel=",".$smuNameKor.",";
				$sql9=" insert into ".$dbH."_medicine_".$refer." (mm_seq,md_code,mm_code,mm_title_kor,mm_title_excel,mm_title_chn,mm_use,mm_date,mm_modify) ";
				$sql9.="values((SELECT NVL(MAX(mm_seq),0)+1 FROM ".$dbH."_medicine_".$refer."),'".$mdCode."','".$mmCode."','".$smuNameKor."','".$mm_title_excel."','".$smuNameChn."','".$mm_use."',SYSDATE,SYSDATE) ";

				dbcommit($sql9);
				
				$sql1=" update ".$dbH."_medicine set md_price = '".$md_price."',md_priceA = '".$md_priceA."',md_priceB = '".$md_priceB."'";
				$sql1.=" ,md_priceC = '".$md_priceC."', md_priceD = '".$md_priceD."', md_priceE = '".$md_priceE."', md_maker_".$language." = '".$md_maker."'";
				$sql1.=", md_origin_".$language." = '".$md_origin."', md_stable = '".$md_stable."' where  md_code = '".$mdCode."'";

				dbcommit($sql1);

				///공동약재함
				$sql2=" select * from  ( select substr(mb_code, 10) as MBCODE from ".$dbH."_medibox where mb_table = '00000' and substr(mb_code, 10,1)='5'";
				$sql2.="order by mb_code desc) where rownum <= 1 ";
				$dt2=dbone($sql2); 

				$newcode=$dt2["MBCODE"] + 1 ;
				$newcode=sprintf("%010d",intval($newcode));
				$boxcode="MDB".$newcode;

				///약재함 중복이 있는지 체크 하기
				$sql3=" select mb_code from ".$dbH."_medibox where mb_code='".$boxcode."' and mb_table = '00000' and  substr(mb_code, 10,1)='5' order by mb_code desc ";	
				$dt22=dbone($sql3);


				if($dt22["MB_CODE"])  ///만약 약재함코드 같은게 있으면
				{
					$mbcode3=substr($dt22["MB_CODE"],3,10) + 1 ;
					$mbcode3=sprintf("%010d",intval($mbcode3));
					$mediboxcode="MDB".$mbcode3;
				}
				else
				{
					$mediboxcode=$boxcode;	
				}

				$sql4=" insert into ".$dbH."_medibox (mb_seq,mb_code,mb_table,mb_medicine,mb_use,mb_date) ";
				$sql4.=" values ((SELECT NVL(MAX(mb_seq),0)+1 FROM ".$dbH."_medibox),'".$mediboxcode."','00000','".$mdCode."','Y',SYSDATE) ";

				dbcommit($sql4);

				/** ------------ 조제대 정리 ---------------------------- 
				1천번대 : 00001, 1조제대
				2천번대 : 00002, 2조제대
				3천번대 : 00003, 3조제대
				5천번대 : 00000, 공통
				8천번대 : 00080, 수동조제대
				9만번대 : 99999, 제환실
				-------------------------------------------------- **/
 

				///수동약재함
				$sql5=" select * from  ( select substr(mb_code, 10) as MBCODE from ".$dbH."_medibox where mb_table = '00080' and substr(mb_code, 10,1)='8' ";
				$sql5.=" order by mb_code desc) where rownum <= 1 "; 
				$dt3=dbone($sql5);  

				$newcode3=$dt3["MBCODE"] + 1 ;
				$boxcode3=sprintf("%010d",intval($newcode3));
				$boxcode3="MDB".$boxcode3;

				///약재함 중복이 있는지 체크 하기
				$sql6=" select mb_code from ".$dbH."_medibox where mb_code='".$boxcode3."' and mb_table = '00080' and substr(mb_code,10,1)='8' order by mb_code desc ";	
				$dt33=dbone($sql6);

				if($dt33["MB_CODE"])  ///만약 약재함코드 같은게 있으면
				{
					$mbcode33=substr($dt33["MB_CODE"],3,10) + 1 ;
					$mbcode33=sprintf("%010d",intval($mbcode33));
					$mediboxcode3="MDB".$mbcode33;
				}
				else
				{
					$mediboxcode3=$boxcode3;	
				}

				$sql7=" insert into ".$dbH."_medibox (mb_seq,mb_code,mb_table,mb_medicine,mb_use,mb_date) ";
				$sql7.=" values ((SELECT NVL(MAX(mb_seq),0)+1 FROM ".$dbH."_medibox),'".$mediboxcode3."','00080','".$mdCode."','Y',SYSDATE) ";

				dbcommit($sql7);

				$returnData=urldecode($_POST["returnData"]);
				$json=array("apiCode"=>$apiCode,"seq"=>$seq,"returnData"=>$returnData);

				$json["sql"]=$sql;
				$json["sql1"]=$sql1;
				$json["sql2"]=$sql2;
				$json["sql3"]=$sql3;
				$json["sql4"]=$sql4;
				$json["sql5"]=$sql5;
				$json["sql6"]=$sql6;
				$json["sql7"]=$sql7;
				$json["sql9"]=$sql9;

				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}
			else
			{
				$json["resultCode"]="209";
				$json["resultMessage"]="1726";///이미 사용중인 약재코드입니다.
			}
		}
	}
?>
