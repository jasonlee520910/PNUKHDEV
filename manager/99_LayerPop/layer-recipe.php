<?php   //수기처방에서 처방검색 버튼 클릭시 고유처방/ 이전처방/ 약속처방 주문가능하게 처리
	$root = "..";
	include_once $root."/_common.php";
	$goodstype=$_GET["goodstype"];//사전조제처방 __ 제환에서 넘어온 데이터 
	if($goodstype=="pill")
	{
		$_GET["type"]="pill";
	}
	else
	{
		//상시처방이 제일 앞으로 하자 
		if($_GET["type"]=="")$_GET["type"]="Unique";  //layer-recipe 열었을때 처음 기본값은 고유처방
	}

	$type = $_GET["type"];
	$page = $_GET["page"];//현재페이지 
	$psize = $_GET["psize"];//
	$block = $_GET["block"];//	
	$pagegroup = "recipe";
	$medicalId = "";
	$goods=$_GET["goods"];//사전조제처방에서..넘어온 데이터 


	if($goods=="Y" && $type=="Unique")
	{
		$type=$_GET["type"]="commercial";
	}

	switch($_GET["type"])
	{
		case "Unique":
			$carr=array("rcSourceTxt","rcTitle","rcMedicine","rcMedicnt");
			//처방집,처방명,약재,약미
			$tarr=array($txtdt["1462"],$txtdt["1323"],$txtdt["1497"],$txtdt["1498"]);
			$pagecode = "uniquesclist";
			$medicalId = "";
			break;
		case "General":
			$carr=array("rcTitle","reName","rcMedicine","rcMedicnt");
			//$tarr=array("처방명","환자명","약재","약미");
			$tarr=array($txtdt["1323"],$txtdt["1414"],$txtdt["1497"],$txtdt["1498"]);
			$pagecode = "generalsclist";
			$medicalId = "&medicalId=all";
			break;
		case "smu": //세명대 상시처방
			$carr=array("rcSourceTxt","rcTitle","rcMedicine","rcMedicnt");
			//처방집,처방명,약재,약미
			$tarr=array($txtdt["1462"],$txtdt["1323"],$txtdt["1497"],$txtdt["1498"]);
			$pagecode = "smulist";
			$medicalId = "";
			break;
		case "worthy":  //실속처방
			$carr=array("rcTitle","reName","rcMedicine","rcMedicnt");
			//$tarr=array("처방명","환자명","약재","약미");
			$tarr=array($txtdt["1323"],$txtdt["1497"],$txtdt["1498"]);
			$pagecode = "worthylist";
			$medicalId = ""; ///worthy 실속처방
			break;
		case "commercial":  //상용처방
			$carr=array("rcTitle","reName","rcMedicine","rcMedicnt");
			//$tarr=array("처방명","환자명","약재","약미");
			$tarr=array($txtdt["1323"],$txtdt["1497"],$txtdt["1498"]);
			$pagecode = "commerciallist";
			$medicalId = ""; //상용 commercial
			break;
		case "goods":  //약속처방
			$carr=array("rcTitle","reName","rcMedicine","rcMedicnt");
			//$tarr=array("처방명","환자명","약재","약미");
			$tarr=array($txtdt["1323"],$txtdt["1497"],$txtdt["1498"]);
			$pagecode = "recipegoodslist";
			$medicalId = ""; //rc_medical='goods'
			break;
		case "pill":  //제환처방 
			$carr=array("rcTitle","reName","rcMedicine","rcMedicnt");
			//$tarr=array("처방명","환자명","약재","약미");
			$tarr=array("제품명","구성요소","구성");
			$pagecode = "recipepilllist";
			$medicalId = ""; //rc_medical='goods'
			break;


			
	}

	$apirecipeData = "page=".$page."&psize=".$psize."&block=".$block.$medicalId;

