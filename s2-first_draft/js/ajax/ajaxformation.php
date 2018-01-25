<<?php
session_start();
require_once('../BDD.php');

$content = "<option value=''></option>";

if(isset($_POST['nom_for']) && isset($_POST['id_a'])  && isset($_POST['group_td'])  && isset($_POST['group_tp']) && $_SESSION['role'] < 3){

			$req = $bdd->prepare("INSERT INTO formation(nom_f,group_td,group_tp) VALUES(:nom_for, :group_td, :group_tp)");
			$error = $req->execute(array("nom_for" => $_POST['nom_for'], "group_td" => $_POST["group_td"], "group_tp" => $_POST['group_tp']));


			$id_for = $bdd->lastInsertId();
			$req = $bdd->prepare("INSERT INTO for_annee VALUES(:id_for,:id_annee)");
			$req->execute(array("id_for" => $id_for, "id_annee" => $_POST['id_a']));

}

	echo("<option value='". $id_for ."'>". $_POST["nom_for"]."</option>");
?>
