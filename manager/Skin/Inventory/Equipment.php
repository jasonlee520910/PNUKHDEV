<?php //장비관리 리스트
$root = "../..";
include_once ($root.'/_common.php');
$pagegroup = "inventory";
$pagecode = "equipmentlist";
?>
<style>
	#chkcode {color:blue;}
</style>
<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<input type="hidden" name="modifyAuth" class="" value="<?=$modifyAuth?>">
<input type="hidden" name="apiCode" class="reqdata" value="equipmentupdate">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Inventory/Equipment.php">

<!--// page start -->
<div class="board-view-wrap" id="boardviewDiv">
	<span class="bd-line"></span>
	<table>
		<caption><span class="blind"></span></caption>
		
		<colgroup>
		<col width="180">
		<col width="*"> 
		</colgroup>
		
		<tbody>
			<tr>
				<th>장비상태<?//=$txtdt["1364"]?><!-- 탕전기상태 --></th>
				<td><?=selectstatus()?></td>
			</tr>
			<tr>
				<th><span><?=$txtdt["1020"]?><!-- 검색 --></span></th>
				<td><?=selectsearch()?></td>
			</tr>	
		</tbody>
	</table>
</div>

<div class="gap"></div>

<div class="board-list-wrap">
	<span class="bd-line"></span>
	<div class="list-select">
	<span id="pagecnt" class="tcnt" style="float:left"></span>
		<p class="fr">
			<?php if($modifyAuth == "true" || $modifyAuth == "admin"){?>
			   <button type="button" class="btn-blue">
				<span class="modinput_" onclick="modinput('add_equipment','', '<?=$txtdt["1070"]?>,<?=$txtdt["1153"]?>,<?=$txtdt["1481"]?>')">+ 장비추가<?//=$txtdt["1365"]?><!--탕전기 추가 --></span>
				</button>
			<?php }?>
		</p>
	</div>
	<table id="tbllist" class="tblcss">
		<caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>

		<colgroup>
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width="*">
			<col scope="col" width="10%">
			<col scope="col" width="6%">
			<col scope="col" width="6%">
			<col scope="col" width="6%">
			<col scope="col" width="10%">
			<col scope="col" width="10%">
		</colgroup>

		<thead>
			<tr>
				<th>장비그룹<?//=$txtdt["1362"]?><!-- 탕전 바코드 --></th>
				<th>장비종류<?//=$txtdt["1362"]?><!-- 탕전 바코드 --></th>
				<th>장비코드<?//=$txtdt["1362"]?><!-- 탕전 바코드 --></th>
				<th>장비명<?//=$txtdt["1548"]?><!-- 탕전기명 --></th>
				<th><?=$txtdt["1086"]?><!-- 모델명 --></th>
				<th colspan="3"><?=$txtdt["1240"]?><!-- 위치 --></th>
				<th><?=$txtdt["1164"]?><!-- 상태 --></th>
				<th><?=$txtdt["1289"]?><!-- 제조일 --></th>
			</tr>
		</thead>

		<tbody>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='paging-wrap' id="equipmentlistpage"></div>
<!-- e : 게시판 페이징 -->

