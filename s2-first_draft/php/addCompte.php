<?php
require_once "../bdd/BDD.php";

if(empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['mail'])|| empty($_POST['mdp'])){
    echo 0;
}

else if($_POST['id_role'] != 1 && $_POST['id_role'] != 2 && $_POST['id_role'] != 3 || empty($_POST['id_role'])){
    echo -1;
    //$ERROR = "Id du rôle incorrect !";
}

else if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
    echo -2;
    //$ERROR = "Adresse mail incorrecte !";
}

else if(strlen($_POST['mdp']) < 6){
    echo -3;
    //$ERROR = "Mot de passe trop court !";
}

/********** REQUETE A EFFECTUER **************/

else{
    $req_ajout = $bdd->prepare("INSERT INTO utilisateur(nom,prenom,mail,id_role,mdp) VALUES(:nom,:prenom,:mail,:id_role,:mdp)");					$req_ajout->execute(array(
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'mail' => $_POST['mail'],
        'id_role' => $_POST['id_role'],
        'mdp' => sha1($_POST['mdp'])
    ));
    //header('Location: gestion_compte.php');

    if(!$req_ajout){
        echo -4;
    } else{
        echo 1;
    }
}
