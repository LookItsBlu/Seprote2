<?php
    require_once "../bdd/BDD.php";

    $res = $bdd->query("SELECT id_u,nom,prenom,mail,nom_r FROM utilisateur INNER JOIN role ON id_r = id_role WHERE id_role >= 2");

    echo json_encode($res->fetchAll());

?>
