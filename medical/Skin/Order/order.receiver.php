<div class="table__tit">받는 사람</div>
<div class="table__radio">
	<div class="inp-radioBox d-flex" id="receivetype">
<!-- 		<div class="inp inp-radio">
			<label for="q0" class="d-flex">
				<input type="radio" name="receivertype" id="q0" class="blind" value="patient" onclick="getReceiverInfo()">
				<span></span>환자
			</label>
		</div>
		<div class="inp inp-radio">
			<label for="q1" class="d-flex">
				<input type="radio" name="receivertype" id="q1" class="blind" value="medical" onclick="getReceiverInfo()">
				<span></span>의료기관
			</label>
		</div>
		<div class="inp inp-radio">
			<label for="q2" class="d-flex">
				<input type="radio" name="receivertype" id="q2" class="blind" value="" onclick="getReceiverInfo()" checked>
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
				<th>수신인</th>
				<td>
					<div class="form__row">
						<div class="inp inp-input">
							<input type="text" name="receiveName" class="receive" placeholder="수신인 입력" onfocus='this.select();'>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<th>연락처</th>
				<td>
					<div class="col-auto col-auto--fst d-flex phone-row">
						<div class="inp inp-input inp-radius">
							<input type="text" name="receivePhone0" class="receive" maxlength="3" onchange="changePhoneNumber(event);" onfocus='this.select();' >
						</div>
						<span class="hyphen">-</span>
						<div class="inp inp-input inp-radius">
							<input type="text" name="receivePhone1" class="receive" maxlength="4" onchange="changePhoneNumber(event);" onfocus='this.select();'>
						</div>
						<span class="hyphen">-</span>
						<div class="inp inp-input inp-radius">
							<input type="text" name="receivePhone2" class="receive" maxlength="4" onchange="changePhoneNumber(event);" onfocus='this.select();'>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<th>휴대전화</th>
				<td>
					<div class="col-auto col-auto--fst d-flex phone-row">
						<div class="inp inp-input inp-radius">
							<input type="text" name="receiveMobile0" class="receive"  maxlength="3" onchange="changePhoneNumber(event);" onfocus='this.select();'>
						</div>
						<span class="hyphen">-</span>
						<div class="inp inp-input inp-radius">
							<input type="text" name="receiveMobile1" class="receive" maxlength="4" onchange="changePhoneNumber(event);" onfocus='this.select();'>
						</div>
						<span class="hyphen">-</span>
						<div class="inp inp-input inp-radius">
							<input type="text" name="receiveMobile2" class="receive" maxlength="4" onchange="changePhoneNumber(event);" onfocus='this.select();'>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<th rowspan="3" class="vertical">주소</th>
				<td>
					<div class="col-group d-flex address-row">
						<div class="col-auto col-auto--fst">
							<div class="inp inp-input inp-radius">
								<input type="text" placeholder="우편번호 입력" name="receiveZipcode" class="receive" maxlength="6" readonly>
							</div>
						</div>
						<div class="col-auto col-auto--lst">
							<div class="btnBox">
								<a href="javascript:getzip('receiveZipcode','receiveAddress');" class="d-flex btn border-gray color-gray ">주소검색</a>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="form__row">
						<div class="inp inp-input">
							<input type="text" placeholder="읍,면,동 입력" name="receiveAddress" class="receive" readonly>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="form__row">
						<div class="inp inp-input">
							<input type="text" placeholder="나머지 주소(번지) 입력" name="receiveAddressDesc" class="receive">
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<th>배송메시지</th>
				<td>
					<div class="form__row">
						<div class="inp inp-input">
							<input type="text" placeholder="내용 입력" name="receiveComment" class="">
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
