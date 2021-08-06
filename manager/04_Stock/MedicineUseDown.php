
<?php  $root="..";?>
<?php  include_once ($root.'/cmmInc/subHead.php');?>

<!--// page start -->
<div id="listdiv" data-value="/Skin/Stock/MedicineUseDown"></div>

<script>
	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage();

	}
	
		viewpage();  //첫페이지

	function viewpage()
	{
		$("#listdiv").load("<?=$root?>/Skin/Stock/MedicineUseDown.php");
	}

</script>

<!--// page end -->
<?php  include_once ($root.'/cmmInc/subTail.php');?>
