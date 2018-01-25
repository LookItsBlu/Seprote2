<?php
session_start();
require_once('../BDD.php');

if(isset($_POST['id_per']) && isset($_POST['id_mod']) && $_SESSION['role'] < 3){

	$req = $bdd->prepare("INSERT INTO per_mod VALUES(:id_per,:id_mod)");
	$req->execute(array("id_per" => $_POST['id_per'] , "id_mod" => $_POST['id_mod']));
}
	echo true;
?>
