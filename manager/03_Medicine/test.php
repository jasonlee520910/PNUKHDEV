<?php  $root="..";?>
<?php  include_once ($root.'/cmmInc/subHead.php');?>

<!--// page start -->
<div id="listdiv" data-value="/Skin/Medicine/Hub"></div>

<script>
	window.onhashchange = function(e) {		
		$("#listdiv").load("<?=$root?>/Skin/Medicine/testList.php");  //해시값이 바뀌면
	}

	//첫페이지
	$("#listdiv").load("<?=$root?>/Skin/Medicine/testList.php");

	//검색을 하면 1페이지로 간다
	function searchhash(search){
		location.hash="1|"+search;
	}
</script>

<!--// page end -->
<?php  include_once ($root.'/cmmInc/subTail.php');?>
