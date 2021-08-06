<?php 
	$root = "..";

	$odCode=$_GET["odCode"];
	$apiprinterData = "odCode=".$odCode;

	include_once ($root.'/cmmInc/headPrint.php');
?>
<style type="text/css">
	html{background:none; min-width:0; min-height:0;}
	.barcode img{width:252px;height:54px;}
</style>
<h1 style="padding:30px;" id="odTitleDiv"><!-- <?=$txtdt["1323"]?> - <?=$json["odTitle"]?> --></h1><!-- 처방명 -->
<div id="test"></div>

<div class="section_print" id="sectionDiv">	
</div>
</body>
</html>
<script>
	function getDecoTypeName(list, data)
	{
		var str = "<?=$txtdt['1251']?>";//일반 
		for(var key in list)
		{
			if(data == list[key]["cdCode"])
			{
				str = list[key]["cdName"];
				break;
			}
		}
		return str;
	}
	function makepage(json)
	{
		console.log("making makepage ----------------------------------------------- ")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])
		console.log("-------------------------------------------------------- ")

		if(obj["apiCode"]=="orderprint")
		{
			var title = '<?=$txtdt["1323"]?> - '+obj["odTitle"];
			$("#odTitleDiv").text(title);

			var carr=new Array("ma","dc","mr");
			var tarr=new Array('<?=$txtdt["1596"]?>','<?=$txtdt["1615"]?>','<?=$txtdt["1624"]?>');//조제일지, 탕전일지, 마킹/배송일지
			var sarr=new Array('<?=$txtdt["1602"]?>','<?=$txtdt["1373"]?>','<?=$txtdt["1625"]?>');//조제사, 탕제사, 마킹사

			var data=staff=code=barcode="";

			
			for(var i=0;i<tarr.length;i++)
			{				
				code = obj[carr[i]+"Code"];
				if(!isEmpty(obj[carr[i]+"staffid"]))
					staff=obj[carr[i]+"staffid"]
				else
					staff='<?=$txtdt["1256"]?>';

				data+='<div class="view_lst">';
				data+='<h3 class="dtl_tit">'+obj["miName"]+' - '+tarr[i]+'</h3>';
				data+='<div class="form_dtl">';
				data+='<div class="barcode" id="'+carr[i]+'Div">';	//바코드 출력하는 부분 
				data+='</div>';
				data+='<div class="form_info">';
				data+='<dl>';
				data+='<dt><?=$txtdt["1597"]?></dt>';
				data+='<dd><em>'+code+'</em></dd>';
				data+='</dl>';
				data+='<dl>';
				data+='<dt>'+sarr[i]+' : </dt>';
				data+='<dd><em>'+staff+'</em></dd>';
				data+='</dl>';
				data+='<dl>';
				data+='<dt><?=$txtdt["1609"]?></dt>';
				data+='<dd>'+obj["odCode"]+'</dd>';
				data+='</dl>';
				data+='<dl>';
				data+='<dt><?=$txtdt["1304"]?></dt>';
				data+='<dd>'+obj["odDate"]+'</dd>';
				data+='</dl>';
				data+='</div>';
				data+='</div>';
				data+='</div>';
			}

			$("#sectionDiv").html(data);


			for(var i=0;i<tarr.length;i++)
			{				
				code = obj[carr[i]+"Code"];
				$("#"+carr[i]+"Div").barcode(code, "code128", {barWidth:2, barHeight: 50, fontSize:15});
				$("#"+carr[i]+"Div").css('width', 'auto');
				$("#"+carr[i]+"Div").css('height', '70px');
				$("#"+carr[i]+"Div").css('margin', '0 auto');
				$("#"+carr[i]+"Div").css('margin-top', '5px');
			}


			setTimeout('print();', 500);

		}
	}

	//한의원 상세 정보 
	callapi('GET','order','orderprint','<?=$apiprinterData?>');

</script>
