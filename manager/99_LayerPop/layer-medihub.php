<?php  //본초검색
	$root = "..";
	include_once $root."/_common.php";

	if($_GET["searchPop"])
	{
		$arr=explode("|",$_GET["searchPop"]);
		foreach($arr as $val)
		{
			$arr2=explode(",",$val);
			${$arr2[0]}=$arr2[1];
		}
	}
	$_GET["searchType"]=$searchType;
	$_GET["searchTxt"]=$searchTxt;

	if($_GET["page"]=="")$page=$_GET["page"]=1;
	if($_GET["psize"]=="")$psize=$_GET["psize"]=5;
	if($_GET["block"]=="")$block=$_GET["block"]=10;

	if($_GET["type"]=="")$_GET["type"]="";
	if($_GET["sweet"]=="")$_GET["sweet"]="";

	$apimedicineData = "type=".$_GET["type"]."&page=".$_GET["page"]."&psize=".$_GET["psize"]."&block=".$_GET["block"]."&medicine=".$_GET["medicine"]."&searchPop=".URLEncode($_GET["searchPop"]);
	$pagegroup = "medicine";
	$pagecode = "hublist";
?>
<style>
.delspan{position:relative;display:none;overflow:hidden;width:0;height:0;}
.delspan .delbtn{position:absolute;background:#fff;color:#111;padding:0 5px 0 5px;cursor:pointer;}
#popmedilist dt{display:inline-block;background:#215295;color:#fff;padding:5px;margin:0 3px 3px 0;}
#popmedilist dt.dismatch{background:red;}
#popmedilist dt.poison{background:#444;}
#popmedilist dd{display:none;}

/* 팝업 tr height 고정 */
#laymedicinetbl
{	table-layout:fixed;
	word-wrap: break-word;
}
#laymedicinetbl tbody tr.putpopdata td
{
	height:40px;
	/* border: 1px solid green; */
	overflow:hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
	table-layout:fixed;
}
.stuff-list{min-height:20px;}
.stuff-list .btxt{clear:both;margin-top:-9px;}
.stuff-tab{padding:0 0 5px 0;overflow:hidden;}
.stuff-tab dl{clear:both;padding:3px 0 0 0;}
.stuff-tab dl dt{float:left;width:13px;height:13px;margin-right:0;}
.stuff-tab dl dd{float:left;line-height:110%;}
.stuff-tab .dismatchtxt dt{background:red;}
.stuff-tab .poisontxt dt{background:#444;}
</style>

<div id="pagegroup" value="<?=$pagegroup?>"></div>
<div id="pagecode" value="<?=$pagecode?>"></div>
<!-- s: 본초검색 -->
<div class="layer-wrap" id="layer_medicine_wrap">
	<div class="layer-top">
		<h2><?=$txtdt["1122"]?><!-- 본초검색 --></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind">닫기</span></a>
	</div>
	<div class="layer-con">
		<input type="hidden" name="poptype" value="<?=$_GET["type"]?>">
		<input type="hidden" name="popcode" value="<?=$_GET["code"]?>">
		<input type="hidden" name="rcMedicine_pop" value="" style="width:100%;">
			<div class="list-select">
				 <p class="fl">
					 <input type="text" class="w200 seartext_pop" title="<?=$txtdt["1021"]?>" name="searchTxt" value="<?=$_GET["searchTxt"]?>" onkeydown="searchpopkeydown(event)" />
					 <button type="button" class="cdp-btn medical-btn"  onclick="pop_search('<?=$_GET["type"]?>')"><span><?=$txtdt["1020"]?><!-- 검색 --></span></button>
				 </p>
			</div>
			<div class="board-list-wrap">
			<span class="bd-line"></span>
			<table id="laymedicinetbl">
				<colgroup>
				 <col scope="col" width="20%">
				 <col scope="col" width="20%">
				 <col scope="col" width="20%">
				 <col scope="col" width="20%">
				 <col scope="col" width="*">
				</colgroup>
				<thead>
						<th><?=$txtdt["1131"]?><!-- 본초코드 --></th>
						<th><?=$txtdt["1124"]?><!-- 본초명 --></th>
						<th><?=$txtdt["1400"]?><!-- 학명 --></th>
						<th><?=$txtdt["1461"]?><!-- 이명 --></th>
						<th><?=$txtdt["1028"]?><!-- 과명 --></th>
					</tr>
				</thead>
				 <tbody>

				</tbody>
			</table>
		</div>
		<div class="sgap"></div>
		<!-- s : 게시판 페이징 -->
<div class='paging-wrap' id="hublistpage"></div>
		<!-- e : 게시판 페이징 -->
	</div>
</div>
<!-- e: 약재검색 -->

<script>
var type="<?=$_GET['type']?>";
console.log("type   ---->"+type);

	//본초테이블에서 클릭하면 팝업이 사라지면서 본초 입력됨
	function putpopdata(obj)
	{
		var chk="N";
		if(type=="dismatch"){
			var mediinput="dmMedicine";
			var medi=$("input[name=dmMedicine]").val();
		}else if(type=="poison"){
			var mediinput="poMedicine";
			var medi=$("input[name=poMedicine]").val();
		}else{
			var medi="";
		}

		if(medi!="")
		{
			console.log(medi);
		}

		if(chk=="Y")
		{
			alertsign("warning",$("input[name=txt1483]").val()/*" 중복약재 "*/, "", "1500");
		}
		else
		{
			
			var mhCode=$(obj).find("td:eq(0)").text(); //본초코드
			var mhTitle=$(obj).find("td:eq(1)").text(); //본초명
			var mhStitle=$(obj).find("td:eq(2)").text(); //학명
			var mhDtitle=$(obj).find("td:eq(3)").text(); //별칭/이명
			var mhCtitle=$(obj).find("td:eq(4)").text(); //과명

			// console.log("mhCode = " + mhCode+", mhTitle = " + mhTitle);
			if(type=="medicine")
			{

				$("input[name=mhCode]").val(mhCode);
				$("#mhTitle").text(mhTitle);
				$("#mhStitle").text(mhStitle);
				$("#mhDtitle").text(mhDtitle);
				$("#mhCtitle").text(mhCtitle);
			}
			else
			{
				if(medi=="")
				{
					medi=mhCode;
				}
				else
				{
					medi=medi+","+mhCode;
				}
				$("input[name="+mediinput+"]").val(medi);
				$("#matchmedi").append("<dd id='"+mhCode+"' onmouseover=viewdelicon('"+mhCode+"','"+mhTitle+"',0) onmouseout=viewdelicon('"+mhCode+"','"+mhTitle+"',1) onclick=removemedi('dmMedicine','"+mhCode+"') data-code='"+mhCode+"'>"+mhTitle+"</dd>");
			}
			closediv('viewlayer');
		}
	}

	function pop_search(code)
	{
		var data = url = pagedata = "";
		pagedata = $("#comPageData").val();
		
		//var page=$("#hublistpage ul li a.active").text();
		//var txt="type=medicine&page="+page+"&psize=5&block=10&medicine=&searchPop=";
		//$("#comPageData").val(txt);
		//data = "type="+code+"&page="+page+"&psize=5&block=10"+getsearpopdata();
		data = "type="+code+"&page=1&psize=5&block=10"+getsearpopdata();
		url="<?=$root?>/99_LayerPop/layer-medihub.php?"+data;
		viewlayer(url,700, 600,"");

		console.log("pop_search  ========================================>>>>>>>>>>>>>  url = " + url);
	}
	//본초리스트 API 호출
	callapi('GET','medicine','hublist','<?=$apimedicineData?>');

	$("input[name=searchTxt]").focus();
</script>
