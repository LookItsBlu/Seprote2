<?php
include ('../../../bdd/BDD.php');

$level = array(
    //"annee",
    "formation",
    "semestre",
    "periode",
    "module",
    ""
);

$res = '';

switch($level[$_POST['depth']]){
    /*case 'annee':
        $sql = 'SELECT * FROM annee';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute();
        $res = $pdoreq->fetchall();
        break;
    */
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
    default:
        break;
}

if (empty($res)) echo('end');
else echo(json_encode($res));
