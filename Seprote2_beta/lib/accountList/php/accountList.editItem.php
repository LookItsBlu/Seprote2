<?php
include ('../../../bdd/BDD.php');

if( isset($_POST["new_values"]) ){

    $req = $bdd->prepare('
    UPDATE utilisateur
    SET id_u = :id, nom = :nom, prenom = :prenom, mail = :mail, id_role = :role
    WHERE id_u = :id
    ');
    $res = $req->execute(array(
        "nom"=> $_POST["new_values"][0],
        "prenom"=> $_POST["new_values"][1],
        "mail"=> $_POST["new_values"][2],
        "role"=> $_POST["new_values"][3],
        "id"=> $_POST["id"]
    ));
}