?>
<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<!--약재리스트가 처방에 따라 재선택 됩니다. 재선택 하시겠습니까?  -->
<!-- <input type="hidden" name="txt1495" value="<?=$txtdt["1495"]?>">
<input type="hidden" name="txt1496" value="<?=$txtdt["1496"]?>"> -->
<!-- s: 처방검색 -->
<div class="layer-wrap layer-recipe">
	<div class="layer-top">
		<h2><?=$txtdt["1321"]?><!-- 처방검색 --></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind">닫기</span></a>
	</div>
	<div class="layer-con">
		<div class="u-tab01" style="margin-bottom:5px;">
			<ul>
				<?php  if($goods=="Y") {?>
					<?php if($goodstype=="pill") { ?>
						<li class="<?php if($_GET["type"]=="pill")echo "over";?>"><a href="javascript:;" data-bind="pill"><span>제환처방<?//=$txtdt["1924"]?></span></a></li>
					<?php } else { ?>
						<li class="<?php if($_GET["type"]=="commercial")echo "over";?>"><a href="javascript:;" data-bind="commercial"><span><?=$txtdt["1925"]?><!-- 상용 처방 --></span></a></li>
						<li class="<?php if($_GET["type"]=="goods")echo "over";?>"><a href="javascript:;" data-bind="goods"><span><?=$txtdt["1924"]?><!-- 약속처방 --></span></a></li>
					<?php } ?>					
				<?php  } else {?>
					<li class="<?php if($_GET["type"]=="Unique")echo "over";?>"><a href="javascript:;" data-bind="Unique"><span><?=$txtdt["1026"]?><!-- 고유처방--></span></a></li> 
					<li class="<?php if($_GET["type"]=="General")echo "over";?>"><a href="javascript:;" data-bind="General"><span><?=$txtdt["1249"]?><!-- 이전처방 --></span></a></li>
					<li class="<?php if($_GET["type"]=="commercial")echo "over";?>"><a href="javascript:;" data-bind="commercial"><span><?=$txtdt["1925"]?><!-- 상용 처방 --></span></a></li>
				<?php  } ?>
			</ul>
		</div>
		<div class="list-select">
			<p class="fl"><?=selectsearch()?></p>
		</div>
		<div class="board-list-wrap">
			<span class="bd-line"></span>
			<table id="pop_recipetbl" style="table-layout:fixed">
				<colgroup>
				<?php if($_GET["type"]=="worthy" || $_GET["type"]=="commercial" || $_GET["type"]=="goods"|| $_GET["type"]=="pill"){?>
				 <col scope="col" width="">
				 <col scope="col" width="40%">
				 <col scope="col" width="8%">
				<?php }else{?>
				 <col scope="col" width="20%">
				 <col scope="col" width="18%">
				 <col scope="col" width="">
				 <col scope="col" width="8%">
				 <?php }?>
				</colgroup>
				<thead>
					<tr>
					<?php for($m=0;$m<count($tarr);$m++){?>
						<th><?=$tarr[$m]?></th>
					<?php }?>
					</tr>
				</thead>
				<tbody>	
				</tbody>
			</table>
		</div>
		<div class="sgap"></div>
		<!-- s : 게시판 페이징 -->
		<div class='pagingpop-wrap' id="recipelistpage"></div>
		<!-- e : 게시판 페이징 -->
	</div>
</div>
<!-- e: 처방검색 -->
<script>
	function putpopdata(obj)
	{
		var chk="Y";
		var rcMedicine=$("input[name=rcMedicine]").val();
		if(!isEmpty(rcMedicine))
		{	
			var txt = '<?=$txtdt["1495"]?> \n <?=$txtdt["1496"]?>';
			if(!confirm(txt))
			{
				chk="N";
			}
		}
		if(chk=="Y")
		{
			var type=$("div.u-tab01 ul li.over a").attr("data-bind");
			var seq = obj.getAttribute("data-id");
			var code = obj.getAttribute("data-code");
			var title = obj.getAttribute("data-title");
			$("input[name=rc_seq]").val(seq);
			$("input[name=rc_type]").val(type);

			$("input[name=rc_source]").val(code);
			//$("input[name=odScription]").val(code);
			$("input[name=odTitle]").val(title);
			console.log("type = " + type);
			if(type=="pill")
			{
				var pillorder=$("textarea[name=pillorder"+seq+"]").val();
				$("textarea[name=rcPillorder]").val(pillorder);
				$("input[name=maType]:radio[value=pill]").prop("checked", true);//제환
			}
			else
			{
				$("textarea[name=rcPillorder]").val("");
				//$("input[name=maType]:radio[value=decoction]").prop("checked", true);//탕제 
				$("input[name=maType]:radio[value="+type+"]").prop("checked", true);//탕제 
			}

			console.log(" 페이지 다시 로드 ");
			//조제타입에 따른 페이지 다시 로드 
			changeMatype();
			//var data = "seq="+seq+"&type="+type;
			//console.log("medicinerecipe    :"+data+", code = " + code);
			//callapi('GET','medicine','medicinerecipe',data);

		}
		closediv('viewlayer');

	}

	$(".u-tab01 ul li a").on("click",function()
	{
		console.log("click ");
		var goods="<?=$goods?>";
		var type=$(this).attr("data-bind");
		var medicalId=goodsdata=goodstype="";
		if(type == 'General')
			medicalId = "&medicalId=all";

		if(type=="pill")
		{
			goodstype="&goodstype=pill";
		}
	
		if(!isEmpty(goods) && goods=="Y")
		{
			goodsdata="&goods=Y";
		}
		var data = "&page=1&psize=5&block=10"+medicalId+goodsdata+goodstype;
		console.log("type   >>>  "+type);
		console.log("data   >>>  "+data);
		var url="<?=$root?>/99_LayerPop/layer-recipe.php?type="+type+data;
	

		viewlayer(url,700, 600,"");
	});


	var type = '<?=$type?>';
	if(type == 'General')
	{
		//약재리스트 API 호출
		callapi('GET','recipe','generalsclist','<?=$apirecipeData?>');
	}
	else if(type == 'Unique')
	{
		//고유처방 API 호출
		callapi('GET','recipe','uniquesclist','<?=$apirecipeData?>');
	}
	else if(type == 'smu')
	{
		//세명대 상시처방리스트 API 호출
		//callapi('GET','recipe','smulist','<?=$apirecipeData?>');
	}
	else if(type == 'worthy') //실속처방
	{
		callapi('GET','recipe','worthylist','<?=$apirecipeData?>');
	}
	else if(type == 'commercial') //상용처방
	{
		callapi('GET','recipe','commerciallist','<?=$apirecipeData?>');
	}
	else if(type == 'goods') //약속처방
	{
		callapi('GET','recipe','recipegoodslist','<?=$apirecipeData?>');
	}
	else if(type == 'pill') //제환처방
	{
		callapi('GET','recipe','recipepilllist','<?=$apirecipeData?>');
	}

	$("input[name=searchTxt]").focus();
</script>
