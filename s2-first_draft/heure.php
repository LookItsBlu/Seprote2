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

?>

	<form>
		<label>Choix du module: </label><select name="module" id="mod">
			<?php
				$req = $bdd->prepare("SELECT * FROM module");
				$req->execute();
				while($res = $req->fetch()){
					echo "<option value='".$res['id_m']."'>".$res['code_m']." : ".$res['nom_m']."</option>";
				}

			?>
		</select>
		<br>
		<label>Choix du professeur: </label> <select name="prof" id="prof">
			<?php
				$req = $bdd->prepare("SELECT * FROM utilisateur");
				$req->execute();
				while($res = $req->fetch()){
					echo "<option value='".$res['id_u']."'>".$res['nom']." ".$res['prenom']."</option>";
				}

			?>
		</select>

		<br>

		<?php
			echo "<label>Nombre d'heures CM: </label> <input type='text' name ='cm' id='cmm'/> <br/>";
			echo "<label>Nombre d'heures TD: </label> <input type='text' name ='td' id='tdd'/> <br/>";
			echo "<label>Nombre d'heures TP: </label> <input type='text' name ='tp' id='tpp'/> <br/>";
		?>

		<p>Nombre d'heures de CM restant: <span class="cm"></span></p>
		<p>Nombre d'heures de TD restant: <span class="td"></span></p>
		<p>Nombre d'heures de TP restant: <span class="tp"></span></p>
		<p>Total: <span class="total"></span></p>
	</form>


<?php

include('footer.php');
?>
