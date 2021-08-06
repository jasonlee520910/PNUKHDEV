<?php
include_once("_Inc/_define.php");
$depart=$_GET["depart"];
if($NetLive == "LOCAL")
{
	if($depart)
	{
		header ("Location:/".$depart."");
	}
	else
	{
		header ("Location:".$NET_URL_MEMBER);
	}
}
else
{
	// HTTPS 체크 및 URL 리턴
	if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) //true이면 https false이면 http
	{
		if($depart)
		{
			header ("Location:/".$depart."");
		}
		else
		{
			header ("Location:".$NET_URL_MEMBER);
		}		
	}
	else
	{
		if($depart)
		{
			header('Location: https://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']."/");
		}
		else
		{
			header('Location: '.$NET_URL_MEMBER);
		}
	}
}
?>
