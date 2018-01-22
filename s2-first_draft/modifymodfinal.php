<?php
session_start();
require_once('BDD.php');


if(isset($_POST['id_m']) && isset($_POST['code_m']) && isset($_POST['cm_g']) && isset($_POST['td_g']) && isset($_POST['tp_g'])){

	$req = $bdd->prepare("UPDATE module SET id_m = :id_m , code_m = :code_m , cm_g = :cm_g , td_g = :td_g , tp_g = :tp_g");
	$req->execute(array("id_m" => $_POST["id_mod"], "code_m" => $_POST["code_m"], "cm_g" => $_POST["cm_g"] , "td_g" => $_POST["td_g"] , "tp_g" => $_POST["tp_g"]));

}

	echo true;
?>
