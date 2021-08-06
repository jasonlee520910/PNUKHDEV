<div class="table__tit">보내는 사람</div>
<div class="table__radio">
	<div class="inp-radioBox d-flex" id="resendtype">
<!-- 		<div class="inp inp-radio">
			<label for="r0" class="d-flex">
				<input type="radio" name="sendertype" id="r0" class="blind" value="medical" onclick="getSenderInfo()"  >
				<span></span>의료기관
			</label>
		</div>
		<div class="inp inp-radio">
			<label for="r1" class="d-flex">
				<input type="radio" name="sendertype" id="r1" class="blind" value="factory" onclick="getSenderInfo()">
				<span></span>탕전원
			</label>
		</div>
		<div class="inp inp-radio">
			<label for="r2" class="d-flex">
				<input type="radio" name="sendertype" id="r2" class="blind" value="" onclick="getSenderInfo()" checked>
				<span></span>새로입력
			</label>
		</div> -->
	</div>
</div>
<div class="table table--details">
	<table>
		<colgroup>
			<col>
			<col>
		</colgroup>
		<tbody>
			<tr>
				<th>발신인</th>
				<td>
					<div class="form__row">
						<div class="inp inp-input">
							<input type="text" name="sendName" class="sender" placeholder="발신인 입력" onfocus='this.select();'>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<th>연락처</th>
				<td>
					<div class="col-auto col-auto--fst d-flex phone-row">
						<div class="inp inp-input inp-radius">
							<input type="text" name="sendPhone0" class="sender" maxlength="3" onchange="changePhoneNumber(event);" onfocus='this.select();'>
						</div>
						<span class="hyphen">-</span>
						<div class="inp inp-input inp-radius">
							<input type="text" name="sendPhone1" class="sender" maxlength="4" onchange="changePhoneNumber(event);" onfocus='this.select();'>
						</div>
						<span class="hyphen">-</span>
						<div class="inp inp-input inp-radius">
							<input type="text" name="sendPhone2" class="sender" maxlength="4" onchange="changePhoneNumber(event);" onfocus='this.select();'>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<th>휴대전화</th>
				<td>
					<div class="col-auto col-auto--fst d-flex phone-row">
						<div class="inp inp-input inp-radius">
							<input type="text" name="sendMobile0" class="sender" maxlength="3" onchange="changePhoneNumber(event);" onfocus='this.select();'>
						</div>
						<span class="hyphen">-</span>
						<div class="inp inp-input inp-radius">
							<input type="text" name="sendMobile1" class="sender" maxlength="4" onchange="changePhoneNumber(event);" onfocus='this.select();'>
						</div>
						<span class="hyphen">-</span>
						<div class="inp inp-input inp-radius">
							<input type="text" name="sendMobile2" class="sender" maxlength="4" onchange="changePhoneNumber(event);" onfocus='this.select();'>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<th rowspan="4" class="vertical">주소</th>
				<td>
					<div class="col-group d-flex address-row">
						<div class="col-auto col-auto--fst">
							<div class="inp inp-input inp-radius">
								<input type="text" placeholder="우편번호 입력" name="sendZipcode" class="sender" maxlength="6" readonly>
							</div>
						</div>
						<div class="col-auto col-auto--lst">
							<div class="btnBox">
								<a href="javascript:getzip('sendZipcode','sendAddress');" class="d-flex btn border-gray color-gray ">주소검색</a>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="form__row">
						<div class="inp inp-input">
							<input type="text" placeholder="읍,면,동 입력" name="sendAddress" class="sender" readonly>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="form__row">
						<div class="inp inp-input">
							<input type="text" placeholder="나머지 주소(번지) 입력" name="sendAddressDesc" class="sender">
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
			</tr>
		</tbody>
	</table>
</div>
