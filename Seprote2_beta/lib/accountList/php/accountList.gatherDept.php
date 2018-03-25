<?php
include ('../../../bdd/BDD.php');

$res = $bdd->query("SELECT * FROM departement");
echo json_encode($res->fetchAll());
