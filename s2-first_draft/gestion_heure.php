<?php
	session_start();
	require_once "bdd/BDD.php";
	include('includes/header.php');

	if(!empty($_SESSION['id']) && $_SESSION['role'] < 3){ // On est connecter
	   include('includes/menu.php');

       /**** LISTE DES PROGRAMMES *****/

        $req_prog = $bdd->query("SELECT * FROM programme WHERE ppn = false");
        $liste_programme = "";
        while($donnees = $req_prog->fetch()){
         $liste_programme .= "<option value='". $donnees["id_prog"] ."'>". $donnees["prog_nom"] ."</option>";
        }
?>

<div id="main">
    <div class="mainWrap">
        <div id="content" class="GEST_HEURE">
            <h2> Gestion des heures </h2>

            <form class="formHour">
                <label for="prog">Choix du programme </label>
                <select id="prog">
                    <option value="">
                    <?php echo $liste_programme ?>
                </select><br><br>
                <label for="module">Choix du module: </label>
                <select id="mod">
                    <option value="">

                </select>
                <br/><br/>
                <label for="prof">Choix du prof: </label>
                <select id="prof">
                    <?php
				$req = $bdd->prepare("SELECT * FROM utilisateur");
				$req->execute();
				while($res = $req->fetch()){
					echo "<option value='".$res['id_u']."'>".$res['nom']." ".$res['prenom']."</option>";
				}

			?>
                </select>
                <br/><br/><br/>
                <label for="NBheuresCM">NB heures de CM: </label>
                <input id="cmm" type="text" min=0 name="cm">
                <br/><br/>
                <label for="NBheuresTD">NB heures de TD: </label>
                <input id="tdd" type="text" min=0 name="td">
                <br/><br/>
                <label for="NBheuresTP">NB heures de TP: </label>
                <input id="tpp" type="text" min=0 name="tp">

                <br/><br/><br/>

                <span>NB heure CM restant: </span><span class="cm">NaN</span><br/><br/>
                <span>NB heure TD restant: </span><span class="td">NaN</span><br/><br/>
                <span>NB heure TP restant: </span><span class="tp">NaN</span><br/><br/>
                <span>Total: </span><span class="total">NaN</span>
                <br/><br/><br/>

                <button id="butval">Valider</button>
            </form>

            <div id="RECAP_HEURE" class="blueBorder">

            </div>

        </div>

    </div>
</div>

<?php
    } else { header('Location: login.php'); }

	include('includes/footer.php');
?>
