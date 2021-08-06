<?php
	$navcarr=array("making","decoction","marking","release","goods");
	$navtarr=array($txtdt["making"],$txtdt["decoction"],$txtdt["marking"],$txtdt["release"],$txtdt["9034"]);
?>
<nav class="nav" id="nav" data-bind="<?=$depart?>">
	<?php
	$navi_sel=$navi_blank="";

	for($i=0;$i<count($navcarr);$i++)
	{
		if($_COOKIE["ck_staffdepart"]==$navcarr[$i]||$_COOKIE["ck_staffdepart"]=="manager")
		{
			if($_COOKIE["ck_staffdepart"]==$navcarr[$i]||($_COOKIE["ck_staffdepart"]=="manager"&&$url[2]==$navcarr[$i]))
			{
				$on="on";
			}
			else
			{
				$on="";$cust="";
			}
			$navi_sel.="<a href='".$navcarr[$i]."/' date-value='".$navcarr[$i]."' class='".$on."'>".$navtarr[$i]."".$cust."</a>";
		}
		else
		{
			$navi_blank.="<a href='javascript:;' date-value='' class=''></a>";
		}
	}
	echo $navi_sel.$navi_blank;
	?>

<!--
	<a href="<?=$root?>/making" date-value="making" class="on">조제</a>
	<a href="<?=$root?>/decoction" date-value="decoction">탕제<spna class="info">홍길동<time>07.07 / 23:00</time></spna></a>
	<a href="<?=$root?>/marking" date-value="marking">마킹</a>
	<a href="<?=$root?>/release" date-value="release">출고</a>

 -->
</nav>