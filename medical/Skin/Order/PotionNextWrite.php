<?php
	$root="../..";
	include_once $root."/_common.php";
?>


<div class="container">
    <div class="sub product-payment prescribe prescribe-info">
        <div class="sub__content">
            <div class="sub__title">
                <div class="wrap">처방정보 및 주문</div>
            </div>
            <div class="sub__section sec1">
                <div class="wrap">
        <!--             <div class="btnBox d-flex">
                        <a href="javascript:;" class="d-flex btn bg-blue color-white radius">재처방</a>
                    </div> -->
                    <div class="tableBox d-flex">
                        <div class="table__col" id="ordersender">
                        </div>
                        <div class="table__col" id="orderreceiver">
                        </div>
                    </div>
                </div>
            </div>
            <div class="sub__section sec2" id="orderrecipe">
            </div>
            <div class="sub__section sec3">
                <div class="wrap">
                    <div class="table__tit">옵션</div>
                    <div class="tableBox d-flex">
                        <div class="table__col">
                            <div class="table__item" id="orderdecocview">
                            </div>
                            <div class="table__item" id="orderadviceview">
                            </div>
                            <div class="table__item" id="ordercommentview">
                            </div>
                        </div>
                        <div class="table__col">
                            <div class="table table--details" id="orderpaymentview">
                            </div>
                            <div class="btnBox d-flex">
                               <a href="javascript:saveOrder('prev');" class="d-flex btn border-blue color-blue radius">이전단계</a>
                                <!-- <a href="javascript:orderupdate();" class="d-flex btn color-white bg-blue radius">접수</a> -->
                                <!-- <a href="javascript:location.href='/Order/';" class="d-flex btn color-white bg-blue radius">접수</a> -->
								<a href="javascript:saveOrder('cart');" class="d-flex btn color-white bg-blue radius">접수</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
