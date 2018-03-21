<?php
    require_once "bdd/BDD.php";
    session_start();

    include('includes/header.php');
?>

    <div class="loginWrap">
        <img class="loginSeprote" src="src/seprote_logo.svg" alt="Seprote" />
        <div class="loginIutImg">
            <img class="loginIut" src="src/iut.png" alt="IUT Calais Boulogne" />
        </div>
        <div class="container">
            <div class="row">
                <div class="form_connex col-md-offset-3 col-md-6">
                    <form method="POST" action="login.php" id="loginForm">
                        <input type="text" placeholder="Adresse e-mail" name="login" />
                        <input type="password" placeholder="Mot de passe" name="mdp" />
                        <button type="input">Connexion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/ajax/checkLogin.js"></script>

    <?php include('includes/footer.php'); ?>
