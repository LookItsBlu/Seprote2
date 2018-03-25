<?php
require_once "bdd/BDD.php";

session_start();

if(empty($_SESSION['id']))		// On n'est pas connecté
	header('Location: login.php');
else if($_SESSION['role'] > 2)	// On n'est pas connecté en tant qu'admin
	header('Location: index.php');

include('includes/header.php');
include('includes/menu.php');
?>

    <div id="main" class="mainWrap">
        <div id="content" class="container">
            <div class="row">
                <div class="col-md-12 accInput">
                    <form class='addCompte' action="#" method="POST">
                        <input class="col-md-2" name="nom" placeholder="Nom" type="text">
                        <input class="col-md-2" name="prenom" placeholder="Prénom" type="text">
                        <input class="col-md-2" name="mail" placeholder="Adresse mail" type="text">
                        <select class="col-md-2" name="id_role" type="text">
                        <?php if($_SESSION['role'] == 1) { ?>
                            <option value="2">Gestionnaire</option>
                        <?php } ?>
                        <option value="3" selected>Professeur</option>
                    </select>
                    <input class="col-md-2" type="password" name="mdp" placeholder="Mot de passe">
                    <select class="departements col-md-2" multiple="multiple">
                        <?php
                        $req_dptm = $bdd->prepare("SELECT id_d,nom_d from departement");
                        $req_dptm->execute();
                        while($data =$req_dptm->fetch()){
                        ?>
                            <option value="<?php echo $data['id_d'];?>"><?php echo $data['nom_d'];?></option>
                        <?php } ?>
                    </select>
                    <button class="col-md-1" class="submitBtn" value="Créer" type="submit">Ajouter</button>
                </form>
            </div>
        </div>
    </div>

    <script type="module" src="js/gestion_comptes.js"></script>

    <?php include('includes/footer.php'); ?>
