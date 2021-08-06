<?php
	$root="../..";
	include_once $root."/_common.php";
?>


<div class="container">
    <div class="sub dictionary">
        <div class="sub__title sub__title--tab d-flex">
            <div class="wrap d-flex">
                <h2>처방사전</h2>
                <div class="tab d-flex">
					<?=viewdictionarytab("formulary");?>
                </div>
            </div>
        </div>
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
                    <div class="sub__body">
                        <div class="inp-searchBox d-flex">
                            <div class="inp inp-search d-flex">
								<?=searcharea();?>	
                                <!-- <input type="text" placeholder="방제명 입력">
                                <button class="inp-search__btn" style="border:2px solid red;"></button> -->
                            </div>
                        </div>
						<div class="pm__item">
								<?php
									$carr=array(8,18,"*",20);
									$marr=array("순서","처방명","약재정보","효능");
									echo tblinfo($carr, $marr);
								?>
						</div>
                        <div class="paging d-flex" >
                            <!-- <div class="paging__arrow d-flex">
                                <a href="javascript:;" class="paging__btn paging__fst">처음</a>
                                <a href="javascript:;" class="paging__btn paging__prev">이전</a>
                            </div>
                            <div class="paging__numBox d-flex">
                                <a href="javascript:;" class="paging__num active">1</a>
                                <a href="javascript:;" class="paging__num">2</a>
                                <a href="javascript:;" class="paging__num">3</a>
                                <a href="javascript:;" class="paging__num">4</a>
                                <a href="javascript:;" class="paging__num">5</a>
                                <a href="javascript:;" class="paging__num">6</a>
                                <a href="javascript:;" class="paging__num">7</a>
                                <a href="javascript:;" class="paging__num">8</a>
                                <a href="javascript:;" class="paging__num">9</a>
                            </div>
                            <div class="paging__arrow d-flex">
                                <a href="javascript:;" class="paging__btn paging__next">다음</a>
                                <a href="javascript:;" class="paging__btn paging__lst">마지막</a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

