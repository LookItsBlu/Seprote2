<?php
	session_start();
	require_once "bdd/BDD.php";

	include('includes/header.php');

	if(empty($_SESSION['id'])) // On n'est pas connecté
		header('Location: login.php');
	else
	   include('includes/menu.php');
?>

<div id="main">
    <div class="mainWrap">
        <h1 class="bonjour">Bonjour, <?= htmlspecialchars($_SESSION['nom'])." ".htmlspecialchars($_SESSION['prenom']) ?> !</h1>
		<div id="dep">
			<span class="selectDepText">Choix du département: </span>
			<select class="selectDep"></select>
		</div>
		<span class="selectProgText">Choix du programme: </span>
		<select class="selectProg">
			<option disabled selected>Veuillez Choisir un programme</option>
		</select>
		<div id="content">
			<div id="left">
				<div class="center">
					<div id="chart"></div>
					<div class="selection">
						<button class="tabBtn">Tableau</button>
						<button class="pieBtn">Circulaire</button>
						<button class="barBtn">Barres</button>
					</div>
				</div>
			</div>
			<div id="right">
				<div id="calendar"></div>
			</div>
		</div>
    </div>
</div>
<script src="js/googlechart.js"></script>
<script src="js/index.js"></script>

<?php include('includes/footer.php'); ?>
