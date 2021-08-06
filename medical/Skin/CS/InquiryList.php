<?php
	$root="../..";
	include_once $root."/_common.php";
?>

<input type="hidden" name="medicalid" class="ajaxdata" value="<?=$_COOKIE["ck_miUserid"]?>">
<div class="container">
    <div class="sub customer-service inquiry board-cont-none">
        <div class="sub__title sub__title--tab d-flex">
            <div class="wrap d-flex">
                <h2>고객센터</h2>
                <div class="tab d-flex">
                    <?=viewcstab("inquiry");?>
                </div>
            </div>
        </div>
        <div class="sub__content">
            <div class="sub__section">
                <div class="wrap">
                    <div class="btnBox d-flex topBtn">
                        <a href="javascript:;" class="d-flex btn btn--small border-rightGray color-gray" onclick="viewdesc('add'); return false;">1:1 문의하기</a>
                    </div>
					<div class="pm__item">
							<?php								
								$carr=array(10,"*",10,10);
								$marr=array("문의유형","제목","문의날짜","답변상태");
								echo tblinfo($carr, $marr);
							?>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
	function getlist()
	{
		callapi("GET","/medical/cs/",getdata("qnalist"));
	}

	function viewdesc(seq)
	{	
		
		
		if(seq=="add")
		{
			
			$("#listdiv").load("<?=$root?>/Skin/CS/InquiryWrite.php");//탕전처방 
		}
		else
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
	}


	/*
	{
		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		if(page==undefined){page="";}
		var search=hdata[2];
		if(search ===undefined){search="";}
		makehash(page,seq,search)
	}
	*/

	function makepage(result)
	{		
		var obj = JSON.parse(result);
		console.log(obj);
		console.log("apiCode>>>>> "+obj["apiCode"]);

		if(obj["apiCode"]=="qnalist")  
		{
			//$marr=array("문의유형","제목","문의날짜","답변상태","");
			var marr=["seq","bbTitle","bbIndate","bbAnswer"];		
			makelist(result, marr);
		}
	}

	
</script>