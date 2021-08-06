<?php //재고관리>약재이력추적
$root = "../..";
include_once ($root.'/_common.php');
?>
<style>
	.stockcode{width:500px;font-size:14px;font-weight:bold;}
</style>
<div class="board-view-wrap">
	<span class="bd-line"></span>
	<table>
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			  <col width="180">
			  <col width="*">
		  </colgroup>
		  <tbody>
			<tr>
				<th><span><?=$txtdt['1795']?></span></th>
				<td><input type="text" name="stockcode" placeholder="<?=$txtdt['1073']?>" class="stockcode" value="" onkeyPress="if(event.keyCode==13)routeStock()"></td><!-- 약재박스를 스캔해 주세요 -->
			</tr>
		  </tbody>
	</table>
</div>
<div class="gap"></div>
<style>
	.routediv{margin-top:20px;margin-bottom:20px;}
	.routediv h1{font-size:35px;font-weight:bold;height:30px;padding:10px 0 0 30px}
	.routediv dl dd{display:inline-block;width:200px;border:1px solid #333;padding:10px;border-radius:5px;
		margin:20px;height:160px;vertical-align:top;
	}
	.routediv dl dd h3{font-size:20px;margin-bottom:20px;font-weight:normal;background:#333;color:#fff;padding:5px;text-align:center;}
	.ulcenter{text-align:center;}
	#mbCapacity{color:blue;}
	.routediv dl dd ul{vertical-align:top;}
	.routediv dl dd ul li{font-size:20px;line-height:250%;}
	.routediv dl dd ul li span{font-size:20px;}
	.routediv dl dd ul li span.font30{font-size:30px;font-weight:bold;}
	.routediv dl dd ul li span.font25{font-size:25px;font-weight:bold;}
	.routediv dl dd ul li span i{font-size:20px;font-weight:normal;}
</style>
<div class="board-list-wrap">
	<span class="bd-line"></span>
	<div class="routediv" id="routeID">
		<h1 id="mmTitle"></h1>
		<dl>
			<dd>
				<h3><?=$txtdt["1450"]?><!-- 약재정보 --></h3>
				<ul class="ulcenter">
					<li><span class="font30" id="mdOrigin"></span></li>
					<li><span class="font25" id="mdMaker"></span></li>
				</ul>
			</dd>
			<dd>
				<h3><?=$txtdt["1776"]?><!-- 재고입고일 --></h3>
				<ul class="ulcenter">
					<li><span class="font30" id="whIndate"></span></li>
				</ul>
			</dd>
			<dd>
				<h3><?=$txtdt["1777"]?><!-- 약재박스입고일 --></h3>
				<ul class="ulcenter">
					<li><span class="font30" id="whOutdate"></span></li>
				</ul>
			</dd>
			<dd>
				<h3><?=$txtdt["1242"]?><!-- 유통기한 --></h3>
				<ul class="ulcenter">
					<li><span class="font30" id="whExpired"></span></li>
					<li><span class="font20" id="whExpiredDay"></span></li>
				</ul>
			</dd>
			<dd>
				<h3><?=$txtdt["1429"]?><!-- 약재재고 --></h3>
				<ul class="ulcenter">
					<li><span class="font30" id="mdQty"></span></li>
				</ul>
			</dd>
			<dd id="mbCapacityDiv">
				<h3 style="background:blue;"><?=$txtdt["1778"]?><!-- 약재함잔량 --></h3>
				<ul class="ulcenter">
					<li><span class="font30" id="mbCapacity" ></span></li>
				</ul>
			</dd>
		</dl>
	</div>
	<span class="bd-line"></span>
	<table id="tbllist" class="tblcss">
		  <caption><span class="blind"></span></caption>
		  <colgroup>
			 <col scope="col" width="8%">
			 <col scope="col" width="*">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="12%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="10%">
			 <col scope="col" width="8%">
			 <col scope="col" width="8%">
		  </colgroup>
		  <thead>
			 <tr>
				  <th><?=$txtdt["1257"]?><!-- 입출고구분 --></th>
				  <th><?=$txtdt["1265"]?>/<?=$txtdt["1427"]?><!-- 입출고코드 --></th>
				  <th><?=$txtdt["1713"]?><!-- 조제대 --></th>
				  <th><?=$txtdt["1669"]?><!-- 약재함 --></th>
				  <th><?=$txtdt["1266"]?>/<?=$txtdt["1352"]?><!-- 입고품명/출고제목 --></th>
				  <th><?=$txtdt["1258"]?><!-- 입출고량 --></th>
				  <th><?=$txtdt["1282"]?><!-- 재고수량 --></th>
				  <th><?=$txtdt["1260"]?><!-- 입고가격 --></th>
				  <th><?=$txtdt["1054"]?><!-- 담당자 --></th>
				  <th><?=$txtdt["1458"]?><!-- 입/출고일 --></th>
			  </tr>
		  </thead>
		  <tbody>
		  </tbody>
	  </table>
</div>
<div class="gap"></div>
<!--// page end -->

<script>
	function routeStock()
	{
		var code=$("input[name=stockcode]").val();
		var type=code.substring(0,3);

		if(type=="MDB")
		{
			$("#routeID").show();
			var apidata="code="+code;
			callapi('GET','stock','stockroute',apidata);
		}
		else
		{
			if(!isEmpty(code))
			{
				type=code.substring(0,2);
				if(type=="HD")
				{
					$("#routeID").hide();
					var apidata="mbStock="+code;
					callapi('GET','stock','stockroutelist',apidata);
				}
				else
				{
					$("#routeID").hide();
					var apidata="mbTitle="+code;
					callapi('GET','stock','stockroutelist',apidata);
				}
			}
			//alertsign("warning", "<?=$txtdt['1734']?>", "", "1500");//약재박스코드가 아닙니다.
			//setTimeout("$('input[name=stockcode]').val('')",1500);
		}
		$("input[name=stockcode]").val("");
	}
	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"] == "stockroute") //약재함으로 검색했을때
		{
			$("#mbCapacity").text(comma(obj["data"]["mbCapacity"])+"g"); //약재함잔량
			$("#mmTitle").text(obj["data"]["mmTitle"]);
			$("#whExpired").text(obj["data"]["whExpired"]);
			$("#whIndate").text(obj["data"]["whIndate"]);
			$("#whOutdate").text(obj["data"]["whOutdate"]);
			$("#mdOrigin").html("<i></i>"+obj["data"]["mdOrigin"]);//원산지
			$("#mdMaker").html("<i></i>"+obj["data"]["mdMaker"]);//생산자
			$("#mdQty").text(obj["data"]["mdQty"]+"g");


			if(obj["data"]["whExpiredDay"]["invert"] == 1)
			{
				var temp="<?=$txtdt['1779']?>";//[1]년 [2]개월 [3]일 지남
				temp=temp.replace("[1]",obj["data"]["whExpiredDay"]["y"]);
				temp=temp.replace("[2]", obj["data"]["whExpiredDay"]["m"]);
				temp=temp.replace("[3]", obj["data"]["whExpiredDay"]["d"]);
				$("#whExpiredDay").html("<span style='color:red;font-weight:bold;'>"+temp+"</span>");
			}
			else
			{
				var temp="<?=$txtdt['1780']?>";//[1]년 [2]개월 [3]일 남음
				temp=temp.replace("[1]",obj["data"]["whExpiredDay"]["y"]);
				temp=temp.replace("[2]", obj["data"]["whExpiredDay"]["m"]);
				temp=temp.replace("[3]", obj["data"]["whExpiredDay"]["d"]);
				$("#whExpiredDay").html("<span style='color:blue;'>"+temp+"</span>");
			}
			
			
			var apidata="mbStock="+obj["data"]["mbMedicine"];
			callapi('GET','stock','stockroutelist',apidata);
		}
		else if(obj["apiCode"] == "stockroutelist")
		{
			var data=mtitle=price=remain=mbcode="";
			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					mtitle=isEmpty(value["mt_title"]) ? "-":value["mt_title"];
					price=isEmpty(value["wh_price"]) ? "-" : value["wh_price"];
					remain=isEmpty(value["wh_remain"]) ? "-" : value["wh_remain"];
					mbcode=isEmpty(value["mb_code"]) ? "-" : value["mb_code"];
					data+="<tr>";
					data+="<td>"+value["stockType"]+"</td>"; //입/출고 구분
					data+="<td>"+value["wh_code"]+"</td>"; //입고코드/출고코드
					data+="<td>"+mtitle+"</td>"; //조제대
					data+="<td>"+mbcode+"</td>"; //약재함
					data+="<td class='l'>"+value["wh_title"]+"</td>"; //입고품명/출고제목	
					data+="<td class='r'>"+comma(value["wh_qty"])+"</td>"; //	입/출고량
					data+="<td class='r'>"+comma(remain)+"</td>"; //재고수량 
					data+="<td class='r'>"+comma(price)+"</td>"; //입고가격
					data+="<td>"+value["st_name"]+"</td>"; //담당자
					data+="<td>"+value["wh_indate"]+"</td>"; //입/출고일
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='10'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#tbllist tbody").html(data);
		}

		
	}

	$("input[name=stockcode]").focus();
</script>
