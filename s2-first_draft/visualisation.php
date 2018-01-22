<?php
	session_start();
    require_once "BDD.php";



    /***************** REQUETE LISTE DES PROGRAMMES **************/

    $req_prog = $bdd->query("SELECT * FROM programme");
    $liste_programme = "";


    while($donnees = $req_prog->fetch()){

        $liste_programme .= "<option value='". $donnees["id_prog"] ."'>". $donnees["prog_nom"] ."</option>";
    }


	include('header.php');

	if(!empty($_SESSION['id']) && $_SESSION['role'] < 3){ // On est connecter
	   include('menu.php');
?>

<div id="main">
    <div class="mainWrap">

        <div id="content">
            <label for="programme">Choix du programme </label>
            <select name="prog" id="prog">
                <option value=""></option>
             <?php echo $liste_programme; ?>
            </select>

            <div id="table_prog">

            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function() {


$("#prog").change(function(){
    var params = "id_prog=" + $("#prog").val();
                    $.ajax({
                        type: 'POST',
                        url: 'ajaxvisualprog.php',
                        data: params,
                        success: ajaxOK
                    });
});


});


function ajaxOK(data){

    $("#table_prog").html(data);
}

</script>


<?php
    } else { header('Location: login.php'); }


	include('footer.php');
?>

