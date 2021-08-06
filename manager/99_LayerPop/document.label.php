<?php 
	$root = "..";
	$arr=explode("|",$_GET["seq"]);
	$type=$arr[0];
	//echo $type;
	$seq=$arr[1];
	$apiprinterData = "seq=".$seq;
	include_once ($root.'/cmmInc/headPrint.php');
?>
<style type="text/css">
	html, body{background:none; min-width:0; min-height:0;padding:0;margin:0 0 0 3px;}
	#thetbl{float:left;width:294px;height:130px;border:2px solid #111;border-bottom:1px solid #111;border-right:1px solid #111;}
	#thetbl tr td{text-align:center;padding:2px;border-bottom:1px solid #111;border-right:1px solid #111;}
	#thetbl tr td.title{text-align:left;font-size:20px;padding:5px;font-weight:bold;}
	#thetbl tr td.title span{float:right;padding-left:10px;margin-top:10px;font-size:15px;font-weight:normal;}
	#thetbl tr td.subtitle{height:27px;text-align:center;font-size:16px;}
	#thetbl tr td .barcode{height:35px;overflow:hidden;}
	#thetbl tr td .barcode object{width:250px;height:30px;}
	#bcTextDiv {height:22px;font-size:16px;}
</style>

	<table cellspacing="0" cellpadding="0" border="0" id="thetbl">
	<col style="width:50%;">
	<col style="width:50%;">
	<tr>
		<td colspan="2" class="title" id="data1Div"><!-- <?=$data1?> --></td>
	</tr>
	<tr>
		<td id="data2Div" class="subtitle"><!-- <?=$data2?> --></td>
		<td id="data3Div" class="subtitle"><!-- <?=$data3?> --></td>
	</tr>
	<tr>
		<td colspan="2"><div id="bcDiv" class="barcode"><!-- <?=$barcodeimg?><br><?=$barcode?> --></div><div id="bcTextDiv"></div></td>
	</tr>
	</table>
