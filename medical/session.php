<?php
	include_once "_Inc/_session.php";

	$type=$_GET["type"];

	if($type=="logout")
	{
		//$_SESSION["ss_Seq"]="";
		//$_SESSION["ss_meUserId"]="";
		
		$_SESSION["ss_meSeq"]="";
		$_SESSION["ss_meGrade"]="";
		$_SESSION["ss_meUserId"]="";
		$_SESSION["ss_meLoginid"]="";
		$_SESSION["ss_meName"]="";
		$_SESSION["ss_miUserid"]="";
		$_SESSION["ss_miName"]="";	
		$_SESSION["ss_miRegistNo"]="";	
		$_SESSION["ss_meStatus"]="";	
		$_SESSION["ss_miStatus"]="";	

		//unset($_SESSION["ss_Seq"]);
		//unset($_SESSION["ss_meUserId"]);
		unset($_SESSION["ss_meSeq"]);
		unset($_SESSION["ss_meGrade"]);
		unset($_SESSION["ss_meUserId"]);
		unset($_SESSION["ss_meLoginid"]);
		unset($_SESSION["ss_meName"]);
		unset($_SESSION["ss_miUserid"]);
		unset($_SESSION["ss_miName"]);
		unset($_SESSION["ss_miRegistNo"]);
		unset($_SESSION["ss_meStatus"]);
		unset($_SESSION["ss_miStatus"]);
		session_destroy();
			echo "/";
	}
	else
	{
		//$_SESSION["ss_Seq"]=$_GET["seq"];
		//$_SESSION["ss_meUserId"]=$_GET["userid"];

		$_SESSION["ss_meSeq"]=$_GET["seq"];
		$_SESSION["ss_meGrade"]=$_GET["meGrade"];  
		$_SESSION["ss_meUserId"]=$_GET["meUserId"]; 
		$_SESSION["ss_meLoginid"]=$_GET["meLoginid"];
		$_SESSION["ss_meName"]=$_GET["meName"]; 
		$_SESSION["ss_miUserid"]=$_GET["miUserid"];  
		$_SESSION["ss_miName"]=$_GET["miName"]; 
		$_SESSION["ss_miRegistNo"]=$_GET["miRegistNo"]; 
		$_SESSION["ss_meStatus"]=$_GET["meStatus"];  
		$_SESSION["ss_miStatus"]=$_GET["miStatus"];  

		if($_SESSION["ss_meSeq"])
		{
			echo $_GET["url"];
			//echo "/";
		}
	}
?>


