<?php
	$root="..";
	include_once $root."/_Inc/head.php";
	include_once $root."/_common.php";
?>
<textarea name="join_jsondata" style="display:none3;"></textarea> 
<div class="container">
    <div class="sub join-fill-in">
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
                    <div class="sub__title">계약서 작성안내</div>
                    <div class="sub__body">
                        <div class="contract-guide d-flex">
                            <div class="cg__download-btn">							
                                <a href="https://data.dev.pnuh.djmedi.net/file.zip" download="https://data.dev.pnuh.djmedi.net/file.zip" class="btn bg-blue radius d-flex">
                                    <div class="inner d-flex">
                                        Download
                                        <span>원외탕전실 계약서류 모음.pdf</span>         
                                    </div>                           
                                </a>
                            </div>
                            <div class="cg__txt">
                                한의원 개설 등록증을 제외한모든 서류는 다운받으신 문서에 포함되어 있습니다.<br/>
                                *표시한 문서에 한의원 정보를 기입해주세요.
                            </div>
                        </div>
                        <div class="contract-document d-flex">
                            <div class="cd__item">
                                <div class="cd__head">원외탕전실에 보내실 서류</div>
                                <div class="cd__body">
                                    탕전실 공동이용 계약서 원본*<br/>
                                    한의원 의료기관 개설 등록증 사본<br/>
                                    한의사 면허증사본<br/>
                                    재직증명서
                                </div>
                                <div class="cd__foot">
                                    50612 경상남도 양산시 물금읍 금오로 20 부산대학교한방병원<br/>
                                    원외탕전실 행정담당자 앞
                                </div>
                            </div>
                            <div class="cd__item">
                                <div class="cd__head">보건소에 보내실 서류</div>
                                <div class="cd__body">
                                    한의원 의료기관 개설 등록증 원본<br/>
                                    원외탕전실 공동이용 계약서 사본*<br/>
                                    원외탕전실 의료기관 개설신고 증명서<br/>
                                    의료기관 개설신고 및 신고사항 변경신청서*<br/>
                                    원외탕전실 공동이용 내역서 *<br/>
                                    원외탕전실 평면도 및 구조설명서<br/>
                                    원외탕전실 설치내역 확인서 사본<br/>
                                    상주 한약사 면허증 사본<br/>
                                    원외탕전실 사업자등록증 사본
                                </div>
                                <div class="cd__foot">
                                    한의원 관할 보건소,<br/>
                                    또는 인터넷 ( 보건의료자원통합신고포털 <a href="http://www.hurb.or.kr" target="_blank">http://www.hurb.or.kr</a> ) 제출
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sub__section sec2">
                <div class="wrap">
                    <div class="sub__title">의료기관정보 입력</div>
                    <div class="sub__body">
                        <form action="">
                            <div class="form">
                                <div class="form__row tf__row d-flex baseline">
                                    <div class="form__col form__title nec">의료기관명</div>
                                    <div class="form__col col-required">
                                        <div class="inp inp-input inp-radius">
                                            <input type="text" placeholder="의료기관명" name="miName" class="ajaxdata ajaxnec">
                                        </div>
                                    </div>
                                </div>
                                <div class="form__row tf__row d-flex baseline">
                                    <div class="form__col form__title nec" >사업자번호</div>
                                    <div class="form__col col-required">

										<div class="inp inp-input inp-radius">
											<input type="text" name="miBusinessno0" id="miBusinessno0" placeholder="사업자번호" class="ajaxdata ajaxnec" >
										</div>
                                        <!-- <div class="col-auto col-auto--fst d-flex">
                                            <div class="inp inp-input phone-num license inp-radius">
                                                <input type="text" placeholder="사업자번호" name="miBusinessno0" class="ajaxdata ajaxnec">
                                            </div>
                                            <span class="hyphen">-</span>
                                            <div class="inp inp-input phone-num license inp-radius">
                                                <input type="text" placeholder="사업자번호" name="miBusinessno1" class="ajaxdata ajaxnec">
                                            </div>
                                            <span class="hyphen">-</span>
                                            <div class="inp inp-input phone-num license inp-radius">
                                                <input type="text" placeholder="사업자번호" name="miBusinessno2" class="ajaxdata ">
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="form__row tf__row d-flex baseline">
                                    <div class="form__col form__title nec">대표자명</div>
                                    <div class="form__col col-required">
                                        <div class="inp inp-input inp-radius">
                                            <input type="text" placeholder="대표자명" name="miCeo" class="ajaxdata ajaxnec">
                                        </div>
                                    </div>
                                </div>
                                <div class="form__row tf__row d-flex">
                                    <div class="form__col form__title nec">사업장 소재지</div>
                                    <div class="form__col col-required">
                                        <div class="col-group d-flex">
                                            <div class="col-auto col-auto--fst">
                                                <div class="inp inp-input inp-radius">
                                                    <input type="text" placeholder="우편번호 " name="miZipcode" class="ajaxdata" readonly>
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
                                            <div class="inp inp-input address inp-radius">
                                                <input type="text" placeholder="읍, 면, 동 " name="miAddress" class="ajaxdata ajaxnec" readonly>
                                            </div>
                                        </div>
                                        <div class="col-group d-flex">
                                            <div class="inp inp-input address inp-radius">
                                                <input type="text" placeholder="나머지 주소(번지) " name="miAddress1" class="ajaxdata ajaxnec">
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="form__row tf__row d-flex baseline">
                                    <div class="form__col form__title nec">전화번호</div>
                                    <div class="form__col col-required">
                                        <div class="col-auto col-auto--fst d-flex">
                                            <div class="inp inp-input fax inp-radius">
                                                <input type="text"  name="miPhone0" class="ajaxdata ajaxnec" placeholder="번호1" maxlength="4" onchange="changePhoneNumber(event);" >
                                            </div>
                                            <span class="hyphen">-</span>
                                            <div class="inp inp-input fax inp-radius">
                                                <input type="text"  name="miPhone1" class="ajaxdata ajaxnec" placeholder="번호2" maxlength="4" onchange="changePhoneNumber(event);" >
                                            </div>
                                            <span class="hyphen">-</span>
                                            <div class="inp inp-input fax inp-radius">
                                                <input type="text"  name="miPhone2" class="ajaxdata ajaxnec" placeholder="번호3" maxlength="4"onchange="changePhoneNumber(event);" >
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="form__row tf__row d-flex baseline">
                                    <div class="form__col form__title">팩스번호</div>
                                    <div class="form__col col-required">
                                        <div class="col-auto col-auto--fst d-flex">
                                            <div class="inp inp-input fax inp-radius">
                                                <input type="text"  name="miFax0" class="ajaxdata" maxlength="4" onchange="changePhoneNumber(event);" >
                                            </div>
                                            <span class="hyphen">-</span>
                                            <div class="inp inp-input fax inp-radius">
                                                <input type="text"  name="miFax1" class="ajaxdata" maxlength="4" onchange="changePhoneNumber(event);" >
                                            </div>
                                            <span class="hyphen">-</span>
                                            <div class="inp inp-input fax inp-radius">
                                                <input type="text"  name="miFax2" class="ajaxdata" maxlength="4"onchange="changePhoneNumber(event);" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form__row tf__row d-flex baseline">
                                    <div class="form__col form__title nec">세금계산서</div>
                                    <div class="form__col col-required">                       											
										<div class="inp inp-input inp-radius">
											<input type="text" name="miEmail0" id="stEmail0" placeholder="세금계산서" class="ajaxdata ajaxnec"  onfocus="this.select();" onchange="changeID(event, false);">
										</div>
												
											<!-- <span class="hyphen">@</span>
											<div class="inp inp-input email inp-radius">
												<input type="text" name="miEmail1" id="stEmail1" placeholder="세금계산서" class="ajaxdata ajaxnec">
											</div> -->
									   
										<!-- <div class="col-auto col-auto--lst">
											<div class="inp inp-select inp-radius">
												<select name="selectEmail" onchange="selemail('selectEmail')">
													<option value="">직접입력</option>
													<option value="naver.com">naver.com</option>
													<option value="hanmail.net">hanmail.net</option>
													<option value="gmail.com">gmail.com</option>
													<option value="nate.com">nate.com</option>
												</select>
											</div>
										</div> -->
										<div class="attach-txt">
											세금계산서를 발급받으실 이메일 주소를 입력해주세요.
										</div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="btnBox btnBox--modify d-flex">
                <a href="javascript:joinfillin_update('hold');" class="d-flex btn color-white bg-blue radius">완료</a>
            </div>
        </div>
    </div>
</div>


<script>

	//완료 버튼
	function joinfillin_update(type)
	{
		if(type=="hold")
		{
			if(ajaxnec()=="Y")  //이메일 인증은 이미 한의사 가입하면서 하였음
			{
				callapi("POST","/medical/member/",getdata("addmedicalupdate"));
				location.href="/Signup/JoinComplete.php";//완료 페이지로 이동

			}
		}
	}

	function makepage(result)
	{
		var obj = JSON.parse(result);
		console.log(obj);
		console.log("apiCode>>>"+obj["apiCode"]);

	}

</script>