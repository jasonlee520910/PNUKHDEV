<?php
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
    <div class="sub member-info member-info-6">
        <div class="sub__title sub__title--tab d-flex">
            <div class="wrap d-flex">
                <h2>처방정보</h2>
                <div class="tab d-flex">
					<?=viewmembertab("record");?>
                </div>
            </div>
        </div>
        <div class="sub__content" >
            <div class="sub__section">
                <div class="wrap">
                    <div class="table__box">
                        <!-- <div class="table__tit">처방기록</div> -->
                        <div class="table table--list">
							<div class="sub admin admin-order-details" style="padding: 0;">
								<div class="sub__title sub__title--left d-flex" style="margin-bottom: 20px;">
									<div class="table table--detail" >
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
                            </div>
							<div class="pm__item">
								<?php									
									$carr=array(15,12,8,"*",9,8);			
									$marr=array("처방번호","처방전송일자","환자명","처방명","진행상황","합계금액");
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
