<?php

session_start();
require_once "BDD.php";

include('header.php');
?>
		<div id="header">
			<div class="wrap">
			<img class="seprote" src="src/seprote.png" alt="Seprote"/>
			</div>
			<img class="iutCB" src="src/iutCB.png" alt="IUT Calais Boulogne"/>
		</div>
<?php
include('menu.php');
include('footer.php');
?>
