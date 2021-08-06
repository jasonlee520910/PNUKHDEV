<?php
	$root="../..";
	include_once $root."/_common.php";
	$upload=$root."/_module/upload";
	include_once $upload."/upload.lib.php";
?>

<style>
	.upload{overflow:hidden;margin:0;padding:0;}
	.uploaddiv{overflow:hidden;padding-bottom:10px;}
	.multiimg dd{width:48%;float:left;overflow:hidden;margin:0;padding:0;}
	.multiimg dd p{padding:0 10px;font-weight:bold;}
	#imgs_wrap, .imgs_wrap{clear:both;margin:10px 5px;padding:0;width:50px;}
	.imgs_wrap img{max-width:100px;}
	.viewimg{width:100px;height:80px;overflow:hidden;margin:5px;}
	.viewimg img{height:100%;}
	.col-required .inp-input.phone-num {width:100px;}
	.inp-checkBox .chkemail{font-size:13px;color:red;}
</style>

<script  type="text/javascript" src="<?=$root?>/jquery.form.min.js"></script>
<link rel="stylesheet" media="all" href="<?=$upload?>/upload.css?v=<?php echo time();?>" />
<script  type="text/javascript" src="<?=$upload?>/upload_200722.js?v=<?=time()?>"></script>

<div class="container">
    <div class="sub join">
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
                    <div class="join__inner">
                        <div class="sub__title">회원 정보 입력</div>
                        <div class="sub__body">
                            <!-- <form action=""> -->
                                <div class="form">
                                    <div class="form__row tf__row d-flex baseline">
                                        <div class="form__col form__title nec">아이디</div>
                                        <div class="form__col col-required">
                                            <div class="inp inp-input inp-radius inp-warning">
                                                <input type="text" class="ajaxdata ajaxnec" name="stUserId" placeholder="아이디" onkeyup="loginid_check()" onfocus="this.select();" onchange="changeID(event, false);">
                                            </div>
											<input type="hidden" id="idchk" name="idchk" value="0">	
                                            <div class="inp-error" id="idchktxt" style="min-height:15px;">
                                                5~20자의 영문 소문자, 숫자만 사용해주세요.
                                           </div>	
																		
											<!-- <div class="checkStaffId"><span class="stxt" id="idsame"></span></div> --><!--아이디중복여부표시-->
                                        </div>
                                    </div>
                                    <div class="form__row tf__row d-flex baseline">
                                        <div class="form__col form__title nec">비밀번호</div>
                                        <div class="form__col col-required">
											<input type="hidden" id="passchk" name="passchk" value="0">
                                            <div class="inp inp-input inp-radius inp-warning">
                                                <input type="password" class="ajaxdata ajaxnec" name="passwordDiv" placeholder="비밀번호" onkeyup="password_check()" autocomplete="off">
                                            </div>
                                            <div class="inp-error" id="passwordchk" style="min-height:15px;">
                                                비밀번호는 9자리 이상 문자, 숫자, 특수문자로 구성하여야 합니다..
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__row tf__row d-flex baseline">
                                        <div class="form__col form__title nec">비밀번호 확인</div>
                                        <div class="form__col col-required">
                                            <div class="inp inp-input inp-radius">
                                                <input type="password" class="ajaxdata ajaxnec" name="passwordDiv2" placeholder="비밀번호 확인" onkeyup="password_check()">
                                            </div>
                                            <div class="inp-error" id="passwordchk2" style="min-height:15px;">
                                                비밀번호 확인란을 입력해 주세요.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__row tf__row d-flex baseline">
                                        <div class="form__col form__title nec">이름</div>
                                        <div class="form__col col-required">
                                            <div class="inp inp-input inp-radius">
                                                <input type="text" class="ajaxdata ajaxnec" name="stName" placeholder="이름">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__row tf__row d-flex baseline">
                                        <div class="form__col form__title nec">휴대전화</div>
                                        <div class="form__col col-required">
                                            <div class="col-group d-flex">
                                                <div class="col-auto col-auto--fst d-flex">
                                                    <div class="inp inp-input phone-num inp-radius">
                                                        <input type="text" class="ajaxdata ajaxnec" name="stMobile0" placeholder="휴대전화1" maxlength="3" onkeyup="chkkeylen('stMobile0', 'stMobile1')" onchange="changePhoneNumber(event);">
                                                    </div>
                                                    <span class="hyphen">-</span>
                                                    <div class="inp inp-input phone-num inp-radius">
                                                        <input type="text" class="ajaxdata ajaxnec" name="stMobile1" placeholder="휴대전화2" maxlength="4" onkeyup="chkkeylen('stMobile1', 'stMobile2')" onchange="changePhoneNumber(event);" >
                                                    </div>
                                                    <span class="hyphen">-</span>
                                                    <div class="inp inp-input phone-num inp-radius">
                                                        <input type="text" class="ajaxdata ajaxnec" name="stMobile2" placeholder="휴대전화3" maxlength="4" onchange="changePhoneNumber(event);">
                                                    </div>
                                                </div>
                                                <!-- <div class="col-auto col-auto--lst">
                                                    <div class="btnBox">
                                                        <a href="javascript:mobilechk();" id="mobilechk" class="d-flex btn border-blue color-blue radius">인증번호 받기</a>
                                                    </div>
                                                </div> -->
                                            </div>
                                            <!-- <div class="col-group d-flex">
                                                <div class="col-auto col-auto--fst">
                                                    <div class="inp inp-input inp-radius">
                                                        <input type="text" placeholder="인증번호 6자리 숫자 입력" name="qwdqdqw">
                                                    </div>
                                                </div>
                                                <div class="col-auto col-auto--lst">
                                                    <div class="btnBox">
                                                        <a href="javascript:mobilere();" id="mobilere" class="d-flex btn border-blue color-blue radius">인증하기</a>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-group d-flex">
                                                <div class="inp-checkBox">
                                                    <div class="inp inp-check">
                                                        <label for="d1" class="d-flex">
                                                            <input type="checkbox" name="" id="d1" class="blind">
                                                            <span></span>사이트 이용관련 안내 SMS 수신
                                                        </label>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="form__row tf__row d-flex baseline">
                                        <div class="form__col form__title nec">이메일</div>
                                        <div class="form__col col-required">
                                            <div class="col-group d-flex">
                                                <div class="col-auto col-auto--fst d-flex">
                                                    <div class="inp inp-input email inp-radius">
                                                        <input type="text" name="stEmail0" id="stEmail0" class="ajaxdata ajaxnec" placeholder="이메일1" onfocus="this.select();" onchange="changeID(event, false);" >
                                                    </div>
                                                    <span class="hyphen">@</span>
                                                    <div class="inp inp-input email inp-radius">
                                                        <input type="text" name="stEmail1" id="stEmail1" class="ajaxdata ajaxnec"  placeholder="이메일2" onfocus="this.select();" onchange="changeID(event, false);">
                                                    </div>
                                                </div>
                                                <div class="col-auto col-auto--lst">
                                                    <div class="inp inp-select inp-radius">
                                                        <select name="selectEmail" onchange="selemail('selectEmail')">
                                                            <option value="">직접입력</option>
                                                            <option value="naver.com">naver.com</option>
                                                            <option value="hanmail.net">hanmail.net</option>
                                                            <option value="gmail.com">gmail.com</option>
                                                            <option value="nate.com">nate.com</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-group d-flex">
                                                <div class="inp-checkBox">
                                                    <div class="inp inp-check">
                                                        <label for="meIsemail" class="d-flex">
                                                            <input type="checkbox" name="meIsemail" id="meIsemail" class="blind" value="Y" checked="checked" >
                                                            <span></span>사이트 이용관련 안내 이메일 수신
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-group d-flex">
                                                <div class="inp-checkBox">
													<?php
													if($_SERVER["REMOTE_ADDR"]=="59.7.50.122"){
													?>
													<a href="javascript:test_update('');" class="d-flex btn color-white bg-blue radius">이메일 테스트</a> 
													<?php }?>									
                                                    <div class="inp inp-check chkemail">
                                                        * 이메일 인증 후 사이트 사용가능합니다.														
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__row tf__row d-flex baseline">
                                        <div class="form__col form__title nec">면허번호</div>
                                        <div class="form__col col-required">
                                            <div class="inp inp-input inp-radius">
                                                <input type="text" placeholder="면허번호" class="ajaxdata ajaxnec" name="licenseno">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__row tf__row d-flex baseline">
                                        <div class="form__col form__title">서류첨부</div>
                                        <div class="form__col col-required">
                                            <div class="col-group d-flex">
                                                <div class="attach-txt">
                                                    면허증 사본을 첨부해주세요.<br/>
                                                    전체 최대용량 8MB, 이미지 파일 (jpeg, jpg, png, gif) 첨부 가능합니다.
                                                </div>
                                            </div>
											<div>
		
											</div>
                                            <div class="col-group">
												<!-- <button type="button" class="sp-btn" onclick="uploadbtn('license');">면허증첨부</button> -->
												<input type="hidden" name="mmFileSeq" class="w10p ajaxdata" title="fileseq" value=""/>
												<?=upload("license",$_COOKIE["ck_stStaffid"],$_COOKIE["ck_language"])?>
                                                <!-- <div class="inp-file d-flex file-custom">
                                                    <label for="fu1">
                                                        파일첨부
                                                        <input type="file" name="" id="fu1" class="blind upload-file">
                                                    </label>
                                                    <input type="text" value="선택된 파일 없음" class="upload-name" disabled="disabled">
                                                    <button class="file-delete"></button>
                                                </div>
                                                <div class="inp-error">
                                                    파일을 첨부해주세요.
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- </form> -->
                        </div>
                    </div>

                    <div class="btnBox btnBox--modify d-flex">
                        <a href="javascript:;" class="d-flex btn bg-white border-blue color-blue radius" onclick="goterms('');return false;">이전</a>
                        <a href="javascript:join_update();" class="d-flex btn color-white bg-blue radius">다음</a>

						<?php
						if($_SERVER["REMOTE_ADDR"]=="59.7.50.122")
						{
						?>
							<!-- <a href="javascript:join_pass();" class="d-flex btn color-white bg-blue radius">개발용PASSDEV</a> -->
						<?php
						}
						?>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
