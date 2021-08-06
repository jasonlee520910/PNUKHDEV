<?php  //release orderlist
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
		$jsql.=" inner join ".$dbH."_release e on a.od_code=e.re_odcode ";
		$jsql.=" inner join ".$dbH."_package p on a.od_code=p.gp_odcode ";
		$jsql.=" left join ".$dbH."_staff s4 on e.re_staffid=s4.st_staffid and s4.st_staffid!='' ";
		$jsql.=" left join ".$dbH."_staff s3 on p.gp_staffid=s3.st_staffid and s3.st_staffid!='' ";
		if($wktype=="process")
		{
			$wsql="  where a.od_use in ('Y','C') ";
		}
		else
		{
			$wsql="  where a.od_use in ('Y','C') ";
		}
		$wsql.=" and (p.gp_staffid='' or p.gp_staffid is null or p.gp_staffid='".$staffid."') ";
		if($depart)
		{
			$wsql.=" and a.od_status like 'goods%' ";
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

		$osql=" group by a.od_seq, to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss'), a.od_code, a.od_title, a.od_use, a.od_status,a.od_name, a.od_seq, a.od_userid, m.mi_name, e.re_name   ";
		$osql.=" order by decode(a.od_status,'goods_processing',1,'goods_start',2,'goods_apply',3,'goods_stop',4,'goods_cancel',5), to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') desc  ";
		//$lsql=" limit  ".$pg["snum"].", ".$pg["psize"];

		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		$sql=" select * from ( ";
		$sql.=" select ROW_NUMBER() OVER (order by decode(a.od_status,'order','paid','goods_processing','goods_start','goods_apply','goods_stop','goods_cancel','done'), to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') desc) NUM, to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') as odDate, a.od_code, a.od_title, a.od_use, a.od_status,a.od_name, a.od_seq, a.od_userid, m.mi_name, e.re_name ";
		$sql.=" from ".$dbH."_order $jsql $wsql $osql $lsql";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

		$res=dbqry($sql);

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
					"odStatusName"=>$odStatus //주문상태	
			);
			array_push($json["list"], $addarray);
		}

		
		$json["sql"] = $sql;
		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";


	}
?>