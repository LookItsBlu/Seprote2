<?php
session_start();
require_once "../bdd/BDD.php";


if(isset($_POST['type'])){

	if($_POST['type'] == "create_for"){

		if(isset($_POST['nom_for']) && isset($_POST['annee'])){

			$req = $bdd->prepare("INSERT INTO formation(nom_f) VALUES(:nom_for)");
			$req->execute(array("nom_for" => $_POST['nom_for']));


			$id_for = $bdd->lastInsertId();
			$req = $bdd->prepare("INSERT INTO for_annee VALUES(:id_for,id_anne)");
			$req->execute(array("id_for" => $id_for, "id_annee" => $_POST['annee']));

			header('Location: gestion_programme.php');
		}

		else{header('Location: index.php');}

	}


	elseif ($_POST['type'] == "create_annee") {

		if(isset($_POST['date_d']) && isset($_POST['date_fin'])){

			$req = $bdd->prepare("INSERT INTO annee(dat_deb_a,dat_fin_a) VALUES(:date_d,:date_fin)");
			$req->execute(array("date_d" => $_POST['date_d'], "date_fin" => $_POST['date_fin']));

			header('Location: gestion_programme.php');

		}

		else{header('Location: index.php');}
	}
}

else{ header('Location: index.php');}
?>
