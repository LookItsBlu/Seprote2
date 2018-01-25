<?php
session_start();
require_once "bdd/BDD.php";

/************ RECUPERATION DES ELEMENTS NECESSAIRES A LA CREATION DE PROGRAMMES ***********/

/**** LISTE DE TOUS LES PROGRAMMES *****/

$req_tprog = $bdd->query("SELECT * FROM programme");
$liste_tprogramme = "";
while($donnees = $req_tprog->fetch()){
	$liste_tprogramme .= "<option value='". $donnees["id_prog"] ."'>". $donnees["prog_nom"] ."</option>";
}

/**** LISTE DES PROGRAMMES *****/

$req_prog = $bdd->query("SELECT * FROM programme WHERE ppn = false");
$liste_programme = "";
while($donnees = $req_prog->fetch()){
	$liste_programme .= "<option value='". $donnees["id_prog"] ."'>". $donnees["prog_nom"] ."</option>";
}

/**** LISTE DES PPN *****/

$req_ppn = $bdd->query("SELECT * FROM programme WHERE ppn = true");
$liste_ppn = "";
while($donnees = $req_ppn->fetch()){
	$liste_ppn .= "<option value='". $donnees["id_prog"] ."'>". $donnees["prog_nom"] ."</option>";
}

/**** LISTE DES FORMATIONS *****/

$req_formation = $bdd->query("SELECT * FROM formation");
$liste_formation = "";
while($donnees = $req_formation->fetch()){
	$liste_formation .= "<option value='". $donnees["id_for"] ."'>". $donnees["nom_f"] ."</option>";
}

/**** LISTE DES ANNEES *****/

$req_annee = $bdd->query("SELECT * FROM annee");
$liste_annee = "";
while($donnees = $req_annee->fetch()){
	$liste_annee .= "<option value='". $donnees["id_a"] ."'>". $donnees["dat_deb_a"]. " au " . $donnees["dat_fin_a"] ."</option>";
}

/**** LISTE DES MODULE *****/

$req_module = $bdd->query("SELECT * FROM module");
$liste_module = "";
while($donnees = $req_module->fetch()){
	$liste_module .= "<option value='". $donnees["id_m"] ."'>". $donnees["code_m"]. " " .  $donnees["nom_m"] ."</option>";
}


