<?php 

	clearstatcache();

	$filename=$_REQUEST["filename"];
	$save_dir=$_REQUEST["imgurl"];
	$size=$_REQUEST["imgsize"];

	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$filename."");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".$size);
	header("Cache-Control: cache, must-revalidate");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	$fp = fopen($save_dir, "r");
	fpassthru($fp);
	fclose($fp);

	exit;

?>