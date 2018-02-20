<?php
//require_once "bdd/BDD.php";
/*if($_POST['type_form'] == 2){
	/*if(isset($_POST["id"]) && isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["mail"]) && isset($_POST["role"])){
		$req = $bdd->prepare('UPDATE utilisateur SET id_u = :id, nom = :nom, prenom = :prenom, mail = :mail, id_role = :role  WHERE id_u = :id');
		$res = $req->execute(array(
			"nom"=> $_POST["nom"],
			"prenom"=> $_POST["prenom"],
			"mail"=> $_POST["mail"],
			"id"=> $_POST["id"],
			"role"=> $_POST["role"]
		));
    	header('Location: gestion_compte.php');
	}
}*/
?>
<?php
session_start();

if(empty($_SESSION['id'])) {		// On n'est pas connecté
	header('Location: login.php');
}
else if($_SESSION['role'] != 1) {	// On n'est pas connecté en tant qu'admin
	header('Location: index.php');
}
?>
<?php
include('includes/header.php');
include('includes/menu.php');
?>

    <div id="main">
        <div class="mainWrap">
            <div id="content">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 accInput">
                            <form class='addCompte' action="#" method="POST">
                                <div class="container">
                                    <div class="row">
                                        <input class="col-md-2" name="nom" placeholder="Nom" type="text">
                                        <input class="col-md-2" name="prenom" placeholder="Prénom" type="text">
                                        <input class="col-md-2" name="mail" placeholder="Adresse mail" type="text">
                                        <select class="col-md-2" name="id_role" type="text">
                                            <option value="2">Gestionnaire</option>
                                            <option value="3" selected>Professeur</option>
                                        </select>
                                        <input class="col-md-2" type="password" name="mdp" placeholder="Mot de passe">
                                        <button class="col-md-1" class="submitBtn" value="Créer" type="submit">Ajouter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <table id="ListeComptes" class="sep_table col-md-12">
                            <form id="delete_users" method="POST" action="#">
                                <input type='hidden' name='type_form' value='3'>
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Adresse mail</th>
                                        <th>Rôle</th>
                                        <th>Éditer</th>
                                        <th>Supprimer</th>
                                    </tr>
                                </thead>

                                <tbody></tbody>
                            </form>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/ajax/fetchCompte.js"></script>
    <script src="js/ajax/addCompte.js"></script>
    <script src="js/ajax/updateCompte.js"></script>
    <script src="js/ajax/deleteCompte.js"></script>

<?php include('includes/footer.php'); ?>
