<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$od_code=$_GET["odCode"];
	$st_staffid=$_GET["staffID"];
	$ma_pharmacist=$_GET["pharmacist"];
	$matype=$_GET["matype"];
	
	if($apiCode!="pharmacyupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="pharmacyupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else if($od_code==""){$json["resultMessage"]="API(odCode) ERROR";}
	else
	{
		//조제완료 
		$sql ="update ".$dbH."_making set ma_end=sysdate where ma_odcode = '".$od_code."'";
		dbcommit($sql);

		$tsql="";

		//첩수, 약재 가져오기 
		$sql=" SELECT ";
		$sql.=" a.od_code, a.od_chubcnt, a.od_gender, a.od_matype, a.od_goods ";
		$sql.=", to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') as ODDATE, to_char(a.od_birth, 'yyyy-mm-dd') as ODBIRTH";
		$sql.=", b.rc_code ";
		$sql.=", b.rc_medicine as RCMEDICINE ";
		$sql.=", b.rc_sweet as RCSWEET ";
		$sql.=", to_char(c.ma_start, 'yyyy-mm-dd hh24:mi:ss') as MASTART, to_char(c.ma_end, 'yyyy-mm-dd hh24:mi:ss') as MAEND ";
		$sql.=" , c.ma_medibox_infirst, c.ma_medibox_inmain , ma_medibox_inafter, ma_medibox_inlast ";
		$sql.=" FROM han_order a ";
		$sql.=" INNER JOIN han_recipeuser b ON b.rc_code=a.od_scription ";
		$sql.=" inner join ".$dbH."_making c on a.od_keycode=c.ma_keycode ";
		$sql.=" WHERE a.od_code='".$od_code."' ";
		$dt=dbone($sql);
		$tsql.=$sql;

		$od_goods=$dt["OD_GOODS"];//20200120 : 약재포장
		$db_odcode=$dt["OD_CODE"];
		//첩수
		$od_chubcnt=$dt["OD_CHUBCNT"];
		//recipeuser code 
		$rc_code=$dt["RC_CODE"];
		//약재 
		$rc_medicine=getClob($dt["RCMEDICINE"]);
		//별전 
		$rc_sweet=getClob($dt["RCSWEET"]);
		//조제타입  
		$od_matype=$dt["OD_MATYPE"];

		$ma_medibox_infirst=$dt["MA_MEDIBOX_INFIRST"];
		$ma_medibox_inmain=$dt["MA_MEDIBOX_INMAIN"];
		$ma_medibox_inafter=$dt["MA_MEDIBOX_INAFTER"];
		$ma_medibox_inlast=$dt["MA_MEDIBOX_INLAST"];

		$db_mkstart=($dt["MASTART"]) ? "to_date('".$dt["MASTART"]."','YYYY-MM-DD hh24:mi:ss')" : 'NULL';
		$db_mkend=($dt["MAEND"]) ? "to_date('".$dt["MAEND"]."','YYYY-MM-DD hh24:mi:ss')" : 'NULL';
		$db_oddate=$dt["ODDATE"];
		//20190823 : 생일 수정
		if($dt["ODBIRTH"])
		{
			if($dt["ODBIRTH"]=="0000-00-00")
			{
				$db_birth='NULL';
			}
			else
			{
				$db_birth= "'".str_replace("-","",$dt["ODBIRTH"])."'";
			}
		}
		else
		{
			$db_birth='NULL';
			
		}
		//20190823 : 성별 수정
		if($dt["OD_GENDER"]=="female")
		{
			$db_gender=2;
		}
		else if($dt["OD_GENDER"]=="male")
		{
			$db_gender=1;
		}
		else
		{
			$db_gender='NULL';
		}

		//|HD10141_02,2,inmain,21.2|HD10095_01,16,inmain,32.5|HD10113_08,4,inmain,16.9|HD10080_01__천궁(중국)-去油,12,inmain,16.3|HD10149_01__건강(중국)-炒黑,2,inmain,21.3
		$busql=$new_rcMedicine=$usql="";
		if($rc_medicine)
		{
			$mediarry=explode("|",$rc_medicine);
			for($i=1;$i<count($mediarry);$i++)
			{
				$arr=explode(",",$mediarry[$i]);
				$mdcode=getNewMediCode($arr[0]);//약재코드 
				$mdexcel=getNewExcelTitle($arr[0]);//엑셀에서 넘어온 약재명 
				$mdcapa=$arr[1];//첩당약재량 
				$mdtype=$arr[2];//타입
				$mdprice=$arr[3];//가격 
				$mdmaking=floatval($mdcapa)*floatval($od_chubcnt);//수동으로 조제한것이라 P를 붙여서 첩량*첩수를 곱하자 
				$mdmakingP="P".$mdmaking;

				if(strpos($mdmakingP, 'P') !== false)
				{
					if($mdmakingP == "P0")
					{
						$db_makingcapa=$mdcapa;
					}
					else
					{
						$db_makingcapa=str_replace("P","",$mdmakingP);
					}
					
					$db_pass="Y";
				}
				else
				{
					$db_makingcapa=$mdmakingP;
					$db_pass="N";
				}
	
				if($mdexcel)
				{
					$new_rcMedicine.="|".$mdcode."__".$mdexcel.",".$mdcapa.",".$mdtype.",".$mdprice.",".$mdmakingP;
				}
				else
				{
					$new_rcMedicine.="|".$mdcode.",".$mdcapa.",".$mdtype.",".$mdprice.",".$mdmakingP;
				}
				$busql=" update han_medibox set mb_capacity=mb_capacity-".$mdmaking.", mb_modify=sysdate wehre mb_table='00080' and mb_medicine='".$mdcode."' ";
				dbcommit($busql);

				$isql="INSERT INTO han_dashboard (DB_SEQ, db_odcode, DB_TABLE, db_mkstart, db_mkend, db_birth, db_gender, db_chubcnt, db_mdcode, db_mdcapa, db_makingcapa, db_pass, db_oddate, db_date) VALUES ((SELECT NVL(MAX(DB_SEQ),0)+1 FROM ".$dbH."_dashboard),'".$db_odcode."','00080',".$db_mkstart.",".$db_mkend.",".$db_birth.",".$db_gender.",'".$od_chubcnt."','".$mdcode."','".$mdmaking."','".$db_makingcapa."','".$db_pass."',to_date('".$db_oddate."','YYYY-MM-DD hh24:mi:ss'), sysdate) ";
				dbcommit($isql);
				$json["isql_".$mdcode]=$isql;
			}
		}
		//|HD10141_02,2,inmain,21.2|HD10095_01,16,inmain,32.5|HD10113_08,4,inmain,16.9|HD10080_01__천궁(중국)-去油,12,inmain,16.3|HD10149_01__건강(중국)-炒黑,2,inmain,21.3
		//|HD10141_02,2,inmain,21.2,30|HD10095_01,16,inmain,32.5,240|HD10113_08,4,inmain,16.9,60|HD10080_01__천궁(중국)-去油,12,inmain,16.3,180|HD10149_01__건강(중국)-炒黑,2,inmain,21.3,30"

		
		$json["od_chubcnt"] = $od_chubcnt;
		$json["new_rcMedicine"] = $new_rcMedicine;
		

		$new_rc_sweet="";
		if($rc_sweet)
		{
			$sweetarry=explode("|",$rc_sweet);
			for($i=1;$i<count($sweetarry);$i++)
			{
				$arr=explode(",",$sweetarry[$i]);
				$sweetcode=getNewMediCode($arr[0]);//약재코드 
				$sweetexcel=getNewExcelTitle($arr[0]);//엑셀에서 넘어온 약재명 
				$sweetcapa=$arr[1];//처방할 g 
				$sweettype=$arr[2];//타입
				$sweetprice=$arr[3];//가격 
				$sweetmaking=floatval($sweetcapa);//수동으로 조제한것이라 P를 붙여서 하자 
				$sweetmakingP="P".$sweetmaking;

				//20190822 : P0이면 db_mdcapa랑 똑같이 넣고, db_pass를 Y 로 바꾸자 
				if(strpos($sweetmakingP, 'P') !== false)
				{
					if($sweetmakingP == "P0")
					{
						$db_makingcapa=$db_mdcapa;
					}
					else
					{
						$db_makingcapa=str_replace("P","",$sweetmakingP);
					}
					
					$db_pass="Y";
				}
				else
				{
					$db_makingcapa=$sweetmakingP;
					$db_pass="N";
				}

	
				if($mdexcel)
				{
					$new_rc_sweet.="|".$sweetcode."__".$sweetexcel.",".$sweetcapa.",".$sweettype.",".$sweetprice.",".$sweetmakingP;
				}
				else
				{
					$new_rc_sweet.="|".$sweetcode.",".$sweetcapa.",".$sweettype.",".$sweetprice.",".$sweetmakingP;
				}
				$busql=" update han_medibox set mb_capacity=mb_capacity-".$sweetmaking.", mb_modify=sysdate wehre mb_table='00080' and mb_medicine='".$sweetcode."' ";
				//dbcommit($busql);

				$isql="INSERT INTO han_dashboard (DB_SEQ, db_odcode,DB_TABLE, db_mkstart, db_mkend, db_birth, db_gender, db_chubcnt, db_mdcode, db_mdcapa, db_makingcapa, db_pass, db_oddate, db_date) VALUES ((SELECT NVL(MAX(DB_SEQ),0)+1 FROM ".$dbH."_dashboard),'".$db_odcode."','00080',".$db_mkstart.",".$db_mkend.",".$db_birth.",".$db_gender.",'".$od_chubcnt."','".$sweetcode."','".$sweetmaking."','".$db_makingcapa."','".$db_pass."',to_date('".$db_oddate."','YYYY-MM-DD hh24:mi:ss'), sysdate) ";
				dbcommit($isql);
				$json["isql_".$sweetcode]=$isql;

			}
		}


		//-----------------------------------------------------------------------
		//if($usql)
		//{
			//$isql=" INSERT ALL ";
			//$isql.=$usql;
			//$isql.=" select * from dual ";
			//$isql=" INSERT INTO ".$dbH."_dashboard (DB_SEQ, db_odcode, db_mkstart, db_mkend, db_birth, db_gender, db_chubcnt, db_mdcode, db_mdcapa, db_makingcapa, db_pass, db_oddate, db_date) VALUES ";
			//$isql.=substr($usql, 1);
			//dbcommit($isql);
			//$json["isql"]=$isql;
		//}
		//-----------------------------------------------------------------------

		//-------------------------------------------------------------------------------------
		//품질보고서를 위한 약재정보 저장  (수동조제일경우 추가)
		//recipeuser update 하려면 rc_code 을 알아야함
		$sql2="select od_scription,od_chubcnt from ".$dbH."_order where od_code='".$od_code."' ";  //	 select od_scription from han_order where od_code='ODD1912040000107753'

		$dt2=dbone($sql2);
		$json["sql2"]=$sql2;
		$odScription=$dt2["OD_SCRIPTION"];  //RC2019120416234300001
		$odChubcnt=$dt2["OD_CHUBCNT"];  //첩수
	
		$rcQuality=medicineinfo($rc_medicine,$odChubcnt);  //여기는 테이블이 수동조제만 있음 

		$json["rcQuality"]=$rcQuality;
		$rc_quality=json_encode($rcQuality);

		//$json["rc_quality"]=$unescaped;

		$sql3=" update ".$dbH."_recipeuser set rc_quality='".$rc_quality."', rc_modify=sysdate where rc_code='".$odScription."' ";
		dbcommit($sql3);
		$json["sql3"]=$sql3;		

		//-------------------------------------------------------------------------------------




		$json["busql"] = $busql;


		if($od_goods=="M") //약재포장이면 조제에서 포장으로 가기 
		{
			if($ma_medibox_infirst=="" && $ma_medibox_inmain=="" && $ma_medibox_inafter=="" &&$ma_medibox_inlast=="")
			{
				$sql=" update ".$dbH."_making set ma_status='making_done', ma_table='00080', ma_tablestat='finish', ma_medibox_inmain='MDT0000030000', ma_staffid='".$st_staffid."', ma_pharmacist='".$ma_pharmacist."',  ma_modify=sysdate, ma_pharmacy=sysdate where ma_odcode='".$od_code."' ";
				dbcommit($sql);
				$tsql.=$sql;
			}
			else
			{
				$sql=" update ".$dbH."_making set ma_status='making_done', ma_table='00080', ma_tablestat='finish', ma_staffid='".$st_staffid."', ma_pharmacist='".$ma_pharmacist."',  ma_modify=sysdate, ma_pharmacy=sysdate where ma_odcode='".$od_code."' ";
				dbcommit($sql);
				$tsql.=$sql;
			}
			$json["making1"] = $sql;
			
			//원래 소스 임 - 나중에는 이부분으로 교체해야함 
			//주문테이블 탕전대기로 상태변경
			$sql=" update ".$dbH."_order set od_status='release_apply', od_modify=sysdate where od_code='".$od_code."'"; //making_start -> release_apply
			dbcommit($sql);
			$json["order1"] = $sql;

			//포장  
			$sql=" update ".$dbH."_release set re_status='release_apply', re_modify=sysdate where re_odcode='".$od_code."'";//order -> release_apply
			$json["release1"] = $sql;
			dbcommit($sql);

		}
		else
		{
				
			if($od_matype=="goods" || $od_matype=="commercial" || $od_matype=="worthy")
			{
				if($ma_medibox_infirst=="" && $ma_medibox_inmain=="" && $ma_medibox_inafter=="" &&$ma_medibox_inlast=="")
				{
					$sql=" update ".$dbH."_making set ma_status='making_done', ma_table='00080', ma_tablestat='finish', ma_medibox_inmain='MDT0000030000', ma_staffid='".$st_staffid."', ma_pharmacist='".$ma_pharmacist."',  ma_modify=sysdate, ma_pharmacy=sysdate where ma_odcode='".$od_code."' ";
					dbcommit($sql);
					$tsql.=$sql;
				}
				else
				{
					$sql=" update ".$dbH."_making set ma_status='making_done', ma_table='00080', ma_tablestat='finish', ma_staffid='".$st_staffid."', ma_pharmacist='".$ma_pharmacist."',  ma_modify=sysdate, ma_pharmacy=sysdate where ma_odcode='".$od_code."' ";
					dbcommit($sql);
					$tsql.=$sql;
				}
			}
			else
			{
				//making 변경 - 조제사 아이디 업데이트 staffid
				$sql=" update ".$dbH."_making set ma_status='making_done', ma_table='00080', ma_tablestat='finish', ma_staffid='".$st_staffid."', ma_pharmacist='".$ma_pharmacist."',  ma_modify=sysdate, ma_pharmacy=sysdate where ma_odcode='".$od_code."' ";
				dbcommit($sql);
				$tsql.=$sql;
			}		
			$json["making"] = $sql;
			

			//order 변경
			$sql=" update ".$dbH."_order set od_status='decoction_apply', od_modify=sysdate where od_code='".$od_code."' ";
			dbcommit($sql);
			$tsql.=$sql;
			$json["order"] = $sql;

			//decoction 변경
			$sql=" update ".$dbH."_decoction set dc_status='decoction_apply', dc_modify=sysdate where dc_odcode='".$od_code."' ";
			dbcommit($sql);
			$tsql.=$sql;
			$json["decoction"] = $sql;
		}

		//recipeuser 변경 변경
		if($new_rcMedicine)
		{
			$sql=" update ".$dbH."_recipeuser set rc_medicine='".$new_rcMedicine."', rc_modify=sysdate where rc_code='".$rc_code."' ";
			dbcommit($sql);
			$json["new_rcMedicine"] = $sql;
			$tsql.=$sql;
		}

		if($new_rc_sweet)
		{
			$sql=" update ".$dbH."_recipeuser set rc_sweet='".$new_rc_sweet."', rc_modify=sysdate where rc_code='".$rc_code."' ";
			dbcommit($sql);
			$tsql.=$sql;
			$json["new_rc_sweet"] = $sql;
		}

		//약재차감 쿼리.. 한꺼번에 update 하자.. 일단은 물어보고 
		//if($busql)
		//{
			//dbcommit($busql);
		//}


		$json["tsql"] = $tsql;
		$json["apiCode"] = $apiCode;
		$json["returnData"] = $returnData;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
<?php
	//약재정보 가져오기
	function medicineinfo($rcmedicine,$odChubcnt)// |HD10039_15,1,inmain,0,P0
	{
		global $dbH;
		global $language;
		
		$medidata=array();

		$arr=explode("|",$rcmedicine);
		for($i=1;$i<count($arr);$i++)
		{
			$arr2=explode(",",$arr[$i]);		

			$sql = " select ( select to_char(wh_expired, 'yyyy-mm-dd hh24:mi:ss') from ".$dbH."_warehouse where  wh_code=b.mb_stock and wh_type='incoming') whExpired  ";
			$sql .= " ,( select to_char(wh_indate, 'yyyy-mm-dd hh24:mi:ss') from ".$dbH."_warehouse where  wh_code=b.mb_stock and wh_type='incoming') whIndate   ";			 
			$sql .= " ,( select max(af_url) from ".$dbH."_file where  af_fcode=a.md_hub and af_code='medihub') afUrl  ";			 
			$sql .= " , a.md_hub, a.md_seq, a.md_title_kor, a.md_code ,a.md_origin_kor ,a.md_maker_kor ,b.mb_code    ";		
			$sql .=" from ".$dbH."_medicine a ";
			$sql .=" inner join ".$dbH."_medibox b on a.md_code=b.mb_medicine ";			
			$sql .=" where a.md_code='".$arr2[0]."' and  b.mb_table='00080' and b.MB_USE<>'D' ";

			$dt5=dbone($sql);

			$afFile=getafFile($dt5["AFURL"]);
			$afThumbUrl=getafThumbUrl($dt5["AFURL"]);

			$mediarr=array(
				//"sql"=>$sql,
				"afUrl"=>$dt5["AFURL"],
				"afFile"=>$afFile,
				"afThumbUrl"=>$afThumbUrl,
				"mdTitleKor"=>$dt5["MD_TITLE_KOR"], //약재명
				"mdCode"=>$dt5["MD_CODE"], //약재코드
				"mdOrigin_kor"=>$dt5["MD_ORIGIN_KOR"], //원산지
				"mdMaker_kor"=>$dt5["MD_MAKER_KOR"], //생산자
				"mbCode"=>$dt5["MB_CODE"], //약재함
				"capaTotal"=>$arr2[1]*$odChubcnt, //총약재량

				"whExpired"=>$dt5["WHEXPIRED"], //유통기한
				"whIndate"=>$dt5["WHINDATE"] //재고입고일

				);
			
			array_push($medidata,$mediarr);				
		}	
		return $medidata;
	}

?>