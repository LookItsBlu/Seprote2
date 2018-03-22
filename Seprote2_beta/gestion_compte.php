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
                        <button class="col-md-1" class="submitBtn" value="Créer" type="submit">Ajouter</button>
                        <div class="form-check col-md-12">
                            <span>Département :</span>
                            <?php
                                $req_dptm = $bdd->prepare("SELECT id_d,nom_d from departement");
                                $req_dptm->execute();
                                while($data =$req_dptm->fetch()){ ?>
                                <input type="checkbox" class="dept" id="dptm<?php echo $data['id_d'];?>">
                                <label class="" for="dptm<?php echo $data['id_d'];?>"><?php echo $data['nom_d'];?></label>
                                <?php } ?>
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
                                <th>Département</th>
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

    <script src="js/ajax/fetchCompte.js"></script>
    <script src="js/ajax/addCompte.js"></script>
    <script src="js/ajax/updateCompte.js"></script>
    <script src="js/ajax/deleteCompte.js"></script>

    <?php include('includes/footer.php'); ?>
