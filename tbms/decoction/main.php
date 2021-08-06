<?php
	$root="..";
	include_once $root."/_common.php";

	$code=$_GET["code"];
	$stat=$_GET["stat"];
	$ordercode=$_GET["ordercode"];
	//로그인 작업 후 다시 COOKIE 로 바꿔야함
	$ck_staffid=$_COOKIE["ck_ntStaffid"];

	$apiData="code=".$code."&ck_staffid=".$ck_staffid."&stat=".$stat."&ordercode=".$ordercode."&decoctionprocess=".$decoctionprocess;
	//echo $apiData;
?>

<style>
	.cmt1 {height:150px;}
	.decoleft {float:left;width:70%;height:auto;text-align: left;padding:0}
	.decoright {float:left;width:30%;height:auto;text-align: left;padding:0}

	.derequest {display:block;background-color:black;font-size:20px;width:auto;height:150px;color:#f2c261; vertical-align:middle;overflow-y:auto;padding:10px;}
	ul.boilerview{}
	ul.boilerview li{position:absolute;width:6%;height:53px;border:1px solid #999;}
	#boilerDiv .boilerview li.loas{border:1px solid #4169E1;background:#4169E1;}
	#boilerDiv .boilerview li.balloon{border:1px solid #DC143C;background:#DC143C;}
	#boilerDiv .boilerview li a .name{padding-right:50px;}
	#boilerDiv .boilerview li a .stxt{padding-right:50px;}
	#boilerDiv .boilerview li.ing{border:1px solid #C54026;background:#D2691E;}
	#boilerDiv .boilerview li.ing a span{color:#000;}
	#boilerDiv .boilerview li.ready{border:1px solid orange}
	#boilerDiv .boilerview li.ready{border:1px solid #343434;background:#545454;}
	#boilerDiv .boilerview li.ready a span{color:#bbb;}
	#boilerDiv .boilerview li.end{border:1px solid gray}
	#boilerDiv .boilerview li.hold{border:1px solid #006400;background:#2E8B57}
	#boilerDiv .boilerview li.hold a span{color:#000;}
	#boilerDiv .boilerview li.select{border:1px solid #7BA428;background:#ADFF2F}
	#boilerDiv .boilerview li.select a span{color:#000;}

	ul.packingview{}
	ul.packingview li{position:absolute;margin:0;width:10%;height:70px;border:1px solid #999;}
	#packingDiv .packingview li a{height:70px;background-size:auto 100%;
		background-position:right;
		background-image:url("../_Img/packing-ready.png");}
	#packingDiv .packingview li.ing a{background-image:url("../_Img/packing-ing.png");}
	#packingDiv .packingview li.end a{background-image:url("../_Img/packing-end.png");}
	#packingDiv .packingview li.select a{background-image:url("../_Img/packing-select.png");}
	#packingDiv .packingview li.hold a{background-image:url("../_Img/packing-hold.png");}
	#packingDiv .packingview li.sticky a{background:#F09262;}
	#packingDiv .packingview li.sticky a .name{width:170px;padding:15px 0 0 0;color:#000;font-size:30px;letter-spacing:-1px;}
	#packingDiv .packingview li.sticky a .stxt{color:#F09262;}
	#packingDiv .packingview li a span{text-align:left;margin-left:20px;}
	#packingDiv .packingview li a .name{font-size:18px;}
	#packingDiv .packingview li a .stxt{font-size:13px;}

	#packingDiv .packingview li.ing{border:1px solid #C54026;background:#D2691E;}
	#packingDiv .packingview li.ing a span{color:#000;}
	#packingDiv .packingview li.ready{border:1px solid orange}
	#packingDiv .packingview li.ready{border:1px solid #343434;background:#545454;}
	#packingDiv .packingview li.ready a span{color:#bbb;}
	#packingDiv .packingview li.end{border:1px solid gray}
	#packingDiv .packingview li.hold{border:1px solid #006400;background:#2E8B57}
	#packingDiv .packingview li.hold a span{color:#000;}
	#packingDiv .packingview li.select{border:1px solid #7BA428;background:#ADFF2F}
	#packingDiv .packingview li.select a span{color:#000;}


	.steppacking {font-size:30px;color:#fff;float:right;margin:-20px 20px 0 0;}
</style>

<input type="hidden" name="decocstat">
<input type="hidden" name="decoctionprocess" value="<?=$decoctionprocess?>">

<!-- <div class="info_dtl" style="position:absolute;margin-top:-20px;margin-bottom:5px;">
	<dl class="count">
		<dt class=""><?=$txtdt["9012"]?></dt> 탕전기선택
		<dt class="reload"><?=$txtdt["pouch"]?></dt> 파우치
		<dd><em class="st_num" id="pouchboxcode"></em></dd>
	</dl>
</div> -->

<!-- 파우치 아래부분 -->
<div class="contents nobor" id="decocproc" data-stepbp="">
	<div class="stats-time">
		<div id="boilerDiv" class="decoleft"></div>
		<div id="packingDiv" class="decoleft"></div>

		<div id="decocRightDiv" class="decoright" >
			<div id="odRequest" class="derequest"></div>
			<div class="method">
				<ul>
					<li>
						<dl>
							<dt><?=$txtdt["titdecoction"]?></dt> <!--탕전법-->
							<dd id="decoctype"></dd>
						</dl>
						<dl>
							<dt><?=$txtdt["spdecoction"]?></dt> <!--특수탕전-->
							<dd id="special"></dd>
						</dl>
						<dl>
							<dt><?=$txtdt["pouchtype"]?></dt> <!--파우치종류-->
							<dd>
								<span class="pouch" id='packtype'><dfn class="img"></dfn></span>
							</dd>
						</dl>
						<!-- <dl>
							<dt><?=$txtdt["sweet"]?></dt> 감미제
							<dd id="sugarDiv"></dd>
						</dl> -->
					</li>

					<li>
						<dl>
							<dt><?=$txtdt["timer"]?></dt> <!--시간-->
							<dd id="dcTime"></dd>
						</dl>
						<dl>
							<dt><?=$txtdt["watercapa"]?></dt> <!--투입물용량-->
							<dd>
								<span id="dcWater"></span>
								<span><small>mL</small></span>
							</dd>

						</dl>

						<dl id="alcoholDiv">
							<dt id="dcAlcoholName">청주</dt> <!--투입물용량-->
							<dd>
								<span id="dcAlcohol"></span>
								<span><small>mL</small></span>
							</dd>
						</dl>

						<dl>
							<dt><?=$txtdt["cntpouch"]?></dt> <!--파우치수-->
							<dd>
								<span id="odPackcnt"></span><span><?=$txtdt["pack"]?></span> /
								<span id="odPackcapa"></span>ml
								
							</dd>
						</dl>
						<!-- <dl>
							<dt></dt> 파우치수
							<dd>
								(<span id="total"></span>ml)
							</dd>
						</dl> -->
					</li>
				</ul>
			</div>

			<div class="progress">
				<div class="info">
				</div>
				<div class="poutchinfo">
					<dl class="medigroup">
						<dt id="txtfront"><?=$txtdt['pouch']?></dt>
						<dd id="imgfront">
						</dd>
					</dl>
				</div>
			</div>


		</div>
	</div>
	


</div>

<script>
	function gostepboiler()
	{
		var no=$("#step_info").find("li.on").index();
		console.log("gostepboiler  no = " + no);
		if(no==3)
		{
			showboiler();
		}
	}
	callapi('GET','decoction','decoctionmain',"<?=$apiData?>");
</script>
