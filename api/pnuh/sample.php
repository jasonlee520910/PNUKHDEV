<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document</title>
  <script  type="text/javascript" src="jquery-1.8.3.js"></script>
</head>
<script>
//------------------------------------------------------------------------------------
// api 호출
//------------------------------------------------------------------------------------
function callapi(type,group,code,data)
{
	var language="kor";
	//medical로 데이터 넣을때 
	//var url="https://api.dev.pnuh.djmedi.net/medical/order/";
	//client 
	//var url="https://api.pnuh.djmedi.net/pnuh/order/"+group+"/";

	//pnuh EMR
	var url="https://api.pnuh.djmedi.net/pnuh/order/"+group+"/";
	//pnuh MEDICAL 
	//var url="https://api.pnuh.djmedi.net/medical/order/";

	switch(type)
	{
	case "GET": case "DELETE":
		url+="?apiCode="+code+"&language="+language+"&"+data;
		data="";
		break;
	case "POST":
		break;
	}
	$.ajax({
		type : type, //method
		url : url,
		data : data,
		success : function (result) {
			console.log("result " + result);
			alert(result);
			$("#resultdata").text(result);

			var obj = JSON.parse(result);
			console.log(obj)
		},
		error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
   });
}
function sample()
{	

	//var data='{"apiCode":"orderregist","language":"kor","orderInfo":[{"orderCode":"116808073202006230021","orderDate":"2020-06-23","deliveryDate":"2020-06-23","medicalCode":"PNUKH","medicalName":"부산대학교한방병원","doctorCode":"TESTDOO","doctorName":"한방의1","orderTitle":"HT003보혈안신탕","orderTypeCode":"decoction","orderType":"탕전","orderCount":"1","productCode":"KD99999","productCodeName":"HT003보혈안신탕","orderComment":"용법 확인하세요TEST","orderAdvice":"","orderStatus":"paid"}],"patientInfo":[{"patientCode":"116808073","patientName":"김현주","patientGender":"F","patientBirth":"19630414","patientPhone":"010-21111"}],"recipeInfo":[{"chubCnt":"3","packCnt":"3","packCapa":"200","totalMedicine":[{"mediType":"inmain","mediCode":"KHMMD","mediName":"맥문동","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHBS","mediName":"복신","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHBJY","mediName":"백자인","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHSJYC","mediName":"산조인(초)","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHWJ","mediName":"원지","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"3"},{"mediType":"inmain","mediCode":"KHHGMJ","mediName":"황금(주초)","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"3"},{"mediType":"inmain","mediCode":"KHOMJ","mediName":"오미자","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"3"},{"mediType":"inmain","mediCode":"KHBCC","mediName":"백출(초)","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"6"},{"mediType":"inmain","mediCode":"KHGGK","mediName":"국화","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"1.2"},{"mediType":"inmain","mediCode":"KHDGI","mediName":"당귀(일)","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"6"},{"mediType":"inmain","mediCode":"KHYAY","mediName":"용안육","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"8"},{"mediType":"inmain","mediCode":"KHSNYC","mediName":"산약(초)","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"8"},{"mediType":"inmain","mediCode":"KHNBJ","mediName":"내복자","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"6"}],"sweetMedi":[{"sweetCode":"","sweetName":"","sweetCapa":""}]}],"decoctionInfo":[{"specialDecoc":"spdeco01","specialDecoctxt":"주수상반"}],"markingInfo":[{"markType":"type01","markText":"김현주/20/06/23/부산대한방병원"}],"packageInfo":[{"packType":"","packCode":"","packName":"","packImage":"","packAmount":""}],"deliveryInfo":[{"deliType":"direct","sendName":"김현주","sendPhone":"010-21111","sendMobile":"010-21111","sendZipcode":"49416","sendAddress":"부산광역시 사하구 괴정로101111 ","sendAddressDesc":"523-31111","receiveName":"김현주","receivePhone":"010-21111","receiveMobile":"010-21111","receiveZipcode":"49416","receiveAddress":"부산광역시 사하구 괴정로101111 ","receiveAddressDesc":"523-31111","receiveComment":"빠른배송 부탁드립니다.","receiveTied":"N"}],"paymentInfo":[{"amountTotal":"100","amountMedicine":"100","amountAddmedi":"100","amountSweet":"100","amountPharmacy":"100","amountDecoction":"100","amountPackaging":"100","amountDelivery":"100"}],"adviceInfo":[{"foodAdvice":"계란,짠 음식,밀가루,라면","cautionAdvice":"약을 복용하고 있을 시에는 의사의 지시사항에 따라 주시기 바랍니다.불특정한 증상이 생기면 전문의와 상의하시기 바랍니다.몸이 차고 기운이 약한 상태입니다.","foodAdvicFree":"기타주의해야 할 음식","cautionAdviceFree":"기타 주의사항 프리텍스트"}],"labelInfo":[{"wardNo":"4K","roomNo":"06","bedNo":"03","mediDays":"1일분","mediType":"첩제","mediCapa":"200cc*3포","mediName":"HT003보혈안신탕","mediAdvice":"1일 3회 식후2시간에 1포씩 복용"}]}';

	var data='{"apiCode":"orderregist","language":"kor","orderInfo":[{"orderCode":"096623271202006230011","orderDate":"2020-06-23","deliveryDate":"2020-06-24","medicalCode":"PNUKH","medicalName":"부산대학교한방병원","doctorCode":"TESTDOO","doctorName":"한방의1","orderTitle":"HT014가미시평탕","orderTypeCode":"decoction","orderType":"탕전","orderCount":"1","productCode":"KD99999","productCodeName":"HT014가미시평탕","orderComment":"복용법 지켜서 복용해주세요(용법비고)3주후 방문하세요(비고)","orderAdvice":"","orderStatus":"paid"}],"patientInfo":[{"patientCode":"096623271","patientName":"박용아","patientGender":"M","patientBirth":"19820312","patientPhone":"010-51111"}],"recipeInfo":[{"chubCnt":"1","packCnt":"3","packCapa":"200","totalMedicine":[{"mediType":"inmain","mediCode":"KHJJY","mediName":"적작약","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHBHAT","mediName":"반하(강제)","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHJP","mediName":"진피","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHHBK","mediName":"후박","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHGJI","mediName":"계지","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHGC","mediName":"감초","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"4"},{"mediType":"inmain","mediCode":"KHJGK","mediName":"지각","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"3"},{"mediType":"inmain","mediCode":"KHMHA","mediName":"목향","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"3"},{"mediType":"inmain","mediCode":"KHGHA","mediName":"강황","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"3"},{"mediType":"inmain","mediCode":"KHOM","mediName":"오매","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"3"},{"mediType":"inmain","mediCode":"KHSGO","mediName":"석고","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"6"},{"mediType":"inmain","mediCode":"KHZM","mediName":"지모","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"6"},{"mediType":"inmain","mediCode":"KHCCU","mediName":"창출","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"6"},{"mediType":"inmain","mediCode":"KHSIH","mediName":"시호","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"6"},{"mediType":"inmain","mediCode":"KHHGM","mediName":"황금","mediPoison":"0","mediDismatch":"0","mediOrigin":"","mediOriginTxt":"","mediCapa":"6"}],"sweetMedi":[{"sweetCode":"","sweetName":"","sweetCapa":""}]}],"decoctionInfo":[{"specialDecoc":"spdeco01","specialDecoctxt":"주수상반"}],"markingInfo":[{"markType":"type01","markText":"박용아/20/06/23/부산대한방병원"}],"packageInfo":[{"packType":"pouch","packCode":"12","packName":"파우치","packImage":"","packAmount":"0"}],"deliveryInfo":[{"deliType":"post","sendName":"박용아","sendPhone":"055-31111","sendMobile":"010-51111","sendZipcode":"46637","sendAddress":"부산광역시 북구 백양대로11111 ","sendAddressDesc":"","receiveName":"박용아","receivePhone":"055-31111","receiveMobile":"010-51111","receiveZipcode":"46637","receiveAddress":"부산광역시 북구 백양대로11111 ","receiveAddressDesc":"22-33","receiveComment":"빠른배송 부탁드립니다.","receiveTied":"Y"}],"paymentInfo":[{"amountTotal":"100","amountMedicine":"100","amountAddmedi":"100","amountSweet":"100","amountPharmacy":"100","amountDecoction":"100","amountPackaging":"100","amountDelivery":"100"}],"adviceInfo":[{"foodAdvice":"계란,짠 음식,밀가루,라면","cautionAdvice":"약을 복용하고 있을 시에는 의사의 지시사항에 따라 주시기 바랍니다.불특정한 증상이 생기면 전문의와 상의하시기 바랍니다.몸이 차고 기운이 약한 상태입니다.","foodAdvicFree":"","cautionAdviceFree":"기타 주의사항 프리텍스트"}],"labelInfo":[{"wardNo":"(한) 척추관절센터","roomNo":"-","bedNo":"-","mediDays":"1일분","mediType":"첩제","mediCapa":"200cc*3포","mediName":"HT014가미시평탕","mediAdvice":"1일 3회 식후2시간에 1포씩 복용"}]}';


	callapi('POST','regist','orderregist',"data="+data);

	$("#jsonda").text(data);

	//get 형식으로 보내기 
	//var data="";
	//callapi('GET','list','orderlist',data);

}
</script>
 <body>
  <div>
		예시 json <br>
		{"apiCode":"orderregist","language":"kor","orderInfo":[{"orderCode":"123454","orderDate":"2019-07-20","deliveryDate":"2019-07-31"}].....} <Br>
		보낸 json 데이터 <br>
	 <p id="jsonda"></p>
	<input type="button" value="send" onclick="sample()">
	<br>
	<p id="resultdata"></p>
  </div>
 </body>
</html>
