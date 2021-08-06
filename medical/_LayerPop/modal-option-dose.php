<?php
	$root = "..";
	include_once $root."/_common.php";
	$upload=$root."/_module/upload";
	include_once $upload."/upload.lib.php";

?>

<script  type="text/javascript" src="<?=$root?>/jquery.form.min.js"></script>
<link rel="stylesheet" media="all" href="<?=$upload?>/upload.css?v=<?php echo time();?>" />
<script  type="text/javascript" src="<?=$upload?>/upload_200722.js?v=<?=time()?>"></script>

<!-- modal 복용지시 파일등록-->
<div class="modal" id="modal-option-dose">
    <div class="modal__bg"></div>	
    <div class="modal__content pd0 pd-modify">
		<button class="modal-closeBtn" onclick="moremove('modal-option-dose');"></button>
        <div class="option-dose m-file">
            <div class="modal__head--type2 d-flex">복용지시 파일등록</div>
            <div class="modal__body">
                <div class="item">
                    <div class="inp-inputBox d-flex">
                        <p class="d-flex dose-tit">
                            제목
                            <span class="bar">|</span>
                        </p>
                        <div class="inp inp-input">
                            <input type="text" name="mdTitle" placeholder="제목을 입력해주세요" class="ajaxdata" >
                        </div>
                    </div>
                    <!-- <p class="warning-message">제목을 입력해주세요.</p> -->
                </div>
                <div class="item">
                    <div class="fileBox">
                        <div class="inp-file d-flex file-custom">
							<input type="text" name="mdFileIdx" class="ajaxdata"  >
							<?=upload("docx",$_COOKIE["ck_meUserId"],$_COOKIE["ck_language"]);?>
                        </div>
                        <div class="inp-file-memory">
                            최대용량 10MB (jpg, gif, png, pdf) 첨부 가능합니다.
                        </div>
                    </div>
                    <p class="warning-message">파일첨부를 해주세요.</p>
                </div>

                <div class="btnBox d-flex">
                    <a href="javascript:moremove('modal-option-dose');" class="d-flex btn color-gray">취소</a>
                    <a href="javascript:adviceupdate();" class="d-flex btn color-blue">등록</a>
                </div>
            </div>
        </div>
    </div>
</div>