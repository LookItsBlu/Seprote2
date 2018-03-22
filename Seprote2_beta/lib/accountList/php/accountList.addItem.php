<?php
	include ('../../../bdd/BDD.php');

	$message = array();


	$req_identiq = $bdd->prepare('SELECT mail FROM utilisateur WHERE mail = :mail');
	$req_identiq->execute(array( 'mail' => $_POST['mail']));
	if($req_identiq->fetch()){
		$message = array(
			'title' => 'Compte déjà existant',
			'body' => "L'adresse mail entré est déjà utilisé par un autre compte, veuillez en utiliser une autre."
		);
	}

	else if(
		empty($_POST['nom']) || empty($_POST['prenom'])
		|| empty($_POST['mail']) || empty($_POST['mdp'])
	){
		$message = array(
			'title' => 'Champ(s) vide(s) !',
			'body' => 'Veuillez remplir tous les champs pour valider la création de ce compte.'
		);
	}

	else if(
		$_POST['id_role'] != 1 && $_POST['id_role'] != 2
		&& $_POST['id_role'] != 3 || empty($_POST['id_role'])
	) {
		$message = array(
			'title' => 'Id du rôle incorrect !',
			'body' => "Veuillez sélectionner l'un des rôles présents dans la liste."
		);
	}

	else if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
		$message = array(
			'title' => 'Adresse mail incorrecte !',
			'body' => 'Veuillez saisir une adresse e-mail conforme comme ci-contre : xx@xx.xx .'
		);
	}

	else if(strlen($_POST['mdp']) < 6){
		$message = array(
			'title' => 'Mot de passe trop court !',
			'body' => 'Veuillez saisir un mot de passe comportant au moins 6 caractères.'
		);
	}

	else{
	    $req_ajout = $bdd->prepare("
	    INSERT INTO utilisateur(nom,prenom,mail,id_role,mdp)
	    VALUES(:nom,:prenom,:mail,:id_role,:mdp)
	    ");
	    $req_ajout->execute(array(
	        'nom' => $_POST['nom'],
	        'prenom' => $_POST['prenom'],
	        'mail' => $_POST['mail'],
	        'id_role' => $_POST['id_role'],
	        'mdp' => sha1($_POST['mdp'])
	    ));

	    if(!$req_ajout){
			$message = array(
				'title' => 'Erreur du serveur !',
				'body' => 'Une erreur a eu lieu lors de la création de ce compte, veuillez réessayer ultérieurement.'
			);
	    } else{
			$message = array(
				'title' => 'Compte créé !',
				'body' => 'Le compte a été créé avec succès !',
				'type' => 'success'
			);
	    }
	}

	echo json_encode($message);
?>
