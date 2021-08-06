<?php
	$root="../..";
	include_once $root."/_common.php";
?>

<!-- FAQ -->
<div class="container">
    <div class="sub customer-service notice board-cont-none">
        <div class="sub__title sub__title--tab d-flex">
            <div class="wrap d-flex">
                <h2>고객센터</h2>
                <div class="tab d-flex">
					<?=viewcstab("faq");?>
                </div>
            </div>
        </div>
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
					<div class="pm__item">
							<?php								
								$carr=array(5,"*");
								$marr=array("번호","제목");
								echo tblinfo($carr, $marr);
							?>
					</div>
					 <div class="paging d-flex">
					 </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
	function getlist()
	{
		callapi("GET","/medical/cs/",getdata("faqlist"));
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
		
		if(obj["apiCode"]=="faqlist") 
		{
				//$marr=array("번호","제목","날짜");
				var marr=["seq","bbTitle"];		
				makelist(result, marr);

		}
	}

	
</script>

