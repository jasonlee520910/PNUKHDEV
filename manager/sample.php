<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document</title>
  <script  type="text/javascript" src="jquery-2.2.4.js"></script>
</head>
<script>
//------------------------------------------------------------------------------------
// api 호출
//------------------------------------------------------------------------------------
function callapi(type,group,code,data)
{
	var language="kor";

	var url="https://api.pnuh.djmedi.net/pnuh/order/"+group+"/";

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
		},
		error:function(request,status,error){
			console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
		}
   });
}
function sample()
{
	//post 형식으로 데이터 보내기 
	var jsondata={};
	var orderinfo={};
	orderinfo[0]={};
	orderinfo[0]["orderCode"]="djmedi1234";
	orderinfo[0]["orderDate"]="2019-07-20";
	orderinfo[0]["deliveryDate"]="2019-07-31";
	jsondata["apiCode"]="orderregist";
	jsondata["language"]="kor";
	jsondata["orderInfo"]=orderinfo;

	var jsdata={};
	jsdata["data"]=JSON.stringify(jsondata);
	callapi('POST','regist','orderregist',jsdata);

	//get 형식으로 보내기 
	//var data="";
	//callapi('GET','list','orderlist',data);

}
</script>
 <body>
  <div>
	 <p>[JSON]
{  
   "apiCode":"orderregist",
   "language":"kor",
   "orderInfo":[  
      {  
         "orderCode":"부산대주문코드",
         "orderDate":"2019-07-20",
         "deliveryDate":"2019-07-31",
         "medicalCode":"md00001",
         "medicalName":"디제이한의원",
         "doctorCode":"dt00001",
         "doctorName":"한의사",	 
         "orderTitle":"쌍화탕",
         "orderTypeCode":"decoction",
	 "orderType":"탕제",
"orderCount":"1",
"productCode":"34",
"productCodeName":"쌍화탕"
         "orderComment":"테스트조제지시입니다",
"orderAdvice":"복약지도서입니다.",
"orderStatus":"cart"

      }
   ],
   "patientInfo":[
{
	"patientName":"홍길동",
   "patientGender":"Male",
   "patientBirth":"19920415",
"patientPhone":"010-2345-6789"
}
],
   "recipeInfo":[  
      {  
         "chubCnt":"20",
         "packCnt":"45",
         "packCapa":"120",
         "totalMedicine":[  
            {  
               "mediType":" Infirst ",
               "mediCode":"A00001",
               "mediName":"녹용",
               "mediPoison":"0",
               "mediDismatch":"0",
               "mediOrigin":"chn"
"mediOriginTxt":"중국",
               "mediCapa":"3.5",
               "mediAmount":"1000"
            },
            {  
               "mediType":" inmain ",
               "mediCode":"A00001",
               "mediName":"녹용",
               "mediPoison":"1",
               "mediDismatch":"0",
"mediOrigin":"chn"
"mediOriginTxt":"중국",
               "mediCapa":"3.5",
               "mediAmount":"1000"
            },
            {  
               "mediType":" inafter ",
               "mediCode":"A00001",
               "mediName":"녹용",
               "mediPoison":"0",
               "mediDismatch":"1",
"mediOrigin":"chn"
"mediOriginTxt":"중국",
               "mediCapa":"3.5",
               "mediAmount":"1000"
            }
         ],
	"sweetMedi”:[
	  {
"sweetCode ":"A00001",
               	"sweetName ":"올리고당",
"sweetCapa ":"15"
      	  }
]
      }
   ],
"decoctionInfo":[  
      {  
         "specialDecoc":"spdeco01",
	 "specialDecoctxt":"주수상반"
      }
   ],
"markingInfo":[  
      {  
         "markType":"type01",
"markText":"홍길동/2019.10.31/서울한의원"
      }
   ],
   "packageInfo":[  
      {  
         "packType":"poutch",
         "packCode":"pt001",
         "packName":"디제이파우치",
         "packImage":"https://data.hanpurmall.co.kr/imgurl",
         "packAmount":"2000"
      },
      {  
         "packType":"medibox",
         "packCode":"mb001",
         "packName":"디제이한약박스",
         "packImage":"https://data.hanpurmall.co.kr/imgurl",
         "packAmount":"2000"
      },
      {  
         "packType":"delibox",
         "packCode":"de001",
         "packName":"디제이포장박스",
         "packImage":"https://data.hanpurmall.co.kr/imgurl",
         "packAmount":"2000"
      }
   ],
   "deliveryInfo":[  
      {  
         "deliType":"post",
"sendName":"디제이메디한의원",
         "sendPhone":"031-1234-5678",
         "sendMobile":"011-9876-1234",
         "sendZipcode":"04550",
         "sendAddress":"경기 고양시 일산동구 호수로 358-25 ",
         "sendAddressDesc":" 동문타워 601호 ",
         "recieveName":"홍길동",
         "recievePhone":"031-1234-5678",
         "recieveMobile":"010-1234-5678",
         "recieveZipcode":"04550",
         "recieveAddress":"경기 고양시 일산동구 호수로 358-25 ",
         "recieveAddressDesc":" 동문타워 601호 ",
         "recieveComment":"빠른배송 부탁합니다."
      }
   ],
   "paymentInfo":[  
      {  
         "amountTotal":"45000",
         "amountMedicine":"30000",
         "amountAddmedi":"4000",
         "amountSweet":"1000",
         "amountPharmacy":"2000",
         "amountDecoction":"3000",
         "amountPackaging":"2000",
         "amountDelivery":"3000"
      }
   ]
}
</p>
	<input type="button" value="send" onclick="sample()">
  </div>
 </body>
</html>
