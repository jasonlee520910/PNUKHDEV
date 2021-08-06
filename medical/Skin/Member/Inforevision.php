<?php
	$root="../..";
	include_once $root."/_common.php";
?>
<!-- 내정보 수정 화면 -->
<div class="table__tit">내 정보 수정</div>
<div class="table table--details">
	<table id="tbllist">
		  <colgroup>
			  <col width="15%">
			  <col width="35%">
			  <col width="15%">
			  <col width="35%">
		  </colgroup>
		<tbody>
		   <tr>
				<th>이름</th>
				<td colspan='3'><div class="col-auto col-auto--fst d-flex"><div class="inp inp-input email-num inp-radius"><input type="text" name="stName" class="ajaxdata"></div></div></td>
			</tr>
			<!-- <tr>
				<th>아이디</th>
				<td>
					<div class="col-auto col-auto--fst d-flex">
						<div class="inp inp-input email-num inp-radius">
						<input type="text" name="stUserId" class="ajaxdata" readonly>
						</div>
					</div>
					<!-- <input type="hidden" id="idchk" name="idchk" value="0">		 -->
					<!-- <div class="inp-error" id="idchktxt">5~20자의 영문 소문자, 숫자만 사용해주세요.</div> -->
                <!-- </td>
			</tr>  -->
			<tr>
				<th>휴대전화</th>
				<td colspan='3'>
					<div class="col-auto col-auto--fst d-flex">
						<div class="inp inp-input phone-num inp-radius">
							<input type="text" class="ajaxdata" name="stMobile0" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);">
						</div>
						<span class="hyphen">-</span>
						<div class="inp inp-input phone-num inp-radius">
							<input type="text" class="ajaxdata" name="stMobile1" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);">
						</div>
						<span class="hyphen">-</span>
						<div class="inp inp-input phone-num inp-radius">
							<input type="text" class="ajaxdata" name="stMobile2" maxlength="4" onfocus="this.select();" onchange="changePhoneNumber(event);">
						</div>
					</div>				
				</td>
			</tr>
			<tr>
				<th>이메일</th>
				<td>
					<div class="col-auto col-auto--fst d-flex" >
						<div class="inp inp-input email-num inp-radius">
							<input type="text" class="ajaxdata" name="stEmail0" style="width:149px;" onfocus="this.select();" onchange="changeID(event, false);" >
						</div>
						<span class="hyphen">@</span>
						<div class="inp inp-input email-num inp-radius"  style="width:100px;">
							<input type="text" class="ajaxdata" name="stEmail1"  style="width:100px;" onfocus="this.select();" onchange="changeID(event, false);">
						</div>
					</div>	
				</td>
				<th>메일수신여부</th>
				<td>
					<div class="col-auto col-auto--fst d-flex">
						
							<div class="inp inp-radio" >
								<label for="meIsemailY" class="d-flex" >
									<input type="radio" name="meIsemail" id="meIsemailY" class="blind" value="Y">
									<span></span>Yes
								</label>
							</div>

						  <div class="inp inp-radio">
								<label for="meIsemailN" class="d-flex">
									<input type="radio" name="meIsemail" id="meIsemailN" class="blind" value="N">
									<span></span>No
								</label>
							</div>							
							
					</div>	
				</td>
			</tr>
			<tr>
				<th>면허번호</th>
				<td colspan='3'><div class="col-auto col-auto--fst d-flex"><div class="inp inp-input email-num inp-radius"><input type="text" name="licenseno" class="ajaxdata"></div></div></td>
			</tr>
		</tbody>
	</table>

</div>
	<div class="btnBox d-flex">
		<a href="javascript:;" class="d-flex btn btn--small border-rightGray color-gray" onclick="addmyinfo();">내정보 수정</a>
	</div>
</div>
                    
               
