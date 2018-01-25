<?php
	include('includes/header.php');
?>

<div class="loginWrap">
    <img class="loginSeprote" src="src/seprote.png" alt="Seprote" />
    <div class="loginIutImg">
        <img class="loginIut" src="src/iut.png" alt="IUT Calais Boulogne" />
    </div>
    <div class="row">
        <div class="form_connex col-md-offset-3 col-md-6">
            <form method="POST" action="login.php" id="loginForm">
                <input type="text" placeholder="Adresse e-mail" name="login" />
                <input type="password" placeholder="Mot de passe" name="mdp" />
                <button type="input">Connexion</button>
            </form>
        </div>
    </div>

    <?php
	require_once "lib/php/Error.php";
	require_once "bdd/BDD.php";

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

<?php include('includes/footer.php'); ?>
