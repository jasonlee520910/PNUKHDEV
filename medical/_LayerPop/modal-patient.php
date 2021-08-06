<?php
	$root = "..";
	include_once $root."/_common.php";
?>


<style>
	.modal{position:absolute;top:10px;}
</style>

<!-- modal 신규등록-->
<div class="modal" id="modal-patient">
    <div class="modal__bg"></div>
    <div class="modal__content">
        <button class="modal-closeBtn" onclick="moremove('modal-patient');"></button>
        <div class="prescribe__new-register">
            <div class="modal__head"><?php if($_GET["seq"]){echo "정보수정";}else{echo "신규등록";}?></div>
			<input type="hidden" name="seq" class="ajaxdata" value="<?=$_GET["seq"]?>">
			<input type="hidden" name="ck_meUserId" class="ajaxdata" value="<?=$_COOKIE["ck_meUserId"]?>">
            <div class="modal__body">
                <form action="">
                    <div class="form">
                        <div class="form__row tf__row d-flex baseline">
                            <div class="form__col form__title">차트번호</div>
                            <div class="form__col col-required">
                                <div class="inp inp-input inp-radius">
                                    <input type="text" class="ajaxnec ajaxdata" placeholder="차트번호" name="meChartno" >
                                </div>
                            </div>
                        </div>
                        <div class="form__row tf__row d-flex baseline">
                            <div class="form__col form__title">환자명</div>
                            <div class="form__col col-required">
                                <div class="inp inp-input inp-radius">
                                    <input type="text" class="ajaxnec ajaxdata" placeholder="이름" name="meName">
                                </div>
                            </div>
                        </div>
                        <div class="form__row tf__row d-flex baseline">
                            <div class="form__col form__title">성별</div>
                            <div class="form__col col-required">
                                <div class="inp-radioBox d-flex col-sb">
                                    <div class="inp inp-radio--type2 inp-radius">
                                        <label for="r0">
                                            <input type="radio" name="meSex" id="r0" class="blind" value="male">
                                            <span>남자</span>
                                        </label>
                                    </div>
                                    <div class="inp inp-radio--type2 inp-radius">
                                        <label for="r1">
                                            <input type="radio" name="meSex" id="r1" class="blind" value="female">
                                            <span>여자</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form__row tf__row d-flex baseline">
                            <div class="form__col form__title">생년월일</div>
                            <div class="form__col col-required">
                                <div class="col-group d-flex col-sb">
                                     <div class="inp inp-input phone-num license inp-radius" style="width:100px;">
                                        <input type="text" class="ajaxnec ajaxdata" name="meBirth0" placeholder="생년월일" maxlength="4" onchange="changePhoneNumber(event);">
                                    </div>
									<span class="hyphen">-</span>
                                     <div class="inp inp-input phone-num license inp-radius" style="width:100px;">
                                        <input type="text" class="ajaxnec ajaxdata" name="meBirth1" placeholder="" maxlength="2" onchange="changePhoneNumber(event);">
                                    </div>
									<span class="hyphen">-</span>
                                     <div class="inp inp-input phone-num license inp-radius" style="width:100px;">
                                        <input type="text" class="ajaxnec ajaxdata" name="meBirth2" placeholder="" maxlength="2" onchange="changePhoneNumber(event);">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form__row tf__row d-flex baseline">
                            <div class="form__col form__title">연락처</div>
                            <div class="form__col col-required">
                                <div class="col-group d-flex col-sb">
                                     <div class="inp inp-input phone-num license inp-radius" style="width:100px;">
                                        <input type="text" class="ajaxdata" name="mePhone0" maxlength="4"  placeholder="연락처" onchange="changePhoneNumber(event);">
                                    </div>
									<span class="hyphen">-</span>
                                     <div class="inp inp-input phone-num license inp-radius" style="width:100px;">
                                        <input type="text" class="ajaxdata" name="mePhone1" maxlength="4"  placeholder="" onchange="changePhoneNumber(event);">
                                    </div>
									<span class="hyphen">-</span>
                                     <div class="inp inp-input phone-num license inp-radius" style="width:100px;">
                                        <input type="text" class="ajaxdata" name="mePhone2" maxlength="4"  placeholder="" onchange="changePhoneNumber(event);">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form__col col-required d-flex">
                                <div class="col-group d-flex">
                                    <div class="inp inp-input phone-num license inp-radius">
                                        <input type="text">
                                    </div>
                                    <span class="hyphen">-</span>
                                    <div class="inp inp-input phone-num license inp-radius">
                                        <input type="text">
                                    </div>
                                    <span class="hyphen">-</span>
                                    <div class="inp inp-input phone-num license inp-radius">
                                        <input type="text">
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        <div class="form__row tf__row d-flex baseline">
                            <div class="form__col form__title">휴대전화</div>
                           
                            <div class="form__col col-required">
                                <div class="col-group d-flex col-sb">
                                     <div class="inp inp-input phone-num license inp-radius" style="width:100px;">
                                        <input type="text" class="ajaxnec ajaxdata" name="meMobile0" maxlength="3" placeholder="휴대전화1"  onkeyup="chkkeylen('meMobile0', 'meMobile1')" onchange="changePhoneNumber(event);">
                                    </div>
									<span class="hyphen">-</span>
                                     <div class="inp inp-input phone-num license inp-radius" style="width:100px;">
                                        <input type="text" class="ajaxnec ajaxdata" name="meMobile1" maxlength="4" placeholder="휴대전화2" onkeyup="chkkeylen('meMobile1', 'meMobile2')" onchange="changePhoneNumber(event);">
                                    </div>
									<span class="hyphen">-</span>
                                     <div class="inp inp-input phone-num license inp-radius" style="width:100px;">
                                        <input type="text" class="ajaxnec ajaxdata" name="meMobile2" maxlength="4" placeholder="휴대전화3" onchange="changePhoneNumber(event);">
                                    </div>
                                </div>
                            </div>
							  <!--  <div class="form__col col-required d-flex">
                              <div class="col-group d-flex">
                                    <div class="inp inp-input phone-num license inp-radius">
                                        <input type="text">
                                    </div>
                                    <span class="hyphen">-</span>
                                    <div class="inp inp-input phone-num license inp-radius">
                                        <input type="text">
                                    </div>
                                    <span class="hyphen">-</span>
                                    <div class="inp inp-input phone-num license inp-radius">
                                        <input type="text">
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="form__row tf__row d-flex">
                            <div class="form__col form__title">주소</div>
                            <div class="form__col col-required">
                                <div class="col-group col-address d-flex col-sb">
                                    <div class="col-auto">
                                        <div class="inp inp-input inp-radius">
                                            <input type="text" placeholder="우편번호 입력" name="meZipcode" class="ajaxdata ajaxnec" readonly>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <div class="btnBox">
                                            <a href="javascript:getzip('meZipcode','meAddress');" class="d-flex btn border-blue color-blue radius">주소검색</a>
											<p class="mg5t"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-group d-flex">
                                    <div class="inp inp-input address inp-radius">
                                        <input type="text" placeholder="읍, 면, 동 입력" name="meAddress" class="ajaxdata" readonly>
                                    </div>
                                </div>
                                <div class="col-group d-flex">
                                    <div class="inp inp-input address inp-radius">
                                        <input type="text" placeholder="나머지 주소(번지) 입력" name="meAddress1" class="ajaxdata ajaxnec">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form__row tf__row d-flex">
                            <div class="form__col form__title">기타</div>
                            <div class="form__col col-required">
                                <div class="inp inp-textarea inp-radius">
                                    <textarea placeholder="내용입력" name="meRemark" class="ajaxdata"></textarea>
                                </div>
                            </div>
                        </div>
						<?php if(!$_GET["seq"]) { ?>
                        <div class="inp-checkBox d-flex">
                            <div class="inp inp-check">
                                <label for="userchk" class="d-flex">
                                    <input type="checkbox" name="userchk" id="userchk" class="blind">
                                    <span></span>등록하는 환자에게 개인정보 수집·이용·제공에 대한 동의를 받았습니다
                                </label>
                            </div>
							<div style="width:autp;margin:10px auto;"><a href="https://data.dev.pnuh.djmedi.net/InformationConsent.hwp" download="https://data.dev.pnuh.djmedi.net/InformationConsent.hwp" style="background:#01A9DB;padding:5px;border-radius:2px;color:#fff;font-size:13px;">개인정보 수집·이용·제공 동의서 다운로드</a>
							</div>
                        </div>
						<?php } ?>
                    </div>
                    <div class="btnBox btnBox--type2 d-flex">
                        <a href="javascript:moremove('modal-patient');" class="d-flex btn border-blue color-blue radius modal-closeBtn--type2">취소</a>
						<?php if($_GET["seq"]){ ?>
						<a href="javascript:patient_update();" class="d-flex btn bg-blue color-white radius">수정</a>
						<a href="javascript:patient_delete();" class="d-flex btn bg-blue color-white radius" style="background:red;width:150px;margin-left: 20px;">삭제</a>
						<?php }else{ ?>
						<a href="javascript:patient_update();" class="d-flex btn bg-blue color-white radius">등록</a>
						<?php }?>                       
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

	var seq=$("input[name=seq]").val();
	console.log("seq  >>>  "+seq);
	if(isEmpty(seq))
	{
		$("input:radio[name='meSex']:radio[value='male']").attr("checked",true);  //남자를 기본값으로 체크
	}
	
	if(!isEmpty(seq))
	{
		callapi("GET","/medical/patient/",getdata("patientdesc")+"&seq="+seq);  
	}	
	

</script>