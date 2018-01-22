<?php
	session_start();
	require_once "BDD.php";

	if(isset($_POST['mod']) && $_SESSION['role'] < 3  && isset($_POST['prof']) && isset($_POST['td'])){
		$req  = $bdd->prepare("SELECT SUM(td) as td FROM volume_horaire WHERE id_module = :mod");
		$req->execute(array('mod' => $_POST['mod']));
		$res = $req->fetch();

		$group = $bdd->prepare("SELECT group_td FROM formation WHERE id_for = (SELECT id_for FROM prog_for WHERE id_prog = :prog)");
		$group->execute(array('prog'=>$_POST['prog']));
		$group = $group->fetch();

		$req_2 = $bdd->prepare("SELECT td FROM volume_horaire WHERE id_module = :mod AND id_utilisateur = :util");
		$req_2 ->execute(array('mod' => $_POST['mod'], 'util' => $_POST['prof']));
		$res_2 = $req_2->fetch();

		$req_ = $bdd->prepare("SELECT td_g FROM module WHERE id_m = :mod");
		$req_->execute(array('mod' => $_POST['mod']));
		$res_ = $req_->fetch();

		echo ($group['group_td'] * $res_['td_g']) - ($res['td'] + $_POST['td'] - $res_2['td']);
	}
?>
