<?php
include ('../../../bdd/BDD.php');

/*
$_POST['breadcrum']:
[0] => id_annee
[1] => id_formation
[2] => id_semestre
[3] => id_periode
[4] => id_module

$_POST['new_values']:
semestres, periodes:
[0] => date debut
[1] => date fin
modules:
[0] => nom
[1] => code
le reste:
[0] => nom
*/

$res = '';

switch(count($_POST['breadcrum'])-1){
    case 0: // formation
        $sql = 'INSERT INTO formation(nom_f, id_d) VALUES(?, 1)';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute($_POST['new_values'][0]);

        $sql = 'INSERT INTO for_annee VALUES(:id_formation, :id_annee)';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute(array(
            ':id_annee' => $_POST['breadcrum'][0],
            ':id_formation' => $bdd->lastInsertId()
        ));
        break;
    case 1: // semestre
        $sql = 'INSERT INTO semestre() VALUES()';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute($_POST['new_values'][0]);

        $sql = 'INSERT INTO for_annee VALUES(:id_formation, :id_annee)';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute(array(
            ':id_annee' => $_POST['breadcrum'][0],
            ':id_formation' => $bdd->lastInsertId()
        ));
        break;
    case 2: // periode

    case 3: // module

    default:
        break;
}

echo(true); //json_encode($res)
