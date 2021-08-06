<?php 
	/// 수기처방입력 > 한의원 > 검색 버튼 눌렀을 경우 
	$root = "..";
	include_once $root."/_common.php";

	$page = $_GET["page"];//현재페이지
	$psize = $_GET["psize"];//
	$block = $_GET["block"];//
	$ordertype=$_GET["ordertype"];


	if($_GET["searchPop"])
	{
		$searchPop = $_GET["searchPop"];//
		$arr=explode("|",$_GET["searchPop"]);
		foreach($arr as $val)
		{
			$arr2=explode(",",$val);
			${$arr2[0]}=$arr2[1];
		}
	}
	$_GET["searpoptxt"]=$searpoptxt;

	$apimedicalData = "page=".$page."&psize=".$psize."&block=".$block."&searchPop=".$searchPop;

	$pagegroup = "member";
	$pagecode = "medicallist";

?>
<!-- s: 한의원 검색 -->
<style>
	.medical-detail{display:none;}
</style>

<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<div class="layer-wrap layer-medical">
	<div class="layer-top">
		<h2><?=$txtdt["1405"]?><!-- 한의원 검색 --></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind">닫기</span></a>
	</div>
	<!-- s: 한의원 검색 결과 -->
	<div class="layer-con medical-result">
		<div class="list-select">
			<p class="fl">
				<input type="text" class="w200 seartext_pop" title="<?=$txtdt["1021"]?>" name="searpoptxt" value="<?=$_GET["searpoptxt"]?>" onkeydown="searchpopkeydown(event)" />
				<button type="button" class="cdp-btn medical-btn"  onclick="pop_search()"><span><?=$txtdt["1020"]?><!-- 검색 --></span></button>
			</p>
		</div>
		<div class="board-list-wrap">
			<span class="bd-line"></span>
			<table class="poptbl" id="pop_medicaltbl">
				<colgroup>
				 <col scope="col" width="40%">
				 <col scope="col" width="30%">
				 <col scope="col" width="*">
				</colgroup>
				<thead>
				 <tr>
						<th><?=$txtdt["1593"]?><!-- 병원명 --></th>
						<th><?=$txtdt["1642"]?><!-- 원장 --></th>
						<th><?=$txtdt["1143"]?><!-- 사업자등록번호 --></th>
					</tr>
				</thead>
				 <tbody>
				</tbody>
			</table>
		</div>
		<div class="sgap"></div>
		<!-- s : 게시판 페이징 -->
		<div class='pagingpop-wrap' id="medicallistpage"></div>
		<!-- e : 게시판 페이징 -->
		<div class="mg20t c">
			<a href="javascript:;" class="cw-btn close" onclick="closediv('viewlayer')"><span><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
		</div>
	</div>
</div>

<script>
	function putpopdata(obj)
	{
		console.log("putpopdata 한의원 검색에서 클릭시  ===========================  ");
		var oid = obj.getAttribute("data-id");
		var oname = $(obj).find("td:eq(0)").text();
		var odoctor = obj.getAttribute("data-doctor");
		var mizipcode = obj.getAttribute("data-zipcode");
		var miaddr = obj.getAttribute("data-addr");
		var miphone = obj.getAttribute("data-phone");
		var mimobile = obj.getAttribute("data-mobile");
		var migrade = obj.getAttribute("data-grade");

		console.log("oid : "+oid+", oname : "+oname+", odoctor : "+odoctor+", mizipcode = " + mizipcode+", miaddr = " + miaddr);
		$("#miUserid").val(oid);
		$("#miName").text(oname);  //input  text 박스를 없앰
		$("input[name=miName]").val(oname);
		$("input[name=miZipcode]").val(mizipcode);
		$("input[name=miAddress]").val(miaddr);
		$("input[name=miPhone]").val(miphone);//한의원이름
		$("input[name=miMobile]").val(mimobile);//한의원이름
		$("input[name=miGrade]").val(migrade);//한의원등급 

		if(!isEmpty(odoctor))
		{
			var darr2="";
			var darr=odoctor.split(",");
			var str = "<select name='odStaff' class='reqdata' >";
			for(var i=0;i<darr.length;i++)
			{
				darr2=darr[i].split("|");
				str+="<option value='"+darr2[1]+"'>"+darr2[0]+"</option>";
			}
			str+="</select>";

			//$("select[name=odStaff]").html(str);
		}

		$("#odStaffDiv").html(str);

		closediv('viewlayer');

		setReleaseInfo();
		changeDelitype();

		var ordertype="<?=$ordertype?>";

		console.log("################한의원검색시에 페이지 다시 로드 ordertype : " + ordertype);



		//조제타입에 따른 페이지 다시 로드 
		if(!isEmpty(ordertype)&&ordertype=="order")
		{
			changeMatype();
		}

		//파우치, 한약박스, 포장박스, 제환, 항아리, 스틱 list 새로 받아서 다시 갱신하자 
		//callapi('GET','member','medicalimg',"medicalID="+oid);

		

	}

	/*$(".research").on("click",function(){
		$(".medical-search").fadeIn(100).css({"height":"253px","padding":"25px","display":"block"});
		$(".medical-result").fadeOut(100).css("display","none");
	});*/
	function pop_search()
	{
		var data = url = pagedata = "";
		pagedata = $("#comPageData").val();
		data = "page=1&psize=5&block=10"+getsearpopdata();

		url="<?=$root?>/99_LayerPop/layer-medical.php?"+data;

		viewlayer(url,700, 600,"");

		console.log("pop_search  ========================================>>>>>>>>>>>>>  url = " + url);
	}

	//주문리스트 API 호출
	callapi('GET','member','medicallist',"<?=$apimedicalData?>");

//	$(".medical-search").css("display", "block");
//	$(".medical-result").css("display", "block");

	$("input[name=searpoptxt]").focus();
</script>
