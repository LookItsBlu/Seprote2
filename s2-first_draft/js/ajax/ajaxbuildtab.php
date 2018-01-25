<?php
	session_start();
	require_once "../BDD.php";

	if(isset($_POST['id_m']) && $_SESSION['role'] < 3){
		$req  = $bdd->prepare("SELECT * FROM volume_horaire INNER JOIN utilisateur ON id_utilisateur = id_u  WHERE id_module = :mod");
		$req->execute(array('mod' => $_POST['id_m']));


		$content = " <h1>Récapitulatif des heures</h1><table><tr><th>Nom</th><th>Prénom</th><th>CM atribuées</th><th>TD atribuées</th><th>TP atribuées</th></tr>";

		while($donnees = $req -> fetch()){

			$content .= "<tr><td>".$donnees["nom"]."</td><td>".$donnees["prenom"]."</td><td>".$donnees["cm"]."</td><td>".$donnees["td"]."</td><td>".$donnees["tp"];
		}

		$content .= "</table>";

		echo $content;
	}
?>
