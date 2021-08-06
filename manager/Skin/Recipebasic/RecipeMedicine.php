<?php //고유처방 약재 리스트 

	$root = "../..";
	include_once $root."/_common.php";

	$medicine = $_GET["medicine"];
	$sweet = $_GET["sweet"];

	//주문리스트 API 호출할 파라미터값 
	$apiOrderData ="medicine=".$medicine."&sweet=".$sweet;

?>
<input type="hidden" title="<?=$txtdt["1497"]?>" class="reqdata necdata" name="rcMedicine" value="<?=$_GET["medicine"]?>"/><!--약재-->
<input type="hidden" name="rcSweet" class="reqdata" class="w90p" value="<?=$_GET["sweet"];?>">

<div class="board-list-wrap" id="board-list-wrap">
	<span class="bd-line"></span>

	<div class="list-select">
		<p class="fl info-txt">
			<span id="totmedicnt"><?=$txtdt["1339"]?> : <!-- 총약재 --><i id="totMedicineDiv"></i></span>
			<span id="totmedicnt"><?=$txtdt["1064"]?> : <!-- 독성 --> <i id="totPoisonDiv"></i></span>
			<span id="totmedicnt"><?=$txtdt["1158"]?> : <!-- 상극 --> <i id="totDismatchDiv" class="cred"></i></span>
		</p>
	</div>

	<table id="medicinetbl">
		<colgroup>
			<!-- <col scope="col" width="13%"> -->
			<col scope="col" width="15%">
			<col scope="col" width="*">
			<col scope="col" width="25%">
			<col scope="col" width="17%">
			<col scope="col" width="8%">
			<col scope="col" width="5%">
		</colgroup>

		<thead>
		</thead>

		<tbody>
		</tbody>
	</table>	
</div>


<script>
	//select box (선전,일반,후하) 선택시
	function mediChange()
	{
		resetmedi();
	}
	function resetmedi()
	{
		var capa=0;
		//---------------------------------------------
		//약재 
		//---------------------------------------------
		var rccode=new Array();
		$(".rccode").each(function(){
			rccode.push($(this).val().trim());
		});
		var rcDecoctype=new Array();
		$(".rcDecoctype").each(function(){
			rcDecoctype.push($(this).val().trim());
		});
		var chubamt=new Array();
		$(".chubamt").each(function(){
			chubamt.push($(this).val().trim());
		});		

		var len=$(".rccode").length;
		var medicine="";
		for(var i=0;i<len;i++)
		{
			capa = (isNaN(chubamt[i])==false) ? chubamt[i] : 0;
			medicine+="|"+rccode[i]+","+capa+","+rcDecoctype[i]+",";
		}

		medicine = medicine.replace(/ /gi, "");
		console.log("resetmedi 약재  === " + medicine);
		$("input[name=rcMedicine]").val(medicine);

		//---------------------------------------------
		//별전
		//---------------------------------------------
		var srccode=new Array();
		$(".srccode").each(function(){
			srccode.push($(this).val().trim());
		});
		var srcDecoctype=new Array();
		$(".srcDecoctype").each(function(){
			srcDecoctype.push($(this).val().trim());
		});
		var schubamt=new Array();
		$(".schubamt").each(function(){
			schubamt.push($(this).val().trim());
		});
	
		var slen=$(".srccode").length;
		var sweet="";
		for(var i=0;i<slen;i++)
		{
			capa = (isNaN(schubamt[i])==false) ? schubamt[i] : 0;
			sweet+="|"+srccode[i]+","+capa+","+srcDecoctype[i]+",";
		}
		sweet = sweet.replace(/ /gi, "");
		console.log("resetmedi 별전  === " + sweet);
		$("input[name=rcSweet]").val(sweet);
	}
	function deletemedi(code)
	{
		/*var marr2=medicine="";
		var m=0;
		var mediarr=$("input[name=rcMedicine]").val().split("|");
		for(var i=1;i<mediarr.length;i++)
		{
			marr2=mediarr[i].split(",");
			if(marr2[0]!=code)
			{
				medicine+="|"+mediarr[i];
				m++;
			}
		}
		*/
		$("#md"+code).remove();
		resetmedi();
	}

	var medicine = '<?=$medicine?>';
	var sweet = '<?=$sweet?>';

	console.log("recipemedicine medicine = " + medicine+", sweet = " + sweet);
	if(!isEmpty(medicine) || !isEmpty(sweet))
	{
		//약재리스트 API 호출
		callapi('GET','medicine','medicinetitle','<?=$apiOrderData?>');
	}
</script>
