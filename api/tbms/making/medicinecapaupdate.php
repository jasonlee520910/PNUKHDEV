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

	if($apiCode!="medicinecapaupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="medicinecapaupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($mediCode==""){$json["resultMessage"]="API(mediCode) ERROR";}
	else if($mbTable==""){$json["resultMessage"]="API(mbTable) ERROR";}
	else
	{
		

		$sql=" select o.od_scription, r.rc_medicine as RCMEDICINE , r.rc_sweet as RCSWEET ";
		$sql.=" from ".$dbH."_order o ";
		$sql.=" inner join ".$dbH."_recipeuser r on r.rc_code=o.od_scription ";
		$sql.=" where od_code = '".$ordercode."'";

		$dt=dbone($sql);
		$rc_code=$dt["OD_SCRIPTION"];
		$rc_medicine=getClob($dt["RCMEDICINE"]);
		$rc_sweet=getClob($dt["RCSWEET"]);


		$mediType="";
		//rc_medicine array
		//|1002,3.0,inmain,22|1008,3.5,inmain,22
		$mediArr=explode("|",$rc_medicine);
		$new_medicine="";
		for($i=1;$i<count($mediArr);$i++)
		{
			$medi=explode(",",$mediArr[$i]);

			if(strpos($medi[0], '__') !== false)
			{
				$marr=explode("__",$medi[0]);
				$mdcode=$marr[0];
			}
			else
			{
				$mdcode=$medi[0];
			}

			//if(count($medi)==4)//투입한 약재량이 없다면 
			//{
				if($mediCode==$mdcode) //투입한 약재코드가 있다면 투입한 약재량 추가 
				{
					if($mediCapa!=""){
						$medi[4]=$mediCapa;
					}else{
						unset($medi[4]);
					}
					$mediType="medicine";
				}
			//}
			$new_medicine.="|".implode(',', $medi);
		}
		
		//|9980,2,inlast,1300|9986,1,inlast,18000|9987,1,inlast,0|9989,3,inlast,0
		if($mediType == "")
		{
			$sweetArr=explode("|",$rc_sweet);
			$new_sweet="";
			for($i=1;$i<count($sweetArr);$i++)
			{
				$sweet=explode(",",$sweetArr[$i]);
				//if(count($sweet)==4)//투입한 약재량이 없다면 
				//{
					if($mediCode==$sweet[0]) //투입한 약재코드가 있다면 투입한 약재량 추가 
					{
						if($mediCapa!=""){
							$sweet[4]=$mediCapa;
						}else{
							unset($sweet[4]);
						}
						$mediType="sweet";
					}
				//}
				$new_sweet.="|".implode(',', $sweet);
			}
		}

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

		$json["mediCode"]=$mediCode;
		$json["mediCapa"]=$mediCapa;
		$json["newMediCapa"]=$newMediCapa;
		$json["mb_capacity"]=$mb_capacity;
		$json["mdCapaLast"]=$mdCapaLast;

		/*if($newMediCapa > $mb_capacity) 
		{
			$json["meditxt"]=$mbTitle;
			$json["resultCode"]="999";
			$json["resultMessage"]="MEDISHORTAGE";//약재가 부족합니다.
		}
		else */
		{
			$json["rc_code"]=$rc_code;
			$json["new_medicine"]=$new_medicine;
			if($new_medicine)//약재
			{
				$sql ="update ".$dbH."_recipeuser set rc_modify=sysdate, rc_medicine='".$new_medicine."' where rc_code = '".$rc_code."'";
				dbcommit($sql);
				$json["msql"]=$sql;
			}
			if($new_sweet)//별전 
			{
				$sql ="update ".$dbH."_recipeuser set rc_modify=sysdate, rc_sweet='".$new_sweet."'  where rc_code = '".$rc_code."'";
				dbcommit($sql);
				$json["ssql"]=$sql;
			}

			//medigroup 20190514 =
			if($medigroup)
			{
				$mdgrouparr=explode("_", $medigroup);
				$json["medigroup"]=$mdgrouparr[1];
			}

			$json["resultCode"]="200";
			$json["resultMessage"]="OK";
		}

		
	}
?>