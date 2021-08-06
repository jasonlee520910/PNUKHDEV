<?php 
	$root = "..";
	include_once $root."/_common.php";
?>
<!-- s: -->
<div class="layer-wrap layer-medical">
	<div class="layer-top">
		<h2><?=$txtdt["1670"]?><!-- 취소사유 --></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind"><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
	</div>
	<div class="layer-con medical-search">
		<div class="board-view-wrap">
			<span class="bd-line"></span>
			<table>
					<caption><span class="blind"></span></caption>
					<colgroup>
						<col width="150">
						<col width="*"> 
					</colgroup>
					<tbody>	
						<tr>
							<th class="l"><span><?=$txtdt["1671"]?><!-- 사유선택 --></span></th>
							<td id="canceltypeDiv"></td>
						</tr>
						<tr>
							<th class="l"><span><?=$txtdt["1672"]?><!-- 사유입력 --></span></th>
							<td><textarea cols="50" rows="5" id="cancelText"></textarea></td>
						</tr>
				 </tbody>

			</table>
		</div>
		<div class="mg20t c">
			<a href="javascript:;" class="cdp-btn" onclick="ordercancelchange()"><span><?=$txtdt["1673"]?><!-- 취소하기 --></span></a>
			<a href="javascript:;" class="cw-btn close" onclick="closediv('viewlayer')"><span><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
		</div>
	</div>
</div>

<script>
	function ordercancelchange()
	{
		var seq='<?=$_GET["seq"]?>';
		var status='<?=$_GET["status"]?>';
		var page='<?=$_GET["page"]?>';
		var url=$("#comSearchData").val();
		var canceltype=$("select[name=cancelType]").val();
		var cancelText = $("#cancelText").val();

		if(isEmpty(cancelText))
		{
			alert('<?=$txtdt["1674"]?>'); //사유입력을 작성해 주세요.
			$("#cancelText").focus();
			return false;
		}

		url+='&seq='+seq;
		var arr=status.split("_");
		url+='&process='+arr[0];
		url+='&canceltype='+canceltype;
		url+='&cancelText='+cancelText;
		if(arr[1]=="apply"||arr[1]=="start"||arr[1]=="processing")
		{
			url+='&status=stop&statustxt=<?=$txtdt["1315"]?>';//중지
		}
		else if(arr[1]=="stop")
		{
			url+='&status=cancel&statustxt=<?=$txtdt["1356"]?>';//취소 
		}
		else if(arr[0]=="done")
		{
			//url+='&status=delivery_cancel&statustxt=<?=$txtdt["1356"]?>';//done 
			url+='&status=release_apply&statustxt=<?=$txtdt["1356"]?>';//done 
		}
		url+='&returnData=<?=$root?>/Skin/Order/OrderList.php';

		console.log("chkstatus  url = " + url);
		callapi('GET','order','orderchange',url);
		viewpage();
		closediv('viewlayer');
	}

	callapi('GET','order','ordercanceltype','');
</script>