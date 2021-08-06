<?php 
	$root = "..";
	include_once $root."/_common.php";

	$seq = $_GET["seq"];//현재상품seq 상위seq
	$his = $_GET["his"];//현재상품seq 상위seq
	$title = $_GET["title"];//현재상품seq 상위seq
	$page = $_GET["page"];//현재페이지
	$psize = $_GET["psize"];//
	$block = $_GET["block"];//
	$searpoptype = $_GET["searpoptype"];//
	if($searpoptype=="")$searpoptype="pregoods";
	$searpoptxt = $_GET["searpoptxt"];//
	$apidata = "page=".$page."&psize=".$psize."&block=".$block."&searpoptype=".$searpoptype."&searpoptxt=".$searpoptxt."&seq=".$seq;
	$apiseq = "seq=".$seq;

	$pagegroup = "goods";
	$pagecode = "goodspoplist";

	/*
	$hisarr=explode(",",$his);
	$hisdat="<span>";
	foreach($hisarr as $val){
		$arr2=explode("|",$val);
		if($arr2[0]){
			$hisdat.="<i onclick=\"viewGoods(".$arr2[0].",'".urlencode($arr2[1])."')\">".urldecode($arr2[1])."</i>";
		}
	}
	$hisdat.="<i onclick=\"viewGoods(".$seq.",'".urlencode($title)."')\">".urldecode($title)."</i>";
	*/
