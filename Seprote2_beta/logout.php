<?php

	session_start();

	unset($_SESSION['id']);
	unset($_SESSION['nom']);
	unset($_SESSION['prenom']);

	session_destroy();

	header('Location: login.php');
?>
