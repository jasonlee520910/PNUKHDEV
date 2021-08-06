<?php
	$root="..";
	include_once $root."/_common.php";
	$code=$_GET["code"];
	$apiData="code=".$code."&plType=".$_COOKIE["ck_pilltype"];

?>
<style>
	.pillleft {float:left;width:43%;min-height:100px;text-align: left;padding:0;/*background:yellow;*/}
	.pillcenter {float:left;width:27%;min-height:100px;text-align: left;padding:0;/*background:green;*/}
	.pillright {float:left;width:30%;min-height:100px;text-align: left;padding:0;/*background:pink;*/}

	.pillcapa {display:block;background-color:black;font-size:20px;width:auto;height:150px;color:#f2c261; vertical-align:middle;overflow-y:auto;padding:10px;}

	#pilltypeDiv{float:left;width:100%;min-height:700px;/*overflow-y:scroll;*/}
	#pilltypeDiv dl{float:left;width:45%;margin:0 0 20px 1%;overflow:hidden;border:1px solid #aaa;}
	#pilltypeDiv dl dt, #pilltypeDiv dl dd{width:100%;color:#fff;font-size:18px;overflow:hidden;padding:10px;margin:0;}
	#pilltypeDiv dl dt{height:50px}
	#pilltypeDiv dl dd{width:auto;padding:0;border:1px solid #aaa;text-align:center;height:55px;}
	#pilltypeDiv dl dd.img{height:150px;}
	#pilltypeDiv dl.componentok {border: 1px solid green;background:green;}


	ul.machinview{}
	ul.machinview li{position:absolute;width:6%;height:58px;font-size:15px;}
	#machinDiv .machinview li a span {width:100%;display:block;padding:0;}
	#machinDiv .machinview li a .name{text-align:center;height:30px;background:white;}
	#machinDiv .machinview li a .stxt{text-align:center;height:22px;background:#999;}
	#machinDiv .machinview li.one a span.name{background:#F4D03F;}
	#machinDiv .machinview li.one a span.stxt{background:#FCF3CF;}
	#machinDiv .machinview li.two a span.name{background:#5DADE2;}
	#machinDiv .machinview li.two a span.stxt{background:#D6EAF8;}
	#machinDiv .machinview li.three a span.name{background:#AF7AC5;}
	#machinDiv .machinview li.three a span.stxt{background:#EBDEF0;}

	#machinDiv .machinview li.machineoneok {border: 3px solid #CB4335;}
	#machinDiv .machinview li.machinetwook {border: 3px solid #1F618D;}
	#machinDiv .machinview li.machinethreeok {border: 3px solid #6C3483;}

	#plcapaName{float:left;width:30%;;height:70px;font-size:40px;text-align:center;color:#fff;line-height:70px;border:1px solid #999;}
	#plcapa{float:left;width:69%;;height:70px;font-size:40px;text-align:right;color:#fff;font-weight:bold;line-height:70px;padding-right:10px;border:1px solid #999;}
	#ploutcapaName{float:left;width:30%;;height:70px;font-size:40px;text-align:center;color:#fff;line-height:70px;border:1px solid #999;}
	#ploutcapa{float:left;width:69%;;height:70px;font-size:40px;text-align:right;color:#fff;font-weight:bold;line-height:70px;padding-right:10px;border:1px solid #999;}
	
	ul.medicineview{}
	ul.medicineview li{position:absolute;width:10%;height:101px;font-size:15px;margin:0;}
	#medicineDiv .medicineview li a span {width:100%;display:block;padding:0;}
	#medicineDiv .medicineview li a .name{text-align:center;height:31px;background:#7DCEA0;}
	#medicineDiv .medicineview li a .capa{text-align:center;height:32px;background:#D4EFDF;}
	#medicineDiv .medicineview li a .stxt{text-align:center;height:32px;background:#D4EFDF;}
	#medicineDiv .medicineview li.medicineok {border: 3px solid #138D75;}

	#incapa {width:430px;height:120px;font-size:70px;color:#fff;font-weight:bold;text-align:center;}
	#outcapa {width:430px;height:120px;font-size:70px;color:yellow;font-weight:bold;text-align:center;}
	
</style>

<div class="content">
	<div class="pillleft" id="machinDiv" data-totcnt="0">
		장비리스트
	</div>
	<div class="pillcenter" id="medicineDiv" data-totcnt="0">
		약재리스트
	</div>
	<div class="pillright">
		<div id="plcapaName">
			투입량
		</div>
		<div id="plcapa">			
		</div>
		<div id="ploutcapaName">
			산출량
		</div>
		<div id="ploutcapa">
		</div>
		<div class="pillcapa">
			<input type="hidden" id="originincapa" name="originincapa" value="" />
			<input type="hidden" id="originoutcapa" name="originoutcapa" value="" />
			<input type="text" id="incapa" name="incapa" value="" maxlength="10" onfocus="this.select();" onblur="setOrderpill();" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" onclick="pillcapaok();" />
			<input type="text" id="outcapa" name="outcapa" value="" maxlength="10" onfocus="this.select();" onblur="setOrderpill();" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" onclick="pillcapaok();" />
		</div>
		<div class="method" id="pilltypeDiv" data-totcnt="0">
		</div>
	</div>
</div>

<script>
	callapi('GET','pill','pillmain',"<?=$apiData?>");
</script>