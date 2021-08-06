<?php //한의원관리
$root = "../..";
include_once ($root.'/_common.php');
?>
<script>
	$.datepicker.setDefaults({
			dateFormat: 'yy.mm.dd',
			prevText: '이전 달',
      nextText: '다음 달',
      monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
      monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
      dayNames: ['일', '월', '화', '수', '목', '금', '토'],
      dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
      dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
      showMonthAfterYear: true,
      yearSuffix: '년'
		});

	$(function(){
		//달력
		$("#sdate").datepicker({
			maxDate :  $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#edate").val()),
			onSelect:function(selectedDate){
				$("#edate").datepicker('option', 'minDate', $.datepicker.parseDate($.datepicker._defaults.dateFormat, selectedDate));
			}
		});
		$("#edate").datepicker({
			minDate :  $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#sdate").val()),
			onSelect:function(selectedDate){
				$("#sdate").datepicker('option', 'maxDate', $.datepicker.parseDate($.datepicker._defaults.dateFormat, selectedDate));
			}
		});
	})
</script>
<input type="hidden" name="miUserid" class="reqdata" value="<?=$miUserid?>">
<input type="hidden" name="seq" class="reqdata" value="">
<input type="hidden" name="status" class="reqdata" value="">

<div id="pagegroup" value="member"></div>
<div id="pagecode" value="membermedicallist"></div>

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
				<th><span><?=$txtdt["1038"]?><!-- 기간선택 --></span></th>
				<td><?=selectperiod()?></td>
			<tr>
				<th><span><?=$txtdt["1455"]?><!-- 상태별 --></span></th>
				<td><?=statusType()?></td>
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
		<p class="fl"></p>
			<?php if($modifyAuth == "true" || $modifyAuth == "admin"){?>
				<p class="fr">
					<button class="btn-blue"><span onclick="descview('add')">+ <?=$txtdt["1407"]?><!-- 한의원등록 --></span></button>
				</p>
			<?php }?>
	</div>

	<table id="tbllist" class="tblcss">
		<caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>
		<colgroup>
			<col scope="col" width="15%">
			<col scope="col" width="5%">
			<col scope="col" width="10%">
			<col scope="col" width="5%">
			<col scope="col" width="*">
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width="10%">
		</colgroup>
		<thead>
			<tr>
				<th><?=$txtdt["1408"]?><!-- 한의원이름 --></th>
				<th><?=$txtdt["1891"]?><!-- 한의원등급 --></th>
				<th><?=$txtdt["1061"]?><!-- 대표자명 --></th>
				<th>한의사수<?//=$txtdt["1653"]?><!-- 회원수 --></th>
				<th><?=$txtdt["1307"]?><!-- 주소 --></th>
				<th><?=$txtdt["1059"]?><!-- 대표번호 --></th>
				<th><?=$txtdt["1014"]?><!-- 가입일 --></th>
				<th><?=$txtdt["1164"]?><!-- 상태 --></th>
				<th><?//=$txtdt["1164"]?><!-- 상태 --></th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='paging-wrap' id="medicallistpage"></div>
<!-- e : 게시판 페이징 -->

