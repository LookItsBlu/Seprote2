<?php

/*
$_POST contient deux valeurs:
    depth: la profondeur dans l'arborescence, permet de savoir quel table utiliser
    id: l'id de l'item sélectioné dans la liste
*/


include ('../../../../bdd/BDD.php');

//nom des tables
$level = array(
    "annee",
    "formation",
    "semestre",
    "periode",
    "module"
);

/*
nom des IDs
BTW si on corrige le nom id_for par id_f dan la bdd, on peut se débarraser de cette liste par cette ligne de code:
$id = 'id_'.substr( $level[ $_POST['id'] ] , 0, 1)
*/
$id = array(
    "id_a",
    "id_for",
    "id_s",
    "id_prog",
    "id_p",
    "id_m"
);

$table = array(
    "for_annee",
    "prog_for",
    "per_sem",
    "per_mod"
);


$res = '';

switch($level[$_POST['depth']]){
    case 'annee':
        $sql = 'SELECT * FROM annee';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute();
        $res = $pdoreq->fetchall();
        break;
    case 'formation':
        $sql = 'SELECT * FROM formation INNER JOIN for_annee ON formation.id_f = for_annee.id_f WHERE id_a = :id';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute(array(':id' => $_POST['id']));
        $res = $pdoreq->fetchall();
        break;
    case 'semestre':
        $sql = 'SELECT * FROM semestre INNER JOIN prog_for ON semestre.id_prog = prog_for.id_prog WHERE id_f = :id';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute(array(':id' => $_POST['id']));
        $res = $pdoreq->fetchall();
        break;
    case 'periode':
        $sql = 'SELECT * FROM periode INNER JOIN per_sem ON periode.id_p = per_sem.id_per WHERE id_sem = :id';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute(array(':id' => $_POST['id']));
        $res = $pdoreq->fetchall();
        break;
    case 'module':
        $sql = 'SELECT * FROM module INNER JOIN per_mod ON module.id_m = per_mod.id_mod WHERE id_per = :id';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute(array(':id' => $_POST['id']));
        $res = $pdoreq->fetchall();
        break;
    //default:
}

/*
//si aucun id n'est séletioné, affiche toute la table (pour l'initialisation de la liste, ca peut surement être mieux fais, mais ca c'est pour plus tard)
if($_POST['id'] < 0){
    $sql = 'SELECT * FROM ' . $level[ intval( $_POST['depth'] ) ];
    $pdoreq = $bdd->prepare($sql);
    $pdoreq->execute();
    $res = $pdoreq->fetchall();
}
//selectione toute les entrées liée a l'item selectioné
else {
    $sql = 'SELECT * FROM ' . $level[ intval( $_POST['depth'] ) ] . ' INNER JOIN '. $table[ intval( $_POST['depth']-1 ) ] .' ON '. $level[ intval( $_POST['depth'] ) ]. "." .$id[ intval( $_POST['depth'] ) ] .' WHERE '. $table[ intval( $_POST['depth']-1 ) ] . '.' . $id[ intval( $_POST['depth']-1 ) ] . ' = :id';

    $pdoreq = $bdd->prepare($sql);
    $pdoreq->execute(array(':id' => $_POST['id']));
    $res = $pdoreq->fetchall();
}
*/

echo json_encode($res);
