<?php
	include_once("_Inc/_session.php");

	$type=$_GET["type"];

	if($type=="logout")
	{
		$_SESSION["ss_seq"]="";
		$_SESSION["ss_userid"]="";
		$_SESSION["ss_name"]="";
		$_SESSION["ss_staffid"]="";
		$_SESSION["ss_auth"]="";
		$_SESSION["ss_depart"]="";
		$_SESSION["ss_login"]="";
		$_SESSION["ss_authkey"]="";
		session_destroy();
		echo $_GET["url"];
	}
	else
	{
		$_SESSION["ss_seq"]=$_GET["seq"];
		$_SESSION["ss_userid"]=$_GET["stUserid"];
		$_SESSION["ss_name"]=$_GET["stName"];
		$_SESSION["ss_staffid"]=$_GET["stStaffid"];
		$_SESSION["ss_auth"]=$_GET["stAuth"];
		$_SESSION["ss_depart"]=$_GET["stDepart"];
		$_SESSION["ss_login"]=$_GET["stLogin"];
		$_SESSION["ss_authkey"]=$_GET["stAuthKey"];
		

		if($_SESSION["ss_seq"])
		{
			echo $_GET["url"];
		}
	}
?>
