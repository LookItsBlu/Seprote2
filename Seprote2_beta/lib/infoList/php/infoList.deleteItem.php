<?php
include ('../../../bdd/BDD.php');

/*
$_POST['breadcrum']:
[0] => id_annee
[1] => id_formation
[2] => id_semestre
[3] => id_periode
[4] => id_module
*/

$res = '';

switch(count($_POST['breadcrum'])-1){
    case 0:
        $sql = 'DELETE FROM formation
        WHERE id_f IN (
            SELECT id_a FROM for_annee WHERE id_a = :id_annee AND id_f = :id_formation
        )';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute(array(
            ':id_annee' => $_POST['breadcrum'][0],
            ':id_formation' => $_POST['id']
        ));
        $res = $pdoreq->fetchall();
        break;
    case 1:
        $sql = 'DELETE FROM semestre
        WHERE id_prog IN (
            SELECT id_prog FROM prog_for
            INNER JOIN formation ON prog_for.id_f = formation.id_f
            INNER JOIN for_annee ON formation.id_f = for_annee.id_f
            WHERE id_a = :id_annee AND formation.id_f = :id_formation
            AND semestre.id_s = :id_semestre
        )';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute(array(
            ':id_annee' => $_POST['breadcrum'][0],
            ':id_formation' => $_POST['breadcrum'][1],
            ':id_semestre' => $_POST['id']
        ));
        $res = $pdoreq->fetchall();
        break;
    case 2:
        $sql = 'DELETE FROM periode
        WHERE id_p in (
            SELECT id_per FROM per_sem
            INNER JOIN semestre ON per_sem.id_sem = semestre.id_s
            INNER JOIN prog_for ON semestre.id_prog = prog_for.id_prog
            INNER JOIN formation ON prog_for.id_f = formation.id_f
            INNER JOIN for_annee ON formation.id_f = for_annee.id_f
            WHERE id_a = :id_annee AND formation.id_f = :id_formation
            AND semestre.id_s = :id_semestre AND periode.id_p = :id_periode
        )';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute(array(
            ':id_annee' => $_POST['breadcrum'][0],
            ':id_formation' => $_POST['breadcrum'][1],
            ':id_semestre' => $_POST['breadcrum'][2],
            ':id_periode' => $_POST['id']
        ));
        $res = $pdoreq->fetchall();
        break;
    case 3:
        $sql = 'DELETE FROM module
        WHERE id_m in (
            SELECT id_mod FROM per_mod
            INNER JOIN periode ON per_mod.id_per = periode.id_p
            INNER JOIN per_sem ON periode.id_p = per_sem.id_per
            INNER JOIN semestre ON per_sem.id_sem = semestre.id_s
            INNER JOIN prog_for ON semestre.id_prog = prog_for.id_prog
            INNER JOIN formation ON prog_for.id_f = formation.id_f
            INNER JOIN for_annee ON formation.id_f = for_annee.id_f
            WHERE id_a = :id_annee AND formation.id_f = :id_formation
            AND semestre.id_s = :id_semestre AND periode.id_p = :id_periode
            AND module.id_m = :id_module
        )';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute(array(
            ':id_annee' => $_POST['breadcrum'][0],
            ':id_formation' => $_POST['breadcrum'][1],
            ':id_semestre' => $_POST['breadcrum'][2],
            ':id_periode' => $_POST['breadcrum'][3],
            ':id_module' => $_POST['id']
        ));
        $res = $pdoreq->fetchall();
        break;
    case 4:
        $sql = 'DELETE FROM volume_horaire
        WHERE id_module in (
            SELECT id_m FROM module
            INNER JOIN per_mod ON module.id_m = per_mod.id_mod
            INNER JOIN periode ON per_mod.id_per = periode.id_p
            INNER JOIN per_sem ON periode.id_p = per_sem.id_per
            INNER JOIN semestre ON per_sem.id_sem = semestre.id_s
            INNER JOIN prog_for ON semestre.id_prog = prog_for.id_prog
            INNER JOIN formation ON prog_for.id_f = formation.id_f
            INNER JOIN for_annee ON formation.id_f = for_annee.id_f
            WHERE id_a = :id_annee AND formation.id_f = :id_formation
            AND semestre.id_s = :id_semestre AND periode.id_p = :id_periode
            AND module.id_m = :id_module
        )';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute(array(
            ':id_annee' => $_POST['breadcrum'][0],
            ':id_formation' => $_POST['breadcrum'][1],
            ':id_semestre' => $_POST['breadcrum'][2],
            ':id_periode' => $_POST['breadcrum'][3],
            ':id_module' => $_POST['id']
        ));
        $res = $pdoreq->fetchall();
        break;
    default:
        break;
}

echo(json_encode($res));
