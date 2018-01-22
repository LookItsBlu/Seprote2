<?php session_start();
	include('header.php');
?>

<div class="loginWrap">
	<img class="loginSeprote" src="src/seprote.png" alt="Seprote"/>
	<div class="loginIutImg">
		<img class="loginIut" src="src/iut.png" alt="IUT Calais Boulogne"/>
	</div>

	<form method="POST" action="login.php" id="loginForm">
		<label>E-mail</label>
		<input type="text" name="login"/>
		<br/><br/>
		<label>Mot de passe</label>
		<input type="password" name="mdp"/>
		<br/><br/><br/>
		<button type="input">Connexion</button>
	</form>

<?php
	require_once "Error.php";
	require_once "BDD.php";

	if(!isset($_SESSION['id']) || !isset($_SESSION['nom']) || !isset($_SESSION['prenom']) || !isset($_SESSION['role'])){
		if(empty($_POST['login']) || empty($_POST['mdp'])){
			if(isset($_POST['login']) || isset($_POST['mdp'])){
				errorMes("L'un des 2 champs est vide !");
			}
		} else {
			$req = $bdd->prepare('SELECT id_u, mail, mdp, nom, prenom, id_role FROM utilisateur WHERE mail = :mail AND mdp = :mdp');
			$req->execute(array(
				'mail' => $_POST['login'],
				'mdp' => sha1($_POST['mdp'])
			));

			$resultat = $req->fetch();
			if(!$resultat){
				errorMes("Login ou mot de passe incorrect !");
			} else { // Connexion réussie !
				session_start();

				$_SESSION['id'] = $resultat['id_u'];
				$_SESSION['nom'] = $resultat['nom'];
				$_SESSION['prenom'] = $resultat['prenom'];
				$_SESSION['role'] = $resultat['id_role'];

				header('Location: index.php');
			}
		}
	} else header("Location: index.php");
?>

</div>

<?php include('footer.php'); ?>
