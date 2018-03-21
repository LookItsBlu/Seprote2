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
        $sql = 'UPDATE formation
        INNER JOIN for_annee ON formation.id_f = for_annee.id_f
        SET nom_f = :new
        WHERE id_a = :id_annee AND formation.id_f = :id_formation';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute(array(
            ':id_annee' => $_POST['breadcrum'][0],
            ':id_formation' => $_POST['id'],
            ':new' => $_POST['new_values'][0]
        ));
        $res = $pdoreq->fetchall();
        break;
    case 1:
        $sql = 'UPDATE semestre
        INNER JOIN prog_for ON semestre.id_prog = prog_for.id_prog
        INNER JOIN formation ON prog_for.id_f = formation.id_f
        INNER JOIN for_annee ON formation.id_f = for_annee.id_f
        SET dat_deb_s = :new, dat_fin_s = :new2
        WHERE id_a = :id_annee AND formation.id_f = :id_formation
        AND semestre.id_s = :id_semestre';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute(array(
            ':id_annee' => $_POST['breadcrum'][0],
            ':id_formation' => $_POST['breadcrum'][1],
            ':id_semestre' => $_POST['id'],
            ':new' => $_POST['new_values'][0],
            ':new2' => $_POST['new_values'][1]
        ));
        $res = $pdoreq->fetchall();
        break;
    case 2:
        $sql = 'UPDATE periode
        INNER JOIN per_sem ON periode.id_p = per_sem.id_per
        INNER JOIN semestre ON per_sem.id_sem = semestre.id_s
        INNER JOIN prog_for ON semestre.id_prog = prog_for.id_prog
        INNER JOIN formation ON prog_for.id_f = formation.id_f
        INNER JOIN for_annee ON formation.id_f = for_annee.id_f
        SET dat_deb_p = :new, dat_fin_p = :new2
        WHERE id_a = :id_annee AND formation.id_f = :id_formation
        AND semestre.id_s = :id_semestre AND periode.id_p = :id_periode';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute(array(
            ':id_annee' => $_POST['breadcrum'][0],
            ':id_formation' => $_POST['breadcrum'][1],
            ':id_semestre' => $_POST['breadcrum'][2],
            ':id_periode' => $_POST['id'],
            ':new' => $_POST['new_values'][0],
            ':new2' => $_POST['new_values'][1]
        ));
        $res = $pdoreq->fetchall();
        break;
    case 3:
        $sql = 'UPDATE module
        INNER JOIN per_mod ON module.id_m = per_mod.id_mod
        INNER JOIN periode ON per_mod.id_per = periode.id_p
        INNER JOIN per_sem ON periode.id_p = per_sem.id_per
        INNER JOIN semestre ON per_sem.id_sem = semestre.id_s
        INNER JOIN prog_for ON semestre.id_prog = prog_for.id_prog
        INNER JOIN formation ON prog_for.id_f = formation.id_f
        INNER JOIN for_annee ON formation.id_f = for_annee.id_f
        SET nom_m = :new
        WHERE id_a = :id_annee AND formation.id_f = :id_formation
        AND semestre.id_s = :id_semestre AND periode.id_p = :id_periode
        AND module.id_m = :id_module';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute(array(
            ':id_annee' => $_POST['breadcrum'][0],
            ':id_formation' => $_POST['breadcrum'][1],
            ':id_semestre' => $_POST['breadcrum'][2],
            ':id_periode' => $_POST['breadcrum'][3],
            ':id_module' => $_POST['id'],
            ':new' => $_POST['new_values'][0]
        ));
        $res = $pdoreq->fetchall();
        break;
    case 4:
        $sql = 'UPDATE volume_horaire
        INNER JOIN utilisateur ON volume_horaire.id_utilisateur = utilisateur.id_u
        INNER JOIN module ON volume_horaire.id_module = module.id_m
        INNER JOIN per_mod ON module.id_m = per_mod.id_mod
        INNER JOIN periode ON per_mod.id_per = periode.id_p
        INNER JOIN per_sem ON periode.id_p = per_sem.id_per
        INNER JOIN semestre ON per_sem.id_sem = semestre.id_s
        INNER JOIN prog_for ON semestre.id_prog = prog_for.id_prog
        INNER JOIN formation ON prog_for.id_f = formation.id_f
        INNER JOIN for_annee ON formation.id_f = for_annee.id_f
        SET cm = :new, td = :new2, tp = :new3
        WHERE id_a = :id_annee AND formation.id_f = :id_formation
        AND semestre.id_s = :id_semestre AND periode.id_p = :id_periode
        AND volume_horaire.id_module = :id_module';
        $pdoreq = $bdd->prepare($sql);
        $pdoreq->execute(array(
            ':id_annee' => $_POST['breadcrum'][0],
            ':id_formation' => $_POST['breadcrum'][1],
            ':id_semestre' => $_POST['breadcrum'][2],
            ':id_periode' => $_POST['breadcrum'][3],
            ':id_module' => $_POST['id'],
            ':new' => $_POST['new_values'][2],
            ':new2' => $_POST['new_values'][3],
            ':new3' => $_POST['new_values'][4]
        ));
        $res = $pdoreq->fetchall();
        break;
    default:
        break;
}

echo(json_encode($res));
