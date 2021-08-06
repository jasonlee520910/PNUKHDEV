<?php
	$root="..";
	include_once $root."/_Inc/head.php";
?>
<div id="listdiv"></div>
<input type="hidden" name="medicalid" class="ajaxdata" value="<?=$_COOKIE["ck_miUserid"]?>">

<script>
	function getlist(search)
	{
		var sear=searchdata(search);
		callapi("GET","/medical/order/",getdata("orderlist")+sear);
	}



	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage();
	}
	
	viewpage();  //첫페이지

	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		var search=!isEmpty(hdata[3])?hdata[3]:"";

		//처방기록  
		$("#listdiv").load("<?=$root?>/Skin/Member/Record.php",function(){
			getlist(search);
		});

	}

</script>

<?php
   include_once $root."/_Inc/tail.php"; ?>

<script>

   	function makepage(result)
	{		
		var obj = JSON.parse(result);
		console.log(obj);
		console.log("apiCode>>>>> "+obj["apiCode"]);

		if(obj["apiCode"]=="orderlist")  //환자리스트
		{
			//$marr=array("한의사","처방번호","처방전송일자","환자명","처방명","진행상황","합계금액");
			var marr=["ordercode","orderdate","patientname","ordertitle","orderstatus","amounttotal"];	
			makelist(result, marr);
		}
	}

	function viewdesc(seq)
	{
		location.href="<?=$root?>/Order/Potion.php?seq="+seq;

	}



</script>