</body>
</html>
<script>
	function makepage(json)
	{
		console.log("making makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		var data1=data2=data3=whCode=mdOrigin=mdMaker='';

		if(obj["apiCode"]=="genstockdesc")
		{
			mdOrigin = (!isEmpty(obj["whOrigin"])) ? obj["whOrigin"]+"/" : "";
			mdMaker = (!isEmpty(obj["whMaker"])) ? obj["whMaker"] : "";
			data1=obj["whTitle"]+" <span class='right'> "+mdOrigin+mdMaker+"</span>";
			data2=obj["whDate"];
			data3=(!isEmpty(obj["whExpired"])) ? obj["whExpired"] : "-";
			whCode=obj["whCode"];
			//barcodeimg=createbarcode("stock",obj["whCode"]);
		}
		else if(obj["apiCode"]=="instockdesc")
		{
			mdOrigin = (!isEmpty(obj["mdOrigin"])) ? obj["mdOrigin"] : "-";
			mdMaker = (!isEmpty(obj["mdMaker"])) ? obj["mdMaker"] : "-";
			data1=obj["mdTitle"]+" <span class='right'>/ "+mdOrigin+" / "+mdMaker+"</span>";
			data2=obj["whDate"];
			data3=obj["whExpired"];
			whCode=obj["whCode"];
			//var barcodeimg=createbarcode_api(obj["whCode"]);

		}
		else if(obj["apiCode"]=="mediboxdesc")  //약재함관리
		{
			data1=obj["mdTitle"];
			data2=obj["mdOrigin"];
			data3=obj["mtTitle"];
			whCode=obj["mbCode"];
			if(data2.length > 10)//원산지
			{
				$("#data2Div").css('font-size','13');
			}
			if(data3.length > 10)//조제대
			{
				$("#data3Div").css('font-size','13');
			}
		}
		else if(obj["apiCode"]=="potdesc")
		{
		}
		else if(obj["apiCode"]=="pouchtagdesc")
		{
			data1=obj["ptName1"];
			data2=obj["ptName2"];
			data3=obj["ptName3"];
			whCode=obj["ptCode"];
		}
		else if(obj["apiCode"]=="packingdesc")//포장재관리 - 파우치(odPacktype),한약박스(reBoxmedi),포장박스(reBoxdeli)
		{
			data1=obj["pbTypeName"];
			data2=obj["pbTitle"];
			data3=obj["pbStaff"];
			whCode=obj["pbCode"];
			
		}
		else if(obj["apiCode"]=="staffdesc") //스태프 바코드 추가
		{
			data1=obj["stName"];
			data2=obj["stDepart"];
			data3=obj["stDepart"];
			whCode=obj["stStaffId"];

			var idcode="<?=$type?>";
			if(idcode=="staff_code")
			{
				whCode=obj["stStaffId"];
			}else{

				whCode=obj["stUserId"];
			}

			if(data2=="making"){
				data2='<?=$txtdt["1291"]?>'/*"조제"*/;
			}else if(data2=="decoction"){
				data2='<?=$txtdt["1361"]?>'/*"탕전"*/;
			}else if(data2=="marking"){
				data2='<?=$txtdt["1467"]?>'/*"마킹/포장"*/;
			}else if(data2=="release"){
				data2='<?=$txtdt["1346"]?>'/*"출고"*/;
			}else if(data2=="manager"){
				data2='<?=$txtdt["1080"]?>'/*"매니저"*/;
			}else if(data2=="sales"){
				data2='<?=$txtdt["1663"]?>'/*"영업"*/;
			}else if(data2=="marketing"){
				data2='<?=$txtdt["1565"]?>'/*"마케팅"*/;
			}
			data3=data2;
		}

		$("#data1Div").html(data1);
		$("#data2Div").text(data2);
		$("#data3Div").text(data3);


			
		if(obj["apiCode"]=="mediboxdesc") //자재코드관리 >> 약재함관리  
		{
			$("#bcDiv").barcode(whCode, "code128", {barWidth:2, barHeight: 50, fontSize:15, output:"bmp"});
			$("#bcDiv").css('width', '290px');
			$("#bcTextDiv").text(whCode);
		}
		else if(obj["apiCode"]=='pouchtagdesc')//자재코드관리 >> 조제태그관리 
		{
			$("#bcDiv").barcode(whCode, "code128", {barWidth:2, barHeight: 50, fontSize:15, output:"bmp"});
			$("#bcDiv").css('width', '290px');
			$("#bcTextDiv").text(whCode);
		}
		else if(obj["apiCode"]=='packingdesc')//자재코드관리 >> 포장재관리 - 파우치(odPacktype),한약박스(reBoxmedi),포장박스(reBoxdeli)
		{
			$("#bcDiv").barcode(whCode, "code128", {barWidth:2, barHeight: 50, fontSize:15, output:"bmp"});
			$("#bcDiv").css('width', '290px');
			$("#bcTextDiv").text(whCode);
		}
		else
		{
			$("#bcDiv").barcode(whCode, "code128", {barWidth:2, barHeight: 50, fontSize:15, output:"bmp"});
			$("#bcDiv").css('width', '290px');
			$("#bcTextDiv").text(whCode);
		}

		//$("#bcDiv").barcode(whCode, "code128", {barWidth:2, barHeight: 50, fontSize:15, output:"bmp"});
		//$("#bcDiv").css('width', '290px');
		//console.log("whCode  >>>  "+obj["stUserId"]);
		//$("#bcTextDiv").text(obj["stUserId"]);

		$("#bcDiv").css('margin', '0 auto');
		$("#bcDiv").css('margin-top', '7px');
		return false;
	}

	//각 타입에 맞게 api 호출
	var type = '<?=$type?>';
	console.log("type = " + type);
	switch(type)
	{
		case "warehouse":
			callapi('GET','stock','genstockdesc','<?=$apiprinterData?>');
		break;
		case "stock":
			callapi('GET','stock','instockdesc','<?=$apiprinterData?>');
		break;
		case "medibox":  //약재함 바코드
			callapi('GET','inventory','mediboxdesc','<?=$apiprinterData?>');
		break;
		case "pot":
			callapi('GET','inventory','potdesc','<?=$apiprinterData?>');
		break;
		case "pouchtag":  //조제태그관리
			callapi('GET','inventory','pouchtagdesc','<?=$apiprinterData?>');
		break;
		case "odPacktype": case "reBoxmedi": case "reBoxdeli":
			callapi('GET','inventory','packingdesc','<?=$apiprinterData?>');
		break;
		case "staff_code":  //스태프 code 바코드 추가
			callapi('GET','member','staffdesc','<?=$apiprinterData?>');
		break;
		case "staff_id":  //스태프 id 바코드 추가
			callapi('GET','member','staffdesc','<?=$apiprinterData?>');
		break;
	}

	setTimeout("print()",1000);
</script>
