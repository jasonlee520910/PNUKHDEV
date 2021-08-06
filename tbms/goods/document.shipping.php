<?php
	$root="..";
	include_once $root."/_common.php";
	include_once $root."/_Inc/headpop.php";
	
	$odCode=$_GET["odCode"];
	$delicomp=$_GET["delicomp"];
	$page = ($_GET["page"]) ? $_GET["page"] : 1;//page
	$psize = ($_GET["psize"]) ? $_GET["psize"] : 10;//psize
	$block = ($_GET["block"]) ? $_GET["block"] : 10;//block
	
	$apiData="odCode=".$odCode."&delicomp=".$delicomp."&page=".$page."&psize=".$psize."&block=".$block;

?>
<style>
	.deli_tb table {height:300px;}
	.deli_tb table thead th{border-left:1px solid #dedede;font-size:13px;text-align:center; padding:16px 0 14px 0px; color:#3d434c; border-bottom:1px solid #e3e3e4; background:/* url(../cmmImg/Board/th-bg.jpg) no-repeat left */ #f5f5f6;}
	.deli_tb table thead th:first-child{border-left:0;}
	.deli_tb table thead th:first-child{background:#f5f5f6;}

	.deli_tb table tbody tr {height:62px;}
	.deli_tb table tbody tr:hover {background:#cccccc;}
	.deli_tb table tbody th{font-size:13px;text-align:center; padding:9px 20px; border-bottom:1px solid #e3e3e4; color:#3d434c; background:#f7f7f7;}
	.deli_tb table tbody td{font-size:13px;padding:9px 10px; border-bottom:1px solid #e3e3e4; border-left:1px solid #e3e3e4; color:#7f7f7f;}
	.deli_tb table tbody td:first-child, .deli_tb table tfoot td:first-child{border-left:0;}
	.deli_tb table tbody td a:hover{ text-decoration:none;}
	.deli_tb table tbody td span.answer-end{background:#f65b3e; padding:5px 10px; display:block; color:#fff;}
	.deli_tb table tbody td span.answer-ready{background:#bbbbbb; padding:5px 10px; display:block; color:#fff;}
	.deli_tb .cw-btn, .deli_tb .cdp-btn, .deli_tb .cp-btn, .deli_tb .cg-btn{padding: 0 }
	.deli_tb .cw-btn span, .deli_tb .cdp-btn span, .deli_tb .cp-btn span, .deli_tb .cg-btn span{padding-left:5px; padding-right:5px}


	dl.btndiv{width:20%;margin:20px auto;}
	dl.btndiv dd span{float:left;width:140px;padding:10px;margin:10px;font-size:20px;font-weight:bold;background:green;border-radius:3px;color:#fff;text-align:center;cursor:pointer;}
	dl.btndiv dd span.btnsend{background:#0e98c0;}
	dl.btndiv dd span.noClick{background:gray;}

	.paging-wrap{font-size:0px; text-align:center;}
	.paging-wrap li{display:inline-block; vertical-align:top;}
	.paging-wrap li a{display:inline-block; width:30px; height:30px; font-size:13px; border:1px solid #e2e2e2; border-right:none; line-height:30px; color:#777777; font-weight:600;margin-top:20px;}
	.paging-wrap li a.active{ width:30px; height:30px;background:#20add6;border:1px solid #20add6; color:#fff; text-decoration: none;}
	.paging-wrap li a:hover{background:#20add6; color:#fff;}
	.paging-wrap li a.first{display:inline-block; border:1px solid #e2e2e2; width:30px; height:30px; background:url(../_Img/paging-btn.jpg)no-repeat 10px 10px; font-size:0px;}
	.paging-wrap li a.prev{display:inline-block; border:1px solid #e2e2e2; width:30px; height:30px; background:url(../_Img/paging-btn.jpg)no-repeat -20px 10px #e2e2e2; font-size:0px;}
	.paging-wrap li a.next{display:inline-block; border:1px solid #e2e2e2; width:30px; height:30px; background:url(../_Img/paging-btn.jpg)no-repeat -50px 10px #e2e2e2; font-size:0px;}
	.paging-wrap li a.last{display:inline-block; border:1px solid #e2e2e2; width:30px; height:30px; background:url(../_Img/paging-btn.jpg)no-repeat -80px 10px; font-size:0px;}


</style>
<div id="pagegroup" value="goods"></div>
<div id="pagecode" value="goodsshipping"></div>
<div class="deli_tb"> 
<table id="deliID">
	<colgroup>
	<col width="10%">
	<col width="25%">
	<col width="17%">
	<col width="17%">
	<col width="">
	</colgroup>
	<thead>
		<tr>
			<th>송장번호</th>
			<th>처방명</th>
			<th>보내는사람</th>
			<th>받는사람</th>
			<th>받는사람 주소</th>
		</tr>
	</thead>

	<tbody>

	</tbody>
</table>
<div class='paging-wrap' id="delilistpage"></div>

</div>
<dl class="btndiv" id="btndl" >
		<dd><span id="btnclose" onclick="deliclose();">닫기</span></dd>
	</dl>

<script>
	function deliclose()
	{
		self.close();
	}
	function shippingupdate(delicode)
	{
		var odCode="<?=$odCode?>";
		var delicomp="<?=$delicomp?>";
		if(confirm("송장번호 : "+delicode+"로 묶음배송 하시겠습니까?"))
		{
			if(!isEmpty(odCode))
			{
				if(!isEmpty(delicomp))
				{
					console.log("delicode = " + delicode+", odCode = " + odCode);
					var url="odcode="+odCode+"&delicode="+delicode;
					callapi('GET','goods','goodsshippingupdate',url);
				}
				else
				{
					alert("배송업체가 없습니다. 팝업 닫기 후 다시 시작해주세요.");
				}
			}
			else
			{
				alert("주문번호가 없습니다. 팝업 닫기 후 다시 시작해주세요.");
			}
		}
	}
	function childdelClose()
	{
		//window.close();
		opener.opener.location.href = "javascript:parentdelClose();";
		opener.close();
		self.close();
	}
	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj)
		if(obj["apiCode"]=="goodsshipping")
		{
			var data="";
			$("#deliID tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+='<tr style="cursor:pointer;" class="putpopdata" onclick="shippingupdate(\''+value["delicode"]+'\', \''+value["od_code"]+'\');" >';
					data+='<td>'+value["delicode"]+'</td>';
					data+='<td class="l">'+value["odChartPK"]+' '+value["od_title"]+'</td>';
					data+='<td>'+value["re_sendname"]+'</td>';
					data+='<td>'+value["re_name"]+'</td>';
					data+='<td  class="l">'+value["re_address"]+'</td>';
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='5'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#deliID tbody").html(data);

			getsubpage("delilistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"]=="goodsshippingupdate")
		{
			if(obj["resultCode"]=="200")
			{
				alert("묶음배송 처리되었습니다.");
				childdelClose();
			}
		}
	}

	callapi('GET','goods','goodsshipping',"<?=$apiData?>");
</script>