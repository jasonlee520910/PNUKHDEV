<?php //제품관리 리스트
$root = "../..";
include_once ($root.'/_common.php');
$pagegroup = "goods";
$pagecode = "goodslist";
?>
<style>
	#goodsaddtbl{}
	#goodsaddtbl tbody tr td{font-size:14px;font-weight:normal;}
	#goodsaddtbl tbody tr td input{width:80%;text-align:right;}
	#goodsaddtbl tbody tr td.ct{text-align:center;}
	#goodsaddtbl tbody tr td.bomdata{text-align:right;}
	#goodsaddtbl tbody tr td.bomdata .bomcapa{font-size:15px;font-weight:bold;margin-right:5px;}
	#goodsaddtbl tbody tr th{font-size:15px;}
	#goodsaddtbl tbody tr th.rt{text-align:right;}

</style>
<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<input type="hidden" name="modifyAuth" class="" value="<?=$modifyAuth?>">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Goods/Goods.php">
<textarea name="selworker" rows="10" cols="100%" class="hidden" id="selworkerDiv"></textarea>
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
				<th>제품구분</th>
				<td><?=selectstatus()?></td>
			</tr>
			<tr>
				<th>제품TAG</th>
				<td><?=selectmatype()?></td>
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
		<span style="float:left;margin-left:20px;color:red;">* 제품명 클릭 시 제품 구성 가능합니다.</span>
		<span style="float:left;margin-left:900px;color:blue;">* 붉은색 제품은 적정수량에 비해 수량이 부족한 제품입니다.</span>
		<p class="fr">
			<?php if($modifyAuth == "true" || $modifyAuth == "admin"){?>
				<button class="btn-blue"><span onclick="viewdesc('add')">+ <?=$txtdt["1930"]?><!-- 제품등록 --></span></button>
			<?php }?>
		</p>
	</div>
	<table id="tbllist" class="tblcss">
		<caption><span class="blind">번호,분류,내용,담당자,등록일,완료예정일,완료일,중요도,상태를 나타내는 이슈관리 테이블 입니다.</span></caption>

		<colgroup>
			<col scope="col" width="5%">
			<!-- <col scope="col" width="5%"> -->
			<col scope="col" width="10%">
			<col scope="col" width="*">
			<col scope="col" width="7%">
			<col scope="col" width="7%">
			<col scope="col" width="7%">
			<col scope="col" width="7%">
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width="10%">
			<col scope="col" width="7%">
		</colgroup>

		<thead>
			<tr>			
				<th>종류</th>
				<th>품목코드</th>
				<th>제품명</th>
				<th>규격</th>
				<th>구성</th>
				<th>판매/소모량</th>
				<th>재고량</th>
				<th>최종입고일</th>
				<th>최종출고일</th>
				<th>등록/수정일</th>
				<th>재고추가</th>
			</tr>
		</thead>

		<tbody>
		</tbody>
	</table>
</div>

<div class="gap"></div>

