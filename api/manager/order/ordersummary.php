<?php
	///GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$odCode=$_GET["odCode"];
	$mDepart=$_GET["mDepart"];
	$dDepart=$_GET["dDepart"];
	
	if($apicode!="ordersummary"){$json["resultMessage"]="API(apiCode) ERROR";$apicode="ordersummary";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($odCode==""){$json["resultMessage"]="API(od_code) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];

		$sweetList=getSweet("");///별전 
		$hCodeList = getNewCodeTitle("mrDesc");
		$mrDescList = getCodeList($hCodeList, 'mrDesc');///마킹정보리스트 


		///20190809 새로 구성 
		$sql=" select ";
		$sql.=" a.od_seq, a.od_code, a.od_keycode, a.od_title, a.od_userid, a.od_matype, a.od_packtype, a.od_packcapa, a.od_packcnt, a.od_packprice ";
		$sql.=" , a.od_chubcnt, a.od_status, a.od_sitecategory, a.od_goods, a.od_name, a.od_subjecttype ";
		$sql.=", a.od_request as odRequest ";
		$sql.=", a.od_advice as odAdvice ";
		$sql.=", a.od_amountdjmedi as odAmountdjmedi ";
		$sql.=", to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') as odDate  ";
		$sql.=", b.mi_name, b.mi_grade, b.mi_delivery ";
		$sql.=", c.rc_code, c.rc_source ";

		$sql.=", c.rc_medicine as rcMedicine ";
		$sql.=", c.rc_sweet as rcSweet ";

		$sql.=", d.re_boxmedi, d.re_boxdeli, d.re_boxmedibox, d.re_box, d.re_price, d.re_boxmediprice, d.re_boxdeliprice, d.re_zipcode, d.re_zipseq, d.re_address, d.re_addresschk ";
		$sql.=" , d.re_sendzipcode, d.re_sendaddress, d.re_name , d.re_sendname, d.re_deliexception, d.re_delicomp, d.re_delicompchk, d.re_boxmedivol, d.re_boxmedipack, d.RE_PACKINGPRICE ";
		$sql.=", e.dc_sugar, e.dc_water, e.DC_ALCOHOL, e.dc_time, e.dc_price, e.DC_SPECIAL, e.DC_SPECIALPRICE ";
		$sql.=", f.ma_price, f.ma_staffid, f.MA_TABLE, f.MA_FIRSTPRICE,  f.MA_AFTERPRICE  ";
		$sql.=", h.mr_desc ";
		$sql.=", s.CD_DESC_KOR as dcSpecialName ";
		$sql.=", g.cd_desc_kor as dcShapeDesc";
		$sql.=", oc.orderCode cyodcode, oc.productCode, oc.receiveName cyRecieveName, oc.orderCount  ";
		$sql.=" from ".$dbH."_order ";
		$sql.=" a inner join ".$dbH."_medical b on b.mi_userid=a.od_userid ";
		$sql.=" inner join ".$dbH."_recipeuser c on c.rc_code=a.od_scription ";
		$sql.=" inner join ".$dbH."_release d on d.re_keycode=a.od_keycode ";
		$sql.=" inner join ".$dbH."_decoction e on e.dc_keycode=a.od_keycode ";
		$sql.=" inner join ".$dbH."_making f on f.ma_keycode=a.od_keycode ";
		$sql.=" inner join ".$dbH."_marking h on h.mr_keycode=a.od_keycode ";
		$sql.=" left join ".$dbH."_code g on g.cd_code=e.dc_shape and g.cd_type='dcShape' ";
		$sql.=" left join ".$dbH."_code s on s.cd_code=e.DC_SPECIAL and s.cd_type='dcSpecial' ";
		$sql.=" left join ".$dbH."_order_client oc on a.od_keycode=oc.keycode ";

		$sql.=" where a.od_code='".$odCode."' ";

		$dt=dbone($sql);
		$rezipchk=$resendzipchk=0;
		$onesql=$sql;

		$re_boxmedivol=$dt["RE_BOXMEDIVOL"];
		$re_boxmedipack=$dt["RE_BOXMEDIPACK"];
		$od_chubcnt=$dt["OD_CHUBCNT"];
		$od_packcnt=$dt["OD_PACKCNT"];
		$od_goods=$dt["OD_GOODS"];
		$od_packtype=$dt["OD_PACKTYPE"];
		$od_packcapa=$dt["OD_PACKCAPA"];
		$re_boxmedi=$dt["RE_BOXMEDI"];
		$od_keycode=$dt["OD_KEYCODE"];

		//포장비 
		$re_packingprice=$dt["RE_PACKINGPRICE"];

		$dcSpecialName=getClob($dt["DCSPECIALNAME"]);

		$addPackType=$addBoxMedi="";


		///***************************************************************************************
		///약속처방, 실속, 상비 
		$productCode=$dt["PRODUCTCODE"];
		$orderCount=$dt["ORDERCOUNT"];
		$od_matype=$dt["OD_MATYPE"];
		$od_title=$dt["OD_TITLE"];
		$od_rcCode=$dt["RC_CODE"];
		$rc_source=$dt["RC_SOURCE"];
		$re_delicomp=$dt["RE_DELICOMP"];
		$re_delicompchk=$dt["RE_DELICOMPCHK"];
		$od_userid=$dt["OD_USERID"];
		$od_date=$dt["ODDATE"];
		$mi_delivery=($dt["MI_DELIVERY"])?$dt["MI_DELIVERY"]:"post";
		$gp_type="";


		
		//$productCode="323";//[자보치료용] 보중익기탕
		//$productCode="223";//(상용처방) 파세아 (25첩 45팩 120cc)
		//$productCode="523";//[약속] 자보특화 작약감초탕
		//$productCode="51";//경옥고스틱1박스 
		//$productCode="227";//(상용처방) 총명차
		
		
		
		if($od_matype=="goods" && $productCode)///약속처방일 경우 
		{	
			if($rc_source)
			{
				$gd_code=$rc_source;
				$gp_type="marking";

				$psql=" select ";
				$psql.="  rc_packtype, rc_medibox ";
				$psql.=" from ".$dbH."_recipemedical ";
				$psql.=" where rc_medical='goods' and rc_code='".$rc_source."' and rc_use='Y' ";
				$pdt=dbone($psql);

				///약속탕전 파우치,한약박스..
				$addPackType=$pdt["RC_PACKTYPE"];
				$addBoxMedi=$pdt["RC_MEDIBOX"];
			}
			else
			{
				///약속처방 있는지 체크 
				$gsql=" select gd_code, gd_name_kor as gdName, gd_bomcode from ".$dbH."_goods where gd_cypk like '%,".$productCode.",%' and gd_use='Y' ";
				$gdt=dbone($gsql);

				if($gdt["GD_CODE"])
				{
					$gd_code=$gdt["GD_CODE"];
					$gp_type="goods";
					$gd_bomcode=$gdt["GD_BOMCODE"];
					
					if(chkGoodsTie($productCode, $od_matype, $od_goods)==true)///code가 427이거나 ($type=="goods" && $goods=="P") 일 경우에는 gd_bomcode에서 가져와서 팩수 저장 
					{
						///,MA191210175501|45,MA200224125619|45
						$goodbom=explode(",",$gd_bomcode);
						$gd_packcnt=0;
						$gdCodeName="";
						$i=0;
						foreach($goodbom as $key=>$gdata)
						{
							if($gdata)
							{
								$bomchild=explode("|",$gdata);
								$gd_packcnt+=intval($bomchild[1]);
								if($i>0)
								{
									$gdCodeName.=",";
								}
								$gdCodeName.="'".$bomchild[0]."'";
								$i++;
							}
						}

						///우체국때문에 팩용량이 필요함.. [기획] 옥병풍산 + 곽향정기산 각45팩 (0 / 0) 두개의 처방중에 제일 큰 팩용량으로 데이터 넣기..
						///20200305 : 팀장님이 안계셔서 실장님에게 물어봄 이런경우 어떻게 처리해야 되나.. 
						///팩량  가져오기 
						$gpsql=" select  b.rc_packcapa
									from han_goods a 
								inner join han_recipemedical b on b.rc_code=a.gd_recipe and b.rc_use='Y'
								where a.gd_code in (".$gdCodeName.") and a.gd_use='Y' ";
						$gpres=dbqry($gpsql);
						$rcPackcapa=0;
						while($gpdt=dbarr($gpres))
						{
							if(intval($rcPackcapa) <= intval($gpdt["RC_PACKCAPA"]))
							{
								$rcPackcapa=$gpdt["RC_PACKCAPA"];
							}
						}
						$od_packcapa=$rcPackcapa;
						


						if(intval($gd_packcnt)>0)
						{
							$od_packcnt=intval($gd_packcnt)*intval($orderCount);
							$od_packtype="PCB200117151735";
							$re_boxmedi="RBM200117151838";
							$sql=" update ".$dbH."_order set od_packcnt='".$gd_packcnt."', od_goods='P', od_packcapa='".$od_packcapa."', od_packtype='".$od_packtype."' where od_code='".$odCode."' ";
							dbcommit($sql);

							$sql=" update ".$dbH."_release set re_boxmedi='".$re_boxmedi."' where re_odcode='".$odCode."' ";
							dbcommit($sql);
						}
					}
				}
				else
				{
					///약속처방 탕전이 있는지 체크 
					$psql=" select ";
					$psql.=" rc_source,  rc_medicine,  rc_packtype, rc_medibox ";
					$psql.=" from ".$dbH."_recipemedical ";
					$psql.=" where rc_medical='goods' and rc_use='Y' and rc_source like '%,".$productCode.",%' ";
					$pdt=dbone($psql);
					
					
					if(getClob($pdt["RC_MEDICINE"]))///약속처방 탕전이 있다면 
					{
						$gd_code=$gdt["RC_SOURCE"];
						$gp_type="decoction";
						///약속탕전 파우치,한약박스..
						$addPackType=$gdt["RC_PACKTYPE"];
						$addBoxMedi=$gdt["RC_MEDIBOX"];
					}
				}
			}
		}
		else if($od_matype=="commercial")///상비일 경우 
		{
			$csql=" select rc_code,rc_packtype,rc_medibox from ".$dbH."_recipemedical where rc_medical='commercial' and rc_use='Y' and rc_source like '%,".$productCode.",%' ";
			$cres=dbqry($csql);
			$totalcnt=dbrows($csql);
			$gp_type="";
			$gd_code="";
			$tmp_csql.=$csql;
			$tmp_csql.="|".$totalcnt."|";
			if(intval($totalcnt)==1)
			{
				while($cdt=dbarr($cres))
				{
					if($cdt["RC_CODE"])
					{
						$gd_code=$cdt["RC_CODE"];
						///상비 파우치,한약박스..
						$addPackType=$cdt["RC_PACKTYPE"];
						$addBoxMedi=$cdt["RC_MEDIBOX"];
						$od_packtype=$cdt["RC_PACKTYPE"];
						$re_boxmedi=$cdt["RC_MEDIBOX"];

						$usql="update ".$dbH."_recipeuser set rc_source='".$gd_code."' where rc_code='".$od_rcCode."'";
						dbcommit($usql);
						$tmp_csql.=$usql;
					}
				}

				$rsql="select rc_source from ".$dbH."_recipeuser where rc_code='".$od_rcCode."' ";
				$rdt=dbone($rsql);
				$tmp_csql.=$rsql;
				if($rdt["RC_SOURCE"])
				{
					$gd_code=$rdt["RC_SOURCE"];
					$gp_type="commercial";

					///한번더 검색하자 
					$qsql="select rc_code,rc_packtype,rc_medibox  from ".$dbH."_recipemedical where rc_code='".$rdt["RC_SOURCE"]."' and rc_use='Y' ";
					$qdt=dbone($qsql);
					$gd_code=$qdt["RC_SOURCE"];
					///실속 파우치,한약박스..
					$addPackType=$qdt["RC_PACKTYPE"];
					$addBoxMedi=$qdt["RC_MEDIBOX"];
					$od_packtype=$qdt["RC_PACKTYPE"];
					$re_boxmedi=$qdt["RC_MEDIBOX"];
				}
			}
			else
			{
				$rsql="select rc_source from ".$dbH."_recipeuser where rc_code='".$od_rcCode."' ";
				$rdt=dbone($rsql);
				$tmp_csql.=$rsql;
				if($rdt["RC_SOURCE"])
				{
					$gd_code=$rdt["RC_SOURCE"];
					$gp_type="commercial";

					///한번더 검색하자 
					$qsql="select rc_code,rc_packtype,rc_medibox  from ".$dbH."_recipemedical where rc_code='".$rdt["RC_SOURCE"]."' and rc_use='Y'";
					$qdt=dbone($qsql);
					$tmp_csql.=$qsql;
					$gd_code=$qdt["RC_SOURCE"];
					///실속 파우치,한약박스..
					$addPackType=$qdt["RC_PACKTYPE"];
					$addBoxMedi=$qdt["RC_MEDIBOX"];
					$od_packtype=$qdt["RC_PACKTYPE"];
					$re_boxmedi=$qdt["RC_MEDIBOX"];
				}
				else
				{
					$gp_type="";
				}
			}
		}
		else if($od_matype=="worthy")///실속일 경우 
		{
			$wsql=" select rc_code,rc_packtype,rc_medibox from ".$dbH."_recipemedical where rc_medical='worthy' and rc_use='Y' and rc_source like '%,".$productCode.",%' ";
			$wres=dbqry($wsql);
			$totalcnt=dbrows($wsql);
			$gp_type="";
			$gd_code="";
			$tmp_csql.=$wsql;
			$tmp_csql.="|".$totalcnt."|";
			if(intval($totalcnt)==1)
			{
				while($wdt=dbarr($wres))
				{
					if($wdt["RC_CODE"])
					{
						$gd_code=$wdt["RC_CODE"];
						///실속 파우치,한약박스..
						$addPackType=$wdt["RC_PACKTYPE"];
						$addBoxMedi=$wdt["RC_MEDIBOX"];
						$od_packtype=$wdt["RC_PACKTYPE"];
						$re_boxmedi=$wdt["RC_MEDIBOX"];

						$usql="update ".$dbH."_recipeuser set rc_source='".$gd_code."' where rc_code='".$od_rcCode."' ";
						dbcommit($usql);
						$tmp_csql.=$usql;
					}
				}

				$rsql="select rc_source from ".$dbH."_recipeuser where rc_code='".$od_rcCode."' ";
				$rdt=dbone($rsql);
				$tmp_csql.=$rsql;
				if($rdt["RC_SOURCE"])
				{
					$gp_type="worthy";

					///한번더 검색하자 
					$qsql="select rc_code,rc_packtype,rc_medibox  from ".$dbH."_recipemedical where rc_medical='worthy' and rc_use='Y' and rc_code='".$rdt["RC_SOURCE"]."'";
					$qdt=dbone($qsql);
					$gd_code=$qdt["RC_CODE"];
					///실속 파우치,한약박스..
					$addPackType=$qdt["RC_PACKTYPE"];
					$addBoxMedi=$qdt["RC_MEDIBOX"];
					$od_packtype=$qdt["RC_PACKTYPE"];
					$re_boxmedi=$qdt["RC_MEDIBOX"];

					///파우치업데이트
					$usql="update ".$dbH."_order set od_packtype='".$od_packtype."' where od_keycode='".$od_keycode."'";
					dbcommit($usql);
					$tmp_csql.=$usql;
					///한약박스 
					$usql="update ".$dbH."_release set re_boxmedi='".$re_boxmedi."' where re_keycode='".$od_keycode."'";
					dbcommit($usql);

					$tmp_csql.=$usql;
				}
			}
			else
			{
				$rsql="select rc_source from ".$dbH."_recipeuser where rc_code='".$od_rcCode."' ";
				$rdt=dbone($rsql);
				$tmp_csql.=$rsql;
				if($rdt["RC_SOURCE"])
				{
					$gd_code=$rdt["RC_SOURCE"];
					$gp_type="worthy";

					///한번더 검색하자 
					$qsql="select rc_code,rc_packtype,rc_medibox  from ".$dbH."_recipemedical where rc_code='".$rdt["RC_SOURCE"]."' and rc_use='Y' ";
					$qdt=dbone($qsql);
					$tmp_csql.=$qsql;
					$gd_code=$qdt["RC_SOURCE"];
					///실속 파우치,한약박스..
					$addPackType=$qdt["RC_PACKTYPE"];
					$addBoxMedi=$qdt["RC_MEDIBOX"];
					$od_packtype=$qdt["RC_PACKTYPE"];
					$re_boxmedi=$qdt["RC_MEDIBOX"];
				}
				else
				{
					$gp_typ="";
				}
			}	
		}
		else
		{
			if($od_goods=="Y"&&$rc_source)///재고이면서 rc_source가 있을 경우 
			{
				///탕제재고 파우치,한약박스..
				$addPackType=$wdt["RC_PACKTYPE"];
				$addBoxMedi=$wdt["RC_MEDIBOX"];
			}
		}
		///***************************************************************************************
		///부산대는 POST(우체국)으로 고정
		///***************************************************************************************
		/*
		$dootest=array();
		///------------------------------------------------------
		/// 20200116:배송회사 관련 수정 최종적으로 여기서 처리후 모든것은 release /  re_delicomp에서 가져다가 쓰임 
		///------------------------------------------------------
		$miDelivery=$mi_delivery;
		if($od_matype=="goods" && $productCode && $gp_type=="goods") ///약속처방일때만 LOGEN
		{
			$miDelivery="LOGEN";///20200103:일단은로젠으로 하기로 함 이실장님한테 연락받음 
			if($re_delicomp)
			{
				$re_delicomp=$miDelivery;
			}
			else///데이터가 없을 경우에는 먼저 업데이트 
			{
				$sql=" update ".$dbH."_release set re_delicomp='".strtolower($miDelivery)."' where re_odcode='".$odCode."' ";
				$dootest["DOO_배송회사수정"].=$sql;
				dbcommit($sql);
				$re_delicomp=$miDelivery;
			}
		}
		else
		{
			$dootest["re_delicomp"]=strtoupper($re_delicomp);
			$dootest["mi_delivery"]=strtoupper($mi_delivery);
			$dootest["한의원"]=$od_userid;
			$dootest["한의원od_date"]=$od_date;
			if($od_userid=="4394266112")///하늘체 제주점인경우
			{
				$yoil=date("w",strtotime($od_date));
				$timenow = date("H:i:s",strtotime($od_date)); 
				$timetarget = date("H:i:s", strtotime("13:00:00") );
				$timeendtarget = date("H:i:s", strtotime("11:00:00") );

				$dootest["한의원timenow"]=$timenow;
				$dootest["한의원yoil"]=$yoil;
				$dootest["한의원timetarget"]=$timetarget;
				$dootest["한의원timeendtarget"]=$timeendtarget;
				if($yoil=="5" || $yoil=="6")///금요일이면 
				{
					///금요일 13:00:00~ 토요일 11:00:00  하늘체 제주점 - 원래 우체국인데 로젠으로 바꾸기 
					if ( ($yoil=="5" && $timenow > $timetarget) || ($yoil=="6" && $timenow < $timeendtarget)) 
					{
						$miDelivery="LOGEN";
						$dootest["한의원로젠으로"]="LOGEN";
					}
					else
					{
						$miDelivery=($mi_delivery) ? $mi_delivery : "POST";
					}
				}
				else
				{
					$miDelivery=($mi_delivery) ? $mi_delivery : "POST";
				}
			}
			else
			{
				$miDelivery=($mi_delivery) ? $mi_delivery : "POST";
			}
		}

		if($re_delicompchk=="N")
		{
			if(strtoupper($re_delicomp)!=strtoupper($miDelivery))
			{
				$sql=" update ".$dbH."_release set re_delicomp='".$miDelivery."' where re_odcode='".$odCode."' ";
				$dootest["DOO_배송회사수정"].=$sql;
				dbcommit($sql);
				$re_delicomp=$miDelivery;
			}
		}
		*/
		///------------------------------------------------------

		if($dt["od_goods"]=="G") ///사전조제는 우체국, 로젠으로 안타게..
		{

		}
		else
		{
			////20200402 
			////부산대는 우체국으로 고정을 함.. 그래서 아래와 같이 수정함 
			if(!$re_delicomp)
			{
				$sql=" update ".$dbH."_release set re_delicomp='post' where re_odcode='".$odCode."' ";
				dbcommit($sql);
				$re_delicomp="post";
			}
			$miDelivery=$re_delicomp;

			/*
			if($re_delicomp=="POST" || $re_delicomp=="post")
			{
				include_once $root.$folder."/order/ordersummary.post.php";
			}
			else if($re_delicomp=="LOGEN" || $re_delicomp=="logen")
			{
				include_once $root.$folder."/order/ordersummary.logen.php";
			}
			else ///if($miDelivery=="CJ" || $miDelivery=="cj")
			{
				include_once $root.$folder."/order/ordersummary.post.php";
			}
			*/
			include_once $root.$folder."/order/ordersummary.post.php";


			///20191202 : 송장출력 로젠
			/*$dsql=" select delicode, deliconfirm, usedate, confirmdate, canceldate  from han_delicode where odcode='".$odCode."' and deliconfirm <> 'C' and inuse <> 'D' ";
			$ddt=dbone($dsql);
			$chkdelicode="";
			if($ddt["delicode"])///송장번호가 있다면..
			{
				$chkdelicode=$ddt["delicode"];
				$chkdeliconfirm=$ddt["deliconfirm"];
				$chkusedate=$ddt["usedate"];
				$chkconfirmdate=$ddt["confirmdate"];
				$chkcanceldate=$ddt["canceldate"];
			}
			else*/
			///{
				///20191202 : 송장출력 우체국 
				

				$dsql=" select delicode, deliconfirm, to_char(usedate, 'yyyy-mm-dd hh24:mi:ss') as usedate,to_char(confirmdate, 'yyyy-mm-dd hh24:mi:ss') as confirmdate,to_char(canceldate, 'yyyy-mm-dd hh24:mi:ss') as canceldate from han_delicode_post where odcode='".$odCode."' and deliconfirm <> 'C' and inuse <> 'D' ";
				$ddt=dbone($dsql);
				$chkdelicode="";
				if($ddt["delicode"])///송장번호가 있다면..
				{
					$chkdelicode=$ddt["DELICODE"];
					$chkdeliconfirm=$ddt["DELICONFIRM"];
					$chkusedate=$ddt["USEDATE"];
					$chkconfirmdate=$ddt["CONFIRMDATE"];
					$chkcanceldate=$ddt["CANCELDATE"];
				}
			///}

			$re_deliexception=$dt["RE_DELIEXCEPTION"];
			if(strpos($re_deliexception, "O") !== false || strpos($re_deliexception, "T") !== false || strpos($re_deliexception, "D") !== false)
			{
				$rezipchk=1;
				$readdresschk=1;
			}
		}

		$add= explode("||",$dt["RE_ADDRESS"]);
		$sendadd= explode("||",$dt["RE_SENDADDRESS"]);

		$od_chartpk="";
		if($dt["OD_GOODS"]=="G"){$gGoods="사전";}else{$gGoods="";}
		if($gGoods) {$gGoods="<span style='padding:2px 5px;border-radius:2px;background:#FF0000;color:#fff;'>".$gGoods."</span>";}

		if($dt["OKRECIEVENAME"]){$recieveName=$dt["OKRECIEVENAME"];}else{$recieveName="";}
		if($dt["CYRECIEVENAME"]){$recieveName=$dt["CYRECIEVENAME"];}else{$recieveName="";}
		if(!$recieveName){$recieveName=$dt["RE_NAME"];}

		///택배회사 이름
		$re_delicompName=getDeliveryCompName($re_deliexception, $re_delicomp);

		$od_rcmedicine=getClob($dt["RCMEDICINE"]);
		$od_rcsweet=getClob($dt["RCSWEET"]);

		$json=array(
			"odSeq"=>$dt["OD_SEQ"],
			"odCode"=>$dt["OD_CODE"],
			"odKeycode"=>$od_keycode,
			"odTitle"=>$dt["OD_TITLE"], 
			"odDate"=>$dt["ODDATE"], 	
			"odRequest"=>getClob($dt["ODREQUEST"]),
			"odPacktype"=>$od_packtype,
			"odPackcapa"=>$od_packcapa,
			"odStatus"=>$dt["OD_STATUS"],
			"odChubcnt"=>$od_chubcnt,
			"odPackcnt"=>$od_packcnt,
			"odMatype"=>$dt["OD_MATYPE"],	
			"odName"=>$dt["OD_NAME"],
			"odAmountdjmedi"=>getClob($dt["ODAMOUNTDJMEDI"]),
			"odPackprice"=>$dt["OD_PACKPRICE"],
			"odSitecategory"=>$dt["OD_SITECATEGORY"],
			"odSubjecttype"=>$dt["OD_SUBJECTTYPE"],			
			"odGoods"=>$od_goods,
			"maStaffid"=>$dt["MA_STAFFID"],
			"maTable"=>$dt["MA_TABLE"],
			"miDelivery"=>$miDelivery,

			"chkdelicode"=>$chkdelicode,///송장출력에 관한것 
			"chkdeliconfirm"=>$chkdeliconfirm,///송장출력에 관한것 
			"chkusedate"=>$chkusedate,///송장출력에 관한것 
			"chkconfirmdate"=>$chkconfirmdate,///송장출력에 관한것 
			"chkcanceldate"=>$chkcanceldate,///송장출력에 관한것 

			///"dootest"=>$dootest,
			"gd_chubcnt"=>$gd_chubcnt,


			"reDelicomp"=>$re_delicomp,
			"reDelicompName"=>$re_delicompName,

			"odAdvice"=>getClob($dt["ODADVICE"]),  ///복약지도서		
		
			"mrDescList"=>$mrDescList,///마킹리스트 
			"mrDesc"=>$dt["MR_DESC"],

			///"로젠logen"=>$logen,
			"gGoods"=>$gGoods, ///사전
			"odChartPK"=>"",///$od_chartpk, 
			///"chartpk"=>$chartpk,
			"recieveName"=>$recieveName,
			"tmp_csql"=>$tmp_csql,

			"productCode"=>$productCode,///PK
			"gp_type"=>$gp_type,///약속처방 타입
			"gd_code"=>$gd_code,///약속처방코드 
			"orderCount"=>$orderCount,

			"reName"=>$dt["RE_NAME"],  ///받는사람 
			"reZipcode"=>$rezip,  ///받는사람 우편번호
			"reZipchk"=>$rezipchk,  ///받는사람 우편번호chk
			"reAddress"=>$add[0]."||".$add[1],  ///받는사람주소
			"reAaddresschk"=>$readdresschk,  ///받는사람주소 확인

			"reSendname"=>$dt["RE_SENDNAME"],  ///보내는사람 
			"reSendzipcode"=>$resendzip,  ///보내는사람 우편번호
			"reSendzipchk"=>$resendzipchk,  ///보내는사람 우편번호
			"reSendaddress"=>$sendadd[0]."||".$sendadd[1],  ///보내는사람주소 
			"reDeliexception"=>$re_deliexception,
			"rePackingprice"=>$re_packingprice,

			"miName"=>$dt["MI_NAME"],
			"miGrade"=>$dt["MI_GRADE"],

			"rcCode"=>$dt["RC_CODE"],
			"rcMedicine"=>$od_rcmedicine, 
			"rcSweet"=>$od_rcsweet, 

			"reBoxmedi"=>$re_boxmedi, 
			"reBoxdeli"=>$dt["RE_BOXDELI"],
			"reBoxmedibox"=>$dt["RE_BOXMEDIBOX"],
			"reBox"=>$dt["RE_BOX"],
			"rePrice"=>$dt["RE_PRICE"],
			"reBoxmediprice"=>$dt["RE_BOXMEDIPRICE"],
			"reBoxdeliprice"=>$dt["RE_BOXDELIPRICE"],
			
			"maPrice"=>$dt["MA_PRICE"],
			"maFirstprice"=>$dt["MA_FIRSTPRICE"],
			"maAfterprice"=>$dt["MA_AFTERPRICE"],


			"dcShapeDesc"=>$dt["DCSHAPEDESC"],

			"dcPrice"=>$dt["DC_PRICE"],
			"dcTime"=>$dt["DC_TIME"],
			"dcWater"=>$dt["DC_WATER"],
			"dcAlcohol"=>$dt["DC_ALCOHOL"],
			"dcSpecial"=>$dt["DC_SPECIAL"],
			"dcSpecialName"=>$dcSpecialName,
			"dcSpecialprice"=>$dt["DC_SPECIALPRICE"],
			"dcSugar"=>$dt["DC_SUGAR"]
		);
		


		///파우치, 한약박스, 배송박스 
		$od_userid=$dt["OD_USERID"];
		$od_matype=$dt["OD_MATYPE"];
		///------------------------------------------------------------
		/// DOO :: PackCode 테이블 목록 보여주기 위한 쿼리 추가 
		///------------------------------------------------------------
		$hPackCodeList = getPackCodeTitle($od_userid, "odPacktype,reBoxdeli,reBoxmedi");
		$reBoxmediList = getCodeList($hPackCodeList, 'reBoxmedi');///한약박스
		$reBoxdeliList = getCodeList($hPackCodeList, 'reBoxdeli');///배송포장재종류 
		$poutchList = getCodeList($hPackCodeList, 'odPacktype');///파우치

		///탕제재고, 상비재고, 실속재고, 약속재고
		$json["추가파우치"]=$addPackType;
		$json["추가한약박스"]=$addBoxMedi;
		if($addPackType && $addBoxMedi)
		{
			$zsql=" select ";
			$zsql.=" pb_code, pb_type, pb_title, pb_codeonly, pb_priceA, pb_priceB,pb_priceC, pb_priceD,pb_priceE, pb_capa, pb_volume, pb_maxcnt, pb_member, pb_staff ";
			$zsql.=" , to_char(pb_desc) as pbdesc ";
			$zsql.=" ,(select MIN(af_url) KEEP (DENSE_RANK FIRST ORDER BY af_no DESC) from ".$dbH."_file where pb_code=af_fcode and af_code='packingbox' and af_use='Y') as af_url ";
			$zsql.=" from ".$dbH."_packingbox ";
			$zsql.=" where pb_use ='Y' and  pb_code in ('".$addPackType."','".$addBoxMedi."') ";
			$zsql.=" group by pb_code, pb_type, pb_title, pb_codeonly, pb_priceA, pb_priceB,pb_priceC, pb_priceD,pb_priceE, pb_capa, pb_volume, pb_maxcnt, pb_member, pb_staff, to_char(pb_desc)   ";
			$zsql.=" order by pb_code desc ";

			$zres=dbqry($zsql);
			
			while($zdt=dbarr($zres))
			{				
				$afFile=getafFile($zdt["AF_URL"]);
				$afThumbUrl=getafThumbUrl($zdt["AF_URL"]);

				$capa=($zdt["PB_TYPE"]=="reBoxmedi") ? $zdt["PB_MAXCNT"]:$zdt["PB_CAPA"];

				$addarray = array(
					"pbCode"=>$zdt["PB_CODE"], 
					"pbType"=>$zdt["PB_TYPE"], 
					"pbTitle"=>$zdt["PB_TITLE"], 
					"pbCodeOnly"=>$zdt["PB_CODEONLY"],
					"pbPriceA"=>$zdt["PB_PRICEA"], 
					"pbPriceB"=>$zdt["PB_PRICEB"],
					"pbPriceC"=>$zdt["PB_PRICEC"],
					"pbPriceD"=>$zdt["PB_PRICED"],
					"pbPriceE"=>$zdt["PB_PRICEE"],
					"pbVolume"=>$zdt["PB_VOLUME"],
					"pbMaxcnt"=>$zdt["PB_MAXCNT"],
					"pbCapa"=>$capa, 
					"pbMember"=>$zdt["PB_MEMBER"], 
					"pbStaff"=>$zdt["PB_STAFF"], 
					"pbDesc"=>$zdt["PB_DESC"], 
					"afFilel"=>$afFile,
					"afThumbUrl"=>$afThumbUrl
				);
				if($zdt["PB_TYPE"]=="odPacktype")///파우치
				{
					array_push($poutchList, $addarray);
				}
				else if($zdt["PB_TYPE"]=="reBoxmedi")///한약박스 
				{
					array_push($reBoxmediList, $addarray);
				}
			}
		}


		$json["poutchList"]=$poutchList;///파우치
		$json["reBoxmediList"]=$reBoxmediList;///한약박스 
		$json["reBoxdeliList"]=$reBoxdeliList;///포장박스 
		

		///감미제 
		///$json["dcSugarList"]=$dcSugarList;
		///별전
		$json["sweetList"]=$sweetList;

		$totmedi=count(explode("|", $od_rcmedicine))-1;
		$totsweet=count(explode("|", $od_rcsweet))-1;
		$json["totMedicine"]=$totmedi;
		$json["totSweet"]=$totsweet;
		$sweettotal=0;
		if($od_rcsweet)
		{
			$arr=explode("|",$od_rcsweet);
			for($i=1;$i<count($arr);$i++)
			{
				$arr2=explode(",",$arr[$i]);
				$sweettotal+=$arr2[1];
			}
		}

		$json["sweettotal"]=$sweettotal;///총 약재량 

		if($od_rcmedicine)
		{
			$arr=explode("|",$od_rcmedicine);
			$medicode="";$medicapa=0;
			for($i=1;$i<count($arr);$i++)
			{
				$arr2=explode(",",$arr[$i]);
				if($i>1)$medicode.=",";
				$medicode.="'".$arr2[0]."'";
				$medicapa+=$arr2[1];
				if($arr2[2]=="infirst")$infirst="Y";
				if($arr2[2]=="inmain")$inmain="Y";
				if($arr2[2]=="inafter")$inafter="Y";
			}
			if($medicode)
			{
				$sql=" select  ";
				$sql.=" md_code, md_title_".$language." as mdTitle, md_poison, md_dismatch, md_water, md_origin_".$language." as mdOrigin  ";
				$sql.=" from ".$dbH."_medicine where md_code in (".$medicode.")   ";
				$sql.=" order by decode(md_code,".$medicode.") ";

				$res=dbqry($sql);
				$medi=array();
				while($dt2=dbarr($res))
				{
					$addarray=array($dt2["MD_CODE"]=>$dt2["MDTITLE"]);
					$mdtitle[$dt2["MD_CODE"]]=$dt2["MDTITLE"];
					$mdpoison[$dt2["MD_CODE"]]=$dt2["MD_POISON"];
					$mddismatch[$dt2["MD_CODE"]]=$dt2["MD_DISMATCH"];
					$mdWater[$dt2["MD_CODE"]]=$dt2["MD_WATER"];
					$mdorigin[$dt2["MD_CODE"]]=$dt2["MDORIGIN"];
				}
			}
			$dismatchcnt=$poisoncnt=$mediamt=$meditotal=$mdwater=$watertotal=0;
			$json["medicine"]=array();
			for($i=1;$i<count($arr);$i++)
			{
				if($arr[$i]!="")
				{
					$arr2=explode(",",$arr[$i]);
					if($mddismatch[$arr2[0]]=="Y")$dismatchcnt++;
					if($mdpoison[$arr2[0]]=="Y")$poisoncnt++;
					if($mdtitle[$arr2[0]]){$rcMedititle=$mdtitle[$arr2[0]];}else{$rcMedititle="-";}
					if($mdorigin[$arr2[0]]){$rcOrigin=$mdorigin[$arr2[0]];}else{$rcOrigin="-";}
					if($arr2[1]){$rcCapa=$arr2[1];}else{$rcCapa=0;}
					$twater=($mdWater[$arr2[0]]) ? $mdWater[$arr2[0]] : 0;


					$mediamt=floatval($od_chubcnt)*floatval($arr2[1]);///첩수*약재g = 총약재 
					$meditotal+=$mediamt;///총토탈 약재량 
					$mdwater = (floatval($mediamt) * floatval($twater))/100; /// (총약재*흡수율) 나누기 100
					$watertotal+=$mdwater;///총물량 토탈

					$medicine=array(
						"rcMedicode"=>$arr2[0], 
						"rcMedititle"=>$rcMedititle, 
						"rcCapa"=>$rcCapa, 
						"rcDecoctype"=>$arr2[2], 
						"rcOrigin"=>$rcOrigin, 
						"rcPoison"=>$mdpoison[$arr2[0]], 
						"rcDismatch"=>$mddismatch[$arr2[0]]
						);
					array_push($json["medicine"], $medicine);
				}
			}
			$json["meditotal"]=$meditotal;///총 약재량 
			$json["watertotal"]=$watertotal;///총 약재량 
			


			///----------------------------------------------------------------------
			///약재부족 체크
			///|6166,4,inmain,0|1025,5,inmain,0|1306,3,inmain,0|1173,3,inmain,0|1017,4,inmain,0|1022,3,inmain,0
			///----------------------------------------------------------------------
			$shortage="";
			$mediboxshortage="";
			if($medicode)
			{
				$mediarr=explode("|",$od_rcmedicine);
				///20191217 : 기타출고와 제환실을 제외한 테이블 조회 
				///----------------------------------------------------------------------
				$sql=" select   ";
				$sql.=" a.md_code,a.md_qty,c.mm_code, c.mm_title_kor as mmTitle  ";
				$sql.=" , (select LISTAGG(mb_table, ',') WITHIN GROUP (ORDER BY mb_table asc) from ".$dbH."_medibox where mb_medicine = a.md_code and mb_use <> 'D' and mb_table not in ('99999','44444') ) as MBTABLE ";
				$sql.=" , (select sum(mb_capacity)  from ".$dbH."_medibox where mb_medicine = a.md_code and mb_use <> 'D' and mb_table not in ('99999','44444') ) as MBCAPACITY  ";
				$sql.=" from ".$dbH."_medicine a  ";
				$sql.=" inner join ".$dbH."_medicine_djmedi c on c.md_code = a.md_code  and c.mm_use <> 'D' ";
				$sql.=" where a.md_code in (".$medicode.") ";
				$sql.=" group by a.md_code,a.md_qty,c.mm_code, c.mm_title_kor  ";
				$sql.=" order by decode(a.md_code, ".$medicode.") ";

				$res=dbqry($sql);
				$json["shortagesql"]=$sql;
				$totalCnt=dbrows($sql);
				$json["shortagetotalCnt"]=intval($totalCnt);
				if(intval($totalCnt) > 0)
				{
					while($dt=dbarr($res))
					{	
						for($i=1;$i<count($mediarr);$i++)
						{
							$arr2=explode(",",$mediarr[$i]);
							
							if($arr2[0] == $dt["MD_CODE"])
							{
								if($dt["MBTABLE"]=="00000,00080" || $dt["MBTABLE"]=="00001,00002,00003,00080")
								{
									$total=$dt["MBCAPACITY"] + $dt["MD_QTY"];
									$medi=$arr2[1] * $odChubCnt;

									if($total < $medi)
									{
										$shortage.="|".$dt["MD_CODE"];
									}
								}
								else ///약재함이 없다면 
								{	
									$mediboxshortage.=",".$dt["MMTITLE"];
								}
							}
						}
					}
				}
				else
				{
					$sarr=explode(",",$medicode);
					$mediboxshortage="";
					for($i=0;$i<count($sarr);$i++)
					{
						$mediname=str_replace("*","",$sarr[$i]);
						$mediname=str_replace("'","",$mediname);
						$mediboxshortage.=",".$mediname;
					}
					
				}
			}
			$json["shortage"]=$shortage;
			$json["mediboxshortage"]=$mediboxshortage;
			///----------------------------------------------------------------------

			if(strpos($od_rcmedicine, "*") !== false) ///포함되어있다면 
			{
				$json["nonemedi"]="true";
			}	
		}


		///----------------------------------------------------------------------
		///상극체크- 후하 전 위치
		///----------------------------------------------------------------------
		$dismatch=array();
		$dismatchtxt="";
	

		$dsql=" select a.dm_group, a.dm_medicine, listagg(b.md_title_".$language.", ',') as mdTitle ";
		$dsql.=" from ".$dbH."_medi_dismatch a  ";
		$dsql.=" join ".$dbH."_medicine b on(REGEXP_COUNT(a.dm_medicine, b.md_code) > 0) ";
		$dsql.=" where a.dm_medicine <> '' and a.dm_use='Y' ";
		$dsql.=" group by a.dm_seq,a.dm_group, a.dm_medicine ";
		$dres=dbqry($dsql);
		while($ddt=dbarr($dres)){
			$arrtxt=$ddt["MDTITLE"];
			$arr=explode(",",$ddt["DM_MEDICINE"]);
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
		$json["dsql"]=$dsql;
		$json["dismatch"]=$dismatch;
		$json["totDismatch"]=count($dismatch);
		///----------------------------------------------------------------------


		///----------------------------------------------------------------------
		///중독체크- 후하 전 위치
		///$psql=" select po_group, po_medicine, po_desc_".$language." po_desc from ".$dbH."_medi_poison where po_medicine <> '' and po_use='Y'";
		///----------------------------------------------------------------------
		$poison=array();
		$poisontxt="";

		$psql=" select a.po_medicine, b.md_hub,b.md_code, b.md_title_".$language." mdTitle ";
		$psql.=" from ".$dbH."_medi_poison a ";
		$psql.=" left join ".$dbH."_medicine b on a.po_medicine=b.md_hub and b.md_use <> 'D' ";
		$psql.=" where a.po_medicine <> '' and a.po_code <> 100 ";
		$pres=dbqry($psql);
		while($pdt=dbarr($pres)){
			if(strpos($medicode,$pdt["MD_CODE"]))
			{
				array_push($poison, $pdt["MD_CODE"]);
				$poisontxt.=",".$pdt["MDTITLE"];
			}
		}
		$json["poison"]=$poison;
		$json["totPoison"]=count($poison);
		///----------------------------------------------------------------------



		///----------------------------------------------------------------------
		///작업자 리스트 
		///----------------------------------------------------------------------
		$sql=" select st_staffid, st_userid, st_name, st_depart ";
		$sql.=" from han_staff ";
		$sql.=" where st_use <>'D' and st_depart = '".$mDepart."' ";
		$sql.="order by st_seq ";
		$res=dbqry($sql);
		$json["makinglist"]=array();
		while($dt=dbarr($res))
		{
			$addarray=array(
				"stStaffid"=>$dt["ST_STAFFID"], 
				"stUserid"=>$dt["ST_USERID"],
				"stName"=>$dt["ST_NAME"],  
				"stDepart"=>$dt["ST_DEPART"]
				);
			array_push($json["makinglist"], $addarray);
		}
		///----------------------------------------------------------------------
		$sql=" select st_staffid, st_userid, st_name, st_depart ";
		$sql.=" from han_staff ";
		$sql.=" where st_use <>'D' and st_depart = '".$dDepart."' ";
		$sql.="order by st_seq ";
		$res=dbqry($sql);
		$json["decolist"]=array();
		while($dt=dbarr($res))
		{
			$addarray=array(
				"stStaffid"=>$dt["ST_STAFFID"], 
				"stUserid"=>$dt["ST_USERID"],
				"stName"=>$dt["ST_NAME"],  
				"stDepart"=>$dt["ST_DEPART"]
				);
			array_push($json["decolist"], $addarray);
		}
		///----------------------------------------------------------------------


		///탕제일때 약속처방 탕전리스트 
		$goodsDecoList=getGoodsDecoction();
		$json["goodsDecoList"]=$goodsDecoList;

		$bm=getBoxMediinfo($od_keycode, $re_boxmedi, $re_boxmedivol, $re_boxmedipack);
		$json["bsql"]=$bm["bsql"];
		$json["pb_medichk"]=$bm["pb_medichk"];
		$json["pb_code"]=$bm["pb_code"];
		$json["pb_title"]=$bm["pb_title"];
		$json["pb_volume"]=$bm["pb_volume"];
		$json["pb_maxcnt"]=$bm["pb_maxcnt"];

		///$json["hPackCodeList"]=$hPackCodeList;

		$json["onesql"]=$onesql;
		$json["apiCode"]=$apicode;
		$json["returnData"]=$returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
<?php
function getGoodsDecoction()
{
	global $language;
	global $dbH;

	$gsql=" select a.gd_seq, a.gd_code, a.gd_recipe, a.gd_qty, a.gd_name_".$language." gdName 
			from ".$dbH."_goods a
			inner join ".$dbH."_recipemedical b on b.rc_code=a.gd_recipe and b.rc_use='Y'
			where a.gd_type='goodsdecoction' and a.gd_use <> 'D'  ";
	$gres=dbqry($gsql);
	$list = array();

	while($gdt=dbarr($gres))
	{
		$addarray=array(
			"gdSeq"=>$gdt["GD_SEQ"], 
			"gdCode"=>$gdt["GD_CODE"], 
			"gdRecipe"=>$gdt["GD_RECIPE"], 
			"gdQty"=>$gdt["GD_QTY"], 
			"gdName"=>$gdt["GDNAME"]
		);

		array_push($list, $addarray);
	}
	return $list;
}
?>