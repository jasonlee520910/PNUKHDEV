<?php 
/*
	$adm="../../_adm";
	include_once $adm."/common.php";
	if($_GET["searchPop"]){
		$arr=explode("|",$_GET["searchPop"]);
		foreach($arr as $val){
			$arr2=explode(",",$val);
			${$arr2[0]}=$arr2[1];
		}
	}
	$_GET["searchType"]=$searchType;
	$_GET["searchTxt"]=$searchTxt;
	if($_GET["page"]=="")$page=$_GET["page"]=1;
	$_GET["psize"]=5;
	$carr=array("rbCode","rbTitle","rbIndex","rbBookno");
	$tarr=array("처방집코드","처방서적","대목차","책번호");
	$json=json_decode(getapidata("forsclist"),true);
	*/
//echo $json["sql"];

	$root = "..";
	include_once $root."/_common.php";

	$page = $_GET["page"];//현재페이지 
	$psize = $_GET["psize"];//
	$block = $_GET["block"];//
	

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

	$apirecipeData = "page=".$page."&psize=".$psize."&block=".$block."&searchPop=".$searchPop;

	$pagegroup = "recipe";
	$pagecode = "forsclist";

	$carr=array("rbCode","rbTitle","rbIndex","rbBookno");
	//$tarr=array("처방코드","처방서적","대목차","책번호");
	$tarr=array($txtdt["1463"],$txtdt["1324"],$txtdt["1057"],$txtdt["1319"]);
?>
<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<!-- s: 처방검색 -->
<div class="layer-wrap layer-recipe">
	<div class="layer-top">
		<h2><?=$txtdt["1325"]?><!-- 처방서적검색 --></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind"><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
	</div>
	<div class="layer-con">
		<div class="list-select">
			<p class="fl"><?=selectsearch()?></p>
		</div>
		<div class="board-list-wrap">
			<span class="bd-line"></span>
			<table id="forsclisttbl">
				<colgroup>
				 <col scope="col" width="35%">
				 <col scope="col" width="35%">
				 <col scope="col" width="15%">
				 <col scope="col" width="15%">
				</colgroup>
				<thead>
					<tr>
						<?php for($m=0;$m<count($tarr);$m++){?>
							<th><?=$tarr[$m]?></th>
						<?php }?>
					</tr>
				</thead>
				<tbody>
				<!-- <?php foreach($json["list"] as $val){?>
					<tr class="putpopdata" data-code="<?=$val["seq"]?>">
					<?php for($m=0;$m<count($carr);$m++){?>
						<td><?=$val[$carr[$m]];?></td>
					<?php }?>
					</tr>
				<?php }?>
				-->
				</tbody>
			</table>
		</div>
		<div class="sgap"></div>
		<!-- s : 게시판 페이징 -->
		<div class='pagingpop-wrap' id="recipebooklistpage"></div>
		<!-- e : 게시판 페이징 -->
	</div>
</div>
<!-- e: 처방검색 -->
<script>
/*
	$(".putpopdata").on("click",function(){
		var code=$(this).children("td").eq(0).text();
		var title=$(this).children("td").eq(1).text();
		var index=$(this).children("td").eq(2).text();
		var bookno=$(this).children("td").eq(3).text();
		$("input[name=rcSource]").val(code);
		$("#rbSource").text(title);
		$("#rbIndex").text(index+" / "+bookno);
		closediv('viewlayer');
	});

	$(".searchbtn").on("click",function(){
		gopage_pop(1);
	});

	$(".u-tab01 ul li a").on("click",function(){
		var type=$(this).attr("data-bind");
		var url="/_adm/99_LayerPop/layer-recipebook.php?type="+type;
		viewlayer(url,650,550,"")
	});

	$(".research").on("click",function(){
		$(".medical-search").fadeIn(100).css({"height":"253px","padding":"25px","display":"block"});
		$(".medical-result").fadeOut(100).css("display","none");
	});
	*/
	function putpopdata(obj)
	{
		var code=$(obj).find("td:eq(0)").text();
		var title=$(obj).find("td:eq(1)").text();
		var index=$(obj).find("td:eq(2)").text();
		var bookno=$(obj).find("td:eq(3)").text();

		console.log("code : "+code+", title : "+title+", index : "+index + ", bookno : " + bookno);

		$("input[name=rcSource]").val(code);
		$("#rbSource").text(title);
		$("#rbIndex").text(index+" / "+bookno);

		closediv('viewlayer');

	}

	callapi('GET','<?=$pagegroup?>','<?=$pagecode?>',"<?=$apirecipeData?>");
</script>
