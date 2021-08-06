function setAllPrice(obj)
{
	//================================================================
	// 20190917 : 조제비, 탕전비, 배송비 수정 
	//================================================================
	var odAllPrice={}; //
	//주문받았을 당시의 조제비와 config에 저장된 데이터들 
	odAllPrice["maPrice"]=!isEmpty(obj["maPrice"]) ? obj["maPrice"] : "";
	odAllPrice["maPriceA"]=obj['config']['cfMakingpriceA'];
	odAllPrice["maPriceB"]=obj['config']['cfMakingpriceB'];
	odAllPrice["maPriceC"]=obj['config']['cfMakingpriceC'];
	odAllPrice["maPriceD"]=obj['config']['cfMakingpriceD'];
	odAllPrice["maPriceE"]=obj['config']['cfMakingpriceE'];
	//탕전비
	odAllPrice["dcPrice"]=!isEmpty(obj["dcPrice"]) ? obj["dcPrice"] : "";
	odAllPrice["dcPriceA"]=obj['config']['cfDecocpriceA'];
	odAllPrice["dcPriceB"]=obj['config']['cfDecocpriceB'];
	odAllPrice["dcPriceC"]=obj['config']['cfDecocpriceC'];
	odAllPrice["dcPriceD"]=obj['config']['cfDecocpriceD'];
	odAllPrice["dcPriceE"]=obj['config']['cfDecocpriceE'];
	//배송비 
	odAllPrice["rePrice"]=!isEmpty(obj["rePrice"]) ? obj["rePrice"] : "";
	odAllPrice["rePriceA"]=obj['config']['cfReleasepriceA'];
	odAllPrice["rePriceB"]=obj['config']['cfReleasepriceB'];
	odAllPrice["rePriceC"]=obj['config']['cfReleasepriceC'];
	odAllPrice["rePriceD"]=obj['config']['cfReleasepriceD'];
	odAllPrice["rePriceE"]=obj['config']['cfReleasepriceE'];

	//포장비  
	odAllPrice["packPrice"]=!isEmpty(obj["packPrice"]) ? obj["packPrice"] : "";
	odAllPrice["packPriceA"]=obj['config']['cfPackingpriceA'];
	odAllPrice["packPriceB"]=obj['config']['cfPackingpriceB'];
	odAllPrice["packPriceC"]=obj['config']['cfPackingpriceC'];
	odAllPrice["packPriceD"]=obj['config']['cfPackingpriceD'];
	odAllPrice["packPriceE"]=obj['config']['cfPackingpriceE'];

	//선전비   
	odAllPrice["firstPrice"]=!isEmpty(obj["firstPrice"]) ? obj["firstPrice"] : "";
	odAllPrice["firstPriceA"]=obj['config']['cfFirstpriceA'];
	odAllPrice["firstPriceB"]=obj['config']['cfFirstpriceB'];
	odAllPrice["firstPriceC"]=obj['config']['cfFirstpriceC'];
	odAllPrice["firstPriceD"]=obj['config']['cfFirstpriceD'];
	odAllPrice["firstPriceE"]=obj['config']['cfFirstpriceE'];

	//후하비    
	odAllPrice["afterPrice"]=!isEmpty(obj["afterPrice"]) ? obj["afterPrice"] : "";
	odAllPrice["afterPriceA"]=obj['config']['cfAfterpriceA'];
	odAllPrice["afterPriceB"]=obj['config']['cfAfterpriceB'];
	odAllPrice["afterPriceC"]=obj['config']['cfAfterpriceC'];
	odAllPrice["afterPriceD"]=obj['config']['cfAfterpriceD'];
	odAllPrice["afterPriceE"]=obj['config']['cfAfterpriceE'];

	//후하비    
	odAllPrice["cheobPrice"]=!isEmpty(obj["cheobPrice"]) ? obj["cheobPrice"] : "";
	odAllPrice["cheobPriceA"]=obj['config']['cfCheobpriceA'];
	odAllPrice["cheobPriceB"]=obj['config']['cfCheobpriceB'];
	odAllPrice["cheobPriceC"]=obj['config']['cfCheobpriceC'];
	odAllPrice["cheobPriceD"]=obj['config']['cfCheobpriceD'];
	odAllPrice["cheobPriceE"]=obj['config']['cfCheobpriceE'];

	//config 조제비 
	$("textarea[name=odAllPrice]").val(JSON.stringify(odAllPrice));
	//================================================================
}
function getConfigPrice(type, grade)
{
	var tmp=0;
	grade=chkGrade(grade);

	var adprice=JSON.parse($("textarea[name=odAllPrice]").val());
	switch(type)
	{
	case "making":
		if(!isEmpty(adprice["maPrice"]) && adprice["maPrice"]!=0)
		{
			tmp = parseFloat(adprice["maPrice"]);
		}
		else
		{
			tmp = parseFloat(adprice["maPrice"+grade]);
		}
		break;
	case "decoction":
		if(!isEmpty(adprice["dcPrice"]) && adprice["dcPrice"]!=0)
		{
			tmp = parseFloat(adprice["dcPrice"]);
		}
		else
		{
			if(!isEmpty(adprice["dcPrice"+grade]) && adprice["dcPrice"+grade] >= 0)
			{
				tmp = parseFloat(adprice["dcPrice"+grade]);
			}
			else
			{
				tmp = parseFloat(adprice["dcPriceE"]);
			}
		}
		break;
	case "release":
		if(!isEmpty(adprice["rePrice"]) && adprice["rePrice"]!=0)
		{
			tmp = parseFloat(adprice["rePrice"]);
		}
		else
		{
			tmp = parseFloat(adprice["rePrice"+grade]);
		}
		break;
	case "packing":
		if(!isEmpty(adprice["packPrice"]) && adprice["packPrice"]!=0)
		{
			tmp = parseFloat(adprice["packPrice"]);
		}
		else
		{
			tmp = parseFloat(adprice["packPrice"+grade]);
		}
		break;
	case "first":
		if(!isEmpty(adprice["firstPrice"]) && adprice["firstPrice"]!=0)
		{
			tmp = parseFloat(adprice["firstPrice"]);
		}
		else
		{
			tmp = parseFloat(adprice["firstPrice"+grade]);
		}
		break;
	case "after":
		if(!isEmpty(adprice["afterPrice"]) && adprice["afterPrice"]!=0)
		{
			tmp = parseFloat(adprice["afterPrice"]);
		}
		else
		{
			tmp = parseFloat(adprice["afterPrice"+grade]);
		}
		break;
	case "cheob":
		if(!isEmpty(adprice["cheobPrice"]) && adprice["cheobPrice"]!=0)
		{
			tmp = parseFloat(adprice["cheobPrice"]);
		}
		else
		{
			tmp = parseFloat(adprice["cheobPrice"+grade]);
		}
		break;
	}

	console.log("DOO ====> getConfigPrice type = "+type+", grade = " + grade+", tmp = " + tmp);

	return tmp;
}
function getPackPrice(type, grade)
{
	var tmp=0;
	var packprice=$("input[name=odPackprice]").val();//등록된 파우치 가격
	var mediprice=$("input[name=reBoxmediprice]").val();//등록된 한약박스 가격 
	var deliprice=$("input[name=reBoxdeliprice]").val();//등록된 배송박스 가격 
	var matype=$('input:radio[name="maType"]:checked').val();//조제타입 

	grade=chkGrade(grade);//등급 
	grade=grade.toLowerCase();

	switch(type)
	{
	case "odPacktype":
		switch(matype)
		{
		case "decoction": case "worthy": case "goods": case "commercial"://20191108:실속,약속,상비 추가 
			tmp=(!isEmpty(packprice)) ? packprice : $("input:radio[name=odPacktype]:checked").data("price"+grade);
			break;
		}
		break;
	case "reBoxmedi":
		tmp=(!isEmpty(mediprice)) ? mediprice : $("input:radio[name=reBoxmedi]:checked").data("price"+grade);
		break;
	case "reBoxdeli":
		tmp=(!isEmpty(deliprice)) ? deliprice : $("input:radio[name=reBoxdeli]:checked").data("price"+grade);
		break;
	}

	if(!isEmpty(tmp))
	{
		tmp=parseFloat(tmp);
	}
	//console.log("DOO ====> getPackPrice type = "+type+", grade = " + grade+", matype = "+matype+", packprice = " + packprice+", mediprice = " + mediprice+", deliprice = " + deliprice+", tmp = " + tmp);

	return tmp;
}
//약재
function resetmedi()
{
	//----------------------------------------------
	//약재 데이터 
	//----------------------------------------------
	var rccode=new Array();
	$(".rccode").each(function(){
		rccode.push($(this).val().trim());
	});
	var rcDecoctype=new Array();
	$(".rcDecoctype").each(function(){
		rcDecoctype.push($(this).val().trim());
	});
	var chubamt=new Array();
	$(".chubamt").each(function(){
		chubamt.push($(this).val().trim());
	});
	var mgprice=new Array();
	$(".mgprice").each(function(){
		mgprice.push($(this).text().trim());
	});

	var mediamt=new Array();
	$(".mediamt").each(function(){
		mediamt.push($(this).val().trim());
	});
	var rctotalqty=new Array();
	$(".rctotalqty").each(function(){
		rctotalqty.push($(this).text().trim());
	});


	var len=$(".rccode").length;
	var medicine=shortage="";
	var capa = price = 0;
	for(var i=0;i<len;i++)
	{
		capa = (isNaN(chubamt[i])==false) ? chubamt[i] : 0;
		price = (isNaN(mgprice[i])==false) ? mgprice[i] : 0;
		medicine+="|"+rccode[i]+","+capa+","+rcDecoctype[i]+","+price;
		if(parseFloat(rctotalqty[i])<parseFloat(mediamt[i]))
			shortage+="|"+rccode[i];
	}
	medicine = medicine.replace(/ /gi, "");
	console.log("resetmedi 약재  === " + medicine);
	$("input[name=rcMedicine]").val(medicine);
	$("input[name=rcShortage]").val(shortage);

	//---------------------------------------------
	//20191010 : 약재가 녹용이 있다면 탕전시간을 120으로 수정 
	if(!isEmpty(medicine))
	{
		var nok_dctime=$("input[name=base_nok_dctime]").val();//"<?=$BASE_NOK_DCTIME?>";
		var dctime=$("input[name=base_dctime]").val();//"<?=$BASE_DCTIME?>";
		console.log("nok_dctime = " + nok_dctime + ", dctime  = " + dctime)
		if(medicine.indexOf("HD10337") != -1 || medicine.indexOf("HD10336_15") != -1) //녹용이 있다면 탕전시간을 120으로 수정 
		{
			$("input[name=dcTime]").val(nok_dctime);
		}
		else
		{
			$("input[name=dcTime]").val(dctime);
		}
	}

	//---------------------------------------------
	//별전
	//---------------------------------------------
	var srccode=new Array();
	$(".srccode").each(function(){
		srccode.push($(this).val().trim());
	});
	var srcDecoctype=new Array();
	$(".srcDecoctype").each(function(){
		srcDecoctype.push($(this).val().trim());
	});
	var schubamt=new Array();
	$(".schubamt").each(function(){
		schubamt.push($(this).val().trim());
	});
	var smgprice=new Array();
	$(".smgprice").each(function(){
		smgprice.push($(this).text().trim());
	});

	var smediamt=new Array();
	$(".smediamt").each(function(){
		smediamt.push($(this).val().trim());
	});
	var srctotalqty=new Array();
	$(".srctotalqty").each(function(){
		srctotalqty.push($(this).text().trim());
	});

	var slen=$(".srccode").length;
	var sweet=sshortage="";
	var capa = price = 0;
	for(var i=0;i<slen;i++)
	{
		capa = (isNaN(schubamt[i])==false) ? schubamt[i] : 0;
		price = (isNaN(smgprice[i])==false) ? smgprice[i] : 0;
		sweet+="|"+srccode[i]+","+capa+","+srcDecoctype[i]+","+price;
	}
	sweet = sweet.replace(/ /gi, "");
	console.log("resetmedi 별전  === " + sweet);
	$("input[name=rcSweet]").val(sweet);

	//---------------------------------------------
	var totlen=len+slen;


	$("#totmedicnt").html('총약재 : <i>'+(totlen)+'</i>');
}
//조제비,탕전비,배송비등 계산
function resetamount()
{
	//-------------------------------------------------------------------------------
	var data="";
	var odAmount = 0;
	var db_making=db_decoction=db_deliprice=db_cheobprice=p1=p2=p3=packprice=db_box=db_boxmedibox=0;
	var chubcnt=packcnt=packcapa=boxcnt=boxmedicnt=packaddcnt=0;
	var chubtotal=schubtotal=chubpricetotal=chubprice=meditotal=watertotal=pricetotal=medipricetotal=sweetpricetotal=0;
	var tval=mediamt=tprice=mdprice=twater=mdwater=totalmediprice=0;
	var amountdjmedi={}; //djmedi 주문금액 json data 
	//-------------------------------------------------------------------------------
	console.log("resetamountresetamountresetamountresetamountresetamount  "+$("input[name=odChubcnt]").val()+", "+$("input[name=odPackcnt]").val()+", "+$("input[name=odPackcapa]").val());
	if(isEmpty($("input[name=odChubcnt]").val()))
	{
		return;
	}
	//첩수
	if($.isNumeric($("input[name=odChubcnt]").val())==false)
	{
		$("input[name=odChubcnt]").val(Number($("input[name=odChubcnt]").val().replace(/[^0-9]/g,"")));
	}
	//팩수 
	if($.isNumeric($("input[name=odPackcnt]").val())==false)
	{
		$("input[name=odPackcnt]").val(Number($("input[name=odPackcnt]").val().replace(/[^0-9]/g,"")));
	}
	//팩용량 
	if($.isNumeric($("input[name=odPackcapa]").val())==false)
	{
		$("input[name=odPackcapa]").val(Number($("input[name=odPackcapa]").val().replace(/[^0-9]/g,"")));
	}
	
	var tdmedi=$("input:checkbox[id='tdMedi']").is(":checked");//약재 체크 
	var odGoods=$("input[name=odGoods]").val();
	console.log("DOO:: 약재체크 ===> "+tdmedi);
	console.log("DOO:: odGoods ===> "+odGoods);


	//-------------------------------------------------------------------------------
	//20190917 : 한의원등급
	//-------------------------------------------------------------------------------
	var miGrade=$("input[name=miGrade]").val();
	miGrade=chkGrade(miGrade);
	//-------------------------------------------------------------------------------
	//20190917 : 조제비,탕전비,배송비
	//-------------------------------------------------------------------------------
	//조제비 
	db_making=getConfigPrice("making", miGrade);
	//탕전비
	db_decoction=getConfigPrice("decoction", miGrade);
	//배송비 
	db_deliprice=getConfigPrice("release", miGrade);
	//포장비 
	db_packingprice=getConfigPrice("packing", miGrade);
	//선전비 
	db_firstprice=getConfigPrice("first", miGrade);
	//후하비  
	db_afterprice=getConfigPrice("after", miGrade);
	db_cheobprice=getConfigPrice("cheob", miGrade);

	$("input[name=maPrice]").val(db_making);
	$("input[name=dcPrice]").val(db_decoction);
	$("input[name=rePrice]").val(db_deliprice);

	$("input[name=packPrice]").val(db_packingprice);
	$("input[name=firstPrice]").val(db_firstprice);
	$("input[name=afterPrice]").val(db_afterprice);


	if(tdmedi==true)
	{
		$("input[name=odGoods]").val("M");
		$("input[name=rePrice]").val(db_cheobprice);
		$("input[name=dcPrice]").val("0");
	}
	else
	{
		odGoods=isEmpty(odGoods)?"N":odGoods;
		$("input[name=odGoods]").val(odGoods);
		$("input[name=rePrice]").val(db_deliprice);
		$("input[name=dcPrice]").val(db_decoction);
	}


	console.log("db_packingprice = " + db_packingprice);
	console.log("db_firstprice = " + db_firstprice);
	console.log("db_afterprice = " + db_afterprice);
	console.log("db_cheobprice = " + db_cheobprice);
	

	//-------------------------------------------------------------------------------
	//201909017 : 선택된 한약박스의 용량을 가져오자!!!
	db_boxmedibox=$("input:radio[name=reBoxmedi]:checked").data("capa");
	$("input[name=reBoxmedibox]").val(db_boxmedibox);
	console.log("DOO ====> db_boxmedibox = " + db_boxmedibox);
	//-------------------------------------------------------------------------------
	console.log("DOO ====> miGrade = "+miGrade+", db_making = "+db_making+", db_decoction = "+db_decoction+", db_deliprice = "+db_deliprice+", db_boxmedibox = " + db_boxmedibox);

	//조제타입
	var type = $('input:radio[name="maType"]:checked').val();

	//-------------------------------------------------------------------------------
	//20190917 : 파우치, 한약박스, 배송포장 레벨에 따른 가격 가져오기 
	//-------------------------------------------------------------------------------
	//파우치 가격
	p1 = getPackPrice("odPacktype", miGrade);
	if(isEmpty(packprice))
	{
		$("input[name=odPackprice]").val(p1);
	}
	//한약박스 가격 
	p2 = getPackPrice("reBoxmedi", miGrade);
	//배송포장 가격 
	p3 = getPackPrice("reBoxdeli", miGrade);
	console.log("DOO ====> p1 = "+p1+", p2 = "+p2+", p3 = "+p3);
	//-------------------------------------------------------------------------------

	
	//-------------------------------------------------------------------------------
	// 입력받은 첩수,팩수,팩용량
	//-------------------------------------------------------------------------------
	//첩수
	chubcnt=parseFloat($("input[name=odChubcnt]").val());
	//팩수
	packcnt=parseFloat($("input[name=odPackcnt]").val());
	//팩용량
	packcapa=parseFloat($("input[name=odPackcapa]").val());
	//20190826 11:11 분에 수정
	//입력받은 팩수에 + 4 해야함. (1개는 버리고 3개는 보관용)
	packaddcnt = parseInt($("input[name=packaddcnt]").val());
	//-------------------------------------------------------------------------------
	chubcnt = ((isNaN(chubcnt)==false)) ? parseFloat(chubcnt):0;
	packcnt = ((isNaN(packcnt)==false)) ? parseFloat(packcnt):0;
	packcapa = ((isNaN(packcapa)==false)) ? parseFloat(packcapa):0;
	//-------------------------------------------------------------------------------
	var mgrade=miGrade.toLowerCase();
	//첩당
	$(".chubamt").each(function(){
		//-------------------------------------------------------------------------------
		// 총약재
		//-------------------------------------------------------------------------------
		tval = parseFloat($(this).val());//첩당약재
		tval=((isNaN(tval)==false)) ? tval:0;
		mediamt= tval * parseFloat(chubcnt);//첩당약재 * 첩수 = 총약재
		//$(this).parent().next().children("input").val(commasFixed(mediamt));//총약재 input box
		$(this).parent().next().children("span").text(commasFixed(mediamt));//총약재 input box
		//-------------------------------------------------------------------------------
		//약재가 부족하면 현재약재량을 빨간색으로 바꾼다.
		var totalqty = $(this).parent().children("#id_total_qty").val();
		//console.log("totalqty : " + totalqty);
		if(parseFloat(totalqty) < parseFloat(mediamt) || (parseFloat(totalqty) == 0))
		{
			$(this).parent().prev().css('color','red');
			$(this).parent().prev().css('font-weight','bolder');
			$(this).parent().prev().css('font-size','15px');
		}

		//-------------------------------------------------------------------------------
		//20190917 : 약재별 한의원 등급에  따른 약재비 계산 
		//-------------------------------------------------------------------------------
		tprice=getMediPrice($(this).parent().next().next().children("span"), miGrade);
		$(this).parent().next().next().children("span").text(tprice);
		mdprice = (mediamt * parseFloat(tprice));//총약재 * 1g당약재비 = 총약재비 ---- 반올림
		$(this).parent().next().next().next().children("span").text(commasFixed(mdprice));//총약재비 input box
		//-------------------------------------------------------------------------------

		//-------------------------------------------------------------------------------
		//흡수율 계산
		//-------------------------------------------------------------------------------
		twater = $(this).parent().children("#id_water").val();//해당약재 흡수율
		twater = ((isNaN(twater)==false)) ? twater:0;
		mdwater = (parseFloat(mediamt) * parseFloat(twater))/100; // (총약재*흡수율) 나누기 100
		//-------------------------------------------------------------------------------
		chubprice=(tval*tprice);
		chubpricetotal+=chubprice;
		chubtotal+=tval;//첩당무게 토탈
		meditotal+=mediamt;//총약재 토탈
		medipricetotal+=mdprice;//총약재비 토탈
		watertotal+=mdwater;//총물량 토탈
		pricetotal+=tprice;//1g당 약재비


		console.log("흡수율 총약재 = "+mediamt+", 흡수율 = " + twater+", mdwater = " + mdwater+", watertotal = " + watertotal);

	});

	//-------------------------------------------------------------------------------
	// sweet 계산
	//-------------------------------------------------------------------------------
	var tsweetval=tsweettype=sweettotal=sweetcnt=stprice=smdprice=stwater=smdwater=0;
	schubtotal=0;
	sweetpricetotal=0;
	var sweetdata="";
	$(".schubamt").each(function() {

		tsweetval = parseFloat($(this).val());//첩당약재
		$(this).parent().next().children("span").text(commasFixed(tsweetval));//총약재 input box

		//-------------------------------------------------------------------------------
		// 20190917 : 별전 한의원 등급별로 약재비 계산 
		//-------------------------------------------------------------------------------
		stprice=getMediPrice($(this).parent().next().next().children("span"), miGrade);
		$(this).parent().next().next().children("span").text(stprice);
		smdprice = (tsweetval * parseFloat(stprice));//총약재 * 1g당약재비 = 총약재비 ---- 반올림
		$(this).parent().next().next().next().children("span").text(commasFixed(smdprice));//총약재비 input box
		//-------------------------------------------------------------------------------

		//-------------------------------------------------------------------------------
		//흡수율 계산
		//-------------------------------------------------------------------------------
		stwater = $(this).parent().children("#id_water").val();//해당약재 흡수율
		stwater = ((isNaN(stwater)==false)) ? stwater:0;
		smdwater = (parseFloat(tsweetval) * parseFloat(stwater))/100; // (총약재*흡수율) 나누기 100
		//-------------------------------------------------------------------------------

		watertotal+=smdwater;//총물량 토탈
		schubtotal+=tsweetval;

		sweetpricetotal+=smdprice;

		var name=$(this).parent().prev().prev().prev().prev().prev().children("td b").text();

		sweetdata+="|"+name+","+tsweetval+","+stprice+","+smdprice;

		console.log("흡수율 총별전 = "+tsweetval+", 흡수율 = " + stwater+", smdwater = " + smdwater+", watertotal = " + watertotal+", name = " + name);

	});
	//-------------------------------------------------------------------------------


	//-------------------------------------------------------------------------------
	//탕전물량 
	//-------------------------------------------------------------------------------
	var dcTime=$("input[name=dcTime]").val();
	var dooWater=calcDcWater(dcTime, watertotal, packcnt, packcapa);
	
	var dc_special=$("#dcSpecial option:selected").val();
	console.log("resetamount  dc_special = " + dc_special);
	if(dc_special=="spdecoc03")
	{
		var water=calcWaterAlcohol(dooWater);//parseInt((totwater - ( totwater * 0.1)) / 10) * 10;
		var alcohol=dooWater - water;
		$("input[name=dcWater]").val(comma(water));
		$("input[name=dcAlcohol]").val(comma(alcohol));
	}
	else
	{
		$("input[name=dcWater]").val(comma(dooWater));
		$("input[name=dcAlcohol]").val(0);
	}


	//-------------------------------------------------------------------------------
	console.log("watertotal = "+watertotal+", dcTime = " + dcTime + ", packcnt = "+packcnt+", packcapa = "+packcapa);

	$("#chubtotal").text(commasFixed(chubtotal));//첩당무게 토탈
	$("#schubtotal").text(commasFixed(schubtotal));//첩당무게 토탈
	$("#meditotal").text(commasFixed(meditotal));//총약재 토탈
	$("#pricetotal").text(commasFixed(medipricetotal + sweetpricetotal));//총약재비 토탈


	var dcSugarPrice=$('input:radio[name="dcSugar"]:checked').data("price");
	var dcSugarUsage=$('input:radio[name="dcSugar"]:checked').data("usage");
	dcSugarPrice=(!isEmpty(dcSugarPrice)) ? parseFloat(dcSugarPrice) : 0;
	dcSugarUsage=(!isEmpty(dcSugarUsage)) ? parseFloat(dcSugarUsage) : 0;
	var dcSugar=parseInt(dcSugarPrice*dcSugarUsage);		

	//-------------------------------------------------------------------------------
	//약재비 : 약재비, 감미제(앰플), 녹용(앰플), 자하거(앰플) (ㅇ)
	//-------------------------------------------------------------------------------
	//최종 총약재비 : 약재비 + 감미제 + 녹용 + 자하거
	totalmediprice = medipricetotal + sweetpricetotal + dcSugar;
	data=commasFixed(totalmediprice)+getTxtData("UNIT");
	$("#tot_meditotalprice").html(data);

	amountdjmedi["medicine"]=chubpricetotal+","+chubcnt+","+medipricetotal;//약재비 
	amountdjmedi["sweet"]=sweetdata;//별전 
	amountdjmedi["sugar"]=dcSugarUsage+","+dcSugarPrice+","+dcSugar;//감미제 
	amountdjmedi["totalmedicine"]=totalmediprice;//토탈약재비  


	//-------------------------------------------------------------------------------
	//20190917 : 탕전비 계산 => 용량에 상관없이 Class 적용됨 공식은 약재비와 같음
	//-------------------------------------------------------------------------------
	var decoctionprice=0;
	if(tdmedi==true)
	{
		data=commasFixed(decoctionprice)+getTxtData("UNIT");//
		$("#tot_decoctionprice").html(data);
		data=commasFixed(decoctionprice)+getTxtData("UNIT");
		$("#tot_decoctiontotalprice").html(data);
		amountdjmedi["decoction"]=decoctionprice+",1,"+decoctionprice;//탕전비 
	}
	else
	{
		decoctionprice = db_decoction;
		data=commasFixed(db_decoction)+getTxtData("UNIT");//
		$("#tot_decoctionprice").html(data);
		data=commasFixed(decoctionprice)+getTxtData("UNIT");
		$("#tot_decoctiontotalprice").html(data);
		amountdjmedi["decoction"]=db_decoction+",1,"+decoctionprice;//탕전비 
	}
	//-------------------------------------------------------------------------------

	var rcDecoctypetxt="";
	$(".rcDecoctype").each(function(){

		rcDecoctypetxt+=($(this).val().trim())+",";
	});
	console.log("rcDecoctypetxt = " + rcDecoctypetxt);

	//-------------------------------------------------------------------------------
	//20190917 : 조제비 계산 => 팩수 * 조제비 적용
	//-------------------------------------------------------------------------------
	var makingprice = parseFloat(packcnt) * parseFloat(db_making); //조제비  * 팩수

	var inafter=infirst=0;
	if (rcDecoctypetxt.indexOf("infirst") != -1) 
	{
		infirst=db_firstprice;
		console.log("infirst = " + infirst);
	}
	if (rcDecoctypetxt.indexOf("inafter") != -1) 
	{
		inafter=db_afterprice;	
		console.log("inafter = " + inafter);
	}


	amountdjmedi["makingprice"]=db_making+","+packcnt+","+makingprice;
	amountdjmedi["infirst"]=infirst+",1,"+infirst;
	amountdjmedi["inafter"]=inafter+",1,"+inafter;
	var totalmaking=makingprice+infirst+inafter;
	amountdjmedi["making"]=totalmaking;//조제비 
	//-------------------------------------------------------------------------------

	//-------------------------------------------------------------------------------
	//20190917 : 파우치, 한약박스 계산 => 수량에 상관없이 적용됨 * 1
	//-------------------------------------------------------------------------------
	var pmdcnt=1;//수량에 상관없이 하기때문에 기본1로 셋팅 
	var packp = parseFloat(p1);//파우치
	var mediboxp = parseFloat(p2);//한약박스
	var deliboxp = parseFloat(p3);//배송박스 

	var matype = $('input:radio[name="maType"]:checked').val();
	var dcShapeDesc=0;
	if(matype=="pill")
	{
		//제형이 금박지이면 
		dcShapeDesc=$('input:radio[name="dcShape"]:checked').data("desc");
		dcShapeDesc=(!isEmpty(dcShapeDesc)) ? parseInt(dcShapeDesc) : 0;
	}
	console.log("dcShapeDesc == "+ dcShapeDesc);

	var packingp=parseFloat(db_packingprice);


	packprice = packp + mediboxp + deliboxp + dcShapeDesc + packingp;
	//포장비 선택목록을 삭제하면서 추가한부분임
	if(isNaN(packprice)){packprice=0;}

	if(tdmedi==true)
	{
		data="0"+getTxtData("UNIT");
	}
	else
	{
		data=commasFixed(packprice)+getTxtData("UNIT");
	}

	amountdjmedi["poutch"]=p1+","+pmdcnt+","+packp;//파우치 
	amountdjmedi["medibox"]=p2+","+pmdcnt+","+mediboxp;//한약박스
	amountdjmedi["delibox"]=p3+","+pmdcnt+","+deliboxp;//배송박스
	amountdjmedi["dcshape"]=dcShapeDesc+",1,"+dcShapeDesc;//금박지 
	if(tdmedi==true)
	{
		amountdjmedi["packing"]="0,1,0";//포장비 
	}
	else
	{
		amountdjmedi["packing"]=packingp+",1,"+packingp;//포장비 
	}
	amountdjmedi["totalpack"]=packprice;//토탈포장비 

	$("#tot_packingtotalprice").html(data);//포장비
	//-------------------------------------------------------------------------------


	//-------------------------------------------------------------------------------
	//20190917 : 배송비 계산 => 배송비는 약재박스 단위로 계산하는데 2개당 하나의 송장이 부착 1개일때 - 송장한개, 2개일때  송장한개, 3개일일때 송장 2개...
	//-------------------------------------------------------------------------------
	if(tdmedi==true)
	{
		boxcnt=1;
		boxprice=db_cheobprice*boxcnt
		console.log("DOO ====> packcnt = "+packcnt+", db_boxmedibox = "+db_boxmedibox+", boxmax = " + boxmax+", boxcnt = " + boxcnt);
		data=commasFixed(db_cheobprice)+getTxtData("UNIT")+" * "+boxcnt+"ea";
		$("#tot_releaseprice").html(data);
		data=commasFixed(boxprice)+getTxtData("UNIT");
		$("#tot_releasetotalprice").html(data);
		amountdjmedi["release"]=db_cheobprice+","+boxcnt+","+boxprice;//배송비 
	}
	else
	{
		var boxmax = Math.ceil(packcnt / db_boxmedibox);//올림 
		boxcnt=Math.ceil(boxmax/2);
		boxprice=db_deliprice*boxcnt
		console.log("DOO ====> packcnt = "+packcnt+", db_boxmedibox = "+db_boxmedibox+", boxmax = " + boxmax+", boxcnt = " + boxcnt);
		data=commasFixed(db_deliprice)+getTxtData("UNIT")+" * "+boxcnt+"ea";
		$("#tot_releaseprice").html(data);
		data=commasFixed(boxprice)+getTxtData("UNIT");
		$("#tot_releasetotalprice").html(data);
		amountdjmedi["release"]=db_deliprice+","+boxcnt+","+boxprice;//배송비 
	}

	//-------------------------------------------------------------------------------

	//-------------------------------------------------------------------------------
	//주문금액
	//-------------------------------------------------------------------------------
	odAmount = totalmediprice + decoctionprice + totalmaking + packprice + boxprice;
	//10원단위 
	odAmount=Math.floor(odAmount/10)*10;
	$("#td_total_price").text(commasFixed(odAmount));
	$("input[name=odAmount]").val(odAmount);//seq //Math.floor(tdprice/10)*10; 1원단위는 버림
	//-------------------------------------------------------------------------------
	

	amountdjmedi["totalamount"]=odAmount;//총주문금액 
		

	$("textarea[name=odAmountdjmedi]").val(JSON.stringify(amountdjmedi));


	setAmountDjmedi();
}
function setAmountDjmedi()
{
	var data="";
	if(!isEmpty($("textarea[name=odAmountdjmedi]").val()))
	{
		var adjmedi=JSON.parse($("textarea[name=odAmountdjmedi]").val());
		//-----------------------------------------------------------
		//약재비 
		var medicinearr=adjmedi["medicine"].split(",");//medicine":"28828.8,1,28828.8","sweet":"0,0,0","sugar":"0,0,0",
		var sweetarr=adjmedi["sweet"].split("|");
		var sugararr=adjmedi["sugar"].split(",");
		var totalmedicine=adjmedi["totalmedicine"];//약재비 
		//-----------------------------------------------------------	
		//약재비
		data="<div class='table_style'>";
		data+="<ul>";
		data+="<li class='left'>약재비 </li><li>"+commasFixed(medicinearr[0])+getTxtData("UNIT")+" * "+commasFixed(medicinearr[1])+"첩  = "+commasFixed(medicinearr[2])+" "+getTxtData("UNIT")+"</li>";
		data+="</ul>";
		//console.log(adjmedi);
		var sweetarr2;
		if(sweetarr.length > 0)
		{
			for(i=1;i<sweetarr.length;i++)
			{
				sweetarr2=sweetarr[i].split(",");
				//별전
				data+="<ul>";
				data+="<li class='left'>"+sweetarr2[0]+"</li><li>"+sweetarr2[1]+"ml * "+commasFixed(sweetarr2[2])+getTxtData("UNIT")+" = "+commasFixed(sweetarr2[3])+getTxtData("UNIT")+"</li>";
				data+="</ul>";
			}
		}
		//감미제 
		if(parseFloat(sugararr[2]) > 0)
		{
			data+="<ul>";
			data+="<li class='left'>감미제 </li><li> "+sugararr[0]+" g * "+sugararr[1]+" "+getTxtData("UNIT")+" </li>";
			data+="</ul>";
		}
		data+="</div>";
		$("#tot_mediprice").html(data);
		data=comma(setPriceFloor(totalmedicine))+getTxtData("UNIT");
		$("#tot_meditotalprice").html(data);
		//-----------------------------------------------------------

		//-----------------------------------------------------------
		//20190917 : 탕전비 수정 
		//-----------------------------------------------------------
		var decoctionarr=adjmedi["decoction"].split(",");//탕전비
		data=decoctionarr[0]+getTxtData("UNIT");
		$("#tot_decoctionprice").html(data);
		data=comma(setPriceFloor(decoctionarr[2]))+getTxtData("UNIT");
		$("#tot_decoctiontotalprice").html(data);
		//-----------------------------------------------------------

		//-----------------------------------------------------------
		//20190917 : 조제비 수정 
		//-----------------------------------------------------------
		var makingarr=adjmedi["makingprice"].split(",");//조제비
		var infirstarr=adjmedi["infirst"].split(",");//선전비
		var inafterarr=adjmedi["inafter"].split(",");//후하비 
		var totalmaking=adjmedi["making"];//포장비
		//-----------------------------------------------------------
		data="<div class='table_style'>";
		if(parseFloat(makingarr[2])>0)
		{
			data+="<ul>";
			data+="<li class='left'>조제비  </li><li> "+commasFixed(makingarr[0])+getTxtData("UNIT")+" * "+commasFixed(makingarr[1])+"ea = "+commasFixed(makingarr[2])+" "+getTxtData("UNIT")+"</li>";//배송포장재
			data+="</ul>";
		}
		if(parseFloat(infirstarr[2])>0)
		{
			data+="<ul>";
			data+="<li class='left'>선전비  </li><li> "+commasFixed(infirstarr[0])+getTxtData("UNIT")+" </li>";//배송포장재
			data+="</ul>";
		}
		if(parseFloat(inafterarr[2])>0)
		{
			data+="<ul>";
			data+="<li class='left'>후하비  </li><li> "+commasFixed(inafterarr[0])+getTxtData("UNIT")+"</li>";//배송포장재
			data+="</ul>";
		}
		data+="</div>";
		$("#tot_makingprice").html(data);

		data=comma(setPriceFloor(totalmaking))+getTxtData("UNIT");
		$("#tot_makingtotalprice").html(data);//포장비
		//-----------------------------------------------------------

		//-----------------------------------------------------------
		//포장비 
		//-----------------------------------------------------------
		var poutcharr=adjmedi["poutch"].split(",");
		var mediboxarr=adjmedi["medibox"].split(",");
		var deliboxarr=adjmedi["delibox"].split(",");
		var packingarr=adjmedi["packing"].split(",");
		var dcshapearr=(!isEmpty(adjmedi["dcshape"])) ? adjmedi["dcshape"].split(",") : "";
		var totalpack=adjmedi["totalpack"];//포장비

		data="<div class='table_style'>";
		if(parseFloat(poutcharr[2])>0)
		{
			data+="<ul>";
			data+="<li class='left'>파우치 </li><li>"+(poutcharr[2])+getTxtData("UNIT")+"</li>";//파우치가격 
			data+="</ul>";
		}
		if(parseFloat(mediboxarr[2])>0)
		{
			data+="<ul>";
			data+="<li class='left'>한약박스  </li><li> "+(mediboxarr[2])+getTxtData("UNIT")+"</li>";//한약박스가격
			data+="</ul>";
		}
		if(parseFloat(deliboxarr[2])>0)
		{
			data+="<ul>";
			data+="<li class='left'>배송포장재  </li><li> "+(deliboxarr[0])+getTxtData("UNIT")+" * "+(deliboxarr[1])+"ea </li>";//배송포장재
			data+="</ul>";
		}
		if(parseFloat(dcshapearr[2])>0)
		{
			data+="<ul>";
			data+="<li class='left'>금박지  </li><li> "+(dcshapearr[2])+getTxtData("UNIT")+"</li>";//금박지
			data+="</ul>";
		}
		if(parseFloat(packingarr[2])>0)
		{
			data+="<ul>";
			data+="<li class='left'>포장비  </li><li> "+(packingarr[2])+getTxtData("UNIT")+"</li>";//포장비
			data+="</ul>";
		}
		data+="</div>";
		$("#tot_packingprice").html(data);

 
		data=comma(setPriceFloor(totalpack))+getTxtData("UNIT");
		$("#tot_packingtotalprice").html(data);//포장비
		//-----------------------------------------------------------

		//-----------------------------------------------------------
		//배송비 
		//-----------------------------------------------------------
		var releasearr=adjmedi["release"].split(",");// 
		data=(releasearr[0])+getTxtData("UNIT")+" * "+releasearr[1]+"ea = " + comma(setPriceFloor(releasearr[2]))+getTxtData("UNIT");
		$("#tot_releaseprice").html(data);
		data=comma(setPriceFloor(releasearr[2]))+getTxtData("UNIT");
		$("#tot_releasetotalprice").html(data);
		//-----------------------------------------------------------

		//-----------------------------------------------------------
		//주문금액
		//-----------------------------------------------------------
		var totalamount=adjmedi["totalamount"];//주문금액
		$("#td_total_price").text(comma(setPriceFloor(totalamount)));
		//-----------------------------------------------------------
	}
}
///파우치, 한약박스종류선택, 배송포장재종류
function parsepackcodes(pgid, list, title, name, data, price, text, readonly)
{
	var allstr = opstr = pricestr=imgstr = checked = disable = path = opprice="";
	var i=selprice=0;
	disable = (readonly == 'readonly') ? "disabled='disabled'" : "";
	opstr = "";
	price=isEmpty(price) ? 0 : price;
	var miGrade=$("input[name=miGrade]").val();
	miGrade=chkGrade(miGrade);

	for(var key in list)
	{
		checked = "";
		if(i == 0)
		{
			checked = "checked";
			selprice=list[key]["pbPrice"+miGrade];
		}
		if(!isEmpty(data))
		{
			if(data == list[key]["pbCode"])
			{
				checked = "checked";
				selprice=list[key]["pbPrice"+miGrade];
			}
		}


		opprice=" data-priceA="+list[key]["pbPriceA"]+" data-priceB="+list[key]["pbPriceB"]+" data-priceC="+list[key]["pbPriceC"]+" data-priceD="+list[key]["pbPriceD"]+" data-priceE="+list[key]["pbPriceE"];

		opstr += '<li>';
		opstr += '<p class="check-box" onchange="changepackcode()">';
		opstr += '<input type="radio" id="pack-'+name+'-'+i+'" name="'+name+'" value="'+list[key]["pbCode"]+'" class="radiodata"  data-capa="'+list[key]["pbCapa"]+'" '+opprice+' '+checked+' '+disable+'/>';
		opstr += '<label for="pack-'+name+'-'+i+'">';
		if(!isEmpty(list[key]["afThumbUrl"]) && list[key]["afThumbUrl"]!="NoIMG")
		{
			
			if(list[key]["afThumbUrl"].substring(0,4)=="http")
			{
				opstr += '<img src="'+list[key]["afThumbUrl"]+'" onerror="this.src=\'/_Img/Content/noimg.png\'" />';
			}
			else
			{
				opstr += '<img src="'+getUrlData("FILE_DOMAIN")+list[key]["afThumbUrl"]+'" onerror="this.src=\'/_Img/Content/noimg.png\'" />';
			}
		}
		else
		{
			opstr += '<img src="/_Img/Content/noimg.png" alt=""/>';
		}
			
		opstr += '<span class="btxt">'+list[key]["pbTitle"]+'</span>';
		opstr += '</label>';
		opstr += '</p>';
		opstr += '</li>';
		i++;
	}

	selprice=(parseInt(price)<=0) ? selprice : price;
	pricestr='';
	if(name=='reBoxmedi')
	{
		pricestr = '<input type="hidden" name="reBoxmediprice" class="reqdata" value="'+selprice+'">';
	}
	else if(name=='reBoxdeli')
	{
		pricestr = '<input type="hidden" name="reBoxdeliprice" class="reqdata" value="'+selprice+'">';
	}
	allstr="";
	allstr = '<ul class="pack-list11">';
	allstr += pricestr;
	allstr += opstr;
	allstr += '</ul>';



	$("#"+pgid).html(allstr);
}
function maTypeSetting(type, jsondata)
{
	switch(type)
	{
	case "decoction": case "worthy": case "goods": case "commercial"://20191108:실속,약속,상비 추가 
		jsondata["dcShape"]="";
		jsondata["dcBinders"]="";
		jsondata["dcFineness"]="";
		//jsondata["edcFineness"]="";
		
		//jsondata["dcTerms"]="";

		jsondata["dcMillingloss"]="0";
		jsondata["dcLossjewan"]="0";
		jsondata["dcBindersliang"]="0";
		jsondata["dcCompleteliang"]="0";
		jsondata["dcCompletecnt"]="0";

		//jsondata["dcJungtang"]="";
		//jsondata["dcRipen"]="0";
		jsondata["dcDry"]="0";
		break;
	case "pill":
		//jsondata["dcTitle"]="";
		//jsondata["dcSpecial"]="";

		//jsondata["dcJungtang"]="";
		//jsondata["dcRipen"]="0";
		//jsondata["edcFineness"]="";
		break;
	}
	return jsondata;
}
//파우치,한약박스,배송포장 선택시
function changepackcode()
{
	var odPackprice=odPackcapa=reBoxmediprice=reBoxdeliprice=0;
	var miGrade=$("input[name=miGrade]").val();
	miGrade=chkGrade(miGrade);
	miGrade=miGrade.toLowerCase();

	var type = $('input:radio[name="maType"]:checked').val();

	//20190917 : 파우치,한약박스,배송포장 선택할때마다 한의원 레벨에 따라 
	odPackcapa=$("input:radio[name=odPacktype]:checked").data("capa");
	odPackprice=$("input:radio[name=odPacktype]:checked").data("price"+miGrade);
	
	//한약박스 가격
	reBoxmediprice=$("input:radio[name=reBoxmedi]:checked").data("price"+miGrade);
	//배송포장 가격 
	reBoxdeliprice=$("input:radio[name=reBoxdeli]:checked").data("price"+miGrade);

	var seq=$("input[name=seq]").val();
	if(isEmpty(seq))
	{
		$("input[name=odPackcapa]").val(odPackcapa);//odPackcapa
	}

	$("input[name=odPackprice]").val(odPackprice);//odPackprice
	$("input[name=reBoxmediprice]").val(reBoxmediprice);//reBoxmediprice
	$("input[name=reBoxdeliprice]").val(reBoxdeliprice);//reBoxdeliprice

	console.log("changepackcodechangepackcodechangepackcodechangepackcodechangepackcode");
	resetamount();
	resetmedi();
}
function getMediPrice(medi, grade)
{
	grade=chkGrade(grade);//등급 
	grade=grade.toLowerCase();

	//처방내릴때 등록된 가격 
	var sprice=medi.data("price");
	var gprice=medi.data("price"+grade);
	var lgprice=(parseFloat(gprice)<0)?medi.data("pricee"):gprice;
	var tprice=!isEmpty(sprice) ? sprice : lgprice;

	tprice=((isNaN(tprice)==false)) ? parseFloat(tprice):0;

	//console.log("DOO ====> getMediPrice  grade= "+grade+", sprice = " + sprice+", gprice = " + gprice+", lgprice = "+lgprice+", tprice = " +tprice );
	return tprice;
}

