<?php
session_start();
require_once('BDD.php');

$json = array();

if(isset($_POST["id_mod"]) && $_SESSION['role'] < 3){

	$req = $bdd->prepare("SELECT * FROM module WHERE id_m=:id_m");
	$req->execute(array("id_m" => $_POST["id_mod"]));
	$donnees = $req->fetch();
	$donnees = array('nom_m' => $donnees["nom_m"], 'code_m' => $donnees["code_m"] , 'cm_g' => $donnees["cm_g"] , 'td_g' => $donnees["td_g"] , 'tp_g' => $donnees["tp_g"]);

	array_push($json, $donnees);
}

	echo json_encode($json);
?>
