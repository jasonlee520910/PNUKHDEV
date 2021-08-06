<style>
	#patbl tbody tr td input{width:99%;border:1px solid #ccc;padding:3px;height:25px;}
</style>
<table id="patbl">
	<colgroup>
		<col width="15%">
		<col width="35%">
		<col width="15%">
		<col width="35%">
	</colgroup>
	<tbody>
		<tr>
			<th>차트번호</th>
			<td id="meChartno"></td>
			<th>환자명</th>
			<td id="meName"></td>
		</tr>
		<tr>
			<th>성별</th>
			<td id="meSexTxt"></td>
			<th>생년월일</th>
			<td id="meBirthDay"></td>
		</tr>
		<tr>
			<th>연락처</th>
			<td id="mePhone"></td>
			<th>휴대전화</th>
			<td id="meMobile"></td>
		</tr>
		<tr>
			<th>주소</th>
			<td colspan="3" id="meAddress"></td>
		</tr>
		<tr>
			<th>최근처방정보</th>
			<td colspan="3" id="lastScript"></td>
		</tr>
		<tr>
			<th>기타</th>
			<td colspan="3" id="meMemo"></td>
		</tr>
		<tr>
			<th>처방메모</th>
			<td colspan="3">
				<div class="inp inp-input inp-radius">
					<textarea class="text-area ajaxdata" name="patientmemo" title="" placeholder="처방메모를입력해주세요." style="width:800px;padding:10px;"></textarea>	
				</div>
			</td>
		</tr>
	</tbody>
</table>
<input type="hidden" name="paZipcode" value="">
<input type="hidden" name="paAddr" value="">
<input type="hidden" name="paUserID" class="ajaxdata" value="">