<script>
/*
	//한의원 등록
	function godescid(userid)
	{
		gowriteloadid(userid, "<?=$root?>/Skin/Member/MemberWrite.php");
	}

	function gowriteloadid(userid, url)
	{
		var data = "?userid="+userid;
		if(isEmpty(userid))
		{
			$("#comSearchData").val('');
		}
		//console.log("gowriteload  ========:>>>>  url = " + url + data);
		$("#listdiv").load(url + data);
	}


*/

	function descview(userid)
	{
		if(userid=='add')
		{
			console.log("추가");
			var hdata=location.hash.replace("#","").split("|");
			console.log("hdata"+hdata);
			var page=hdata[0];
			if(page==undefined){page="";}
			var search=hdata[2];
			if(search ===undefined){search="";}
			makehash(page,userid,search);
			//$("#listdiv").load("<?=$root?>/Skin/Member/MemberWrite.php?");
		}
		else
		{
			console.log("상세보기");
			var hdata=location.hash.replace("#","").split("|");
			console.log("hdata"+hdata);
			var page=hdata[0];
			if(page==undefined){page="";}
			var search=hdata[2];
			if(search ===undefined){search="";}
			makehash(page,userid,search);
			//var data = "userid="+userid;
			//$("#listdiv").load("<?=$root?>/Skin/Member/MemberWrite.php?"+data);
		}	
	}

	function repageload(){
	console.log("no  repageload ");
	}

	function goApproval(seq,status)
	{
		var txt="";
		console.log(seq);
		console.log(status);

		$("input[name=seq]").val(seq); 
		$("input[name=status]").val(status);


		if(status=="apply")
		{
			txt="승인하시겠습니까?";
		}
		else if(status=="confirm")
		{
			txt="승인취소하시겠습니까?";
		}
		else 
		{
			txt="";
		}
	
		if(!isEmpty(txt))
		{
			if(confirm(txt))
			{
				var key=data="";
				var jsondata={};

				$(".reqdata").each(function(){
					key=$(this).attr("name");
					data=$(this).val();
					jsondata[key] = data;
				});

				callapi("POST","member","medicaldoctorupdate",jsondata);
				location.reload();
			}
		}
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);
		var data=miStatus=Btn="";
		if(obj["apiCode"]=="membermedicallist")
		{
			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					miStatus = memberstatus(value["miStatus"]);

					Btn = memberBtn(value["Btn"],value["seq"]);
				
					data+="<tr>";
					data+="<td style='cursor:pointer;' onclick=\"descview('"+value["miUserid"]+"')\">"+value["miName"]+"</td>"; //한의원이름
					data+="<td>"+value["miGrade"]+"</td>"; //한의원등급
					data+="<td>"+value["miDoctor"]+"</td>"; //대표자명
					data+="<td>"+value["memCnt"]+"</td>";   //회원수
					data+="<td class='l'>["+value["miZipcode"]+"] "+value["miAddress"]+"</td>"; //주소
					data+="<td>"+value["miPhone"]+"</td>"; //대표번호
					data+="<td>"+value["miDate"]+"</td>"; //가입일
					data+="<td>"+miStatus+"</td>"; //상태
					data+="<td>"+Btn+"</td>"; //버튼
					data+="</tr>";
				});				
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='8'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			//테이블에 넣기
			$("#tbllist tbody").html(data);
			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			//페이징
			getsubpage("medicallistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
		}
	}

	//스탭 상태
	function memberstatus(status)
	{
		var carr=["confirm","apply","delete","reject","ready"];  //일반회원과 정회원으로 나뉘면서  ready 추가됨
		var txt=cls=departtxt=stattxt="";
		for(var i=0;i<carr.length;i++)
		{
			if(carr[i]=status)
			{
				switch(carr[i])
				{
					case "confirm":txt="<?=$txtdt['1185']?>"/*"승인"*/;cls="r-stat08";break;
					case "apply":txt="<?=$txtdt['1055']?>"/*"대기"*/;cls="r-stat12";break;
					//case "standby":txt="승인<?=$txtdt['1055']?>중"/*"대기"*/;cls="r-stat12";break;
					case "delete":txt="<?=$txtdt['1360']?>"/*"탈퇴"*/;cls="r-stat00";break;
					case "reject":txt="<?=$txtdt['1318']?>"/*"차단"*/;cls="r-stat07";break;
				}
			}
		}
		departtxt+="<span class='r-stat "+cls+"'>"+txt+"</span>";
		return departtxt;
	}

	//상태값에 따른 버튼 
	function memberBtn(status,seq)
	{
		var carr=["confirm","apply","delete","ready"];//"reject"
		var txt=cls=departtxt=stattxt="";
		for(var i=0;i<carr.length;i++)
		{
			if(carr[i]=status)
			{
				switch(carr[i])
				{
					case "confirm":txt="차단하기";cls="r-stat15";break;
					case "apply":txt="승인하기";cls="r-stat16";break;
					//case "standby":txt="승인<?=$txtdt['1055']?>중"/*"대기"*/;cls="r-stat12";break;
					case "delete":txt=""/*"탈퇴"*/;cls="r-stat10";break;
					//case "reject":txt=""/*"차단"*/;cls="r-stat14";break;
				}
			}
		}
		departtxt+="<span class='r-stat "+cls+"' onclick='goApproval(\""+seq+"\",\""+status+"\");' style='cursor:pointer;'>"+txt+"</span>";
		return departtxt;
	}


	//한의원리스트 API 호출
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
		if(sarr[1]!=undefined)var sarr2=sarr[1].split("=");
		if(sarr[2]!=undefined)var sarr3=sarr[2].split("=");
		if(sarr[3]!=undefined)var sarr4=sarr[3].split("=");
		if(sarr[4]!=undefined)var sarr5=sarr[4].split("=");
		if(sarr1[1]!=undefined)var sdate=sarr1[1];
		if(sarr2[1]!=undefined)var edate=sarr2[1];
		if(sarr3[1]!=undefined)var searchTxt=sarr3[1];
		if(sarr4[1]!=undefined)var searchStatus=sarr4[1];
		if(sarr5[1]!=undefined)var searchPeriodEtc=sarr5[1];
		
		$("input[name=sdate]").val(sdate);
		$("input[name=edate]").val(edate);
		$("input[name=searchTxt]").val(decodeURI(searchTxt));
		//searPeriodEtc
		//------------------------------------------------------
		//상태 체크박스 
		//------------------------------------------------------
		var starr=searchStatus.split(",");
		for(var i=0;i<starr.length;i++){
			if(starr[i]!=""){
				$(".searchStatus"+starr[i]).attr("checked",true);
			}
		}
		//------------------------------------------------------
		
		//------------------------------------------------------
		//기간선택 라디오박스 
		//------------------------------------------------------
		var pearr=searchPeriodEtc.split(",");
		for(var i=0;i<pearr.length;i++){
			if(pearr[i]!=""){
				$(".searPeriodEtc"+pearr[i]).attr("checked",true);
			}
		}
		//------------------------------------------------------

		apiOrderData="&sdate="+sdate+"&edate="+edate+"&searchTxt="+searchTxt+"&searchStatus="+searchStatus;
	}

	var apidata="page="+page+apiOrderData;
	console.log("apidata     : "+apidata);
	callapi('GET','member','membermedicallist',apidata);
	$("#searchTxt").focus();

</script>