if($_SESSION['role'] < 3 && isset($_SESSION['id'])){

include('includes/header.php');
include('includes/menu.php');
?>

<div id="main">
	<div class="mainWrap">
		<div id="content">
			<table class="actionList">
				<tr><th>Création rapide d'éléments</th></tr>
				<tr>
					<td>
						<input type="button" id="create_module" value="Créer un module">
						<input type="button" id="create_annee" value="Créer une année">
						<input type="button" id="create_for" value="Créer une formation">
					</td>
				</tr>
				<tr><th>Action sur les programmes</th></tr>
				<tr>
					<td>
						<input type="button" id="test" value="Modifier un programme existant">
						<input type="button" id="test2" value="Créer un nouveau programme">
						<input type="button" id="test3" value="Gestion des modules">
					</td>
				</tr>
			</table>

			<!--           FORMULAIRE CREATION DE PROGRAMME             -->

			<div class="blueBorder" id="create_prog">
				<form action="php/creation_programme.php" method="POST">

					<!-- ETAPE NUMERO 1 -->
					<div id="1">
						<h3>Paramètres principaux</h3>
						<br>
						<label for="nom">Nom du programme:</label>
						<br>
						<input type="text" name="nom">
						<br><br>
						<label for="ppn">Le programme est un PPN:</label>
						<input type="checkbox"id="ppn" name="ppn"><br>
						<br><br>
						<label for="ppn_relie">PPN à relier:</label>
						<select name="ppn_relie" type="number">
							<option value=""></option>
							<?php echo($liste_ppn); ?>
						</select>
						<br><br>
						<label for="formation">Formation concernée:</label>
						<select name="formation" id="formation">
							<option value=""></option>
							<?php echo($liste_formation); ?>
						</select>
						<br><br><br>
					</div>

					<!-- ETAPE NUMERO 2 -->
					<div id="2">
						<h3>Sélection des semestres</h3>
						<br>
						<label for="sem1">Semestre 1: </label>
						<br>
						<input type="date" name="sem1_deb">
						<input type="date" name="sem1_fin">
						<br><br>
						<label for="sem1">Semestre 2: </label>
						<br>
						<input type="date" name="sem2_deb">
						<input type="date" name="sem2_fin">
						<br><br>
						<h3> SEMESTRE 1 </h3>
						<label for="nb_p1">Nombre de périodes</label>
						<input type="number" name="nb_p1" value=0 onchange="updatePeriode(1)">
						<br><br>
						<h3> SEMESTRE 2 </h3>
						<label for="nb_p2">Nombre de périodes</label>
						<input type="number" name="nb_p2" value=0 onchange="updatePeriode(2)">
						<br><br><br>
					</div>

					<!-- ETAPE NUMERO 3 -->
					<div id="3">
						<h3> Semestre n° 1 </h3>
						<div id="p_sem1"></div>
						<br><br>
						<h3> Semestre n° 2 </h3>
						<div id="p_sem2"></div>
						<input type="submit" value="Créer le programme">
						<br><br><br>
					</div>

					<input type=button class="ui-button ui-widget ui-corner-all" id="precedent" value="Etape précédente">
					<input type=button class="ui-button ui-widget ui-corner-all" id="suivant" value="Etape suivante">
				</form>

			<!--		BOITE DE DIALOGUE CREATION FORMATION		-->
			<div id="dialog_for" title="Création nouvelle formation">
				<p class="validateTips">Tous les champs sont nécessaires.</p>
				<fieldset>
					<label for="nom_for">Nom de la formation</label><br>
					<input type="text" name="nom_for" id="nom_for"  class="text ui-widget-content ui-corner-all"><br>
					<label for="annee">Année concernée</label><br>
					<select name="annee" id="for_annee"> <br><br>
						<option value=""></option>
						<?php echo($liste_annee); ?>
					</select><br><br>
					<label for="nb_td">Nombre de groupe TD:</label><br><br>
					<input type="number" name="nb_td" id="nb_td"  class="text ui-widget-content ui-corner-all"><br>
					<label for="nb_tp">Nombre de goupe TP:</label><br><br>
					<input type="number" name="nd_tp" id="nb_tp"  class="text ui-widget-content ui-corner-all">
				</fieldset>
			</div>

			<!--		BOITE DE DIALOGUE CREATION MODULE		-->
			<div id="dialog_module" title="Création nouveau module">
				<p class="validateTips">Tous les champs sont nécessaires.</p>
				<fieldset>
					<label for="nom_mod">Nom du module</label><br>
					<input type="nom_mod" name="nom_mod" id="nom_mod"  class="text ui-widget-content ui-corner-all"><br>
					<label for="code_mod">Code du module</label><br>
					<input type="text" name="code_mod" id="code_mod"><br><br>
					<label for="cm_g">Nombre d'heure de CM</label><br>
					<input type="text" name="cm_g" id="cm_g"><br>
					<label for="td_g">Nombre d'heure de TD(par groupe)</label><br>
					<input type="number" name="td_g" id="td_g"><br>
					<label for="tp_g">Nombre d'heure de TP(par groupe)</label><br>
					<input type="number" name="tp_g" id="tp_g">
				</fieldset>
			</div>

			<!--		BOITE DE DIALOGUE CREATION ANNEE		-->
			<div id="dialog_annee" title="Création nouvelle année">
				<p class="validateTips">Tous les champs sont nécessaires.</p>
				<form name="send_annee" method="POST" action="php/traitement.php">
					<fieldset>
						<label for="date_d">Date de début</label><br>
						<input type="date" name="date_d" id="dat_deb"  class="text ui-widget-content ui-corner-all"><br><br>
						<label for="date_fin">Date de fin</label><br>
						<input type="date" name="date_fin" id="dat_fin"  class="text ui-widget-content ui-corner-all">
					</fieldset>
				</form>
			</div>
		</div>

		<div  class="blueBorder" id="modify_prog">

				<form action="php/modification_programme.php" method="POST">
					<h3>Choisir un programme</h3>
					<select id='id_prog_modif' name="id_prog_modif">
						<option value=""></option>
						<?php echo $liste_tprogramme ?>
					</select>


						<h3>Paramètres principaux</h3>
						<br>
						<label for="nom">Nom du programme:</label>
						<br>
						<input type="text" name="nom" id="nommodif">
						<br><br>
						<label for="ppn">Le programme est un PPN:</label>
						<input type="checkbox" id="ppnmodif" name="ppn"><br>
						<br><br>
						<label for="ppn_relie">PPN à relier:</label>
						<select name="ppn_relie" type="number" id="ppn_reliemodif">
							<option value=""></option>
							<?php echo($liste_ppn); ?>
						</select>
						<br><br>
						<label for="formation">Formation concernée:</label>
						<select name="formation" id="formationmodif">
							<option value=""></option>
							<?php echo($liste_formation); ?>
						</select>
						<br><br><br>
						<h3>Dates des semestres</h3>
						<br>
						<label for="sem1">Semestre 1: </label>
						<br>
						<input type="date" id="sem1_debmodif" name="sem1_deb">
						<input type="date" id="sem1_finmodif" name="sem1_fin">
						<input type="hidden" value="" id="id_sem1" name="id_sem1">
						<br><br>
						<label for="sem1">Semestre 2: </label>
						<br>
						<input type="date" name="sem2_deb" id="sem2_debmodif">
						<input type="date" name="sem2_fin" id="sem2_finmodif">
						<input type="hidden" value="" id="id_sem2" name="id_sem2">
						<br><br>
						<input type="submit" value="Modifier le programme">
						<br><br><br>

				</form>
		</div>

		<div  class="blueBorder" id="gestion_module">
			<h3>Inserer un module</h3>
			<label for="prog">Choisir un programme: </label>
			<select name="prog" id="prog">
				<option value=""></option>
				<?php echo($liste_programme); ?>
			</select>
			<br><br>
			<label for="prog_semestre">Choisir un semestre: </label>
			<select name="prog_sem" id="prog_sem">
				<option value=""></option>
			</select>
			<br><br>
			<label for="prog_periode">Choisir une periode: </label>
			<select name="prog_p" id="prog_p">
				<option value=""></option>
			</select>
			<br><br>
			<label for="p_module">Choisir un module: </label>
			<select name="p_module" id="p_module">
				<option value=""></option>
				<?php echo($liste_module); ?>
			</select>
			<br><br>
			<input type="button" id="affect_module" value="Affecter le module">

			<table id="recapTab">

			</table>

			<h3>Modifier un module</h3>
			<label for="module">Choisir un module: </label>
			<select name="module" id="module">
				<option value=""></option>
				<?php echo($liste_module); ?>
			</select>
			<br><br>
			<label for="prog">Nom: </label>
			<input type="text" name="m_nom_mod" id="m_nom_mod">
			<br><br>
			<label for="prog">Code: </label>
			<input type="text" name="m_code_mod" id="m_code_mod">
			<br><br>
			<label for="prog">Heures CM(par groupe): </label>
			<input type="number" name="m_cm_mod" id="m_cm_mod">
			<br><br>
			<label for="prog">Heures TD(par groupe): </label>
			<input type="number" name="m_td_mod" id="m_td_mod">
			<br><br>
			<label for="prog">Heures TP(par groupe): </label>
			<input type="number" name="m_tp_mod" id="m_tp_mod">
			<br><br>
			<input type="button" id="modify_mod" value="Modifier module">
		</div>
	</div>
</div>
</div>

<script>
	/*********************** UPDATE PAGE MODULE *************************/

	/*********************** AVANT l'AFFICHAGE DE LA PAGE *************************/
	$(document).ready(function() {
		nb_p1=$("select[name='nb_p1']").val();
		nb_p2=$("select[name='nb_p2']").val();

		etape=1;
		$("#modify_prog").hide();
		$("#create_prog").hide();
		$("#gestion_module").hide();
		$("#dialog_for").hide();
		$("#dialog_annee").hide();
		$("#dialog_module").hide();
		$("#2").hide();
		$("#3").hide();

		$( "#test" ).click(function	() {
			$( "#modify_prog" ).show( "slow", function() {});
			$("#create_prog").hide();
			$("#gestion_module").hide();
		});

		$( "#test2" ).click(function() {
			$( "#create_prog" ).show( "slow", function() {});
			$("#modify_prog").hide();
			$("#gestion_module").hide();
		});

		$( "#test3" ).click(function() {
			$( "#gestion_module" ).show( "slow", function() {});
			$("#modify_prog").hide();
			$("#create_prog").hide();
		});

		$("#suivant").click(function(){
			if(etape < 3){
				$("#" + etape).hide();
				etape++;
				$("#" + etape).show();
			}
		});

		$("#precedent").click(function(){
			if(etape > 1){
				$("#" + etape).hide();
				etape--;
				$("#" + etape).show();
			}
		});

		$("select[name='nb_p1").change(function(){
			nb_p1=$("select[name='nb_p1']").val();
		});

		$("select[name='nb_p2").change(function(){
			nb_p1=$("select[name='nb_p2']").val();
		});

		$( "#affect_module" ).click(function(){
			var params = "id_per=" + $("#prog_p").val() + "&id_mod=" + $("#p_module").val();
			$.ajax({
				type: 'POST',
				url: 'js/ajax/ajaxaffectmod.php',
				data: params,
				success: ajaxOK
			});
		});

		$( "#modify_mod" ).click(function(){
			var params = "id_m=" + $("#module").val() + "&nom_m="+ encodeURIComponent($("#m_nom_mod").val()) + "&code_m=" +  $("#m_code_mod").val() + "&cm_g=" +  $("#m_cm_mod").val() + "&td_g=" + $("#m_td_mod").val() + "&tp_g=" +  $("#m_tp_mod").val();
			$.ajax({
				type: 'POST',
				url: 'js/ajax/ajaxmodifymodfinal.php',
				data: params,
				success: ajaxOK
			});
		});

		$( "#prog" ).change(function(){
			buildTabRecap();
			var params = "id_prog=" + $("#prog").val();
			$.ajax({
				type: 'POST',
				url: 'js/ajax/ajaxprog.php',
				data: params,
				success: ajaxOKprog
			});
		});

		$( "#prog_sem" ).change(function(){
			var params = "id_sem=" + $("#prog_sem").val();
			$.ajax({
				type: 'POST',
				url: 'js/ajax/ajaxsem.php',
				data: params,
				success: ajaxOKsem
			});
		});

		$( "#module" ).change(function(){
			var params = "id_mod=" + $("#module").val();
			$.ajax({
				type: 'POST',
				url: 'js/ajax/ajaxmodifymod.php',
				data: params,
				success: ajaxOKmodifymod
			});
		});

		$( "#id_prog_modif" ).change(function(){
			var params = "id_prog=" + $("#id_prog_modif").val();
			$.ajax({
				type: 'POST',
				url: 'js/ajax/ajaxmodifyprog.php',
				data: params,
				success: ajaxOKmodifyprog
			});
		});

	});

	/*********************** AJAX *************************************/
	function ajaxOKsem(data){ $("#prog_p").html(data); }

	function ajaxOKprog(data){ $("#prog_sem").html(data); }

	function ajaxOKannee(data){ $("#for_annee").append(data); }

	function ajaxOKformation(data){ $("#formation").append(data); }

	function ajaxOKmodule(data){
		$("#p_module").append(data);
		$("#module").append(data);
	}

	function ajaxOK(data){}

	function ajaxOKmodifymod(data){
		var tab_info = $.parseJSON(data)
		$("#m_nom_mod").val(tab_info[0].nom_m);
		$("#m_code_mod").val(tab_info[0].code_m);
		$("#m_cm_mod").val(tab_info[0].cm_g);
		$("#m_td_mod").val(tab_info[0].td_g);
		$("#m_tp_mod").val(tab_info[0].tp_g);
	}

	function ajaxOKmodifyprog(data){

		$tab = $.parseJSON(data);
		$("#nommodif").val($tab[0].prog_nom);
		if($tab[0].ppn == 1){

			$("#ppnmodif").prop("checked", true);
		}
		else{

			$("#ppnmodif").prop("checked", false);
		}

		document.getElementById('ppn_reliemodif').value = $tab[0].ppn_relie; //ne fonctionne pas avec JQuery ??
		document.getElementById('formationmodif').value = $tab[1].id_for; //ne fonctionne pas avec JQuery ??

		/*** SEMESTRE 1 ***/

		$("#id_sem1").val($tab[2][0].id_s);  //ne fonctionne pas avec JQuery ??
		document.getElementById('sem1_debmodif').value = $tab[2][0].dat_deb_s; //ne fonctionne pas avec JQuery ??
		document.getElementById('sem1_finmodif').value = $tab[2][0].dat_fin_s; //ne fonctionne pas avec JQuery ??

		/*** SEMESTRE 2 ***/

		$("#id_sem2").val($tab[2][1].id_s); //ne fonctionne pas avec JQuery ??
		document.getElementById('sem2_debmodif').value = $tab[2][1].dat_deb_s; //ne fonctionne pas avec JQuery ??
		document.getElementById('sem2_finmodif').value = $tab[2][1].dat_fin_s; //ne fonctionne pas avec JQuery ??
	}

	function ajaxOKrecaptab(data){
		$("#recapTab").html(data);
	}

	function buildTabRecap($id_prog){

		var params = "id_prog=" + $("#prog").val();
			$.ajax({
				type: 'POST',
				url: 'js/ajax/ajaxvisualprog.php',
				data: params,
				success: ajaxOKrecaptab
			});
	}
	/*********************** UPDATE DES PERIODES *************************/

	function updatePeriode($x){
		var nb_periode = 0;
		var i = 1;
		var content = "";
		if($x == 1){
			nb_periode = $("input[name='nb_p1']").val();
			for(i=1;i<=nb_periode;i++){
				content += "<h3>Période n°" + i + "</h3>" ;
				content += "<label for='p_deb_sem1'>Date de début:</label><input type='date' name='p_deb_sem1[]'><br>";
				content += "<label for='p_fin_sem1'>Date de fin:</label><input type='date' name='p_fin_sem1[]'><br>";
			}
			$("#p_sem1").html(content);
		}
		else if($x == 2){
			nb_periode = $("input[name='nb_p2']").val();
			for(i=1;i<=nb_periode;i++){
				content += "<h3>Période n°" + i + "</h3>" ;
				content += "<label for='p_deb_sem2'>Date de début:</label><input type='date' name='p_deb_sem2[]'><br>";
				content += "<label for='p_fin_sem2'>Date de fin:</label><input type='date' name='p_fin_sem2[]'><br>";
			}
			$("#p_sem2").html(content);
		}
	}

	/*********************** FORMULAIRE CREATION FORMATION *************************/

	$("#create_for").click(function(){
		$( "#dialog_for" ).dialog({
			modal: true,
			height: 400,
			width: 350,
			buttons : [
				{
					text: "Créer",
					id: "submit_for",
					click: function(){
						var params = "nom_for=" + $("#nom_for").val() + "&id_a=" + $("#for_annee").val() + "&group_td=" + $("#nb_td").val() + "&group_tp=" + $("#nb_tp").val();
						$.ajax({
							type: 'POST',
							url: 'js/ajax/ajaxformation.php',
							data: params,
							success: ajaxOKformation
						});
						$(this).dialog("close");
					}
				},
				{
					text: "Annuler",
					click: function(){
						$(this).dialog("close");
					}
				}
			]
		});
	});

	/*********************** FORMULAIRE CREATION ANNEE *************************/

	$("#create_annee").click(function(){
		$( "#dialog_annee" ).dialog({
			modal: true,
			height: 400,
			width: 350,
			buttons : [
				{
					text: "Créer",
					id: "submit_annee",
					click: function(){
						var params = "date_d=" + $("#dat_deb").val() + "&date_fin=" + $("#dat_fin").val();
						$.ajax({
							type: 'POST',
							url: 'js/ajax/ajaxannee.php',
							data: params,
							success: ajaxOKannee
						});
						$(this).dialog("close");
					}
				},
				{
					text: "Annuler",
					click: function(){
						$(this).dialog("close");
					}
				}
			]
		});
	});

	/*********************** FORMULAIRE CREATION MODULE *************************/

	$("#create_module").click(function(){
		$( "#dialog_module" ).dialog({
			modal: true,
			height: 400,
			width: 350,
			buttons : [
				{
					text: "Créer",
					id: "submit_module",
					click: function(){
						var params = "nom_mod=" + $("#nom_mod").val() + "&code_mod=" + $("#code_mod").val() + "&cm_g=" + $("#cm_g").val() + "&td_g=" + $("#td_g").val() + "&tp_g=" + $("#tp_g").val();
						$.ajax({
							type: 'POST',
							url: 'js/ajax/ajaxmodule.php',
							data: params,
							success: ajaxOKmodule
						});
						$(this).dialog("close");
					}
				},
				{
					text: "Annuler",
					click: function(){
						$(this).dialog("close");
					}
				}
			]
		});
	});
</script>
<?php include('includes/footer.php');} else {header('location: login.php');}?>
