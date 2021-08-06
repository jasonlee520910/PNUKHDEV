<?php  //배송리스트(191018)
	$apiCode=$_GET["apiCode"];
	$language=$_GET["language"];
	$page=$_GET["page"];
	if($apiCode!="deliverylist"){$json["resultMessage"]="API(apiCode) ERROR";$apiCode="deliverylist";}
	else if(!($language=="kor"||$language=="chn"||$language=="eng")){$json["resultMessage"]="API(language) ERROR";}
	else
	{
		
		//기간선택 
		$sdate = $_GET["sdate"];
		$edate = $_GET["edate"];
		//$searperiodetc=$_GET["searPeriodEtc"];
		$searchDelitype=$_GET["searchDelitype"];
		//검색 
		$searchtxt=urldecode($_GET["searchTxt"]);
		$search="";

		//기간선택 : 타입과 날짜 
		if($sdate&&$edate)
		{
			$sdate=str_replace(".","-",$sdate);//시작 날짜
			$edate=str_replace(".","-",$edate);//끝 날짜 

			$wsql.=" and ( ";
			$wsql.=" to_char(b.od_modify, 'yyyy-mm-dd') >= '".$sdate."' and to_char(b.od_modify, 'yyyy-mm-dd') <= '".$edate."' ";  
			$wsql.=" ) ";

			$search.="&sdate=".$sdate."&edate=".$edate;
		}


		if($searchDelitype)
		{
			$marr=explode(",",$searchDelitype);
			$json["delicount"]=count($marr);
			if(count($marr)>1)
			{
				$wsql.=" and ( ";
				for($i=1;$i<count($marr);$i++)
				{				
					if($i>1)$wsql.=" or ";
					$wsql.=" a.delitype = '".strtoupper($marr[$i])."' ";
				}
				$wsql.=" ) ";
			}
		}
		


		$json["searchDelitype"]=$searchDelitype;

		//검색 
		if($searchtxt)
		{
			$searchdelibk=$_GET["searchdelibk"];
			if($searchdelibk=="Y")
			{
				$wsql.=" and ( ";
				$wsql.=" cy.orderCode = '".($searchtxt - 10000)."' ";//처방전pk 
				$wsql.=" ) ";
			}
			else
			{
				$wsql.=" and ( ";
				$wsql.=" c.re_odcode like '%".$searchtxt."%' ";//odcode
				$wsql.=" or ";
				$wsql.=" c.re_name like '%".$searchtxt."%' ";//받는사람
				$wsql.=" or ";
				$wsql.=" c.re_address like '%".$searchtxt."%' ";//보내는사람
				$wsql.=" or ";
				$wsql.=" c.re_sendname like '%".$searchtxt."%' ";//보내는사람
				$wsql.=" or ";
				$wsql.=" c.re_sendaddress like '%".$searchtxt."%' ";//보내는사람
				$wsql.=" or ";
				$wsql.=" cy.orderCode = '".($searchtxt - 10000)."' ";//처방전pk 
				$wsql.=" or ";
				$wsql.=" a.delicode like '%".$searchtxt."%' ";//송장번호
				$wsql.=" ) ";
			}
			$search.="&searchType=".$searchtxt;			
		}

		$sql=" 
			select 
			a.delicode , a.odcode, to_char(a.usedate,'YYYY.MM.DD') as USE_DATE, a.deliconfirm, a.delitype, a.inuse
			,b.od_seq, b.od_title, b.od_goods
			,c.re_odcode, c.re_name, c.re_sendname, c.re_zipcode, c.re_address, c.re_delidate, c.re_date, c.re_modify
			,( select count(re_odcode) from han_release where re_deliexception like '%,T%' and re_delino=a.delicode) tiedCnt 
			, cy.orderCode cyodcode 
			from han_delicode_post a
			inner join han_order b on a.odcode=b.od_code
			inner join han_release c on a.odcode=c.re_odcode
			left join han_order_client cy on b.od_keycode=cy.keycode
			where odcode is not null $wsql

			union 

			select 
			a.delicode , a.odcode, to_char(a.usedate,'YYYY.MM.DD') as USE_DATE, a.deliconfirm, a.delitype, a.inuse
			,b.od_seq, b.od_title, b.od_goods
			,c.re_odcode, c.re_name, c.re_sendname, c.re_zipcode, c.re_address, c.re_delidate, c.re_date, c.re_modify
			,( select count(re_odcode) from han_release where re_deliexception like '%,T%' and re_delino=a.delicode) tiedCnt
			, cy.orderCode cyodcode 
			from han_delicode_direct a
			inner join han_order b on a.odcode=b.od_code
			inner join han_release c on a.odcode=c.re_odcode
			left join han_order_client cy on b.od_keycode=cy.keycode
			where c.re_deliexception like '%,D%' and odcode is not null $wsql

			order by re_date desc, odcode desc, inuse desc, deliconfirm desc, delitype asc  ";

		$pg=delipaging($sql);

		$dsql="select * from (".$sql.") where ROWNUM>".$pg["snum"]." and ROWNUM<=".$pg["tlast"];

		//$sql.=" limit ".$pg["snum"].", ".$pg["psize"];

		$res=dbqry($sql);



		$json["sql"]=$sql;
		$json["wsql"]=$wsql;
		$json["page"]=$pg["page"];
		$json["tcnt"]=$pg["tcnt"];
		$json["tpage"]=$pg["tpage"];
		$json["psize"]=$pg["psize"];
		$json["block"]=$pg["block"];
		$json["search"]=$search;
		$json["list"]=array();
		$i=0;
		while($dt=dbarr($res))
		{
			$arr=explode("||",$dt["RE_ADDRESS"]);

			$deliCode=$dt["DELICODE"];
			$reDelidate=$dt["USE_DATE"];
			$deliConfirm=$dt["DELICONFIRM"];
			$delitype=$dt["DELITYPE"];

			/*
			if($dt["logenDelicode"]){$deliCode=$dt["logenDelicode"];}
			if($dt["postDelicode"]){$deliCode=$dt["postDelicode"];}
			if($dt["logenUsedate"]){$reDelidate=viewdate($dt["logenUsedate"]);}
			if($dt["postUsedate"]){$reDelidate=viewdate($dt["postUsedate"]);}
			if($dt["logenDeliConfirm"]){$deliConfirm=$dt["logenDeliConfirm"];}
			if($dt["postDeliConfirm"]){$deliConfirm=$dt["postDeliConfirm"];}
			if($dt["logenDeliType"]){$delitype=$dt["logenDeliType"];}
			if($dt["postDeliType"]){$delitype=$dt["postDeliType"];}
			*/

			if($deliConfirm=="Y")
			{
				$deliConfirmName="완료";
			}
			else if($deliConfirm=="C")
			{
				$deliConfirmName="취소";
			}
			else
			{
				$deliConfirmName="대기";
			}

			if($dt["INUSE"]=="Y" || $dt["INUSE"]=="Y"){
				//$deliCode="".$deliCode."</b>";
				if($deliConfirm=="C")
				{
					$deliBtn="";
					$delireBtn="";
				}
				else
				{
					$deliBtn="<button class='btn-deli2'><span>추가출력</span></button>";
					$delireBtn="<button class='btn-deli1'><span>재출력</span></button>";
				}
				$deliBtnChk="R";
			}else{
				//$deliCode="<i style='font-size:11px;color:#999;'>".$deliCode."</i><br>-";
				if($deliConfirm=="C")
				{
					$deliBtn="";
					$delireBtn="";
				}
				else
				{
					$delireBtn="<button class='btn-deli1'><span>재출력</span></button>";
				}
				$deliBtnChk="Y";
			}

			
			if(strtoupper($delitype)=="LOGEN")
			{
				$delitypeName="로젠";
				//964 0105 5122
				$deliCodeView=substr($deliCode,0,3)."-".substr($deliCode,3,4)."-".substr($deliCode,7,4);
			}
			else if(strtoupper($delitype)=="POST")
			{
				$delitypeName="우체국";
				//18921 2184 1383
				$deliCodeView=substr($deliCode,0,5)."-".substr($deliCode,5,4)."-".substr($deliCode,9,4);
			}
			else if(strtoupper($delitype)=="CJ")
			{
				$delitypeName="CJ";
				$deliCodeView=$deliCode;
			}			
			else if(strtoupper($delitype)=="DIRECT")
			{
				$delitypeName="직배";
				$deliCodeView=$deliCode;
				$deliConfirmName="";
				$deliConfirm="N";
				$deliBtnChk="";
				$deliBtn="";
				$delireBtn="";
			}


			$trName="DELI".$i;

			//$od_chartpk=($dt["OD_CHARTPK"]) ? $dt["OD_CHARTPK"] : "";
			//if($dt["OD_CHARTPK"]){$od_chartpk="<span style='padding:2px 5px;border-radius:2px;background:#CC66CC;color:#fff;'>OK ".$dt["od_chartpk"]."</span>";}else{$od_chartpk="";}
			//if($dt["CYODCODE"]){$cyodcode="<span style='padding:2px 5px;border-radius:2px;background:#6699FF;color:#fff;'>BK ".($dt["CYODCODE"]+10000)."</span>";}else{$cyodcode="";}
			//if($cyodcode){$od_chartpk=$cyodcode;}
			//if($dt["OD_GOODS"]=="G"){$gGoods=" 사전";}else{$gGoods="";}
			//if(!$od_chartpk) {$od_chartpk="<span style='padding:2px 5px;border-radius:2px;background:#549E08;color:#fff;'>CY ".($dt["OD_SEQ"]+50000)."".$gGoods."</span>";}
			if($dt["TIEDCNT"]){$tiedCnt="<span style='padding:2px 5px;border-radius:2px;background:green;color:#fff;' onclick=\"viewtied('".$deliCode."','".$trName."')\">".$dt["TIEDCNT"]."건</span>";}else{$tiedCnt="-";}
			$addarray=array(
				"trName"=>$trName,
				"reDelidate"=>$reDelidate,//배송요청일
				"deliConfirm"=>$deliConfirm,//택배사등록 
				"deliConfirmName"=>$deliConfirmName,//택배사등록 
				"deliTied"=>$tiedCnt,//묶음배송 
				"odCode"=>$dt["RE_ODCODE"], //주문번호
				"odTitle"=>$od_chartpk." ".$dt["OD_TITLE"], //처방
				"cusutomer"=>$dt["CUSUTOMER"], //거래처코드
				"delitype"=>$delitype,//택배회사 
				"delitypeName"=>$delitypeName,//택배회사이름 

				"reSendname"=>$dt["RE_SENDNAME"], //보내는사람
				"reName"=>$dt["RE_NAME"], //받는사람

				"reZipcode"=>$dt["RE_ZIPCODE"], //우편번호
				"reAddress"=>$arr[0].$arr[1], //주소
				"deliCode"=>$deliCode, //송장번호				
				"deliBtn"=>$deliBtn, //송장번호				
				"delireBtn"=>$delireBtn,
				"deliBtnChk"=>$deliBtnChk, //송장번호				
				"deliCodeView"=>$deliCodeView
			);
			array_push($json["list"], $addarray);
			$i++;
		}

		$json["apiCode"] = $apiCode;
		$json["resultCode"]="200";
		$json["resultMessage"]="OK";
	}
?>
<?php
	//페이징
	function delipaging($sql)
	{
		$page=$_GET["page"];
		$psize=$_GET["psize"];
		$block=$_GET["block"];
		if(!$page)$page=1;
		$pg["page"]=$page;
		if(!$psize)$psize=10;
		$pg["psize"] = $psize;	//페이지당 갯수
		if(!$block)$block=10;
		$pg["block"] = $block;	//화면당 페이지수
		$pg["snum"] = ($pg["page"]-1)*$pg["psize"];
		if(!$page)$page=1;

		$res=dbqry($sql);
		$totalcnt=dbrows($sql);

		//$pg["tsql"] = $sql;
		$pg["tcnt"] = $totalcnt;
		$pg["tpage"] = ceil($totalcnt / $pg["psize"]);
		return $pg;
	}
?>