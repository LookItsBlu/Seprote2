<?php
require_once "../bdd/BDD.php";
$req_identiq = $bdd->prepare('SELECT mail FROM utilisateur WHERE mail = :mail');
$req_identiq->execute(array(
    'mail' => $_POST['mail'],
));

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
else if($req_identiq->fetch()){
    echo -4;
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

    if(!$req_ajout){
        echo -5;
    } else{
        echo 1;
    }
}
