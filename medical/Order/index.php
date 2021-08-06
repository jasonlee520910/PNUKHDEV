<?php
	$root="..";
	include_once $root."/_Inc/head.php";
?>
<div id="listdiv"></div>
<script>
	function getlist(search)
	{
		var sear=searchdata(search);
		callapi("GET","/medical/order/",getdata("orderlist")+"&pagetype=notemp"+sear);
	}

	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage();
	}
	
	viewpage();  //첫페이지

	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		var seq=hdata[1];
		var search=!isEmpty(hdata[3])?hdata[3]:"";
		console.log("viewpageviewpageviewpageviewpageviewpageviewpage     ====>>>>  seq="+seq);
		//주문내역  
		$("#listdiv").load("<?=$root?>/Skin/Order/OrderList.php",function(){
			getlist(search);
		});
	}

</script>

<?php
include_once $root."/_Inc/tail.php"; 
?>
