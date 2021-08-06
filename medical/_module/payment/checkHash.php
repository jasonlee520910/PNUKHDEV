<?php
	$message = $_POST["message"];
	$secretKey = $_POST["apiKey"];
	$hmac = hash_hmac('sha256', $message, $secretKey, true);
	$hashValue = base64_encode($hmac);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="ko" lang="ko" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<input type="text" id="checkHash" name="checkHash" value="<?=$hashValue?>"/>
</body>
</html>