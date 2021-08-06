<?php  
	/// 자재코드관리 > 약재함관리 > 등록 & 수정
	$apicode=$_POST["apiCode"];
	$language=$_POST["language"];
	if($apicode!="mediboxupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="mediboxupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$mb_seq=$_POST["seq"];
		$mb_code=$_POST["mbCode"];
		$mb_table=$_POST["mbTable"]; //조제대
		$mb_medicine=$_POST["mbMedicine"];
		$returnData=$_POST["returnData"];

		$json=array("apiCode"=>$apicode,"returnData"=>$returnData);

		if($mb_code=='add')
		{
			///해당약재코드와 조제대로 등록된 것이 있는 체크  
			$sql2="select mb_code, mb_table from ".$dbH."_medibox where mb_medicine = '".$mb_medicine."' and mb_use = 'Y'  and mb_table = '".$mb_table."'";
			// select mb_code, mb_table from han_medibox where mb_medicine = 'HD10471_01' and mb_use = 'Y'  and mb_table = '00000'
			$res=dbqry($sql2);   ///OK

			$comCnt=$joCnt=$isFlag=0;

			while($dt=dbarr($res))
			{
				if($dt["MB_TABLE"]==$mb_table)
				{
					$isFlag=1;
					$json["resultCode"]="209";
					$json["resultMessage"]="1714";///해당 조제대에 약재가 등록되어 있습니다.
					break;
				}
				else  ///등록된 약재함이 없으면 공동조제함으로 생성
				{
					$isFlag=0;
					if($dt["MB_TABLE"] == "00000")
					{
						$comCnt++;
					}
					else
					{
						$joCnt++;
					}
				}
			}

			if($isFlag == 0)
			{

				if($mb_table == '00000' && $joCnt > 0)
				{
					$json["resultCode"]="209";
					$json["resultMessage"]="1715";///개별 약재로 등록되어 있습니다.
				}
				else if($mb_table != '00000' && $comCnt > 0)
				{
					$json["resultCode"]="209";
					$json["resultMessage"]="1716";///공통 약재로 등록되어 있습니다.
				}
				else
				{
					///----------------------------------------------------------------
					/// 공동약재함이면 1,2,3  조제대가 있는지 체크, 1,2,3 조제대이면 공동약재함이 있는지 체크
					///----------------------------------------------------------------

					if($mb_table=='00000')  ///약재함이 공동일 경우 1,2,3약재함 없는지 체크
					{
						$zsql=" select mb_code from ".$dbH."_medibox where mb_medicine ='".$mb_medicine."' and (mb_table='00001' or mb_table='00002' or mb_table='00003') and mb_use<>'D' ";
						// select mb_code from han_medibox where mb_medicine ='HD10471_01' and (mb_table='00001' or mb_table='00002' or mb_table='00003') and mb_use<>'D' 
						$dtz=dbone($zsql);    //OK

						if($dtz["MB_CODE"])
						{
							$json["resultCode"]="209";
							$json["resultMessage"]="1942";///1,2약재함과 공동약재함은 함께 사용하실수 없습니다. 다시 확인해주세요	
							$boxchk=0;
						}
						else
						{
							$boxchk=1;					
						}
					}

					if($mb_table=='00001' || $mb_table=='00002' || $mb_table=='00003')  ///약재함이 1,2,3 조제대일경우 공동약재함이 없는지 체크
					{
						$zsql2=" select mb_code from ".$dbH."_medibox where mb_medicine ='".$mb_medicine."' and mb_table='00000' and mb_use<>'D' ";
						$dtz=dbone($zsql2); 
///echo $zsql2;

						if($dtz["MB_CODE"])
						{
							$json["resultCode"]="209";
							$json["resultMessage"]="1942";///1,2,3약재함과 공동약재함은 함께 사용하실수 없습니다. 다시 확인해주세요	
							$boxchk=0;
						}
						else
						{
							$boxchk=1;						
						}
					}

					if($mb_table=='99999' || $mb_table=='00080')
					{
						$boxchk=1;
					}

					if($boxchk==1)  //---------------------------------------------------
					{					
						///------------ 조제대 정리 ---------------------------- 
						/// 1천번대 : 1조제대
						/// 2천번대 : 2조제대
						/// 5천번대 : 00000, 공통
						/// 8천번대 : 00080, 수동조제대
						/// 9만번대 : 99999, 제환실
						///--------------------------------------------------

						$boxnumber="";

						if($mb_table=='00001')
						{
							$boxnumber='1';
						}
						
						else if($mb_table=='00002')
						{
							$boxnumber='2';
						}
						else if($mb_table=='00003')
						{
							$boxnumber='3';
						}
						
						else if($mb_table=='00000') ///공동
						{
							$boxnumber='5';
						}
						
						else if($mb_table=='00080') ///수동조제대
						{
							$boxnumber='8';
						}				
						else if($mb_table=='99999') ///제환실
						{
							$boxnumber='9';
						}
						
						if($mb_table!='99999')  ///제환실은 9만번대라서 따로 처리
						{
							//$sql9=" select substring(mb_code,10)  mbcode from ".$dbH."_medibox where mb_table = '".$mb_table."'  and substr(mb_code,10,1)='".$boxnumber."'  order by mb_code desc  limit 0,1 "; 
							// select mb_code,substring(mb_code,10)  mbcode from han_medibox where mb_table = '00080'  and substr(mb_code,10,1)='8'  order by mb_code desc  limit 0,1
 
							$sql9="  select * from  ( select substr(mb_code,10) as mbcode from ".$dbH."_medibox  where mb_table = '".$mb_table."' and substr(mb_code,10,1)='".$boxnumber."' order by mb_code desc) where rownum <= 1 ";

							$dt2=dbone($sql9); 
	///echo $sql9;
							$newcode=$dt2["MBCODE"] + 1 ;
							$boxcode=sprintf("%010d",intval($newcode));
							$boxcode="MDB".$boxcode;

							///----------------------------------------------------------------
							///약재함 중복이 있는지 체크 하기
							$sql8=" select mb_code from ".$dbH."_medibox where mb_code='".$boxcode."' and mb_table = '".$mb_table."' order by mb_code desc ";	
							$dt22=dbone($sql8);
	//echo $sql8;

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

							///----------------------------------------------------------------

							///약재함코드 중복이 없으면 insert
							$asql=" insert into ".$dbH."_medibox (mb_seq,mb_code,mb_table,mb_medicine,mb_use,mb_date, mb_modify) values ((SELECT NVL(MAX(mb_seq),0)+1 FROM ".$dbH."_medibox),'".$mediboxcode."','".$mb_table."','".$mb_medicine."','Y',SYSDATE,SYSDATE) ";
							// insert into han_medibox (mb_seq,mb_code,mb_table,mb_medicine,mb_use,mb_date, mb_modify) values ((SELECT NVL(MAX(mb_seq),0)+1 FROM han_medibox),'MDB0000005012','00000','HD10471_01','Y',SYSDATE,SYSDATE) 
	///echo $asql;
							dbcommit($asql);

							///----------------------------------------------------------------
							if($mb_table!='00080')///수동약재함이 아니면  있는지 확인한후 수동약재함도 함께 생성
							{
								$bsql=" select mb_code from ".$dbH."_medibox where mb_medicine='".$mb_medicine."' and mb_table = '00080' order by mb_code desc ";	
								//" select mb_code from han_medibox where mb_medicine='HD10471_01' and mb_table = '00080' order by mb_code desc "
								$dtb=dbone($bsql);
	///echo $bsql;
								if(!$dtb["MB_CODE"]) ///수동약재함이 없으면 
								{
									//$fsql=" select substring(mb_code,10)  mbcode from ".$dbH."_medibox where mb_table = '00080'  and substr(mb_code,10,1)='8' order by mb_code desc  limit 0,1 "; 
									 $fsql="select * from  ( select substr(mb_code,10) as mbcode from ".$dbH."_medibox  where mb_table = '00080' and substr(mb_code,10,1)='8' order by mb_code desc) where rownum <= 1  ";

									$dtd=dbone($fsql); 
	///echo $fsql;
									$handbox=$dtd["mbcode"] + 1 ;
									$handbox=sprintf("%010d",intval($handbox));
									$handmediboxcode="MDB".$handbox;

									$esql=" insert into ".$dbH."_medibox (mb_code,mb_table,mb_medicine,mb_use,mb_date, mb_modify) values ('".$handmediboxcode."','00080','".$mb_medicine."','Y',SYSDATE,SYSDATE) ";
	///echo $esql;
									dbcommit($esql);
								}
							}
							///----------------------------------------------------------------
						}
						else  ///제환실은 만번대 숫자가 다름(기존에 제환실 아닌데 9만번대로 들어간 약재함들이 있어서 쿼리를 수정)
						{
							//$sql6=" select substring(mb_code,4,10) mbcode from ".$dbH."_medibox order by mb_code desc limit 0,1 "; 
							$sql6=" select * from  ( select substr(mb_code,4,10) as MBCODE from ".$dbH."_medibox order by mb_code desc) where rownum <= 1  ";  //OK
							$dt2=dbone($sql6); 
	///echo $sql6;						
							$mbcode9=sprintf("%010d",intval($dt2["MBCODE"]) + 1);
							$boxcode="MDB".$mbcode9;


							///약재함 중복이 있는지 체크 하기(0116)
							$sql5=" select mb_code from ".$dbH."_medibox where mb_code='".$boxcode."' order by mb_code desc ";	
							$dt22=dbone($sql5);
	///echo $sql5;

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

							$sql3=" insert into ".$dbH."_medibox (mb_seq, mb_code,mb_table,mb_medicine,mb_use,mb_date, mb_modify) ";
							$sql3.=" values ((SELECT NVL(MAX(mb_seq),0)+1 FROM ".$dbH."_medibox) ";
							$sql3.=" ,'".$mediboxcode."','".$mb_table."','".$mb_medicine."','Y',SYSDATE,SYSDATE) ";
	///echo $sql3;
							dbcommit($sql3);
						}
						
						$json["sql"]=$sql;
						$json["sql3"]=$sql3;
						$json["resultCode"]="200";
						$json["resultMessage"]="OK";

						$json["asql"]=$asql;	
						$json["bsql"]=$bsql;	
						$json["csql"]=$csql;
						$json["dsql"]=$dsql;
						$json["esql"]=$esql;
						$json["fsql"]=$fsql;

						$json["sql2"]=$sql2;
						$json["sql9"]=$sql9;

						$json["sql8"]=$sql8;
						
						$json["sql6"]=$sql6;
						$json["sql5"]=$sql5;
						$json["sql3"]=$sql3;

						$json["zsql2"]=$zsql2;
						$json["zsql"]=$zsql;						
					} //---------------------------------------------------($boxchk==1)
				}
			}
		}
		///--------------------------------------------------------여기까지가 add
		else
		{

			///해당약재코드와 조제대로 등록된 것이 있는 체크  
			$sql7="select mb_code, mb_table from ".$dbH."_medibox where mb_medicine = '".$mb_medicine."' and mb_use = 'Y'  and mb_table = '".$mb_table."'";
			$res=dbqry($sql7);

			while($dt=dbarr($res))
			{
				if($dt["mb_table"]==$mb_table)
				{
					$isFlag=1;
					$json["resultCode"]="209";
					$json["resultMessage"]="1714";///해당 조제대에 약재가 등록되어 있습니다.
					break;
				}
				else
				{				
					$sql4=" update ".$dbH."_medibox set mb_modify =SYSDATE, mb_table='".$mb_table."', mb_medicine='".$mb_medicine."'  where mb_seq='".$mb_seq."'";
					dbcommit($sql4);

					
					$json["sql4"]=$sql4;				
					$json["resultCode"]="200";
					$json["resultMessage"]="OK";
				}
			}		
		}
	}
?>