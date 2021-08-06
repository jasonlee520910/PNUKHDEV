<?php
	$root="..";
	include_once $root."/_Inc/head.php";
?>
<div id="listdiv"></div>
<input type="hidden" name="medicalid" class="ajaxdata" value="<?=$_COOKIE["ck_miUserid"]?>">

<script>
	function getlist()
	{	
		callapi("GET","/medical/member/",getdata("mydoctorlist"));	
	}

	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage();
	}
	
	viewpage();  //첫페이지

	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		var search=!isEmpty(hdata[3])?hdata[3]:"";

		//처방기록  
		$("#listdiv").load("<?=$root?>/Skin/Member/Mydoctor.php",function(){
			getlist();
		});
	}

</script>

<?php
   include_once $root."/_Inc/tail.php"; ?>

<script>

	//대표한의사가 소속한의사를 등록하기
	function invitedoctor()
	{
		//라디오박스 값 가져오기
		if(ajaxnec()=="Y")
		{
			if(confirm("한의사 등록을 하시겠습니까?"))
			{
				callapi("POST","/medical/member/",getdata("invitedoctorupdate"));			
			}
		} 
	}

	function goApproval(seq,status)
	{
		console.log("seq   >>>>>>>>>>"+seq);
		console.log("status   >>>>>>>>>>"+status);

		if(status=="request") //승인요청
		{
			if(confirm("요청을 취소 하시겠습니까?"))
			{	
				callapi("POST","/medical/member/",getdata("mydoctorupdate")+"&status="+status+"&seq="+seq);//내정보 수정하기
				location.reload();
			}

		}
		else if(status=="standby")
		{
			if(confirm("소속한의사로 승인하시겠습니까?"))
			{
				callapi("POST","/medical/member/",getdata("mydoctorupdate")+"&status="+status+"&seq="+seq);	
				location.reload();
			}	
		}
		else if(status=="confirm")
		{
			if(confirm("소속한의사를 삭제하시겠습니까?"))
			{
				callapi("POST","/medical/member/",getdata("mydoctorupdate")+"&status="+status+"&seq="+seq);
				location.reload();
			}
		}
	}

   	function makepage(result)
	{		
		var obj = JSON.parse(result);
		console.log(obj);
		console.log("apiCode>>>>> "+obj["apiCode"]);

		if(obj["apiCode"]=="mydoctorlist")  //나의 소속 한의사 리스트
		{
			//$marr=array("등록일","면허번호","한의사명","휴대전화","이메일","상태");
			var marr=["meDate","meRegistno","meName","meMobile","meEmail","statusBtn","doBtn"];	
			makelist(result, marr);
		}
		else if(obj["apiCode"]=="invitedoctorupdate")  //post라서 여기로 안온다. js  보기
		{
			if(obj["resultCode"]=="200")
			{
				alert("한의사가 등록되었습니다");		
				location.reload();
			}
			else if(obj["resultCode"]=="204")
			{
				alert("한의사가 등록되지않았습니다. 다시 확인해주세요");		
				
			}	
		}
	}
</script>