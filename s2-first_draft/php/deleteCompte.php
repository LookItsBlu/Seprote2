<?php
require_once "../bdd/BDD.php";

if(isset($_POST["idD"])){
    $req_delete = $bdd->prepare("DELETE FROM utilisateur WHERE id_u = :id");
    $req_delete->execute(array( "id" => intval($_POST["idD"]) ));
}

?>
