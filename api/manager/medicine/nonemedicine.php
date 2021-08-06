<?php  
	/// 주문현황 > 주문리스트 > 약재 리스트 약재등록시 약재매칭
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odKeycode=$_GET["odKeycode"];
	$medicine=$_GET["medicine"];
	$medititle=$_GET["medititle"];	
	$site=$_GET["site"];
	$cymedicode=$_GET["cymedicode"];
	
	if($apiCode!="nonemedicine"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="nonemedicine";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$json["odKeycode"]=$odKeycode;  //2020042716013700001
		$json["medicine"]=$medicine;
		$json["medititle"]=$medititle;
		$json["site"]=$site;
		$json["cymedicode"]=$cymedicode;

		if($medicine)
		{
			if($site=="CLIENT")
			{
				$mmsql=" select md_code, mm_title_kor from han_medicine_djmedi where md_code = '".$medicine."' and mm_use <> 'D'";
				$mmdt=dbone($mmsql);
				$excelchk=true;
				$json["mmdt"]=$mmdt["MD_CODE"];
				$json["mmsql"]=$mmsql;
			}
			else
			{
				$mmsql=" select md_code, mm_title_kor from han_medicine_djmedi where mm_title_excel like '%,".$medititle.",%' and mm_use <> 'D'";
				$mmdt=dbone($mmsql);
				$excelchk=true;
				$json["mmdt"]=$mmdt["MD_CODE"];
				$json["mmsql"]=$mmsql;
			}

			
			if($mmdt["MD_CODE"])
			{
				if($mmdt["MD_CODE"] == $medicine)
				{
					$excelchk=false;
				}
				else
				{
					$excelchk=true;
				}
			}
			else
			{
				$excelchk=false;
			}
			$json["excelchk"]=$excelchk;


			if($excelchk==true)
			{
				//약재가 등록이 안되어있으면..
				$json["apiCode"]=$apiCode;
				$json["resultCode"]="397";
				$json["nomatchTitle"]=$mmdt["MM_TITLE_KOR"];
				$json["resultMessage"]="POP_NOMATCHING";
			}
			else
			{
				$msql=" select ";
				$msql.=" a.mm_code, a.md_code, a.mm_title_kor as mmTitle, a.mm_title_excel, a.mm_title_chn ";
				$msql.=" , b.md_priceA, b.md_priceB, b.md_priceC, b.md_priceD, b.md_priceE, b.md_water ";
				$msql.=" from ".$dbH."_medicine_".$refer;
				$msql.=" a inner join ".$dbH."_medicine b on b.md_code=a.md_code ";
				$msql.=" where a.md_code='".$medicine."' ";

				$mdt=dbone($msql);

				if($mdt["MM_CODE"]) //등록되어있다면 
				{
					if($odKeycode)
					{
						//등록된 약재 정보들 
						$mmCode=$mdt["MM_CODE"];//세명대코드  
						$mdCode=$mdt["MD_CODE"];//디제이메디코드  
						$json["mdCode"]=$mdCode;
						//$mdPrice=$mdt["md_price"];//가격

						$mdExcelPrice=getMediPrice($mdt, $mi_grade);
						$mdWater=$mdt["MD_WATER"];//물량 

						if($site=="CLIENT")
						{
							$asql=" select mm_code_pk from ".$dbH."_medicine_".$refer." where md_code='".$medicine."' and mm_use <> 'D' ";
							$adt=dbone($asql);
							$mmcodepk=explode(",", $adt["MM_CODE_PK"]);
							$json["mmcodepk1"]=$mmcodepk;
							array_push($mmcodepk,$cymedicode.",");
							$json["mmcodepk2"]=$mmcodepk;
							$mmcodepktmp=array_unique($mmcodepk);
							$json["mmcodepktmp"]=$mmcodepktmp;
							$mmcodepk=implode(",",$mmcodepktmp);
							$json["mmcodepk3"]=$mmcodepk;
							$mmcodepk=str_replace(",,",",",$mmcodepk);
							$json["mmcodepk4"]=$mmcodepk;

							$esql=" update ".$dbH."_medicine_".$refer;
							$esql.=" set mm_code_pk='".$mmcodepk."' ";
							$esql.=" where md_code='".$medicine."' and mm_use <> 'D' ";
							$json["esql"]=$esql;
							dbcommit($esql);
						}
						else
						{
							$lastexcel=substr($mdt["MM_TITLE_EXCEL"], -1);
							if($lastexcel==",")
							{
								$mdExcel=$mdt["MM_TITLE_EXCEL"]."".$medititle.",";//엑셀에 등록된 내용 
							}
							else
							{
								$mdExcel=$mdt["MM_TITLE_EXCEL"].",".$medititle.",";//엑셀에 등록된 내용 
							}

							if($mmdt["md_code"])
							{
							}
							else
							{
								//약재 excel update
								$esql2=" update ".$dbH."_medicine_".$refer;
								$esql2.=" set mm_title_excel='".$mdExcel."' ";
								$esql2.=" where md_code='".$medicine."' ";
								$json["esql2"]=$esql2;
								dbcommit($esql2);
							}
						}
				
						$osql=" select ";
						$osql.=" a.od_keycode, a.od_scription, a.od_chubcnt, a.od_packcapa, a.od_packcnt, a.od_matype, a.od_packprice, a.od_amountdjmedi,a.od_goods ";
						$osql.=" , b.rc_medicine , b.rc_sweet, e.ma_price, e.MA_AFTERPRICE, e.MA_FIRSTPRICE ";
						$osql.=" , c.dc_time, c.dc_price, c.dc_shape, c.dc_binders, c.DC_SPECIAL ";
						$osql.=" , d.re_boxmediprice, d.re_boxdeliprice, d.re_price, d.re_box, d.re_boxmedibox ";
						$osql.=" , f.mi_grade ";
						$osql.=" from ".$dbH."_order a ";
						$osql.=" inner join ".$dbH."_recipeuser b on b.rc_code=a.od_scription ";
						$osql.=" inner join ".$dbH."_decoction c on c.dc_keycode=a.od_keycode ";
						$osql.=" inner join ".$dbH."_release d on d.re_keycode=a.od_keycode ";
						$osql.=" inner join ".$dbH."_making e on e.ma_keycode=a.od_keycode ";
						$osql.=" left join ".$dbH."_medical f on f.mi_userid=a.od_userid ";
						$osql.=" where a.od_keycode='".$odKeycode."' ";

					
						$odt=dbone($osql);

						if($odt["OD_KEYCODE"])
						{

							$od_chubcnt=$odt["OD_CHUBCNT"];
							$od_matype=$odt["OD_MATYPE"];
							$od_packcnt=$odt["OD_PACKCNT"];
							$od_packcapa=$odt["OD_PACKCAPA"];
							$od_packprice=$odt["OD_PACKPRICE"];
							$od_scription=$odt["OD_SCRIPTION"];

							$re_boxmediprice=$odt["RE_BOXMEDIPRICE"];
							$re_boxdeliprice=$odt["RE_BOXDELIPRICE"];
							$mi_grade=$odt["MI_GRADE"];

							$dc_shape=$odt["DC_SHAPE"];
							$dc_binders=$odt["DC_BINDERS"];
							$dc_time=$odt["DC_TIME"];

							$od_goods=$odt["OD_GOODS"];
							
							$rc_sweet=$odt["RC_SWEET"];
							$dc_special=$odt["DC_SPECIAL"];
						

							$ma_price=$odt["MA_PRICE"];//조제비
							$dc_price=$odt["DC_PRICE"];//탕전비
							$re_price=$odt["RE_PRICE"];//배송비
							$re_box=$odt["RE_BOX"];//100팩당1박스 
							$re_boxmedibox=$odt["RE_BOXMEDIBOX"];//한약박스50팩당1박스 


							$firstPrice=$odt["MA_FIRSTPRICE"];//선전비
							$afterPrice=$odt["MA_AFTERPRICE"];//후하비 

							$config=setConfigPrice();
							$json["configconfig"]=$config;

							if(!$firstPrice)  
							{							
								$firstPrice=getConfigPrice("first", $mi_grade);//선전비								
							}

							if(!$afterPrice) 
							{
								$afterPrice=getConfigPrice("after", $mi_grade);//후하비  
							}
				
							$amountdjmedi=json_decode(getClob($odt["OD_AMOUNTDJMEDI"]), true);

							//-------------------------------------------------------------------------------
							// 제환 
							//-------------------------------------------------------------------------------
							//제환 
							if($od_matype=="pill")
							{
								//$cdsql=" select GROUP_CONCAT(cd_code,',',cd_value_kor SEPARATOR '|') as code ";
								$cdsql=" select LISTAGG(CONCAT(CONCAT(cd_code, ','), cd_value_kor),'') as code ";
								$cdsql.=" from han_code ";
								$cdsql.=" where (cd_type='dcBinders' and cd_code='".$dc_binders."') or (cd_type='dcShape' and cd_code='".$dc_shape."') ";
								$cddt=dbone($cdsql);


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
								$dc_millingloss=200; //제분손실
								$dc_lossjewan=200; //제환손실 
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
							else  //제환이 아닐때
							{
								$dc_bindersliang="0"; //결합제
								$dc_completeliang="0"; //완성량
								$dc_completecnt="0"; //완성갯수 
							}
							//-------------------------------------------------------------------------------

							$arr=explode("|",getClob($odt["RC_MEDICINE"]));
							
							$rc_medicine="";
							$meditotal=$mediamt=0;
							for($i=1;$i<count($arr);$i++)
							{
								$arr2=explode(",",$arr[$i]);//|1006,3,inmain,13

								if(strpos($arr2[0], "*") !== false && strpos($arr2[0], $medititle) !== false) //포함되어있다면 
								{
									if($site=="CLIENT")
									{
										$rc_medicine.="|".$mdCode.",".$arr2[1].",".$arr2[2].",".$arr2[3];
									}
									else
									{
										$rc_medicine.="|".$mdCode."__".$medititle.",".$arr2[1].",".$arr2[2].",".$mdExcelPrice;
									}
								}
								else
								{
									$rc_medicine.="|".$arr2[0].",".$arr2[1].",".$arr2[2].",".$arr2[3];
								}
							}

							//-------------------------------------------------------------------------------

							$arr=explode("|",$rc_medicine);
							$medicode=$orderbyname="";
							for($i=1;$i<count($arr);$i++)
							{
								$arr2=explode(",",$arr[$i]);
								if($i>1)
								{
									$medicode.=",";
									$orderbyname.=",";
								}

								$newmdcode=getNewMediCode($arr2[0]);
								$medicode.="'".$newmdcode."'";
								$orderbyname.="'".$newmdcode."'";
								$orderbyname.= ",".$i;
								
							}
				
							//뽑아온 약재 검색해서 필요한 데이터 가져오자 
							$mdsql=" select ";
							$mdsql.=" a.md_type, a.md_code, a.md_water,  a.md_priceA, a.md_priceB, a.md_priceC, a.md_priceD, a.md_priceE  ";
							$mdsql.=" ,b.mm_code, b.mm_title_".$language." mmTitle, b.mm_title_excel ";
							$mdsql.=" from ".$dbH."_medicine a  ";
							$mdsql.=" left join ".$dbH."_medicine_djmedi b on b.md_code=a.md_code ";
							$mdsql.=" where b.md_code in (".$medicode.") ";
							//$mdsql.=" order by field(b.md_code, ".$medicode.") ";
							$mdsql.=" order by decode(b.md_code, ".$orderbyname.") ";


							$mdres=dbqry($mdsql);
							$json["mdsql"]=$mdsql;;
							$mdWater=array();
							$mdPrice=array();
							while($mddt=dbarr($mdres))
							{
								$mdWater[$mddt["MD_CODE"]]=$mddt["MD_WATER"];
								$gmprice=getMediPrice($mddt, $mi_grade);
								$mdPrice[$mddt["MD_CODE"]]=$gmprice;
							}
							$json["mdWater"]=$mdWater;
							$json["mdPrice"]=$mdPrice;		
							//-------------------------------------------------------------------------------
							//최종 정리된 약재로 물량 계산하자 
							$arr=explode("|",$rc_medicine);
							$meditotal=$watertotal=$mdwater=$mtprice=$mediamt=$medipricetotal=$chubprice=$chubpricetotal=0;
							for($i=1;$i<count($arr);$i++)
							{
								$arr2=explode(",",$arr[$i]);

								$newcode=getNewMediCode($arr2[0]);

								if($site=="CLIENT")
								{
									$tmpWater=floatval($mdWater[$newcode]);//약재가 없는건 흡수율이 0으로 셋팅 
									$tmpPrice=floatval($arr2[3]);//약재가 없는건 약재비가 0으로 셋팅 
								}
								else
								{
									if(strpos($arr2[0],"*") !== false) 
									{
										$tmpWater=floatval(0);//약재가 없는건 흡수율이 0으로 셋팅 
										$tmpPrice=floatval(0);//약재가 없는건 약재비가 0으로 셋팅 
									}
									else
									{
										$tmpWater=floatval($mdWater[$newcode]);
										$tmpPrice=floatval($mdPrice[$newcode]);
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
							$json["nonemedicine_dcWater"]=$dcWater;
							$json["nonemedicine_dcAlcohol"]=$dcAlcohol;

							//*****************************************************************
							//금액 
							//*****************************************************************
							//약재비 
							$medipricetotal=floatval($chubpricetotal) * floatval($od_chubcnt);							
							$tgamtotal=$sweetpricetotal;//별전 
							$totalmediprice=$medipricetotal + $tgamtotal;							//최종토탈약재비 

							$tmpdecoction=$amountdjmedi["decoction"];
							$tmpmaking=$amountdjmedi["making"];
							$tmprelease=$amountdjmedi["release"];
							$totalpack=$amountdjmedi["totalpack"];
							$tmpsugar=$amountdjmedi["sugar"];
							$tmpspecial=$amountdjmedi["special"];
	
							$amountdjmedi["medicine"]=$chubpricetotal.",".$od_chubcnt.",".$medipricetotal;
							$amountdjmedi["totalmedicine"]=$totalmediprice;
							
							$totalpackprice=floatval($totalpack);
							$dearr=explode(",",$tmpdecoction);
							$decoctionprice=floatval($dearr[2]);
							$maarr=explode(",",$tmpmaking);
							$makingprice=floatval($maarr[2]);
							$rearr=explode(",",$tmprelease);
							$boxprice=floatval($rearr[2]);

							$sugararr=explode(",",$tmpsugar);
							$dcSugartotal=floatval($sugararr[2]);
							$specialarr=explode(",",$tmpspecial);
							$specialtotal=floatval($specialarr[1]);

							//토탈금액--------------------------
							//주문금액
							//----------------------------------
							$makingprice=floatval($od_packcnt) * floatval($ma_price);
							//선전비
							$infirst=chkInfirstPrice($rc_medicine, $firstPrice);
							//후하비
							$inafter=chkInafterPrice($rc_medicine, $afterPrice);
							

							$amountdjmedi["makingprice"]=$ma_price.",".$od_packcnt.",".$makingprice;
							$amountdjmedi["infirst"]=$infirst.",1,".$infirst;
							$amountdjmedi["inafter"]=$inafter.",1,".$inafter;

							$totalmaking=floatval($makingprice)+floatval($infirst)+floatval($inafter);
							$amountdjmedi["making"]=$totalmaking;


							$odAmount=$totalmediprice+$totalpackprice+$decoctionprice+$totalmaking+$boxprice+$dcSugartotal+$specialtotal;
							$od_amount=$odAmount;
							//10원단위 
							$od_amount=getSibdan($od_amount);
							$amountdjmedi["totalamount"]=$od_amount;

							$od_amountdjmedi=my_json_encode($amountdjmedi);
							//*****************************************************************

						
							//주문정보업데이트
							$sql=" update ".$dbH."_order ";
							$sql.=" set od_amount='".$od_amount."', od_amountdjmedi='".$od_amountdjmedi."',  od_modify=sysdate ";
							$sql.=" where od_keycode='".$odKeycode."' ";
							dbcommit($sql);
							$json["order"]=$sql;

							//탕전정보업데이트
							$sql=" update ".$dbH."_decoction ";
							$sql.=" set dc_water='".$dc_water."', dcAlcohol='".$dcAlcohol."', dc_modify=sysdate ";
							$sql.=" where dc_keycode='".$odKeycode."' ";
							dbcommit($sql);
							$json["decoction"]=$sql;

							//처방정보업데이트
							$sql=" update ".$dbH."_recipeuser ";
							$sql.=" set rc_medicine='".$rc_medicine."', rc_modify=sysdate ";
							$sql.=" where rc_code='".$od_scription."' ";
							dbcommit($sql);
							$json["recipeuser"]=$sql;
						


							$json["water"]=$dc_water;
							$json["alcohol"]=$dcAlcohol;
							$json["rc_medicine"]=$rc_medicine;
							$json["rc_sweet"]=$rc_sweet;


							$json["apiCode"]=$apiCode;
							$json["resultCode"]="200";
							$json["resultMessage"]="OK";
						}
						else
						{
							$json["apiCode"]=$apiCode;
							$json["resultCode"]="398";
							$json["resultMessage"]="NONE_ORDER";//해당하는 주문번호가 없습니다. 
						}

					}
					else
					{
						$json["apiCode"]=$apiCode;
						$json["resultCode"]="398";
						$json["resultMessage"]="NONE_ORDER";//해당하는 주문번호가 없습니다. 
					}
				}
				else
				{
					//약재가 등록이 안되어있으면..
					$json["apiCode"]=$apiCode;
					$json["resultCode"]="399";
					$json["resultMessage"]="POP_MEDICINE";
				}
			}
		}
		else
		{
			
			//약재가 등록이 안되어있으면..
			$json["apiCode"]=$apiCode;
			$json["resultCode"]="399";
			$json["resultMessage"]="POP_MEDICINE";
		}
	}
?>
