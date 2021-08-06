<?php
	$root="..";
	include_once $root."/_Inc/head.php";
?>
<script src="<?=$root?>/Skin/Order/_js.order.200826.js"></script>
<?php
	$jsondata='{"apiCode":"orderregist","language":"kor","orderInfo":[{"keycode":"","orderCode":"'.$_COOKIE["od_ordercode"].'","orderDate":"","deliveryDate":"","medicalCode":"","medicalName":"","doctorCode":"","doctorName":"","orderTitle":"","orderTypeCode":"decoction","orderType":"","orderCount":"1","productCode":"","productCodeName":"","orderComment":"","orderAdvice":".","orderStatus":"temp"}],"patientInfo":[{"patientCode":"","patientName":"","patientGender":"","patientBirth":"","patientPhone":""}],"recipeInfo":[{"chubCnt":"","packCnt":"","packCapa":"","totalMedicine":[{"mediType":"","mediCode":"","mediName":"","mediPoison":"","mediDismatch":"","mediOrigin":"","mediOriginTxt":"","mediCapa":"","mediAmount":""}],"sweetMedi":[{"sweetCode":"","sweetName":"","sweetCapa":""}],"sugarMedi":[{"sugarCode":"","sugarName":"","sugarCapa":""}]}],"decoctionInfo":[{"specialDecoc":"","specialDecoctxt":""}],"markingInfo":[{"markType":"","markText":""}],"packageInfo":[{"packType":"","packCode":"","packName":"","packImage":"","packAmount":""}],"deliveryInfo":[{"deliType":"","sendName":"","sendPhone":"","sendMobile":"","sendZipcode":"","sendAddress":"","sendAddressDesc":"","receiveName":"","receivePhone":"","receiveMobile":"","receiveZipcode":"","receiveAddress":"","receiveAddressDesc":"","receiveComment":"","receiveTied":""}],"paymentInfo":[{"amountTotal":"","amountMedicine":"","amountAddmedi":"","amountSugar":"","amountPharmacy":"","amountDecoction":"","amountPackaging":"","amountDelivery":""}],"adviceInfo":[{"foodAdvice":"","cautionAdvice":"","foodAdvicFree":"","cautionAdviceFree":""}],"labelInfo":[{"wardNo":"","roomNo":"","bedNo":"","mediDays":"","mediType":"","mediCapa":"","mediName":"","mediAdvice":""}]}';
?>
<textarea name="keycode"  style="display:none;"></textarea>
<textarea name="join_jsondata" style="display:none;"><?=$jsondata?></textarea>

<input type="hidden" name="medicalseq" class="ajaxdata" value="<?=$_GET["seq"]?>">
<input type="hidden" name="medicalkeycode" class="ajaxdata" value="">

<div id="listdiv"></div>

<script>
	function getlist(type, search)
	{
		var sear=searchdata(search);
		callapi("GET","/medical/order/",getdata("orderlist")+"&pagetype="+type+sear);
	}
	function getmylist(search)
	{
		var sear=searchdata(search);
		var meUserId=getCookie("ck_meUserId");//한의사ID
		var medicalId=getCookie("ck_miUserid");//한의원ID
		callapi("GET","/medical/recipe/",getdata("myrecipelist")+"&medicalId="+medicalId+"&meUserId="+meUserId+sear);
	}
	function getrecommendlist(search)
	{
		var sear=searchdata(search);
		callapi("GET","/medical/recipe/",getdata("recommendlist")+sear);
	}
	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage();
	}
	
	viewpage();  //첫페이지

	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		var type=hdata[1];
		var seq=!isEmpty(hdata[2])?hdata[2]:"";
		var search=!isEmpty(hdata[3])?hdata[3]:"";

		console.log("######### Potion viewpage page=  "+page+", type = " + type + ", seq = " + seq);

		if(type=="next")
		{
			$("#listdiv").load("<?=$root?>/Skin/Order/PotionNextWrite.php",function(){
				viewscription2(seq);
			});
		}
		else if(type=="temp")
		{
			//임시처방   
			$("#listdiv").load("<?=$root?>/Skin/Order/TempList.php",function(){
				getlist("temp", search);
			});
		}
		else if(type=="mydecoc")
		{
			//나의처방   
			$("#listdiv").load("<?=$root?>/Skin/Order/MyRecipeList.php",function(){
				getmylist(search);
			});
		}
		else if(type=="recommend")
		{
			//추천처방    
			$("#listdiv").load("<?=$root?>/Skin/Order/RecommendList.php",function(){
				getrecommendlist(search);
			});
		}
		else
		{
			$("#listdiv").load("<?=$root?>/Skin/Order/PotionWrite.php",function(){
				viewscription(seq);
			});
		}
	}




	function initialize_table()
	{
		console.log("initialize_table");
		$("#meditbl").tableDnD({ onDragClass: "dragRow"	});
	}
	//임시처방
	function goTempList()
	{
		makeorderhash("1","temp","");
	}
	//나의처방
	function goMyList()
	{
		makeorderhash("1","mydecoc","");
	}
	//탕전처방
	function goPotionList()
	{
		makeorderhash("1","","");
	}
	//추천처방 
	function goRecommendList()
	{
		makeorderhash("1","recommend","");
	}


	///////



</script>

<?php
   include_once $root."/_Inc/tail.php"; ?>
