<?php
session_start();
require_once('BDD.php');


$json = array();
$info_programme = array();
$info_formation = array();
$info_semestre = array();


if(isset($_POST['id_prog']) && $_SESSION['role'] < 3){

	//$req = $bdd->prepare("SELECT * FROM programme as p INNER JOIN prog_for as pf ON pf.id_prog = p.id_prog INNER JOIN semestre as s ON s.id_prog = p.id_prog INNER JOIN per_sem as ps ON ps.id_sem = s.id_s INNER JOIN periode as per ON per.id_p = ps.id_per WHERE p.id_prog = :id_prog ORDER BY id_sem ASC, id_per ASC");
	$req = $bdd->prepare("SELECT * FROM programme WHERE id_prog = :id_prog");
	$req->execute(array("id_prog" => $_POST["id_prog"]));


	while($donnees = $req->fetch()){

		$info_programme = array('id_prog' => $donnees["id_prog"] , 'prog_nom' => $donnees["prog_nom"], 'ppn' => $donnees["ppn"], 'ppn_relie' => $donnees["ppn_relie"] );

	}

	$req = $bdd->prepare("SELECT * FROM prog_for WHERE id_prog = :id_prog");
	$req->execute(array("id_prog" => $_POST["id_prog"]));

	while($donnees = $req->fetch()){

		$info_formation = array('id_for' => $donnees["id_for"]);

	}

	$req = $bdd->prepare("SELECT * FROM semestre WHERE id_prog = :id_prog ORDER BY id_s ASC");
	$req->execute(array("id_prog" => $_POST["id_prog"]));

	while($donnees = $req->fetch()){

		array_push($info_semestre, array('id_s' => $donnees["id_s"], 'dat_deb_s' => $donnees['dat_deb_s'], 'dat_fin_s' => $donnees['dat_fin_s']));

	}


	array_push($json, $info_programme);
	array_push($json, $info_formation);
	array_push($json, $info_semestre);
}

	echo json_encode($json);
?>
