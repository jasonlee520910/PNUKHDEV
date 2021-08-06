<?php //포장기
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$odcode=$_POST["odcode"];
	$code=$_POST["code"];

	if($apiCode!="checkpackingupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="checkpackingupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		//4. 탕전 2차(포장기)  포장기 선택 시 pa_intime 현시간 저장 상태 hold 변경
		$dsql=" select dc_packingid, dc_boilercode from ".$dbH."_decoction where dc_odcode='".$odcode."'";
		$ddt=dbone($dsql);
		$dc_packingid=$ddt["DC_PACKINGID"];
		$dc_boilercode=$ddt["DC_BOILERCODE"];
		$json["dc_packingid"]=$dc_packingid;
		$json["dc_boilercode"]=$dc_boilercode;

		//처방명 가져오기
		$osql=" select  od_title from ".$dbH."_order where  od_code='".$odcode."' ";
		$odt=dbone($osql);
		$od_title=$odt["OD_TITLE"];


		//탕전기상태 변경
		//20191107:bo_intime을 decocprocessing으로 옮김 
		$sql3=" update ".$dbH."_boiler set  bo_status='standby', bo_outtime=sysdate where bo_odcode='".$odcode."'";
		$json["1포장기로그"]=$sql3;

		dbcommit($sql3);

		//탕전기로그
		$bsql=" update ".$dbH."_boilerlog set ";
		$bsql.=" bo_outtime=sysdate, bo_status='end' ";
		$bsql.=" where bo_odcode='".$odcode."' ";
		dbcommit($bsql);
		$json["2포장기로그"]=$bsql;


		//포장기 사용등록
		$sql2=" update ".$dbH."_decoction set dc_packingcode='".$code."' where dc_odcode='".$odcode."'";
		$json["3포장기로그"]=$sql2;
		dbcommit($sql2);

		//포장기상태 변경
		$sql3=" update ".$dbH."_packing set pa_odcode='".$odcode."', pa_staff='".$dc_packingid."', pa_status='hold', pa_intime=sysdate where pa_code='".$code."'";
		$json["4포장기로그"]=$sql3;
		dbcommit($sql3);

	
		//포장기로그에 od_code가 있는지 체크 
		$sql="select pa_odcode from ".$dbH."_packinglog where pa_odcode='".$odcode."'";
		$dt=dbone($sql);
		if(!$dt["PA_ODCODE"])
		{
			//포장기로그
			$bsql=" INSERT INTO ".$dbH."_packinglog (PA_SEQ, pa_code, pa_odcode, pa_title, pa_staffid, pa_intime, pa_outtime, pa_status, pa_etc, pa_use, pa_date) VALUES ";
			$bsql.=" ((SELECT NVL(MAX(PA_SEQ),0)+1 FROM ".$dbH."_packinglog),'".$code."', '".$odcode."', '".$od_title."', '".$dc_packingid."', sysdate, NULL, 'ing', '', 'Y', sysdate) ";
			dbcommit($bsql);
			$json["5포장기로그"]=$bsql;
		}
		else
		{
			//포장기로그
			$bsql=" update ".$dbH."_packinglog set ";
			$bsql.=" pa_code='".$code."', pa_title='".$od_title."', pa_staffid='".$dc_packingid."', pa_intime=sysdate, pa_outtime=NULL, pa_status='ing' ";
			$bsql.=" where pa_odcode='".$odcode."' ";
			dbcommit($bsql);
			$json["6포장기로그"]=$bsql;
		}
	


		//보일러리스트 
		$boilerlist=getBoilerList();
		$json["boilerlist"]=$boilerlist;

		//포장기리스트 
		$packinglist=getpackingList();
		$json["packinglist"]=$packinglist;

		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";		
		$json["resultMessage"]="OK";
	}
?>