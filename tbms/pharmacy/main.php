<?php
	$root="..";
	include_once $root."/_common.php";
	$staffID=$_GET["code"];
	$apiData="code=".$staffID;
?>
<style>
	.pharmacydiv{background:#333;width:1300px;margin:100px auto;overflow:hidden;padding:20px;}
	.pharmacydiv h1{color:#fafafa;margin:10px;font-size:30px;}
	.pharmacydiv ul, .pharmacydiv dl{width:50%;float:left;color:#fafafa;padding:20px 0;}
	.pharmacydiv ul li{padding:20px 0;}
	.pharmacydiv ul li a{color:#fff;}
	.pharmacydiv ul li input{width:95%;height:90px;font-size:35px;font-weight:bold;color:#fff;padding:15px;border:none;background:#555;}
	::placeholder{color:#999;}
	.pharmacydiv ul li.btn{text-align:center;padding:20px;}
	.pharmacydiv ul li.btn button{background:#ccc;font-size:40px;font-weight:bold;margin:40px auto;padding:20px;border-radius:10px;cursor:pointer;margin:0 30px;}
	.pharmacydiv dl dt, .pharmacydiv dl dd{border:1px solid #fff;padding:10px 0;}
	.pharmacydiv dl dt{text-align:center;font-size:25px;font-weight:bold;padding:20px;}
	.pharmacydiv dl dd{padding:0;}
	.pharmacydiv dl dd .mntbl{width:100%;border:none;}
	.pharmacydiv dl dd .mntbl tr th, .pharmacydiv dl dd .mntbl tr td{border:none;border-right:1px solid #ccc;border-bottom:1px solid #ccc;padding:20px;font-size:15px;}
	#tagCode{padding:3px 20px;}
	#tagCode .tagul{margin:0;padding:0;}
	#tagCode .tagul li{margin:0;padding:10px;border:none;}
	#tagCode .tagul li i{margin-left:10px;}
	#tagCode .tagul li i.on{color:yellow;}
</style>
		<div class="pharmacydiv">
			<h1>수동조제확인</h1>
			<ul>
				<li><input type="hidden" name="staffidscan" value="<?=$staffID;?>"><input type="hidden" name="odMatype" value=""><!-- <a href="javascript:inscode('orderscan','ODD1910024075605703')">ODD1910024075605703</a> --><input type="text" name="orderscan" onkeyup="if(event.keyCode==13)odcodeenter()" placeholder="작업지시서 스캔" value=""></li>
				<li><!-- <a href="javascript:inscode('tagscan','MDT0000030001')">MDT0000030001</a> <a href="javascript:inscode('tagscan','MDT0000050006')">MDT0000050006</a>  --><input type="text" name="tagscan" placeholder="작업태그 스캔" onkeypress="if(event.keyCode==13)focusscan();"></li>
				<li class="btn"><button onclick="pharmacyrescan()">다시스캔</button><button onclick="pharmacyconfirm()">수동조제완료</button></li>
			</ul>
			<dl>
				<dt>조제정보</dt>
				<dd>
					<table class="mntbl">
					<col style="width:30%;"><col style="width:70%;">
					<tr>
						<th>주문번호</th>
						<td id="odCode"> - </td>
					</tr>
					<tr>
						<th>조제태그</th>
						<td id="tagCode"> - </td>
					</tr>
					<tr>
						<th>처방명</th>
						<td id="odTitle"> - </td>
					</tr>
					<tr>
						<th>주문자명</th>
						<td id="odName"> - </td>
					</tr>
					<tr>
						<th>약미</th>
						<td id="mediCount"> - </td>
					</tr>
					<tr>
						<th>조제사</th>
						<td id="makingStaff"></td>
					</tr>
					</table>
					<div></div>
				</dd>
			</dl>
		</div>
			


<?php include_once $root."/_Inc/tail.php"; ?>
<script>
	$("input").on("blur",function(){
		//var chk=$("input[name=orderscan]").val();
		//if(chk!=undefined){
		//	console.log("input blur focusscan");
		//	focusscan();
		//}
	});

	//console.log("MAIN focusscan");
	//focusscan();
	callapi('GET','common','getstaff',"<?=$apiData?>");
</script>
