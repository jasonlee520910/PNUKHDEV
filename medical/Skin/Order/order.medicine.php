<style>
	/* 약재목록 drag 선택 */
	#meditbl .dragRow td{background-color: #E4E7E6;}
</style>
<table id="meditbl">
	<colgroup>
		<col width="50px">
		<col width="90px">
		<col width="250px">
		<col>
		<col>
		<col>
		<col>
		<col>
	</colgroup>
	<thead>
		<tr class="nodrop nodrag">
			<th>
				<div class="inp-checkBox">
					<div class="inp inp-check">
						<label for="d0" class="d-flex">
							<input type="checkbox" name="allchk" id="d0" class="blind" onclick="allchk()">
							<span></span>
						</label>
					</div>
				</div>
			</th>
			<th>번호</th>
			<th>상품명</th>			
			<th>원산지</th>
			<th>1첩량</th>
			<th>총용량</th>
			<th>약재비</th>
			<th>옵션</th>
		</tr>
	</thead>
	<tbody>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4">
				<div class="btnBox">
					<a href="javascript:clearchk();" class="d-flex btn border-rightGray color-gray">선택삭제</a>
				</div>
			</td>
			<td class="" id="totChubcapa">0<span>g</span>
			</td>
			<td class="" id="totCapa">0<span>g</span>
			</td>
			<td class="" id="totAmount">0<span>원</span>
			</td>
		</tr>
	</tfoot>
</table>
