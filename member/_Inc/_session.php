<?php
	ini_set('session.cookie_domain', $NET_DOMAIN ); 
	session_set_cookie_params( 43200, "/", $NET_DOMAIN, false, false); 
	session_start();
?>
