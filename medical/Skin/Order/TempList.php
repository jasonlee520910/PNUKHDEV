<?php
	//임시처방
	$root="../..";
	include_once $root."/_common.php";
?>

<script>
	$.datepicker.setDefaults({
			dateFormat: 'yy-mm-dd'
		});

	$(function(){
		//달력
		$("#sdate").datepicker({
			maxDate :  $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#edate").val()),
			onSelect:function(selectedDate){
				$("#edate").datepicker('option', 'minDate', $.datepicker.parseDate($.datepicker._defaults.dateFormat, selectedDate));
			}
		});
		$("#edate").datepicker({
			minDate :  $.datepicker.parseDate($.datepicker._defaults.dateFormat, $("#sdate").val()),
			onSelect:function(selectedDate){
				$("#sdate").datepicker('option', 'maxDate', $.datepicker.parseDate($.datepicker._defaults.dateFormat, selectedDate));
			}
		});
	})
</script>
<div class="container">
    <div class="sub admin admin-order-details">
        <div class="sub__title sub__title--tab d-flex">
            <div class="wrap d-flex">
                <h2>처방하기</h2>
                <div class="tab d-flex">
					<?=viewpotiontab("temp");?>
                </div>
            </div>
        </div>
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
                    <div class="tableBox">
                        <div class="table__item">
                            <div class="table table--detail">
								<table>
									<colgroup>
										<col width="120px">
										<col>
									</colgroup>
									<tbody>
										<tr>
											<th>조회기간</th>
											<td class="td-txtLeft"><?=selectperiod()?></td>
										</tr>
										<tr>
											<th>검색어</th>
											<td class="td-txtLeft"><?=searcharea()?></td>
										</tr>
								</table>
                            </div>
                        </div>
                        <div class="table__item">
                            <div class="table table--list invalid">
								<div class="pm__item">
										<?php

											$carr=array(8,15,10,"*",8,8,8);			
											$marr=array("처방일자","처방번호","제형","주문상품정보","환자정보","결제금액","상태");
											echo tblinfo($carr, $marr);
										?>
								</div>
                                <!-- <table>
                                    <colgroup>
                                        <col>
                                        <col>
                                        <col>
                                        <col>
                                        <col>
                                        <col>
                                        <col>
                                        <col>
                                        <col>
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>한의사</th>
                                            <th>처방번호</th>
                                            <th>처방전송일자</th>
                                            <th>환자명</th>
                                            <th>처방명</th>
                                            <th>첩수</th>
                                            <th>용량</th>
                                            <th>진행상황</th>
                                            <th>합계금액</th>
                                        </tr>
                                    </thead>
                                    <tbody> -->
                                        <!-- <tr>
                                            <td>신영진</td>
											<td><p>20200512183505005</p></td>
											<td><p>2020.6.3</p></td>
											<td><p>김영희</p></td>
											<td><p>시호계지탕</p></td>
											<td><p>20</p></td>
											<td><p>120ml</p></td>
											<td><p><div class="btnBox cart-detail">
                                                        <a href="/Payment/" class="d-flex btn btn--small bg-blue color-white ">결제하기</a>
                                                    </div></p></td>
											<td><p>65110원</p></td>
                                        </tr> -->

   <!-- 
                                    </tbody>
                                </table> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>