<?php  
	///이전처방 리스트
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$medicalid=$_GET["medicalid"]; ///mi_userid &  me_company
	$userid=$_GET["userid"]; //환자의 userid

	if($apiCode!="medicalrecordlist"){$json["resultMessage"]="API(apiCode) ERROR2";$apiCode="medicalrecordlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		$jsql=" c left join ".$dbH."_order a on a.od_keycode=c.keycode ";
		$jsql.=" left join ".$dbH."_RECIPEUSER b on b.rc_code=a.OD_SCRIPTION ";
		$wsql=" where  c.medicalcode ='".$medicalid."' and c.patientcode='".$userid."'  ";

		if($search)  ///검색단어 (주문자,처방명,주문코드)
		{
			/* order 테이블
			$wsql.=" and ( ";
			$wsql.=" a.od_rename like '%".$search."%' ";///주문자
			$wsql.=" or ";
			$wsql.=" a.od_title like '%".$search."%' ";///처방명
			$wsql.=" or ";
			$wsql.=" a.od_code like '%".$search."%' ";///주문코드
			$wsql.=" )";
			*/

			//$wsql.=" and ( ";
			//$wsql.=" c.patientname like '%".$search."%' ";///주문자
			//$wsql.=" )";
		}

		$pg=apipaging("c.seq","order_medical",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (order by c.orderdate desc) NUM ";
		$sql.=" ,a.od_seq,a.od_keycode,a.od_title, a.od_name, a.od_birth,a.od_gender ,a.od_mobile,to_char(a.od_date,'yyyy-mm-dd') as od_date,a.od_userid,a.od_status ";
		$sql.=" ,c.medicalcode,c.doctorname ,c.keycode,to_char(c.orderdate,'yyyy-mm-dd') as orderdate,  c.ordertitle, c.seq, c.orderstatus,c.ordercode,c.patientname";
		$sql.=" ,c.AMOUNTTOTAL,c.AMOUNTMEDICINE,c.AMOUNTADDMEDI,c.AMOUNTSWEET,c.AMOUNTPHARMACY,c.AMOUNTDECOCTION,c.AMOUNTPACKAGING,c.AMOUNTDELIVERY ";	
		$sql.=" ,c.ordertype, c.orderCount,c.ordertypecode, c.TOTALMEDICINE, c.SWEETMEDI,c.PATIENTMEMO  ";	
		$sql.=" ,b.RC_SEQ";
		$sql.=" from ".$dbH."_order_medical  $jsql $wsql  ";
		$sql.=" order by c.orderdate desc";
		$sql.=" ) where NUM>".$pg["snum"]." and NUM<=".$pg["tlast"];

		$res=dbqry($sql);
		$json["sql"]=$sql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["search"]=$searchtxt;
		$json["list"]=array();



		while($dt=dbarr($res))
		{
			if($dt["OD_STATUS"]){$od_status=$dt["OD_STATUS"];}else{$od_status=$dt["ORDERSTATUS"];}
			if($dt["AMOUNTTOTAL"]){$amounttotal=$dt["AMOUNTTOTAL"];}else{$amounttotal="0";}//총금액


			$odstatustex="";
			if($od_status=="cart")  
			{
				$odstatustext="장바구니";
			}
			else if($od_status=="paid" || $od_status=="done")  
			{
				$odstatustext="주문완료";
			}
			else if($od_status=="temp")
			{	 
				$odstatustext="임시저장";
			}
			else
			{
				$odstatustext="임시저장";
			}



			$addarray=array(
			"Btn"=>"<button type='button' class='btn bg-blue color-white radius' style='font-size:12px;padding:3px 5px;background:#DBA901;width:70px;height:30px;' onclick='againorder(".$dt['SEQ'].");'>재처방</button>", //againorder(".$dt['SEQ'].")의 seq 는 han_order_medical
      
			"seq"=>$dt["SEQ"], 
			"doctorname"=>$dt["DOCTORNAME"], //한의사 
			"ordercode"=>$dt["ORDERCODE"], //처방번호
						
			"orderdate"=>$dt["ORDERDATE"], //처방전송일자

			"patientname"=>$dt["PATIENTNAME"], //환자명	
			"ordertitle"=>$dt["ORDERTITLE"], //처방명

			"patientmemo"=>getClob($dt["PATIENTMEMO"]), //처방메모	

			"ordertypecode"=>$dt["ORDERTYPECODE"], //decoction,goods,commercial,pill

			"rc_seq"=>$dt["RC_SEQ"],//recipeuser의 seq 이값으로 나의처방등록할때 필요함 

			"orderstatus"=>$odstatustext, //진행상황
			"od_status"=>$od_status, //진행상황

			"nopayorderstatus"=>$odstatustext, //진행상황	

			"ordertype"=>$dt["ORDERTYPE"], //진행상황	
			"keycode"=>$dt["KEYCODE"], //진행상황	

			"ordercount"=>$ordercount,//주문갯수 
			"totmediname"=>$totmediname,
		
			"totalmedicine"=>$totalmedicine, //상품금액(약재비)
			"totalmaking"=>$totalmaking,//조제비용(조제비+탕전비+포장비)
			"totaldelivery"=>$totaldelivery, //배송비 

			"amounttotal"=>$amounttotal //합계금액
				
			);
			array_push($json["list"], $addarray);

		}

		//$json["wsql"]=$wsql;
		$json["medicalid"]=$medicalid;
		$json["sql"]=$sql;
		$json["apiCode"]=$apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	

	}
?>