<?php
	$root="..";
	include_once $root."/_Inc/head.php";
?>
<div id="listdiv"></div>
<input type="hidden" name="changeno" value="0">

<script>
	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage();
	}
	
	viewpage();  //첫페이지

	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		var seq=hdata[1];
		var search=!isEmpty(hdata[3])?hdata[3]:"";

		if(seq==undefined || seq=="")
		{
			//본초사전 
			$("#listdiv").load("<?=$root?>/Skin/Dictionary/HerbList.php",function(){
				getlist(search,seq);
			});
		}
		else
		{
			$("#listdiv").load("<?=$root?>/Skin/Dictionary/HerbDeatil.php?seq="+seq,function(){
				getlist(search,seq);
			});
		}
	}

	function changeno(text)
	{
		var orderby="";
		var changeno=$("input[name=changeno]").val(); 
		console.log("changeno   >>>> "+changeno);
		if(changeno=="0")
		{
			orderby="DESC";
			$("input[name=changeno]").val("1");			
			$("#arrowDiv").text("▼");
		}
		else
		{	
			orderby="ASC";
			$("input[name=changeno]").val("0");		
			$("#arrowDiv").text("▲");
		}
		callapi("GET","/medical/medicine/",getdata("hublist")+"&orderby="+orderby);
	}

	function getlist(search,seq)
	{

		if(!isEmpty(seq))
		{
			callapi("GET","/medical/medicine/",getdata("hubdesc"));
		}
		else
		{
			var changeno=$("input[name=changeno]").val(); 
			if(changeno=="0")
			{

				orderby="ASC";
				$("input[name=changeno]").val("0");	
				$("#arrowDiv").text("▲");
			}
			else
			{	
				orderby="DESC";
				$("input[name=changeno]").val("1");
				$("#arrowDiv").text("▼");
			}
			//search="sdate=&edate=&"+search;
			var sear=searchdata(search);
			//callapi("GET","/medical/medicine/",getdata("hublist")+"&orderby="+orderby+sear);
			callapi("GET","/medical/medicine/",getdata("hublist")+"&orderby="+orderby);
		}
	}

	function viewdesc(seq)
	{	
		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		if(page==undefined){page="";}
		var search=hdata[2];
		if(search ===undefined){search="";}
		makehash(page,seq,search);
	}

	function viewlist(){
		var hdata=location.hash.replace("#","").split("|");
		var page=hdata[0];
		if(page==undefined){page="";}
		var seq="";
		var search=hdata[2];
		if(search ===undefined){search="";}
		makehash(page,seq,search)
	}

	function makepage(result)
	{
		var obj = JSON.parse(result);
		console.log(obj);
		console.log("apiCode>>>>> "+obj["apiCode"]);

		if(obj["apiCode"]=="hublist")  
		{
			//$marr=array("번호","본초명","설명","이명","교과서분류");
			var marr=["no","mhTitle","mhRedefinition","mhDtitleKor","mhOrigin"];		
			makelist(result, marr);
		}
		else if(obj["apiCode"]=="hubdesc")  
		{
			$("#mhTitle").text(obj["mhTitle"]); 
			$("#mhDtitleKor").text(obj["mhDtitleKor"]); 
			$("#mhTitleChn").text(obj["mhTitleChn"]); 
			$("#mhTitleEng").text(obj["mhTitleEng"]); 
			$("#mhRedefinition").text(obj["mhRedefinition"]); 
			$("#mhEfficacyKor").text(obj["mhEfficacyKor"]);  //효능
			$("#mhDescKor").text(obj["mhDescKor"]);  ///주치
			$("#mhCautionKor").text(obj["mhCautionKor"]);  ///금기
		}
	}

	
	$("input[name=search]").focus();
</script>

<?php
   include_once $root."/_Inc/tail.php"; ?>
