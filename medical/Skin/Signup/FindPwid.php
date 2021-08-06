<?php
	$root="..";
	include_once $root."/_common.php";
?>


<div class="container">
    <div class="sub find find-pw">
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
                    <div class="sub__title find__title">
                        <h2>비밀번호 찾기</h2>
                        <p>비밀번호를 찾고자 하는 아이디를 입력해 주세요.</p>
                    </div>
                    <div class="sub__body">
                        <form action="">
                            <div class="form">
                                <div class="form__row tf__row d-flex baseline"">
                                    <div class="form__col form__title">아이디</div>
                                    <div class="form__col col-required">
                                        <div class="inp inp-input inp-radius">
                                            <input type="text" placeholder="아이디" name="findid" class="ajaxdata ajaxnec">
                                        </div>
                                    </div>
                                </div>
                                <div class="form__row tf__row d-flex baseline"">
                                    <div class="form__col form__title">이름</div>
                                    <div class="form__col col-required">
                                        <div class="inp inp-input inp-radius">
                                            <input type="text" placeholder="이름" name="findname" class="ajaxdata ajaxnec">
                                        </div>
                                    </div>
                                </div>
								<div class="form__row tf__row d-flex baseline">
									<div class="form__col form__title">이메일</div>
									<div class="form__col col-required">
										<div class="col-group d-flex">
											<div class="col-auto col-auto--fst d-flex">
												<div class="inp inp-input email inp-radius">
													<input type="text" name="stEmail0" id="stEmail0" class="ajaxdata ajaxnec" placeholder="이메일">
												</div>
												<span class="hyphen">@</span>
												<div class="inp inp-input email inp-radius">
													<input type="text" name="stEmail1" id="stEmail1" class="ajaxdata ajaxnec" placeholder="이메일">
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
									</div>
								</div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="btnBox btnBox--modify d-flex">
                    <a href="javascript:findpw()" class="d-flex btn color-white bg-blue radius">찾기</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
	function findpw(){
		if(ajaxnec()=="Y"){
			callapi("POST","/medical/member/",getdata("findpw"));
		}
	}

	function makepage(result)
	{
		var obj = JSON.parse(result);
		console.log(obj);
		if(obj["resultCode"] == "200")
		{
			setCookie("findinfo","findpw="+obj["memberEmail"],1);
			location.href="/Signup/FindComplete.php";
		}
		else if(obj["resultCode"] == "204")
		{
			alert(obj["resultMessage"]); //중복아이디	
		}
		else
		{

		}
		return false;
	}
</script>

