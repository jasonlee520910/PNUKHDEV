<?php //조제에서 약재량 차감과 rc_medicine에 투입한 약재량 추가 
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];

	$ordercode=$_POST["ordercode"];//주문번호 
	$mediCode=$_POST["mediCode"];//스캔받은 약재코드 
	$medibarcode=$_POST["medibarcode"];//스캔받은 약재함 medibox 
	$mediCapa=$_POST["mediCapa"];//스캔받은 약재함의 투입한 약재량 
	$mbTable=$_POST["mbTable"];//조제대
	$mdCapaLast=$_POST["mdCapaLast"];//약재 체크후에 마지막일때에만 보낸다. 
	$medigroup=$_POST["medigroup"];//medigroup 20190514

	if($apiCode!="newmedicapaupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="newmedicapaupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mediCode==""){$json["resultMessage"]="API(mediCode) ERROR";}
	else if($mbTable==""){$json["resultMessage"]="API(mbTable) ERROR";}
	else
	{
		//주문번호로 rc_code를 검색하자 
		$sql=" select od_scription, OD_CHUBCNT from  ".$dbH."_order where od_code='".$ordercode."' ";
		$dt=dbone($sql);
		$od_scription=$dt["OD_SCRIPTION"];
		$od_chubcnt=$dt["OD_CHUBCNT"];

		//처방량 가져오기 위해서 
		$sql=" select RC_MEDICINE as RCMEDICINE, RC_SWEET as RCSWEET from  ".$dbH."_RECIPEUSER where RC_CODE='".$od_scription."' ";
		$dt=dbone($sql);
		$rc_medicine=getClob($dt["RCMEDICINE"]);
		$rc_sweet=getClob($dt["RCSWEET"]);

		//공통약재와 내 조제대의 약재함들을 검색하여 해당 약재함의 재고량 가져오기 
		$sql=" select  a.mb_capacity, b.mm_title_".$language." mmTitle ";
		$sql.=" from ".$dbH."_medibox ";
		$sql.=" a left join ".$dbH."_medicine_".$refer." b on b.md_code=a.mb_medicine ";
		$sql.=" where a.mb_table in ('00000','".$mbTable."') and a.mb_code = '".$medibarcode."' and a.mb_use = 'Y' ";
		$dt=dbone($sql);
		$mb_capacity=$dt["MB_CAPACITY"];//약재함의 재고량 
		$mbTitle=$dt["MMTITLE"];

		$json["apiCode"]=$apiCode;
		
		$newMediCapa=str_replace("P","", $mediCapa);

		if(strpos($mediCapa, 'P') !== false)
		{  
			$mu_pass='Y';
		} 
		else 
		{  
			$mu_pass='N';
		}  

		$json["newMediCapa"]=$newMediCapa;
		$json["mb_capacity"]=$mb_capacity;
		$json["mdCapaLast"]=$mdCapaLast;
	
		if($medigroup)
		{
			$mdgrouparr=explode("_", $medigroup);
			$json["medigroup"]=$mdgrouparr[1];
		}
		$mu_chubang=0;
		if(strpos($rc_medicine, $mediCode) !== false)
		{
			$mediArr=explode("|",$rc_medicine);
			for($i=1;$i<count($mediArr);$i++)
			{
				$medi=explode(",",$mediArr[$i]);
				$mdcode=getNewMediCode($medi[0]);
				if($mediCode==$mdcode)
				{
					$mu_chubang=$medi[1];
				}
			}
		}
		else if(strpos($rc_sweet, $mediCode) !== false)
		{
			$mediArr=explode("|",$mediCode);
			for($i=1;$i<count($mediArr);$i++)
			{
				$medi=explode(",",$mediArr[$i]);
				$mdcode=getNewMediCode($medi[0]);
				if($mediCode==$mdcode)
				{
					$mu_chubang=$medi[1];
				}
			}
		}
		
		if($medibarcode && $mediCode)
		{
			//약재차감 로그 
			$isql="insert into ".$dbH."_medicine_use (MU_SEQ, mu_recipe, mu_medibox, mu_medicine, mu_chubang, od_chubcnt, mu_qty, mu_pass, mu_date) values ((SELECT NVL(MAX(MU_SEQ),0)+1 FROM ".$dbH."_medicine_use), '".$od_scription."','".$medibarcode."','".$mediCode."','".$mu_chubang."','".$od_chubcnt."','".$newMediCapa."','".$mu_pass."', sysdate) ";
			dbcommit($isql);
			$json["isql"]=$isql;

			//약재차감 - 나중에 주석제거 
			$sql ="update ".$dbH."_medibox set mb_capacity=mb_capacity-".$newMediCapa.", mb_modify=sysdate where mb_code = '".$medibarcode."' and mb_medicine ='".$mediCode."' and mb_use ='Y' ";
			dbcommit($sql);
			$json["sql"]=$sql;
		}
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
		
	}
?>