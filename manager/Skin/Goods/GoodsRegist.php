<?php //제품등록 상세
	$root = "../..";
	$upload=$root."/_module/upload";
	include_once $root.'/_common.php';
	include_once $upload."/upload.lib.php";
if($_GET["seq"]=="add"){
	$apidata="seq=";
	$seq="";
}else{
	$apidata="seq=".$_GET["seq"];
	$seq=$_GET["seq"];
}
//echo $_GET["seq"];
?>
<script  type="text/javascript" src="<?=$root?>/cmmJs/jquery/jquery.form.min.js"></script>
<link rel="stylesheet" media="all" href="<?=$upload?>/upload.css?v=<?php echo time();?>" />
<script  type="text/javascript" src="<?=$upload?>/upload.js?v=<?=time()?>"></script>
<style type="text/css">
	.goodstype-list li{width:auto;margin-right:10px;display:inline-block;}
	.gdUse-list li{width:auto;margin-right:10px;display:inline-block;}
	.use-list li{width:auto;margin-right:10px;display:inline-block;}
	.capa input{width:80%;text-align:right;}
	#pop_goods tr td, #pop_goodsinfo tr td{padding:2px 5px;height:30px;}
	#pop_goodsinfo tr td input{height:15px;}
	table tr th.rt, table tr td.rt{text-align:right;padding-right:10px;}
	a button.sp-btn{padding:0;height:;margin-top:20px;}
	a button.sp-btn span{padding:10px 5px;height:;}
	#goodstypeDiv input[type=radio] + label, .board-view-wrap input[type=checkbox] + label{margin-right:10px;margin-left:3px;display:inline-block;vertical-align:middle;padding:10px;font-size: 20px;font-weight:bold;}
	.board-view-wrap input[type=radio], .board-view-wrap input[type=text] {display:inline-block; vertical-align:middle;}  
	#medicineBtn a button.sp-btn{margin-top: 0px;}
	.pregoodstype-list li p{float:left;padding:10px;}

	.pillorder{height:35px;padding:0 11px;background:#009dab;vertical-align:top;border:0;color:#fff;overflow:visible;cursor:pointer;}


	#pillOrderDiv dd{min-width:19%;display:block;float:left;text-align:center;padding:5px;margin:0 3px 0 3px;border:1px solid #aaa;font-size: 20px;}
	#pillOrderDiv dd:hover{cursor:pointer;font-weight:bold;}
	.clsbtn{position:absolute;border:1px solid #999;width:10px;height:20px;padding:3px 5px;cursor:pointer;margin-left:5px;text-align:center;font-weight:bold;}
	.clsbtn:hover{background: #999;color:#fff;}

</style>

<input type="hidden" name="apiCode" class="reqdata" value="goodsupdate">
<input type="text" name="seq" class="reqdata" value="<?=$_GET["seq"]?>">
<input type="hidden" name="returnData" class="reqdata" value="<?=$root?>/Skin/Goods/Goods.php">
<input type="hidden" name="goods_type" class="" value="">
<input type="hidden" name="rcCode" class="reqdata" value=""/>

<input type="hidden" name="codechk" id="codechk" value="0">
<input type="hidden" name="pillOrderText" id="pillOrderText" class="reqdata w50p" value="">

<input type="text" name="gdPilltype" id="gdPilltype" value="" class="reqdata">
<textarea name="gdPillorder" class="" cols="90" rows="7" title="제환순서설정" ></textarea><!-- 최종적으로 han_goods에 저장될 pillorder data -->
<textarea name="gdPillmedicine" class="" cols="70" rows="4" title="구성요소" ></textarea><!-- pillorder에 등록할 medicine -->

<textarea name="gdPregoodsname" class="" cols="70" rows="4" title="" style="display:none;"></textarea><!-- 등록된 구성요소에 pillorder가 등록되어 있지 않는 반제품-->

<!--// page start -->

<div id="goodstypeDiv" style=""></div>
<!-- <div id="pregoodstypeDiv" style=""></div> -->
<div class="board-view-wrap" >
	<span class="bd-line"></span>
	<table style="border-top: 1px solid #cacaca;">
		<caption><span class="blind"></span></caption>
		<colgroup>
			<col width="8%">
			<col width="15%">
			<col width="8%">

			<col width="15%">
			<col width="8%">
			<col width="50%">
		</colgroup>
		<tbody>
			<tr>
				<th><span class="nec"><?=$txtdt["1926"]?><!-- 제품코드 --></span></th>
				<td colspan="3">
					<input type="text" name="gdCode" id="gdCode" value="" class="reqdata necdata w40p" title="<?=$txtdt["1204"]?>" onblur="resetcode()"//>
					<!-- <a href="javascript:;" >
						<button type="button" class="sp-btn" style="margin-top: 0px;"  onclick="chkcode();"><span><?=$txtdt["1314"]?> --><!-- 중복확인 --><!-- </span></button>
					</a>	 -->
					<div class="checkcode"><span class="stxt" id="idsame" style="color:red;"></span></div><!--중복여부표시-->				
				</td>
				<th rowspan="5" style="vertical-align:top;">
					<span class=""><?=$txtdt["1929"]?><!-- 구성요소---></span>					
					<span id="addbtn" style="display:none;">
						<a href="javascript:;" onclick="setGoods();">
							<button type="button" class="sp-btn"><span>등록/수정</span></button>
						</a>	
					</span>
				</th>
				<td rowspan="5" id="BomDiv" style="vertical-align:top;"> 
					<table id="bomcodelist" style="border-top:1px solid #ddd;border-right:1px solid #ddd;">
					<div id="elementDiv"></div>
						<colgroup>
							<col width="10%"/> 
							<col width="25%"/> 
							<col width="*"/>
							<col width="15%"/>
							<col width="13%"/>
						</colgroup>
						<thead>
							<tr>
								<th>종류</th>
								<th>코드</th>
								<th>명칭</th>
								<th class="rt">투입량</th>
								<th class="rt">비율</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</td>
			</tr>
			<tr id="gdBomDiv">
				<th><span class="nec"><?=$txtdt["1928"]?><!-- 제품명---></span></th>
				<td colspan="3"><input type="text" name="gdNameKor" title="<?=$txtdt["1928"]?>" class="reqdata necdata w40p" onkeyup="changegoodsename();"/></td>
			</tr>
			<tr>
				<th><span class="nec">재고기준량<!-- 기준량 --></span></th>
				<td><input type="text" name="gdUnit" title="재고기준량" class="reqdata necdata w40p" maxlength="9"  onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
				<th><span class="nec"><?=$txtdt["1549"]?><!-- 적정수량 --></span></th>
				<td><input type="text" name="gdStable" title="<?=$txtdt["1549"]?>" class="reqdata necdata w40p" maxlength="9" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
			</tr>
			<tr>
				<th><span class="nec">로스타입</span></th>
				<td><div id="losstypediv"></div><!-- <input type="text" name="gdLoss" title="로스타입" class="reqdata w40p" maxlength="9" onfocus="this.select();" onchange="changeNumber(event, false);"/> --></td>
				<th><span class="nec">로스량<!-- 적정수량 --></span></th>
				<td><input type="text" name="gdLossCapa" title="로스량" class="reqdata w40p" maxlength="9" onkeyup="changegoodsloss();" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
			</tr>
			<tr>
				<th><span class="nec">제품용량<!-- 적정수량 --></span></th>
				<td><input type="text" name="gdCapa" title="제품용량" class="reqdata w40p" maxlength="9" onfocus="this.select();" onchange="changeNumber(event, false);"/></td>
				<th><span class="nec"><?=$txtdt["1144"]?><!-- 사용 --></span></th>
				<td>
					<div id="gdUseDiv"></div> 
					<div id="radioDiv"> 
						<!-- <input type="radio" id="radiouseA" name="radiouse" class="radiodata" title="<?=$txtdt["1144"]?>" value="A" onclick="return(false);" /> -->
						<input type="radio" id="radiouseA" name="gdUse" class="radiodata" title="<?=$txtdt["1144"]?>" value="A" onclick="updateGduse()"/> 
						<label for="radiouseA">승인전 &nbsp;&nbsp;</label>
						<input type="radio" id="radiouseY" name="gdUse" class="radiodata" title="<?=$txtdt["1144"]?>" value="Y" onclick="updateGduse()"/>
						<label for="radiouseY">승인 완료 &nbsp;&nbsp;</label>
						<!-- <input type="radio" id="radiouseN" name="radiouse" class="radiodata" title="<?=$txtdt["1144"]?>" value="N"/>
						<label for="radiouseN">No</label> -->
					</div> 
				</td>
			</tr>
			<tr>
				<th>
					<span><?=$txtdt["1949"]?><br><!--  제환순서----></span>
				</th>
				<td colspan="6">
				<style>
					.pill dl{width:5%;margin:1%;display:inline-block;vertical-align:top;}
					.pill dl dt{width:auto;border:1px solid #ddd;border-radius:7px;text-align:center;padding:10px 5px;cursor:pointer;color:#999;font-size:17px;font-weight:bold;}
					.pill dl dt.on{color:#111;border:1px solid #48DAFF;background:#48DAFF;}
					.pill dl dt.childon{color:#111;border:1px solid #CCCCCC;background:#CCCCCC;}
					.pill dl dd{margin:2px auto;width:100%;}
					.pill dl dd select{width:100%;}

					#packing .chkdl{width:100%;overflow:hidden;}
					#packing .chkdl dd {position:relative;float:left;text-align:left;}
				</style>
					<div class='pill' id="pillorderdiv">
					</div>
				<?php
					//echo "<div class='pill'>";
					//$carr=array("making","soak","smash","decoction","concent","juice","mixed","warmup","ferment","plasty","dry","packing");
					//$cdarr=array("making","","pillFineness","dcSpecial","concent","juice","pillBinders","warmup","ferment","pillShape","dry","packing");
					//$tarr=array("조제","불림","분쇄","탕전","농축","착즙","혼합","중탕","숙성","제형","건조","포장");
					//for($i=0;$i<count($carr);$i++){
					//	echo "<dl id='".$carr[$i]."' class='pilldl'>";
					//	echo "<dt onclick=\"selorder('".$seq."','".$carr[$i]."', '".$tarr[$i]."')\">".$tarr[$i]."</dt>";
					//	echo "</dl>";
					//}
					//echo "</div>";
				?>
				</td>
			</tr>
			<tr>
				<th>
					<span><?=$txtdt["1173"]?><!-- 설명----></span>
				</th>
				<td colspan="6">
					<textarea class="text-area reqdata" name="gdDesc"></textarea>
				</td>
			</tr>
<?php
if($_GET["seq"]!="add")  //처음에는 이미지 등록못하게 처리(goods의 seq가 없으므로)
{
?>
			<tr>
				<th><span><?=$txtdt["1935"]?><!-- 제품사진 ----></span></th>		
				

				<td colspan="6" id="" ><?=upload("goods",$_COOKIE["ck_stStaffid"],$_COOKIE["ck_language"])?></td>
			</tr>
<?php
}
?>
		</tbody>
	</table>

	<div class="gap"></div>

	<div class="btn-box c" id="btnDiv">

	</div>
</div>

<!--// page end -->


<script>
	function delorder(id){
		var len=$(id).parent().parent("dd").length;
		console.log("delorder len = " +len);
		$(id).parent().remove();
	}

/*
[{"type":"making"},{"type":"smash"},
{"type":"decoction","order":[{"code":"spdecoc03"}]},{"type":"concent"},{"type":"juice"},{"type":"mixed"},{"type":"warmup"},{"type":"ferment"},{"type":"plasty"},{"type":"dry"},{"type":"packing"}]

{"type":"packing","incapa":"1000(제거 0)","outcapa":"900(제거 0)","order":[
	{"medicine":[
		{"code":"KHBML","type":percent","value":"25"(추가),"capa":0}
		.{"code":"MA200515160940","type":unit","value":"1"(추가),"capa":0}
		.{"code":"MA200515160958","per":"25%"(추가)}
		.{"code":"MA200515160951","per":"25%"(추가)}
	]},
]}



{"type":"","incapa":0,"outcapa":0,"order":{"medicine":[{"type":"medicine","code":"KHYS","kind":"percent","value":100,"capa":0}]}}


   {"type":"making","order":null},
   {"type":"smash","order":[{"plFineness":"milling","plMillingloss":"200"}]},
   {"type":"decoction","order":[{"plDctitle":"200","plDcspecial":"10","plDctime":"200","plDcwater":"10"}]},
   {"type":"concent","order":[{"plConcentratio":"200","plConcenttime":"10"}]},
   {"type":"juice","order":null},
   {"type":"mixed","order":[{"plBinders":"honey","plBindersliang":"10"}]},
   {"type":"warmup","order":[{"plWarmupTemperature":"600","plWarmupTime":"200"}]},
   {"type":"ferment","order":[{"plFermenttemperature":"300","plFermenttime":"200"}]},
   {"type":"plasty","order":[{"plShape":"eundandae","plLosspill":"200"}]},
   {"type":"dry","order":[{"plDrytemperature":"200","plDrytime":"100"}]},
   {"type":"packing","order":null}]}


*/
	//분쇄
	function setsmash()
	{
		var str='';
		var selFineness=$("textarea[name=selFineness]").val();//분말도
		var chkchildon=getchildon("smash");
				//분말도
		str+='<dd>';		
		str+='<span>분말도:</span>'+selFineness;
		//제분손실
		//str+='<span>제분손실:</span><input type="text" name="plMillingloss" id="plMillingloss" class="pilldata" value="200"  onkeyup="changepillorder(this);"  />';		
		if(chkchildon<=0)
		{
			str+='<span class="clsbtn" onclick="delorder(this)">X</span>';
		}
		str+='</dd>';
		return str;
	}
	//탕전
	function setdecoction()
	{
		var str='';
		var selDcTitle=$("textarea[name=selDcTitle]").val();//탕전법
		var selDcSpecial=$("textarea[name=selDcSpecial]").val();//특수탕전
		var chkchildon=getchildon("decoction");
		//탕전법
		str+='<dd>';
		str+='<span>탕전법:</span>'+selDcTitle;		
		//특수탕전
		str+='<span>특수탕전:</span>'+selDcSpecial;
		//탕전시간
		str+='<span>탕전시간:</span><input type="text" name="plDctime"  id="plDctime" class=" pilldata" value="240"  onkeyup="changepillorder(this);"/>';
		if(chkchildon<=0)
		{
			str+='<span class="clsbtn" onclick="delorder(this)">X</span>';
		}
		str+='</dd>';
		return str;
	}
	//농축
	function setconcent()
	{
		var str='';
		var selConcentRatio=$("textarea[name=selConcentRatio]").val();//농축비율
		var selConcentTime=$("textarea[name=selConcentTime]").val();//농축시간
		var chkchildon=getchildon("concent");
		str+='<dd>';
		//농축비율
		str+='<span>농축비율:</span>'+selConcentRatio;
		//농축시간
		str+='<span>농축시간:</span>'+selConcentTime;
		if(chkchildon<=0)
		{
			str+='<span class="clsbtn" onclick="delorder(this)">X</span>';
		}
		str+='</dd>';
		return str;
	}
	//착즙
	function setjuice()
	{
		var str='';
		var selJuice=$("textarea[name=selJuice]").val();//착즙유무
		var chkchildon=getchildon("juice");
		str+='<dd>';
		//착즙유무
		str+='<span>착즙유무:</span>'+selJuice;
		if(chkchildon<=0)
		{
			str+='<span class="clsbtn" onclick="delorder(this)">X</span>';
		}
		str+='</dd>';
		return str;
	}
	//혼합 , 
	function setmixed()
	{
		var str='';
		var selBinders=$("textarea[name=selBinders]").val();//결합제
		var chkchildon=getchildon("mixed");
		str+='<dd>';
		//결합제
		str+='<span>결합제:</span>'+selBinders;
		if(chkchildon<=0)
		{
			str+='<span class="clsbtn" onclick="delorder(this)">X</span>';
		}
		str+='</dd>';
		return str;
	}
	//교반
	function setstir()
	{
		var str='';
		var selstirBinders=$("textarea[name=selstirBinders]").val();//결합제
		var chkchildon=getchildon("stir");
		str+='<dd>';
		//결합제
		str+='<span>결합제:</span>'+selstirBinders;
		if(chkchildon<=0)
		{
			str+='<span class="clsbtn" onclick="delorder(this)">X</span>';
		}
		str+='</dd>';
		return str;
	}
	//중탕
	function setwarmup()
	{
		var str='';
		var selWarmupTemperature=$("textarea[name=selWarmupTemperature]").val();//중탕온도
		var selWarmupTime=$("textarea[name=selWarmupTime]").val();//중탕시간
		var chkchildon=getchildon("warmup");
		str+='<dd>';
		//중탕온도
		str+='<span>중탕온도:</span>'+selWarmupTemperature;		
		//중탕시간
		str+='<span>중탕시간:</span>'+selWarmupTime;
		if(chkchildon<=0)
		{
			str+='<span class="clsbtn" onclick="delorder(this)">X</span>';
		}
		str+='</dd>';
		return str;
	}
	//숙성
	function setferment()
	{
		var str='';
		var selFermentTemperature=$("textarea[name=selFermentTemperature]").val();//숙성온도
		var selFermentTime=$("textarea[name=selFermentTime]").val();//숙성시간
		var chkchildon=getchildon("ferment");
		str+='<dd>';
		//숙성온도
		str+='<span>숙성온도:</span>'+selFermentTemperature;		
		//숙성시간
		str+='<span>숙성시간:</span>'+selFermentTime;
		if(chkchildon<=0)
		{
			str+='<span class="clsbtn" onclick="delorder(this)">X</span>';
		}
		str+='</dd>';
		return str;
	}
	//제형
	function setplasty()
	{
		var str='';
		var selShape=$("textarea[name=selShape]").val();//제형
		var chkchildon=getchildon("plasty");
		str+='<dd>';
		//제형
		str+='<span>제형:</span>'+selShape;		
		//제형손실
		//str+='<span>제형손실:<input type="text" name="plLosspill" id="plLosspill" class="pilldata" value="200"  onkeyup="changepillorder(this);" /></span>';
		if(chkchildon<=0)
		{
			str+='<span class="clsbtn" onclick="delorder(this)">X</span>';
		}
		str+='</dd>';
		return str;
	}
	//건조
	function setdry()
	{
		var str='';
		var selDryTemperature=$("textarea[name=selDryTemperature]").val();//건조온도
		var selDryTime=$("textarea[name=selDryTime]").val();//건조시간
		var chkchildon=getchildon("dry");
		str+='<dd>';
		//건조온도
		str+='<span>건조온도:</span>'+selDryTemperature;		
		//건조시간
		str+='<span>건조시간:</span>'+selDryTime;
		if(chkchildon<=0)
		{
			str+='<span class="clsbtn" onclick="delorder(this)">X</span>';
		}
		str+='</dd>';
		return str;
	}
	//불림
	function setsoak()
	{
		var str='';
		var selSoakTime=$("textarea[name=selSoakTime]").val();//불린시간
		var chkchildon=getchildon("soak");
		str+='<dd>';
		//불린시간
		str+='<span>불린시간:</span>'+selSoakTime;
		if(chkchildon<=0)
		{
			str+='<span class="clsbtn" onclick="delorder(this)">X</span>';
		}
		str+='</dd>';
		return str;
	}
	
	function setpacking()
	{
		var str='';
		var chkPacking=$("textarea[name=chkPacking]").val();//부자재
		var chkchildon=getchildon("packing");
		console.log("setpacking   chkPacking= " + chkPacking);
		str+='<dd>';
		str+=''+chkPacking;
		if(chkchildon<=0)
		{
			str+='<span class="clsbtn" onclick="delorder(this)">X</span>';
		}
		str+='</dd>';
		return str;
	}
	function getchildon(type)
	{
		var chkchildon=$("#"+type+" dt.childon").length;
		console.log(type+" chkchildon = " + chkchildon);
		return chkchildon;
	}
	function selorder(seq, type, name)
	{
		
		var chkon=$(".pill dl dt.on").length;
		var chkchildon=$("#"+type+" dt.childon").length;
		console.log("##DOO## selorder  seq="+seq+", type="+type+", name="+name+", chkon = " + chkon+", chkchildon = " + chkchildon);
		if(chkchildon>0)
		{
			return;
		}
		//if(chkon>0)
		//{
		//	return;
		//}

		$("input[name=gdPilltype]").val(type);
		setviewpillorder(type);

		$("#"+type).children("dt").addClass("on");
		$("#"+type).children("dd").children("select").addClass("onpilldata");
		$("#"+type).children("dd").children("input").addClass("onpilldata");


		if(type=="making")
		{
			changepillorder(null);
		}
	}
	function setviewpillorder(type)
	{
		var sel="";
		switch(type)
		{
		case "making"://조제

			break;
		case "soak"://불림
			sel+=setsoak();
			break;
		case "smash"://분쇄 
			sel+=setsmash();
			break;
		case "decoction"://탕전
			sel+=setdecoction();
			break;
		case "concent"://농축
			sel+=setconcent();
			break;
		case "juice"://착즙
			sel+=setjuice();
			break;
		case "mixed"://혼합
			sel+=setmixed();
			break;
		case "stir"://교반
			sel+=setstir();
			break;
		case "warmup"://중탕
			sel+=setwarmup();
			break;
		case "ferment"://숙성
			sel+=setferment();
			break;
		case "plasty"://제형
			sel+=setplasty();
			break;
		case "dry"://건조 
			sel+=setdry();
			break;
		case "packing"://포장 
			sel+=setpacking();
			break;
		}
		$("#"+type).append(sel);
	}
	function viewpillorder(kind,pill)
	{
		var pillData=JSON.parse(pill);
		var pilltype=pillData["type"];
		var pilltypetxt=pillData["typetxt"];
		var pillOrder=pillData["order"];
		var pillWork=pillOrder["work"];
		var sel=disabled="";

		console.log("viewpillorder  kind : "+kind+", pill = " + pill+", pilltype = " + pilltype);
		if(isEmpty(pilltype))
		{
			return;
		}

		disabled="disabled";
		if(kind=="parent")
		{
			disabled="";
			$("#"+pilltype+" dt").addClass("on");
			$("input[name=gdPilltype]").val(pilltype);
			
		}
		else
		{
			$("#"+pilltype+" dt").addClass("childon");
		}


		setviewpillorder(pilltype);

		for(var key in pillWork)
		{
			var pwcode=pillWork[key]["code"];
			var pwvalue=pillWork[key]["value"];

			console.log("viewpillorder key="+key+", pwcode="+pwcode+", pwvalue = " + pwvalue);
			switch(pwcode)
			{
			case "plFineness"://분말도 
			case "plSoakTime"://불리는시간 
			case "plDctitle"://탕전법
			case "plDcspecial"://특수탕전 
			case "plConcentRatio"://농축비율
			case "plConcentTime"://농축시간 
			case "plJuice"://착즙유무 
			case "plBinders"://결합제 
			case "plstirBinders"://교반결합제 
			case "plWarmupTemperature"://중탕온도
			case "plWarmupTime"://중탕시간 
			case "plFermentTemperature"://숙성온도
			case "plFermentTime"://숙성시간 
			case "plShape"://제형
			case "plDryTemperature"://건조온도
			case "plDryTime"://건조시간 
				$("select[name="+pwcode+"] option[value='"+pwvalue+"']").attr("selected", "selected");
				if(!isEmpty(disabled)&&disabled=="disabled") { $("select[name="+pwcode+"]").attr('disabled',true); }
				break;
			//case "plMillingloss"://제분손실 
			case "plDctime"://탕전시간 
			//case "plLosspill"://제형손실 
				$("input[name="+pwcode+"]").val(pwvalue);
				if(!isEmpty(disabled)&&disabled=="disabled") { $("input[name="+pwcode+"]").attr("disabled",true); }
				break;
			case "plPacking"://포장
				$('input:checkbox[name="'+pwcode+'"]').each(function() {
					if(this.value == pwvalue){ //값 비교
						this.checked = true; //checked 처리
					}
				});
				break;
			}

		}


/*
		switch(pilltype)
		{
		case "making"://조제
			break;
		case "soak"://불림
			$("select[name=plSoakTime] option[value='"+pillOrder["plSoakTime"]+"']").attr("selected", "selected");
			if(!isEmpty(disabled)&&disabled=="disabled")
			{
				$("select[name=plSoakTime]").attr('disabled',true);
			}
			break;
		case "decoction"://탕전
			$("select[name=plDctitle] option[value='"+pillOrder["plDctitle"]+"']").attr("selected", "selected");
			$("select[name=plDcspecial] option[value='"+pillOrder["plDcspecial"]+"']").attr("selected", "selected");
			$("input[name=plDctime]").val(pillOrder["plDctime"]);

			if(!isEmpty(disabled)&&disabled=="disabled")
			{
				$("select[name=plDctitle]").attr('disabled',true);
				$("select[name=plDcspecial]").attr("disabled",true);
				$("input[name=plDctime]").attr("disabled",true);
			}
			break;
		case "concent"://농축
			$("select[name=plConcentRatio] option[value='"+pillOrder["plConcentRatio"]+"']").attr("selected", "selected");
			$("select[name=plConcentTime] option[value='"+pillOrder["plConcentTime"]+"']").attr("selected", "selected");

			if(!isEmpty(disabled)&&disabled=="disabled")
			{
				$("select[name=plConcentRatio]").attr('disabled',true);
				$("select[name=plConcentTime]").attr("disabled",true);
			}
			break;
		case "juice"://착즙
			$("select[name=plJuice] option[value='"+pillOrder["plJuice"]+"']").attr("selected", "selected");
			if(!isEmpty(disabled)&&disabled=="disabled")
			{
				$("select[name=plJuice]").attr('disabled',true);
			}
			break;
		case "mixed"://혼합
			$("select[name=plBinders] option[value='"+pillOrder["plBinders"]+"']").attr("selected", "selected");
			if(!isEmpty(disabled)&&disabled=="disabled")
			{
				$("select[name=plBinders]").attr('disabled',true);
			}
			break;
		case "warmup"://중탕
			$("select[name=plWarmupTemperature] option[value='"+pillOrder["plWarmupTemperature"]+"']").attr("selected", "selected");
			$("select[name=plWarmupTime] option[value='"+pillOrder["plWarmupTime"]+"']").attr("selected", "selected");			
			if(!isEmpty(disabled)&&disabled=="disabled")
			{
				$("select[name=plWarmupTemperature]").attr('disabled',true);
				$("select[name=plWarmupTime]").attr("disabled",true);
			}
			break;
		case "ferment"://숙성
			$("select[name=plFermentTemperature] option[value='"+pillOrder["plFermentTemperature"]+"']").attr("selected", "selected");
			$("select[name=plFermentTime] option[value='"+pillOrder["plFermentTime"]+"']").attr("selected", "selected");					
			if(!isEmpty(disabled)&&disabled=="disabled")
			{
				$("select[name=plFermentTemperature]").attr('disabled',true);
				$("select[name=plFermentTime]").attr("disabled",true);
			}
			break;
		case "plasty"://제형
			$("select[name=plShape] option[value='"+pillOrder["plShape"]+"']").attr("selected", "selected");
			$("input[name=plLosspill]").val(pillOrder["plLosspill"]);			
			if(!isEmpty(disabled)&&disabled=="disabled")
			{
				$("select[name=plShape]").attr('disabled',true);
				$("input[name=plLosspill]").attr("disabled",true);
			}
			break;
		case "dry"://건조 
			$("select[name=plDryTemperature] option[value='"+pillOrder["plDryTemperature"]+"']").attr("selected", "selected");
			$("select[name=plDryTime] option[value='"+pillOrder["plDryTime"]+"']").attr("selected", "selected");				
			if(!isEmpty(disabled)&&disabled=="disabled")
			{
				$("select[name=plDryTemperature]").attr('disabled',true);
				$("select[name=plDryTime]").attr("disabled",true);
			}
			break;
		case "packing":
			break;
		}
		*/
		
		if(kind=="parent")
		{
			$("#"+pilltype).children("dd").children("select").addClass("onpilldata");
			$("#"+pilltype).children("dd").children("input").addClass("onpilldata");
		}
	}
	function changegoodsloss()
	{
		var pilllosscapa=$("input[name=gdLossCapa]").val();
		var pilllosstype=$("input:radio[name=gdLoss]:checked").val();
		var gdpillorder=$("textarea[name=gdPillorder]").val();

		if(!isEmpty(gdpillorder) && !isEmpty(pilllosstype) && !isEmpty(pilllosscapa))
		{
			var orderdata=JSON.parse(gdpillorder);
			orderdata["losstype"]=pilllosstype;
			orderdata["losscapa"]=pilllosscapa;

			$("textarea[name=gdPillorder]").val(JSON.stringify(orderdata));
			console.log("orderdata = " + JSON.stringify(orderdata));
		}
		//else
		//{
		//	console.log("changegoodsloss  changepillorder null ");
		//	changepillorder(null);
		//}
	}

	//제품명입력시
	function changegoodsename()
	{
		var pillname=$("input[name=gdNameKor]").val();
		var gdpillorder=$("textarea[name=gdPillorder]").val();

		if(!isEmpty(gdpillorder) && !isEmpty(pillname))
		{
			var orderdata=JSON.parse(gdpillorder);
			orderdata["name"]=pillname;
			$("textarea[name=gdPillorder]").val(JSON.stringify(orderdata));
			console.log("orderdata = " + JSON.stringify(orderdata));
		}
		//else
		//{
		//	console.log("changegoodsename  changepillorder null ");
		//	changepillorder(null);
		//}
	}

	//제환순서를 선택할때마다 pillorder를 바꾸자 
	function changepillorder(obj)
	{
		console.log(obj);
		var name=id="";
		if(obj!=null)
		{
			name=obj.name;
			id=obj.id;
		}


		console.log("changepillorder name="+name+", id="+id);

		var pilltype=$("input[name=gdPilltype]").val();
		var pilltypetxt=$(".pill dl dt.on").text();
		var pillname=$("input[name=gdNameKor]").val();
		var gdPillmedicine=$("textarea[name=gdPillmedicine]").val();
		console.log("changepillorder pilltype="+pilltype+", pilltypetxt="+pilltypetxt+",pillname="+pillname+", gdPillmedicine= " +gdPillmedicine);
		if(isEmpty(gdPillmedicine))
		{
			return;
		}
		
		var orderdata={};
		orderdata["medicine"]=JSON.parse(gdPillmedicine);
		var orderwork=new Array();
		
		if(name=="plPacking")
		{
			$("input[name=plPacking]:checked").each(function() {

				var packingval = $(this).val();
				var packingname = $(this).data("name");
				var arr={};
				arr["code"]="plPacking";
				arr["value"]=packingval;
				arr["name"]=packingname;
				orderwork.push(arr);
			});
		}
		else
		{
			$(".onpilldata").each(function(){
				var arr={};
				if(!isEmpty($(this)))
				{
					key=$(this).attr("name");
					keytxt=$(this).attr("title");
					data=$(this).val();
					datatxt=$(this).children("option:selected").text();

					//console.log(key+"__"+keytxt+"__"+data+"__"+datatxt);
					arr["code"]=key;
					arr["codetxt"]=keytxt;
					arr["value"]=data;
					arr["valuetxt"]=datatxt;
					orderwork.push(arr);
				}
			});
		}
		orderdata["work"]=orderwork;

		var pilllosstype=$("input:radio[name=gdLoss]:checked").val();
		var pilllosscapa=$("input[name=gdLossCapa]").val();

		var pilldata={type:pilltype,typetxt:pilltypetxt,name:pillname,incapa:0,outcapa:0,losstype:pilllosstype,losscapa:pilllosscapa,order:orderdata};
		

		console.log(JSON.stringify(pilldata));

		//구성요소 리스트를 말자!
		$("textarea[name=gdPillorder]").val(JSON.stringify(pilldata));


	}
	function chkorder(code, id){
		var data=$(id).val();
		if(data==""){
			$("#"+code).children("dt").removeClass("on");
		}else{
			$("#"+code).children("dt").addClass("on");
		}
	}

	function updateGduse(){
		var seq=$("input[name=seq]").val();
		var chk=$("input:radio[name=gdUse]:checked").val();
		var data="seq="+seq+"&chk="+chk;
		console.log("data   >>   "+data);
		callapi('GET','goods','updateGduse',data);
	}

	function resetcode()
	{
		$(".checkcode").html('');
		$("input[name=codechk]").val(0);
	}

	//코드중복체크
	function chkcode()
	{
		console.log("코드중복체크");
		var id=$("input[name=gdCode]").val();
		var apidata = "gd_code="+id;
		console.log(""+apidata);
		callapi('GET','goods','chkcode',apidata);
		return false;
	
	}

	//화면전환
	function showcode(value)
	{
		console.log("showcode   >> "+value);


		var seq= $("input[name=seq]").val();
		if(isEmpty(seq))
		{
			console.log("seq가 없을때만    >> "+seq);
			$("input[name=goods_type]").val(value); 
			$('#BomDiv').text('등록 하신후 구성요소를 다시 입력해주세요');

			if(value=="goods")
			{	
				//$("#pregoodstypeDiv").css("display","none");	
				$("#bomcodelist tbody").text("");
			}	
			else if(value=="pregoods")  //반제품이면
			{				
				$("#bomcodelist tbody").text("");			
				//$("#pregoodstypeDiv").css("display","block");	 //반제품의 상세분유 값을 입력받음 		
			}
		}
			
			if(value=="material") //부자재일경우 
			{
				//$("#pregoodstypeDiv").css("display","none");	
				$('#BomDiv').text('부자재는 구성요소가 없습니다.');	
				$("#addbtn").css("display","none");//구성요소 등록수정버튼 
			}
		
	}

	function setGoods()
	{
		var chk=$("input:radio[name=gdUse]:checked").val();
		//if(chk=="Y"){
		//	alert("승인완료 체크 해제후 사용하시기 바랍니다.");
		//}else{
			var seq= $("input[name=seq]").val();
			var title=encodeURI($("#goodstit").text());
			if(title==""){
				title=encodeURI($("input[name=gdNameKor]").val());
			}
			var url="/99_LayerPop/layer-goods.php?seq="+seq+"&title="+title;
			viewlayer(url,1100,750,"");
		//}
	}

	function viewGoods(seq, title)
	{
		var his=$("input[name=his]").val();
		var url="/99_LayerPop/layer-goods.php?seq="+seq+"&title="+title+"&his="+his;
		viewlayer(url,1100,750,"");
		parent.document.location.hash="#|"+seq+"|"
	}

	function moveGoods(dir)
	{
		var his=$("input[name=his]").val();
		var no=$("input[name=hisno]").val();
		var arr=his.split(",");
		if(dir=="prev"){
			var cnt = no - 1;
		}else{
			var cnt = no + 1;
		}
		if(arr[cnt]!="" && arr[cnt]!=undefined){
		console.log(dir+"_"+no+"_"+cnt+"_"+arr[cnt]);
			var url="/99_LayerPop/layer-goods.php?seq="+arr[cnt]+"&his="+his+"&no="+no+"&dir="+dir;
			console.log(url);
			viewlayer(url,1100,750,"");
			parent.document.location.hash="#|"+arr[cnt]+"|"
		}
	}


	//원재료 외 등록수정
	function goodsupdate()
	{
		var chk=$("input:radio[name=gdUse]:checked").val();
		var pregoodsname=$("textarea[name=gdPregoodsname]").val();
		var gdPillorder=$("textarea[name=gdPillorder]").val();
		var gdPillmedicine=$("textarea[name=gdPillmedicine]").val();
		var seq=$("input[name=seq]").val();
		console.log("seq="+seq+". gdPillmedicine = " + gdPillmedicine+", gdPillorder = " + gdPillorder);


		var gdType=$("input:radio[name=gdType]:checked").val();
		console.log("############# gdType = " + gdType);
		if(gdType=="pregoods" || gdType=="goods") //제품, 반제품일 경우에만 구성요소 
		{
			var chkon=$(".pill dl dt.on").length;

			if(!isEmpty(seq)&&!isEmpty(pregoodsname))
			{
				alertsign('error',pregoodsname+" 구성요소에 제환순서를 먼저 입력해 주세요",'','2000'); //해당하는 구성요소에 제환순서를 입력해 주세요
				return;
			}
			if(!isEmpty(seq)&&isEmpty(gdPillmedicine))
			{
				alertsign('error',"구성요소를 등록해 주세요.",'','2000'); //해당하는 구성요소에 제환순서를 입력해 주세요
				return;
			}
			if(!isEmpty(seq)&&isEmpty(gdPillorder))
			{
				alertsign('error',"제환순서를 설정해 주세요.",'','2000'); //해당하는 구성요소에 제환순서를 입력해 주세요
				return;
			}
			if(!isEmpty(seq)&&!isEmpty(gdPillorder)&&chkon<=0)
			{
				alertsign('error',"제환순서를 설정해 주세요",'','2000'); //해당하는 구성요소에 제환순서를 입력해 주세요
				return;
			}
		}
		//if(chk=="Y"){
			//alert("승인완료 체크 해제후 사용하시기 바랍니다.");
		//}else{
			if(necdata()=="Y") //필수조건 체크
			{
				//if($("input[name=codechk]").val()==1) //중복확인이 1이어야 등록가능
				//{
					var key=data="";
					var jsondata={};
					//radio data
					$(".radiodata").each(function()
					{
						key=$(this).attr("name");
						data=$(":input:radio[name="+key+"]:checked").val();
						jsondata[key] = data;
					});

					$(".reqdata").each(function(){
						key=$(this).attr("name");
						data=$(this).val();
						jsondata[key] = data;
					});
					//var pill={};
					/*var pillorder=[];
					$(".pill dl").each(function(){
						data=$(this).attr("id");
						var order=[];
						$(this).children("dd").children("select").each(function(){
							if($(this).val()==null){
								order.push({"code" : ""});
							}else{
								order.push({"code" : $(this).val()});
							}
						});
						pillorder.push({"type" : data,"order":order});
					});
					*/
					/*
					$(".pilldata").each(function(){
						key=$(this).attr("name");
						data=$(this).val();
						var pilldata=[key,data];
						pillorder.push(pilldata);
					});
					*/
					//var pillorder=pill;
					var pillorder=$("textarea[name=gdPillorder]").val();
					jsondata["pillorder"] = pillorder;
					console.log(JSON.stringify(jsondata));
					callapi('POST','goods','goodsupdate',jsondata); 	
					$("#btnDiv a").eq(0).attr("onclick","alert('<?=$txtdt['1885']?>')").children("span").text("<?=$txtdt['1884']?>");
					viewlist();
				//}
				//else
				//{
				//	alert("중복확인버튼을 눌러주세요 또는 아이디를 확인해주세요");
					//alert('<?=$txtdt["1526"]?>');//중복코드
				//	$("input[name=gdCode]").focus();
				//	return false;			
				//}
			}
		//}
	}

	function viewlayerPopup(obj)
	{
		var url=obj.getAttribute("data-bind");
		var size=obj.getAttribute("data-value");
		var data = "&page=1&psize=5&block=10"; //page,psize,block 사이즈 초기화
		//console.log("=========>>>> viewlayerPopup url = " + url+", size = " + size+", data = " + data);

		getlayer(url,size,data);
	}

	//처음 등록시 A상태로 입력하고 그후 다시 승인할때
	function approvalBtn()
	{
		//$('#gdUseDiv').text('승인상태로 변경합니다. 승인이 되면 수정할수 없습니다.');
		//$('#gdUseDiv').text('승인완료.');
		//$("input[name=gdUse]").val("Y");
		//$("#radioDiv").css("display","none");	
	}

	//삭제
	function goods_del()
	{
		var data = "seq="+$("input[name=seq]").val();
		var url = encodeURI($("input[name=returnData]").val());
		$("input[name=returnData]").val(url);
		callapidel('goods','goodsdelete',data);
		return false;
	}

	function viewchildbomcodeList(childlist)
	{
		console.log("viewchildbomcodeList ");
		if(!isEmpty(childlist))
		{
			console.log(childlist);
			for(var key in childlist)
			{
				console.log("key:"+key+", childlist["+key+"]="+childlist[key]);

				if(!isEmpty(childlist[key]))
				{
					viewpillorder("child",childlist[key]["order"]);
				}
			}
		}

		//MA200515160940
		//viewpillorder("child",list[key]["gdPillorder"]);
	}
	function viewbomcodeList(bomcodeList)
	{
		var data="";	
		var totqty=0;
		var bomarr=[];
		var pregoodsname="";
		if(!isEmpty(bomcodeList))
		{
			//원재료
			var list=bomcodeList["medicine"];
			if(!isEmpty(list))
			{
				for(var key in list)
				{
					//if(isNaN(list[key]["bomcapa"])){list[key]["bomcapa"]=0;}
					data+="<tr id='tr"+list[key]["bomcode"]+"');\">";
					data+="<td>"+list[key]["gdTypename"]+"</td>";  
					data+="<td>"+list[key]["bomcode"]+"</td>"; //코드
					data+="<td>"+list[key]["bomtext"]+"</td>"; //재료명
					data+="<td class='rt'>"+comma(list[key]["bomcapa"])+"</td>";  //용량
					data+="<td class='rt per'>"+comma(list[key]["bomcapa"])+"</td>";  //용량
					data+="</tr>";
					var arr=["medicine",list[key]["gdTypename"],list[key]["bomcode"],list[key]["bomcapa"], list[key]["bomtext"], "0"];
					bomarr.push(arr);
					totqty=totqty+parseInt(list[key]["bomcapa"]);

					console.log("원재료 :: gdPillorder = " + list[key]["gdPillorder"]);
					if(!isEmpty(list[key]["gdPillorder"]))
					{	
						viewpillorder("child",list[key]["gdPillorder"]);					
					}
				}
			}
			
			//제품
			list=bomcodeList["goods"];
			if(!isEmpty(list))
			{
				for(var key in list)
				{
					data+="<tr id='tr"+list[key]["bomcode"]+"');\">";
					data+="<td>"+list[key]["gdTypename"]+"</td>";  
					data+="<td>"+list[key]["bomcode"]+"</td>"; //코드
					data+="<td>"+list[key]["bomtext"]+"</td>"; //재료명
					data+="<td class='rt'>"+comma(list[key]["bomcapa"])+"</td>";  //용량
					data+="<td class='rt'>-</td>";  //용량
					data+="</tr>";
					var arr=["goods",list[key]["gdTypename"],list[key]["bomcode"],list[key]["bomcapa"], list[key]["bomtext"], list[key]["gdCapa"]];
					bomarr.push(arr);
					totqty=totqty+parseInt(list[key]["bomcapa"]);
					console.log("제품 :: gdPillorder = " + list[key]["gdPillorder"]);
					if(!isEmpty(list[key]["gdPillorder"]))
					{	
						viewpillorder("child",list[key]["gdPillorder"]);					
					}
				}
			}

			//반제품
			list=bomcodeList["pregoods"];
			if(!isEmpty(list))
			{
				for(var key in list)
				{
					data+="<tr id='tr"+list[key]["bomcode"]+"');\">";
					data+="<td>"+list[key]["gdTypename"]+"</td>";  
					data+="<td>"+list[key]["bomcode"]+"</td>"; //코드
					data+="<td>"+list[key]["bomtext"]+"</td>"; //재료명
					data+="<td class='rt'>"+comma(list[key]["bomcapa"])+"</td>";  //용량
					data+="<td class='rt per'>"+comma(list[key]["bomcapa"])+"</td>";  //용량
					data+="</tr>";
					var arr=["pregoods",list[key]["gdTypename"],list[key]["bomcode"],list[key]["bomcapa"], list[key]["bomtext"], list[key]["gdCapa"]];
					bomarr.push(arr);
					totqty=totqty+parseInt(list[key]["bomcapa"]);
					console.log("반제품 :: gdPillorder = " + list[key]["gdPillorder"]);
					if(!isEmpty(list[key]["gdPillorder"]))
					{					
						viewpillorder("child",list[key]["gdPillorder"]);					
					}
					else
					{
						pregoodsname+=","+list[key]["bomtext"];
					}
				}
			}

	

			//부자재
			list=bomcodeList["material"];
			
			//console.log(list);
			if(!isEmpty(list))
			{
				for(var key in list)
				{
					data+="<tr id='tr"+list[key]["bomcode"]+"');\">";
					data+="<td>"+list[key]["gdTypename"]+"</td>";  
					data+="<td>"+list[key]["bomcode"]+"</td>"; //코드
					data+="<td>"+list[key]["bomtext"]+"</td>"; //재료명
					data+="<td class='rt'>"+comma(list[key]["bomcapa"])+"</td>";  //용량
					data+="<td class='rt'>-</td>";  //용량
					data+="</tr>";
					var arr=["material",list[key]["gdTypename"],list[key]["bomcode"],list[key]["bomcapa"], list[key]["bomtext"], list[key]["gdCapa"]];
					bomarr.push(arr);
					//totqty=totqty+parseInt(list[key]["bomcapa"]);
					console.log("부자재 :: gdPillorder = " + list[key]["gdPillorder"]);
					if(!isEmpty(list[key]["gdPillorder"]))
					{	
						parentcnt++;
						viewpillorder("child",list[key]["gdPillorder"]);
					}
				}

			}





			//실속
			list=bomcodeList["worthy"];
			if(!isEmpty(list))
			{
				for(var key in list)
				{
					data+="<tr id='tr"+list[key]["bomcode"]+"');\">";
					data+="<td>"+list[key]["gdTypename"]+"</td>";  
					data+="<td>"+list[key]["bomcode"]+"</td>"; //코드
					data+="<td>"+list[key]["bomtext"]+"</td>"; //재료명
					data+="<td class='rt'>"+comma(list[key]["bomcapa"])+"</td>";  //용량
					data+="<td class='rt'>-</td>";  //용량
					data+="</tr>";
					var arr=["worthy",list[key]["gdTypename"],list[key]["bomcode"],list[key]["bomcapa"], list[key]["bomtext"], list[key]["gdCapa"]];
					bomarr.push(arr);
					//totqty=totqty+parseInt(list[key]["bomcapa"]);
					console.log("실속 :: gdPillorder = " + list[key]["gdPillorder"]);
					if(!isEmpty(list[key]["gdPillorder"]))
					{
						parentcnt++;
						viewpillorder("child",list[key]["gdPillorder"]);
					}
				}
			}
		}
		data+="<tr><th colspan='3'>총 투입량(부자재 제외)</th><th class='rt'>"+comma(totqty)+" g/개</th><th id='totper' class='rt'>-</th></tr>"; 
		/*
		for(var key in bomcodeList)
		{
			//data+="<tr id='tr"+bomcodeList[key]["bomseq"]+"' onclick=\"viewGoods("+bomcodeList[key]["bomseq"]+",'"+encodeURI(bomcodeList[key]["gdTypename"])+"');\">";
			data+="<tr id='tr"+bomcodeList[key]["bomseq"]+"');\">";
			data+="<td>"+bomcodeList[key]["gdTypename"]+"</td>";  
			data+="<td>"+bomcodeList[key]["bomcode"]+"</td>"; //코드
			data+="<td>"+bomcodeList[key]["bomtext"]+"</td>"; //재료명
			data+="<td>"+bomcodeList[key]["bomcapa"]+"</td>";  //용량
			data+="</tr>";
		}
		*/
		$("#bomcodelist tbody").html(data);
		//console.log(bomarr);

/*
		{"type":"packing","incapa":"1000(제거 0)","outcapa":"900(제거 0)","order":[
	{"medicine":[
		{"code":"KHBML","type":percent","value":"25"(추가),"capa":0}
		.{"code":"MA200515160940","type":unit","value":"1"(추가),"capa":0}
		.{"code":"MA200515160958","per":"25%"(추가)}
		.{"code":"MA200515160951","per":"25%"(추가)}
	]},
]}
*/
		var jBomlist=new Array();
		var totPer=0;
		var per=pertxt="";
		//var pacode=$("input[name=gdCode]").val();
		$.each(bomarr, function(idx, val){
			var btype=val[0];
			var btypename=val[1];
			var bcode=val[2];
			var bvalue=val[3];
			var bname=val[4];
			var bcapa=val[5];

			pertxt="";
			per="";
			if(btype=="medicine" || btype=="pregoods")
			{
				per=Math.round(bvalue / totqty * 100 * 100) / 100;
				pertxt=per.toFixed(2);
				if(isNaN( pertxt )){pertxt=0;}
				$("#tr"+bcode+" .per").text(pertxt+"%");
				totPer=totPer + per;
			}
			if(!isEmpty(per))
			{
				var medicine={type:btype,typetxt:btypename,code:bcode,name:bname,kind:"percent",value:per,capa:0,unit:bcapa};
			}
			else
			{
				var medicine={type:btype,typetxt:btypename,code:bcode,name:bname,kind:"unit",value:bvalue,capa:0,unit:bcapa};
			}

			
			console.log("##DOO:: type="+btype+",typetxt="+btypename+", code=" + bcode+", name="+bname+", value=" + bvalue +", per="+per+",pertxt="+pertxt);
			jBomlist.push(medicine);
		});

		if(isNaN( totPer )){totPer=0;}
		$("#totper").text(totPer.toFixed(2)+"%");

		console.log(JSON.stringify(jBomlist));

		//구성요소 리스트를 말자!
		$("textarea[name=gdPillmedicine]").val(JSON.stringify(jBomlist));

		var gdpillorder=$("textarea[name=gdPillorder]").val();
		console.log("구성요소 리스트를 말자!!!! jBomlist = " + JSON.stringify(jBomlist));
		console.log("구성요소 리스트를 말자!!!! gdpillorder = " + gdpillorder);
		if(!isEmpty(gdpillorder))
		{
			console.log("viewbomcodeList  changepillorder !isEmpty ");
			var orderdata=JSON.parse(gdpillorder);
			orderdata["order"]["medicine"]=jBomlist;
			$("textarea[name=gdPillorder]").val(JSON.stringify(orderdata));
		}
		else
		{
			console.log("viewbomcodeList  changepillorder null ");
			changepillorder(null);
		}
		
		console.log("pregoodsname =====>> " + pregoodsname);
		$("textarea[name=gdPregoodsname]").val("");
		if(!isEmpty(pregoodsname))
		{
			var name=pregoodsname.substring(1);
			console.log("name =====>> " + name);
			$("textarea[name=gdPregoodsname]").val(name);
			alertsign('error',name+" 구성요소에 제환순서를 입력해 주세요",'','2000'); //해당하는 구성요소에 제환순서를 입력해 주세요
		}
		
	}


	function goodsinfo(obj){
		var data = "";
		var seq=obj["seq"];
		$("#goodstit").text(obj["gdName"]);
		$("#nowgoods").text(obj["gdName"]);
		$("#pop_goodsinfo tbody").html("");
		if(!isEmpty(obj["gdBom"]))
		{
			var totCapa=0;
			var arrCapaCode=new Array();
			$(obj["gdBom"]).each(function( index, value )
			{
				data+="<tr id='goodsinfo"+value["gdCode"]+"' data-type='"+value["gdTypeCode"]+"'>";
				data+="<td>"+value["gdType"]+"</td>"; //제품상태
				data+="<td>"+value["gdCode"]+"</td>"; //품목코드
				data+="<td class='lf'><span class='btnx' onclick=\"delGoods('"+value["gdCode"]+"')\">X</span><b>"+value["gdName"]+"</b></td>"; //제품명
				//if(value["gdTypeCode"]=="material"){
				//	data+="<td class='capa'>"+value["gdRate"]+"</td></tr>"; //용량
				//}else{
					//data+="<td class='capa'><input type='text' name='gdRate' value='"+value["gdRate"]+"' onblur=\"capaupdate("+seq+",'"+value["gdCode"]+"',this.value);\" onkeyup=\"if(event.keyCode==13)capaupdate("+seq+",'"+value["gdCode"]+"',this.value);\"  onchange=\"changeNumber(event, false);\"></td></tr>"; //용량
					//data+="<td class='capa'><input type='text' name='gdRate' value='"+value["gdRate"]+"' onkeyup=\"capaupdate("+seq+",'"+value["gdCode"]+"',this.value, event, false);\"></td>"; //용량
					data+="<td class='capa'><input type='text' name='gdRate' value='"+value["gdRate"]+"' onkeyup='recountrate(event, false);'></td>"; //용량
					if(value["gdTypeCode"]=="pregoods" || value["gdTypeCode"]=="origin"){
						data+="<td class='rt per'>0%</td></tr>"; //비율
					}else{
						data+="<td class='rt'>-</td></tr>"; //비율
					}
				//}
				if(value["gdTypeCode"]=="pregoods" || value["gdTypeCode"]=="origin"){
					arrCapaCode.push(value["gdCode"]);
					totCapa+=parseInt(value["gdRate"]);
				}
				//팝업의 하위요소
				if(value["gdBom"].length > 0){
					$(value["gdBom"]).each(function( index2, value2 )
					{
						data+="<tr id='goodsinfo"+value2["gdCode"]+"'>";
						data+="<td style='text-align:right;margin-right:2px;'>&gt&gt&gt&gt</td>"; //제품상태
						data+="<td>"+value2["gdCode"]+"</td>"; //제품상태
						//data+="<td class='lf'>["+value2["gdType"]+"] <b onclick=\"viewGoods("+value2["gdSeq"]+",'"+encodeURI(value2["gdName"])+"')\">"+value2["gdName"]+"</b></td>"; //제품명
						data+="<td class='lf'>["+value2["gdType"]+"] <b>"+value2["gdName"]+"</b></td>"; //제품명
						data+="<td class='' colspan='2'></td>"; //비율
						data+="</tr>";
					});
				}
			});
		}
		else
		{
			data+="<tr><td colspan='5'><?=$txtdt['1665']?></td></tr>";
		}
		if(totCapa==undefined){totCapa=0;}
		data+="<tr><th colspan='3'>구성요소총량 (부자재제외)</th><th id='totCapa' class='rt' >"+comma(totCapa)+" g/개</th><th id='pertotCapa' class='rt'></th></tr>";
		$("#pop_goodsinfo tbody").html(data);
		var totPer=0;
		$.each(arrCapaCode, function(idx, val){
			var chk=$("#goodsinfo"+val).attr("data-type");
			console.log(chk);
			var rate=$("#goodsinfo"+val).children(".capa").children("input").val();
			var per=Math.round(rate / totCapa * 100 * 100) / 100;
			var pertxt=per.toFixed(2);
			pertxt = (isNaN(pertxt)==false) ? pertxt : 0;
			$("#goodsinfo"+val).children("td.per").text(pertxt+"%");
			totPer=totPer + per;
		});
		totPer = (isNaN(totPer)==false) ? totPer : 0;
		$("#pertotCapa").text(totPer.toFixed(2)+"%");
		return false;
	}

	function recountrate(evt, check){
		changeNumber(evt, check);
		var totCapa=0;
		$("#pop_goodsinfo tbody tr td.capa input").each(function(){
			var type=$(this).parent("td").parent("tr").attr("data-type");
			if(type=="pregoods" || type=="origin"){
				totCapa+=parseInt($(this).val());
			}
		});
		var totPer=0;
		$("#pop_goodsinfo tbody tr td.capa input").each(function(){
			var type=$(this).parent("td").parent("tr").attr("data-type");
			if(type=="pregoods" || type=="origin"){
				var rate=parseInt($(this).val());
				var per=Math.round(rate / totCapa * 100 * 100) / 100;
				var pertxt=per.toFixed(2);
				$(this).parent().next("td.per").text(pertxt+"%");
				totPer=totPer + per;
			}
		});
		$("#totCapa").text(comma(totCapa)+" g/개");
		$("#pertotCapa").text(totPer.toFixed(2)+"%");
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
				//data+="<td class='lf'>"+value["gdName"]+"("+value["gdOrigin"]+")<span class='btnadd' onclick=\"addGoods('"+value["gdCode"]+"')\">▶▶</span></td>"; //제품명
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
		//getsubpage_pop("goodslistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"],"goods");
		getsubpage_pop("goodslistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"], "goodspop");
		return false;
	}
	function parseselpill(list, title, name, data)
	{
		var selected=selstr="";
		selstr='<select name="'+name+'" id="'+name+'" title="'+title+'" class="w100p pilldata" onchange="changepillorder(this);">';
		selstr+='<option value="">선택해주세요</option>';
		for(var key in list)
		{
			selected = "";
			if(isEmpty(data))
			{
				if('inmain' == list[key]["cdCode"])
					selected = "selected";
			}
			else
			{
				if(data == list[key]["cdCode"])
					selected = "selected";
			}
			selstr+='<option value='+list[key]["cdCode"]+' '+selected+'>'+list[key]["cdName"]+'</option>';
		}
		selstr+='</select>';
		return selstr;
	}
	
	//checkbox 
	function parsecheckpill(list, title, name, data)
	{
		console.log("parsecheckpill title="+title+", name="+name+", data="+data);
	    var option = checked = hiddenvalue = "";
	    option = '<dl class="chkdl">';
		for(var key in list)
		{
			option+='<dd><label for="'+list[key]["bomcode"]+'">';
			option+='<input type="checkbox" name="'+name+'" title = "'+title+'" id="'+list[key]["bomcode"]+'" value="'+list[key]["bomcode"]+'" '+checked+' onclick="changepillorder(this)" data-name="'+list[key]["bomtext"]+'">'+list[key]["bomtext"]+'</label></dd>';
		}
	    option += '</dl>';
		return option;
	}
    function makepage(json)
    {
		console.log("makepage ----------------------------------------------- start")
		var obj = JSON.parse(json);
		console.log(obj)
		console.log("apiCode : " + obj["apiCode"])

		if(obj["apiCode"]=="goodsgoodsdesc")   //오른쪽 구성요소 화면
		{

			var date = getNowFull(4);
			var rcCode = (!isEmpty(obj["gdRecipe"])) ? obj["gdRecipe"] : "RC"+date;
			$("input[name=rcCode]").val(rcCode); 	

			console.log("rcCode   >>>  "+rcCode);

			$("input[name=seq]").val(obj["seq"]); 
			$("input[name=gdType]").val(obj["gdType"]); 
			$("input[name=gdCode]").val(obj["gdCode"]); 
			$("input[name=gdUnit]").val(obj["gdUnit"]); 
			$("input[name=gdNameKor]").val(obj["gdNameKor"]); 
			//$("input[name=gdSpec]").val(obj["gdSpec"]); 
			//$("input[name=gdUse]").val(obj["gdUse"]); 
			//$("select[name=gdLoss]").val(obj["gdLoss"]); 

			

			$("input[name=gdLossCapa]").val(obj["gdLossCapa"]); 
			$("input[name=gdStable]").val(obj["gdStable"]); 
			$("input[name=gdCapa]").val(obj["gdCapa"]); 
			
			$("textarea[name=gdDesc]").val(obj["gdDesc"]); 
			$('input:radio[name=gdUse]:input[value="'+obj["gdUse"]+'"]').attr("checked", true);
			if(obj["gdType"]==""||obj["gdType"]==undefined)obj["gdType"]="pregoods";
			parseradiocodes("goodstypeDiv", obj["gdTypeList"], '<?=$txtdt["1132"]?>', "gdType", "goodstype-list", obj["gdType"], '');

			//로스타입 
			var gdLoss=!isEmpty(obj["gdLoss"])?obj["gdLoss"]:"100";
			if(gdLoss=="0" || gdLoss=="1")
			{
				gdLoss="100";
			}
			parseradiocodes("losstypediv", obj["gdLossTypeList"], '로스타입', "gdLoss", "goodstype-list", gdLoss, '');
			$('input:radio[name=gdLoss]:input[value="'+gdLoss+'"]').attr("checked", true);
			
			
			//제환순서
			var podata="";
			var seq="<?=$seq?>";
			$(obj["pillOrderList"]).each(function( index, value )
			{
				podata+="<dl id='"+value["cdCode"]+"' class='pilldl'>";
				podata+="<dt onclick=\"selorder('"+seq+"','"+value["cdCode"]+"', '"+value["cdName"]+"')\">"+value["cdName"]+"</dt>";
				podata+="</dl>";
			});
			$("#pillorderdiv").html(podata);

			//농축비율
			var pConcentRatio = parseselpill(obj["pillRatioList"], '농축비율', 'plConcentRatio', null);
			$("#goodstypeDiv").prepend("<textarea name='selConcentRatio' style='display:none;'>"+pConcentRatio+"</textarea>");
			//농축시간
			var pConcentTime = parseselpill(obj["pillTimeList"], '농축시간', 'plConcentTime', null);
			$("#goodstypeDiv").prepend("<textarea name='selConcentTime' style='display:none;'>"+pConcentTime+"</textarea>");
			//착즙유무
			var pJuice = parseselpill(obj["pillJuiceList"], '착즙유무', 'plJuice', null);
			$("#goodstypeDiv").prepend("<textarea name='selJuice' style='display:none;'>"+pJuice+"</textarea>");
			//중탕온도
			var pWarmupTemperature = parseselpill(obj["pillTemperatureList"], '중탕온도', 'plWarmupTemperature', null);
			$("#goodstypeDiv").prepend("<textarea name='selWarmupTemperature' style='display:none;'>"+pWarmupTemperature+"</textarea>");
			//중탕시간 
			var pWarmupTime = parseselpill(obj["pillTimeList"], '중탕시간', 'plWarmupTime', null);
			$("#goodstypeDiv").prepend("<textarea name='selWarmupTime' style='display:none;'>"+pWarmupTime+"</textarea>");
			//탕전법
			var pdcTitle = parseselpill(obj["dcTitleList"], '탕전법', 'plDctitle', null);
			$("#goodstypeDiv").prepend("<textarea name='selDcTitle' style='display:none;'>"+pdcTitle+"</textarea>");
			//특수탕전
			var pdcSpecial = parseselpill(obj["dcSpecialList"], '특수탕전', 'plDcspecial', null);
			$("#goodstypeDiv").prepend("<textarea name='selDcSpecial' style='display:none;'>"+pdcSpecial+"</textarea>");
			//제형
			var pShape = parseselpill(obj["pillShapeList"], '제형', 'plShape', null);
			$("#goodstypeDiv").prepend("<textarea name='selShape' style='display:none;'>"+pShape+"</textarea>");
			//결합제
			var pBinders = parseselpill(obj["pillBindersList"], '결합제', 'plBinders', null);
			$("#goodstypeDiv").prepend("<textarea name='selBinders' style='display:none;'>"+pBinders+"</textarea>");
			//교반결합제
			var pstirBinders = parseselpill(obj["pillBindersList"], '결합제', 'plstirBinders', null);
			$("#goodstypeDiv").prepend("<textarea name='selstirBinders' style='display:none;'>"+pstirBinders+"</textarea>");
			//분말도
			var pFineness = parseselpill(obj["pillFinenessList"], '분말도', 'plFineness', null);
			$("#goodstypeDiv").prepend("<textarea name='selFineness' style='display:none;'>"+pFineness+"</textarea>");
			//숙성온도 
			var pFermentTemperature = parseselpill(obj["pillTemperatureList"], '숙성온도', 'plFermentTemperature', null);
			$("#goodstypeDiv").prepend("<textarea name='selFermentTemperature' style='display:none;'>"+pFermentTemperature+"</textarea>");
			//숙성시간
			var pFermentTime = parseselpill(obj["pillTimeList"], '숙성시간', 'plFermentTime', null);
			$("#goodstypeDiv").prepend("<textarea name='selFermentTime' style='display:none;'>"+pFermentTime+"</textarea>");
			//건조온도 
			var pDryTemperature = parseselpill(obj["pillTemperatureList"], '건조온도', 'plDryTemperature', null);
			$("#goodstypeDiv").prepend("<textarea name='selDryTemperature' style='display:none;'>"+pDryTemperature+"</textarea>");
			//건조시간
			var pDryTime = parseselpill(obj["pillTimeList"], '건조시간', 'plDryTime', null);
			$("#goodstypeDiv").prepend("<textarea name='selDryTime' style='display:none;'>"+pDryTime+"</textarea>");
			//불림시간
			var pSoakTime = parseselpill(obj["pillTimeList"], '불림시간', 'plSoakTime', null);
			$("#goodstypeDiv").prepend("<textarea name='selSoakTime' style='display:none;'>"+pSoakTime+"</textarea>");
			//부자재 
			if(!isEmpty(obj["bomcodeList"]))
			{
				var plPacking = parsecheckpill(obj["bomcodeList"]["material"], '포장', 'plPacking', null);
				$("#goodstypeDiv").prepend("<textarea name='chkPacking' style='display:none;'>"+plPacking+"</textarea>");
			}


			//현재등록된 pillorder data -->> 위에 데이터들을 다 불러온다음 해야함 
			if(!isEmpty(obj["gdPillorder"]))
			{
				$("textarea[name=gdPillorder]").val(obj["gdPillorder"]);
				viewpillorder("parent",obj["gdPillorder"]);
			}

			//parseradiocodes("pregoodstypeDiv", obj["gdCategoryList"], '<?=$txtdt["1932"]?>', "gdCategory", "pregoodstype-list", obj["gdCategory"], '');  //반제품의 상세분류
			//parseradiocodes("gdUseDiv", obj["UseList"], '<?=$txtdt["1932"]?>', "gdUse", "gdUse-list", obj["gdUse"], '');  //승인전, 후
			
			setFileCode("goods", obj["gdCode"], obj["seq"]);
			//upload된 이미지가 있다면
			if(!isEmpty(obj["afFiles"]))
			{
				handleImgFileSelect(obj["afFiles"]);
			}

			if(isEmpty(obj["seq"])) 
			{
				//$('#gdUseDiv').text('처음 등록시에는 사용전 상태로 등록됩니다.');
				//$("#radioDiv").css("display","none");			
				$('#BomDiv').text('등록 하신후 구성요소를 다시 입력해주세요');
				//$("#pregoodstypeDiv").css("display","none");	//반제품 상세분류 안나오게 
			}
			else
			{
				//if(obj["gdUse"]=="A")  //사용전 상태이면 승인 버튼이 보이게 처리
				//{				
					//$('#gdUseDiv').html('<button type="button" class="sp-btn" onclick="approvalBtn();">승인</button>');
					//$("#radioDiv").css("display","none");	
				//}
	
				$("input[name=codechk]").val(1);  //seq가 있으면 가능

				if(obj["gdType"]=="goods")  
				{				
					$("#addbtn").css("display","block");//구성요소 등록수정버튼 
					//$("#pregoodstypeDiv").css("display","none");	//반제품 상세분류 안나오게 
				}
				else if(obj["gdType"]=="pregoods")
				{
				
					$("#addbtn").css("display","block");//구성요소 등록수정버튼 
				
				}
				else if(obj["gdType"]=="material")
				{
				
					//$("#pregoodstypeDiv").css("display","none");	//반제품 상세분류 안나오게 
				
				}
			}

			var btnHtml='';
			var json = "seq="+obj["seq"];

			//승인완료되면 등록수정버튼 안보이게 처리함
			if(obj["gdUse"]=="Y")
			{			
				$("#addbtn").css("display","none");////승인완료되면 구성요소 수정 버튼 안보이게 처리함
				btnHtml+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록
				btnHtml+='<a href="javascript:goods_del();" class="bdp-btn"><span><?=$txtdt["1154"]?></span></a>';//삭제
			}
			else
			{
				btnHtml='<a href="javascript:;" onclick="goodsupdate();" class="bdp-btn"><span><?=$txtdt["1070"]?></span></a> ';//저장하기
				btnHtml+='<a href="javascript:;" onclick="viewlist();" class="bw-btn"><span><?=$txtdt["1087"]?></span></a> ';//목록
				btnHtml+='<a href="javascript:goods_del();" class="bdp-btn"><span><?=$txtdt["1154"]?></span></a>';//삭제
			}

			$("#btnDiv").html(btnHtml);

			if(obj["gdUse"]=="Y") //승인완료되면 사용은 승인완료로 보여지기만 처리
			{			
				var usedata=' <input type="radio" id="radiouseA" name="radiouse" class="radiodata" title="<?=$txtdt["1144"]?>" value="A" onclick="return(false);" />  ';
					usedata+=' <label for="radiouseA" style="color:#A4A4A4;">승인전 &nbsp;&nbsp;</label> ';
					usedata+=' <input type="radio" id="radiouseY" name="gdUse" class="radiodata" title="<?=$txtdt["1144"]?>" value="Y" onclick="return(false);" checked/> ';
					usedata+=' <label for="radiouseY">승인 완료 &nbsp;&nbsp;</label> ';
				$("#radioDiv").html(usedata);
			}


			//구성요소 
			viewbomcodeList(obj["bomcodeList"]);
			//구성요소에 해당하는 child들을 다 뽑아온다 
			viewchildbomcodeList(obj["childbomcodeList"]);

		}
		else if(obj["apiCode"] == "medicinelist") //약재리스트
		{
			var data = "";
			var capa = 0;
			$("#laymedicinetbl tbody").html("");
			if(!isEmpty(obj["list"]))
			{
				$(obj["list"]).each(function( index, value )
				{
					capa = (isNaN(value["mdProperty"])==false) ? value["mdProperty"] : 0;
					data+='<tr class="putpopdata" onclick="javascript:putpopdata(this);" data-code="'+value["mdCode"]+'" data-property="'+capa+'">';
					data+='<td>'+value["mdTypeName"]+'</td>';
					data+='<td>'+value["mmCode"]+'</td>'; //청연 약재코드
					data+='<td>'+value["mmtitle"]+'</td>'; //고객 약재명(디제이메디아님)
					data+='<td>'+value["mdOrigin"]+'/'+value["mdMaker"]+'</td>';
					//data+='<td>'+capa+'</td>';
					data+='<td>'+value["mdPrice"]+' <?=$txtdt["1235"]?> </td>';
					data+='</tr>';
				});
			}
			else
			{
				data+="<tr>";
				data+="	<td colspan='5'><?=$txtdt['1665']?></td>";
				data+="</tr>";
			}
			$("#laymedicinetbl tbody").html(data);

			//페이징
			$("#poptotcnt").text(obj["tcnt"]+" 건");
			
			getsubpage_pop("medicinelistpage",obj["tpage"], obj["page"], obj["block"], obj["psize"], obj["reData"]);
		}
		else if(obj["apiCode"]=="goodspoplist") //layer-goods 왼쪽 리스트 화면 (팝업)
		{
			viewpoplist(obj);
		}
		else if(obj["apiCode"]=="goodsdesc")  //layer-goods 오른쪽 화면 (팝업)
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
			//$("input[name=gdCapa]").focus();
			//viewbomcodeList(obj["bomcodeList"]);
		}
		else if(obj["apiCode"]=="goodsaddmaterial" || obj["apiCode"]=="goodsdelmaterial" || obj["apiCode"]=="goodsdelmaterialsub")
		{
			$("#goodslistpage").attr("data-value","adddel");
			var seq=obj["seq"];
			console.log(seq);
			callapi('GET','goods','goodsdesc',"seq="+seq);
			parent.document.location.hash="#|"+seq+"|"
		}
		else if(obj["apiCode"]=="goodsaddcapa")
		{
			//$("#goodslistpage").attr("data-value","adddel");
			//var seq=obj["seq"];
			//console.log(seq);
			//callapi('GET','goods','goodsdesc',"seq="+seq);
			//parent.document.location.hash="#|"+seq+"|"
		}
		else if(obj["apiCode"]=="goodslist")
		{
			viewpoplist(obj)
		}
		else if (obj["apiCode"]=="chkcode")  //코드 중복체크
		{
			if(obj["resultCode"] == "200")
			{
				$(".checkcode").html('<span class="stxt" id="idsame" style="color:red;"> <?=$txtdt["1526"]?></span>'); //중복아이디
				$("#codechk").val(0);
			}
			else
			{
				$(".checkcode").html('<span class="stxt" id="idsame" style="color:blue;"> <?=$txtdt["1476"]?></span>'); //사용 가능합니다
				$("#codechk").val(1);
			}
			return false;
		}
		else if(obj["apiCode"] == "selsuborder") //제환순서작업
		{
			//$("#"+obj["code"]+" dd").remove();
			var sel="<dd><select name='"+obj["code"]+"' class='pilldata' onchange=\"chkorder('"+obj["code"]+"',this)\">";
				sel+="<option value=''>사용안함";
				$(obj["list"]).each(function( index, value ){
					sel+="<option value='"+value["cdCode"]+"'>"+value["cdCodeTxt"];
				});
				 sel+="</select> <span class='clsbtn' onclick='delorder(this)'>X</span></dd>";
				 $("#"+obj["code"]).append(sel);
		}
	     return false;
    }

	
	
	var hdata=location.hash.replace("#","").split("|");
	var page=hdata[0];
	var search=hdata[2];
	if(page==undefined){
		page=1;
	}

	if(search==undefined){
		var searchTxt="";
	}else{
		var sarr=search.split("&");
		if(sarr[0]!=undefined)var sarr1=sarr[0].split("=");
		if(sarr[1]!=undefined)var sarr2=sarr[1].split("=");
		if(sarr1[1]!=undefined)var searchTxt=sarr1[1];
		//if(sarr2[1]!=undefined)var searchStatus=sarr2[1];
		$("input[name=searchTxt]").val(decodeURI(searchTxt));
	}

	if(searchTxt==undefined){
		searchTxt="";
		$("input[name=searchTxt]").val("");
	}
	var apidata="page="+page+"&searchTxt="+searchTxt;
	callapi('GET','goods','goodsgoodsdesc','<?=$apidata?>'); 
</script>
