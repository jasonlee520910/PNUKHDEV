<?php  $root="..";?>
<?php  include_once ($root.'/cmmInc/subHead.php');?>

<!--// page start -->
<div id="listdiv" data-value="/Skin/Stock/StockRoute"></div>

<script>
	$("#listdiv").load("<?=$root?>/Skin/Stock/StockRoute.php");
</script>

<!--// page end -->
<?php  include_once ($root.'/cmmInc/subTail.php');?>
