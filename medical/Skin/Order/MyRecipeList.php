<?php
	//나의처방 
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
					<?=viewpotiontab("mydecoc");?>
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

											$carr=array(6,6,20,"*",6,6,6,6,10);
											$marr=array("mychkdel","제형","처방명","약재정보","약미","첩수","팩수","팩용량","기타");
											echo tblinfo($carr, $marr);
										?>
								</div>
								<div class="product-select d-flex" style="margin-top:-35px;margin-bottom:15px;">
									<div class="btnBox">
										<a href="javascript:delmyrecipe();" class="d-flex btn border-rightGray color-gray bg-white" style="width:100px;height:30px;font-size:13px;">나의처방삭제</a>
									</div>
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