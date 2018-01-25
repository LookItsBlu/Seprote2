<?php
session_start();
require_once "../bdd/BDD.php";

if(!empty($_POST['nom']) && $_SESSION['role'] < 3){

	/*********** CREATION DU PROGRAMME ***********/

	if(!isset($_POST['ppn'])){

		$ppn = 0;
	}

	else{

		$ppn = 1;
	}

	if($_POST['ppn_relie'] != ""){
		$req_prog = $bdd->prepare("INSERT INTO programme(ppn,ppn_relie,prog_nom) VALUES(:ppn,:ppn_relie,:prog_nom)");
		$req_prog->execute(array("ppn" => $ppn, "ppn_relie" => intval($_POST['ppn_relie']), "prog_nom" => $_POST['nom']));
	}

	else{
		$req_prog = $bdd->prepare("INSERT INTO programme(ppn,prog_nom) VALUES(:ppn,:prog_nom)");
		$req_prog->execute(array("ppn" => $ppn, "prog_nom" => $_POST['nom']));
	}

	/************* RATTACHEMENT DU PROGRAMME A LA FORMATION *************/

		$id_prog = $bdd->lastInsertId("programme_id_prog_seq");
		$req_prog_for = $bdd->prepare("INSERT INTO prog_for VALUES (:id_prog,:id_for)");
		$req_prog_for->execute(array('id_prog' => $id_prog['max'], "id_for" => intval($_POST['formation'])));

	/************* CREATION DES SEMESTRES *********/


	/*** SEMESTRE 1 ***/
	$req_sem1 = $bdd->prepare("INSERT INTO semestre(dat_deb_s,dat_fin_s,id_prog) VALUES(:dat_deb_s,:dat_fin_s,:id_prog)");
	$req_sem1->execute(array('dat_deb_s' => $_POST['sem1_deb'] , 'dat_fin_s' => $_POST['sem1_fin'], 'id_prog' => $id_prog ));
	$id_sem1 = $bdd->lastInsertId("semestre_id_s_seq");

	/*** SEMESTRE 2 ***/
	$req_sem2 = $bdd->prepare("INSERT INTO semestre(dat_deb_s,dat_fin_s,id_prog) VALUES(:dat_deb_s,:dat_fin_s,:id_prog)");
	$req_sem2->execute(array('dat_deb_s' => $_POST['sem2_deb'] , 'dat_fin_s' => $_POST['sem2_fin'], 'id_prog' => $id_prog ));
	$id_sem2 = $bdd->lastInsertId("semestre_id_s_seq");


	/************ CREATION DES PERIODES **********/

	$tab_fin_preriode_sem1 = $_POST['p_fin_sem1'];
	$tab_fin_preriode_sem2 = $_POST['p_fin_sem2'];

	/*** PERIODE(S) DU SEMESTRE 1 ***/

	foreach($_POST['p_deb_sem1'] as $index => $date_deb){

		$req_p_sem1 = $bdd->prepare("INSERT INTO periode(dat_deb_p,dat_fin_p) VALUES(:dat_dep_p,:dat_fin_p) ");
		$req_p_sem1->execute(array('dat_dep_p' => $date_deb , 'dat_fin_p' => $tab_fin_preriode_sem1[$index]));

		$id_periode = $bdd->lastInsertId("periode_id_p_seq");
		$req_per_sem = $bdd->prepare("INSERT INTO per_sem(id_per,id_sem) VALUES(:id_per,:id_sem)");
		$req_per_sem->execute(array('id_per' => $id_periode , 'id_sem' => $id_sem1 ));
	}

	/*** PERIODE(S) DU SEMESTRE 2 ***/

	foreach($_POST['p_deb_sem2'] as $index => $date_deb){

		$req_p_sem1 = $bdd->prepare("INSERT INTO periode(dat_deb_p,dat_fin_p) VALUES(:dat_dep_p,:dat_fin_p) ");
		$req_p_sem1->execute(array('dat_dep_p' => $date_deb , 'dat_fin_p' => $tab_fin_preriode_sem2[$index]));

		$id_periode = $bdd->lastInsertId("periode_id_p_seq");
		$req_per_sem = $bdd->prepare("INSERT INTO per_sem(id_per,id_sem) VALUES(:id_per,:id_sem)");
		$req_per_sem->execute(array('id_per' => $id_periode , 'id_sem' => $id_sem2 ));
	}

	header('Location: gestion_programme.php');
}

else{

	header('Location: index.php');
}

?>
