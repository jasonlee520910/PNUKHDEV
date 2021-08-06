<?php //탕전기사용등록
	$apiCode=$_POST["apiCode"];
	$language=$_POST["language"];
	$odcode=$_POST["odcode"];
	$code=$_POST["code"];

	if($apiCode!="checkboilerupdate"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="checkboilerupdate";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	//else if($odcode==""){$json["resultMessage"]="odcode없음";}
	else
	{
		//1.  탕전기 선택 시 bo_intime 현시간 저장 상태 hold 변경
		$dsql=" select dc_staffid from ".$dbH."_decoction where dc_odcode='".$odcode."'";
		$ddt=dbone($dsql);
		$dc_staffid=$ddt["DC_STAFFID"];
		$json["dc_staffid"]=$dc_staffid;

		//처방명 가져오기
		$osql=" select  od_title from ".$dbH."_order where  od_code='".$odcode."' ";
		$odt=dbone($osql);
		$od_title=$odt["OD_TITLE"];


		//탕전기사용등록
		$sql2=" update ".$dbH."_decoction set dc_boilercode='".$code."' where dc_odcode='".$odcode."'";
		$json["1탕전기로그"]=$sql2;
		dbcommit($sql2);

		//탕전기상태 변경
		//20191107:bo_intime을 decocprocessing으로 옮김 
		$sql3=" update ".$dbH."_boiler set bo_odcode='".$odcode."', bo_staff='".$dc_staffid."', bo_status='hold', bo_intime=sysdate where bo_code='".$code."'";
		$json["2탕전기로그"]=$sql3;
		dbcommit($sql3);

		//20191129 추가 
		//탕전기로그에 od_code가 있는지 체크 
		$sql="select bo_odcode from ".$dbH."_boilerlog where bo_odcode='".$odcode."'";
		$dt=dbone($sql);
		if(!$dt["BO_ODCODE"])
		{
			//탕전기로그
			$bsql=" INSERT INTO ".$dbH."_boilerlog (BO_SEQ, bo_code, bo_odcode, bo_title, bo_staffid, bo_intime, bo_outtime, bo_status, bo_etc, bo_use, bo_date) VALUES ";
			$bsql.=" ((SELECT NVL(MAX(BO_SEQ),0)+1 FROM ".$dbH."_boilerlog), '".$code."', '".$odcode."', '".$od_title."', '".$dc_staffid."', sysdate, NULL, 'ing', '', 'Y', sysdate) ";
			dbcommit($bsql);
			$json["3탕전기로그"]=$bsql;
		}
		else
		{
			//탕전기로그
			$bsql=" update ".$dbH."_boilerlog set ";
			$bsql.=" bo_code='".$code."', bo_title='".$od_title."', bo_staffid='".$dc_staffid."', bo_intime=sysdate, bo_outtime=NULL, bo_status='ing' ";
			$bsql.=" where bo_odcode='".$odcode."' ";
			dbcommit($bsql);
			$json["4탕전기로그"]=$bsql;
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