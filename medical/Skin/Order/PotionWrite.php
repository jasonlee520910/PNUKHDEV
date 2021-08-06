<?php
	$root="../..";
	include_once $root."/_common.php";
?>
<style>
	.modal{position:absolute;}
	.inp-search__list ul li a .tit{width:70%;}
	.inp-search__list ul li a .origin{width:20%;}

	.gram .inp input{text-align:center;}
</style>
<div class="container">
    <div class="sub prescribe prescribe-2">
        <div class="sub__title sub__title--tab d-flex">
            <div class="wrap d-flex">
                <h2>처방하기</h2>
                <div class="tab d-flex">
					<?=viewpotiontab("potion");?>
                </div>
            </div>
        </div>
        <div class="sub__content">
            <div class="sub__section sec1">
                <div class="wrap">
                    <div class="sub__body">
                        <div class="sub__item">
                            <div class="table__tit table__tit--type2 d-flex">
                                환자정보
                                <div class="form__row d-flex">
                                    <div class="form__col">
                                        <div class="inp-searchBox d-flex">
                                            <div class="inp inp-search d-flex">
                                                <input type="text" name="searchpatient" placeholder="이름, 생년월일, 전화번호 검색" onkeyup="searchkeyup('searchpatient',event)" onkeydown="searchkeydown('searchpatient', event);">
                                                <button class="inp-search__btn"></button>
                                            </div>
                                            <!-- 검색어 리스트 -->
                                            <div class="inp-search__list"></div>
                                        </div>
                                    </div>
                                    <div class="form__col">
                                        <div class="btnBox">
                                            <a href="javascript:addpatient('');" class="d-flex btn bg-blue color-white radius">신규등록</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table table--details" id="orderpatient">
                            </div>
                        </div>
                        <!-- <div class="btnBox">
                            <a href="javascript:;" id="pabtn" class="d-flex btn border-rightGray color-gray" style="display:none;">정보수정</a>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="sub__section sec2">
                <div class="wrap">
                    <div class="sub__body">
                        <div class="sub__item">
                            <div class="table__tit table__tit--type2 d-flex">
                                처방내용
                                <div class="form__row d-flex">
                                    <div class="form__col">
                                        <div class="inp-searchBox d-flex">
                                            <div class="inp inp-search d-flex">
                                                <input type="text" name="searchmedi" id="searchtab" placeholder="빠른 약재 추가" onkeyup="searchkeyup('searchmedi',event)" onkeydown="searchkeydown('searchmedi', event);">
                                                <button class="inp-search__btn"></button>
                                            </div>
                                            <!-- 검색어 리스트 -->
                                            <div class="inp-search__list"></div>
                                        </div>
                                    </div>
                                    <div class="form__col">
                                        <div class="btnBox">
                                            <a href="javascript:mediBtn('recipe');" id="recipeBtn" class="d-flex btn bg-blue color-white radius">처방추가</a>											
                                        </div>		
                                    </div>
									<div class="form__col">
										<div class="btnBox">
											<a href="javascript:mediBtn('medi');" id="mediBtn" class="d-flex btn bg-red color-white radius">약재추가</a>
										</div>
									</div>
                                </div>
                            </div>
                            <div class="table__form" id="orderinfo">
                            </div>
                            <div class="table table--list vertical-center" id="ordermedicine">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sub__section sec3 option">
                <div class="wrap">
                    <div class="tableBox d-flex">
                        <div class="table__col">
                            <div class="table__tit">탕전옵션</div>
                            <div class="table__item">
                                <div class="table table--details" id="orderdecoc">
                                </div>
                            </div>
                            <div class="table__item" id="orderadvice">
                            </div>
                            <div class="table__item" id="ordercomment">
                            </div>
                        </div>
                        <div class="table__col">
                            <div class="table__tit">처방비용</div>
							<input type="hidden" name="infirstamount" value="" class="ajaxdata">
							<input type="hidden" name="inafteramount" value="" class="ajaxdata">
                            <div class="table table--details" id="orderpayment">
                            </div>
                            <div class="btnBox d-flex">
                                <a href="javascript:saveOrder('');" class="d-flex btn border-blue color-blue radius">임시저장</a>
                                <a href="javascript:saveOrder('next');" class="d-flex btn color-white bg-blue radius">다음단계</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
