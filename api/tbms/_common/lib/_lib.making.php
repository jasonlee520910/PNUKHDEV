<?php
	//medibox랑 join해서 seq까지 가져오자 
	function getmedilist_process($code, $maTable, $chubcnt)
	{
		global $language;
		global $dbH;
		global $refer;

		//-----------------------------------------------------------------------------------------
		// 약재와 별전을 검색하여 셋팅 
		//-----------------------------------------------------------------------------------------
		$sql=" select ";
		$sql.=" rc_medicine as RCMEDICINE, rc_sweet as RCSWEET ";
		$sql.=" from ".$dbH."_recipeuser where rc_code='".$code."'";
		$sql11=$sql;
		$dt=dbone($sql);
		$medicine=getClob($dt["RCMEDICINE"]);
		$medisweet=getClob($dt["RCSWEET"]);
		$arr=explode("|",substr($medicine,1));

		$medi_infirst=$medi_inmain=$medi_inafter=$medi_inlast="";
		$medicapa_infirst=$medicapa_inmain=$medicapa_inafter=$medicapa_inlast="";
		$medicnt_infirst=$medicnt_inmain=$medicnt_inafter=$medicnt_inlast="";
		$medicnt=$medicapa=0;

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
			${"medicapa_".$arr1[2]}.=",".$arr1[1];
			${"medicnt_".$arr1[2]}++;
			$medicapa+=$arr1[1];
			$mdcapa[$newmdcode]=round(floatval($arr1[1]) * floatval($chubcnt));
			
		}
		//-----------------------------------------------------------------------------------------

		//-----------------------------------------------------------------------------------------
		//선전,일반,후하 셋팅
		//-----------------------------------------------------------------------------------------
		$dmarr=array("infirst","inmain","inafter");
		$medilist["dmarr"]=$dmarr;//선전,일반,후하 data
		//-----------------------------------------------------------------------------------------

		//-----------------------------------------------------------------------------------------
		// 약재 
		//-----------------------------------------------------------------------------------------
		$medishortage=$shortagecode=$mediboxnone=$mediboxcode="";
		$qty=0;
		for($i=0;$i<count($dmarr);$i++)
		{
			if(${"medi_".$dmarr[$i]})
			{
				$seqarr=substr(${"medi_".$dmarr[$i]},1);
				$seqarr=str_replace(",","','",$seqarr);

				$sql=" select  a.md_code,  a.md_origin_".$language." origin, a.md_poison, a.md_dismatch, a.md_qty, ";
				$sql.=" b.mb_table, b.mb_code, b.mb_capacity ";
				$sql.=" , r.mm_title_kor mediname, r.mm_title_chn medinamechn, r.mm_code ";//세명대의 경우 한글,한자 모두 검색
				$sql.=" from ".$dbH."_medicine a   ";
				$sql.=" left join ".$dbH."_medibox b on a.md_code=b.mb_medicine and b.mb_use <> 'D'  and b.mb_table in ('00000','".$maTable."') ";
				$sql.=" inner join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code  ";
				$sql.=" where a.md_code in ('".$seqarr."') ";
				$sql.=" group by  a.md_code,  a.md_origin_kor, a.md_poison, a.md_dismatch, a.md_qty, b.mb_table, b.mb_code, b.mb_capacity  , r.mm_title_kor, r.mm_title_chn, r.mm_code ";
				$sql.=" order by b.mb_table DESC ";

				$medilist["medisql".$dmarr[$i]]=$sql;//약재

				$res=dbqry($sql);
				$list=array();
				while($dt=dbarr($res))
				{
					$origin=($dt["ORIGIN"]) ? $dt["ORIGIN"] : "";
					$md_poison=($dt["MD_POISON"]) ? $dt["MD_POISON"] : "";
					$md_dismatch=($dt["MD_DISMATCH"]) ? $dt["MD_DISMATCH"] : "";

					if($dt["MB_TABLE"] == $maTable || $dt["MB_TABLE"] == '00000') //공통이거나 같은 조제대인것만 
					{
						$mb_table=$dt["MB_TABLE"];
						$mb_code=$dt["MB_CODE"];
						$mb_capacity=$dt["MB_CAPACITY"];

						$qty=intval($mb_capacity);
						
						if($dt["MB_TABLE"] == '00000')
						{
							$qty=intval($mb_capacity)+intval($dt["MD_QTY"]);
						}
						if($qty<intval($mdcapa[$dt["MD_CODE"]]))
						{
							$medishortage.=",".$dt["MEDINAME"];
							$shortagecode.=",".$dt["MD_CODE"];
						}
					}
					else
					{
						$mb_table="";
						$mb_code="";
						$mb_capacity="";
						$mediboxnone.=",".$dt["MEDINAME"];
					}

					$mediname=($mdtitle[$dt["MD_CODE"]]) ? $mdtitle[$dt["MD_CODE"]] : $dt["MEDINAME"];

					$addarray=array(
							"md_code"=>$dt["MD_CODE"],
							"mediname"=>$mediname,//약재명한글
							"medinamechn"=>$dt["MEDINAMECHN"], //약재명한자
							"origin"=>$origin,
							"md_poison"=>$md_poison,
							"md_dismatch"=>$md_dismatch,
							"md_qty"=>$dt["MD_QTY"], //창고의 재고량 (han_medicine)
							
							"mb_table"=>$mb_table,
							"mb_code"=>$mb_code,
							"mb_capacity"=>$mb_capacity, //약재함의 재고량(han_medibox)

							"medicapa"=>$mdcapa[$dt["MD_CODE"]]
							);
					array_push($list, $addarray);
					$medicnt++;
				}
				$medilist["list"][$dmarr[$i]]=$list;//선전,일반,후하  list
				$medilist["capa"][$dmarr[$i]]=${"medicapa_".$dmarr[$i]};//선전,일반,후하 capa				
			}
		}		
		$medilist["medicine"]=$medicine;//약재데이터
		$medilist["medicapa"]=$medicapa;//약재
	
		//-----------------------------------------------------------------------------------------

		//-----------------------------------------------------------------------------------------
		// 별전 "|9980,2,inlast,1300|9986,1,inlast,18000|9987,1,inlast,0|9989,3,inlast,0"
		//-----------------------------------------------------------------------------------------
		$arr=explode("|",substr(trim($medisweet),1));
		$list=array();
		foreach($arr as $val)
		{
			$arr1=explode(",",$val);
			$medi_inlast.=",".$arr1[0];
			$medicapa_inlast.=",".$arr1[1];
			$medicnt_inlast++;
			$sweetcapa[$arr1[0]]=floatval($arr1[1]);
		}
		if($medi_inlast)
		{
			$seqarr=substr($medi_inlast,1);
			$seqarr=str_replace(",","','",$seqarr);

			$sql=" select  a.md_code, a.md_origin_".$language." origin, a.md_poison, a.md_dismatch, a.md_qty, ";
			$sql.=" b.mb_table, b.mb_medicine, b.mb_code, b.mb_capacity ";
			$sql.=" , r.mm_title_".$language." mediname, r.mm_code ";
			$sql.=" from ".$dbH."_medicine a   ";
			$sql.=" left join ".$dbH."_medibox b on a.md_code=b.mb_medicine and b.mb_use='Y'  and b.mb_table in ('00000','".$maTable."') ";
			$sql.=" inner join ".$dbH."_medicine_".$refer." r on a.md_code=r.md_code  ";
			$sql.=" where a.md_code in ('".$seqarr."') ";
			$sql.=" group by  a.md_code,  a.md_origin_kor, a.md_poison, a.md_dismatch, a.md_qty, b.mb_table, b.mb_code, b.mb_capacity  , r.mm_title_kor, r.mm_title_chn, r.mm_code ";
			$sql.=" order by b.mb_table DESC, decode(a.md_code,'".$seqarr."') ";
			$res=dbqry($sql);
		
			while($dt=dbarr($res))
			{
				$origin=($dt["ORIGIN"]) ? $dt["ORIGIN"] : "";
				$md_poison=($dt["MD_POISON"]) ? $dt["MD_POISON"] : "";
				$md_dismatch=($dt["MD_DISMATCH"]) ? $dt["MD_DISMATCH"] : "";

				if($dt["MB_TABLE"] == $maTable || $dt["MB_TABLE"] == '00000') //공통이거나 같은 조제대인것만 
				{
					$mb_table=$dt["MB_TABLE"];
					$mb_code=$dt["MB_CODE"];
					$mb_capacity=$dt["MB_CAPACITY"];

					$qty=intval($mb_capacity);
					
					if($dt["MB_TABLE"] == '00000')
					{
						$qty=intval($mb_capacity)+intval($dt["MD_QTY"]);
					}
					if($qty<intval($sweetcapa[$dt["MD_CODE"]]))
					{
						$medishortage.=",".$dt["MEDINAME"];
						$shortagecode.=",".$dt["MD_CODE"];
					}

				}
				else
				{
					$mb_table="";
					$mb_code="";
					$mb_capacity="";
					$mediboxnone.=",".$dt["MEDINAME"];
				}


				$addarray=array(
						//han_medicine
						"md_code"=>$dt["MD_CODE"],
						"mediname"=>$dt["MEDINAME"],
						"origin"=>$origin,
						"md_poison"=>$md_poison,
						"md_dismatch"=>$md_dismatch,
						"md_qty"=>$dt["MD_QTY"], //창고의 재고량 (han_medicine)
						//han_medibox - 데이터가 없으면 medicine에만 데이터가 있고, 약재함등록은 안되어잇음 
						"mb_table"=>$mb_table,
						"mb_medicine"=>$dt["MB_MEDICINE"],
						"mb_code"=>$mb_code,
						"mb_capacity"=>$mb_capacity, //약재함의 재고량(han_medibox)

						"medicapa"=>$sweetcapa[$dt["MD_CODE"]]
						);
				array_push($list, $addarray);
				$medicnt++;
			}
		}
		
		$medilist["sweetlist"]=$list;//별전리스트
		$medilist["medicnt"]=$medicnt;//총약재갯수 
		$medilist["medisweet"]=$medisweet;//별전데이터 
		//-----------------------------------------------------------------------------------------

		$medilist["mediboxnone"]=$mediboxnone;
		$medilist["medishortage"]=$medishortage;
		$medilist["shortagecode"]=$shortagecode;

		return $medilist;
	}

?>