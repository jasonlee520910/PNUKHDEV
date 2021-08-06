<?php  //반제품 재고추가 팝업
	$root = "..";
	include_once $root."/_common.php";

	$seq = $_GET["seq"];//현재상품seq
	$gdTypeCode = $_GET["gdTypeCode"];//현재상품gdTypeCode
	$goods = urldecode($_GET["goods"]);//현재상품
	$apidata = "seq=".$seq;
?>
<!-- s: 제품구성 -->
<style>
	h1.goodstit{font-weight:bold;font-size:30px;padding:40px;}
	#goodstbl{table-layout:fixed;border-top:1px solid #ccc;border-left:1px solid #ccc;margin:30px 0;width:95%;margin:auto;}
	#goodstbl tr th, #goodstbl tr td{padding:20px;border-right:1px solid #ccc;border-bottom:1px solid #ccc;font-size:20px;font-weight:bold;}
	td#goodssubtd{padding:0;vertical-align:top;}
	table#goodsaddtbl{margin:0;}
	table#goodsaddtbl tr th, table#goodsaddtbl tr td{padding:5px;border-bottom:1px solid #ccc;}
	.gdMade{width:60%;height:40px;font-size:25px;font-weight:bold;margin-right:20px;}
	.layer-wrap .btn a{margin:0 10px;}
</style>
<input type="hidden" name="popseq" value="<?=$seq?>">
<div class="layer-wrap layer-medical">
	<div class="layer-top">
		<h2 onclick="setGoods(<?=$_GET["seq"]?>)"><?=$txtdt["1933"]?><!-- 재고등록 --></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind">닫기</span></a>
	</div>
	<div>
		<h1 class="goodstit"><?=$goods?></h1>
		<table id="goodstbl">
		<col width="15%;">
		<col width="35%;">
		<col width="50%;">
		<tbody>
		</tbody>
		</table>
	</div>
	<?php 
	if($gdTypeCode=="goods")  //제품일때는 
	{
	?>
			<div class="btn mg20t c">
				<a href="javascript:;" class="cdp-btn" onclick="discardGoodsupdate()"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a>
				<a href="javascript:;" class="cw-btn close" onclick="closediv('viewlayer')"><span><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
			</div>
	<?php 
	}
	else
	{
	?>
			<div class="btn mg20t c">
				<a href="javascript:;" class="cdp-btn" onclick="pregoodsupdate()"><span><?=$txtdt["1070"]?><!-- 등록/수정 --></span></a>
				<a href="javascript:;" class="cw-btn close" onclick="closediv('viewlayer')"><span><?=$txtdt["1595"]?><!-- 닫기 --></span></a>
			</div>
	<?php 
	}
	?>
</div>

<script>
	//제품상세 API 호출
	callapi('GET','goods','goodsdescpop',"<?=$apidata?>");
</script>
