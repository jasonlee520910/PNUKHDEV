<?php
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	$medicalId=$_GET["medicalId"];
	$doctorId=$_GET["doctorId"];

	if($apiCode!="orderlist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="orderlist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{

		$dsql="select ME_GRADE from ".$dbH."_member where ME_USERID='".$doctorId."'";
		$ddt=dbone($dsql);
		$me_grade=$ddt["ME_GRADE"];

		$json["me_grade"]=$me_grade;	

		$pagetype=$_GET["pagetype"];  

		$sdate = $_GET["sdate"];
		$edate = $_GET["edate"];

		$search=urldecode($_GET["searchTxt"]); ///검색단어

		$jsql=" c left join ".$dbH."_order a on a.od_keycode=c.keycode ";
		$jsql.=" left join ".$dbH."_RECIPEUSER b on b.rc_code=a.OD_SCRIPTION ";
		$wsql=" where  c.medicalcode ='".$medicalId."' ";

		if($pagetype=="notemp")//주문내역
		{
			if($me_grade==30)
			{
				$wsql.=" and c.orderstatus not in ('temp', 'cart') and a.od_seq is not null ";
			}
			else
			{
				$wsql.=" and c.orderstatus not in ('temp', 'cart') and a.od_seq is not null and c.DOCTORCODE='".$doctorId."' ";
			}
		}
		else if($pagetype=="cart") //장바구니 
		{
			if($me_grade==30)
			{
				$wsql.=" and c.orderstatus='cart' ";
			}
			else
			{
				$wsql.=" and c.orderstatus='cart' and c.DOCTORCODE='".$doctorId."' ";
			}
		}
		else if($pagetype=="temp") //임시처방
		{
			if($me_grade==30)
			{
				$wsql.=" and c.orderstatus='temp' ";
			}
			else
			{
				$wsql.=" and c.orderstatus='temp' and c.DOCTORCODE='".$doctorId."' ";
			}
		}
		$json["cartnum"]=$cartnum;	
		$json["pagetype"]=$pagetype;	

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

			$wsql.=" and ( ";
			$wsql.=" c.patientname like '%".$search."%' ";///주문자
			$wsql.=" or ";
			$wsql.=" c.ordertitle like '%".$search."%' ";///처방명
			$wsql.=" )";
		}

		if($sdate&&$edate)
		{
			$wsql.=" and ( ";
			$wsql.=" to_char(c.orderdate, 'yyyy-mm-dd') >= '".$sdate."' and to_char(c.orderdate, 'yyyy-mm-dd') <= '".$edate."' ";
			$wsql.=" ) ";
		}

		$json["sdate"]=$sdate;	
		$json["edate"]=$edate;	

		$pg=apipaging("c.seq","order_medical",$jsql,$wsql);

		$sql=" select * from (";
		$sql.=" select ROW_NUMBER() OVER (order by c.orderdate desc) NUM ";
		$sql.=" ,a.od_seq,a.od_keycode,a.od_title, a.od_name, a.od_birth,a.od_gender ,a.od_mobile,to_char(a.od_date,'yyyy-mm-dd') as od_date,a.od_userid,a.od_status ";
		$sql.=" ,c.medicalcode,c.doctorname ,c.keycode,to_char(c.orderdate,'yyyy-mm-dd') as orderdate,  c.ordertitle, c.seq, c.orderstatus,c.ordercode,c.patientname";
		$sql.=" ,c.AMOUNTTOTAL,c.AMOUNTMEDICINE,c.AMOUNTADDMEDI,c.AMOUNTSWEET,c.AMOUNTPHARMACY,c.AMOUNTDECOCTION,c.AMOUNTPACKAGING,c.AMOUNTDELIVERY,c.AMOUNTSPECIAL ";	
		$sql.=" ,c.ordertype, c.orderCount,c.ordertypecode, c.TOTALMEDICINE, c.SWEETMEDI ";	
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
		$json["search"]=$search;
		$json["list"]=array();
		$json["wsql"]=$wsql;

		///------------------------------------------------------------
		/// DOO :: OrderStatus 
		///------------------------------------------------------------
		$hCodeList = getNewCodeTitle("odStatus");
		$odStatusList = getCodeList($hCodeList, 'odStatus');///주문상태 
		$json["odStatusList"] = $odStatusList;
		
		while($dt=dbarr($res))
		{	
			if($dt["OD_STATUS"]){$od_status=$dt["OD_STATUS"];}else{$od_status=$dt["ORDERSTATUS"];}

			if($dt["AMOUNTTOTAL"]){$amounttotal=$dt["AMOUNTTOTAL"];}else{$amounttotal="0";}//총금액
			
			if($dt["AMOUNTMEDICINE"]){$amountmedicine=$dt["AMOUNTMEDICINE"];}else{$amountmedicine="0";}//약재비
			if($dt["AMOUNTADDMEDI"]){$amountaddmedi=$dt["AMOUNTADDMEDI"];}else{$amountaddmedi="0";}//별전
			if($dt["AMOUNTSWEET"]){$amountsweet=$dt["AMOUNTSWEET"];}else{$amountsweet="0";}//감미제

					
			if($dt["AMOUNTSPECIAL"]){$amountSpecial=$dt["AMOUNTSPECIAL"];}else{$amountSpecial="0";}//특수탕전비 
			if($dt["AMOUNTPHARMACY"]){$amountpharmacy=$dt["AMOUNTPHARMACY"];}else{$amountpharmacy="0";}//조제비
			if($dt["AMOUNTDECOCTION"]){$amountdecoction=$dt["AMOUNTDECOCTION"];}else{$amountdecoction="0";}//탕전비
			if($dt["AMOUNTPACKAGING"]){$amountpackaging=$dt["AMOUNTPACKAGING"];}else{$amountpackaging="0";}//포장비

			if($dt["AMOUNTDELIVERY"]){$amountdelivery=$dt["AMOUNTDELIVERY"];}else{$amountdelivery="0";}//배송비 

			$totalmedicine=intval($amountmedicine)+intval($amountaddmedi)+intval($amountsweet);//상품금액(약재비+별전+감미제+선전비+후하비)
			$totalmaking=intval($amountpharmacy)+intval($amountdecoction)+intval($amountpackaging)+intval($amountSpecial);//조제비용(조제비+탕전비+포장비+특수탕전비)


			$totaldelivery=intval($amountdelivery);//배송비


			if($dt["ORDERCOUNT"]){$ordercount=$dt["ORDERCOUNT"];}else{$ordercount="0";}//주문갯수 

			$rcmedicine=getClob($dt["TOTALMEDICINE"]);
			$rcsweet=getClob($dt["SWEETMEDI"]);
			//|inmain,HD031801KR0001E,맥문동,,,,한국,4.0,75|inmain,HD035201KR0001E,오미자,,,,한국,2.0,72|inmain,HD024401KR0001F,인삼,,,,한국,2.0,192
			$rcMedicineArry = explode('|',$rcmedicine);
			$totmediname="";
			foreach($rcMedicineArry as $value)
			{
				$items = explode(',', $value);
				if($items[2])
				{					
					$totmediname.=",".$items[2]." ".$items[7]."g";
				}
			}

			if($rcsweet)
			{
				$rcSweetArry = explode('|',$rcsweet);
				foreach($rcSweetArry as $value)
				{
					$items = explode(',', $value);
					if($items[0])
					{						
						$totmediname.=",".$items[2]." ".$items[7]."g";
					}
				}
			}
			$totmediname=substr($totmediname,1);

			

			$odstatustex="";

			if($od_status=="cart")  
			{
				//$odstatustext="<div class='btnBox'><a href='javascript:;' onclick='paynow();' class='d-flex btn bg-blue color-white radius' style='width:70px;height:20px;'>결제하기</a></div>"; 
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

			"seq"=>$dt["SEQ"], 
			"doctorname"=>$dt["DOCTORNAME"], //한의사 
			"ordercode"=>$dt["ORDERCODE"], //처방번호
						
			"orderdate"=>$dt["ORDERDATE"], //처방전송일자

			"patientname"=>$dt["PATIENTNAME"], //환자명	
			"ordertitle"=>$dt["ORDERTITLE"], //처방명

			"ordertypecode"=>$dt["ORDERTYPECODE"], //decoction,goods,commercial,pill

			"rc_seq"=>$dt["RC_SEQ"],//recipeuser의 seq 이값으로 나의처방등록할때 필요함 

			"Btn"=>"<button type='button' class='btn bg-blue color-white radius' style='font-size:12px;padding:3px 5px;background:#DBA901;width:70px;height:22px;' onclick='againorder(".$dt['SEQ'].");'>재처방</button>",  //againorder(".$dt['SEQ'].")의 seq 는 han_order_medical	

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