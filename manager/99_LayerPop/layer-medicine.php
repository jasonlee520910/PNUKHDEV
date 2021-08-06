<?php   //약재입고
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
	$_GET["returnData"]=$_GET["type"];
	$_GET["reData"]=$_GET["type"];

	$apimedicineData = "reData=".$_GET["reData"]."&returnData=".$_GET["returnData"]."&type=".$_GET["type"]."&page=".$_GET["page"]."&psize=".$_GET["psize"]."&block=".$_GET["block"]."&sweet=".$_GET["sweet"]."&medicine=".$_GET["medicine"]."&searchPop=".URLEncode($_GET["searchPop"]);

	$pagegroup = "medicine";
	$pagecode = "medicinelist";

?>
<style>
.layer-con{height: 500px;/*overflow: auto;*/overflow-y:scroll;}
.delspan{position:relative;display:none;overflow:hidden;width:0;height:0;}
.delspan .delbtn{position:absolute;background:#fff;color:#111;padding:0 5px 0 5px;cursor:pointer;}
#popmedilist dt{display:inline-block;background:#215295;color:#fff;padding:5px;margin:0 3px 3px 0;}
#popmedilist dt.dismatch{background:red;}
#popmedilist dt.poison{background:#444;}
#popmedilist dd{display:none;}
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
<!-- s: 약재검색 -->
<div class="layer-wrap" id="layer_medicine_wrap">
	<div class="layer-top">
		<h2><?=$txtdt["1199"]?><!-- 약재검색 --></h2>
		<a href="javascript:;" class="close-btn" onclick="closediv('viewlayer')"><span class="blind">닫기</span></a>
	</div>
	<div class="layer-con">
			<input type="hidden" name="poptype" value="<?=$_GET["type"]?>">
			<input type="hidden" name="popcode" value="<?=$_GET["code"]?>">
			<input type="hidden" name="rcMedicine_pop" value="" style="width:100%;">
			<input type="hidden" name="rcSweet_pop" value="" style="width:100%;">
			<input type="hidden" name="medititle" value="" >
			<input type="hidden" name="mediorigine" value="" >
			<input type="hidden" name="medihub"  value="" >
			<input type="hidden" name="medicode"  value="" >

			<?php if($_GET["type"]=="stock"||$_GET["type"]=="medibox"){?>
				<div class="list-select">
					<p class="fl"><?=selectsearch()?></p>
					<p class="fr" id="poptotcnt">0</p>
				</div>
			<?php }else{?>
				<div class="list-select">
					<button class="cdp-btn" onclick="setmedicine()" style="float:right;"><span><?=$txtdt["1485"]?><!-- 적용완료 --></span></button>
					<p class="fl"><?=selectsearch()?></p>
				</div>
				<div class="stuff-list">
					<p class="btxt"><?=$txtdt["1486"]?><!-- 선택된약재 --></p>
					<dl id="popmedilist"><!-- <?=$medilist?> --></dl>
				</div>
				<div class="stuff-tab" id="stuff-tab">
				</div>
			<?php }?>
			<div class="board-list-wrap">
			<span class="bd-line"></span>
			<table id="laymedicinetbl" class="layertbl" style="table-layout:fixed">
				<colgroup>
				 <col scope="col" width="12%">
				 <col scope="col" width="25%">
				 <col scope="col" width="*">
				 <col scope="col" width="18%">
				 <col scope="col" width="15%">
				</colgroup>
				<thead>
			 		<tr>
						<th><?=$txtdt["1706"]?><!-- 약재타입 --></th>
						<th><?=$txtdt["1124"]?><!-- 본초명 --></th>
						<th><?=$txtdt["1204"]?>_<?=$txtdt["1750"]?><!-- 약재명 --></th>
						<th><?=$txtdt["1237"]?>/<?=$txtdt["1288"]?><!-- 원산지 --><!-- /제조사 --></th>
						<!-- <th><?=$txtdt["1487"]?>용법</th> -->
						<th><?=$txtdt["1606"]?>(g)<!-- 약재비--></th>
					</tr>
				</thead>
				 <tbody>
				</tbody>
			</table>
		</div>
		<div class="sgap"></div>
		<!-- s : 게시판 페이징 -->
		<div class='pagingpop-wrap' id="medicinelistpage"></div>
		<!-- e : 게시판 페이징 -->
	</div>
</div>

<script>
	function putpopdata(obj)
	{
		console.log("putpopdata 약재추가 에서 클릭시  ===========================  ");

		var popcode=$("input[name=popcode]").val();
		var poptype=$("input[name=poptype]").val();
		var medicode=obj.getAttribute("data-code")
		var property=obj.getAttribute("data-property");
		var meditype=obj.getAttribute("data-type");
		var medihub=$(obj).find("td:eq(0)").text();
		var medititle=$(obj).find("td:eq(1)").text();
		var mediorigin=$(obj).find("td:eq(2)").text().split("/");
		var type="<?=$_GET['type']?>";

		console.log("medicode = " + medicode + ", meditype = " + meditype);

		if(type=="medibox") //자재코드관리 > 약재함관리
		{
			var apiboxdata ="medicode="+medicode;
			//medicinebox 페이지에 값을 넣어준다.
			$("input[name=medicode]").val(medicode);  //매칭된 약재코드
			$("input[name=medititle]").val(medititle);  //약재명
			$("input[name=mediorigine]").val(mediorigin[0]);  //원산지
			$("input[name=medihub]").val(medihub);  //본초명

			/*12/6 green*/
			medihub=$(obj).find("td:eq(1)").text();
			medititle=$(obj).find("td:eq(2)").text();
			mediorigin=$(obj).find("td:eq(3)").text().split("/");

			var chkmedihub= $("input[name=medihub]").val();
			$("#hubtitle").text(medihub).css("color","red");
			//약재명
			var chkmedititle= $("input[name=medititle]").val();
			$("#mbNameTxt").text(medititle);  //약재명
			$("#medititle").text(medititle).css("color","red");
			//원산지
			var chkmediorigin= $("input[name=mediorigine]").val();
			$("#mediorigin").text(mediorigin[0]);
			//제조사
			//var chkmediorigin= $("input[name=mediorigine]").val();
			$("#medimaker").text(mediorigin[1]);
			//매칭된 약재함코드
			var chkmedicode= $("input[name=medicode]").val();
			$("#medicode").text(chkmedicode).css("color","red");

			$("input[name=mbMedicine]").val(chkmedicode);
			closediv('viewlayer');

			//callapi('GET','inventory','mediBoxchk',apiboxdata); //약재함중복체크
		}
		else if(type=="stock")
		{
			/*12/6 green*/
			medihub=$(obj).find("td:eq(1)").text();
			medititle=$(obj).find("td:eq(2)").text();
			mediorigin=$(obj).find("td:eq(3)").text().split("/");

			$("input[name=whStock]").val(medicode);
			$("#mdTitle").text(medititle);  //input  text 박스를 없앰
			$("input[name=whTitle]").val(medititle);
			$("input[name=mdOrigin]").val(mediorigin[0]);
			$("input[name=mdMaker]").val(mediorigin[1]);
			closediv('viewlayer');
		}
		else if(type=="goods") //goods
		{
			$("input[name=gdCode2]").val(medititle);  //A012G039CN600G 코드값만 가져옴 
			closediv('viewlayer');
		}
		else if(type=="GoodsMedicine") //GoodsMedicine 원재료
		{
			//1210 추가
			medihub=$(obj).find("td:eq(1)").text();
			medititle=$(obj).find("td:eq(2)").text();
			mediorigin=$(obj).find("td:eq(3)").text().split("/");

			$("input[name=whStock]").val(medicode);
			$("#mdTitle").text(medititle);  //input  text 박스를 없앰
			$("input[name=whTitle]").val(medititle);
			$("input[name=mdOrigin]").val(mediorigin[0]);
			$("input[name=mdMaker]").val(mediorigin[1]);
			closediv('viewlayer');
		}
		else
		{
			
			var medilist="_"+$("input[name=rcMedicine_pop]").val();
			var sweetlist="_"+$("input[name=rcSweet_pop]").val();

			console.log("medilist = " + medilist);
			console.log("sweetlist = " + sweetlist);

			if(medilist.match(medicode)==null && sweetlist.match(medicode)==null)
			{
				var type='<?=$_GET["type"]?>';
				var data = "";
				var property = (isNaN(property)==false) ? property : 0;
				var pagedata = $("#comPageData").val();
				var searchPop = getsearpopdata();

				

				if(meditype=="sweet")
				{	
					var sweet=$("input[name=rcSweet_pop]").val();
					$("input[name=rcSweet_pop]").val(sweet+"|"+medicode+","+property+",inlast");
				}
				else
				{
					var medicine=$("input[name=rcMedicine_pop]").val();
					$("input[name=rcMedicine_pop]").val(medicine+"|"+medicode+","+property+",inmain");
				}

				sweet = $("input[name=rcSweet_pop]").val();
				medicine = $("input[name=rcMedicine_pop]").val();

				data = "type="+type+"&sweet="+sweet+"&"+pagedata+"&medicine="+medicine+searchPop;
				console.log("layer medicine   sweet = " + sweet);
				var url="<?=$root?>/99_LayerPop/layer-medicine.php?"+data;
				console.log("medicine  url = " + url);
				viewlayer(url,750,600,"");

			}
			else
			{
				var txt1483 = '<?=$txtdt["1483"]?>';/*" 중복약재 "*/
				alertsign("warning",txt1483, "", "1500");
			}
		}
	}

	//적용완료
	function setmedicine()
	{
		var medilist=$("input[name=rcMedicine_pop]").val();
		var sweetlist=$("input[name=rcSweet_pop]").val();
		var meditxt=$("#popmedilist").html();
		var popcode=$("input[name=popcode]").val();

		console.log("==============>>>>>  popcode = " + popcode);
		if(popcode=="medi"){
			$("input[name=rcMedicine]").val(medilist);
			$("#medilist").html(meditxt);
			reloaddata("medi");
		}
		if(popcode=="sweet"){
			$("input[name=rcSweet]").val(medilist);
			$("#sweetlist").html(meditxt);
			reloaddata("sweet");
		}
		if($("#ordermedicine").html()!=undefined)
		{	
			var data = "?seq="+$("input[name=rcSeq]").val()+"&medicine="+medilist+"&sweet="+sweetlist;
			console.log("===============>>> ordermedicine  data = " + data);
			$("#ordermedicine").load("<?=$root?>/Skin/Order/OrderMedicine.php" + data);
		}
		else if($("#medilist").html()!=undefined)
		{
			console.log("===============>>> medilist");
			console.log(medilist);
			var medi=sweet="";
			var arr=medilist.split("|");
			for(var i=1;i<arr.length;i++)
			{
				var arr2=arr[i].split(",");
				var property = (isNaN(arr2[1])==false) ? arr2[1] : 0;
				medi+="|"+arr2[0]+","+property+","+arr2[2];
			}
			var sarr=sweetlist.split("|");
			for(var i=1;i<sarr.length;i++)
			{
				var sarr2=sarr[i].split(",");
				var property = (isNaN(sarr2[1])==false) ? sarr2[1] : 0;
				sweet+="|"+sarr2[0]+","+property+","+sarr2[2];
			}
			var url="../Skin/Recipebasic/RecipeMedicine.php?seq="+$("input[name=seq]").val()+"&medicine="+medi+"&sweet="+sweet;
			$("#medilist").html("");
			$("#medilist").load(url);
			console.log("===============>>> medilist  medi = " + medi+", sweet = " + sweet);
			$("input[name=rcMedicine]").val(medi);
			$("input[name=rcSweet]").val(sweet);
		}

		closediv('viewlayer');
	}


	//약재리스트 API 호출
	var medi = '<?=$_GET["medicine"]?>';
	var asweet = '<?=$_GET["sweet"]?>';
	var type = '<?=$_GET["type"]?>';

	callapi('GET','medicine','medicinelist','<?=$apimedicineData?>');

	if(!isEmpty(medi) || !isEmpty(asweet))
	{
		callapi('GET','medicine','medicinetitle','<?=$apimedicineData?>');
	}

	//페이징데이터 초기화 comdatapage
	if(type!="order"){
		//$("#comPageData").val("");   //고유처방 약재검색때문에 주석처리함
	}

	$("input[name=searchTxt]").focus();
</script>
