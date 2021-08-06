<?php
	//이거 안씀 
	//GET
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$medicine=$_GET["medicine"];

	if($apiCode!="medicinetitle"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicinetitle";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	//else if($medicine==""){$json["resultMessage"]="API(medicine) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$smuNewCode=$_GET["smuNewCode"];

		$orderSmuNewCode=str_replace(",","','", $smuNewCode);
		
		$sweet=$_GET["sweet"];
		$infirst=$inmain=$inafter=$inlast="N";
		$rc_medicine=$medicine;
		$rc_sweet=$sweet;
		$json["rc_medicine"]=$rc_medicine;
		$json["rc_sweet"]=$rc_sweet;

		$totmedi=$totsweet=0;

		//"|HD10136_01,8,inmain,21.1|HD10095_01,8,inmain,37.4|HD10115_08,8,inmain,23.1|HD10409_01,4,inmain,12.5|HD10511_15,16,inmain,22.9|HD10463_01,6,inmain,11.7|HD10132_09,4,inmain,12|*감초(1호/중국)-炙"
		if($rc_medicine)
		{
			$arr=explode("|",$rc_medicine);
			$medicode="";$medicapa=0;$medihub="";
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
				$medicapa+=$arr2[1];
				if($arr2[2]=="infirst")$infirst="Y";
				if($arr2[2]=="inmain")$inmain="Y";
				if($arr2[2]=="inafter")$inafter="Y";

				$mdcapa[$newmdcode]=($arr2[1]) ? $arr2[1] : 0;//첩당약재
				$mdprice[$newmdcode]=($arr2[3]) ? $arr2[3] : 0;//가격 
				$mddecotype[$newmdcode]=($arr2[2]) ? $arr2[2] : "inmain";//가격 

				$totmedi++;
			}

			//*******************************************************************************************************
			if($medicode)
			{
				if(substr($medicode,0, 1)==",")
				{
					$medicode=substr($medicode,1);
				}

				//약재함이 없어도 약재는 검색이 되어야함. 
				$sql=" select a.md_type, b.mb_code, group_concat(b.mb_table) as mbTable, sum(b.mb_capacity) as mbCapacity, a.* ";
				$sql.=" , r.mm_title_kor mmTitle, r.mm_title_chn mmTitlechn, r.mm_code ";
				$sql.=" from ".$dbH."_medicine a ";
				$sql.=" left join ".$dbH."_medibox b on b.mb_medicine = a.md_code ";
				$sql.=" left join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code  ";
				$sql.=" where a.md_code in (".$medicode.")  ";
				$sql.=" group by a.md_code ";
				$sql.=" order by field(a.md_code,".$medicode.") ";

				$res=dbqry($sql);
				$json["ssql"]=$sql;
				$json["medicine"]=array();
				while($dt2=dbarr($res))
				{
					//우리약재코드
					$mdCode=$dt2["md_code"];
					//약재코드 
					$mmCode=($dt2["mm_code"]) ? $dt2["mm_code"] : $dt2["md_code"];//한퓨어약재DB에 있다면 

					//------------------------------------------------------------------------------------
					//rc_medicine에 있던 데이터들
					//------------------------------------------------------------------------------------
					$rcCapa = ($mdcapa[$mdCode]) ? $mdcapa[$mdCode] : 0;
					//20190917 : 약재가격을 5단계로 
					$rcPrice=$mdprice[$mdCode]; //처방할때 저장된 약재 가격 

					$rcPriceA=$dt2["md_priceA"]; //저장된 약재 가격 A
					$rcPriceB=$dt2["md_priceB"]; //저장된 약재 가격 B
					$rcPriceC=$dt2["md_priceC"]; //저장된 약재 가격 C
					$rcPriceD=$dt2["md_priceD"]; //저장된 약재 가격 D
					$rcPriceE=$dt2["md_priceE"]; //저장된 약재 가격 E


					$rcDecoType = ($mddecotype[$mdCode]) ? $mddecotype[$mdCode] : "inmain";
					$rcTitle=($mdtitleList[$mdCode]) ? $mdtitleList[$mdCode] : "";
					//------------------------------------------------------------------------------------
					$rcOrigin=($dt2["md_origin_".$language])? $dt2["md_origin_".$language] : "";

					//한퓨어 약재명
					$mdTitle = ($dt2["mmTitle"]) ? $dt2["mmTitle"] : $dt2["md_title_".$language];
					//우리약재명
					$djmediTitle=$dt2["md_title_".$language];
					//허브코드 
					$medihub.="'".$dt2["md_hub"]."'";

					$rcMedicode=($dt2["mm_code"]) ? $dt2["md_code"] : $dt2["md_code"]."*".$djmediTitle;

					//현재 창고에 있는 약재량 
					$mdQty=($dt2["md_qty"]) ? $dt2["md_qty"] : "0";
					$rcmedibox=($dt2["mbTable"]) ? $dt2["mbTable"] : "";

					$medicine=array(

						"rcType"=>"query",

						"rcCapa"=>$rcCapa, 
						"rcPrice"=>$rcPrice,
						//20190917 : 약재가격 5단계 추가 
						"rcPriceA"=>$rcPriceA,
						"rcPriceB"=>$rcPriceB,
						"rcPriceC"=>$rcPriceC,
						"rcPriceD"=>$rcPriceD,
						"rcPriceE"=>$rcPriceE,

						"rcDecoctype"=>$rcDecoType, 

						"mmCode"=>$mmCode,
						"rcMedititle"=>$mdTitle, 
						"rcMedicode"=>$rcMedicode, 
						"rcOrigin"=>$rcOrigin,

						"exceltitle"=>$rcTitle,
						"mdtitle"=>$djmediTitle,  //han_medicine 의 약재명

						"mdQty"=>$mdQty,
						"rcmedibox"=>$rcmedibox,

						"mdType"=>$dt2["md_type"],//약재타입 
						
						"mbCapacity"=>$dt2["mbCapacity"],//현재 박스에 있는 총 약재량 (조제대+공통 합계)

						"rcWaterchk"=>$dt2["md_waterchk"],
						"rcWatercode"=>$dt2["md_watercode"],
						"rcWater"=>$dt2["md_water"],

						"rcPoison"=>$dt2["md_poison"],
						"rcDismatch"=>$dt2["md_dismatch"]
						);
					array_push($json["medicine"], $medicine);
				
				}

				$json["nomedicode"]=$nomedicode;

				if($nomedicode)
				{
					$narr=explode("|",$nomedicode);
					for($i=1;$i<count($narr);$i++)
					{
						$narr2=explode(",",$narr[$i]);
						$narr3=explode("*",$narr2[0]);
						$medicine=array(
							"rcType"=>"nomedicode",

							"rcCapa"=>$narr2[1], 
							"rcPrice"=>"0",
							//20190917 : 약재가격 5단계 추가 
							"rcPriceA"=>"0",
							"rcPriceB"=>"0",
							"rcPriceC"=>"0",
							"rcPriceD"=>"0",
							"rcPriceE"=>"0",

							"rcDecoctype"=>$narr2[2], 

							"mmCode"=>trim($narr3[0]),
							"rcMedititle"=>trim($narr3[1]), 
							"rcMedicode"=>trim($narr2[0]), 
							"rcOrigin"=>"", 
							
							"exceltitle"=>trim($narr3[1]),
							"mdtitle"=>"",
						
							"mdQty"=>"0",//현재 창고에 있는 약재량 
							"rcmedibox"=>"",

							"mbCapacity"=>"0",
							
							"rcWaterchk"=>"",
							"rcWatercode"=>"",
							"rcWater"=>"0",

							"rcPoison"=>"",
							"rcDismatch"=>""
							);
						array_push($json["medicine"], $medicine);
					}
				}
			}
			else
			{
				//$json["medicineprice"]=$mdprice;
				$dismatchcnt=$poisoncnt=0;
				$json["medicine"]=array();
				for($i=1;$i<count($arr);$i++)
				{
					if($arr[$i]!="")
					{
						$arr2=explode(",",$arr[$i]);

						$newmdcode=getNewMediCode($arr2[0]);
						$mdtitleexcel=getNewExcelTitle($arr2[0]);

						if($mddismatch[$newmdcode]=="Y")$dismatchcnt++;
						if($mdpoison[$newmdcode]=="Y")$poisoncnt++;

						if($mmcode[$newmdcode]){$mmCode=$mmcode[$newmdcode];}else{$mmCode="";}

						if($mdtitle[$newmdcode]){$rcMedititle=$mdtitle[$newmdcode];}else{$rcMedititle=$mdtitleexcel;}
						if($mdtitlechn[$newmdcode]){$rcMedititlechn=$mdtitlechn[$newmdcode];}else{$rcMedititlechn="-";}
						if($mdorigin[$newmdcode]){$rcOrigin=$mdorigin[$newmdcode];}else{$rcOrigin="-";}
						if($arr2[1]){$rcCapa=$arr2[1];}else{$rcCapa=0;}
						if($arr2[3]){$rcPrice=$arr2[3];}else{$rcPrice=$mdprice[$newmdcode];}
						if($mdmedibox[$newmdcode]){$rcmedibox=$mdmedibox[$newmdcode];}else{$rcmedibox="-";}
						if($mdqty[$newmdcode]){$mdQty=$mdqty[$newmdcode];}else{$mdQty="0";}
						if($mbcapacity[$newmdcode]){$mbCapacity=$mbcapacity[$newmdcode];}else{$mbCapacity="0";}
						//if(!$rcPrice){$rcPrice=0;}

						$mbMedicine = ($refer) ? $mmCode : $newmdcode;//약재코드 
						
						$medicine=array(
							"rcType"=>"medicodeelse",
							"rcMedicode"=>$newmdcode, 
							"mmCode"=>$mbMedicine,
							"rcMedititle"=>$rcMedititle, 
							"rcMedititlechn"=>$rcMedititlechn, 
							"rcCapa"=>$rcCapa, 
							"rcDecoctype"=>$arr2[2], 
							"rcOrigin"=>$rcOrigin, 
							"rcPrice"=>$rcPrice,
							//20190917 : 약재가격 5단계 추가 
							"rcPriceA"=>"0",
							"rcPriceB"=>"0",
							"rcPriceC"=>"0",
							"rcPriceD"=>"0",
							"rcPriceE"=>"0",
							"mdQty"=>$mdQty,
							"mbCapacity"=>$mbCapacity,
							"rcmedibox"=>$rcmedibox,

							"rcWaterchk"=>$mdWaterchk[$newmdcode],
							"rcWatercode"=>$mdWatercode[$newmdcode],
							"rcWater"=>$mdWater[$newmdcode],

							"rcPoison"=>$mdpoison[$newmdcode],
							"rcDismatch"=>$mddismatch[$newmdcode]
							);
						array_push($json["medicine"], $medicine);
					}
				}
			}
			//*******************************************************************************************************
		}


		if($rc_sweet)
		{
			$sarr=explode("|",$rc_sweet);
			$sweetcode="";$sweetcapa=0;
			for($i=1;$i<count($sarr);$i++)
			{
				$sarr2=explode(",",$sarr[$i]);

				//------------------------------------------------
				//20190624 : 추가 (없는 약재가 있다면)
				//------------------------------------------------
				if(strpos($sarr2[0], "*") !== false) //포함되어있다면 
				{
					$newmdcode=getNewMediCode($sarr2[0]);
					$nomedicode.="|".$newmdcode.",".$sarr2[1].",".$sarr2[2].",".$sarr2[3];
					//엑셀에서 넘어온 데이터 
					$mdtitleList[$newmdcode]=getNewExcelTitle($sarr2[0]);
				}
				else
				{
					if($i>1)$sweetcode.=",";
					$newmdcode=getNewMediCode($sarr2[0]);
					$sweetcode.="'".$newmdcode."'";
					//엑셀에서 넘어온 데이터 
					$mdtitleList[$newmdcode]=getNewExcelTitle($sarr2[0]);
				}
				//------------------------------------------------
				$sweetcapa+=$sarr2[1];

				$mdcapa[$newmdcode]=($sarr2[1]) ? $sarr2[1] : 0;//첩당약재
				$mdprice[$newmdcode]=($sarr2[3]) ? $sarr2[3] : 0;//가격 
				$mddecotype[$newmdcode]=($sarr2[2]) ? $sarr2[2] : "inlast";//가격 
				$totsweet++;
			}

			if(substr($sweetcode,0, 1)==",")
			{
				$sweetcode=substr($sweetcode,1);
			}

			//약재함이 없어도 약재는 검색이 되어야함. 
			$sql=" select a.md_type, b.mb_code, group_concat(b.mb_table) as mbTable, sum(b.mb_capacity) as mbCapacity, a.* ";
			$sql.=" , r.mm_title_kor mmTitle, r.mm_title_chn mmTitlechn, r.mm_code ";
			$sql.=" from ".$dbH."_medicine a ";
			$sql.=" left join ".$dbH."_medibox b on b.mb_medicine = a.md_code ";
			$sql.=" left join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code  ";
			$sql.=" where a.md_code in (".$sweetcode.")  ";
			$sql.=" group by a.md_code ";
			$sql.=" order by field(a.md_code,".$sweetcode.") ";

			$res=dbqry($sql);
			$json["sweetsql"]=$sql;
			$json["sweet"]=array();
			while($dt2=dbarr($res))
			{
				//우리약재코드
				$mdCode=$dt2["md_code"];
				//약재코드 
				$mmCode=($dt2["mm_code"]) ? $dt2["mm_code"] : $dt2["md_code"];//한퓨어약재DB에 있다면 

				//------------------------------------------------------------------------------------
				//rc_medicine에 있던 데이터들
				//------------------------------------------------------------------------------------
				$rcCapa = ($mdcapa[$mdCode]) ? $mdcapa[$mdCode] : 0;
				//20190917 : 약재가격 5단계로 
				$rcPrice=$mdprice[$mdCode];
				$rcPriceA=$dt2["md_priceA"]; //저장된 약재 가격 A
				$rcPriceB=$dt2["md_priceB"]; //저장된 약재 가격 B
				$rcPriceC=$dt2["md_priceC"]; //저장된 약재 가격 C
				$rcPriceD=$dt2["md_priceD"]; //저장된 약재 가격 D
				$rcPriceE=$dt2["md_priceE"]; //저장된 약재 가격 E

				$rcDecoType = ($mddecotype[$mdCode]) ? $mddecotype[$mdCode] : "inmain";
				$rcTitle=($mdtitleList[$mdCode]) ? $mdtitleList[$mdCode] : "";
				//------------------------------------------------------------------------------------
				$rcOrigin=($dt2["md_origin_".$language])? $dt2["md_origin_".$language] : "";

				//한퓨어 약재명
				$mdTitle = ($dt2["mmTitle"]) ? $dt2["mmTitle"] : $dt2["md_title_".$language];
				//우리약재명
				$djmediTitle=$dt2["md_title_".$language];
				//허브코드 
				$medihub.="'".$dt2["md_hub"]."'";

				$rcMedicode=($dt2["mm_code"]) ? $dt2["md_code"] : $dt2["md_code"]."*".$djmediTitle;

				//현재 창고에 있는 약재량 
				$mdQty=($dt2["md_qty"]) ? $dt2["md_qty"] : "0";
				$rcmedibox=($dt2["mbTable"]) ? $dt2["mbTable"] : "";

				$medicine=array(

					"rcType"=>"query",

					"rcCapa"=>$rcCapa, 
					"rcPrice"=>$rcPrice,
					//20190917 : 약재가격 5단계 추가 
					"rcPriceA"=>$rcPriceA,
					"rcPriceB"=>$rcPriceB,
					"rcPriceC"=>$rcPriceC,
					"rcPriceD"=>$rcPriceD,
					"rcPriceE"=>$rcPriceE,

					"rcDecoctype"=>$rcDecoType, 

					"mmCode"=>$mmCode,
					"rcMedititle"=>$mdTitle, 
					"rcMedicode"=>$rcMedicode, 
					"rcOrigin"=>$rcOrigin,

					"exceltitle"=>$rcTitle,
					"mdtitle"=>$djmediTitle,  //han_medicine 의 약재명

					"mdQty"=>$mdQty,
					"rcmedibox"=>$rcmedibox,

					"mdType"=>$dt2["md_type"],//약재타입 
					
					"mbCapacity"=>$dt2["mbCapacity"],//현재 박스에 있는 총 약재량 (조제대+공통 합계)

					"rcWaterchk"=>$dt2["md_waterchk"],
					"rcWatercode"=>$dt2["md_watercode"],
					"rcWater"=>$dt2["md_water"],

					"rcPoison"=>$dt2["md_poison"],
					"rcDismatch"=>$dt2["md_dismatch"]
					);
				array_push($json["sweet"], $medicine);
			
			}

			$json["nomedicode"]=$nomedicode;

			if($nomedicode)
			{
				$narr=explode("|",$nomedicode);
				for($i=1;$i<count($narr);$i++)
				{
					$narr2=explode(",",$narr[$i]);
					$narr3=explode("*",$narr2[0]);
					$medicine=array(
						"rcType"=>"nomedicode",

						"rcCapa"=>$narr2[1], 
						"rcPrice"=>"0",
						//20190917 : 약재가격 5단계 추가 
						"rcPriceA"=>"0",
						"rcPriceB"=>"0",
						"rcPriceC"=>"0",
						"rcPriceD"=>"0",
						"rcPriceE"=>"0",
						"rcDecoctype"=>$narr2[2], 

						"mmCode"=>trim($narr3[0]),
						"rcMedititle"=>trim($narr3[1]), 
						"rcMedicode"=>trim($narr2[0]), 
						"rcOrigin"=>"", 
						
						"exceltitle"=>trim($narr3[1]),
						"mdtitle"=>"",
					
						"mdQty"=>"0",//현재 창고에 있는 약재량 
						"rcmedibox"=>"",

						"mbCapacity"=>"0",
						
						"rcWaterchk"=>"",
						"rcWatercode"=>"",
						"rcWater"=>"0",

						"rcPoison"=>"",
						"rcDismatch"=>""
						);
					array_push($json["medicine"], $medicine);
				}
			}
		}

		$json["totMedicine"]=intval($totmedi)+intval($totsweet);
		$json["totMedicapa"]=$medicapa;

