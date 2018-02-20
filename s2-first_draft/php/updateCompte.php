<?php
require_once "../bdd/BDD.php";

if(isset($_POST["id"]) && isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["mail"]) && isset($_POST["role"])){

    $req = $bdd->prepare('UPDATE utilisateur SET id_u = :id, nom = :nom, prenom = :prenom, mail = :mail, id_role = :role  WHERE id_u = :id');
    $res = $req->execute(array(
        "nom"=> $_POST["nom"],
        "prenom"=> $_POST["prenom"],
        "mail"=> $_POST["mail"],
        "id"=> $_POST["id"],
        "role"=> $_POST["role"]
    ));
    //header('Location: gestion_compte.php');

}
