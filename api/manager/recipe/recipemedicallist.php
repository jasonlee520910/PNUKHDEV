<?php   ///약속처방, 실속, 상비 

	//GET
	$apicode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	if($apicode!="recipemedicallist"){$json["resultMessage"]="API(apiCode) ERROR_uniquesclist";$apicode="recipemedicallist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$returnData=$_GET["returnData"];
		$json=array("apiCode"=>$apicode,"search"=>$search,"returnData"=>$returnData);
		$searchpop=urldecode($_GET["searchPop"]);

		$reData=$_GET["reData"];

		$jsql.="a left join ".$dbH."_member m on a.rc_userid=m.me_userid ";
		$jsql.="left join ".$dbH."_medical c on m.me_company=c.mi_userid ";
		$jsql.="left join ".$dbH."_packingbox p1 on a.rc_packtype=p1.pb_code and p1.pb_type='odPacktype' ";
		$jsql.="left join ".$dbH."_packingbox p2 on a.rc_medibox = p2.pb_code and p2.pb_type='reBoxmedi' ";
		
		$type=$reData;
		if($reData!="commercial" && $reData!="worthy")
		{
			$type="goods";
		}

		$wsql=" where a.rc_use in ('F','Y') and  a.rc_medical='".$type."' ";  //약속 goods

		if($searchpop)  //layer-medicine에서 검색했을때
		{
			$arr=explode("|",$searchpop);
			foreach($arr as $val)
			{
				if($val)
				{
					$arr2=explode(",",$val);
					$json["arr2[0]"]=$arr2[0];
					$json["arr2[1]"]=$arr2[1];
					if($arr2[0]=="searpoptxt")
					{
						$seardata=$arr2[1];
					}
				}
			}
			$json["seardata"]=$seardata;
			if($seardata)
			{
				$wsql.=" and a.rc_title_kor like '%".$seardata."%' ";
			}
		}

		$pg=apipaging("a.rc_code","recipemedical",$jsql,$wsql);
		$sql=" select * from ( ";
		$sql.=" select ROW_NUMBER() OVER (ORDER BY a.rc_date desc) NUM,   ";
		$sql.="  a.rc_seq rcSeq, a.rc_code rcCode, a.rc_source rcSource, a.rc_title_kor rcTitle ";
		$sql.=", a.rc_medicine as RCMEDICINE ";
		$sql.=", a.rc_sweet as RCSWEET ";
		$sql.=", a.rc_chub rcChub, a.rc_packcnt rcPackCnt, a.rc_packcapa rcPackCapa, a.rc_status rcStatus, a.rc_date rcDate, p1.pb_title packType, p2.pb_title mediBox ";
		$sql.=" from ".$dbH."_recipemedical $jsql $wsql order by a.rc_date desc ";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];


		$res=dbqry($sql);
		$json["searchtxt"]=$searchtxt;
		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["list"]=array();

		while($dt=dbarr($res))
		{
			//------------------------------------------------------------
			// 20191015 : 약재와 별전 이름만 가져오기 
			//------------------------------------------------------------
			$rcMedicine = substr(getClob($dt["RCMEDICINE"]), 1); //한자리만 자르기 //HD10030_03,1.0,inmain,20|HD10244_07,2,inmain,167.2
			$rcMedicine = str_replace(" ", "", $rcMedicine);//빈공간있으면 일단은 삭제
			$rcMedicineName = getMedicine($rcMedicine, 'list');
			$rcSweet = substr(getClob($dt["RCSWEET"]), 1); //한자리만 자르기 //HD10030_03,1.0,inmain,20|HD10244_07,2,inmain,167.2
			$rcSweet = str_replace(" ", "", $rcSweet);//빈공간있으면 일단은 삭제
			$rcSweetName = getMedicine($rcSweet, 'list');
			//------------------------------------------------------------

			if($rcSweetName=="-")
			{
				$rcMedicineTxt=$rcMedicineName;
			}
			else
			{
				$rcMedicineTxt=$rcMedicineName.",".$rcSweetName;
			}
			
			
			
			$arr=explode("|",$rcMedicine);//약재갯수(약미)
			$mediCnt=count($arr);

			$rcSource=($dt["RCSOURCE"]) ? $dt["RCSOURCE"]:"";
			

			$addarray = array(
				"seq"=>$dt["RCSEQ"], 
				"rcCode"=>$dt["RCCODE"], 
				"rcTitle"=>$dt["RCTITLE"],
				"rcSource"=>$rcSource,//cypk	
				"rcMedicineTxt"=>$rcMedicineTxt, //약재만 뽑아서 이름만 추출 
				"rcMedicineCnt"=>$mediCnt,  //약미
				"rcStatus"=>$dt["RCSTATUS"] //승인
				);
			array_push($json["list"], $addarray);
		}
		$json["sql"]=$sql;
		$json["reData"]=$reData;

		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

?>