//		$json["mdpoison"]=$mdpoison;
//		$json["mddismatch"]=$mddismatch;
		$json["medihub"]=$medihub;
		$json["medicode"]=$medicode;
		


		$dismatch=array();
		$dismatchtxt="";
		//상극체크- 후하 전 위치
		$sql=" select a.dm_group, a.dm_medicine, ";
		if($refer)
			$sql.=" group_concat(r.mm_title_".$language.") mdTitle ";
		else
			$sql.=" group_concat(b.md_title_".$language.") mdTitle ";
		$sql.=" from ".$dbH."_medi_dismatch a  ";
		$sql.=" join ".$dbH."_medicine b on(find_in_set(b.md_code,a.dm_medicine) > 0) ";
		//----------------------------------------------------------------------
		//세명대 약재명을 가져오기 위함
		if($refer)
			$sql.=" inner join ".$dbH."_medicine_".$refer." r on b.md_code=r.md_code  ";
		//----------------------------------------------------------------------
		$sql.=" where a.dm_medicine <> '' and a.dm_use='Y' ";
		$sql.=" group by a.dm_seq ";


		$res=dbqry($sql);
		while($dt=dbarr($res)){
			$arrtxt=$dt["mdTitle"];
			$arr=explode(",",$dt["dm_medicine"]);
			$arr=array_unique($arr);
			$arrcnt=count($arr);
			$valcnt=0;
			$tmpcode=$tmptxt="";
			foreach($arr as $val){
				if(strpos($medicode,$val)){
					$tmpcode.=",".$val;
					$valcnt++;
				}
			}
			if($arrcnt==$valcnt){
				array_push($dismatch, $tmpcode);
				$dismatchtxt.=",(".$arrtxt.")";
			}
		}
		$json["dismatch"]=$dismatch;
		$json["totDismatch"]=count($dismatch);
		$dismatchtxt = substr($dismatchtxt,1);


		$poison=array();
		$poisontxt="";
		//독성체크- 후하 전 위치

		$sql=" select a.po_medicine, b.md_hub,b.md_code, ";
		if($refer)
			$sql.=" r.mm_title_".$language." mdTitle ";
		else
			$sql.=" b.md_title_".$language." mdTitle ";
		
		$sql.=" from ".$dbH."_medi_poison a ";
		$sql.=" left join ".$dbH."_medicine b on a.po_medicine=b.md_hub and b.md_use <> 'D' ";
		//----------------------------------------------------------------------
		//세명대 약재명을 가져오기 위함
		if($refer)
			$sql.=" inner join ".$dbH."_medicine_".$refer." r on b.md_code=r.md_code  ";
		//----------------------------------------------------------------------
		$sql.=" where a.po_medicine <> '' and a.po_code <> 100 ";

		$res=dbqry($sql);
		while($dt=dbarr($res)){
			if(strpos($medicode,$dt["md_code"]))
			{
				array_push($poison, $dt["md_code"]);
				$poisontxt.=",".$dt["mdTitle"];
			}
		}

		$json["poison"]=$poison;
		$json["totPoison"]=count($poison);
		$poisontxt = substr($poisontxt,1);


		//$json["rcSweet"]=$rc_sweet;
		//$json["sweet"]=getSweet($rc_sweet);
		$json["deCoction"]["infirst"]=$infirst;
		$json["deCoction"]["inmain"]=$inmain;
		$json["deCoction"]["inafter"]=$inafter;
		$json["deCoction"]["inlast"]=$inlast;

		//상극 중독 회신은 후하 뒤에 위치
		if($dismatchtxt)
		{
			$json["dismatchtxt"]="[DISMATCH] - ".$dismatchtxt;
		}
		else
		{
			$json["dismatchtxt"]="";
		}
		if($poisontxt)
		{
			$json["poisontxt"]="[POISON] - ".$poisontxt;
		}
		else
		{
			$json["poisontxt"]="";
		}

		//------------------------------------------------------------
		// DOO :: DecocCode 테이블 목록 보여주기 위한 쿼리 추가 
		//------------------------------------------------------------
		$decoctypeList = getDecoCodeTitle();//탕전타입
		$json["decoctypeList"]=$decoctypeList;//탕전타입 (선전,일반,후하 )
		//------------------------------------------------------------

		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

	function getNewMediCode($code)
	{
		if(strpos($code, "__") !== false)//약재code에 __이 있다면 
		{
			$mdarr=explode("__",$code);
			$newmdcode=$mdarr[0];
		}
		else
		{
			$newmdcode=$code;
		}
		return $newmdcode;
	}

	function getNewExcelTitle($code)
	{
		if(strpos($code, "__") !== false)//약재code에 __이 있다면 
		{
			$mdarr=explode("__",$code);
			$title=$mdarr[1];
		}
		else
		{
			$title="";
		}
		return $title;
	}

?>
