<?php
session_start();
require_once "BDD.php";

	if(isset($_POST["nom"]) && isset($_POST['id_prog_modif']) && $_SESSION['role'] < 3){
		if(!isset($_POST["ppn"])){

			$ppn = 0;
		} else{

			$ppn = 1;
		}

		if($_POST['ppn_relie'] == ''){

			$ppn_relie = 0;
		} else{

			$ppn_relie = 1;
		}




		if($ppn != 0){

			$req = $bdd->prepare("UPDATE programme SET ppn = :ppn, prog_nom = :prog_nom WHERE id_prog = :id_prog ");
			$req->execute(array("ppn" => $ppn, "prog_nom" => $_POST["nom"] , "id_prog" => $_POST['id_prog_modif'] ));
		}

		elseif($ppn == 0 && $ppn_relie == 1){

			$req = $bdd->prepare("UPDATE programme SET ppn = :ppn, prog_nom = :prog_nom, ppn_relie = :ppn_relie WHERE id_prog = :id_prog ");
			$req->execute(array("ppn" => $ppn, "prog_nom" => $_POST["nom"] , "id_prog" => $_POST['id_prog_modif'], "ppn_relie" => $_POST['ppn_relie']));
		}

		elseif($ppn == 0 && $ppn_relie == 0){

			$req = $bdd->prepare("UPDATE programme SET ppn = :ppn, prog_nom = :prog_nom, ppn_relie = :ppn_relie WHERE id_prog = :id_prog ");
			$req->execute(array("ppn" => $ppn, "prog_nom" => $_POST["nom"] , "id_prog" => $_POST['id_prog_modif'], "ppn_relie" => null));
		}


		$req = $bdd->prepare("UPDATE semestre SET dat_deb_s = :dat_deb_s, dat_fin_s = :dat_fin_s WHERE id_s = :id_s");
		$req->execute(array('dat_deb_s' => $_POST['sem1_deb'], 'dat_fin_s' => $_POST["sem1_fin"], 'id_s' => $_POST["id_sem1"] ));

		$req = $bdd->prepare("UPDATE semestre SET dat_deb_s = :dat_deb_s, dat_fin_s = :dat_fin_s WHERE id_s = :id_s");
		$req->execute(array('dat_deb_s' => $_POST['sem2_deb'], 'dat_fin_s' => $_POST["sem2_fin"], 'id_s' => $_POST["id_sem2"] ));

		header("Location: gestion_programme.php");
	}

	else{ header("Location: index.php");}
?>
