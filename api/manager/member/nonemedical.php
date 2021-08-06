<?php  
	///주문리스트 > 한의원등록 버튼 
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odKeycode=$_GET["odKeycode"];  //2020042716013700001
	$odSite=$_GET["site"]; //MANAGER

	if($apiCode!="nonemedical"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="nonemedical";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{	
		//--------------------------------------------------------------------------
		//한의원이 등록이 되어있는데 pk가 없을시에 member에 한의사 pk 업데이트 하자 
		//--------------------------------------------------------------------------
		$memState=$_GET["memState"];
		$memDoctorid=$_GET["memDoctorid"];
		$memDoctorpk=$_GET["memDoctorpk"];

		$memMedicalId=$_GET["memMedicalId"];
		$memMedicalCode=$_GET["memMedicalCode"];
		

		
		$updateChk="true";
		$selpk=0;
		$selcypk=0;
		if($memState=="change" && $memDoctorid!="" && $memDoctorpk!="")
		{
			if($odSite=="CLIENT")
			{
				$sql="select me_idpk from han_member where me_userid='".$memDoctorid."'";
				$dt=dbone($sql);
				$selpk=$dt["ME_IDPK"];
				$json["selpk"]=$selcypk;

				$msql="select mi_cypk from han_medical where mi_userid='".$memMedicalId."' ";
				$ddt=dbone($msql);
				$selcypk=$ddt["MI_CYPK"];

				$json["msql"]=$msql;
				$json["selcypk"]=$selcypk;

				if($selpk>0 && $selcypk>0) //한의원과 한의사 코드가 둘다 있으면 둘다있다는 에러메세지 
				{
					$updateChk="false";
				}
				else if($selpk>0 && $selcypk<=0) //한의사코드가 있다는 에러메세지 
				{
					//$updateChk="doctorfalse";
					//한의원 업데이트
					$sql=" update ".$dbH."_medical ";
					$sql.=" set mi_cypk='".$memMedicalCode."', mi_modify=sysdate ";
					$sql.=" where mi_userid='".$memMedicalId."' ";
					dbcommit($sql);
				}
				else if($selpk<=0 && $selcypk>0) //한의원코드가 있다는 에러메세지 
				{
					//$updateChk="medicalfalse";
					//한의사 업데이트
					$sql=" update ".$dbH."_member ";
					$sql.=" set me_idpk='".$memDoctorpk."', me_modify=sysdate ";
					$sql.=" where me_userid='".$memDoctorid."' ";
					dbcommit($sql);
				}
				else
				{
					//한의사 업데이트
					$sql=" update ".$dbH."_member ";
					$sql.=" set me_idpk='".$memDoctorpk."', me_modify=sysdate ";
					$sql.=" where me_userid='".$memDoctorid."' ";
					dbcommit($sql);


					//한의원 업데이트
					$sql=" update ".$dbH."_medical ";
					$sql.=" set mi_cypk='".$memMedicalCode."', mi_modify=sysdate ";
					$sql.=" where mi_userid='".$memMedicalId."' ";
					dbcommit($sql);
				}
			}
			else
			{
				$sql="select me_auth from han_member where me_userid='".$memDoctorid."'";
				$selpk=$dt["ME_AUTH"];
				$json["selpk"]=$selcypk;

				if($selpk>0)
				{
					$updateChk="false";
				}
				else
				{			
					//한의사 업데이트
					$sql=" update ".$dbH."_member ";
					$sql.=" set me_auth='".$memDoctorpk."', me_modify=sysdate ";
					$sql.=" where me_userid='".$memDoctorid."' ";
					dbcommit($sql);
				}
			}


			/*
			if($selpk>0)
			{
				$updateChk="false";
			}
			else
			{			
				//한의원 업데이트
				$sql=" update ".$dbH."_member ";
				if($odSite=="CLIENT")
				{
					$sql.=" set me_idpk='".$memDoctorpk."', me_modify=sysdate ";
				}
				else
				{
					$sql.=" set me_auth='".$memDoctorpk."', me_modify=sysdate ";
				}
				$sql.=" where me_userid='".$memDoctorid."' ";
				dbcommit($sql);
			}

			if($selcypk>0)
			{
				$updateChk="medicalfalse";
			}
			else
			{
				//한의원 업데이트
				if($odSite=="CY")
				{
					$sql=" update ".$dbH."_medical ";
					$sql.=" set mi_cypk='".$memMedicalCode."', mi_modify=sysdate ";
					$sql.=" where mi_userid='".$memMedicalId."' ";
					dbqry($sql);
				}
			}
			*/
		}
		//--------------------------------------------------------------------------

		if($updateChk=="false")
		{
			$json["apiCode"]=$apiCode;
			$json["resultCode"]="381";
			if($odSite=="CLIENT")
			{
				$json["resultMessage"]="ADD_CLIENT_MEMBER";
			}
			else
			{
				$json["resultMessage"]="ADD_OK_MEMBER";
			}
		}
		else
		{
			if($odKeycode)
			{
				$sql=" select ";
				$sql.=" a.od_scription, a.od_staff, a.od_matype, a.od_packcnt, a.od_chubcnt, a.od_amountdjmedi, a.od_packcapa ";
				$sql.=" ,b.dc_time, b.dc_water, b.dc_shape, b.dc_binders, b.dc_special ";
				$sql.=" ,c.rc_medicine, c.rc_sweet ";
				if($odSite=="CLIENT")
				{
					$sql.=" ,d.medicalName as medicalName, d.medicalCode as medicalCode, d.doctorName as doctorName, d.doctorCode as doctorpk ";
				}
				else
				{
					$sql.=" ,d.od_medicalname  as medicalName, d.od_doctorname as doctorName, d.od_doctorpk as doctorpk ";
				}
				
				$sql.=" from ".$dbH."_order ";
				$sql.=" a inner join ".$dbH."_decoction b on b.dc_keycode=a.od_keycode ";
				$sql.=" inner join ".$dbH."_recipeuser c on c.rc_code=a.od_scription ";

				if($odSite=="CLIENT")
				{
					$sql.=" left join ".$dbH."_order_CLIENT d on d.keycode=a.od_keycode ";
				}
				$sql.=" where a.od_keycode='".$odKeycode."' ";

				$dt=dbone($sql);
				$json["sql"]=$sql;

				$od_staff=$dt["DOCTORPK"];//한의사PK 
				$rc_code=$dt["OD_SCRIPTION"];//recipeuser code 
				$od_matype=$dt["OD_MATYPE"];//조제타입
				$od_chubcnt=$dt["OD_CHUBCNT"];//첩수
				$od_packcnt=$dt["OD_PACKCNT"];//팩수 
				$od_packcapa=$dt["OD_PACKCAPA"];//팩수 
				$dc_time=$dt["DC_TIME"];//탕전시간
				$rc_medicine=$dt["RC_MEDICINE"];//약재
				$rc_sweet=$dt["RC_SWEET"];//별전 
				$dc_special=$dt["DC_SPECIAL"];

				$dc_binders=$dt["DC_BINDERS"];//결합제
				$dc_shape=$dt["DC_SHAPE"];//결합제

				//주문금액 json data
				$amountdjmedi=json_decode($dt["OD_AMOUNTDJMEDI"], true);
				$json["odSite"]=$odSite;
				$json["od_medicalname"]=$dt["MEDICALNAME"];
				$medicalpk=$dt["MEDICALCODE"];
				$json["od_medicalcode"]=$medicalpk;
				$json["od_doctorname"]=$dt["DOCTORNAME"];
				$json["od_doctorpk"]=$dt["DOCTORPK"];
				$json["od_keycode"]=$odKeycode;

				if($od_staff)   
				{
					//---------------------------------------------------
					//Medical 정보 가져오기 
					//---------------------------------------------------
					$msql=" select ";
					$msql.=" a.me_company, a.me_userid, a.me_name, b.mi_name, b.mi_grade, b.mi_phone, b.mi_zipcode, b.mi_address ";
					$msql.=" from ".$dbH."_member ";
					$msql.=" a inner join ".$dbH."_medical b on a.me_company=b.mi_userid ";

					//url = odKeycode=2020042716013700001&site=CLIENT&memState=change&memDoctorid=0858430158&memDoctorpk=null

					if($odSite=="CLIENT")
					{
						$msql.=" where a.me_idpk='".$od_staff."' and a.me_idpk>0 and a.me_use='Y' and b.mi_cypk='".$medicalpk."' and b.mi_cypk>0 and b.mi_use='Y' ";
					}
					else
					{
						$msql.=" where a.me_auth='".$od_staff."' and a.me_auth!=0 and a.me_use='Y' ";
					}
					
					$mdt=dbone($msql);

					$json["msql"]=$msql;

					if($mdt["ME_COMPANY"]) //등록되어있다면 
					{
						//---------------------------------------------------
						//config 파일의 정보를 가져오자 
						//---------------------------------------------------
						$config=setConfigPrice();
						//---------------------------------------------------

						//---------------------------------------------------
						//한의원 정보 셋팅 
						//---------------------------------------------------
						$re_sendName=$mdt["MI_NAME"];//한의원이름
						$mi_grade=$mdt["MI_GRADE"];//한의원등급 20190918
						$re_sendPhone=$mdt["MI_PHONE"];//한의원전화번호 
						$re_sendMobile=$mdt["MI_PHONE"];//한의원전화번호 
						$re_sendZipcode=$mdt["MI_ZIPCODE"];//한의원주소
						$re_sendAddress=$mdt["MI_ADDRESS"];//한의원상세주소 
						$od_userid=$mdt["ME_COMPANY"];//한의원ID
						$od_staff=$mdt["ME_USERID"];//한의사ID
						//---------------------------------------------------


						//------------------------------------------
						//20190918 : 조제비,탕전비,배송비
						//------------------------------------------
						$ma_price=getConfigPrice("making", $mi_grade);//조제비 
						$dc_price=getConfigPrice("decoction", $mi_grade);//탕전비
						$re_price=getConfigPrice("release", $mi_grade);//배송비 
						//------------------------------------------


						//파우치 
						$hPackCodeList = getPackCodeTitle($od_userid, "odPacktype,reBoxdeli,reBoxmedi");
						$odPacktypeList = getCodeList($hPackCodeList, 'odPacktype');//파우치 ----> 탕전파우치 
						$reBoxmediList = getCodeList($hPackCodeList, 'reBoxmedi');//한약박스
						$reBoxdeliList = getCodeList($hPackCodeList, 'reBoxdeli');//배송포장재종류 
						//---------------------------------------------------
						
						//---------------------------------------------------
						//20190918 : 조제타입에 따라 파우치를 바꾸자 
						//---------------------------------------------------
						$od_packtype=$odPacktypeList[0]["pbCode"];
						$od_packprice=getPackPrice($odPacktypeList[0], $mi_grade);
						
						//한약박스 
						$re_boxmedi=$reBoxmediList[0]["pbCode"];
						$re_boxmedicapa=$reBoxmediList[0]["pbCapa"];
						$re_boxmediprice=getPackPrice($reBoxmediList[0], $mi_grade);
						//배송박스 
						$re_boxdeli=$reBoxdeliList[0]["pbCode"];
						$re_boxdeliprice=getPackPrice($reBoxdeliList[0], $mi_grade);
						//---------------------------------------------------



						//---------------------------------------------------
						//20190918 : 약재비와 물량 계산하자 
						//---------------------------------------------------
						//|HD10141_02,4,inmain,24|HD10136_01,8,inmain,25|HD10115_08,8,inmain,23.1|HD10095_20,8,inmain,27.9|HD10409_01,4,inmain,12.5|HD10463_08,6,inmain,31.2|HD10504_01,4,inmain,13.2|HD10199_01,4,inmain,25.2|HD10400_01,4,inmain,7.7|HD10132_09,4,inmain,12|*숙지황(신흥/중국)-灸__숙지황(신흥/중국)-灸,15,inmain,0
						$arr=explode("|",$rc_medicine);
						$medicode=$nomedicode="";
						$mdCapa=array();
						for($i=1;$i<count($arr);$i++)
						{
							$arr2=explode(",",$arr[$i]);
							//------------------------------------------------
							//20190624 : 추가 (없는 약재가 있다면)
							//------------------------------------------------
							if(strpos($arr2[0], "*") !== false) //포함되어있다면 
							{
								$newmdcode=getNewMediCode($arr2[0]);
								$nomedicode.="|".$newmdcode.",".$arr2[1].",".$arr2[2].",".$arr2[3];
								//엑셀에서 넘어온 데이터 
								$mdtitleList[$newmdcode]=getNewExcelTitle($arr2[0]);
							}
							else
							{
								if($i>1)$medicode.=",";
								$newmdcode=getNewMediCode($arr2[0]);
								$medicode.="'".$newmdcode."'";
								//엑셀에서 넘어온 데이터 
								$mdtitleList[$newmdcode]=getNewExcelTitle($arr2[0]);
							}
							//------------------------------------------------
							$mdcapa[$newmdcode]=($arr2[1]) ? $arr2[1] : 0;//첩당약재
						}

						if($medicode)
						{
							$new_medicine="";
							if(substr($medicode,0, 1)==",")
							{
								$medicode=substr($medicode,1);
							}

							//약재함이 없어도 약재는 검색이 되어야함. 
							$mdsql=" select ";
							$mdsql.=" a.md_type, a.md_code, a.md_water, a.md_priceA, a.md_priceB, a.md_priceC, a.md_priceD, a.md_priceE ";
							$mdsql.=" ,b.mm_code, b.mm_title_".$language." mmTitle, b.mm_title_excel ";
							$mdsql.=" from ".$dbH."_medicine a  ";
							$mdsql.=" left join ".$dbH."_medicine_djmedi b on b.md_code=a.md_code ";
							$mdsql.=" where b.mm_use <> 'D' and a.md_code in (".$medicode.") ";
							$mdsql.=" group by a.md_code ";
							$mdsql.=" order by field(a.md_code,".$medicode.") ";
							$mdres=dbcommit($mdsql);

							$json["mdsql"]=$mdsql;

							while($mddt=dbarr($mdres))
							{
								$mdWater[$mddt["MD_CODE"]]=$mddt["MD_WATER"];

								$gmprice=getMediPrice($mddt, $mi_grade);
								$mdPrice[$mddt["MD_CODE"]]=$gmprice;
							}

							$arr=explode("|",$rc_medicine);
							$meditotal=$watertotal=$mdwater=$mtprice=$mediamt=$medipricetotal=$chubprice=$chubpricetotal=0;
							$new_medicine="";
							for($i=1;$i<count($arr);$i++)
							{
								$arr2=explode(",",$arr[$i]);

								if(strpos($arr2[0],"*") !== false) 
								{
									$tmpWater=floatval(0);//약재가 없는건 흡수율이 0으로 셋팅 
									$tmpPrice=floatval(0);//약재가 없는건 약재비가 0으로 셋팅 
									if($odSite=="CLIENT")
									{
										$new_medicine.="|".$arr2[0].",".$arr2[1].",".$arr2[2].",".$arr2[3];
									}
									else
									{
										$new_medicine.="|".$arr2[0].",".$arr2[1].",inmain,0";
									}
								}
								else
								{
									$tmpWater=floatval($mdWater[$arr2[0]]);
									$tmpPrice=floatval($mdPrice[$arr2[0]]);

									if($odSite=="CLIENT")
									{
										$new_medicine.="|".$arr2[0].",".$arr2[1].",".$arr2[2].",".$arr2[3];
									}
									else
									{
										$new_medicine.="|".$arr2[0].",".$arr2[1].",inmain,".$tmpPrice;
									}
									
								}		


								$mediamt=floatval($od_chubcnt)*floatval($arr2[1]);//첩수*약재g = 총약재 
								$mtprice=($mediamt*$tmpPrice);
								$mdwater=($mediamt*$tmpWater)/100; //(총약재*흡수율) 나누기 100

								$chubprice=floatval($arr2[1]) * $tmpPrice;
								$chubpricetotal+=$chubprice;//첩당 약재비 

								$medipricetotal+=$mtprice;//총약재비 토탈 
								$watertotal+=$mdwater;//총물량 토탈 

								$meditotal+=$mediamt;//총토탈 약재량 
							}
						}


						//-------------------------------------------------------------------------------
						// 제환 
						//-------------------------------------------------------------------------------
						//제환 
						if($od_matype=="pill")
						{
							$cdsql=" select GROUP_CONCAT(cd_code,',',cd_value_kor SEPARATOR '|') as code ";
							$cdsql.=" from han_code ";
							$cdsql.=" where (cd_type='dcBinders' and cd_code='".$dc_binders."') or (cd_type='dcShape' and cd_code='".$dc_shape."') ";
							$cddt=dbone($cdsql);

							$json["cdsql"]=$cdsql;

							if($cddt["CODE"])
							{
								$carr=explode("|", $cddt["CODE"]);
								if(strpos($carr[0], $dc_shape) !== false)//포함되어있다면 
								{
									$carr2=explode(",", $carr[0]);
									$dcShapeValue=intval($carr2[1]);
								}
								else if(strpos($carr[1], $dc_shape) !== false)//포함되어있다면 
								{
									$carr2=explode(",", $carr[1]);
									$dcShapeValue=intval($carr2[1]);
								}
								else
								{
									$dcShapeValue=1;
								}

								if(strpos($carr[0], $dc_binders) !== false)//포함되어있다면 
								{
									$carr2=explode(",", $carr[0]);
									$dcBindersValue=intval($carr2[1]);
								}
								else if(strpos($carr[1], $dc_binders) !== false)//포함되어있다면 
								{
									$carr2=explode(",", $carr[1]);
									$dcBindersValue=intval($carr2[1]);
								}
								else
								{
									$dcBindersValue=6;
								}
							}
							else
							{
								$dcShapeValue=1;
								$dcBindersValue=6;
							}

							//결합제 
							$dbs = floor(($meditotal * ($dcBindersValue / 100)));
							//완성량 
							$dcCompleteliang = intval($meditotal - $dc_millingloss - $dc_lossjewan + $dbs);
							//완성갯수 
							$dcCompletecnt = floor($dcCompleteliang / $dcShapeValue);

							$dc_bindersliang=$dbs; //결합제 //DOO :: 위에서 약재 계산후에..
							$dc_completeliang=$dcCompleteliang; //완성량//DOO :: 위에서 약재 계산후에..
							$dc_completecnt=$dcCompletecnt; //완성갯수//DOO :: 위에서 약재 계산후에..
						}
						else
						{
							$dc_bindersliang="0"; //결합제
							$dc_completeliang="0"; //완성량
							$dc_completecnt="0"; //완성갯수 
						}


						//*****************************************************************
						//탕전물량
						//*****************************************************************
						$dooWater=calcDcWater($dc_time, $watertotal, $od_packcnt, $od_packcapa);
						$dcWater=$dooWater;
						
						$dcAlcohol=0;
						if(chkdcSpecial($dc_special)=="alcohol")//주수상반
						{
							$water=calcWaterAlcohol($dooWater);
							$alcohol=$dooWater - $water;
							$dcWater=$water;
							$dcAlcohol=$alcohol;
						}
						else if(chkdcSpecial($dc_special)=="distillation")//증류탕전 
						{
							$water=calcWaterDistillation($dooWater);
							$dcWater=$water;
						}
						else if(chkdcSpecial($dc_special)=="dry")//건조탕전 
						{
							$dcWater=calcWaterDry($watertotal, $od_packcnt, $od_packcapa);
						}
						//*****************************************************************
						$dc_water=$dcWater;
						$json["nonemedical_dcWater"]=$dcWater;
						$json["nonemedical_dcAlcohol"]=$dcAlcohol;


						//*****************************************************************
						// 가격 
						//*****************************************************************
						//약재비 
						$medipricetotal=floatval($chubpricetotal) * floatval($od_chubcnt);//약재비 
						$tgamtotal=0;//별전 				
						$totalmediprice=$medipricetotal + $tgamtotal ;//최종토탈약재비 
						$amountdjmedi["medicine"]=$chubpricetotal.",".$od_chubcnt.",".$medipricetotal;
						$amountdjmedi["sweet"]=$sweetdata;
						$amountdjmedi["totalmedicine"]=$totalmediprice;

						//감미제 
						//dcSugar
						//HD017603KR0004J,교이5bx,5,270,32
						$dcSugartotal=$sugartot;
						$amountdjmedi["sugar"]=$sugardata;

						//조제비
						$makingprice=floatval($od_packcnt) * floatval($ma_price);
						//선전비
						$infirst=chkInfirstPrice($rc_medicine, $firstPrice);
						//후하비
						$inafter=chkInafterPrice($rc_medicine, $afterPrice);

						$amountdjmedi["makingprice"]=$ma_price.",".$od_packcnt.",".$makingprice;
						$amountdjmedi["infirst"]=$infirst.",1,".$infirst;
						$amountdjmedi["inafter"]=$inafter.",1,".$inafter;

						$totalmaking=$makingprice+$infirst+$inafter;
						$amountdjmedi["making"]=$totalmaking;


						//탕전비
						if(chkCheob($odGoods)==true)//첩약이면 
						{
							$dc_price=0;
							$decoctionprice=0;
						}
						$decoctionprice=$dc_price;	
						$amountdjmedi["decoction"]=$dc_price.",1,".$decoctionprice;


						//특수탕전비  
						$specialtotal=$dc_specialprice;
						$amountdjmedi["special"]=$dc_specialtxt.",".$specialtotal;

						
						//포장비
						$pmdcnt=1;//수량에 상관없이 하기때문에 기본1로 셋팅 
						//파우치 
						$packp=floatval($od_packprice);
						//한약박스 
						$mediboxp=floatval($re_boxmediprice);
						//배송박스 
						$deliboxp=floatval($re_boxdeliprice);
						//포장비 
						if(chkCheob($odGoods)==true)//첩약이면 
						{
							$packingp=0;
							$packPrice=0;
						}
						else
						{
							$packingp=floatval($packPrice);
						}
						//최종토탈포장비 
						$totalpackprice=$packp+$mediboxp+$deliboxp+$packingp;
						$amountdjmedi["poutch"]=$od_packprice.",".$pmdcnt.",".$packp;
						$amountdjmedi["medibox"]=$re_boxmediprice.",".$pmdcnt.",".$mediboxp;
						$amountdjmedi["delibox"]=$re_boxdeliprice.",".$pmdcnt.",".$deliboxp;
						$amountdjmedi["dcshape"]="0,1,0";
						$amountdjmedi["packing"]=$packPrice.",".$pmdcnt.",".$packingp;
						$amountdjmedi["totalpack"]=$totalpackprice;

						//배송비 
						if(chkCheob($odGoods)==true)//첩약이면
						{
							$boxcnt = 1;
							$boxprice=floatval($boxcnt) * floatval($cheobPrice);
							$amountdjmedi["release"]=$cheobPrice.",".$boxcnt.",".$boxprice;
							$re_boxmedibox=$re_boxmedicapa;
							$re_price=$cheobPrice;
						}
						else
						{
							$boxmax = ceil($od_packcnt / $re_boxmedicapa);//올림 
							$boxcnt = ceil($boxmax/2);
							$boxprice=floatval($boxcnt) * floatval($re_price);
							$amountdjmedi["release"]=$re_price.",".$boxcnt.",".$boxprice;
							$re_boxmedibox=$re_boxmedicapa;
						}

						//토탈금액
						$odAmount=$totalmediprice+$totalpackprice+$decoctionprice+$makingprice+$boxprice+$dcSugartotal+$specialtotal;
						$od_amount=$odAmount;
						//10원단위 
						$od_amount=getSibdan($od_amount);
						$amountdjmedi["totalamount"]=$od_amount;

						$od_amountdjmedi=my_json_encode($amountdjmedi);
						//*****************************************************************


						//*****************************************************************
						//약재비 
						$medipricetotal=floatval($chubpricetotal) * floatval($od_chubcnt);
						$medipricetotal=getSibdan($medipricetotal);
						//별전 
						$tgamtotal=0;
						//최종토탈약재비 
						$totalmediprice=$medipricetotal + $tgamtotal;
						$totalmediprice=getSibdan($totalmediprice);

						$amountdjmedi["medicine"]=$chubpricetotal.",".$od_chubcnt.",".$medipricetotal;
						$amountdjmedi["sweet"]="0,0,".$tgamtotal;
						$amountdjmedi["totalmedicine"]=$totalmediprice;

						//포장비----------------------------
						//20190917 : 파우치, 한약박스 계산 => 수량에 상관없이 적용됨 * 1
						//----------------------------------
						$pmdcnt=1;//수량에 상관없이 하기때문에 기본1로 셋팅 
						//파우치 
						$packp=floatval($od_packprice);
						$packp=getSibdan($packp);
						//한약박스 
						$mediboxp=floatval($re_boxmediprice);
						$mediboxp=getSibdan($mediboxp);
						//배송박스 
						$deliboxp=floatval($re_boxdeliprice);
						$deliboxp=getSibdan($deliboxp);
						//최종토탈포장비 
						$totalpackprice=$packp+$mediboxp+$deliboxp;
						$totalpackprice=getSibdan($totalpackprice);


						$amountdjmedi["poutch"]=$od_packprice.",".$pmdcnt.",".$packp;
						$amountdjmedi["medibox"]=$re_boxmediprice.",".$pmdcnt.",".$mediboxp;
						$amountdjmedi["delibox"]=$re_boxdeliprice.",".$pmdcnt.",".$deliboxp;
						$amountdjmedi["dcshape"]="0,1,0";
						$amountdjmedi["totalpack"]=$totalpackprice;

						//----------------------------------

						//탕전비----------------------------
						//20190917 : 탕전비 계산 => 용량에 상관없이 Class 적용됨 공식은 약재비와 같음
						//----------------------------------
						$decoctionprice=$dc_price;	
						$decoctionprice=getSibdan($decoctionprice);
						$amountdjmedi["decoction"]=$dc_price.",1,".$decoctionprice;

						//조제비----------------------------
						//20190917 : 조제비 계산 => 팩수 * 조제비 적용
						//----------------------------------
						$makingprice=floatval($od_packcnt) * floatval($ma_price);
						$makingprice=getSibdan($makingprice);
						$amountdjmedi["making"]=$ma_price.",".$od_packcnt.",".$makingprice;

						//배송비----------------------------
						//20190917 : 배송비 계산 => 배송비는 약재박스 단위로 계산하는데 2개당 하나의 송장이 부착 1개일때 - 송장한개, 2개일때  송장한개, 3개일일때 송장 2개...
						//----------------------------------
						$boxmax = ceil($od_packcnt / $re_boxmedicapa);//올림 
						$boxcnt = ceil($boxmax/2);
						$boxprice=floatval($boxcnt) * floatval($re_price);
						$boxprice=getSibdan($boxprice);
						$amountdjmedi["release"]=$re_price.",".$boxcnt.",".$boxprice;

						//토탈금액--------------------------
						//주문금액
						//----------------------------------
						$odAmount=$totalmediprice+$totalpackprice+$decoctionprice+$makingprice+$boxprice;
						$od_amount=$odAmount;
						//10원단위 
						$od_amount=getSibdan($od_amount);
						$amountdjmedi["totalamount"]=$od_amount;
						$od_amountdjmedi=json_encode($amountdjmedi);
						//*****************************************************************

						//주문정보업데이트
						$sql=" update ".$dbH."_order ";
						$sql.=" set od_userid='".$od_userid."', od_staff='".$od_staff."', od_packtype='".$od_packtype."', od_packprice='".$od_packprice."' ";
						$sql.=" , od_packcapa='".$od_packcapa."', od_amount='".$od_amount."', od_amountdjmedi='".$od_amountdjmedi."',  od_modify=sysdate ";
						$sql.=" where od_keycode='".$odKeycode."' ";
						dbcommit($sql);
						$json["order"]=$sql;

						//조제정보업데이트
						$sql=" update ".$dbH."_making ";
						$sql.=" set ma_userid='".$od_userid."', ma_price='".$ma_price."', ma_modify=sysdate ";
						$sql.=" where ma_keycode='".$odKeycode."' ";
						dbcommit($sql);
						$json["making"]=$sql;

						//탕전정보업데이트
						$sql=" update ".$dbH."_decoction ";
						$sql.=" set dc_userid='".$od_userid."', dc_water='".$dc_water."', dcAlcohol='".$dcAlcohol."', dc_price='".$dc_price."', dc_modify=sysdate ";
						$sql.=" where dc_keycode='".$odKeycode."' ";
						dbcommit($sql);
						$json["decoction"]=$sql;

						//마킹정보업데이트
						$sql=" update ".$dbH."_marking ";
						$sql.=" set mr_userid='".$od_userid."', mr_modify=sysdate ";
						$sql.=" where mr_keycode='".$odKeycode."' ";
						dbcommit($sql);
						$json["marking"]=$sql;

						//출고정보업데이트
						$sql=" update ".$dbH."_release ";
						$sql.=" set re_userid='".$od_userid."', re_sendname='".$re_sendName."', re_sendphone='".$re_sendPhone."', re_sendmobile='".$re_sendMobile."', re_sendzipcode='".$re_sendZipcode."', re_sendaddress='".$re_sendAddress."',  re_price='".$re_price."', re_boxmedi='".$re_boxmedi."', re_boxmediprice='".$re_boxmediprice."',re_boxdeli='".$re_boxdeli."',re_boxdeliprice='".$re_boxdeliprice."', re_boxmedibox='".$re_boxmedicapa."', re_modify=sysdate ";
						$sql.=" where re_keycode='".$odKeycode."' ";
						dbcommit($sql);
						$json["release"]=$sql;

						//처방정보업데이트
						$sql=" update ".$dbH."_recipeuser ";
						$sql.=" set rc_userid='".$od_userid."', rc_medicine='".$new_medicine."', rc_modify=sysdate ";
						$sql.=" where rc_code='".$rc_code."' ";
						dbcommit($sql);
						$json["recipeuser"]=$sql;


						$json["apiCode"]=$apiCode;
						$json["resultCode"]="200";
						$json["resultMessage"]="OK";
					}
					else
					{
						//medical이 등록이 안되어있으면..
						$json["apiCode"]=$apiCode;
						$json["resultCode"]="388";
						$json["resultMessage"]="POP_MEDICAL";
						
					}
					//---------------------------------------------------
				}
				else
				{
					$json["apiCode"]=$apiCode;
					$json["resultCode"]="389";
					$json["resultMessage"]="NONE_MEDICAL";
				}
			}
			else
			{
				$json["apiCode"]=$apiCode;
				$json["resultCode"]="398";
				$json["resultMessage"]="NONE_ORDER";//해당하는 주문번호가 없습니다. 
			}
		}
	}
?>
