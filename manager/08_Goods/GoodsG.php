<?php  $root="..";?>
<?php  include_once ($root.'/cmmInc/subHead.php');?>
<!--// page start -->
<div id="listdiv" data-value="/Skin/Goods/GoodsG"></div>

<script>
	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		
		viewpage();
	}
	
		viewpage();  //첫페이지

	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		var seq=hdata[1];
		var odStatus=hdata[3];
		var odGoods=hdata[4];
		
		console.log("order odStatus   :"+odStatus);
		console.log("order seq   :"+seq);
		var ck_stDepart=getCookie("ck_stDepart");
		var ck_stUserid=getCookie("ck_stUserid");
		console.log("DOO :: ck_stDepart = " + ck_stDepart+", odStatus = " + odStatus+", ck_stUserid = " + ck_stUserid);
		if(seq==undefined || seq=="")
		{
			$("#listdiv").load("<?=$root?>/Skin/Goods/GoodsGList.php");  //seq값이 없으면
		}
		else 
		{	
			$("#listdiv").load("<?=$root?>/Skin/Goods/GoodsGWrite.php?seq="+seq+"&type=G");  
		}
	}

</script>

<!--// page end -->
<?php  include_once ($root.'/cmmInc/subTail.php');?>


