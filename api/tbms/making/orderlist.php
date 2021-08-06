<?php
	/// 조제의 주문 리스트 

	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$wktype=$_GET["wktype"];
	$page=$_GET["page"];
	$depart=$_GET["depart"];
	$process=$_GET["process"];
	$period=$_GET["period"];
	$staffid=$_GET["staffid"];
	$maTable=$_GET["maTable"];

	if($apiCode!="orderlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="orderlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		$jsql=" a inner join ".$dbH."_medical m on a.od_userid=m.mi_userid ";
		$jsql.=" inner join ".$dbH."_making b on a.od_code=b.ma_odcode ";
		if($depart=="making")$jsql.=" and (b.ma_staffid is null or b.ma_staffid = '".$staffid."')";
		$jsql.=" left join ".$dbH."_staff s1 on b.ma_staffid=s1.st_staffid and s1.st_staffid!=''  ";
		$jsql.=" inner join ".$dbH."_release e on a.od_code=e.re_odcode ";
		if($depart=="release")$jsql.=" and (e.re_staffid is null or e.re_staffid = '".$staffid."')";
		$jsql.=" left join ".$dbH."_staff s4 on e.re_staffid=s4.st_staffid and s4.st_staffid!='' ";

		if($wktype=="process")
		{
			$wsql="  where a.od_use in ('Y','C') ";
		}
		else
		{
			$wsql="  where a.od_use in ('Y','C') ";
		}
		//20190822 : matable이 있는 아이는 그 조제대에서만 보이게 하자 
		$wsql.=" and (b.ma_table = '".$maTable."' or b.ma_table is NULL) ";

		if($depart)
		{
			$wsql.=" and a.od_status like '".$depart."%' ";
		}

		if($process)
		{
			$arr=explode(",",$process);
			$prosql=" and ( ";
			for($i=1;$i<count($arr);$i++)
			{
				if($i>1)$prosql.=" or ";
				$len=strlen($arr[$i]);
				if($arr[$i]=="stop")
				{
					$prosql.=" SUBSTR(a.od_status, -4)='stop' ";
				}
				else if($arr[$i]=="cancel")
				{
					$prosql.=" SUBSTR(a.od_status, -6)='cancel' ";
				}
				else
				{
					$prosql.=" SUBSTR(a.od_status,".($len*-1).") =  '".$arr[$i]."' ";
				}
			}
			$prosql.=" ) ";
			$wsql.=$prosql;
		}
		//완료된 작업은 선택시에만
		if(strpos("_".$process,",order")=="")
		{
			$wsql.=" and a.od_status <> 'order' ";
		}
		//************************************
		//20190403 making_done_alway 추가 
		//************************************
		//완료된 작업은 선택시에만
		if(strpos("_".$process,",done")=="")
		{
			$wsql.=" and a.od_status <> 'done' and a.od_status <> 'making_done_smu' and a.od_status <> 'making_done_always'";//수동조제완료도 리스트에 보이지 않게 처리 
		}
		//20190403 %cancel% 로 변경 
		//취소된 작업은 선택시에만
		if(strpos("_".$process,",cancel")=="")
		{
			$wsql.=" and a.od_status not like '%cancel%' ";
		}
		//************************************

		if($period)
		{
			$arr=explode(",",$period);
			$periodsql=" and to_char(a.od_date, 'yyyy-mm-dd') >= '".$arr[0]."' and  to_char(a.od_date, 'yyyy-mm-dd') <= '".$arr[1]."'";
			$wsql.=$periodsql;
		}

		if($_GET["searcate"]!="all"&&$_GET["search"])
		{
			if($_GET["searcate"]=="hospital")
			{
				$wsql.=" and (m.mi_userid like '%".$_GET["search"]."%' or m.mi_name like '%".$_GET["search"]."%' or a.od_name like '%".$_GET["search"]."%')" ;
			}
			if($_GET["searcate"]=="scription")
			{
				$wsql.=" and (a.od_title like '".$_GET["search"]."')" ;
			}
		}
		else if($_GET["search"])
		{
			$wsql.=" and (a.od_title like '%".$_GET["search"]."%' or m.mi_name like '%".$_GET["search"]."%')";
		}

		$pg=apipaging("a.od_seq","order",$jsql,$wsql);

		$osql=" group by a.od_seq, to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss'), a.od_code, a.od_title, a.od_use, a.od_status,a.od_name, a.od_seq, a.od_userid, m.mi_name, e.re_name  ";
		$osql.=" order by decode(a.od_status,'making_processing',1,'making_apply',2,'making_start',3,'making_stop',4,'making_cancel',5), to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') desc  ";
		//$lsql=" limit  ".$pg["snum"].", ".$pg["psize"];

		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		$sql=" select * from ( ";
		$sql.=" select ROW_NUMBER() OVER (order by decode(a.od_status,'making_processing','order','paid','making_apply','making_start','making_stop','making_cancel'), to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') desc) NUM , to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') as odDate, a.od_code, a.od_title, a.od_use, a.od_status,a.od_name, a.od_seq, a.od_userid, m.mi_name, e.re_name ";
		$sql.=" from ".$dbH."_order $jsql $wsql $osql $lsql";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

		$json["sql"] = $sql;
		$res=dbqry($sql);
		$json["sqlsql"] = $sql;
		//------------------------------------------------------------
		// DOO :: Code 테이블 목록 보여주기 위한 쿼리 추가 
		//------------------------------------------------------------
		$hCodeList = getCodeTitle('odStatus');
		//------------------------------------------------------------

		//$json["list"]=$res;
		while($dt=dbarr($res))
		{
			//------------------------------------------------------------
			// DOO :: 주문상태 보여주기 위한 쿼리 추가 
			//------------------------------------------------------------
			$odStatus = getodStatus($hCodeList, $dt["OD_STATUS"], 'true');
			//------------------------------------------------------------
			$addarray=array(
					
					"odDate"=>$dt["ODDATE"], //작업지시일
					"odCode"=>$dt["OD_CODE"], //주문코드
					"company"=>$dt["MI_NAME"],  //한의원
					"reName"=>$dt["RE_NAME"],  //주문자
					"odTitle"=>$dt["OD_TITLE"], //처방명	
					"OD_STATUS"=>$dt["OD_STATUS"],
					"odStatusName"=>$odStatus //주문상태					
			);
			array_push($json["list"], $addarray);
		}

		$json["hCodeList"]=$hCodeList;

		if($staffid && $depart=="making")
		{
			//20190822 : matable이 있는 아이는 그 조제대에서만 보이게 하자 
			$sql=" select * from ( select 
			ROW_NUMBER() OVER (ORDER BY a.ma_modify desc, a.ma_date desc) NUM, ma_barcode, ma_odcode, ma_table, ma_tablestat , b.od_scription , b.od_chubcnt , b.od_title,  m.mi_name, e.re_name, 
			u.rc_medicine as RCMEDICINE, u.rc_sweet as RCSWEET
			from ".$dbH."_making a 
			inner join ".$dbH."_order b on a.ma_odcode=b.od_code 
			inner join ".$dbH."_medical m on b.od_userid=m.mi_userid 
			inner join ".$dbH."_release e on b.od_code=e.re_odcode 
			inner join ".$dbH."_recipeuser u on b.od_scription=u.rc_code 
			where a.ma_staffid='".$staffid."' and a.ma_table='".$maTable."'  
			and ( a.ma_status='making_processing' or b.od_status='making_processing')  and b.od_use in ('Y', 'C') 
			order by a.ma_modify desc, a.ma_date desc ) where NUM=1 ";
			$dt=dbone($sql);
			$json["promaBarcode"]=$dt["MA_BARCODE"];
			$json["promaodCode"]=$dt["MA_ODCODE"];
			$json["promatable"]=$dt["MA_TABLE"];
			$json["protitle"]=$dt["OD_TITLE"];
			$json["prominame"]=$dt["MI_NAME"];
			$json["prorename"]=$dt["RE_NAME"];
			$json["promatableStat"]=$dt["MA_TABLESTAT"];
			$json["prosql"]=$sql;

			$arr=explode("|",substr(getClob($dt["RCMEDICINE"]),1));
			$dmarr=array("infirst","inmain","inafter");
			foreach($arr as $val)
			{
				$arr1=explode(",",$val);
				if(strpos($arr1[0], "__") !== false)//포함되어있다면
				{ 
					$mdarr=explode("__",$arr1[0]);
					$newmdcode=$mdarr[0];
					$mdtitle[$newmdcode]=$mdarr[1];
				}
				else
				{
					$newmdcode=$arr1[0];
				}
				${"medi_".$arr1[2]}.=",".$newmdcode;
			}

			$json["proinfirst"]=${"medi_infirst"};
			$json["proinmain"]=${"medi_inmain"};
			$json["proinafter"]=${"medi_inafter"};
			$json["proinlast"]=(getClob($dt["RCSWEET"])) ? 1:"";
			

			//약재부족 체크 
			if($dt["MA_BARCODE"])
			{
				//약재함과 약재재고 체크 
				$medi=getmedilist_process($dt["OD_SCRIPTION"], $maTable, $dt["OD_CHUBCNT"]);
				$json["medi"]=$medi;

				if($medi["mediboxnone"]=="")
				{
					if($medi["medishortage"]=="")
					{
						$json["resultCode"]="200";
						$json["resultMessage"]="OK";
					}
					else
					{
						//창고재고와 약재함재고보다 적을시 약재상태를 약재부족이라고 바꾼다.
						if($medi["shortagecode"]!="")
						{
							$shortagecode=substr($medi["shortagecode"], 1);
							$shortagecode=str_replace(",","','",$shortagecode);
							$sql=" update ".$dbH."_medicine set md_status='shortage', md_modify=sysdate where md_code in ('".$shortagecode."') ";
							dbcommit($sql);
							//약재부족할때에는 ma_table과 ma_tablestat 은 둘다 null로 바꿔줘야 함. 
							//일단 잠시 보류 
							$sql=" update ".$dbH."_making set ma_table=null, ma_tablestat = null,  ma_modify=sysdate where ma_barcode='".$dt["MA_BARCODE"]."' ";
							//dbqry($sql);
						}
						
						$json["resultCode"]="999";
						$json["resultMessage"]="MEDISHORTAGE";//약재가 부족합니다.
					}
				}
				else
				{
					$json["resultCode"]="999";
					$json["resultMessage"]="MEDIBOXNONE";//약재함이 존재하지 않거나 사용할수 없습니다.
				}

			}
			else
			{
				$json["resultCode"]="200";
				$json["resultMessage"]="OK";
			}

		}
		else
		{
			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}
		
		$json["apiCode"] = $apiCode;

	}


?>