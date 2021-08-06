<?php
	$root="../..";
	include_once $root."/_common.php";
?>


<div class="container">
    <div class="sub customer-service notice board-cont-none">
        <div class="sub__title sub__title--tab d-flex">
            <div class="wrap d-flex">
                <h2>고객센터</h2>
                <div class="tab d-flex">
					<?=viewcstab('notice');?>
                </div>
            </div>
        </div>
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
					<div class="pm__item">
							<?php
								$carr=array(5,"*",10);
								$marr=array("번호","제목","날짜");
								echo tblinfo($carr, $marr);
							?>
					</div>
                    <div class="paging d-flex">
                        <!-- <div class="paging__numBox d-flex">
                            <a href="javascript:;" class="paging__num active">1</a>
                            <a href="javascript:;" class="paging__num">2</a>
                            <a href="javascript:;" class="paging__num">3</a>
                            <a href="javascript:;" class="paging__num">4</a>
                            <a href="javascript:;" class="paging__num">5</a>
                            <a href="javascript:;" class="paging__num">6</a>
                            <a href="javascript:;" class="paging__num">7</a>
                            <a href="javascript:;" class="paging__num">8</a>
                            <a href="javascript:;" class="paging__num">9</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
	function getlist()
	{
		callapi("GET","/medical/cs/",getdata("noticelist"));
	}

	function viewdesc(seq)
	{
		if($("#DescDiv"+seq).hasClass("active") === true) 
		{
			$("#DescDiv"+seq).removeClass('active');
		}
		else
		{
			$("#DescDiv"+seq).addClass('active');
		}
	}

	function makepage(result)
	{

		var obj = JSON.parse(result);
		console.log(obj);
		console.log("apiCode>>>>>>> "+obj["apiCode"]);
		
		if(obj["apiCode"]=="noticelist") 
		{
			//$marr=array("번호","제목","날짜");
			var marr=["seq","bbTitle","bbModify"];		
			makelist(result, marr);

		}
	}
	
</script>



