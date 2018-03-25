<?php
session_start();
require_once '../bdd/BDD.php';

$req_dep = $bdd->prepare('
    SELECT d.id_d, d.nom_d
    FROM departement d, utilisateur u, util_dep ud
    WHERE u.id_u=ud.id_u AND ud.id_d=d.id_d AND u.id_u=:id
');
$req_dep->bindValue(':id', $_SESSION['id']);
$req_dep->execute();

$optionList = '';
while($dep = $req_dep->fetch()) {
    if($dep['id_d'] == $_SESSION['id_dep'])
        $optionList .= "<option value='".$dep['id_d'] ."' selected>".$dep['nom_d']."</option>";
    else
        $optionList .= "<option value='".$dep['id_d'] ."'>".$dep['nom_d']."</option>";
}

echo $optionList;
