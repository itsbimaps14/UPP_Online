<?php
	include 'inc.php';

	if (!isset($_SESSION['username'])) {
		header('location:login');
	}

	session_destroy();
	
	header('location:home');
?>