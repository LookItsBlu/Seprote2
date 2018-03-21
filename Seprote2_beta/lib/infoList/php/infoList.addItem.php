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

			$sql = 'INSERT INTO for_annee(id_f, id_a) VALUES(:id_formation, :id_annee)';
			$pdoreq = $bdd->prepare($sql);
			$pdoreq->execute(array(
				':id_annee' => $_POST['breadcrum'][0],
				':id_formation' => $bdd->lastInsertId()
			));
			break;
		case 1: // semestre
			$sql = 'INSERT INTO semestre(dat_deb_s, dat_fin_s, id_prog) VALUES(:dat_deb, :dab_fin, :dept)';
			$pdoreq = $bdd->prepare($sql);
			$pdoreq->execute(array(
				':dat_deb' => $_POST['new_values'][0],
				':dab_fin' => $_POST['new_values'][1],
				':dept' => $_SESSION['id_dep']
			));
			break;
		case 2: // periode
			$sql = 'INSERT INTO periode(dat_deb_p, dat_fin_p) VALUES(:dat_deb, :dab_fin)';
			$pdoreq = $bdd->prepare($sql);
			$pdoreq->execute(array(
				':dat_deb' => $_POST['new_values'][0],
				':dab_fin' => $_POST['new_values'][1]
			));

			$sql = 'INSERT INTO per_sem(id_per, id_sem) VALUES(:id_periode, :id_semestre)';
			$pdoreq = $bdd->prepare($sql);
			$pdoreq->execute(array(
				':id_semestre' => $_POST['breadcrum'][2],
				':id_periode' => $bdd->lastInsertId()
			));
			break;
		case 3: // module
			$sql = 'INSERT INTO module(nom_m, code_m) VALUES(:nom, :code)';
			$pdoreq = $bdd->prepare($sql);
			$pdoreq->execute(array(
				':nom' => $_POST['new_values'][0],
				':code' => $_POST['new_values'][1]
			));

			$sql = 'INSERT INTO per_mod(id_per, id_mod) VALUES(:id_periode, :id_module)';
			$pdoreq = $bdd->prepare($sql);
			$pdoreq->execute(array(
				':id_periode' => $_POST['breadcrum'][3],
				':id_module' => $bdd->lastInsertId()
			));
			break;
		default:
			break;
	}

	echo(true); //json_encode($res)
?>
