<?php 
	session_start();
	include ( "functions.php" );
	$conn = oci_connect(DBUSER, DBPASSWORD, DBHOST);
	isLoggedIn( $conn );
	if(isAdmin() === true)
		require "adminheader.html";
	else
		require "header.html";
?>