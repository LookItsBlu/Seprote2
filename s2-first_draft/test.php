<?php

session_start();

require_once "bdd/BDD.php";

include('includes/header.php');

if(!empty($_SESSION['id'])){ // On est connecté
?>

    <?php include('includes/menu.php'); ?>

    <table id="ListeComptes" class="sep_table col-md-12">
        <form id="delete_users" method="POST" action="#">
            <input type='hidden' name='type_form' value='3'>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Adresse mail</th>
                    <th>Rôle</th>
                    <th>Éditer</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <tr class='odd'>
                    <td id='name'>
                        Machin
                    </td>
                    <td id='pname'>
                        truc
                    </td>
                    <td id='mail'>
                        e@e.e
                    </td>
                    <td id='rol_value'>
                        Professeur
                    </td>
                    <td id="edit">
                        <input name='edit' type='button' value='Éditer' id="1">
                    </td>
                    <td id="delete">
                        <input name='delete' type='button' value='Supprimer' id='delete1'>
                    </td>
                </tr>
            </tbody>
        </form>
    </table>
    <script src="js/ajax/updateCompte.js"></script>
    <?php
		}

    else header('Location: login.php');

    include('includes/footer.php');
?>
