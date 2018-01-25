<?php

	require_once "../bdd/BDD.php";

	$req = $bdd->prepare("SELECT * FROM volume_horaire WHERE id_module = :mod AND id_utilisateur = :util");
	$req->execute(array("mod" => $_POST['mod'], "util" => $_POST['prof']));
	$error = $req->fetch();


	if(!$error){
		$req = $bdd->prepare("INSERT INTO volume_horaire VALUES(:mod, :util, :cm, :td, :tp)");
		$req->execute(array("cm" => $_POST['cm'],
		"td" => $_POST['td'],
		"tp" => $_POST['tp'],
		"mod" => $_POST['mod'],
		"util" => $_POST['prof']));
	}

	else{
		$req = $bdd->prepare("UPDATE volume_horaire SET cm = :cm, td = :td, tp = :tp WHERE id_module = :mod AND id_utilisateur = :util");
		$req->execute(array("cm" => $_POST['cm'],
		"td" => $_POST['td'],
		"tp" => $_POST['tp'],
		"mod" => $_POST['mod'],
		"util" => $_POST['prof']));

	}

	echo $error;
?>