?>
<!-- <input type="text" name="his" value="<?=$his?>,<?=$seq?>|<?=urlencode($title)?>"> -->
<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<!-- s: 제품구성 -->
<input type="hidden" name="popseq" value="<?=$seq?>">
<div class="layer-wrap layer-medical">
	<div class="layer-top">
		<h2 onclick="setGoods(<?=$_GET["seq"]?>)">제품구성<?//=$txtdt["1405"]?><!-- 제품구성 --></h2>
		<a href="javascript:;" class="close-btn" onclick="goodsPopclose()"><span class="blind">닫기</span></a>
	</div>
	<style>
		h1.goodstit{width:100%;font-size:19px;font-weight:bold;padding:20px 0 0 20px;}
		.half{width:45%;padding:0;margin:0;float:left;}
		dl.goodsinfo{overflow:auto; width:97%; height:600px;}
		dl.goodsinfo dt{font-size:17px;font-weight:bold;padding:26px 0 0 20px;}
		dl.goodsinfo dt span{float:right;}
		dl.goodsinfo dt span i{padding:5px;font-weight:bold;font-style:normal;font-size:13px;cursor:pointer;}
		#nowgoods{font-size:13px;}
		dl.goodsinfo dd{padding:10px 0;}
		.radiodiv{padding:10px 0 0 10px;font-size:15px;line-height:120%;}
		.radiodiv label{padding:10px 0 0 10px;font-size:15px;line-height:120%;}
		.radiodiv input{vertical-align:top;margin:0 5px 0 20px;width:15px;height:15px;}
		#pop_goods tbody tr:hover{background:#f4f4f4;cursor:pointer;}
		.btnx{float:left;;display:block;text-align:center;margin-right:10px;width:18px;height:18px;border-radius:3px;border:1px solid #333;}
		.btnx:hover{background:#333;color:#fff;cursor:pointer;}
		.btnadd{float:right;font-weight:bold;color:#111;font-size:15px;letter-spacing:-1px;}
	</style>
	<div class="half">
		<!-- s: 제품 검색 결과 -->
		<div class="radiodiv">
			<input type="radio" name="searpoptype" id="goods" value="goods" <?php if($searpoptype=="goods")echo "checked";?> onclick="pop_listsearch()"> 
			<label for="goods"> 제품 &nbsp;&nbsp;</label>

			<input type="radio" name="searpoptype" id="pregoods" value="pregoods" <?php if($searpoptype=="pregoods")echo "checked";?> onclick="pop_listsearch()"> 
			<label for="pregoods"> 반제품 &nbsp;&nbsp;</label>

			<input type="radio" name="searpoptype" id="material" value="material" <?php if($searpoptype=="material")echo "checked";?> onclick="pop_listsearch()">
			<label for="material"> 부자재 &nbsp;&nbsp;</label>

			<input type="radio" name="searpoptype" id="origin"  value="origin" <?php if($searpoptype=="origin")echo "checked";?> onclick="pop_listsearch()"> 
			<label for="origin"> 원재료 &nbsp;&nbsp;</label>
			<input type="radio" name="searpoptype" id="worthy"  value="worthy" <?php if($searpoptype=="worthy")echo "checked";?> onclick="pop_listsearch()"> 
			<label for="origin"> 실속 &nbsp;</label>
		</div>
		<div class="layer-con medical-result">
			<div class="list-select">
				<p class="fl">
					<input type="text" class="w200 seartext_pop" title="<?=$txtdt["1021"]?>" name="searpoptxt" value="<?=$_GET["searpoptxt"]?>" onkeydown="if(event.keyCode==13)pop_listsearch()" />
					<button type="button" class="cdp-btn medical-btn"  onclick="pop_listsearch()"><span><?=$txtdt["1020"]?><!-- 검색 --></span></button>
				</p>
			</div>
			<div class="board-list-wrap">
				<span class="bd-line"></span>
				<table class="poptbl" id="pop_goods">
					<colgroup>
					 <col scope="col" width="13%">
					 <col scope="col" width="30%">
					 <col scope="col" width="*">
					</colgroup>
					<thead>
					 <tr>
							<th>구분<?//=$txtdt["1593"]?><!-- 병원명 --></th>
							<th>코드<?//=$txtdt["1591"]?><!-- 한의사 --></th>
							<th class="lf">재료명<?//=$txtdt["1591"]?><!-- 한의사PK --></th>
						</tr>
					</thead>
					 <tbody>
					</tbody>
				</table>
			</div>
			<div class="sgap"></div>

			<!-- s : 게시판 페이징 -->
			<div class='pagingpop-wrap' id="goodslistpage"></div>
			<!-- e : 게시판 페이징 -->

			<div class="mg20t c">
				<!-- <a href="javascript:;" class="cdp-btn medical-btn research"><span><?=$txtdt["1493"]?>재검색</span></a> -->
				<a href="javascript:;" class="cw-btn close" onclick="goodsPopclose()"><span><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
			</div>
		</div>
	</div>
	<div class="half" style="width:55%;" >
		<h1 class="goodstit" id="goodstit">제품명 : </h1>
		<dl class="goodsinfo">
			<dt class="tit">제품구성목록<?=$hisdat?><!-- <span style="font-size: 17px;">1kg기준으로 용량을 적어주세요</span> --></dt>
			<dd>
				<div class="board-list-wrap">
					<span class="bd-line"></span>
					<table class="poptbl" id="pop_goodsinfo" >
						<colgroup>
						 <col scope="col" width="13%">
						 <col scope="col" width="25%">
						 <col scope="col" width="*">
						 <col scope="col" width="20%">
						 <col scope="col" width="15%">
						</colgroup>
						<thead>
						 <tr>
								<th>구분<?//=$txtdt["1593"]?><!-- 병원명 --></th>
								<th>코드<?//=$txtdt["1591"]?><!-- 한의사 --></th>
								<th class="lf">재료명<?//=$txtdt["1591"]?><!-- 한의사PK --></th>
								<th>용량<?//=$txtdt["1593"]?><!-- 병원명 --></th>
								<th>비율<?//=$txtdt["1593"]?><!-- 병원명 --></th>
							</tr>
						</thead>
						 <tbody>
						</tbody>
					</table>
						<a href="javascript:;" onclick="capaupdate();" style="float:right;">
							<button type="button" class="sp-btn"><span>적용하기<?//=$txtdt["1071"]?><!-- 등록/수정하기 --></span></button>
						</a>	
				</div>
			</dd>
		</dl>
	</div>
</div>

<script>
	function goodsPopclose(){
		closediv('viewlayer');
		renewhash();
	}
	//안씀 당분간
	function delGoodsSub(seq, code)
	{
		var apidata="seq="+seq+"&code="+code;
		callapi('GET','goods','goodsdelmaterialsub',apidata);

	}
	function renewhash(){
		var hsdata=location.hash;
		var chk=hsdata.indexOf("renew");
		if(chk<0){
			location.hash=hsdata+"|renew";
		}else{
			location.hash=hsdata.replace("|renew","");
		}
	}

	function delGoods(code)
	{
		var seq=$("input[name=popseq]").val();
		var apidata="seq="+seq+"&code="+code;
		callapi('GET','goods','goodsdelmaterial',apidata);
		//renewhash();
		console.log("삭제해서 리스트 다시 호출 >>>>>>> "+apidata);
		//callapi('GET','goods','goodsgoodsdesc',apidata);
	}
	//table tr 클릭시 
	function addGoods(code)
	{
		var seq=$("input[name=popseq]").val();
		
		if(isEmpty(seq)){seq="add";}	
		var apidata="seq="+seq+"&code="+code;
		console.log(" addGoods  ▶▶ 클릭시 "+apidata);
		callapi('GET','goods','goodsaddmaterial',apidata);
		//renewhash();
	}

	//검색
	function pop_listsearch()
	{
		var seq=$("input[name=popseq]").val();
		var searpoptype = $("input:radio[name=searpoptype]:checked").val();
		if(searpoptype==undefined)searpoptype="pregoods";
		var searpoptxt = $("input[name=searpoptxt]").val();
		//var page=$(".paging-wrap-pop").attr("data-page");
		var page=1;//페이지는 초기화
		if(page==undefined || page<1)page=1;
		var apidata="page="+page+"&psize=10&block=10";
		apidata+="&searpoptype="+searpoptype+"&searpoptxt="+searpoptxt+"&seq="+seq;
		console.log("pop_listsearch  apidata   >>  "+apidata);
		callapi('GET','goods','goodspoplist',apidata);
		//viewpoplist(obj);
	}

	//용량 update
	//function capaupdate(seq, code, value,evt,chk)
	//{
		/*
			changeNumber(evt, chk);
			console.log(seq+"_"+code+"_"+value);
			var apidata="seq="+seq+"&gdCode="+code+"&gdRate="+value;
			//callapi('GET','goods','goodsaddcapa',apidata);
			//renewhash();
			//callapi('GET','goods','goodsgoodsdesc',apidata);
		*/
	//}

/*
	오브젝트처리
	function capaupdate(){
		var jsondata={};
		var seq=$("input[name=popseq]").val();
		jsondata["seq"]=seq;
		$("#pop_goodsinfo tbody tr").each(function(){
			var type=$(this).attr("data-type");
			if(type!=undefined && type!=""){
				var code=$(this).children("td").eq(1).text();
				var capa=$(this).children(".capa").children("input").val();
				var per=$(this).children(".per").text();
				var obj = {code:code,capa:capa,per:per}
				jsondata[code]=obj;
			}
		});
console.log(jsondata);
		//callapi('POST','goods','goodsresetcapa',jsondata);
	}
*/

	function capaupdate(){
		var seq=$("input[name=popseq]").val();
		var apidata="seq="+seq+"&bomData=";
		$("#pop_goodsinfo tbody tr").each(function(){
			var type=$(this).attr("data-type");
			if(type!=undefined && type!=""){
				var code=$(this).children("td").eq(1).text();
				var capa=$(this).children(".capa").children("input").val();
				apidata+=","+code+"|"+capa;
			}
		});
		callapi('GET','goods','goodsresetcapa',apidata);
		goodsPopclose();
	}

	//제품상세 API 호출
	callapi('GET','goods','goodsdesc',"<?=$apiseq?>");
</script>
