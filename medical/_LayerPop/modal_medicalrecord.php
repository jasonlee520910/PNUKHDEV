<?php
	$root = "..";
	include_once $root."/_common.php";
?>

<!-- modal 이전진료기록-->
<div class="modal" id="modal_medicalrecord">
    <div class="modal__bg"></div>
	<input type="text" name="userid" class="ajaxdata" value="<?=$_GET["userid"]?>">
	<input type="text" name="name" class="ajaxdata" value="<?=$_GET["name"]?>">
	
    <div class="modal__content">
<div class="container">
<button class="modal-closeBtn" onclick="moremove('modal_medicalrecord');"></button>
    <div class="member-info member-info-6">
        <div class="sub__title sub__title--tab d-flex">
            <div class="wrap d-flex">
                <h2>진료기록</h2>
				
                <div class="tab d-flex">
					 <h2>환자명 : </h2><?=$_GET["name"]?>
                </div>
            </div>
        </div>
        <div class="sub__content" >
            <div class="sub__section">
                <div class="wrap">
                    <div class="table__box">             
                        <div class="table table--list">
							<div class="pm__item">
								<?php									
									$carr=array(15,15,20,"*",10,10,15);			
									$marr=array("처방번호","처방일자","처방명","진행상황","합계금액","처방메모","재처방하기");
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


























        <div class="withdraw">
		<button class="modal-closeBtn" onclick="moremove('modal_medicalrecord');"></button>
            <div class="modal__head">진료기록</div>
            <div class="modal__body">
                <div class="txtBox">

                </div>

            </div>
        </div>
    </div>
</div>

<script>


</script>