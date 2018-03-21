<?php
session_start();
require_once "../bdd/BDD.php";

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

      $per = array("dat_deb_p" => $donnees["dat_deb_p"], "dat_fin_p" => $donnees["dat_fin_p"]);
      array_push($tab_periode, $per);
   }
}

for($i=0; $i<count($tab_periode); $i++) {
   $periodeInfo = array(
      "title" => "periode n°".($i+1),
      "color" => "#00AFF1",
      "start" => $tab_periode[$i]["dat_deb_p"]."T00:00:00",
      "end" => $tab_periode[$i]["dat_fin_p"]."T00:00:00"
   );
   array_push($data, $periodeInfo);
}

echo json_encode($data);
?>
