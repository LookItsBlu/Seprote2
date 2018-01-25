<?php
session_start();
require_once('../BDD.php');

$content = "<option value=''></option>";

if(isset($_POST["prog"]) && $_SESSION['role'] < 3){

	$req_semestre = $bdd->prepare("SELECT DISTINCT m.id_m, m.code_m, m.nom_m  FROM module as m INNER JOIN per_mod as pm ON m.id_m = pm.id_mod INNER JOIN periode as p ON p.id_p = pm.id_per INNER JOIN per_sem as ps ON p.id_p = ps.id_per INNER JOIN semestre as s ON s.id_s = ps.id_sem INNER JOIN programme as pg ON pg.id_prog =  s.id_prog WHERE pg.id_prog = :id_prog");
	$req_semestre->execute(array("id_prog" => $_POST["prog"]));

	while($donnees = $req_semestre->fetch()){

		$content .= "<option value='".$donnees['id_m']."'>".$donnees["code_m"]." ".$donnees["nom_m"]."</option>";
	}

	echo $content;
}

?>
