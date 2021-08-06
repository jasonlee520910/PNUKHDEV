<?php
	include_once $root.$folder."/_common/db/db.lib.php";
	include_once $root.$folder."/_common/db/db.info.php";

	$select_db = dbconn($mysql_host, $mysql_user, $mysql_password, $mysql_db);
	if (!$select_db)die("<script>alert('MANAGER SERVER ERROR')</script>");

?>
