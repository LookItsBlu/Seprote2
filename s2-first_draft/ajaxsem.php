<?php
session_start();
require_once('BDD.php');

$content = "<option value=''></option>";

if(isset($_POST["id_sem"]) && $_SESSION['role'] < 3){


	$requete_periode = $bdd->prepare("SELECT * FROM per_sem AS ps INNER JOIN periode AS p ON ps.id_per = p.id_p WHERE ps.id_sem = :id_sem");
	$requete_periode->execute(array("id_sem" => $_POST["id_sem"]));

	while($donnees = $requete_periode->fetch()){

		$content .= "<option value='".$donnees['id_p']."'>".$donnees["dat_deb_p"]." au ".$donnees["dat_fin_p"]."</option>";
	}

	echo $content;
}

?>
