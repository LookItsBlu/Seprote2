<?php
	session_start();
    require_once "BDD.php";


    if(isset($_POST["id_prog"]) && $_SESSION['role'] < 3){

    	/*************** RECUPERATION DES SEMESTRES ********************/

    	$req_semestre = $bdd->prepare("SELECT * FROM SEMESTRE WHERE id_prog = :id_prog ORDER BY id_s ASC");
    	$req_semestre->execute(array("id_prog" => $_POST["id_prog"]));
    	$tab_semestre = array();

    	while($donnees = $req_semestre->fetch()){

    		$sem = array("id_s" => $donnees["id_s"], "dat_deb_s" => $donnees["dat_deb_s"], "dat_fin_s" => $donnees["dat_fin_s"], "id_prog" => $donnees["id_prog"]);
    		array_push($tab_semestre, $sem);
    	}

    	/************ RECUPERATION DES PERIODES PAR SEMESTRE ***********/

    	$tab_periode = array();
    	foreach ($tab_semestre as $tableau) {
    		$req_periode = $bdd->prepare("SELECT * FROM periode INNER JOIN per_sem ON id_per = id_p WHERE id_sem = :id_sem");
    		$req_periode->execute(array('id_sem' => $tableau["id_s"] ));

    		while($donnees = $req_periode->fetch()){

    			$per = array("id_s" => $tableau["id_s"], "id_p" => $donnees["id_p"], "dat_deb_p" => $donnees["dat_deb_p"], "dat_fin_p" => $donnees["dat_fin_p"]);
    			array_push($tab_periode, $per);
    		}
    	}

    	/************ RECUPERATION DES MODULES PAR PERIODE *************/

    	$tab_module = array();

    	foreach ($tab_periode as $tableau) {
    		$req_module = $bdd->prepare("SELECT * FROM module INNER JOIN per_mod ON id_m = id_mod WHERE id_per = :id_per");
    		$req_module->execute(array('id_per' => $tableau["id_p"] ));

    		while($donnees = $req_module->fetch()){

    			$mod = array("id_p" => $tableau["id_p"], "id_m" => $donnees["id_m"], "nom_m" => $donnees["nom_m"], "code_m" => $donnees["code_m"], "cm_g" => $donnees["cm_g"], "td_g" => $donnees["td_g"] , "tp_g" => $donnees["tp_g"]);
    			array_push($tab_module, $mod);
    		}
    	}

    	/********** CALCUL DES HEURES DES MODULES RESTANTES ********************/

    	//foreach ($tab_module as $key => $tableau) {
    	//	$cm_restant =0;
    	//	$td_restant =0;
    	//	$tp_restant =0;

    		/** HEURE CM **/

    	//	$req_cm = $bdd->prepare("SELECT SUM(cm) as somme FROM volume_horaire WHERE id_module = :id_module");
    	//	$req_cm->execute(array("id_module" => $tableau["id_m"]));
    	//	$somme = $req_cm->fetch();
    	//	$diff = ($tableau["cm_g"] - $somme["somme"]);
    	//	$tab_module[$key]['cm_restant'] = $diff;

    		/** HEURE TD **/

    		/** HEURE TP **/

    	//}


    }


    $programme = "";
    foreach ($tab_semestre as $num_sem => $tab_sem) {
    	$programme .= "<table class='visualMain'>\n<tr class='visualSem'><th> Semestre n° ". ($num_sem+1) . "(" . $tab_sem["dat_deb_s"]. " au ". $tab_sem["dat_fin_s"] . ")" ."</th></tr>";
    	foreach ($tab_periode as $num_per => $tab_per) {
    		if($tab_per["id_s"] == $tab_sem["id_s"]){

         $programme .= "<tr class='visualPer'><th> Periode n° ". ($num_per+1) . "(" . $tab_per["dat_deb_p"]. " au ". $tab_per["dat_fin_p"] . ")" ."</th></tr>";
         $programme .= "<tr class='visualValNames'><th>Code module</th><th>Nom module</th><th>Heure CM</th><th>Heure TD</th><th>Heure TP</th></tr>";

    			foreach ($tab_module as $num_mod => $tab_mod) {
    				if($tab_mod["id_p"] == $tab_per["id_p"]){

               $programme .= "<tr class='visualValues'><td>". $tab_mod["code_m"] ."</td><td>". $tab_mod["nom_m"] ."</td><td>". $tab_mod["cm_g"] ."</td><td>".$tab_mod["td_g"]."</td><td>".$tab_mod["tp_g"]."</td></tr>";
    				}
    			}
    		}
    	}
	$programme .= "</table>\n";
    }

    echo $programme;


?>
