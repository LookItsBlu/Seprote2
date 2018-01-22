<?php
    session_start();
    require_once "BDD.php";

    $data = array();

/*************** RECUPERATION DES SEMESTRES ********************/

   $req_semestre = $bdd->prepare("SELECT * FROM SEMESTRE WHERE id_prog = :id_prog");
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
         array_push($tab_module, $donnees["id_m"]);
      }
   }

   $cmTotal = 0;
   $tdTotal = 0;
   $tpTotal = 0;
   for($i=0; $i<count($tab_module); $i++) {
      $req_semestre = $bdd->prepare("SELECT cm FROM volume_horaire WHERE id_utilisateur = :id_util AND id_module = :id_mod");
      $req_semestre->execute(array("id_util" => $_SESSION["id"], "id_mod" => $tab_module[$i]));
      $cmTotal += $req_semestre->fetch()[0];

      $req_semestre = $bdd->prepare("SELECT td FROM volume_horaire WHERE id_utilisateur = :id_util AND id_module = :id_mod");
      $req_semestre->execute(array("id_util" => $_SESSION["id"], "id_mod" => $tab_module[$i]));
      $tdTotal += $req_semestre->fetch()[0];

      $req_semestre = $bdd->prepare("SELECT tp FROM volume_horaire WHERE id_utilisateur = :id_util AND id_module = :id_mod");
      $req_semestre->execute(array("id_util" => $_SESSION["id"], "id_mod" => $tab_module[$i]));
      $tpTotal += $req_semestre->fetch()[0];
   }

   array_push($data, $cmTotal);
   array_push($data, $tdTotal);
   array_push($data, $tpTotal);

   echo json_encode($data);
?>
