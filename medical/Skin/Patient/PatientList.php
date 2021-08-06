<?php
	$root="../..";
	include_once $root."/_common.php";
?>

<div class="container">
    <div class="sub patient-management">
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
                    <div class="sub__title">환자관리</div>
                    <div class="sub__body">
                        <div class="form__row d-flex">
                            <div class="form__col">
                                <div class="inp-searchBox d-flex">
                                    <div class="inp inp-search d-flex">
                                        <!-- <input type="text" placeholder="이름, 생년월일, 전화번호 검색" class="ajaxdata" name="search" value="">
                                        <button class="inp-search__btn"></button> -->
										<?=searcharea();?>	
                                    </div>

                                    <!-- 검색어 리스트 -->
                                    <div class="inp-search__list" style="display:1none">
     
                                    </div>
                                </div>
                            </div>
                            <div class="form__col">
                                <div class="btnBox">
                                    <a href="javascript:medicallayer('modal-patient','');" class="d-flex btn bg-blue color-white radius">신규등록</a>
                                </div>
								
                            </div>
                        </div>
                        <div class="pm__chart">

				<?php if($_COOKIE["ck_meGrade"]=="30"){?>

                            <div class="inp-radioBox d-flex">
                                <div class="inp inp-radio">
                                    <label for="all" class="d-flex">
                                        <input type="radio" name="mypatient" id="all" value="all" class="blind"  checked onclick="mypatientlist();">
                                        <span></span>전체
                                    </label>
                                </div>
                                <div class="inp inp-radio">
                                    <label for="mine" class="d-flex">
                                        <input type="radio" name="mypatient" id="mine" value="mine" class="blind"  onclick="mypatientlist();">
                                        <span></span>처방환자
                                    </label>
                                </div>
                            </div>

				<?php }?>
                            <div class="pm__item">
									<?php
										//$carr=array(15,10,10,10,10,10,15,"*");
										$carr=array(10,18,10,7,15,15,10,"*");
										$marr=array("등록일","차트번호","환자명","성별","생년월일","휴대전화","최근처방일","이전기록");
										echo tblinfo($carr, $marr);
									?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
