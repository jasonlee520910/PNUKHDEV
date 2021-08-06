<?php 
	$root = "..";
	include_once $root."/_common.php";

	$page = $_GET["page"];//현재페이지
	$psize = $_GET["psize"];//
	$block = $_GET["block"];//
	$type = $_GET["type"];
	$cypk = $_GET["cypk"];
	$title = $_GET["title"];
	$site = $_GET["site"];
	

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
	$odkeycode=$_GET["odkeycode"];

	$apidata = "page=".$page."&psize=".$psize."&block=".$block."&searchPop=".$searchPop."&reData=".$type."&cypk=".$cypk;


	if($type=="goods")
	{
		$pagegroup = "goods";
		$pagecode = "goodsgoodslist";
	}
	else
	{
		$pagegroup = "recipe";
		$pagecode = "recipemedicallist";
	}

?>
<!-- s: 한의원 검색 -->
<style>
	.medical-detail{display:none;}
</style>

<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<div class="layer-wrap layer-medical">
	<div class="layer-top">
		<h2><?php  if($type=="goods"){echo "약속처방";}else if($type=="commercial"){echo "상비";}else if($type=="worthy"){echo "실속";}else{echo "약속처방 탕전";}?> 상품검색</h2>
		<a href="javascript:;" class="close-btn" onclick="closegoodsdiv('viewgoodslayer')"><span class="blind">닫기</span></a>
	</div>
	<!-- s: 검색 결과 -->
	<div class="layer-con goods-result">
		<div class="list-select">
			<p class="fl">
				<input type="text" class="w200 seartext_pop" title="<?=$txtdt["1021"]?>" name="searpoptxt" value="<?=$_GET["searpoptxt"]?>" onkeydown="searchpopkeydown(event,'<?=$type?>')" />
				<button type="button" class="cdp-btn medical-btn"  onclick="pop_search()"><span><?=$txtdt["1020"]?><!-- 검색 --></span></button>
			</p>
		</div>
		<p style="font-size:15px;font-weight:bold;color:red;margin-bottom:7px;">
			[<?=$site?>]<?=$title?>(<?=$cypk?>)<br>
		</p>
		<div class="board-list-wrap">
			<span class="bd-line"></span>
			<table class="poptbl" id="pop_goodstbl">
				<colgroup>
					<col scope="col" width="17%">
					<col scope="col" width="28%">
					<col scope="col" width="*">
					<col scope="col" width="10%">
				</colgroup>
				<thead>
				 <tr>
						<th>PK<!-- PK --></th>
						<th><?=$txtdt["1926"]?><!-- 제품코드 --></th>
						<th><?=$txtdt["1928"]?><!-- 제품명 --></th>
						<th><?=$txtdt["1929"]?><!-- 구성요소 --></th>
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
			<a href="javascript:;" class="cw-btn close" onclick="closegoodsdiv('viewgoodslayer')"><span><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
		</div>
	</div>
</div>

<script>
	function closegoodsdiv(id){
		gogoodsscreen("close");
		$("#"+id).remove();
	}
	function putpopdata(obj)
	{
		console.log("putpopdata goods 클릭시  ===========================  ");
		var title="<?=$title?>";
		var cypk="<?=$cypk?>";
		var type="<?=$type?>";
		var odkeycode="<?=$odkeycode?>";

		var clicktitle=$(obj).find("td:eq(2)").text();//제품명
		var clickseq=obj.getAttribute("data-seq");
		

		var message="<?=$txtdt['1934']?>";//등록할 상품 : [1]선택한 상품 : [2]선택하신 상품으로 등록하시겠습니까?
		message=message.replace("[1]",title+"\n");
		message=message.replace("[2]",clicktitle+"\n\n");

		if(confirm(message) == true)
		{
			$("#gdMarking option:eq(0)").prop("selected",true);
			$("#div_goodsDecoc").hide();


			closegoodsdiv('viewgoodslayer');
			var url="seq="+clickseq+"&cypk="+cypk+"&title="+encodeURIComponent(title);
			console.log("url = " + url);

			if(type=="goods")
			{
				callapi('GET','goods','nonegoods',url);
			}
			else if(type=="commercial")
			{
				url+="&odkeycode="+odkeycode;
				callapi('GET','recipe','nonerecipemedical',url);
			}
			else if(type=="worthy")
			{
				url+="&odkeycode="+odkeycode;
				callapi('GET','recipe','nonerecipemedical',url);
			}
			else
			{
				callapi('GET','recipe','nonerecipemedical',url);
			}
		}

	}

	function pop_search()
	{
		var odkeycode="<?=$odkeycode?>";
		var site="<?=$site?>";
		var cypk="<?=$cypk?>";
		var title=encodeURIComponent("<?=$title?>");
		var type="<?=$type?>";
		var data = "page=1&psize=5&block=10&type="+type+"&cypk="+cypk+"&title="+title+"&site="+site+"&odkeycode="+odkeycode;
		var url=data+getsearpopdata();
		url="<?=$root?>/99_LayerPop/layer-goodsmedical.php?"+data+getsearpopdata();
		viewgoodslayer(url);
		//callapi('GET','<?=$pagegroup?>','<?=$pagecode?>',url);
		console.log("GoodsBtn  ========================================>>>>>>>>>>>>>  url = " + url);
	}

	callapi('GET','<?=$pagegroup?>','<?=$pagecode?>',"<?=$apidata?>");

	$("input[name=searpoptxt]").focus();
</script>
