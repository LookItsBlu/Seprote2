<?php
	session_start();

	require_once "bdd/BDD.php";

	if(isset($_POST['id_d'])) {
		$_SESSION['id_dep'] = $_POST['id_d'];

		$req_prog = $bdd->prepare("SELECT p.id_prog, p.prog_nom
								FROM programme p, prog_for pf, formation f, departement d
								WHERE p.id_prog=pf.id_prog
								AND pf.id_f=f.id_f
								AND f.id_d=d.id_d
								AND d.id_d=:id");
		$req_prog->bindValue(':id', $_POST['id_d']);
		$req_prog->execute();
		while($donnees = $req_prog->fetch()) {
			echo "<option value='".$donnees["id_prog"]."'>".$donnees["prog_nom"]."</option>";
		}
	}
	else {
		include('includes/header.php');

		if(!empty($_SESSION['id'])) { // On est connecté
		   include('includes/menu.php');
?>

<div id="main">
    <div class="mainWrap">
        <h1 class="bonjour">Bonjour, <?= htmlspecialchars($_SESSION['nom'])." ".htmlspecialchars($_SESSION['prenom']) ?>.</h1>
		<div id="breadcrumb"></div>
		<div id="dep">
			<span class="selectDepText">Choix du département: </span>
			<select class="selectDep">
				<option style="display:none"></option>
				<?php
					$req_dep = $bdd->prepare("SELECT d.id_d, d.nom_d
											FROM departement d, utilisateur u, util_dep ud
											WHERE u.id_u=ud.id_u
											AND ud.id_d=d.id_d
											AND u.id_u=:id");
					$req_dep->bindValue(':id', $_SESSION['id']);
					$req_dep->execute();
					while($donnees = $req_dep->fetch()){
						echo "<option value='".$donnees["id_d"]."'>".$donnees["nom_d"]."</option>";
					}
				?>
			</select>
		</div>
        <div id="hidden">
			<span class="selectProgText">Choix du programme: </span>
			<select class="selectProg">
				<option style="display:none"></option>

			</select>
		</div>
		<div id="hidden2">
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
					<div id="calendar">
					</div>
				</div>
			</div>
		</div>
    </div>
</div>

<script src="js/googlechart.js"></script>
<script>
	$(document).ready(function() {
		$("#hidden").hide();
		$("#hidden2").hide();
		$(".selectDep").change(function() {
			params = "id_d="+$(this).val();
			$.ajax({
				url: 'index.php',
				type: 'POST',
				data: params,
				success: function(data) {
					$("#hidden").show();
					$(".selectProg").append(data);
				}
			});
			return false;
		});
		$(".selectProg").change(function() {
			$("#dep").hide();
			$("#hidden").hide();
			$("#breadcrumb").html("<p><b>"+$(".selectDep").text()+"</b> > <b>"+$(".selectProg").text()+"</b> > Heures</p>");
			$("#hidden2").show();
		});
	});
</script>

<?php
		}
		else { header('Location: login.php'); }

		include('includes/footer.php');
	}
?>
