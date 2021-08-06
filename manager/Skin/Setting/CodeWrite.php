<?php
$root = "../..";
include_once ($root.'/_common.php');
$apidata="seq=".$_GET["seq"];
if($_GET["seq"]=="add"){
	$apidata="seq=";
	$seq="";
}else{
	$apidata="seq=".$_GET["seq"];
	$seq=$_GET["seq"];
}
// echo $apidata;
?>

<input type="hidden" name="apiCode" class="reqdata" value="codeupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Setting/CodeManager.php">

<div class="board-view-wrap">
	<span class="bd-line"></span>
	<table>
		<caption><span class="blind"></span></caption>
		<colgroup>
			<col width="180">
			<col width="*">
			<col width="180">
			<col width="*">
		</colgroup>
		<tbody>
			<tr>
				<th><span class="nec"><?=$txtdt["1034"]?><!-- 그룹코드 --></span></th>
				<td><input type="text" name="cdType" class="reqdata necdata" title="<?=$txtdt["1034"]?>" value="" /></td>
				<th><span class=""><?=$txtdt["1035"]?><!-- 그룹코드명 --></span></th>
				<td>
					<?=$txtdt["1718"]?><br><input type="text" name="cdTypeTxtkor" class="w60p reqdata" title="<?=$txtdt["1035"]?>" value="" /><br>
					<?=$txtdt["1719"]?><br><input type="text" name="cdTypeTxtchn" class="w60p reqdata" title="<?=$txtdt["1035"]?>" value="" />
				</td>
			</tr>
			<tr>
				<th><span class=""><?=$txtdt["1442"]?><!-- 그룹코드설명 --></span></th>
				<td colspan="3">
					<?=$txtdt["1718"]?><textarea name="cdDesckor" rows="" class="reqdata" cols="" style="width:99%;height:50px;" title="<?=$txtdt["1442"]?>"></textarea>
					<?=$txtdt["1719"]?><textarea name="cdDescchn" rows="" class="reqdata" cols="" style="width:99%;height:50px;" title="<?=$txtdt["1442"]?>"></textarea>
				</td>
			</tr>
		</tbody>
	</table>

	<table style="width:100%;">
		<caption><span class="blind"></span></caption>
		<colgroup>
			<col width="180">
			<col width="*">
		</colgroup>
		<tbody>
			<tr>
				<th>
					<span><?=$txtdt["1169"]?><!-- 서브코드명 --></span><br>
					<?
					if($_GET["seq"]) //seq가 있을때만 서브코드추가 버튼 보이기
					{
					?>
						<button class="sp-btn" type="button"><span onclick="addsubcode()">+ <?=$txtdt["1170"]?><!-- 서브코드추가 --></span></button>
					<?
					}
					?>
				</th>
				<td style="padding:0;">
					<style>
						.subtbl2 li dl{padding:0;overflow:hidden;}
						.subtbl2 li dl dt{background:#ececec;font-weight:bold;text-align:center;height:30px;padding:10px 0 0 0;}
						.subtbl2 li dl dt,.subtbl2 li dl dd{float:left;width:13%;}
						.subtbl2 li dl dd{padding:5px 0 5px 0;}
						.subtbl2 li dl dt.subsmall,.subtbl2 li dl dd.subsmall{width:7%;}
						.subtbl2 li dl dt.subval,.subtbl2 li dl dd.subval{width:20%;}
						.subtbl2 li dl dt.subbtn,.subtbl2 li dl dd.subbtn{width:13%;float:right;text-align:right;}
						.subtbl2 li dl dd input,.subtbl2 li dl dd textarea{width:90%;border:1px solid #ccc;}
					</style>
					<ul class="subtbl2" style="margin:0;">
						<li>
							<dl>
								<dt class="subsmall">순서(sort)<?//=$txtdt["1166"]?><!-- 서브코드 --></dt>
								<dt><?=$txtdt["1166"]?><!-- 서브코드 --></dt>
								<dt><?=$txtdt["1169"]?>_<?=$txtdt["1718"]?><!-- 서브코드명 --></dt>
								<dt><?=$txtdt["1169"]?>_<?=$txtdt["1719"]?><!-- 서브코드명 --></dt>
								<dt class="subval"><?=$txtdt["1167"]?>_<?=$txtdt["1718"]?><!-- 서브코드값 --></dt>
								<dt class="subval"><?=$txtdt["1167"]?>_<?=$txtdt["1719"]?><!-- 서브코드값 --></dt>
								<dt class="subbtn"></dt>
							</dl>
						</li>
						<li id="codesubtbl"></li>
					</ul>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="btn-box c" id="btnDiv"></div>
</div>

<!--// page end -->
<script>
	function subcodeupdate(idx)
	{
		if(necdata()=="Y") //필수조건 체크
		{
			var key=data="";
			var jsondata={};
			console.log(idx);

			$(".subreqdata"+idx).each(function(){
				key=$(this).attr("name");
				data=$(this).val();
				jsondata[key] = data;
			});
			console.log(JSON.stringify(jsondata));
			callapi("POST","setting","subcodeupdate",jsondata);
		}
	}

	function countsubcode()
	{
		var i = 0;
		$("#codesubtbl dl").each(function()
		{
			i++;
		});

		return i;
	}

	//서브코드추가 버튼
	function addsubcode(idx, arr)
	{
		//console.log(arr);
		var seq=cdType=cdCode=cdName=cdValue=txt=subreqdata=cdNamekor=cdNamechn=cdValuekor=cdValuechn=cdSort="";
		if(isEmpty(idx))
		{
			idx = countsubcode();
		}
		if(!isEmpty(arr))
		{
			seq = (!isEmpty(arr["seq"])) ? arr["seq"] : "";
			cdType = cdType = $("input[name=cdType]").val();
			cdCode = (!isEmpty(arr["cdCode"])) ? arr["cdCode"] : "";
			cdSort = (!isEmpty(arr["cdSort"])) ? arr["cdSort"] : "";
			cdNamekor = (!isEmpty(arr["cdNamekor"])) ? arr["cdNamekor"] : "";
			cdNamechn = (!isEmpty(arr["cdNamechn"])) ? arr["cdNamechn"] : "";
			cdValuekor = (!isEmpty(arr["cdValuekor"])) ? arr["cdValuekor"] : "";
			cdValuechn = (!isEmpty(arr["cdValuechn"])) ? arr["cdValuechn"] : "";
			txt="<dl >";
		}
		else
		{
			$("#subcodedl").remove();
			cdType = $("input[name=cdType]").val();
			txt="<dl id='subcodedl'>";
		}
		subreqdata="subreqdata"+idx;
		console.log("idx = " + idx);
		console.log("subreqdata = " + subreqdata);

		txt+="<dd class='subsmall'><input type='text' name='cdSort' value='"+cdSort+"' class='"+subreqdata+"'></dd>";
		txt+="<dd>";
		txt+="<input type='hidden' name='apiCode' class='"+subreqdata+"' value='subcodeupdate'><input type='hidden' name='returnData' class='"+subreqdata+"' value='<?=$root?>/Skin/Setting/CodeManager.php'>";
		txt+="<input type='hidden' name='seq' value='"+seq+"' class='"+subreqdata+"'><input type='hidden' name='cdType' value='"+cdType+"' class='"+subreqdata+"'><input type='text' name='cdCode' value='"+cdCode+"' class='"+subreqdata+"'>";
		txt+="</dd>";
		txt+="<dd><input type='text' name='cdNamekor' value='"+cdNamekor+"' class='"+subreqdata+"'></dd>";
		txt+="<dd><input type='text' name='cdNamechn' value='"+cdNamechn+"' class='"+subreqdata+"'></dd>";
		txt+="<dd class='subval'><textarea name='cdValuekor' rows='' cols='' class='"+subreqdata+"'>"+cdValuekor+"</textarea></dd>";
		txt+="<dd class='subval'><textarea name='cdValuechn' rows='' cols='' class='"+subreqdata+"'>"+cdValuechn+"</textarea></dd>";
		txt+="<dd class='subbtn'>";
		txt+="<button type='button' class='cdp-btn' onclick='subcodeupdate("+idx+");'><span><?=$txtdt['1441']?></span></button> ";
		if(!isEmpty(arr))
		{
			var json = "seq="+seq;
			txt+="<button type='button' class='cdp-btn' onclick='callapidel(\"setting\",\"subcodedelete\",\""+json+"\")'><span><?=$txtdt['1154']?></span></button>";
		}
		txt+="</dd>";
		txt+="</dl>";
		$("#codesubtbl").prepend(txt);
	}

	function codeupdate()
	{
		if(necdata()=="Y") //필수조건 체크
		{
			var key=data="";
			var jsondata={};

			$(".reqdata").each(function(){
				key=$(this).attr("name");
				data=$(this).val();
				jsondata[key] = data;
			});
			console.log(JSON.stringify(jsondata));
			callapi("POST","setting","codeupdate",jsondata);
		}
	}

    function makepage(json)
    {
	    var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"]=="codedesc") //약재출고등록
		{
			//그룹코드
			$("input[name=cdType]").val(obj["cdType"]);
			//그룹코드명
			$("input[name=cdTypeTxtkor]").val(obj["cdTypeTxtkor"]);
			$("input[name=cdTypeTxtchn]").val(obj["cdTypeTxtchn"]);
			//그룹코드설명
			$("textarea[name=cdDesckor]").val(obj["cdDesckor"]);
			$("textarea[name=cdDescchn]").val(obj["cdDescchn"]);

			console.log("1111111  cdDesckor = "+obj["cdDesckor"]+", cdDescchn = "+obj["cdDescchn"]);

			$("#codesubtbl").html("");
			$(obj["list"]).each(function( index, value )
			{
				console.log(JSON.stringify(value));
				addsubcode(index, value);
			});

			var btnHtml='';
			var json = "seq="+obj["cdType"];

			btnHtml='<a href="javascript:;" onclick="codeupdate();" class="bdp-btn"><span><?=$txtdt["1441"]?></span></a> ';//저장하기
			btnHtml+='<a href="javascript:;" onclick="golistload();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록
			btnHtml+='<a href="javascript:;" onclick="callapidel(\'setting\',\'codedelete\',\''+json+'\')" class="bdp-btn"><span><?=$txtdt["1154"]?></span></a>';//삭제하기

			$("#btnDiv").html(btnHtml);
		}
		return false;
    }

	callapi('GET','setting','codedesc','<?=$apidata?>'); 	//약재출고등록 상세 API 호출

	$("input[name=cdType]").focus();
</script>
