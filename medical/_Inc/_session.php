<?php
	ini_set('allow_url_fopen',1);
	ini_set('session.cookie_domain', $NET_DOMAIN );
	session_set_cookie_params(3600 , "/", $NET_DOMAIN, false, false); 
	session_start();
?>
