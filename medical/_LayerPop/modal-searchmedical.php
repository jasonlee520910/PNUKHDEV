<?php
	$root = "..";
	include_once $root."/_common.php";

	$userId=!isEmpty($_COOKIE["ck_saveid"])?$_COOKIE["ck_saveid"]:"";
?>
<!-- modal 한의원검색-->

<div class="modal" id="modal-searchmedical">
    <div class="modal__bg"></div>
    <div class="modal__content">
		<button class="modal-closeBtn" onclick="moremove('modal-searchmedical');"></button>
        <div class="auth">
            <div class="modal__head">한의원검색</div>
            <div class="modal__body">
				<td class="td-txtLeft">		
					<div class='inp-searchBox' style="margin-left:400px;" > 
						<div class='inp inp-search d-flex'>	
						<input type='text'  name='medicalsearchTxt' id='medicalsearchTxt' class='ajaxdata' value='' placeholder='' onkeydown='if(event.keyCode==13)medicalsearcls()'>	
						<button class='inp-search__btn' type='button' onclick='medicalsearcls()' style='cursor:pointer;'><span></span></button>	
						</div>
					</div>	
				</td>
            </div>

		<div class="container">
			<div class="member-info member-info-6">
				<div class="sub__content" >
					<div class="sub__section">
						<div class="wrap">
							<div class="table__box">             
								<div class="table table--list">
									<div class="pm__item">
										<?php									
											$carr=array(10,10,"*",10,20);			
											$marr=array("한의원이름","대표자이름","한의원주소","사업자번호","");
											echo popuptblinfo($carr, $marr);
										?>
									</div>
								</div>
							  </div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>


