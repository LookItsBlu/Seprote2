<div id="header">
    <div class="wrap">
        <img class="seprote" src="src/seprote.png" alt="Seprote" />
    </div>
    <img class="iut" src="src/iut2.png" alt="IUT Calais Boulogne" />
</div>

<div id="menuBar">
    <ul>
        <li><a class="itemName" href="index.php">Accueil</a></li>
        <li><a class="itemName" href="liste_programme.php">Liste des programmes</a></li>
        <?php if($_SESSION['role'] < 3){ ?>
        <li><a class="itemName" href="gestion_compte.php">Gestion des comptes</a></li>
        <?php } ?>
        <li><a class="itemName" href="logout.php">Déconnexion</a></li>
    </ul>
</div>
