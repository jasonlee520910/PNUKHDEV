<?php 
	//20190906 : 바코드 일괄 출력 
	$root = "..";
	$type=$_GET["type"];
	$apiData="type=".$type;
	include_once ($root.'/cmmInc/headPrint.php');
?>
<style type="text/css">
		/* A4용지에 making, decoction, marking 각각 한장씩 출력하는 css추가*/
		html{background:none; min-width:0; min-height:0;font-weight:bold;}
		.section_print{width: 21cm;min-height: 29.7cm;}
		.barcode img{width:300px;height:54px;}
		.barcodetext {margin-top:-1px;font-size:14px;font-weight:bold;}
		#allBarcodeDiv{width:100%;overflow:hidden;}
		.bardiv{display:inline-block;width:50%;padding:10px;}
</style>

<div class="section_print">
    <div class="form_cont" style="padding-top:10px;">		
		<div id="allBarcodeDiv"></div>
    </div> <!-- form_cont div -->
</div><!-- section_print div -->

</body>
</html>

<script>
	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="mediboxlist")
		{
			var data=barcode=ptGroup="";
			var i=j=0;
			if(isEmpty(obj["list"]))
			{
				alert("<?=$txtdt['1665']?>");
				close();
			}
			else
			{
				//if(){
				//}
				data+="<h1 style='padding:10px;'>"+obj["tableName"]+" <span style='padding-left:20px;font-size:18px;'>( "+obj["tcnt"]+"개 약재 )</span></h1>";
				$(obj["list"]).each(function( index, value )
				{
					data+='<div class="bardiv"><div class="barcode" id="barcodeDiv_'+i+'"></div><div class="barcodetext" id="barcodeTextDiv_'+i+'"></div></div>';
					i++;
				});
			
				$("#allBarcodeDiv").html(data);
				i=0;
				$(obj["list"]).each(function( index, value )
				{
					barcode=value["mbCode"];
					$("#barcodeDiv_"+i).barcode(barcode, "code128", {barWidth:2, barHeight: 40, fontSize:15, showHRI:false});
					$("#barcodeDiv_"+i).css('width', '320px');
					$("#barcodeDiv_"+i).css('height', '40px');
					$("#barcodeDiv_"+i).css('margin-left', '-20px');
					//바코드텍스트 
					$("#barcodeTextDiv_"+i).text(barcode + " " + value["mdTitle"] + "/" + value["mdOrigin"] + "/" + value["mdMaker"]);

					i++;
				});


				setTimeout('print();', 500);
			}

		}
	}
	callapi('GET','inventory','mediboxlist','<?=$apiData?>');
</script>
