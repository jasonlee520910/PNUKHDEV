<?php
	$root="../..";
	include_once $root."/_common.php";
?>


<div class="container">
    <div class="sub member-info member-info-6">
        <div class="sub__title sub__title--tab d-flex">
            <div class="wrap d-flex">
                <h2>회원정보</h2>
                <div class="tab d-flex">
					<?=viewmembertab("mydoctor");?>
                </div>
            </div>
        </div>
        
		<div class="sub__section">
            <div class="sub__section">
                <div class="wrap">
				<div class="" style="width:100%;height:100%;font-size:16px;padding:10px; -webkit-box-sizing:border-box;box-sizing:border-box;" >			
					<div style="padding-left:450px;">
						<input type="text" name="meRegistno" value="" class="ajaxdata ajaxnec" placeholder="면허번호"  style="border:2px solid #d7d7d7;height:30px;" >
						<input type="text" name="meName" value="" class="ajaxdata ajaxnec" placeholder="한의사이름" style="border:2px solid #d7d7d7;height:30px;">
						 <a href="javascript:invitedoctor();" class="d-flex btn btn--small border-rightGray color-gray" style="float:right;">한의사 등록</a>
					</div >	 
				</div>
                    <div class="table__box">
                        <div class="table table--list">
							<div class="pm__item">
								<?php									
									$carr=array(15,15,15,15,"*",10,10);			
									$marr=array("등록일","면허번호","한의사명","휴대전화","이메일","상태","");
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

