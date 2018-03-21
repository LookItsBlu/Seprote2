<?php
require_once "../bdd/BDD.php";

if(
    !isset($_SESSION['id']) ||
    !isset($_SESSION['nom']) ||
    !isset($_SESSION['prenom']) ||
    !isset($_SESSION['role'])
){
    if(empty($_POST['login']) || empty($_POST['mdp'])){
        if(isset($_POST['login']) || isset($_POST['mdp'])){
            echo -1;
        }
    } else {
        $req = $bdd->prepare('SELECT id_u, mail, mdp, nom, prenom, id_role FROM utilisateur WHERE mail = :mail AND mdp = :mdp');
        $req->execute(array(
            'mail' => $_POST['login'],
            'mdp' => sha1($_POST['mdp'])
        ));

        $resultat = $req->fetch();

        if(!$resultat){
            echo 0;
        } else { // Connexion réussie !
            session_start();

            $_SESSION['id'] = $resultat['id_u'];
            $_SESSION['nom'] = $resultat['nom'];
            $_SESSION['prenom'] = $resultat['prenom'];
            $_SESSION['role'] = $resultat['id_role'];

            echo 1;
        }
    }
} else {
    echo 1;
}
