<?php
session_start();
require_once('../BDD.php');

if(isset($_POST['nom_mod']) && isset($_POST['code_mod']) && isset($_POST['cm_g']) && isset($_POST['td_g']) && isset($_POST['tp_g']) && $_SESSION['role'] < 3){

	$req = $bdd->prepare("INSERT INTO module(nom_m,code_m,cm_g,td_g,tp_g) VALUES(:nom_mod,:code_mod,:cm_g,:td_g,:tp_g)");
	$req->execute(array("nom_mod" => $_POST['nom_mod'] , "code_mod" => $_POST['code_mod'] , "cm_g" => $_POST['cm_g'] , "td_g" => $_POST['td_g'] , "tp_g" => $_POST['tp_g']));
	$id_mod = $bdd->lastInsertId();

}
	echo("<option value='". $id_mod ."'>". $_POST["code_mod"]. " " . $_POST['nom_mod'] ."</option>");
?>
