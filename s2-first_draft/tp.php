<?php
	session_start();
	require_once "BDD.php";

	if(isset($_POST['mod']) && $_SESSION['role'] < 3  && isset($_POST['prof']) && isset($_POST['tp'])){
	$req  = $bdd->prepare("SELECT SUM(tp) as tp FROM volume_horaire WHERE id_module = :mod");
	$req->execute(array('mod' => $_POST['mod']));
	$res = $req->fetch();

	$group = $bdd->prepare("SELECT group_tp FROM formation WHERE id_for = (SELECT id_for FROM prog_for WHERE id_prog = :prog)");
	$group->execute(array('prog'=>$_POST['prog']));
	$group = $group->fetch();

	$req_2 = $bdd->prepare("SELECT tp FROM volume_horaire WHERE id_module = :mod AND id_utilisateur = :util");
	$req_2 ->execute(array('mod' => $_POST['mod'], 'util' => $_POST['prof']));
	$res_2 = $req_2->fetch();

	$req_ = $bdd->prepare("SELECT tp_g FROM module WHERE id_m = :mod");
	$req_->execute(array('mod' => $_POST['mod']));
	$res_ = $req_->fetch();

	echo ($group['group_tp'] * $res_['tp_g']) - ($res['tp'] + $_POST['tp'] - $res_2['tp']);
	}
?>
