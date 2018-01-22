<?php
session_start();
require_once('BDD.php');

$content = "<option value=''></option>";

if(isset($_POST['date_d']) && isset($_POST['date_fin']) && $_SESSION['role'] < 3){

	$req = $bdd->prepare("INSERT INTO annee(dat_deb_a,dat_fin_a) VALUES(:date_d,:date_fin)");
	$req->execute(array("date_d" => $_POST['date_d'], "date_fin" => $_POST['date_fin']));
	$id_a = $bdd->lastInsertId();

}
	echo("<option value='". $id_a ."'>". $_POST["date_d"]. " au " . $_POST["date_fin"] ."</option>");
?>
