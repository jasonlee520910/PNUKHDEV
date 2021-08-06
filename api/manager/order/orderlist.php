<?php
	/// 주문현황>주문리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	if($apiCode!="orderlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="orderlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//기간선택 
		$sdate = $_GET["sdate"];
		$edate = $_GET["edate"];
		$searperiodetc=$_GET["searPeriodEtc"];
		//주문상태별 
		$searchStatus=$_GET["searchStatus"];
		//주문진행별 
		$searchProgress=$_GET["searchProgress"];
		//주문조제별  
		$searchMatype=$_GET["searchMatype"];
		//검색 
		$searchtxt=urldecode($_GET["searchTxt"]);

		$search="";
		$wsql="  where a.od_use in ('Y','C') and a.OD_MATYPE <> 'pill' ";

		//기간선택 : 타입과 날짜 
		if($sdate&&$edate)
		{
			$sdate=str_replace(".","-",$sdate);//시작 날짜
			$edate=str_replace(".","-",$edate);//끝 날짜 

			//주문일과 배송요청일 둘다 검색하여 보여주자 
			$wsql.=" and ( ";
			$wsql.=" to_char(a.od_date, 'yyyy-mm-dd') >= '".$sdate."' and to_char(a.od_date, 'yyyy-mm-dd') <= '".$edate."' ";
			$wsql.=" ) ";

			$search.="&sdate=".$sdate."&edate=".$edate;
		}
		//주문상태별 
		if($searchStatus)
		{
			$search.="&searchStatus=".$searchStatus;
			$search.="&searchProgress=".$searchProgress;

			$arr=explode(",",$searchStatus);
			$parr=explode(",",$searchProgress);

			$json["statuscount"]=count($arr);
			$json["progresscount"]=count($parr);

			if(count($arr)>1)
			{
				$wsql.=" and ( ";
				for($i=1;$i<count($arr);$i++)
				{
					if($i>1)$wsql.=" or ";

					switch($arr[$i])
					{
					case "order": case "paid"://주문/접수, 작업대기 
						$wsql.=" a.od_status = '".$arr[$i]."' ";
						break;
					case "done"://완료
						$wsql.=" a.od_status = 'done' ";
						 break;
					case "making"://조제 
					case "decoction": //탕전
					case "marking": //마킹
					case "release"://포장&배송
						//"apply","processing","stop","cancel","done"
						if(count($parr)>1)
						{
							for($j=1;$j<count($parr);$j++)
							{
								if($j>1)$wsql.=" or ";
								$wsql.=" a.od_status = '".$arr[$i]."_".$parr[$j]."' ";
								if($parr[$j]=="processing")
								{
									$wsql.=" or a.od_status = '".$arr[$i]."_start' ";
								}
							}
						}
						else
						{
							$wsql.=" a.od_status like '".$arr[$i]."%' ";
						}
						break;
					default:
						$wsql.=" a.od_status like '%".$arr[$i]."%' ";
						break;
					}
					
				}
				$wsql.=" ) ";
			}
		}

		if($searchMatype)
		{
			$marr=explode(",",$searchMatype);
			$json["matypecount"]=count($marr);
			if(count($marr)>1)
			{
				$wsql.=" and ( ";
				for($i=1;$i<count($marr);$i++)
				{
					if($i>1)$wsql.=" or ";

					if($marr[$i]=="goodsmaking")
					{
						$wsql.=" (a.od_goods='G') ";
						//$wsql.=" (a.od_matype = 'decoction' and a.od_goods='G') ";
					}
					else
					{
						$wsql.=" a.od_matype = '".$marr[$i]."' ";
					}
				}
				$wsql.=" ) ";
			}
		}

		//검색 
		if($searchtxt)
		{
			//$carr=array("reName","meName","odCode","odTitle");
			//$tarr=array("주문자","한의원","주문코드","처방명");
			$wsql.=" and ( ";
			$wsql.=" e.re_name like '%".$searchtxt."%' ";//주문자 
			$wsql.=" or ";
			$wsql.=" m.mi_name like '%".$searchtxt."%' ";//한의원
			$wsql.=" or ";
			$wsql.=" a.od_code like '%".$searchtxt."%' ";//주문코드
			$wsql.=" or ";
			$wsql.=" b.ma_barcode like '%".$searchtxt."%' ";//MKD바코드 
			$wsql.=" or ";
			$wsql.=" a.od_title like '%".$searchtxt."%' ";//처방명 
			$wsql.=" or ";
			$wsql.=" oc.orderCode = '".($searchtxt - 10000)."' ";//처방전pk 
			$wsql.=" ) ";

			$search.="&searchType=".$searchtxt;
		}


		$jsql=" a left join ".$dbH."_medical m on a.od_userid=m.mi_userid ";
		$jsql.=" inner join ".$dbH."_making b on a.od_keycode=b.ma_keycode ";
		$jsql.=" left join ".$dbH."_staff s1 on b.ma_staffid=s1.st_staffid and s1.st_staffid!=''  ";
		$jsql.=" inner join ".$dbH."_decoction c on a.od_keycode=c.dc_keycode ";
		$jsql.=" left join ".$dbH."_staff s2 on c.dc_staffid=s2.st_staffid and s2.st_staffid!='' ";
		$jsql.=" inner join ".$dbH."_marking d on a.od_keycode=d.mr_keycode ";
		$jsql.=" left join ".$dbH."_staff s3 on d.mr_staffid=s3.st_staffid and s3.st_staffid!='' ";
		$jsql.=" inner join ".$dbH."_release e on a.od_keycode=e.re_keycode ";
		$jsql.=" left join ".$dbH."_staff s4 on e.re_staffid=s4.st_staffid and s4.st_staffid!='' ";
		$jsql.=" left join ".$dbH."_recipeuser r on a.od_scription=r.rc_code ";
		$jsql.=" left join ".$dbH."_code g on g.cd_type='cancelType' and a.od_canceltype=g.cd_code ";
		$jsql.=" left join ".$dbH."_code t on t.cd_type='maType' and a.od_matype=t.cd_code ";
		$jsql.=" left join ".$dbH."_member h on a.od_staff=h.me_userid ";
		$jsql.=" left join ".$dbH."_order_client oc on a.od_keycode=oc.keycode ";
		//$jsql.=" left join ".$dbH."_pill p on a.od_keycode=p.PL_KEYCODE ";

	
		$ssql=" a.od_seq, a.od_code, a.od_keycode, a.od_userid, a.od_staff, a.od_title, a.od_chubcnt, a.od_packcnt";
		$ssql.=", a.od_request as odRequest ";
		$ssql.=", a.od_advice as odAdvice ";

		
		$ssql.=", to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') as odDate  ";

		$ssql.=", a.od_oldodcode, a.od_sitecategory, a.od_scription, a.od_status, a.od_matype, a.od_goods  ";
		$ssql.=", e.re_name ";
		$ssql.=", to_char(e.re_delidate, 'yyyy-mm-dd hh24:mi:ss') as reDelidate  ";
		$ssql.=", r.rc_medicine as rcMedicine ";
		$ssql.=", s1.st_staffid mastaffid, s1.st_name mastaff ";
		$ssql.=", s2.st_staffid dcstaffid, s2.st_name dcstaff ";
		$ssql.=", s3.st_staffid mrstaffid, s3.st_name mrstaff ";
		$ssql.=", s4.st_staffid restaffid, s4.st_name restaff ";
		$ssql.=", m.mi_seq, m.mi_name, m.mi_userid, m.mi_delivery ";
		$ssql.=", g.cd_name_".$language." as cancelTypeName ";
		$ssql.=", t.cd_name_".$language." as maTypeName ";
		$ssql.=", h.me_name doctorName ";
		$ssql.=", oc.orderCode cyodcode, oc.orderCount ,oc.productCode   ";
		$ssql.=", oc.totalMedicine as octotalMedicine ";

		$pg=apipaging("a.od_seq","order",$jsql,$wsql);
		$sql=" select * from ( ";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.od_seq desc) NUM ";
		$sql.=", $ssql from ".$dbH."_order $jsql $wsql ";
		$sql.=" order by a.od_seq desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];
		
		$res=dbqry($sql);

		$json["sql"]=$sql;
		$json["wsql"]=$wsql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["search"]=$search;
		$json["list"]=array();

		//------------------------------------------------------------
		// DOO :: Code 테이블 목록 보여주기 위한 쿼리 추가 
		//------------------------------------------------------------
		$hCodeList = getNewCodeTitle("odStatus");
		//------------------------------------------------------------
	
	
		while($dt=dbarr($res))
		{
			//------------------------------------------------------------
			// DOO :: 주문상태 보여주기 위한 쿼리 추가 , 세명대에는 조제만 해서 od_status 대신에 ma_status로 해야 주문리스트에 상태값을 제대로 보여줄수있다.
			//------------------------------------------------------------
			$odStatus=$dt["OD_STATUS"];
			$odStatus = getodStatus($hCodeList, $odStatus, 'true');
			//------------------------------------------------------------

			$mi_name = (!$dt["MI_NAME"]) ? $dt["OD_USERID"] : $dt["MI_NAME"];
			$re_name = (!$dt["RE_NAME"]) ? "-" : $dt["RE_NAME"];
			if($dt["OD_GOODS"]=="G")
			{
				$gGoods=" 사전";
				$re_name="부산대공용";
			}
			else
			{
				$gGoods="";
			}
			if($gGoods) {$gGoods="<span style='padding:2px 5px;border-radius:2px;background:#FF0000;color:#fff;'>".$gGoods."</span>";}
			
			$cancelTypeName = (!$dt["CANCELTYPENAME"]) ? "" : $dt["CANCELTYPENAME"];

			$mi_delivery=$dt["MI_DELIVERY"];
			if($mi_delivery=="LOGEN" || $mi_delivery=="logen")
			{
				$msql=" select deliconfirm from ".$dbH."_delicode where odcode='".$dt["OD_CODE"]."' ";
			}
			else if($mi_delivery=="POST" || $mi_delivery=="post")
			{
				$msql=" select deliconfirm from ".$dbH."_delicode_post where odcode='".$dt["OD_CODE"]."' ";
			}
			else
			{
				$msql=" select deliconfirm from ".$dbH."_delicode where odcode='".$dt["OD_CODE"]."' ";
			}
			$mdt=dbone($msql);
			$deliconfirm=$mdt["DELICONFIRM"];
	
			$od_rcmedicine=getClob($dt["RCMEDICINE"]);
			$cyarr = explode("|", getClob($dt["OCTOTALMEDICINE"]));
			$djarr = explode("|", $od_rcmedicine);

			//cy 주문갯수 (상비처방)
			$orderCount=($dt["ORDERCOUNT"])?$dt["ORDERCOUNT"]:"1";

			if($dt["OD_GOODS"]=="M"){$gGoodsM="첩";}else{$gGoodsM="";}
			if($gGoodsM) {$gGoodsM="<span style='display:inline-block;width:17px;height:17px;font-size:11px;border-radius:50%;background:#FF0000;color:#fff;text-align:center;line-height:17px;'>첩</span>";}

			$od_chartpk="";
			if($dt["OD_SITECATEGORY"]=="MEDICAL")
			{
				$od_chartpk="<span style='padding:2px 5px;border-radius:2px;background:#549E08;color:#fff;'>EHD</span>";
			}
			else if($dt["OD_SITECATEGORY"]=="PNUH")
			{
				//$od_chartpk="<span style='padding:2px 5px;border-radius:2px;background:#6699FF;color:#fff;'>EMR ".$dt["CYODCODE"]."</span>";
				$od_chartpk="<span style='padding:2px 5px;border-radius:2px;background:#6699FF;color:#fff;'>EMR</span>";
			}

			if($dt["OD_MATYPE"]=="commercial")//상비
			{
				$od_title = $od_chartpk." ".$gGoodsM." ".$dt["OD_TITLE"];//." - ".$orderCount."개"." (".(count($djarr)-1)." / ".(count($cyarr)-1).")";
			}
			else
			{
				$od_title = $od_chartpk." ".$gGoodsM." ".$dt["OD_TITLE"];//." (".(count($djarr)-1)." / ".(count($cyarr)-1).")";
			}



			//미등록 약재가 있다면 
			if(strpos($od_rcmedicine, "*") !== false)
			{
				$noMediBox="1";
			}
			else
			{
				$noMediBox="";
			}

			$addarray=array(
				"seq"=>$dt["OD_SEQ"], 
				"odCode"=>$dt["OD_CODE"], 
				"odKeycode"=>$dt["OD_KEYCODE"],
				"odUserid"=>$dt["OD_USERID"], 
				"odTitle"=>$od_title,
				"odRequest"=>getClob($dt["ODREQUEST"]),
				"odAdvice"=>getClob($dt["ODADVICE"]),		
				"odChubcnt"=>$dt["OD_CHUBCNT"], 
				"odPackcnt"=>$dt["OD_PACKCNT"], 
				"odScription"=>$dt["OD_SCRIPTION"],
				"odStaff"=>$dt["OD_STAFF"], 
				"odStatus"=>$dt["OD_STATUS"], 
				"odGoods"=>$dt["OD_GOODS"],
				"odStatusName"=>$odStatus, //디비상태 text
				"odDate"=>date("y-m-d H:i:s",strtotime($dt["ODDATE"])), //주문날짜 년월일
				"odOldodcode"=>$dt["OD_OLDODCODE"],//이전주문코드
				"cancelTypeName"=>$cancelTypeName,//취소타입 
				"odSitecategory"=>$dt["OD_SITECATEGORY"],//사이트별타입 

				"od_doctorname"=>$dt["OD_DOCTORNAME"],//okchart 한의사 이름 

				"gGoods"=>"",//$gGoods, //사전
				"odChartPK"=>"",//$od_chartpk, 
				"deliconfirm"=>$deliconfirm,

				"doctorName"=>($dt["DOCTORNAME"])?$dt["DOCTORNAME"]:"-",//처방자 
				"miName"=>$mi_name, 
				"miSeq"=>$dt["MI_SEQ"], 
				"miUserid"=>$dt["MI_USERID"], 
	
				"maType"=>$dt["OD_MATYPE"],
				"maTypeName"=>$dt["MATYPENAME"],
				"maStaffid"=>$dt["MASTAFFID"], 
				"maStaff"=>$dt["MASTAFF"], 				

				"dcStaff"=>$dt["DCSTAFF"], 
				"dcStaffid"=>$dt["DCSTAFFID"], 

				"reStaffid"=>$dt["RESTAFFID"], 
				"reName"=>$re_name, 
				"reStaff"=>$dt["RESTAFF"], 
				"reDelidate"=>viewdate($dt["REDELIDATE"]),//배송요청일


				"mrStaff"=>$dt["MRSTAFF"], 
				"mrStaffid"=>$dt["MRSTAFFID"], 
				"rc_medicine"=>$od_rcmedicine,
				
				"hCodeList"=>$hCodeList,
				"noMediBox"=>$noMediBox
				
			);
			array_push($json["list"], $addarray);
		}

		$json["NetLive"]=$NetLive;
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

	//=========================================================================
	//  함수 명     : getodStatus()
	//  함수 설명   : 주문상태값 넘기기 
	//  페러미터    : $list -> getCodeTitle 함수에서 쿼리해온 리스트 데이터 
	//				  $status -> 주문상태 값
	//=========================================================================
	function getodStatus($list, $status, $color='false')
	{
		$chkstat=explode("_",$status);
		$substat=$chkstat[0];
		$substat2=$chkstat[1];
		$substat3=($chkstat[2]) ? $chkstat[2] : ""; //세명대 수동조제

		for($i=0;$i<count($list["odStatus"]);$i++)
		{
			if($list["odStatus"][$i]["cdCode"] == $substat)
			{
				$statName = $list["odStatus"][$i]["cdName"];
			}
			if($list["odStatus"][$i]["cdCode"] == $substat2)
			{
				if($substat2 == 'stop')
				{
					$statName2="<span style='color:purple;'>".$list["odStatus"][$i]["cdName"]."</span>";
				}
				else if($substat2 == 'cancel')
				{
					$statName2="<span style='color:red;'>".$list["odStatus"][$i]["cdName"]."</span>";
				}
				else
				{
					$statName2 = $list["odStatus"][$i]["cdName"];
				}
			}
			if($list["odStatus"][$i]["cdCode"] == $substat3) 
			{
				//***************************************************************************************
				//20190403 상시,수동 폰트 색상 바꾸기 
				//***************************************************************************************
				//$statName3 = $list["odStatus"][$i]["cdName"];  
				if($substat3 == 'always')//상시 
				{
					$statName3="<span style='color:#018271;'>".$list["odStatus"][$i]["cdName"]."</span>";
				}
				else //수동	
				{
					$statName3="<span style='color:#806250;'>".$list["odStatus"][$i]["cdName"]."</span>";
				}
				//***************************************************************************************
			}
		}

		return $statName3." ".$statName." ".$statName2;

	}
?>