<?php
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$od_seq=$_GET["seq"];
	if($apicode!="orderconfirm"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="orderconfirm";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($od_seq==""){$json["resultMessage"]="API(seq) ERROR";}
	else{

		$returnData=$_GET["returnData"];
		$goods=$_GET["goods"];
		$wcMarking=$_GET["wcMarking"];
		$odGoods=$_GET["odGoods"];//사전조제
		$gdmarking=$_GET["gdmarking"];//
		
		$json=array("apiCode"=>$apicode,"seq"=>$od_seq,"returnData"=>$returnData);

		$json["odGoods"]=$odGoods;
		$json["gdmarking"]=$gdmarking;

		$sql=" select dc_keycode, dc_userid, dc_water, DC_ALCOHOL, dc_time, DC_SUGAR, dc_title, dc_special,DC_SPECIALPRICE, to_char(DC_DATE, 'yyyy-mm-dd') as dcDate ";
		$sql.=" from ".$dbH."_decoction ";
		$sql.=" where dc_keycode = (select od_keycode from ".$dbH."_order where od_seq='".$od_seq."') ";
		$dt=dbone($sql);
		$json["sql0"]=$sql;

		$odKeycode=$dt["DC_KEYCODE"];
		$dcWater=intval($dt["DC_WATER"]);
		$dcAlcohol=intval($dt["DC_ALCOHOL"]);
		$dc_time=$dt["DC_TIME"];
		$dc_sugar=$dt["DC_SUGAR"];//HD017603KR0004J,교이5bx,5,270,32
		$sugardata="";
		$sugartot=0;
		$sugartotalprice=0;
		if($dc_sugar)
		{
			$sarr=explode(",",$dc_sugar);
			if($sarr[0])
			{
				$sugarCode=$sarr[0];//감미제코드
				$sugarName=$sarr[1];//감미제명
				$sugarCapa=$sarr[2];//감미제량
				$sugartotalcapa=$sarr[3];//감미제량 
				$sugarPrice=$sarr[4];//감미제가격 
				$sugartotalprice=$sugartotalcapa*$sugarPrice;

				$sugartot+=$sugartotalprice;

				$sugardata=$sugarName.",".$sugartotalcapa.",".$sugarPrice.",".$sugartotalprice;
			}
		}
		
		$dcDate=$dt["DCDATE"];
		$dcUserid=$dt["DC_USERID"];

		$dc_title=($dt["DC_TITLE"])?$dt["DC_TITLE"]:"decoctype03";//탕전법
		$dc_special=($dt["DC_SPECIAL"])?$dt["DC_SPECIAL"]:"spdecoc01";//특수탕전 
		$dc_specialprice=($dt["DC_SPECIALPRICE"])?$dt["DC_SPECIALPRICE"]:"0";//특수탕전 
		$ssql=" select cd_name_kor as dcSpecial from han_code where cd_type='dcSpecial' and cd_code='".$dc_special."' ";
		$sdt=dbone($ssql);
		$dc_specialtxt=($sdt["DCSPECIAL"])?$sdt["DCSPECIAL"]:"특수탕전없음";
		

		

		//20191119 : 약속처방 관련 
		if($goods=="goods" || $goods=="goodsdecoction")//약속처방
		{
			if($wcMarking=="marking" && $gdmarking) //사전조제 재고가 있을 경우 
			{
				$gsql=" select orderCount, productCode from ".$dbH."_order_client where keycode='".$odKeycode."' ";
				$gdt=dbone($gsql);
				$orderCount=($gdt["ORDERCOUNT"]) ? $gdt["ORDERCOUNT"] : 1;

				$psql=" select ";
				$psql.=" rc_medicine as rcMedicine ";
				$psql.=", rc_sweet as rcSweet ";
				$psql.=" , rc_chub, rc_packcnt, rc_packtype, rc_packcapa, rc_medibox ";
				$psql.=" from ".$dbH."_recipemedical ";
				$psql.=" where rc_code='".$gdmarking."' and rc_use='Y' ";
				$pdt=dbone($psql);
				$rc_medicine=getClob($pdt["RCMEDICINE"]);
				$rc_sweet=getClob($pdt["RCSWEET"]);
				$od_chubcnt=intval($pdt["RC_CHUB"]) * intval($orderCount);
				$od_packcnt=intval($pdt["RC_PACKCNT"]) * intval($orderCount);
				$rc_packtype=$pdt["RC_PACKTYPE"];
				$od_packcapa=$pdt["RC_PACKCAPA"];
				$rc_medibox=$pdt["RC_MEDIBOX"];

				$json["약속3:psql"]=$psql;
				$json["약속3:rc_medicine"]=$rc_medicine;
				$json["약속4:orderCount"]=$orderCount;
				$json["약속4:od_chubcnt"]=$od_chubcnt;

				$json["약속5:od_packcnt"]=$od_packcnt;
				$json["약속6:rc_packtype"]=$rc_packtype;
				$json["약속7:od_packcapa"]=$od_packcapa;
				$json["약속8:rc_medibox"]=$rc_medibox;
			}
			else
			{
				
				$gsql=" select orderCount, productCode from ".$dbH."_order_client where keycode='".$odKeycode."' ";
				$gdt=dbone($gsql);
				$orderCount=($gdt["ORDERCOUNT"])?$gdt["ORDERCOUNT"]:1;
				$productCode=$gdt["PRODUCTCODE"];
				$gd_code="";
				$gd_name="";
				$gd_bomcode="";
				$gd_qty=0;
				$json["약속1:orderCount"]=$orderCount;
				$json["약속2:productCode"]=$productCode;
				$productCode="51";//경옥고스틱10박스 
				if($goods=="goods" && $productCode)//상품
				{
					$psql=" select gd_code, gd_name_".$language." as gdName, gd_bomcode, gd_qty from ".$dbH."_goods where gd_cypk like '%,".$productCode.",%' and gd_use='Y' ";
					$pdt=dbone($psql);
					$gd_code=$pdt["GD_CODE"];
					$gd_name=$pdt["GDNAME"];
					$gd_bomcode=$pdt["GD_BOMCODE"];
					$gd_qty=$pdt["GD_QTY"];
					$json["약속3:psql"]=$psql;
					$json["약속3:gd_code"]=$gd_code;
					$json["약속4:gd_name"]=$gd_name;
					$json["약속5:gd_bomcode"]=$gd_bomcode;
					$json["약속6:gd_qty"]=$gd_qty;
				}
				else if($goods=="goodsdecoction" && $productCode)//약속처방 탕전
				{
					$psql=" select ";
					$psql.=" rc_medicine as rcMedicine ";
					$psql.=", rc_sweet as rcSweet ";
					$psql.=" , rc_chub, rc_packcnt, rc_packtype, rc_packcapa, rc_medibox ";
					$psql.=" from ".$dbH."_recipemedical ";
					$psql.=" where rc_medical='goods' and rc_source like '%,".$productCode.",%' and rc_use='Y' ";
					$pdt=dbone($psql);
					$rc_medicine=getClob($pdt["RCMEDICINE"]);
					$rc_sweet=getClob($pdt["RCSWEET"]);
					$od_chubcnt=intval($pdt["RC_CHUB"])* intval($orderCount);
					$od_packcnt=intval($pdt["RC_PACKCNT"])* intval($orderCount);
					$rc_packtype=$pdt["RC_PACKTYPE"];
					$od_packcapa=$pdt["RC_PACKCAPA"];
					$rc_medibox=$pdt["RC_MEDIBOX"];

					$json["약속3:rc_medicine"]=$rc_medicine;
					$json["약속4:od_chubcnt"]=$od_chubcnt;

					$json["약속5:od_packcnt"]=$od_packcnt;
					$json["약속6:rc_packtype"]=$rc_packtype;
					$json["약속7:od_packcapa"]=$od_packcapa;
					$json["약속8:rc_medibox"]=$rc_medibox;
				}
			}
		}
		else if($goods=="commercial"&& $wcMarking=="marking") //상비처방 
		{
			
			$csql=" select ";
			$csql.=" a.od_scription, a.od_packtype, b.rc_source, r.re_boxmedi ";
			$csql.=" , c.rc_medicine as rmmedicine ";
			$csql.=" , c.rc_sweet as RCSWEET ";
			$csql.=" , c.rc_code rmcode, c.rc_title_kor rmtitle, c.rc_chub rmchub, c.rc_packcnt rmpackcnt, c.rc_packtype rmpacktype ";
			$csql.=" , c.rc_packcapa rmpackcapa, c.rc_medibox rmmedibox ";
			$csql.=" , d.orderCount ";
			if($wcMarking=="marking")
			{
				$csql.=" , e.gd_type, e.gd_code ";
			}
			$csql.=" from ".$dbH."_order ";
			$csql.=" a inner join ".$dbH."_recipeuser b on b.rc_code=a.od_scription ";
			$csql.=" left join ".$dbH."_recipemedical c on c.rc_code=b.rc_source and c.rc_medical='commercial' and c.rc_use='Y'";
			$csql.=" left join ".$dbH."_order_client d on a.od_keycode=d.keycode ";
			$csql.=" inner join ".$dbH."_release r on a.od_keycode=r.re_keycode ";
			if($wcMarking=="marking")
			{
				$csql.=" left join ".$dbH."_goods e on e.gd_recipe=b.rc_source and e.gd_type='commercial' and e.gd_use='Y' ";
			}
			$csql.=" where a.od_seq='".$od_seq."'";
			$cdt=dbone($csql);
			$json["csql"]=$csql;

			$rc_medicine="";
			$rc_sweet="";
			$od_chubcnt="";
			$od_packcnt="";
			$rc_packtype="";
			$od_packcapa="";
			$rc_medibox="";
			$orderCount="";
			$gd_code="";//
			if($wcMarking=="marking")
			{
				$gd_code=$cdt["GD_CODE"];
			}

			
			if($cdt["RMCODE"])
			{
				$orderCount=($cdt["ORDERCOUNT"]) ? $cdt["ORDERCOUNT"] : 1;

				$rc_medicine=getClob($cdt["RMMEDICINE"]);
				$rc_sweet=getClob($cdt["RCSWEET"]);
				$od_chubcnt=intval($cdt["RMCHUB"]) * intval($orderCount);
				$od_packcnt=intval($cdt["RMPACKCNT"]) * intval($orderCount);
				$rc_packtype=$cdt["RMPACKTYPE"];
				$od_packcapa=$cdt["RMPACKCAPA"];
				$rc_medibox=$cdt["RMMEDIBOX"];

				$json["두:orderCount"]=$orderCount;
				$json["두:od_chubcnt"]=$od_chubcnt;
				$json["두:od_packcnt"]=$od_packcnt;
				$json["두:rc_packtype"]=$rc_packtype;
				$json["두:rc_medibox"]=$rc_medibox;
			}
		}
		else if($goods=="worthy" && $wcMarking=="marking")//실속이면서 제품이 있다고 체크했을 경우에는 여기로 온다. 
		{
			$osql="select ";
			$osql.=" a.od_chubcnt, a.od_packtype, a.od_packcapa, a.od_packcnt, b.re_boxmedi, b.re_boxdeli ,  c.rc_code rmcode, c.rc_packtype, c.rc_medibox,  e.gd_type, e.gd_code ";
			$osql.=", d.rc_medicine as rcMedicine ";
			$osql.=", d.rc_sweet as rcSweet ";
			$osql.=" , f.orderCount ";
			$osql.=" from ".$dbH."_order ";
			$osql.=" a inner join ".$dbH."_release b on b.re_keycode=a.od_keycode ";
			$osql.=" inner join ".$dbH."_recipeuser d on d.rc_code=a.od_scription ";
			$osql.=" left join ".$dbH."_recipemedical c on c.rc_code=d.rc_source and c.rc_medical='worthy' and c.rc_use='Y'";
			$osql.=" left join ".$dbH."_goods e on e.gd_recipe=d.rc_source and e.gd_type='worthy' and e.gd_use='Y'";
			$osql.=" left join ".$dbH."_order_client f on a.od_keycode=f.keycode ";
			$osql.=" where od_seq='".$od_seq."' ";
			$odt=dbone($osql);
			$orderCount=($odt["ORDERCOUNT"]) ? $odt["ORDERCOUNT"] : 1;

			$od_chubcnt=intval($odt["OD_CHUBCNT"]) * intval($orderCount);
			$od_packcnt=intval($odt["OD_PACKCNT"]) * intval($orderCount);
			$rc_packtype=$odt["RC_PACKTYPE"];
			$od_packcapa=$odt["OD_PACKCAPA"];
			$rc_medibox=$odt["RC_MEDIBOX"];
			$gd_code=$odt["GD_CODE"];//
			$rc_medicine=getClob($odt["RCMEDICINE"]);
			$rc_sweet=getClob($odt["RCSWEET"]);
			$json["여기로왔음"]="1";

		}
		else
		{
			if($wcMarking=="marking" && $gdmarking) //사전조제 재고가 있을 경우 
			{
				$psql=" select gd_code, gd_name_".$language." as gdName, gd_bomcode, gd_qty from ".$dbH."_goods where gd_recipe='".$gdmarking."' and gd_use='Y' ";
				$pdt=dbone($psql);
				$gd_code=$pdt["GD_CODE"];
				$gd_name=$pdt["GDNAME"];
				$gd_bomcode=$pdt["GD_BOMCODE"];
				$gd_qty=$pdt["GD_QTY"];
				$json["탕제1:psql"]=$psql;
				$json["탕제1:gd_code"]=$gd_code;
				$json["탕제1:gd_name"]=$gd_name;
				$json["탕제1:gd_bomcode"]=$gd_bomcode;
				$json["탕제1:gd_qty"]=$gd_qty;
			}
			//else
			{
				$osql="select ";
				$osql.=" a.od_chubcnt, a.od_packtype, a.od_packcapa, a.od_packcnt, b.re_boxmedi, b.re_boxdeli, f.orderCount ";
				$osql.=", u.rc_medicine as RCMEDICINE ";
				$osql.=", u.rc_sweet as RCSWEET ";
				$osql.=" from ".$dbH."_order ";
				$osql.=" a inner join ".$dbH."_release b on b.re_keycode=a.od_keycode ";
				$osql.=" inner join ".$dbH."_recipeuser u on a.od_scription=u.rc_code ";
				$osql.=" left join ".$dbH."_order_client f on a.od_keycode=f.keycode ";
				$osql.=" where od_seq='".$od_seq."' ";
				$odt=dbone($osql);
				$orderCount=($odt["ORDERCOUNT"]) ? $odt["ORDERCOUNT"] : 1;

				$od_chubcnt=intval($odt["OD_CHUBCNT"]) * intval($orderCount);
				$od_packcnt=intval($odt["OD_PACKCNT"]) * intval($orderCount);
				$rc_packtype=$odt["OD_PACKTYPE"];
				$od_packcapa=$odt["OD_PACKCAPA"];
				$rc_medibox=$odt["RE_BOXMEDI"];
				$rc_medicine=getClob($odt["RCMEDICINE"]);
				$rc_sweet=getClob($odt["RCSWEET"]);
			}

		}

		$json["goods"]=$goods;
		$json["gd_code"]=$gd_code;
		$json["wcMarking"]=$wcMarking;

		if($odGoods=="G"){$od_goods="G";}
		else if($odGoods=="M"){$od_goods="M";}
		else {$od_goods="N";}

		$json["odGoods"]=$odGoods;

		if($goods=="goods" || $wcMarking=="marking")
		{
			$od_goods="Y";
		}
	
		//20191224 : 잠시 gd_qty > 0 인거 보류 
		//if(($goods=="goods" && $gd_code && $gd_bomcode && intval($gd_qty)>0) || ($goods=="goodsdecoction" && $rc_medicine && $od_chubcnt && $od_packcnt && $rc_packtype && $od_packcapa && $rc_medibox) || ($goods=="commercial" && $wcMarking=="marking" && $gd_code) || ($goods=="commercial" && $wcMarking!="marking" && $rc_medicine && $od_chubcnt && $od_packcnt && $rc_packtype && $od_packcapa && $rc_medibox) || ($goods=="worthy" && $wcMarking=="marking" &&  $gd_code) || ($goods=="worthy" && $wcMarking!="marking" &&  $od_chubcnt && $od_packcnt && $rc_packtype && $od_packcapa && $rc_medibox) || !$goods && $od_chubcnt && $od_packcnt && $rc_packtype && $od_packcapa && $rc_medibox)
		if(($goods=="goods" && $gd_code && $gd_bomcode && $wcMarking!="marking" && !$gdmarking) || ($goods=="goods" && $wcMarking=="marking" && $gdmarking && $rc_medicine && $od_chubcnt && $od_packcnt && $rc_packtype && $od_packcapa && $rc_medibox) || ($goods=="goodsdecoction" && $rc_medicine && $od_chubcnt && $od_packcnt && $rc_packtype && $od_packcapa && $rc_medibox) || ($goods=="commercial" && $wcMarking=="marking" && $gd_code) || ($goods=="commercial" && $wcMarking!="marking" && $rc_medicine && $od_chubcnt && $od_packcnt && $rc_packtype && $od_packcapa && $rc_medibox) || ($goods=="worthy" && $wcMarking=="marking" &&  $gd_code) || ($goods=="worthy" && $wcMarking!="marking" &&  $od_chubcnt && $od_packcnt && $rc_packtype && $od_packcapa && $rc_medibox) || (!$goods && $od_chubcnt && $od_packcnt && $rc_packtype && $od_packcapa && $rc_medibox && $wcMarking!="marking" && !$gdmarking) || (!$goods && $wcMarking=="marking" && $gdmarking && $od_chubcnt && $od_packcnt && $rc_packtype && $od_packcapa && $rc_medibox))
		{
			$dsql=" select a.od_code, a.od_userid, a.od_status, a.od_scription, b.mi_name, b.mi_grade, b.mi_delivery from ".$dbH."_order a inner join ".$dbH."_medical b on b.mi_userid=a.od_userid where od_seq='".$od_seq."' ";
			$json["ddddsql"]=$dsql;
			$ddt=dbone($dsql);

			$od_status=$ddt["OD_STATUS"];
			$mi_grade=$ddt["MI_GRADE"];
			$od_scription=$ddt["OD_SCRIPTION"];
			$json["dddd mi_grade"]=$mi_grade;

			if($goods=="goodsdecoction" || $goods=="commercial" || $goods=="worthy" || !$goods || ($goods=="goods" && $wcMarking=="marking" && $gdmarking))//약속처방 탕전 데이터 업데이트 
			{

				$sql=" select re_boxdeli from ".$dbH."_release where re_keycode='".$odKeycode."' ";
				$dt=dbone($sql);
				$re_boxdeli=$dt["RE_BOXDELI"];

				//파우치,한약박스,배송박스 관련 정보들 가져오자 
				$psql=" select pb_code, pb_type, pb_price".$mi_grade." as pbPrice, pb_capa from ".$dbH."_packingbox where pb_code in ('".$rc_packtype."','".$rc_medibox."','".$re_boxdeli."') ";
				$pres=dbqry($psql);
				while($pdt=dbarr($pres))
				{
					if($pdt["PB_TYPE"]=="odPacktype")
					{
						$od_packprice=$pdt["PBPRICE"];
					}
					else if($pdt["PB_TYPE"]=="reBoxmedi")
					{
						$re_boxmediprice=$pdt["PBPRICE"];
						$re_boxmedicapa=$pdt["PB_CAPA"];
					}
					else if($pdt["PB_TYPE"]=="reBoxdeli")
					{
						$re_boxdeliprice=$pdt["PBPRICE"];
					}
				}

			
				$new_rc_medicine="";
				$new_rc_sweet="";
				$arr = explode("|", $rc_medicine);
				for($i=1;$i<count($arr);$i++)
				{
					$arr2=explode(",",$arr[$i]);
					$mdcode=$arr2[0];
					$capa=$arr2[1];
					$type=$arr2[2];
					$price=$arr2[3];

					$sql2=" select ";
					$sql2.=" a.md_type, a.md_code mdCode, a.md_water, a.md_price".$mi_grade." as mdPrice, b.mm_code, b.mm_title_kor mmTitle, b.mm_code_pk ";
					$sql2.=" from han_medicine ";
					$sql2.=" a left join han_medicine_djmedi b on b.md_code=a.md_code ";
					$sql2.=" where b.mm_use<>'D' and b.md_code='".$mdcode."' ";
					$dt2=dbone($sql2);
					$md_code=$dt2["MDCODE"];

					//흡수율
					$mdWater[$md_code]=$dt2["MD_WATER"];
					//가격 
					if($price)
					{
						$mdprice=$price;
					}
					else
					{
						$mdprice=($dt2["MDPRICE"]) ? $dt2["MDPRICE"]:"0";
					}
					//$json["mdprice"]=$mdprice;
					$new_rc_medicine.="|".$mdcode.",".$capa.",".$type.",".$mdprice;
					//$json["new_rc_medicine"]=$new_rc_medicine;
				}
				if($rc_sweet)
				{
					$sarr=explode("|",$rc_sweet);
					for($i=1;$i<count($sarr);$i++)
					{
						$sarr2=explode(",",$sarr[$i]);
						$mdcode=$sarr2[0];
						$capa=$sarr2[1];
						$type=$sarr2[2];
						$price=$arr2[3];

						$sql2=" select ";
						$sql2.=" a.md_type, a.md_code mdCode, a.md_water, a.md_price".$mi_grade." as mdPrice, b.mm_code, b.mm_title_kor mmTitle, b.mm_code_pk ";
						$sql2.=" from han_medicine ";
						$sql2.=" a left join han_medicine_djmedi b on b.md_code=a.md_code ";
						$sql2.=" where b.mm_use<>'D' and b.md_code='".$mdcode."' ";
						$dt2=dbone($sql2);
						$md_code=$dt2["MDCODE"];

						//흡수율
						$mdWater[$md_code]=$dt2["MD_WATER"];
						$mdTitle[$md_code]=$dt2["MMTITLE"];
						//가격 
						if($price)
						{
							$mdprice=$price;
						}
						else
						{
							$mdprice=($dt2["MDPRICE"]) ? $dt2["MDPRICE"]:"0";
						}

						$new_rc_sweet.="|".$mdcode.",".$capa.",".$type.",".$mdprice;
					}
				}


				$rc_medicine=$new_rc_medicine;
				$rc_sweet=$new_rc_sweet;

				$dc_water=0;
				//최종 정리된 약재로 물량 계산하자 
				$arr=explode("|",$new_rc_medicine);
				$meditotal=$watertotal=$mdwater=$mtprice=$mediamt=$medipricetotal=$chubprice=$chubpricetotal=0;
				for($i=1;$i<count($arr);$i++)
				{
					$arr2=explode(",",$arr[$i]);

					if(strpos($arr2[0],"*") !== false) 
					{
						$tmpWater=floatval(0);//약재가 없는건 흡수율이 0으로 셋팅 
						$tmpPrice=floatval(0);//약재가 없는건 약재비가 0으로 셋팅 
					}
					else
					{
						$tmpWater=floatval($mdWater[$arr2[0]]);
						$tmpPrice=floatval($arr2[3]);// 가격 
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

				$sweetdata="";
				if($new_rc_sweet)
				{
					$sarr=explode("|",$new_rc_sweet);
					$sweetpricetotal=0;
					
					for($i=1;$i<count($sarr);$i++)
					{
						$sarr2=explode(",",$sarr[$i]);
						if(strpos($sarr2[0],"*") !== false) 
						{
							$tmpWater=floatval(0);
							$tmpPrice=floatval(0);
							$tmpTitle="";
						}
						else
						{
							$tmpWater=floatval($mdWater[$sarr2[0]]);
							$tmpPrice=floatval($mdPrice[$sarr2[0]]);
							$tmpTitle=$mdTitle[$sarr2[0]];
						}		

						$mediamt=floatval($sarr2[1]);//첩수*약재g = 총약재 
						$mtprice=($mediamt*$tmpPrice);
						$mdwater=($mediamt*$tmpWater)/100; //(총약재*흡수율) 나누기 100

						$sweetpricetotal+=$mtprice;//총약재비 토탈 
						$watertotal+=$mdwater;//총물량 토탈 
						
						$sweetdata.="|".$tmpTitle.",".$mediamt.",".$tmpPrice.",".$mtprice;

					
					}
				}

				//*****************************************************************
				//탕전시간 
				//*****************************************************************
				$dc_time=chkVelvetTime($new_rc_medicine);
				//*****************************************************************

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
				$json["confirm_dcWater"]=$dc_water;
				$json["confirm_dcAlcohol"]=$dcAlcohol;


				//***************************************************************
				// config 
				//***************************************************************			
				$config=setConfigPrice();
				$json["configconfig"]=$config;

				$ma_price=getConfigPrice("making", $mi_grade);//조제비 
				$dc_price=getConfigPrice("decoction", $mi_grade);//탕전비
				$re_price=getConfigPrice("release", $mi_grade);//배송비 
				$packPrice=getConfigPrice("packing", $mi_grade);//포장비 
				$firstPrice=getConfigPrice("first", $mi_grade);//선전비
				$afterPrice=getConfigPrice("after", $mi_grade);//후하비 
				$cheobPrice=getConfigPrice("cheob", $mi_grade);//첩약배송비   

				$json["ma_pricema_price"]=$ma_price;
				$json["dc_pricedc_price"]=$dc_price;
				$json["re_pricere_price"]=$re_price;
				$json["packPrice_price"]=$packPrice;
				$json["firstPrice_price"]=$firstPrice;
				$json["afterPrice_price"]=$afterPrice;
				$json["cheobPrice_price"]=$cheobPrice;
				//***************************************************************			


				//*****************************************************************
				// 가격 
				//*****************************************************************
				$amountdjmedi=array();

				//약재비 
				$medipricetotal=floatval($chubpricetotal) * floatval($od_chubcnt);//약재비 
				$tgamtotal=$sweetpricetotal;//별전 				
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
				$specialtotal=0;
				if(chkdcSpecial($dc_special)=="alcohol")//주수상반
				{
					$specialtotal=(($od_packcnt*$od_packcapa)* 0.1)*$dc_specialprice;
				}
				else if(chkdcSpecial($dc_special)=="distillation")//증류탕전 
				{
					$specialtotal=($od_packcnt*$od_packcapa)*$dc_specialprice;
				}
				else if(chkdcSpecial($dc_special)=="dry")//건조탕전 
				{
					$specialtotal=($od_packcnt*$od_packcapa)*$dc_specialprice;
				}

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



				//----------
				$dsql=" update ".$dbH."_decoction set dc_water='".$dc_water."', DC_ALCOHOL='".$dcAlcohol."', dc_price='".$dc_price."', dc_time='".$dc_time."', dc_title='".$dc_title."', dc_special='".$dc_special."', dc_modify=sysdate where dc_keycode='".$odKeycode."' ";
				$json["dsql"]=$dsql;
				dbcommit($dsql);

				$osql=" update ".$dbH."_order set od_chubcnt='".$od_chubcnt."', od_packtype='".$rc_packtype."', od_packcapa='".$od_packcapa."', od_packcnt='".$od_packcnt."', od_amountdjmedi='".$od_amountdjmedi."', od_amount='".$od_amount."', od_modify=sysdate where od_keycode='".$odKeycode."' ";
				$json["osql"].=$osql;
				dbcommit($osql);

				$rsql=" update ".$dbH."_release set re_boxmedi='".$rc_medibox."', re_boxmedibox='".$re_boxmedicapa."', re_price='".$re_price."', re_modify=sysdate where re_keycode='".$odKeycode."' ";
				$json["rsql"].=$rsql;
				dbcommit($rsql);

				$usql=" update ".$dbH."_recipeuser set rc_medicine='".$rc_medicine."', rc_sweet='".$rc_sweet."', rc_modify=sysdate where rc_code = '".$od_scription."' ";
				$json["usql"].=$usql;
				dbcommit($usql);
			

			}
			
			$sql=" select MAX(od_no+1) as addno from han_order where to_char(od_date,'yyyy-mm-dd') = '".$dcDate."' order by od_no desc ";
			$dt=dbone($sql);
			$json["sql00"].=$sql;
			if($dt["ADDNO"]>0)
			{
				$odNo=intval($dt["ADDNO"]);
			}
			else
			{
				$odNo=1;
			}
			$json["sql00_odNo"].=$odNo;
			//날짜 + seq + 물량 + 침포시간  작업시작시 처리 시작전에는 키코드사용
			//코드변경  날짜 =>  180702 + 00000 + 0000 + 0
			$odNo=sprintf("%05d",$odNo);
			$tmp=intval($dcWater/10);
			if(strlen($tmp)<=4)
			{
				$water=sprintf("%04d",intval($dcWater/10));//물량은 꼭 숫자로 바꾸기 
			}
			else
			{
				$water=substr($tmp,0,4);//물량은 꼭 숫자로 바꾸기 
			}
			//ODD 200106 00094 2948 3
			//ODD 200106 00095 0872 3
			//ODD 200106 00096 0499 3
			//ODD 200106 00097 1471 3
			$melting=3;
			$newdate=date("ymd", strtotime($dcDate));
			$odcode=$newdate.$odNo.$water.$melting;

			$sql=" update ".$dbH."_order set od_code='ODD".$odcode."', od_no='".$odNo."', od_goods='".$od_goods."' where od_keycode='".$odKeycode."' ";
			$json["sql1"].=$sql;
			dbcommit($sql);
			$sql=" update ".$dbH."_making set ma_odcode='ODD".$odcode."',  ma_barcode='MKD".$odcode."' where ma_keycode='".$odKeycode."' ";
			$json["sql2"].=$sql;
			dbcommit($sql);
			$sql=" update ".$dbH."_decoction set dc_odcode='ODD".$odcode."',  dc_barcode='DED".$odcode."' where dc_keycode='".$odKeycode."' ";
			$json["sql3"].=$sql;
			dbcommit($sql);
			$sql=" update ".$dbH."_marking set mr_odcode='ODD".$odcode."',  mr_barcode='MRK".$odcode."' where mr_keycode='".$odKeycode."' ";
			$json["sql4"].=$sql;
			dbcommit($sql);
			$sql=" update ".$dbH."_release set re_odcode='ODD".$odcode."', re_barcode='RED".$odcode."' where re_keycode='".$odKeycode."' ";
			$json["sql5"].=$sql;
			dbcommit($sql);


			if($goods=="goods")//약속처방이면 
			{
				if($goods=="goods" && $wcMarking=="marking" && $gdmarking)
				{
					$sql=" update ".$dbH."_decoction set dc_title='decoctype03',  dc_special='spdecoc01', dc_sterilized='N', dc_cooling='N' where dc_keycode='".$odKeycode."' ";
					dbcommit($sql);
					$json["sql7"].=$sql;
				}
				else
				{
					$sql=" INSERT INTO ".$dbH."_package (gp_odcode, gp_keycode, gp_userid, gp_barcode, gp_goods, gp_goodscnt, gp_subgoods, gp_status, gp_use, gp_date) values ";
					$sql.=" ('ODD".$odcode."','".$odKeycode."','".$dcUserid."','GDS".$odcode."','".$gd_code."','".$orderCount."','".$gd_bomcode."','".$od_status."', 'Y', sysdate ) ";
					$json["sql6"].=$sql;
					dbcommit($sql);
				}
			}

			$json["odCode"]='ODD'.$odcode;
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
		else
		{
			if($goods=="goods" || $goods=="goodsdecoction")//약속처방, 약속처방탕전
			{
				$json["resultCode"]="199";
				if(!$productCode)
				{
					$json["resultMessage"]="ERR_NOT_PRODUECTCODE";
				}
				else if(!$orderCount)
				{
					$json["resultMessage"]="ERR_NOT_ORDERCOUNT";
				}
				else if(!$gd_code)
				{
					$json["resultMessage"]="ERR_NOT_GDCODE";
				}
				else if(!$gd_bomcode)
				{
					$json["resultMessage"]="ERR_NOT_GDBOMCODE";
				}
				//else if(intval($gd_qty)<=0)
				//{
				//	$json["resultMessage"]="ERR_NOT_GDQTY";
				//}
				else if(!$rc_medicine)
				{
					$json["resultMessage"]="ERR_NOT_MEDICINE";
				}
				else if(!$od_chubcnt)
				{
					$json["resultMessage"]="ERR_NOT_CHUBCNT";
				}
				else if(!$od_packcnt)
				{
					$json["resultMessage"]="ERR_NOT_PACKCNT";
				}
				else if(!$rc_packtype)
				{
					$json["resultMessage"]="ERR_NOT_RCPACKTYPE";
				}
				else if(!$od_packcapa)
				{
					$json["resultMessage"]="ERR_NOT_PACKCAPA";
				}
				else if(!$rc_medibox)
				{
					$json["resultMessage"]="ERR_NOT_RCMEDIBOX";
				}

			}
			else if($goods=="commercial")//상비 
			{
				if(!$rc_medicine)
				{
					$json["resultMessage"]="ERR_NOT_MEDICINE";
				}
				else if(!$od_chubcnt)
				{
					$json["resultMessage"]="ERR_NOT_CHUBCNT";
				}
				else if(!$od_packcnt)
				{
					$json["resultMessage"]="ERR_NOT_PACKCNT";
				}
				else if(!$rc_packtype)
				{
					$json["resultMessage"]="ERR_NOT_RCPACKTYPE";
				}
				else if(!$od_packcapa)
				{
					$json["resultMessage"]="ERR_NOT_PACKCAPA";
				}
				else if(!$rc_medibox)
				{
					$json["resultMessage"]="ERR_NOT_RCMEDIBOX";
				}
				else if(!$gd_code && $wcMarking=="marking")
				{
					$json["resultMessage"]="ERR_NOT_GDCODE_MARKING";
				}

			}
			else if($goods=="worthy" && $wcMarking=="marking")//실속이면서 제품이라고 선택했을 경우 
			{
				$json["resultCode"]="199";
				if(!$gd_code)
				{
					$json["resultMessage"]="ERR_NOT_GDCODE_MARKING";
				}
				else if(!$od_chubcnt)
				{
					$json["resultMessage"]="ERR_NOT_CHUBCNT";
				}
				else if(!$od_packcnt)
				{
					$json["resultMessage"]="ERR_NOT_PACKCNT";
				}
				else if(!$rc_packtype)
				{
					$json["resultMessage"]="ERR_NOT_RCPACKTYPE";
				}
				else if(!$od_packcapa)
				{
					$json["resultMessage"]="ERR_NOT_PACKCAPA";
				}
				else if(!$rc_medibox)
				{
					$json["resultMessage"]="ERR_NOT_RCMEDIBOX";
				}
			}
			else
			{
				if($wcMarking=="marking" && $gdmarking)
				{
					if(!$od_chubcnt)
					{
						$json["resultMessage"]="ERR_NOT_CHUBCNT";
					}
					else if(!$od_packcnt)
					{
						$json["resultMessage"]="ERR_NOT_PACKCNT";
					}
					else if(!$rc_packtype)
					{
						$json["resultMessage"]="ERR_NOT_RCPACKTYPE";
					}
					else if(!$od_packcapa)
					{
						$json["resultMessage"]="ERR_NOT_PACKCAPA";
					}
					else if(!$rc_medibox)
					{
						$json["resultMessage"]="ERR_NOT_RCMEDIBOX";
					}
				}
				else
				{
					if(!$od_chubcnt)
					{
						$json["resultMessage"]="ERR_NOT_DATA_CHUBCNT";
					}
					else if(!$od_packcnt)
					{
						$json["resultMessage"]="ERR_NOT_DATA_PACKCNT";
					}
					else if(!$rc_packtype)
					{
						$json["resultMessage"]="ERR_NOT_DATA_RCPACKTYPE";
					}
					else if(!$od_packcapa)
					{
						$json["resultMessage"]="ERR_NOT_DATA_PACKCAPA";
					}
					else if(!$rc_medibox)
					{
						$json["resultMessage"]="ERR_NOT_DATA_RCMEDIBOX";
					}

				}
			}

		}
	}
?>
