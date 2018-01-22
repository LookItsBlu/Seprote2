<?php
	session_start();
	require_once "BDD.php";

	if(isset($_POST['mod']) && $_SESSION['role'] < 3  && isset($_POST['prof']) && isset($_POST['cm'])){

	$req = $bdd->prepare("SELECT SUM(cm) as cm FROM volume_horaire WHERE id_module = :mod");
	$req->execute(array('mod' => $_POST['mod']));
	$res = $req->fetch();

	$req_2 = $bdd->prepare("SELECT cm FROM volume_horaire WHERE id_module = :mod AND id_utilisateur = :util");
	$req_2 ->execute(array('mod' => $_POST['mod'], 'util' => $_POST['prof']));
	$res_2 = $req_2->fetch();
	if(!$res_2) $res_2['cm'] = 0;
	$req_ = $bdd->prepare("SELECT cm_g FROM module WHERE id_m = :mod");
	$req_->execute(array('mod' => $_POST['mod']));
	$res_ = $req_->fetch();


	echo $res_['cm_g'] - ($res['cm'] + $_POST['cm'] - $res_2['cm']);
	}
?>
