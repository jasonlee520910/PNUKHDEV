<?php
	$root="..";
	include_once $root."/_Inc/head.php";
?>
<div id="listdiv"></div>
<script>
	function getlist()
	{
		callapi("GET","/medical/policy/",getdata("policydesc"));
	}

	//해시값이 바뀌면 
	window.onhashchange = function(e) {
		viewpage();
	}
	
	viewpage();  //첫페이지

	function viewpage()
	{
		var hdata=location.hash.replace("#","").split("|");
		$("#listdiv").load("<?=$root?>/Skin/Policy/Policy.php",function(){
			getlist();
		});//개인정보처리방침  
	}

</script>

<?php   include_once $root."/_Inc/tail.php"; ?>

<script>
	function gohref(url){
		if(url.indexOf(".php")>-1 || url.indexOf(".html")>-1){
			location.href=url;
		}else{
			//location.href=url;
			//download(url);
		}
	}

	function nl2br(str){  
		return str.replace(/\n/g, "<br />");  
	}  

	function viewContents(type, contents)
	{
		var jsContents=JSON.parse(contents);
		var data="";

		data+="<table class='subtbl'>";
		var i=0;
		var subdat=colper="";
		for(var rows in jsContents)
		{
			if(i>0)subdat+="<tr>";
			for(var cols in jsContents[rows])
			{
				if(i==0){
					colper+="<col style='width:"+jsContents[rows][cols]+"%'>";
				}else if(i==1){
					subdat+="<th>"+jsContents[rows][cols]+"</th>";
				}else{
					subdat+="<td>"+jsContents[rows][cols]+"</td>";
				}
			}
			if(i>0)subdat+="</tr>";
			i++;
		}
		data+=colper+subdat+"</table>";

		return data;
	}
	function makepage(result)
	{
		var obj = JSON.parse(result);
		console.log(obj);
		if(obj["apiCode"]=="policydesc")
		{
			var data = "";
			$("#poContentsDiv").html("");
			if(!isEmpty(obj["policy"]))
			{
				$(obj["policy"]).each(function( index, value )
				{
					if(value["poType"]==700){
						data+=viewContents(value["poType"], value["poContents"]);
					}else if(value["poType"]==600){
						data+="<span class='p"+value["poType"]+"' onclick=\"gohref('"+value["poLink"]+"')\">"+nl2br(value["poContents"])+"</span>";
					}else{
						data+="<p class='p"+value["poType"]+"'>"+nl2br(value["poContents"])+"</p>";
					}
				});
			}
			else
			{
				//data+="<tr>";
				//data+="<td><?=$txtdt['1665']?></td>";   //데이터가 없습니다.
				//data+="</tr>";
			}
			$("#poContentsDiv").html(data);

		}
	}
</script>