<!-- s : 게시판 페이징 -->
<div class='paging-wrap' id="potcodelistpage"></div>
<!-- e : 게시판 페이징 -->
<style>
#addgdqty{position:absolute;width:400px;margin:-10px 0 0 -10px;background:#fff;border:3px solid #111;padding:10px;}
#addgdqty dl dt{width:100px;font-size:19px;font-weight:bold;display:inline-block;padding:5px 10px;}
#addgdqty dl dd{display:inline-block;padding:5px 10px;}
#addgdqty dl dd input{font-size:19px;font-weight:bold;}
#addgdqty p{padding:10px 10px;}
#addgdqty p button{margin:0 10px;}
.linked{font-weight:bold;cursor:pointer;}
</style>
<script>
	//반제품재고등록
	function pregoodsupdate()  //goodsdescpop
	{
		var key=data="";
		var jsondata={};
		var bomdata=[];

		$(".bomdata").each(function(){
			type=$(this).attr("data-type");
			code=$(this).attr("data-code");
			capa=$(this).children("input").val();
			bomdata.push([code,type,capa]);
		});
		if( $("input[name=typeWork]").prop("checked")==true){
			jsondata["typeWork"] = "minus";
		}else{
			jsondata["typeWork"] = "plus";
		}
		jsondata["bomdata"] = bomdata;
		jsondata["gdType"] = $("input[name=gdType]").val();
		jsondata["gdCode"] = $("input[name=gdCode]").val();
		jsondata["gdName"] = $(".goodstit").text();
		jsondata["doneqty"] = $("input[name=doneqty]").val();
		jsondata["stUserid"] = getCookie("ck_stUserid");//staffid 

		console.log(JSON.stringify(jsondata));
		callapi('POST','goods','pregoodsupdate',jsondata); 
		closediv('viewlayer');
	}

	function addGoodsqty(seq, goods)
	{
		var url="/99_LayerPop/layer-goodsadd.php?seq="+seq+"&goods="+encodeURI(goods);
		viewlayer(url,800,600,"");
	}

	function goodsqtyupdate(seq){
		var addcode=$("input[name=addcode]").val();
		var addqty=$("input[name=addqty]").val();
		if(addcode=="" || addqty < 1){
			alert("작업관리코드 또는 추가 제품량을 확인해주세요");
		}else{
			var key=data="";
			var jsondata={};
			jsondata["seq"] = seq;
			jsondata["addcode"] = addcode;
			jsondata["addqty"] = addqty;
			callapi("POST","goods","goodsqtyupdate",jsondata);
			$("#listdiv").load("<?=$root?>/Skin/Goods/Goods.php");
		}
	}

	function repageload(){
	console.log("no  repageload ");
	}

	function setGoods(seq){
		//alert();
		//var url="/99_LayerPop/layer-goods.php?seq="+seq;
		//viewlayer(url,1100,750,"");
	}

	//gdUse 가 Y이면 수정불가 
	function goodsviewdesc(seq,gdUse)
	{
		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		if(page==undefined){page="";}
		var search=hdata[2];
		if(search ===undefined){search="";}
		//location.hash=page+"|"+seq+"|"+search+"|"+gdUse;
		location.hash=page+"|"+seq+"|"+search;
	}

	function makepage(json)
	{
		var obj = JSON.parse(json);
		console.log(obj);

		if(obj["apiCode"]=="goodslist")
		{
			var data = "";
			$("#tbllist tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, val )
				{

					if(val["gdStable"] > val["gdQty"])//적정재고량보다 재고량이 부족한 경우 
					{
						trcolor="style='background-color: #FBEFEF;'";
					}
					else
					{
						trcolor="";
					}

					data+="<tr "+trcolor+" id='goods"+val["seq"]+"' >";					
					data+="<td>"+val["gdType"]+"</td>"; //종류
					//data+="<td>"+val["gdCategory"]+"</td>"; //분류
					data+="<td>"+val["gdCode"]+"</td>"; //품목코드
					data+="<td class='lf linked' onclick=\"goodsviewdesc('"+val["seq"]+"','"+val["gdUse"]+"')\" >"+val["gdName"]+"</td>"; //제품명
					data+="<td>"+val["gdSpec"]+"</td>";//규격
					data+="<td>"+val["gdBom"]+"</td>"; ///구성
					data+="<td>"+val["gdSales"]+"</td>"; ///판매/소모량
					data+="<td>"+val["gdQty"]+"</td>"; //재고량
					data+="<td class='indate'>"+val["incomingDate"]+"</td>"; //최종입고일
					data+="<td>"+val["outgoingDate"]+"</td>"; //최종출고일
					data+="<td>"+val["gdDate"]+"</td>"; //등록.수정일

					//if(val["gdTypeCode"]=="pregoods"){
						//data+="<td><button type='button' class='cdp-btn'><span class='cdp-btn' onclick=\"addGoodsqty("+val["seq"]+",'"+val["gdName"]+"');\">재고추가</span></button></td>"; //재고추가
					//}else{
						data+="<td>-</td>"; //재고추가
					//}
					data+="</tr>";
				});
			}
			else
			{
				data+="<tr>";
				data+="<td colspan='11'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}

			$("#tbllist tbody").html(data);

			$("#pagecnt").text(comma(obj["tcnt"])+" <?=$txtdt['1019']?>");
			getsubpage("potcodelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"]);
			return false;
		}
		else if(obj["apiCode"]=="goodspoplist")
		{
			//viewpoplist(obj);
		}
		else if(obj["apiCode"]=="goodsdesc")
		{
			goodsinfo(obj);
			console.log("gdType"+obj["gdType"]);
			var chkpage=$("#goodslistpage").attr("data-value");
			if(chkpage !="adddel"){
				switch(obj["gdType"]){
					case "goods":
						$("input:radio[name=searpoptype]").eq(0).attr("disabled",true);
						$("input:radio[name=searpoptype]:radio[value='pregoods']").prop('checked', true); // pregoods 선택하기
					break;
					case "pregoods":
						$("input:radio[name=searpoptype]").eq(0).attr("disabled",true);
						$("input:radio[name=searpoptype]").eq(1).attr("disabled",true);
						$("input:radio[name=searpoptype]:radio[value='material']").prop('checked', true); // material 선택하기
					break;
					case "material":
						$("input:radio[name=searpoptype]").eq(0).attr("disabled",true);
						$("input:radio[name=searpoptype]").eq(1).attr("disabled",true);
						$("input:radio[name=searpoptype]:radio[value='material']").prop('checked', true); // material 선택하기
					break;
					case "origin":
						$("input:radio[name=searpoptype]").eq(0).attr("disabled",true);
						$("input:radio[name=searpoptype]").eq(1).attr("disabled",true);
						$("input:radio[name=searpoptype]:radio[value='origin']").prop('checked', true); // origin 선택하기
					break;
				}
				//제품리스트 API 호출
				pop_listsearch();
			}
			$("input[name=searpoptxt]").focus();
		}
		else if(obj["apiCode"]=="goodsaddmaterial" || obj["apiCode"]=="goodsdelmaterial" || obj["apiCode"]=="goodsdelmaterialsub")
		{
			$("#goodslistpage").attr("data-value","adddel");
			var seq=obj["seq"];
			console.log(seq);
			callapi('GET','goods','goodsdesc',"seq="+seq);
		}
		else if(obj["apiCode"]=="goodsdescpop")
		{
			var bomdata="";
			var materialdata = "";
			var origindata = "";
			var bom=obj["bomcodeList"];
			bomdata+="<col width='15%'/> ";
			bomdata+="<col width='55%'/> ";
			bomdata+="<col width='30%'/> ";
			bomdata+="<tbody data-code='"+obj["gdCode"]+"' data-name='"+obj["gdName"]+"' data-type='"+obj["gdType"]+"' data-capa='"+obj["gdCapa"]+"' data-loss='"+obj["gdLoss"]+"' data-losscapa='"+obj["gdLosscapa"]+"' data-bomcapa='"+obj["bomtotCapa"]+"'>";
			for(var key in bom)
			{
				if(bom[key]["type"]=="material"){var unit="개";}else{var unit="g";}
				var subata="<tr>";
				subata+="<td class='ct'>"+bom[key]["name"]+"</td>";  
				subata+="<td>"+bom[key]["text"]+"</td>";  
				subata+="<td class='bomdata'  data-code='"+bom[key]["code"]+"'  data-type='"+bom[key]["type"]+"' data-capa='"+bom[key]["capa"]+"' data-loss='"+bom[key]["loss"]+"' data-losscapa='"+bom[key]["losscapa"]+"' data-gdcapa='"+bom[key]["gdcapa"]+"'><input type='hidden' name='capa' value='0'><b class='bomcapa'>0</b>"+unit+"</td>"; 
				subata+="</tr>";
				if(bom[key]["type"]=="material"){materialdata+=subata;}else{origindata+=subata;}
			}
			bomdata+=origindata;
			bomdata+="<tr><th colspan='2'>총 투입량</th><th class='rt' id='totcapa'>0 g/개</th></tr>";
			bomdata+=materialdata;
			bomdata+="</tbody>";

			var data="<tr>";
			data+="<th>종류</th><td>"+obj["gdTypeName"]+"<input type='hidden' name='gdType' class='reqdata'  value='"+obj['gdType']+"' "+"</td>"; //분류
			data+="<th>구성요소</th>"; //구성요소
			data+="</tr><tr>";
			//data+="<th>분류</th>><td>"+obj["gdCategory"]+"</td>"; //분류
			data+="<th>코드</th><td>"+obj["gdCode"]+"<input type='hidden' name='gdCode' class='reqdata'  value='"+obj['gdCode']+"' "+"</td>"; //코드
			//data+="<td rowspan='5'></td>"; //구성요소
			data+="<td rowspan='2' style='vertical-align:top;padding: 0;'>"; //구성요소
			data+="<table id='goodsaddtbl'>"+bomdata+"</table>";
			data+="</tr><tr>";
			data+="<th style='height:120px;'><?=$txtdt['1799']?><!-- 완성량 --><br><br>";
			data+="<span><input type='checkbox' name='typeWork'> 폐기</span>";
			//onchange='changeNumberGoods(event, false);'  제거
			data+="</th><td><input type='text' onfocus='this.select();' onkeyup='recountcapa(event, false);'  name='doneqty' style='width:60%;height:40px;font-size:30px;font-weight:bold;margin-right:20px;' class='reqdata necdata' value='' title='<?=$txtdt['1799']?>'>g/개"+"</td>"; //완성량
			data+="</tr>";

			$("#goodstbl tbody").html(data);
			$("input[name=doneqty]").focus();
		}
	}
