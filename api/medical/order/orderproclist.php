<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	if($apiCode!="orderproclist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="orderproclist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		///include_once $root.$folder."/hanpure/hanpureUpdate.php";

		$search=$_GET["searchTxt"]; ///검색단어

		$wsql=" where a.od_use in ('Y','C') and a.od_status not in ('charted', 'charted_temp') and e.od_status not in ('charted', 'charted_temp') "; 
		///han_order 테이블에 있는 상태가 처방완료가 아닌것 뽑아오자 
		if($search)  ///검색단어 (주문자,처방명,주문코드)
		{
			$wsql.=" and ( ";
			$wsql.=" a.od_rename like '%".$search."%' ";///주문자
			$wsql.=" or ";
			$wsql.=" a.od_title like '%".$search."%' ";///처방명
			$wsql.=" or ";
			$wsql.=" a.od_code like '%".$search."%' ";///주문코드
			$wsql.=" )";
		}

		$jsql=" a left join ".$dbH."_code b on b.cd_type='maType' and b.cd_code=a.od_matype ";
		$jsql.=" left join ".$dbH."_member c on c.me_userid=a.od_staff ";
		$jsql.=" left join ".$dbH."_code d on d.cd_type='reDelitype' and d.cd_code=a.od_delitype ";
		$jsql.=" inner join ".$dbH."_order e on e.od_keycode=a.od_keycode ";

		$ssql=" a.od_seq, a.od_code, a.od_matype, a.od_staff, a.od_title, a.od_chubcnt, a.od_packcnt ";
		$ssql.=" , a.od_status, a.od_delitype, a.od_rename, a.od_amount ";	
		$ssql.=" , to_char(a.od_date,'yyyy-mm-dd') as ODDATE ";
		$ssql.=" , to_char(a.od_delidate,'yyyy-mm-dd') as OD_DELIDATE ";
		$ssql.=" , b.cd_name_kor as MATYPENAME ";
		$ssql.=" , c.me_name ";
		$ssql.=" , d.cd_name_kor as REDELITYPENAME ";

		$pg=apipaging("a.od_seq","order_medical",$jsql,$wsql);

/*
		$sql=" select $ssql from ".$dbH."_order_medical $jsql $wsql ";
		$sql.=" order by od_seq desc ";
		$sql.=" limit ".$pg["snum"].", ".$pg["psize"]; 
*/
		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (order by a.od_seq) NUM ";
		$sql.=" ,$ssql";			
		$sql.=" from ".$dbH."_order_medical $jsql $wsql  ";
		$sql.=" order by a.od_seq desc  ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];   

		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();


		///------------------------------------------------------------
		/// DOO :: OrderStatus 
		///------------------------------------------------------------
		$hCodeList = getNewCodeTitle("odStatus");
		$odStatusList = getCodeList($hCodeList, 'odStatus');///주문상태 
		$json["odStatusList"] = $odStatusList;

		while($dt=dbarr($res))
		{	
			$chkstat=explode("_",$dt["OD_STATUS"]); 
			$substat1=$chkstat[0];
			$substat2=($chkstat[1]) ? $chkstat[1] : "";
			$substat3=($chkstat[2]) ? $chkstat[2] : "";

			$statName1=getodStatus($odStatusList, $substat1);
			if($substat2)
			{
				$statName2=" ".getodStatus($odStatusList, $substat2);
			}
			if($substat3)
			{
				$statName3=getodStatus($odStatusList, $substat3)." ";
			}

			$odStatusName=$statName3.$statName1.$statName2;

			$addarray=array(
				"odSeq"=>$dt["OD_SEQ"], 
				"odDate"=>$dt["ODDATE"],
				"odCode"=>$dt["OD_CODE"],
				"odMatype"=>$dt["OD_MATYPE"],
				"odStaff"=>$dt["OD_STAFF"],
				"odTitle"=>$dt["OD_TITLE"],
				"odChubcnt"=>$dt["OD_CHUBCNT"],
				"odPackcnt"=>$dt["OD_PACKCNT"],
				"odStatus"=>$dt["OD_STATUS"],
				"odDelitype"=>$dt["OD_DELITYPE"],
				"odDelidate"=>$dt["OD_DELIDATE"],
				"odAmount"=>$dt["OD_AMOUNT"],///주문금액 
				"odRename"=>$dt["OD_RENAME"],///받는사람 
				"maTypeName"=>$dt["MATYPENAME"],///조제타입
				"me_name"=>$dt["ME_NAME"],///처방의
				"odStatusName"=>$odStatusName,///주문상태이름 
				"reDelitypeName"=>$dt["REDELITYPENAME"]///배송방법 
			);
			array_push($json["list"], $addarray);
		}



		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";


	}
	function getodStatus($list, $data)
	{
		$key=array_search($data, array_column($list, 'cdCode'));
		return $list[$key]["cdName"];
	}

?>