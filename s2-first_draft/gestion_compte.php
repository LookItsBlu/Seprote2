<?php

session_start();

require_once "bdd/BDD.php";

$ROLE = array("1" => "Administrateur" , "2" => "Gestionnaire" ,"3" => "Professeur");

if($_SESSION['role'] < 2){

	/************ TRAITEMENT FORMULAIRE ************/

		if(isset($_POST['type_form'])){



			if($_POST['type_form'] == 1){ // Traitement du formulaire d'ajout de compte

				/********* VERIFICATION DES DONNEES *********/
				if($_POST['id_role'] != 1 && $_POST['id_role'] != 2 && $_POST['id_role'] != 3){

						$ERROR = "Id du rôle incorrect !";

				}

				else if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){

						$ERROR = "Adresse mail incorrecte !";
				}


				else if(strlen($_POST['mdp']) < 6){

						$ERROR = "Mot de passe trop court !";
				}

				/********** REQUETE A EFFECTUER **************/

				else{
					$req_ajout = $bdd->prepare("INSERT INTO utilisateur(nom,prenom,mail,id_role,mdp) VALUES(:nom,:prenom,:mail,:id_role,:mdp)");
					$req_ajout->execute(array(
						'nom' => $_POST['nom'],
						'prenom' => $_POST['prenom'],
						'mail' => $_POST['mail'],
						'id_role' => $_POST['id_role'],
						'mdp' => sha1($_POST['mdp'])
					));
					header('Location: gestion_compte.php');

					if(!$req_ajout){

					}

				}
			}

			if($_POST['type_form'] == 2){

				if(isset($_POST["id"]) && isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["mail"]) && isset($_POST["role"])){

					$req = $bdd->prepare('UPDATE utilisateur SET id_u = :id, nom = :nom, prenom = :prenom, mail = :mail, id_role = :role  WHERE id_u = :id');
					$res = $req->execute(array(
						"nom"=> $_POST["nom"],
						"prenom"=> $_POST["prenom"],
						"mail"=> $_POST["mail"],
						"id"=> $_POST["id"],
						"role"=> $_POST["role"]
					));


				}

			}

			if($_POST['type_form'] == 3){
                if(isset($_POST["id"])){
                    $req_delete = $bdd->prepare("DELETE FROM utilisateur WHERE id_u = :id");
                    $req_delete->execute(array( "id" => intval($_POST["id"]) ));
				}
			}
		}

		include('includes/header.php');

			if(!empty($_SESSION['id'])){ // On est connecté
		?>


    <?php include('includes/menu.php'); ?>

    <div id="main">
        <div class="mainWrap">
            <div id="content">
                <?php

						$req_compte = $bdd->query("SELECT id_u,nom,prenom,mail,id_role FROM utilisateur");
					?>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 accInput">
                                <form action="#" method="POST">
                                    <div class="container">
                                        <div class="row">
                                            <input class="col-md-2" name="nom" placeholder="Nom" type="text">
                                            <input class="col-md-2" name="prenom" placeholder="Prénom" type="text">
                                            <input class="col-md-2" name="mail" placeholder="Adresse mail" type="text">
                                            <select class="col-md-2" name="id_role" type="text">
								        <option value="1">Administrateur</option>
								        <option value="2">Gestionaire</option>
								        <option value="3">Professeur</option>
                                    </select>
                                            <input class="col-md-2" type="password" name="mdp" placeholder="Mot de passe">
                                            <button class="col-md-1" class="submitBtn" value="Créer" type="submit">Ajouter</button>
                                            <input type='hidden' name='type_form' value='1'>
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


                                    <tbody>
                                        <?php

						/***************** AFFICHAGE DES COMPTES *********************/

						while($donnees = $req_compte->fetch()){

							 echo "<tr class='odd'><td id='name".htmlspecialchars($donnees['id_u'])."'>";
							 echo htmlspecialchars($donnees['nom']);
							 echo '</td>';
							 echo "<td id='pname".htmlspecialchars($donnees['id_u'])."'>";
							 echo htmlspecialchars($donnees['prenom']);
							 echo '</td>';
							 echo "<td id='mail".htmlspecialchars($donnees['id_u'])."'>";
							 echo htmlspecialchars($donnees['mail']);
							 echo '</td>';
							 echo "<td id='rol_value'>";
							 echo htmlspecialchars($ROLE[$donnees['id_role']]);
							 echo '</td>';
							 echo '<td>';
							 echo "<input name='edit' type='button' value='Éditer' id=".htmlspecialchars($donnees['id_u']).">";
							 echo '</td>';
							 echo '<td>';
							 echo "<input name='delete' type='button' value='Supprimer' id='delete".htmlspecialchars($donnees['id_u'])."'>";
							 echo '</td>';
							 echo '</tr>';

						}

						/***************** BOITE DIALOGUE EDITION *******************/?>

                                            <div id="dialog_edit" title="Edition de compte">
                                                <p class="validateTips">Tous les champs sont nécessaires.</p>
                                                <form name="edit_compte" id="editCompte" method="POST" action="gestion_compte.php">
                                                    <label for="nom">Nom:</label>
                                                    <input type="text" name="nom" id="nom" class="text ui-widget-content ui-corner-all">
                                                    <br>
                                                    <label for="date_fin">Prénom:</label>
                                                    <input type="text" name="prenom" id="prenom" class="text ui-widget-content ui-corner-all">
                                                    <br>
                                                    <label for="mail">Mail:</label>
                                                    <input type="text" name="mail" id="mail" class="text ui-widget-content ui-corner-all">
                                                    <br>
                                                    <label for="role">Rôle:</label>
                                                    <select name="role">
                                                <option value=""></option>
                                                <option value="1">Administrateur</option>
                                                <option value="2">Gestionnaire</option>
                                                <option value="3">Professeur</option>
                                            </select>
                                                    <br>

                                                    <input type="hidden" id="id" name="id" value="">
                                                    <input type="hidden" name='type_form' value='2'>
                                                </form>

                                            </div>

                                    </tbody>
                                </form>
                            </table>
                        </div>


                        <!-- *********** FORMULAIRE AJOUT UTILISATEUR ****************-->

                        <!-- <form action='#' method='POST'>
							<table>
								<tr>
									<th>Nom</th>
									<th>Prénom</th>
									<th>Adresse mail</th>
									<th>Rôle</th>
									<th>Mot de passe</th>
								</tr>
								<tr>
									<td><input type='text' name='nom' id="nom"></td>
									<td><input type='text' name='prenom' id="prenom"></td>
									<td><input type='text' name='mail' id="mail"></td>
									<td><select name='id_role'>
											<option value="1">Administrateur</option>
											<option value="2">Gestionnaire</option>
											<option value="3">Utilisateur</option>
										</select>
									</td>
									<td><input type='password' name='mdp' id="mdp"></td>
									<td><input type='submit' value='Créer' id="ajout">
									<input type='hidden' name='type_form' value='1'></td>
								</tr>
							</table>
						</form>	-->

                        <?php if(isset($ERROR)) { ?>

                        <div class="ui-widget">
                            <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
                                <p>
                                    <span class="ui-icon ui-icon-alert" style="margin-right: .3em;"></span>
                                    <strong>ERREUR: </strong>
                                    <?php echo $ERROR ?>
                                </p>
                            </div>
                        </div>

                        <?php } ?>
                    </div>
            </div>
        </div>
    </div>

    <script>
        $("#ListeComptes").tablesorter();
        $("#dialog_edit").hide();
        $("input[name='edit']").click(function() {

            var x = $(this).attr("id");
            $("#nom").val($("#name" + x).text());
            $("#prenom").val($("#pname" + x).text());
            $("#id").val(x);
            $("#mail").val($("#mail" + x).text());
            $("#id").val(x);
            $("#dialog_edit").dialog({

                modal: true,
                height: 400,
                width: 350,

                buttons: {

                    "Modifier": function() {
                        $("#editCompte").submit();
                    },

                    "Annuler": function() {
                        $(this).dialog("close");
                    }
                }
            });
        });

        $("input[name='delete']").click(function() {
            if (confirm("Voulez-vous vraiment supprimer ce compte ?")) {
                var idd = $(this)[0].id;
                var y = idd.substring('6', idd.length);
                $("#id").val(y);
                $("#delete_users").submit();
            }
        });

    </script>
    <?php
		}

		else header('Location: login.php');

		include('includes/footer.php');
}
else header('Location: index.php')


		?>
