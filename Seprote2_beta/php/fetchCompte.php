<?php
    require_once "../bdd/BDD.php";

    $res = $bdd->query("SELECT utilisateur.id_u,nom,prenom,mail,nom_r,nom_d FROM utilisateur LEFT JOIN util_dep ON util_dep.id_u = utilisateur.id_u LEFT JOIN departement ON util_dep.id_d = departement.id_d INNER JOIN role ON id_r = id_role WHERE id_role >= 2");
    echo json_encode($res->fetchAll());

?>
