<?php
	$root="..";
	include_once $root."/_common.php";
?>
	<input type="hidden" name="ChubcntDiv" value="">
    <div class="form_cont" style="padding-top:10px;">
		<div class="barcode" id="barcodeDiv" ></div>
		<div class="barcodetext" id="barcodeTextDiv"></div>
		<div>
			<table class="maintbl tbltitle">
				<tr>				
					<th id="odTitleDiv"></th>
				</tr>
			</table>
			<table class="maintbl">
				<col width="10%"><col width="10%"><col width="10%"><col width="20%">
				<col width="10%"><col width="15%"><col width="10%"><col width="15%">
				<tr>
					<th align="center"><?=$txtdt["orderno"]?></dt><!-- 주문번호 --></th>
					<td id="odCodeDiv" colspan="3"></td>
					<th align="center"><?=$txtdt["oddate"]?></dt><!-- 주문일 --></th>
					<td id="reDelidateDiv" colspan="3" align="center"></td>
				</tr>
				<tr>
					<th align="center"><?=$txtdt["chubcnt"]?></dt><!-- 첩수 --></th>
					<td id="odChubcnt" align="center"></td>
					<th align="center"><?=$txtdt["packtype"]?></dt><!-- 팩종류 --></th>
					<td id="odPacktype" align="center"></td>
					<th align="center"><?=$txtdt["packcapa"]?></dt><!-- 팩용량 --></th>
					<td id="odPackcapa" align="center"></td>
					<th align="center"><?=$txtdt["packcnt"]?></dt><!-- 팩수 --></th>
					<td id="odPackcnt" align="center"></td>
				</tr>
			</table>
			<table class="maintbl">
				<col width="10%"><col width="13%"><col width="10%"><col width="10%">
				<col width="10%"><col width="15%"><col width="10%"><col width="22%">
				<tr>
					<th align="center">환자명<?//=$txtdt["chubcnt"]?></dt><!-- 첩수 --></th>
					<td id="odName" align="center"></td>
					<th align="center">성별<?//=$txtdt["packtype"]?></dt><!-- 팩종류 --></th>
					<td id="odGender" align="center"></td>
					<th align="center">생년월일<?//=$txtdt["packcapa"]?></dt><!-- 팩용량 --></th>
					<td id="odBirth" align="center"></td>
					<th align="center">전화번호<?//=$txtdt["packcnt"]?></dt><!-- 팩수 --></th>
					<td id="odMobile" align="center"></td>
				</tr>
			</table>
			<!-- <table class="maintbl">
				<tr>
					<th colspan="2" align="center"><?=$txtdt["making"]?><!-- 조제 --></th>
					<!-- <td id="maStaffDiv" colspan="2" align="center" style="width:70px;"></td>
					<td id="maDateDiv" colspan="2" align="center" style="width:130px;"></td>
					<th colspan="2" align="center"><?=$txtdt["decoction"]?><!-- 탕전 --></th>
					<!-- <td id="dcStaffDiv" colspan="2" align="center"></td>
					<td id="dcDateDiv" colspan="2" align="center"></td>
				</tr>
				<tr>
					<th colspan="2" align="center"><?=$txtdt["marking"]?><!-- 마킹 --></th>
					<!-- <td id="mrStaffDiv" colspan="2" align="center"></td>
					<td id="mrDateDiv" colspan="2" align="center"></td>
					<th colspan="2" align="center"><?=$txtdt["release"]?><!-- 출고 --></th>
					<!-- <td id="reStaffDiv" colspan="2" align="center"></td>
					<td id="reDateDiv" colspan="2" align="center"></td>
				</tr>
				<tr>
					<th colspan="2" align="center"><?=$txtdt["9027"]?><!-- 한약사 확인 --></th>
					<!-- <td colspan="9" id="" align="center"></td>
				</tr>
			</table> -->  
			<table class="maintbl">
				</tr>
					<td style="padding:0;" id="medilist">
					</td>
				</tr>
			</table>
		</div>
		<!-- 탕전정보 -->
		<div class="form_dtl_pop">
			<table class="decoctbl" id="decocID">
				<col width="13%"><col width="20%"><col width="13%"><col width="21%"><col width="13%"><col width="20%">
				<tbody>
				<tr>
					<th><?=$txtdt["titdecoction"]?><!-- 탕전법 --></th>
					<td id="dcTitle"></td>
					<th><?=$txtdt["decoctime"]?><!-- 탕전시간 --></th>
					<td id="dcTime"></td>
					<th>탕전기번호<?//=$txtdt["decoctime"]?><!-- 탕전시간 --></th>
					<td id="dcBoiler"></td>
				</tr>
				<tr>
					<th><?=$txtdt["decocwater"]?><!-- 탕전물량 --></th>
					<td id="dcWater"></td>
					<th><?=$txtdt["spdecoction"]?><!-- 특수탕전 --></th>
					<td id="dcSpecial"></td>
					<th>포장기번호<?//=$txtdt["spdecoction"]?><!-- 특수탕전 --></th>
					<td id="dcPacking"></td>
				</tr>
				</tbody>
			</table>
			<table class="decoctbl" id="sfextID">
				<col width="20%"><col width="30%"><col width="20%"><col width="30%">
				<tbody>
				<tr>
					<th><?=$txtdt["9028"]?><!-- 제형 --></th>
					<td id="dcShape"></td>
					<th><?=$txtdt["9029"]?><!-- 결합제 --></th>
					<td id="dcBinders"></td>
				</tr>
				<tr>
					<th><?=$txtdt["9030"]?><!-- 분말도 --></th>
					<td id="dcFineness"></td>							
					<th><?=$txtdt["9002"]?><!-- 건조시간 --></th>
					<td id="dc_dry"></td>
				</tr>
				<tr>
					<th><?=$txtdt["9031"]?><!-- 제분손실 --></th>
					<td id="dcMillingloss"></td>
					<th><?=$txtdt["9032"]?><!-- 제환손실 --></th>
					<td id="dcLossjewan"></td>
				</tr>
				<tr>
					<th><?=$txtdt["9029"]?><!-- 결합제 --></th>
					<td id="dcBindersliang"></td>
					<th><?=$txtdt["9033"]?><!-- 완성량 --></th>
					<td id="dcCompleteliang"></td>
				</tr>
				</tbody>
			</table>
		</div>
		<!-- 탕전정보end -->
		<!-- 조제자 정보 -->
		<table class="maintbl signtbl">
			<col width="46%"><col width="21%"><col width="33%">
			<tr>
				<th><?=$txtdt["making"]?><!-- 조제 --></th>
				<td id="maStaff"></td>
				<td id="maDate"></td>
			</tr>
			<tr>							
				<td colspan="2"><?=$txtdt["9042"]?><!-- 확인내용 --></td>
				<td><?=$txtdt["9041"]?><!-- 서명 --></td>
			</tr>
			<tr>							
				<td colspan="2" class="lf"><?=$txtdt["9036"]?></td>
				<td id="makingsignDiv"></td>
			</tr>
			<tr>							
				<td colspan="3"></td>
			</tr>
			<tr>
				<th><?=$txtdt["decoction"]?><!-- 탕전 --></th>
				<td id="dcStaff" ></td>
				<td id="dcDate"></td>
			</tr>
			<tr>							
				<td colspan="2"><?=$txtdt["9042"]?><!-- 확인내용 --></td>
				<td><?=$txtdt["9041"]?><!-- 서명 --></td>
			</tr>
			<tr>							
				<td colspan="2" class="lf"><?=$txtdt["9038"]?></td>
				<td id="decoctionsignDiv"></td>
			</tr>
			<tr>							
				<td colspan="3"></td>
			</tr>
			<tr>
				<th><?=$txtdt["marking"]?><!-- 마킹 --></th>
				<td id="mrStaff"></td>
				<td id="mrDate"></td>
			</tr>
			<tr>							
				<td colspan="2"><?=$txtdt["9042"]?><!-- 확인내용 --></td>
				<td><?=$txtdt["9041"]?><!-- 서명 --></td>
			</tr>
			<tr>							
				<td colspan="2" class="lf"><?=$txtdt["9039"]?></td>
				<td id="markingsignDiv"></td>
			</tr>
			<tr>							
				<td colspan="3"></td>
			</tr>
			<tr>
				<th><?=$txtdt["9046"]?><!-- 포장 --></th>
				<td id="reStaff"></td>
				<td id="reDate"></td>
			</tr>
			<tr>							
				<td colspan="2"><?=$txtdt["9042"]?><!-- 확인내용 --></td>
				<td><?=$txtdt["9041"]?><!-- 서명 --></td>
			</tr>
			<tr>							
				<td colspan="2" class="lf"><?=$txtdt["9040"]?></td>
				<td id="releasesignDiv"></td>
			</tr>
			<tr>							
				<td colspan="3"></td>
			</tr>
			<tr>
				<th><?=$txtdt["9045"]?><!-- 출하 --></th>
				<td id="delitype"></td>
				<td id="confirmdate"></td>
			</tr>
			<tr>							
				<td colspan="3"></td>
			</tr>
			<tr>							
				<td colspan="2" align="center" style="width:70px;height:70px;"><?=$txtdt["9027"]?><!-- 한약사 확인 --></td>
				<td align="center" style="width:30px;" ></td>
			</tr>
		</table>

		<!-- 약재정보 start -->
		<table class="meditbl" id="mdtbl">	
				<col width="10%">
				<col width="15%">
				<col width="15%">
				<col width="15%">
				<col width="15%">
				<col width="15%">
				<col width="*">			
			<thead>
				<tr>
					<th><?=$txtdt["image"]?><!-- 이미지 --></th>
					<th><?=$txtdt["mediname"]?><!-- 약재명 --></th>
					<th><?=$txtdt["medicapa"]?><!-- 약재량 --></th>
					<th><?=$txtdt["origin"]?><!-- 원산지 --></th>
					<th><?=$txtdt["9049"]?><!-- 제조사 --></th>
					<th><?=$txtdt["9050"]?><!-- 재고입고일 --></th>
					<th><?=$txtdt["9051"]?><!-- 유통기한 --></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
		<!-- 약재정보 end -->



		<!-- 조제 /선전,일반,후하,별전 이미지 -->
		<div class="">
			<h2 class="tit"><?=$txtdt["making"]?><!-- 조제 --></h2>
			<div class="img" id="imgDiv" >
				<dl id="makingimglist"></dl>
			</div>
		</div>
		<div class="">
			<div class="ptdiv2">
				<h2 class="tit"><?=$txtdt["9046"]?><!--포장--></h2>
				<div class="img" id="release_deliboxDiv"></div>
			</div>
		</div>
		<!-- 출고 정보 end -->
		<!-- <div class="advice">
			<h2 class="tit"><?=$txtdt["advice"]?><!-- 복약지도 --></h2>
			<!-- <div class="addiv" id="odAdviceDiv"></div>
		</div> -->	
	</div>