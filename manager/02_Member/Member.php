<?php  $root="..";?>
<?php  include_once ($root.'/cmmInc/subHead.php');?>
<!--// page start -->
<div id="listdiv" data-value="/Skin/Member/Member"></div>

<script>
	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage();
	}
	
		viewpage();  //첫페이지

	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		var userid=hdata[1];
		if(userid==undefined || userid=="")
		{
			$("#listdiv").load("<?=$root?>/Skin/Member/MemberList.php");  //seq값이 없으면
		}
		else
		{
			$("#listdiv").load("<?=$root?>/Skin/Member/MemberWrite.php?userid="+userid);  //seq값이 있으면
		}
	}
</script>

<!--// page end -->
<?php  include_once ($root.'/cmmInc/subTail.php');?>

