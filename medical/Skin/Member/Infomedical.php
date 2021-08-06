<?php
	$root="../..";
	include_once $root."/_common.php";
?>

	<div class="sub__item" id="medicalinfoDiv">
		<div class="table__tit">의료기관정보</div>
		<div class="table table--details">
			<table>
				<colgroup>
					<col>
					<col>
				</colgroup>
				<tbody>
					<tr>
						<th>의료기관명</th>
						<td>
							<div class="col-auto col-auto--fst d-flex">
								<div class="inp inp-input email-num inp-radius">
									<input type="text" name="miName" class="ajaxdata">
								</div>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<th>사업자번호</th>
						<td>
							<div class="col-auto col-auto--fst d-flex">
								<div class="inp inp-input email-num inp-radius">
									<input type="text" class="ajaxdata" name="miBusinessno0" onfocus="this.select();" onchange="changePhoneNumber(event);">
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<th>대표자명</th>
						<td><div class="col-auto col-auto--fst d-flex"><div class="inp inp-input email-num inp-radius"><input type="text" name="miCeo" class="ajaxdata"></div></div></td>
					</tr>
					<tr>
						<th>사업장소재지</th>
						<td>							
							<div class="form__col col-required">
								<div class="col-group d-flex">
									<div class="col-auto col-auto--fst">
										<div class="inp inp-input inp-radius" style="width:400px;">
											<input type="text" placeholder="우편번호 입력" name="miZipcode" class="ajaxdata" readonly />
										</div>
									</div>
									<div class="col-auto col-auto--lst">
										<div class="btnBox">
											<a href="javascript:getzip('miZipcode','miAddress');" class="d-flex btn border-blue color-blue radius">주소검색</a>
											<p class="mg5t"></p>
										</div>
									</div>
								</div>
								<div class="col-group d-flex">
									<div class="inp inp-input address inp-radius" style="width: 500px;">
										<input type="text" placeholder="읍, 면, 동 입력" name="miAddress" class="ajaxdata" readonly>
									</div>
								</div>
								<div class="col-group d-flex">
									<div class="inp inp-input address inp-radius" style="width: 500px;">
										<input type="text" placeholder="나머지 주소(번지) 입력" name="miAddress1" class="ajaxdata">
									</div>
								</div>
							</div>							
						</td>
					</tr>
					<tr>
						<th>전화번호</th>
						<td>
							<div class="col-auto col-auto--fst d-flex">
								<div class="inp inp-input phone-num inp-radius">
									<input type="text" class="ajaxdata" name="miPhone0" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);" >
								</div>
								<span class="hyphen">-</span>
								<div class="inp inp-input phone-num inp-radius">
									<input type="text" class="ajaxdata" name="miPhone1" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);">
								</div>
								<span class="hyphen">-</span>
								<div class="inp inp-input phone-num inp-radius">
									<input type="text" class="ajaxdata" name="miPhone2" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);">
								</div>
							</div>						
						</td>
					</tr>
					<tr>
						<th>팩스번호</th>
						<td>
							<div class="col-auto col-auto--fst d-flex">
								<div class="inp inp-input phone-num inp-radius">
									<input type="text" class="ajaxdata" name="miFax0" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);" >
								</div>
								<span class="hyphen">-</span>
								<div class="inp inp-input phone-num inp-radius">
									<input type="text" class="ajaxdata" name="miFax1" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);">
								</div>
								<span class="hyphen">-</span>
								<div class="inp inp-input phone-num inp-radius">
									<input type="text" class="ajaxdata" name="miFax2" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);">
								</div>
							</div>						
						</td>
					</tr>
					<tr>
						<th>세금계산서</th>
						<td>
							<div class="col-auto col-auto--fst d-flex">
								<div class="inp inp-input email-num inp-radius">
									<input type="text" class="ajaxdata" name="miEmail0" style="width:149px;" onfocus="this.select();" onchange="changeID(event, false);">
								</div>
								<span class="hyphen">@</span>
								<div class="inp inp-input email-num inp-radius">
									<input type="text" class="ajaxdata" name="miEmail1"  style="width:150px;" onfocus="this.select();" onchange="changeID(event, false);">
								</div>
							</div>						
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="btnBox d-flex">
			<a href="javascript:;" class="d-flex btn btn--small border-rightGray color-gray" onclick="addmedicalinfo();">정보 수정</a>
		</div>
	</div>
