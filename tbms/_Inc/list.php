<?php
	$root="..";
	include_once $root."/_common.php";

	$page = ($_GET["page"]) ? $_GET["page"] : 1;//page
	$psize = ($_GET["psize"]) ? $_GET["psize"] : 10;//psize
	$block = ($_GET["block"]) ? $_GET["block"] : 10;//block
	$depart = $_GET["depart"];//depart
	$apiOrderData = "wktype=process&depart=".$depart."&page=".$page."&psize=".$psize."&block=".$block."&staffid=".$_COOKIE["ck_ntStaffid"]."&maTable=".$_COOKIE["ck_matable"]."&pillType=".$_COOKIE["ck_pilltype"];
?>
<div id="pagegroup" value="<?=$depart?>"></div>
<div id="pagecode" value="orderlist"></div>
<div class="contents nobor">
	<div class="lst_tb">
		<table id="listtbl" summary="<?=$txtdt["order"]?>" >
			<caption class="hide"><?=$txtdt["order"]?></caption>
			<colgroup>
					<col width="17%" />
					<col width="16%" />
					<col width="25%" />
					<col width="27%" />
					<col width="15%" />
			</colgroup>
			<thead>
				<tr>
					<th scope="col"><?=$txtdt["commdate"]?></th>
					<th scope="col"><?=$txtdt["odcode"]?> </th>
					<th scope="col"><?=$txtdt["hospital"]?>/<?=$txtdt["oduser"]?></th>
					<th scope="col"><?=$txtdt["scription"]?></th>
					<th scope="col"><?=$txtdt["odstatus"]?></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	<!-- s : 게시판 페이징 -->
	<div class='paging-wrap' id="orderlistpage"></div>
	<!-- e : 게시판 페이징 -->
</div>

<script>
	callapi('GET',"<?=$depart?>",'orderlist',"<?=$apiOrderData?>");
</script>