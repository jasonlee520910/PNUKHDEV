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

		if(isEmpty(seq))
		{
			//방제사전 
			$("#listdiv").load("<?=$root?>/Skin/Dictionary/FormularyList.php",function(){
				getlist(search,seq);
			});
		}
		else
		{
			console.log("seq >>>"+seq);
			$("#listdiv").load("<?=$root?>/Skin/Dictionary/FormularyDeatil.php?seq="+seq,function(){
				getlist(search,seq);
			});
		}
	}

	function changeno(text)
	{
		var orderby="";
		var changeno=$("input[name=changeno]").val(); 
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
		callapi("GET","/medical/recipe/",getdata("uniquesclist")+"&orderby="+orderby);
	}

	function getlist(search,seq)
	{
		
		if(!isEmpty(seq))
		{
			callapi("GET","/medical/recipe/",getdata("uniquescdesc"));
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
			//$("input[name=searchTxt]").removeClass("ajaxdata");
			//alert(getdata("uniquesclist")+"&orderby="+orderby);
			callapi("GET","/medical/recipe/",getdata("uniquesclist")+"&orderby="+orderby);
			//callapi("GET","/medical/recipe/",getdata("uniquesclist")+"&orderby="+orderby);
		}
	}

	function viewdesc(seq){
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

		if(obj["apiCode"]=="uniquesclist")  
		{
			//$marr=array("번호","처방명","약재정보","효능");
			var marr=["no","rcTitle","rcMedicine","RCEFFICACY"];
			makelist(result, marr);
		}
		else if(obj["apiCode"]=="uniquescdesc")  
		{
			$("#rcTitle").text(obj["rcTitlekor"]); //방제명

			$("#rcSource").text(obj["rcSource"]);  //출전
			$("#rcType").text(obj["rcType"]);  //제형
			$("#rcEfficacy").text(obj["rcEfficacy"]);  //효능

			var txt="";
			var i=1;
			$.each(obj["rcMedicine"],function(idx, val){
				/*
				txt+="<tr>";
				txt+="<td>2</td>";
				txt+="<td class='td-txtLeft'>인삼 人蔘</td>";
				txt+="<td>1돈 /  4.0g</td>";
				txt+="</tr>";
				*/
				txt+="<tr>";
				txt+="<td>"+i+"</td>";
				txt+="<td class='td-txtLeft'>"+val["title"]+"</td>";
				txt+="<td>"+val["value"]+" /  "+val["capa"]+"</td>";
				txt+="</tr>";

				i++;
			});
			$("#rcMedicine").html(txt);  //약재구성

		}
	}

	
	$("input[name=search]").focus();
</script>

<?php
   include_once $root."/_Inc/tail.php"; ?>
