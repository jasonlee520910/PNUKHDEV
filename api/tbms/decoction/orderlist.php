<?php  //decoction  orderlist

	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$wktype=$_GET["wktype"];
	$page=$_GET["page"];
	$depart=$_GET["depart"];
	$process=$_GET["process"];
	$period=$_GET["period"];
	$staffid=$_GET["staffid"];
	if($apiCode!="orderlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="orderlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$jsql=" a inner join ".$dbH."_medical m on a.od_userid=m.mi_userid ";
		$jsql.=" inner join ".$dbH."_decoction c on a.od_code=c.dc_odcode ";
		$jsql.=" left join ".$dbH."_staff s2 on c.dc_staffid=s2.st_staffid and s2.st_staffid!='' ";
		$jsql.=" inner join ".$dbH."_release e on a.od_code=e.re_odcode ";
		$jsql.=" left join ".$dbH."_staff s4 on e.re_staffid=s4.st_staffid and s4.st_staffid!='' ";

		if($wktype=="process")
		{
			$wsql="  where a.od_use in ('Y','C') ";
		}
		else
		{
			$wsql="  where a.od_use in ('Y','C') ";
		}
		$wsql.=" and (c.dc_staffid='' or c.dc_staffid is null or c.dc_staffid='".$staffid."'  ";
		//탕전중 모두 보이기
		$wsql.=" or a.od_status = 'decoction_processing') ";

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
		if(strpos("_".$process,",done")=="")
		{
			$wsql.=" and a.od_status <> 'done' ";
		}
		//취소된 작업은 선택시에만
		if(strpos("_".$process,",cancel")=="")
		{
			$wsql.=" and a.od_status not like '%cancel' ";
		}

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

		$osql=" group by a.od_seq, to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss'), a.od_code, a.od_title, a.od_use, a.od_status,a.od_name, a.od_seq, a.od_userid, m.mi_name, e.re_name ";
		$osql.=" order by decode(a.od_status,'order','paid','decoction_processing',1,'decoction_start',2,'decoction_apply',3,'decoction_stop',4,'decoction_cancel',5), to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') desc  ";

		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		$sql=" select * from ( ";
		$sql.=" select ROW_NUMBER() OVER (order by decode(a.od_status,'order','paid','decoction_processing','decoction_start','decoction_apply','decoction_stop','decoction_cancel', 'done'), to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') desc) NUM , to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') as odDate, a.od_code, a.od_title, a.od_use, a.od_status,a.od_name, a.od_seq, a.od_userid, m.mi_name, e.re_name  ";
		$sql.=" from ".$dbH."_order $jsql $wsql $osql $lsql";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];
		$res=dbqry($sql);

		$json["sql"]=$sql;

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
				"odDate"=>$dt["ODDATE"],  //작업지시일
				"odCode"=>$dt["OD_CODE"], //주문코드
				"company"=>$dt["MI_NAME"], //한의원
				"reName"=>$dt["RE_NAME"],  //주문자
				"odTitle"=>$dt["OD_TITLE"],  //처방명					
				"odStatusName"=>$odStatus //주문상태																
			);
			array_push($json["list"], $addarray);
		}

		//보일러 hold이면서 intime이 있을때 지금시간이  intime +10 한것보다 크면  standby 로 바꾸기 

		$bsql=" select bo_code,to_char(bo_intime, 'yyyy-mm-dd hh24:mi:ss') as boIntime,bo_status  from ".$dbH."_boiler where bo_use='Y' and bo_status='hold' order by bo_code asc ";
		$bres=dbqry($bsql);
		
		while($bdt=dbarr($bres))
		{
			if($bdt["BO_STATUS"]=="hold")
			{
				$today = date("Y-m-d H:i:s");
				$bo_code=$bdt["BO_CODE"];
				$bo_intime=$bdt["BOINTIME"];
				$bo_tentime=date("Y-m-d H:i:s",strtotime ("+10 minutes", strtotime($bo_intime)));
				$r = strtotime($today) - strtotime($bo_tentime);
				if($r > 0)
				{
					$usql=" update ".$dbH."_boiler set bo_status='standby' where bo_code='".$bo_code."'; ";
					dbcommit($usql);
				}
			}
		}
		
		$psql=" select pa_code,to_char(pa_intime, 'yyyy-mm-dd hh24:mi:ss') as PAINTIME,pa_status  from ".$dbH."_packing a where a.pa_use='Y' and a.pa_status='hold' order by pa_code asc ";
		$pres=dbqry($psql);
		
		while($pdt=dbarr($pres))
		{
			if($pdt["PA_STATUS"]=="hold")
			{
				$today = date("Y-m-d H:i:s");
				$pa_code=$pdt["PA_CODE"];
				$pa_intime=$pdt["PAINTIME"];
				$bo_tentime=date("Y-m-d H:i:s",strtotime ("+10 minutes", strtotime($pa_intime)));
				$r = strtotime($today) - strtotime($bo_tentime);
				if($r > 0)
				{
					$usql=" update ".$dbH."_packing set pa_status='standby' where pa_code='".$pa_code."'; ";
					dbcommit($usql);
				}
			}
		}
		
	
		//$json["sql"] = $sql;
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>