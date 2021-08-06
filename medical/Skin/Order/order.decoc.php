<table>
	<colgroup>
		<col>
		<col>
		<col>
		<col>
	</colgroup>
	<tbody>
		<tr>
			<th>팩수</th>
			<td>
				<div class="inp inp-select inp-radius">
					<select name="packCnt" id="packCnt" onclick="resetCnt();">
					<?php for($i=5;$i<=200;$i++){?>
						<option value="<?=$i?>"><?=$i?>팩</option>
					<?php }?>
					</select>
				</div>
			</td>
			<th>팩용량</th>
			<td>
				<div class="inp inp-select inp-radius">
					<select name="packCapa" id="packCapa">
					<?php $arr=array("40","50","60","70","80","90","100","110","120","130","140","150");?>
					<?php for($i=0;$i<count($arr);$i++){?>
						<option value="<?=$arr[$i]?>"><?=$arr[$i]?>ml</option>
					<?php }?>
					</select>
				</div>
			</td>
		</tr>
		<tr>
			<th>특수탕전</th>
			<td>
				<div class="inp inp-select inp-radius">
					<select name="specialDecoc" id="specialDecoc" onchange="resetCnt();">
					</select>
				</div>
			</td>
			<th>감미제</th>
			<td>
				<div class="inp inp-select inp-radius">
					<select name="sugar" id="sugar" onchange="resetCnt();">
<!-- 					<?php $arr=array("올리고당5g","올리고당10g","올리고당15g","자하거10ml","자하거20ml","자하거30ml");?>
					<option value="">없음</option>
					<?php for($i=0;$i<count($arr);$i++){?>
						<option value="<?=$arr[$i]?>"><?=$arr[$i]?>ml</option>
					<?php }?> -->
					</select>
				</div>
			</td>
		</tr>
		<script>
			function viewpack(id){
				switch(id){
					case "medibox":
						$("#medibox").toggle();
						$("#packtype").fadeOut(10);
						break;
					case "packtype":
						$("#packtype").toggle();
						$("#medibox").fadeOut(10);
						break;
				}
			}
		</script>
		<tr>
			<th class="vertical">박스</th>
			<td class="tableImg">
				<div class="custom-img-select">
				<button class="custom-img-selected-item" onclick="viewpack('medibox')" id="mediboxbtn">
					<img src="https://via.placeholder.com/100x100" alt="" class="selectedImg">
				</button>
					<input type="hidden" name="odmedibox" class="ajaxdata" value="">
					<input type="hidden" name="odmediboxprice" class="ajaxdata" value="">
					<input type="hidden" name="odmediboxtitle" class="ajaxdata" value="">
					<input type="hidden" name="odmediboximg" class="ajaxdata" value="">
					<input type="hidden" name="odmediboxcapa" class="ajaxdata" value="">
					<ul class="custom-img-select-options" id="medibox">
					</ul>
				</div>
			</td>
			<th class="vertical">파우치</th>
			<td class="tableImg">
				<div class="custom-img-select">
					<button class="custom-img-selected-item" onclick="viewpack('packtype')" id="packtypebtn">
						<img src="https://via.placeholder.com/100x100" alt="" class="selectedImg">
					</button>
					<input type="hidden" name="odpacktypetitle" class="ajaxdata" value="">
					<input type="hidden" name="odpacktypeprice" class="ajaxdata" value="">
					<input type="hidden" name="odpacktype" class="ajaxdata" value="">
					<input type="hidden" name="odpacktypeimg" class="ajaxdata" value="">
					<ul class="custom-img-select-options" id="packtype">
					</ul>
				</div>
			</td>
		</tr>
	</tbody>
</table>
<script>
	$("select[name=packCnt]").val(45);
	$("select[name=packCapa]").val(120);
</script>
