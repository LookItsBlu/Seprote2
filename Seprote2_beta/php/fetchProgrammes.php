<?php
session_start();
require_once '../bdd/BDD.php';

$req_prog = $bdd->prepare('
    SELECT p.id_prog, p.prog_nom
    FROM programme p, prog_for pf, formation f, departement d
    WHERE p.id_prog=pf.id_prog
    AND pf.id_f=f.id_f AND f.id_d=d.id_d AND d.id_d=:id
');
$req_prog->bindValue(':id', $_SESSION['id_dep']);
$req_prog->execute();

$optionList = '';
while($prog = $req_prog->fetch())
    $optionList .= "<option value='".$prog['id_prog']."'>".$prog['prog_nom']."</option>";

echo $optionList;
