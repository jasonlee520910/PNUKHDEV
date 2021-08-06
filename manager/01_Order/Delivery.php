<?php  $root="..";?>
<?php  include_once ($root.'/cmmInc/subHead.php');?>
<!--// page start -->
<div id="listdiv" data-value="/Skin/Order/Order"></div>

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
		//console.log("order odStatus   :"+odStatus);
		//console.log("order seq   :"+seq);
		if(seq==undefined || seq=="")
		{
			$("#listdiv").load("<?=$root?>/Skin/Order/DeliveryList.php");  //seq값이 없으면
		}
		else if(seq=="add")
		{
			$("#listdiv").load("<?=$root?>/Skin/Order/DeliveryWrite.php?seq="+seq);  //seq값이 add
		}
	}
</script>

<!--// page end -->
<?php  include_once ($root.'/cmmInc/subTail.php');?>


