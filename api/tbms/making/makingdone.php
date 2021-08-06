<?php
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];

	$code=$_POST["code"];
	$defineprocess=$_POST["defineprocess"];

	if($apiCode!="makingdone"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="makingdone";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{	
		$json["apiCode"] = $apiCode;

		//-----------------------------------------------------------------------
		//han_dashboard에 데이터 넣기 
		//-----------------------------------------------------------------------
		$jsql=" a inner join ".$dbH."_recipeuser r on a.od_scription=r.rc_code ";
		$jsql.=" inner join ".$dbH."_making b on a.od_keycode=b.ma_keycode ";		
		$ssql=" a.od_seq, a.od_code, to_char(a.od_birth, 'yyyy-mm-dd') as ODBIRTH, a.od_gender,  a.od_chubcnt, a.od_goods ";
		$ssql.=" , to_char(a.od_date, 'yyyy-mm-dd hh24:mi:ss') as odDate ";
		$ssql.=" , r.rc_medicine as RCMEDICINE ";
		$ssql.=" , r.rc_sweet as RCSWEET ";
		$ssql.=" , to_char(b.ma_start, 'yyyy-mm-dd hh24:mi:ss') as MASTART, to_char(b.ma_end, 'yyyy-mm-dd hh24:mi:ss') as MAEND, b.ma_table ";

		$wsql="  where a.od_code = '".$code."' "; //해당하는 주문번호의 데이터들을 가져오자 
		$sql=" select $ssql from ".$dbH."_order $jsql $wsql order by od_seq asc ";
		//-----------------------------------------------------------------------
		$dt=dbone($sql);
		$json["sql"]=$sql;
		//-----------------------------------------------------------------------
		$db_odcode=$dt["OD_CODE"];
		$ma_table=$dt["MA_TABLE"];
		$od_goods=$dt["OD_GOODS"];//20200113 :  약재 
		//20190823 : 생일 수정
		if($dt["ODBIRTH"])
		{
			if($dt["ODBIRTH"]=="0000-00-00")
			{
				$db_birth='NULL';
			}
			else
			{
				$db_birth="'".str_replace("-","",$dt["ODBIRTH"])."'";
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
		$db_mkstart=($dt["MASTART"]) ? "'".$dt["MASTART"]."'" : 'NULL';
		$db_mkend=($dt["MAEND"]) ? "'".$dt["MAEND"]."'" : 'NULL';
		$db_oddate=$dt["ODDATE"];

		$od_chubcnt=$dt["OD_CHUBCNT"];
		$rc_medicine=getClob($dt["RCMEDICINE"]);
		$rc_sweet=getClob($dt["RCSWEET"]);

		if($rc_medicine)
		{
			$mediarry=explode("|",$rc_medicine);
			for($i=1;$i<count($mediarry);$i++)
			{
				$arr=explode(",",$mediarry[$i]);
				if($arr[4])
				{
					if(strpos($arr[0], '__') !== false)
					{
						$marr=explode("__",$arr[0]);
						$db_mdcode=$marr[0];
					}
					else
					{
						$db_mdcode=$arr[0];
					}
					
					$db_mdcapa=floatval($od_chubcnt)*floatval($arr[1]);
					$db_mdcapa=round($db_mdcapa);
					//20190822 : P0이면 db_mdcapa랑 똑같이 넣고, db_pass를 Y 로 바꾸자 
					if(strpos($arr[4], 'P') !== false)
					{
						if($arr[4] == "P0")
						{
							$db_makingcapa=$db_mdcapa;
						}
						else
						{
							$db_makingcapa=str_replace("P","",$arr[4]);
						}
						
						$db_pass="Y";
					}
					else
					{
						$db_makingcapa=$arr[4];
						$db_pass="N";
					}
					$isql="INSERT INTO ".$dbH."_dashboard (DB_SEQ, db_table, db_odcode, db_mkstart, db_mkend, db_birth, db_gender, db_chubcnt, db_mdcode, db_mdcapa, db_makingcapa, db_pass, db_oddate, db_date) VALUES  ((SELECT NVL(MAX(DB_SEQ),0)+1 FROM ".$dbH."_dashboard),'".$ma_table."','".$db_odcode."',to_date(".$db_mkstart.",'YYYY-MM-DD hh24:mi:ss'),to_date(".$db_mkend.",'YYYY-MM-DD hh24:mi:ss'),".$db_birth.",".$db_gender.",'".$od_chubcnt."','".$db_mdcode."','".$db_mdcapa."','".$db_makingcapa."','".$db_pass."',to_date('".$db_oddate."','YYYY-MM-DD hh24:mi:ss'), sysdate) ";
					dbcommit($isql);
					$json["isql_".$db_mdcode]=$isql;
				}
			}
		}

		if($rc_sweet)
		{
			$sweetarry=explode("|",$rc_sweet);
			for($i=1;$i<count($sweetarry);$i++)
			{
				$arr=explode(",",$sweetarry[$i]);
				if($arr[4])
				{
					$db_mdcode=$arr[0];
					$db_mdcapa=floatval($od_chubcnt)*floatval($arr[1]);
					$db_mdcapa=round($db_mdcapa);
					//20190822 : P0이면 db_mdcapa랑 똑같이 넣고, db_pass를 Y 로 바꾸자 
					if(strpos($arr[4], 'P') !== false)
					{
						if($arr[4] == "P0")
						{
							$db_makingcapa=$db_mdcapa;
						}
						else
						{
							$db_makingcapa=str_replace("P","",$arr[4]);
						}
						
						$db_pass="Y";
					}
					else
					{
						$db_makingcapa=$arr[4];
						$db_pass="N";
					}
					
					$isql="INSERT INTO ".$dbH."_dashboard (DB_SEQ, db_table, db_odcode, db_mkstart, db_mkend, db_birth, db_gender, db_chubcnt, db_mdcode, db_mdcapa, db_makingcapa, db_pass, db_oddate, db_date) VALUES ((SELECT NVL(MAX(DB_SEQ),0)+1 FROM ".$dbH."_dashboard),'".$ma_table."','".$db_odcode."',to_date(".$db_mkstart.",'YYYY-MM-DD hh24:mi:ss'),to_date(".$db_mkend.",'YYYY-MM-DD hh24:mi:ss'),".$db_birth.",".$db_gender.",'".$od_chubcnt."','".$db_mdcode."','".$db_mdcapa."','".$db_makingcapa."','".$db_pass."',to_date('".$db_oddate."','YYYY-MM-DD hh24:mi:ss'), sysdate) ";
					dbcommit($isql);
					$json["isql_".$db_mdcode]=$isql;
				}
			}
		}
		//1202 db_table 추가
		//-----------------------------------------------------------------------
		//$isql=" INSERT INTO ".$dbH."_dashboard (DB_SEQ, db_table, db_odcode, db_mkstart, db_mkend, db_birth, db_gender, db_chubcnt, db_mdcode, db_mdcapa, db_makingcapa, db_pass, db_oddate, db_date) VALUES ";
		//$isql.=substr($usql, 1);
		//dbcommit($isql);
		//$json["isql"]=$isql;
		//-----------------------------------------------------------------------


		//-------------------------------------------------------------------------------------
		//1211 품질보고서를 위한 약재정보 저장  
		//recipeuser update 하려면 rc_code 을 알아야함
		$sql2="select od_scription,od_chubcnt from ".$dbH."_order where od_code='".$code."' ";  //	 select od_scription from han_order where od_code='ODD1912040000107753'

		$dt2=dbone($sql2);
		$json["sql2"]=$sql2;
		$odScription=$dt2["OD_SCRIPTION"];  //RC2019120416234300001
		$odChubcnt=$dt2["OD_CHUBCNT"];  //첩수
	
		$rcQuality=medicineinfo($rc_medicine,$ma_table,$odChubcnt);

		$json["rcQuality"]=$rcQuality;
		$rc_quality=json_encode($rcQuality);

		//이부분을 해줘야 한글이 안깨지고 저장됨
		$unescaped = preg_replace_callback('/\\\\u(\w{4})/', function ($matches) {
			return html_entity_decode('&#x' . $matches[1] . ';', ENT_COMPAT, 'UTF-8');
		}, $rc_quality);

		$json["rc_quality"]=$unescaped;

		$sql3=" update ".$dbH."_recipeuser set rc_quality='".$unescaped."', rc_modify=sysdate where rc_code='".$odScription."' ";
		dbcommit($sql3);
		$json["sql3"]=$sql3;		

		//-------------------------------------------------------------------------------------
		if($defineprocess=="true")
		{
			if($od_goods=="M") //약재포장이면 조제에서 포장으로 가기 
			{
				//원래 소스 임 - 나중에는 이부분으로 교체해야함 
				//주문테이블 탕전대기로 상태변경
				$sql=" update ".$dbH."_order set od_status='release_apply' where od_code='".$code."'"; //making_start -> release_apply
				dbcommit($sql);
				//조제종료로 상태변경  테이블상태 finish
				$sql=" update ".$dbH."_making set ma_tablestat='finish', ma_status='making_done', ma_modify=sysdate where ma_odcode='".$code."'"; //making_start -> making_done making_done
				dbcommit($sql);
				
				//포장  
				$sql=" update ".$dbH."_release set re_status='release_apply' where re_odcode='".$code."'";//order -> release_apply
				dbcommit($sql);

				//han_config cf_making을  scan으로 바꾸자  조제작업금지 = N, 테이블 스캔시작 = scan
				//20191030 : han_config 테이블에서 han_makingtable로 이동 
				$sql=" update ".$dbH."_makingtable set mt_making='N',  mt_makingtable='scan' where mt_code = '".$ma_table."' ";//config에서 cf_makingtable
				dbcommit($sql);
			}
			else
			{
				//원래 소스 임 - 나중에는 이부분으로 교체해야함 
				//주문테이블 탕전대기로 상태변경
				$sql=" update ".$dbH."_order set od_status='decoction_apply' where od_code='".$code."'"; //making_start -> decoction_apply
				dbcommit($sql);
				//조제종료로 상태변경  테이블상태 finish
				$sql=" update ".$dbH."_making set ma_tablestat='finish', ma_status='making_done', ma_modify=sysdate where ma_odcode='".$code."'"; //making_start -> making_done making_done
				dbcommit($sql);
				//탕전테이블 탕전대기로 상태변경
				$sql=" update ".$dbH."_decoction set dc_status='decoction_apply' where dc_odcode='".$code."'";//order -> decoction_apply
				dbcommit($sql);

				//han_config cf_making을  scan으로 바꾸자  조제작업금지 = N, 테이블 스캔시작 = scan
				//20191030 : han_config 테이블에서 han_makingtable로 이동 
				$sql=" update ".$dbH."_makingtable set mt_making='N',  mt_makingtable='scan' where mt_code = '".$ma_table."' ";//config에서 cf_makingtable
				dbcommit($sql);
			}
		}
		else
		{
			//-------------------------------------------------------------------------------------
			//조제를 계속 진행하기 위해서는 recipeuser 도 바꾸자 
			//-------------------------------------------------------------------------------------
			$sql=" select a.od_code, b.rc_code, b.rc_medicine, b.rc_sweet from ".$dbH."_order a ";
			$sql.=" inner join ".$dbH."_recipeuser b on a.od_scription=b.rc_code ";
			$sql.=" where a.od_code='".$code."' ";
			$dt=dbone($sql);
			$od_code=$dt["OD_CODE"];
			$rc_code=$dt["RC_CODE"];
			$rc_medicine=getClob($dt["RC_MEDICINE"]);
			$rc_sweet=getClob($dt["RC_SWEET"]);

			if($rc_medicine)
			{
				$finishmedi="";
				$mediarry=explode("|",$rc_medicine);			
				for($i=1;$i<count($mediarry);$i++)
				{
					$arr=explode(",",$mediarry[$i]);
					$finishmedi.="|".$arr[0].",".$arr[1].",".$arr[2].",".$arr[3];
				}
				if(!$finishmedi) $finishmedi=$rc_medicine;
			}

			if($rc_sweet)
			{
				$finishsweet="";
				$sweetarry=explode("|",$rc_sweet);			
				for($i=1;$i<count($sweetarry);$i++)
				{
					$arr=explode(",",$sweetarry[$i]);
					$finishsweet.="|".$arr[0].",".$arr[1].",".$arr[2].",".$arr[3];
				}
				if(!$finishsweet) $finishsweet=$rc_sweet;
			}
			//
			$sql=" update ".$dbH."_recipeuser set rc_medicine='".$finishmedi."', rc_sweet='".$finishsweet."', rc_modify=sysdate where rc_code='".$rc_code."' ";
			dbcommit($sql);


			//주문테이블 탕전대기로 상태변경
			$sql=" update ".$dbH."_order set od_status='making_apply' where od_code='".$code."'"; //making_start -> decoction_apply
			dbcommit($sql);
			//조제종료로 상태변경  테이블상태 finish
			$sql=" update ".$dbH."_making set ma_table=null, ma_tablestat=null, ma_medibox_infirst = null, ma_medibox_inmain=null,ma_medibox_inafter=null,ma_medibox_inlast=null, ma_status='making_apply', ma_modify=sysdate where ma_odcode='".$code."'"; //making_start -> making_done
			dbcommit($sql);
			//탕전테이블 탕전대기로 상태변경
			$sql=" update ".$dbH."_decoction set dc_status='decoction_apply' where dc_odcode='".$code."'";//order -> decoction_apply
			dbcommit($sql);

			//han_config cf_making을  scan으로 바꾸자  조제작업금지 = N, 테이블 스캔시작 = scan
			//20191030 : han_config 테이블에서 han_makingtable로 이동 
			$sql=" update ".$dbH."_makingtable set mt_making='N',  mt_makingtable='scan' where mt_code = '".$ma_table."' ";//config에서 cf_makingtable
			dbcommit($sql);

			//-------------------------------------------------------------------------------------
		}

		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}

	//약재정보 가져오기
	function medicineinfo($rcmedicine,$table,$odChubcnt)// |HD10039_15,1,inmain,0,P0
	{
		global $dbH;
		global $language;
		
		$medidata=array();

		$arr=explode("|",$rcmedicine);
		for($i=1;$i<count($arr);$i++)
		{
			$arr2=explode(",",$arr[$i]);		

			$sql = " select ( select to_char(wh_expired, 'yyyy-mm-dd') from ".$dbH."_warehouse where  wh_code=b.mb_stock and wh_type='incoming') whExpired  ";
			$sql .= " ,( select to_char(wh_indate, 'yyyy-mm-dd') from ".$dbH."_warehouse where  wh_code=b.mb_stock and wh_type='incoming') whIndate   ";			 
			$sql .= " ,( select max(af_url) from ".$dbH."_file where  af_fcode=a.md_hub and af_code='medihub') afUrl  ";			 
			$sql .= " , a.md_hub, a.md_seq, a.md_title_kor, a.md_code ,a.md_origin_kor ,a.md_maker_kor ,b.mb_code    ";		
			$sql .=" from ".$dbH."_medicine a ";
			$sql .=" inner join ".$dbH."_medibox b on a.md_code=b.mb_medicine ";			
			$sql .=" where md_code='".$arr2[0]."' and  b.mb_table in ('".$table."','00000')  ";

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