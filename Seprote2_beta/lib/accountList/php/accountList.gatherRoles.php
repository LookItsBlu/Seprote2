<?php
include ('../../../bdd/BDD.php');

$res = $bdd->query("SELECT * FROM role WHERE id_r>1");
echo json_encode($res->fetchAll());
