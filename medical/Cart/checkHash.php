<?php
	$message = $_POST["message"];
	$secretKey = $_POST["apiKey"];
	$hmac = hash_hmac('sha256', $message, $secretKey, true);
	$hashValue = base64_encode($hmac);
	echo $hashValue;
?>
