<?php
	$root="..";
	include_once $root."/_common.php";
	include_once $root."/_Inc/headpop.php";

	$type="POST";
	$odCode=$_GET["odCode"];
	$site=$_GET["site"];

	$apiData="odCode=".$odCode;

?>
<!-- s: -->
<style>
	.deli_div{width:auto;padding:10px;}
	.deli_div .tbl{table-layout:fixed;border:none;border-top:2px solid #111;border-left:1px solid #ccc;margin:10px auto;width:100%;;}
	.deli_div .tbl tr th, .deli_div .tbl tr td{border:none;border-bottom:1px solid #ccc;border-right:1px solid #ccc;padding:7px;font-size:13px;text-align:center;}
	.deli_div .tbl tr th{background:#eee;font-weight:bold;}
	.deli_div .tbl tr th.lf{text-align:left;padding:15px;}
	.deli_div .tbl tr.last th, .deli_div .tbl tr.last td{border-bottom:1px solid #111;}
	.deli_div .tbl tr.last td{background:#fafafa;}
	.deli_div .tbl tr td span{display:block;margin:auto;color:#fff;font-size:13px;padding:3px;width:80px;}
	.deli_div .tbltop tr th, .deli_div .tbltop tr td{padding:15px 0;}
	.btn-blue{background:#0e98c0;border:1px solid #0e98c0;}
	.btn-purple{background:#B83A99;border:1px solid #B83A99;}
	.btndiv{width:100%;text-align:center;}
	.btndiv dd{display:inline-block;margin:20px;}
	.btndiv dd span{display:block;color:#fff;font-size:17px;font-weight:bold;padding:7px;width:130px;}
	.btndiv dd .cls{color:#aaa;border:1px solid #aaa;}
	.btndiv dd .send{background:#0e98c0;border:1px solid #0e98c0;}
</style>
<div class="deli_div">
	<h1>배송상품정보</h1>
	<table class="tbl tbltop">
		<colgroup>
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
			<col width="10%">
		</colgroup>
		<tr>
			<th colspan="5" class="lf" id="delititle"></th>
			<th colspan="5" class="lf" id="delibox"></th>
		</tr>
		<tr class="last">
			<th>갯수</th>
			<td id="deliordercnt"></td>
			<th>총팩수</th>
			<td id="delipackcnt"></td>
			<th>부피</th>
			<td id="delivol"></td>
			<th id="delimaxcnttit">최대팩수</th>
			<td id="delimaxcnt"></td>
			<th id="delipackcapatit">팩용량</th>
			<td id="delipackcapa"></td>
		</tr>
	</table>

	<table class="tbl" id="delitbl">
		<colgroup>
			<col width="28%">
			<col width="28%">
			<col width="28%">
			<col width="16%">
		</colgroup>
	<thead>
	<tr>
		<th>송장</th>
		<th>처방팩수</th>
		<th>무게</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	</tbody>
	</table>

	<dl class="btndiv">
		<dd style="display:none;"><span id="btnreload" onclick="reloadDelicnt();">새로고침</span></dd>
		<dd><span id="btnclose" class="cls" onclick="popDelicntClose();">닫기</span></dd>
		<dd><span id="btnupdate" class="send" onclick="delicntupdate();" data-check="">적용</span></dd>
	</dl>

	<input type="hidden" id="delicnt" name="delicnt" value="" />
	<input type="hidden" id="delicntchk" name="delicntchk" value="" />
	<input type="hidden" id="packcnt" name="packcnt" value="" />
	<input type="hidden" id="packcapa" name="packcapa" value="" />
	<input type="hidden" id="reBoxmedicnt" name="reBoxmedicnt" value="" />
	<input type="hidden" id="btnupdatechk" name="btnupdatechk" value="N" />
	<textarea name="reBoxmedicntdata" class="reqdata"  style="display:none;"></textarea> 

	<input type="hidden" id="totmedicine" name="totmedicine" value="" />
	<input type="hidden" id="totbujigpo" name="totbujigpo" value="" />
	<input type="hidden" id="od_goods" name="od_goods" value="" />
	
</div>

<script>
	function reloadDelicnt()
	{
		var site="<?=$site?>";
		if(site=="MANAGER")
		{
			self.close();
		}
		else
		{
			window.location.reload();
		}
	}
	function popDelicntClose()
	{
		var site="<?=$site?>";
		if(site=="MANAGER")
		{
			self.close();
		}
		else
		{
			var chk=$("input[name=btnupdatechk]").val();
			console.log("chk==="+chk);
			if(chk=="Y")
			{
				console.log("popDelicntClosepopDelicntClosepopDelicntClosepopDelicntClose");
				opener.location.href = "javascript:showDeliPrint();";
				self.close();
			}
			else
			{
				alert("먼저 적용버튼을 눌러 주세요.");
			}
		}
	}
	function delicntupdate()
	{
		var odCode="<?=$odCode?>";
		var delicnt=$("input[name=delicnt]").val();
		var delidata=$("textarea[name=reBoxmedicntdata]").val();

		var url="odCode="+odCode+"&delicnt="+delicnt+"&delidata="+delidata;
		console.log("delicntupdate  url = " + url);
		$("#btnupdate").hide();
		callapi('GET','release','releasedelicntupdate',url);
	}
	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj)
		if(obj["apiCode"]=="markingdeliverycnt")
		{
			$("#btnreload").hide();

			$("#delititle").html(obj["od_title"]);

			var orderCount=!isEmpty(obj["orderCount"]) ? parseInt(obj["orderCount"]) : 1;
			var od_packcnt=!isEmpty(obj["od_packcnt"]) ? parseInt(obj["od_packcnt"]) : 0;
			var od_packcapa=!isEmpty(obj["od_packcapa"]) ? parseInt(obj["od_packcapa"]) : 0;
			orderCount=(orderCount>0) ? orderCount : 1;

			var re_boxmedivol=!isEmpty(obj["re_boxmedivol"])?parseInt(obj["re_boxmedivol"]):0;
			var re_boxmedipack=!isEmpty(obj["re_boxmedipack"])?parseInt(obj["re_boxmedipack"]):0;


			var totmedicine=!isEmpty(obj["totmedicine"])?parseInt(obj["totmedicine"]):0;
			var totbujigpo=!isEmpty(obj["totbujigpo"])?parseInt(obj["totbujigpo"]):0;
			$("input[name=totmedicine]").val(totmedicine);
			$("input[name=totbujigpo]").val(totbujigpo);
			$("input[name=od_goods]").val(obj["od_goods"]);


			$("#deliordercnt").text(orderCount+"개");
			

			$("#delibox").text(obj["pb_title"]);

			$("#delivol").text(re_boxmedivol+"cm");
			$("#delimaxcnt").text(re_boxmedipack+"팩");
			if(!isEmpty(obj["od_goods"])&&obj["od_goods"]=="M")
			{
				$("#delimaxcnttit").text("약재총량");
				$("#delipackcnt").text(totmedicine+"g");
				$("#delipackcapatit").text("부직포총량");
				$("#delipackcapa").text(totbujigpo+"g");
			}
			else
			{
				$("#delipackcnt").text(od_packcnt+"팩");
				$("#delipackcapa").text(od_packcapa+"ml");
			}

			console.log("orderCount = " + orderCount+", od_packcnt = " + od_packcnt+", od_packcapa = " + od_packcapa+", re_boxmedicnt = " + obj["re_boxmedicnt"]+", re_boxmedicntdata="+obj["re_boxmedicntdata"]);

			if(!isEmpty(obj["re_boxmedicntdata"])&&!isEmpty(obj["re_boxmedicnt"])&&parseInt(obj["re_boxmedicnt"])>0)
			{
				console.log("11111111111111111111");
				$("input[name=btnupdatechk]").val("Y");
			}
			else
			{
				console.log("2222222222222");
				$("input[name=btnupdatechk]").val("N");
			}

			var chk=$("input[name=btnupdatechk]").val();
			console.log("chk==="+chk);
			
			if(parseInt(od_packcnt)<=0 || parseInt(od_packcapa)<=0)
			{
				$("#btnreload").show();
				$("#btnclose").hide();
				$("#btnupdate").hide();
				alert("총팩수나 팩용량의 데이터가 없습니다. 관리자에서 확인 후 다시 시도해 주시기 바랍니다.");
			}
			else if(parseInt(re_boxmedivol)<=0 || parseInt(re_boxmedipack)<=0)
			{
				$("#btnreload").show();
				$("#btnclose").hide();
				$("#btnupdate").hide();
				alert("한약박스를 선택해 주세요.(부피와 최대팩수가 없습니다.) 관리자에서 확인 후 다시 시도해 주시기 바랍니다.");
			}
			else
			{
				if(!isEmpty(obj["re_boxmedicnt"])&&parseInt(obj["re_boxmedicnt"])>0)
				{
					$("input[name=delicnt]").val(obj["re_boxmedicnt"]);
					$("input[name=delicntchk]").val("Y");
					$("#btnupdate").hide();
				}
				else
				{
					$("input[name=delicnt]").val(orderCount);
					$("input[name=delicntchk]").val("N");
					$("#btnupdate").show();
					
				}
				
				$("input[name=packcnt]").val(od_packcnt);
				$("input[name=packcapa]").val(od_packcapa);

				setDelicntList();
			}
			
		}
		else if(obj["apiCode"]=="releasedelicntupdate")
		{
			alert("적용하였습니다.");

			$("input[name=reBoxmedicnt]").val(obj["delicnt"]);
			var odCode="<?=$odCode?>"
			var url="odCode="+odCode;
			callapi('GET','marking','markingdeliverycnt',url);
		}
	}
	function subDelicnt()
	{
		var delicnt=$("input[name=delicnt]").val();

		delicnt=parseInt(delicnt)-1;
		if(delicnt<=1) delicnt=1;

		$("input[name=delicnt]").val(delicnt);

		setDelicntList();
		
	}
	function addDelicnt()
	{
		var delicnt=$("input[name=delicnt]").val();

		delicnt=parseInt(delicnt)+1;
		if(delicnt>=10) delicnt=10;

		$("input[name=delicnt]").val(delicnt);

		setDelicntList();
	}

	function setDelicntList()
	{
		var i=0;
		var data="";
		var delicnt=$("input[name=delicnt]").val();
		var od_packcnt=$("input[name=packcnt]").val();
		var od_packcapa=$("input[name=packcapa]").val();
		var delicntchk=$("input[name=delicntchk]").val();
		var totalpackcnt=od_packcnt;
		var totalweight=(od_packcnt*od_packcapa);
		var onepack=od_packcnt/delicnt;
		var onewei=(od_packcnt*od_packcapa)/delicnt;
		onepack=Math.ceil(onepack);
		onewei=Math.ceil(onewei);

		var od_goods=$("input[name=od_goods]").val();
		var totmedicine=$("input[name=totmedicine]").val();
		var totbujigpo=$("input[name=totbujigpo]").val();

		if(!isEmpty(od_goods)&&od_goods=="M")
		{
			totalweight=parseFloat(totmedicine)+parseFloat(totbujigpo);
			onewei=totalweight/delicnt;
			console.log("약재포장이라면 totalweight = " + totalweight);
		}

		var boxmedicntdata=new Array();

		console.log("od_packcnt = " + od_packcnt+", totalweight = " + totalweight);

		$("#delitbl tbody").html("");
		var totalwei=totalpack=0;
		
		for(i=0;i<delicnt;i++)
		{
			var delbtn="";
			var deliarr=new Object;

			if(i>0&&delicntchk=="N")
			{
				delbtn="<span class='btn-purple' onclick='subDelicnt();'>삭제</span>";
			}

			if(totalpackcnt<(totalpack+onepack))
			{
				var temp=totalpack+onepack;
				var tonepack=temp-totalpackcnt;
				console.log("temp = " + temp+", tonepack = " + tonepack);
				onepack=onepack-tonepack;
			}

			if(totalweight<(totalwei+onewei))
			{
				var tempw=totalwei+onewei;
				var tonewei=tempw-totalweight;
				console.log("tempw = " + tempw+", tonewei = " + tonewei);
				onewei=onewei-tonewei;
			}
			data+="<tr>";
			data+="<td>"+(i+1)+"</td><td>"+onepack+"</td><td>"+onewei+"g</td><td>"+delbtn+"</td>";
			data+="</tr>";


			deliarr.no=i;
			deliarr.packcnt=onepack;
			deliarr.weight=onewei;
			deliarr.weikg=Math.ceil(onewei/1000);

			boxmedicntdata.push(deliarr);
			
			totalpack+=onepack;
			totalwei+=onewei;

			console.log("onepack " +onepack+", onewei = "+onewei+", delicnt : " + delicnt+", totalpack = "+totalpack+", totalwei = " + totalwei+", totalpackcnt = " + totalpackcnt);
		}
		data+="<tr class='last'>";

		if(delicntchk=="N" && parseInt(delicnt)<10)
		{
			data+="<td>계</td><td>"+totalpack+"</td><td>"+totalwei+"g</td><td><span class='btn-blue' onclick='addDelicnt();'>추가</span></td>";
		}
		else
		{
			data+="<td>계</td><td>"+totalpack+"</td><td>"+totalwei+"g</td><td></td>";
		}
		data+="</tr>";

		$("#delitbl tbody").html(data);

		//json data 
		console.log(boxmedicntdata);
		var jsonData = JSON.stringify(boxmedicntdata);
		$("textarea[name=reBoxmedicntdata]").val(jsonData);
		console.log(jsonData);


	}
	callapi('GET','marking','markingdeliverycnt',"<?=$apiData?>");
</script>