<script>
	function chkMcCode()
	{
		var mccode=$("input[name=mcCode]").val();
		console.log("chkMcCodechkMcCodechkMcCode mccode = " + mccode);
		if(!isEmpty(mccode))
		{
			var url="mcCode="+mccode;
			callapi("GET","inventory","equipmentcheckcode",url);
		}
	}
	function equipmentupdate()
	{
		var key=data="";
		var jsondata={};

		//radio data
		$(".radiodata").each(function()
		{
			key=$(this).attr("name");
			data=$(":input:radio[name="+key+"]:checked").val();
			jsondata[key] = data;
		});

		$(".reqdata").each(function(){
			key=$(this).attr("name");
			data=$(this).val();
			jsondata[key] = data;
		});

		console.log(JSON.stringify(jsondata));

		callapi("POST","inventory","equipmentupdate",jsondata);
		
	}
	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="equipmentlist")
		{
			var data = "";
		
			var eqType = parsedecocodes(obj["eqTypeList"], '장비그룹', 'eqType', null);
			var eqGroup= parsedecocodes(obj["eqGroupList"], '장비코드', 'eqGroup', null);
			var mcStatus= parsedecocodes(obj["mcStatusList"], '상태', 'mcStatus', null);
			
			$("#boardviewDiv").prepend("<textarea name='selstat' style='display:none;'>"+eqGroup+"</textarea><textarea name='selstat2' style='display:none;'>"+eqType+"</textarea><textarea name='selstat3' style='display:none;'>"+mcStatus+"</textarea>");
			var btnName = '<?=$txtdt["1070"]?>,<?=$txtdt["1153"]?>';//txt1199 약재검색,txt1070 등록/수정,txt1153 삭제,txt1098 바코드출력

			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					data+="<tr class='modinput modinput_"+value["seq"]+"' style='cursor:pointer;' onclick=\"modinput('_equipment','"+value["seq"]+"', '"+btnName+"')\">";
					data+="<td data-group='"+value["mcGroup"]+"'>"+value["mcGroupName"]+"</td>"; //장비그룹
					data+="<td data-type='"+value["mcType"]+"'>"+value["mcTypeName"]+"</td>"; //장비종류
					data+="<td>"+value["mcCode"]+"</td>";//장비코드
					data+="<td>"+value["mcTitle"]+"</td>"; //장비명
					data+="<td>"+value["mcModel"]+"</td>"; //모델명
					data+="<td>"+value["mcLocate"]+"</td>"; //위치
					data+="<td>"+value["mcTop"]+"</td>"; //위치
					data+="<td>"+value["mcLeft"]+"</td>"; //위치
					data+="<td data-status='"+value["mcStatus"]+"'>"+value["mcStatusName"]+"</td>"; //상태
					data+="<td>"+value["mcDate"]+"</td>"; //제조일
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='10'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#tbllist tbody").html(data);

			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			getsubpage("equipmentlistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
		else if(obj["apiCode"]=="equipmentcheckcode")
		{
			if(obj["resultCode"]=="200"&&obj["resultMessage"]=="OK")
			{
				$("#chkcode").text("사용하실수 있는 코드입니다.");
			}
			else
			{
				$("#chkcode").text(obj["resultMessage"]);
			}
			$("input[name=mcCode]").val(obj["mc_code"]);
		}
	}

	//장비관리  API 호출
	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	var apiOrderData="";
	var search=hdata[2];
	if(page==undefined){
		page=1;
	}

	if(search==undefined || search==""){
		var searchTxt="";
	}else{
		var sarr=search.split("&");
		if(sarr[0]!=undefined)var sarr1=sarr[0].split("=");	
		if(sarr[1]!=undefined)var sarr2=sarr[1].split("=");	//검색단어	
		if(sarr2[2]!=undefined)var sarr3=sarr2[1].split("="); //승인상태별

		if(sarr1[1]!=undefined)var searchTxt=sarr1[1]; //검색단어	
		if(sarr2[1]!=undefined)var searchStatus=sarr2[1]; //승인상태별	
	
		$("input[name=searchTxt]").val(decodeURI(searchTxt));
		
		var starr=searchStatus.split(",");
		for(var i=0;i<starr.length;i++){
			if(starr[i]!=""){
				$(".searchStatus"+starr[i]).attr("checked",true);
			}
		}
		apiOrderData="&searchTxt="+searchTxt+"&searchStatus="+searchStatus;
	}

	var apidata="page="+page+apiOrderData;
	console.log("apidata     : "+apidata);

	callapi('GET','<?=$pagegroup?>','<?=$pagecode?>',apidata);
	$("#searchTxt").focus();
</script>