function chkGrade(grade)
{
	grade=!isEmpty(grade) ? grade : "E";

	if(grade=="A" || grade=="B" || grade=="C" || grade=="D" || grade=="E")
	{
		return grade.toUpperCase();
	}
	else
	{
		return "E";
	}
}
function getMediGradePrice(grade, price, pricee)
{
	var lgprice=0;
	if(!isEmpty(grade))
	{
		lgprice=(parseFloat(price)<0) ? pricee : price;
	}
	else
	{
		lgprice=pricee;
	}
	return lgprice;
}
function checkMedicine(rcmedicode)
{
	if(rcmedicode.indexOf("*") > -1) //포함되어있따면 
	{
		return false;
	}
	return true;
}
function noneMediUpdate(medicine, medititle)
{
	var odKeycode=$("input[name=odKeycode]").val();
	var medi=medicine.replace("*", "");
	var site=$("input[name=odSitecategory]").val();
	var url="odKeycode="+odKeycode+"&medicine="+medi+"&medititle="+medititle+"&site="+site;
	console.log("url = " + url);
	callapi('GET','medicine','nonemedicine',url);
}

//독성,상극 체크하여 알림창 보여주기
function checkPoisonDismatch()
{
	var pd="";
	var dismatch=poison=0;

	$(".dispoison").each(function(){
		pd=$(this).val().trim();
		if(pd == "dismatch")
		{
			dismatch++;
		}
		if(pd=="poison")
		{
			poison++;
		}
	});

	if((parseInt(dismatch)>0) || (parseInt(poison)>0))//상극,독성
	{
		if((parseInt(dismatch)>0) && (parseInt(poison)>0))
			alertsign("error", getTxtData("1722"), "", "2000");//독성,상극 약재가 있습니다.
		else if((parseInt(dismatch)>0))
			alertsign("error", getTxtData("1721"), "", "2000");//상극 약재가 있습니다.
		else if((parseInt(poison)>0))
			alertsign("error", getTxtData("1720"), "", "2000");//독성 약재가 있습니다.
	}
}
function parseDivTable(titleTxt, content)
{
	var data = "";
	data+='<h3 class="u-tit02">'+titleTxt+'</h3>';
	data+='<div class="board-view-wrap">';
	data+='	<table>';
	data+='		<colgroup>';
	data+='			<col width="15%">';
	data+='			<col width="30%">';
	data+='			<col width="*">';
	data+='		</colgroup>';
	data+='		<tbody>';
	data+='			<tr style="border-top: 1px solid #e3e3e4;">';
	data+='				<th><span>'+titleTxt+'</span></th>';
	data+='				<td><span>'+content+'</span></td>';
	data+='			</tr>';
	data+='	 </tbody>';
	data+='	</table>';
	data+='</div>';
	return data;
}
//마킹 
function parsemarkingcodes(pgid, list, title, name, type, data, readonly)
{
	var radiostr = idstr = checked = disable = "";
	var i = 0;

	disable = (readonly == 'readonly') ? "disabled='disabled'" : "";

	for(var key in list)
	{
		idstr = "0" + i;
		idstr = idstr.slice(-2);
		checked = "";
		if(!isEmpty(data))
		{
			if(data == list[key]["cdCode"])
				checked = ' checked="checked"';
		}
		else if(i == 0)
		{
			checked = ' checked="checked"';
		}

		radiostr += '<li>';
		radiostr += '	<p class="radio-box">';
		radiostr += '		<input type="radio"  name="'+name+'" class="radiodata" id="marking-'+idstr+'" value="'+list[key]["cdCode"]+'" '+checked+' '+disable+'>';
		radiostr += '		<label for="marking-'+idstr+'">'+list[key]["cdName"]+'</label>';
		radiostr += '	</p>';
		radiostr += '	<div>';
		radiostr += '		<p class="btxt">'+list[key]["cdDesc"]+'</p>';
		radiostr += '	</div>';
		radiostr += '</li>';

		i++;

	}

	$("#"+pgid).html(radiostr);
}