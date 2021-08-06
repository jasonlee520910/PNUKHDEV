<?php  $root="..";?>
<?php  include_once ($root.'/cmmInc/subHead.php');?>
<!--// page start -->
<link rel="stylesheet" media="all" href="<?=$root?>/00_DashBoard/dashboard_200313.css?v=<?=time();?>" />
<div id="listdiv" data-value="/Skin/DashBoard/OrderGraph"></div>
<!--// page end -->
<?php  include_once ($root.'/cmmInc/subTail.php');?>

<script>$("#listdiv").load("<?=$root?>/Skin/DashBoard/OrderGraph.php");</script>

