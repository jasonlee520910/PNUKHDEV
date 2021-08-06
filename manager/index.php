<?php 
include_once("cmmInc/_define.php");
if($NetLive == "LOCAL")
{
	header ("Location:/01_Order/Order.php");
}
else
{
	// HTTPS 체크 및 URL 리턴
	if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) //true이면 https false이면 http
	{
		//header ("Location:/00_DashBoard/OrderDashBoard.php");
		header ("Location:/01_Order/Order.php");
	}
	else
	{
		header('Location: https://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI']);
	}
}
?>