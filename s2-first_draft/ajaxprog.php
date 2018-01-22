<?php
session_start();
require_once('BDD.php');

$content = "<option value=''></option>";

if(isset($_POST["id_prog"]) && $_SESSION['role'] < 3){

	$req_semestre = $bdd->prepare("SELECT * FROM semestre WHERE id_prog=:id_prog");
	$req_semestre->execute(array("id_prog" => $_POST["id_prog"]));

	while($donnees = $req_semestre->fetch()){

		$content .= "<option value='".$donnees['id_s']."'>".$donnees["dat_deb_s"]." au ".$donnees["dat_fin_s"]."</option>";
	}

	echo $content;
}

?>