/*
	function saveupdate(json){

		var obj = JSON.parse(json);
		console.log(obj);
		if(obj["apiCode"]=="pregoodsupdate")
		{
			if(location.hash.indexOf("renew") < 0) //포함되어있따면 
			{
				location.hash=location.hash+"|renew";
			}else{
				location.hash=location.hash.replace("|renew","");
			}
		}
	}
*/
	function recountcapa(evt, check){
		changeNumber(evt, check);
		var totCapa=0;
		var totCnt=parseInt($("input[name=doneqty]").val());
		var gdCode=$("#goodsaddtbl tbody").attr("data-code");
		var gdName=$("#goodsaddtbl tbody").attr("data-name");
		var gdType=$("#goodsaddtbl tbody").attr("data-type");
		var gdCapa=parseInt($("#goodsaddtbl tbody").attr("data-capa"));
		var gdLoss=parseInt($("#goodsaddtbl tbody").attr("data-loss"));
		var gdLosscapa=parseInt($("#goodsaddtbl tbody").attr("data-losscapa"));
		var bomCapa=parseInt($("#goodsaddtbl tbody").attr("data-bomcapa"));
		$("#goodsaddtbl tbody tr td.bomdata").each(function(){
			var type=$(this).attr("data-type");
			var capa=parseInt($(this).attr("data-capa"));
			var loss=parseInt($(this).attr("data-loss"));
			var losscapa=parseInt($(this).attr("data-losscapa"));
			var gdcapa=parseInt($(this).attr("data-gdcapa"));
			switch(type){
				case "pregoods":
					var useqty=0;
					//투입량 per계산
					var per=capa / bomCapa * 100;
					//2. 손실율계산
					useqty=totCnt + (totCnt * (gdLoss / 100));
					//3. 손실량 계산
					useqty= useqty + gdLosscapa;
					//1. 단위 곱하기
					useqty= useqty * per / 100;
					totCapa+=parseInt(useqty);
					break;
				case "material":
					var useqty=Math.ceil(totCnt / capa);
					break;
				case "origin":
					var useqty=0;
					//투입량 per계산
					per=capa / bomCapa * 100;
					//2. 손실율계산
					useqty=totCnt + (totCnt * (gdLoss / 100));
					//3. 손실량 계산
					useqty= useqty + gdLosscapa;
					//1. 단위 곱하기
					useqty= useqty * per / 100;
					totCapa+=parseInt(useqty);
					break;
			}
			$(this).children("input").val(useqty);
			$(this).children("b").text(comma(parseInt(useqty)));
		});
		$("#totcapa").text(comma(totCapa)+" g/개");
	}

	function viewpoplist(obj){
		var data = "";
		$("#pop_goods tbody").html("");
		if(!isEmpty(obj["list"]))
		{
			$(obj["list"]).each(function( index, value )
			{
				data+="<tr id='goodspop"+value["seq"]+"'>";
				data+="<td>"+value["gdType"]+"</td>"; //제품상태
				data+="<td>"+value["gdCode"]+"</td>"; //품목코드
				data+="<td class='lf'>"+value["gdName"]+"<span class='btnadd' onclick=\"addGoods('"+value["gdCode"]+"')\">▶▶</span></td>"; //제품명
				data+="</tr>";
			});
		}
		else
		{
			data+="<tr>";
			data+="<td colspan='3'><?=$txtdt['1665']?></td>";
			data+="</tr>";
		}
		$("#pop_goods tbody").html(data);
		//페이징
		getsubpage_pop("goodslistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"],"goods");
		return false;
	}

	function goodsinfo(obj){
		var data = "";
		$("#goodstit").text(obj["gdName"]);
		$("#pop_goodsinfo tbody").html("");
		if(!isEmpty(obj["gdBom"]))
		{
			$(obj["gdBom"]).each(function( index, value )
			{
				data+="<tr id='goodsinfo"+value["gdSeq"]+"'>";
				data+="<td>"+value["gdType"]+"</td>"; //제품상태
				data+="<td>"+value["gdCode"]+"</td>"; //품목코드
				data+="<td class='lf'><span class='btnx' onclick=\"delGoods('"+value["gdCode"]+"')\">X</span>"+value["gdName"]+"</td>"; //제품명
				data+="</tr>";
				console.log(value["gdBom"]);
				//console.log("gdBom"+value["gdBom"].length);
				if(value["gdBom"].length > 0){
					$(value["gdBom"]).each(function( index2, value2 )
					{
						data+="<tr id='goodsinfo"+value2["gdSeq"]+"'>";
						data+="<td style='text-align:right;margin-right:2px;'>&gt&gt&gt&gt</td>"; //제품상태
						data+="<td>"+value2["gdCode"]+"</td>"; //제품상태
						data+="<td class='lf'><span class='btnx' onclick=\"delGoodsSub('"+value["gdCode"]+"','"+value2["gdCode"]+"')\">X</span>["+value2["gdType"]+"] "+value2["gdName"]+"</td>"; //제품명
						data+="</tr>";
					});
				}
			});
		}
		else
		{
			data+="<tr>";
			data+="<td colspan='3'><?=$txtdt['1665']?></td>";
			data+="</tr>";
		}
		$("#pop_goodsinfo tbody").html(data);
		return false;
	}

	//탕전기관리  API 호출
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
		if(sarr[0]!=undefined)var sarr0=sarr[0].split("=");	
		if(sarr[1]!=undefined)var sarr1=sarr[1].split("=");	//검색단어	
		if(sarr[2]!=undefined)var sarr2=sarr[2].split("="); //승인상태별
		if(sarr[3]!=undefined)var sarr3=sarr[3].split("="); //제품tag
		if(sarr[4]!=undefined)var sarr4=sarr[4].split("="); //제품tag

		if(sarr0[1]!=undefined)var searchTxt=sarr0[1]; //검색단어	
		if(sarr1[1]!=undefined)var searchStatus=sarr1[1]; //승인상태별	
		if(sarr2[1]!=undefined)var searchProgress=sarr2[1]; //승인상태별	
		if(sarr3[1]!=undefined)var searchPeriodEtc=sarr3[1]; //승인상태별	
		if(sarr4[1]!=undefined)var searchMatype=sarr4[1]; //승인상태별	
	
		$("input[name=searchTxt]").val(decodeURI(searchTxt));
		
	}
	if(searchStatus=="" || searchStatus==undefined){searchStatus=",pregoods";}
	var starr=searchStatus.split(",");
	for(var i=0;i<starr.length;i++){
		if(starr[i]!=""){
			$(".searchStatus"+starr[i]).attr("checked",true);
		}
	}
	if(searchMatype=="" || searchMatype==undefined){searchMatype="";}
	var starr=searchMatype.split(",");
	for(var i=0;i<starr.length;i++){
		if(starr[i]!=""){
			$(".searchMatype"+starr[i]).attr("checked",true);
		}
	}
	apiOrderData="&searchTxt="+searchTxt+"&searchStatus="+searchStatus+"&searchMatype="+searchMatype;
	var apidata="page="+page+apiOrderData;
	console.log("apidata     : "+apidata);

	callapi('GET','<?=$pagegroup?>','<?=$pagecode?>',apidata);
	$("#searchTxt").focus();
</script>
