<?php  
	/// 재고관리 > 약재출고 > 약재바코드 스캔
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$wh_code=$_GET["code"];

	if($apicode!="instocksearch"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="instocksearch";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($wh_code==""){$json["resultMessage"]="API(code) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$mediwhStock=$_GET["whStock"];

		$hCodeList = getNewCodeTitle("whCategoryInStock");
		$whCategoryOutStockList = getCodeList($hCodeList, 'whCategoryInStock');//약재분류 
		$mbTableList = getmaTableList();//조제테이블리스트

		$chk=substr($wh_code, 0, 3);

		if($chk == "STO")///약재바코드일경우 
		{
			$sql2 = " select wh_stock, to_char(wh_expired,'yyyy-mm-dd') as WH_EXPIRED, wh_remain, wh_status  from ".$dbH."_warehouse where wh_code = '".$wh_code."' and wh_type = 'incoming' and wh_use = 'Y' ";
			// select wh_stock, to_char(wh_expired,'yyyy-mm-dd') as WH_EXPIRED, wh_remain, wh_status  from han_warehouse where wh_code = 'STO20200423121555' and wh_type = 'incoming' and wh_use = 'Y' 
			$dt=dbone($sql2);

			$wh_stock=$dt["WH_STOCK"];  //HD011401CN0001I 
			$wh_expired=$dt["WH_EXPIRED"]; //2021-04-24
			$wh_remain=$dt["WH_REMAIN"];  //3000
			$wh_status=$dt["WH_STATUS"];  //incoming

			if($wh_stock) ///해당하는 약재의 유통기한 기준으로 order by해서 유통기한이 얼마 남지 않는 
			{
				if($wh_status == "cancel")
				{
					$inState = "STATECANCEL";///입고취소한 약재입니다
				}
				else if(intval($wh_remain) <= 0)
				{
					$inState = "NOQTY";///재고량이 없는 약재입니다. *********************
				}
				else
				{
					
						
					$sql1=" select * from  ( ";
					$sql1.=" select a.wh_code, a.wh_stock, a.wh_remain, a.wh_staff, a.wh_date, to_char(a.wh_expired,'yyyy-mm-dd') as wh_expired, a.wh_status";
					$sql1.=" ,b.md_title_kor MDTITLE, b.md_origin_kor mdOrigin, b.md_maker_kor mdMaker, b.md_qty, b.md_type";
					$sql1.=" ,c.mm_title_kor MMTITLE  ";
					$sql1.=" from ".$dbH."_warehouse a ";
					$sql1.=" inner join ".$dbH."_medicine b on b.md_code=a.wh_stock ";
					$sql1.=" left join ".$dbH."_medicine_".$refer." c on c.md_code=a.wh_stock ";
					$sql1.=" where a.wh_stock='".$wh_stock."' and a.wh_type='incoming' and a.wh_status = 'incoming' and a.wh_use = 'Y' and a.wh_remain > 0 ";
					$sql1.=" order by a.wh_expired asc, a.wh_remain asc  ) where rownum <= 1 ";
					$dt1=dbone($sql1);

					//select * from  (  select a.wh_code, a.wh_stock, a.wh_remain, a.wh_staff, a.wh_date, a.wh_expired, a.wh_status ,b.md_title_kor MDTITLE, b.md_origin_kor mdOrigin, b.md_maker_kor mdMaker, b.md_qty, b.md_type ,c.mm_title_kor MMTITLE   from han_warehouse a  inner join han_medicine b on b.md_code=a.wh_stock  left join han_medicine_djmedi c on c.md_code=a.wh_stock  where a.wh_stock='HD000101KR0002J' and a.wh_type='incoming' and a.wh_status = 'incoming' and a.wh_use = 'Y' and a.wh_remain > 0  order by a.wh_expired asc, a.wh_remain asc  ) where rownum <= 1 

/*  삭제하기 재고량이 작은걸 떨어냈을경우 그 다음걸로 출고가 되야 되는데 안됨.
					if($dt1["WH_CODE"])
					{
						$csql =" select * from  ( select wh_remain as NEW_WH_REMAIN ,wh_seq from han_warehouse where wh_use<>'D' and wh_code ='".$dt1["WH_STOCK"]."' order by wh_seq desc ) where rownum <= 1 ";
						$dt6=dbone($csql);

						if($dt6["NEW_WH_REMAIN"]==0)
						{
							$dsql1=" select * from  ( ";
							$dsql1.=" select a.wh_code, a.wh_stock, a.wh_remain, a.wh_staff, a.wh_date, to_char(a.wh_expired,'yyyy-mm-dd') as wh_expired, a.wh_status";
							$dsql1.=" ,b.md_title_kor MDTITLE, b.md_origin_kor mdOrigin, b.md_maker_kor mdMaker, b.md_qty, b.md_type";
							$dsql1.=" ,c.mm_title_kor MMTITLE  ";
							$dsql1.=" from ".$dbH."_warehouse a ";
							$dsql1.=" inner join ".$dbH."_medicine b on b.md_code=a.wh_stock ";
							$dsql1.=" left join ".$dbH."_medicine_".$refer." c on c.md_code=a.wh_stock ";
							$dsql1.=" where a.wh_stock='".$wh_stock."' and a.wh_type='incoming' and a.wh_status = 'incoming' and a.wh_use = 'Y' and a.wh_remain > 0 ";
							$dsql1.=" and wh_code<>'".$dt1["WH_STOCK"]."' ";
							$dsql1.=" order by a.wh_expired asc, a.wh_remain asc  ) where rownum <= 1 ";
							$dt7=dbone($dsql1);
						}
						
					}
					
*/


					///출고를 했을대는  outremain의 재고량이 정확함
					$asql =" select * from  ( select wh_remain as NEW_WH_REMAIN ,wh_seq from han_warehouse where wh_use<>'D' and wh_stock ='".$wh_stock."' and wh_code = '".$wh_code."' and wh_status<>'cancel' order by wh_seq desc ) where rownum <= 1 ";
					//select * from  ( select wh_remain as NEW_WH_REMAIN ,wh_seq from han_warehouse where wh_use<>'D' and wh_stock ='HD000101KR0002J' order by wh_seq desc ) where rownum <= 1 
					$dt3=dbone($asql);

					//$dt1["WH_REMAIN"] - > $dt3["NEW_WH_REMAIN"]   //이거를 재고로 처리해야함

					///넘어온 입고코드의 유통기한과 약재코드로 뽑아온 유통기한을 비교하여 처리해야함. $wh_expired

					if($dt1["WH_STOCK"])
					{
						if(intval( $dt3["NEW_WH_REMAIN"]) <= 0)
						{
							$inState = "NOQTY";///재고량이 없는 약재입니다. 
						}
						else
						{
							if($wh_code == $dt1["WH_CODE"]) ///넘어온 입고코드와 뽑아온 입고코드가 같다면 
							{
								$inState = "OKSTO";
								$mdTitle = ($refer) ? $dt1["MMTITLE"] : $dt1["MDTITLE"];///약재명

								$json=array(
									"whStock"=>$dt1["WH_STOCK"], ///약재코드 
									"whRemain"=>$dt3["NEW_WH_REMAIN"],///입고에서 남은량 
									"nowqty"=>$dt3["NEW_WH_REMAIN"],///입고에서 남은량 
									"whStaff"=>$dt1["WH_STAFF"], ///
									"whDate"=>$dt1["WH_DATE"], ///입고일
									"whExpired"=>$dt1["WH_EXPIRED"], ///유통기한
									"mdOrigin"=>$dt1["MDORIGIN"],///원산지
									"mdMaker"=>$dt1["MDMAKER"], ///제조사 
									"mdQty"=>$dt1["MD_QTY"], ///창고량 
									"mdType"=>$dt1["MD_TYPE"],///약재타입 
									"mdTitle"=>$mdTitle, 
									"mbTableList"=>$mbTableList, ///조제테이블리스트
									"whCategoryOutStockList"=>$whCategoryOutStockList,///약재분류
									"mediwhStock"=>$mediwhStock///GET으로 받은 약재코드 
									);
							}
							else
							{
								if(strtotime($wh_expired) > strtotime($dt1["WH_EXPIRED"]))
								{
									$inState = "NOEXPIRED";//유통기한이 얼마남지 않는 약재가 있습니다. 먼저 출고해주세요 
								}
								else if(strtotime($wh_expired) == strtotime($dt1["WH_EXPIRED"]))
								{
								
									if(intval($wh_remain) > intval($dt1["WH_REMAIN"]))
									{
										$inState = "NOREMAIN";//유통기한은 같고, 재고량이 더 적은 약재가 있습니다. 먼저 출고해주세요. 
									}
									else
									{
										$inState = "OKSTO";
										$mdTitle = ($refer) ? $dt1["MMTITLE"] : $dt1["MDTITLE"];//약재명

										$json=array(
											"whStock"=>$dt1["WH_STOCK"], //약재코드 
											"whRemain"=>$dt1["WH_REMAIN"],//입고에서 남은량 
											"whStaff"=>$dt1["WH_STAFF"], //
											"whDate"=>$dt1["WH_DATE"], //입고일
											"whExpired"=>$dt1["WH_EXPIRED"], //유통기한
											"mdOrigin"=>$dt1["MDORIGIN"],//원산지
											"mdMaker"=>$dt1["MDMAKER"], //제조사 
											"mdQty"=>$dt1["MD_QTY"], //창고량 
											"nowqty"=>$dt3["NEW_WH_REMAIN"],///입고에서 남은량 
											"mdType"=>$dt1["MD_TYPE"],//약재타입 
											"mdTitle"=>$mdTitle, 
											"mbTableList"=>$mbTableList, //조제테이블리스트
											"whCategoryOutStockList"=>$whCategoryOutStockList,//약재분류
											"mediwhStock"=>$mediwhStock//GET으로 받은 약재코드 
											);
									}
								
								}
								else
								{
								
									$inState = "OKSTO";
									$mdTitle = ($refer) ? $dt1["MMTITLE"] : $dt1["MDTITLE"];//약재명

									$json=array(
										"whStock"=>$dt1["WH_STOCK"], //약재코드 
										"whRemain"=>$dt1["WH_REMAIN"],//입고에서 남은량 
										"whStaff"=>$dt1["WH_STAFF"], //
										"whDate"=>$dt1["WH_DATE"], //입고일
										"whExpired"=>$dt1["WH_EXPIRED"], //유통기한
										"mdOrigin"=>$dt1["MDORIGIN"],//원산지
										"mdMaker"=>$dt1["MDMAKER"], //제조사 
										"mdQty"=>$dt1["MD_QTY"], //창고량 
										"nowqty"=>$dt3["NEW_WH_REMAIN"],///입고에서 남은량 
										"mdType"=>$dt1["MD_TYPE"],//약재타입 
										"mdTitle"=>$mdTitle, 
										"mbTableList"=>$mbTableList, //조제테이블리스트
										"whCategoryOutStockList"=>$whCategoryOutStockList,//약재분류
										"mediwhStock"=>$mediwhStock//GET으로 받은 약재코드 
										);
								
								}
								
							}
						}
					}
					else
					{
						$inState = "NOMEDICINE";///입고내역이 없습니다. 
					}
				}
			}
			else 
			{
				$inState = "NOMEDICINE";///입고내역이 없습니다. 
			}
		}
		else
		{
			$inState="NOSTO"; ///약재바코드가 아니다. 
		}

		$json["inState"]=$inState;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";

		$json["sql"]=$sql;
		$json["sql1"]=$sql1;
		$json["sql2"]=$sql2;
		$json["asql"]=$asql;

		
	}
?>
