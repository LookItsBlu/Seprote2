<?php
	session_start();

	if(empty($_SESSION['id'])){        // On n'est pas connecter
        header('location: login.php');
    }

    include('includes/header.php');
    include('includes/menu.php');
?>
<div id="main">
    <div class="main_content" id="MySplitter">
        <div class="zone zone_arbor">
            <table class="table form_table col-sm-12" id="liste_program">
                <thead>
                    <tr>
                        <th class="titre_arbor col-sm-12">Année scolaire</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="cursor_drag">
            <img src="src/drag_icon.png" />
        </div>
        <div class="zone zone_table">
            <table class="table sep_table col-sm-12" id="table_program">
                <thead>
                    <tr>
                        <th>Titre1</th>
                        <th>Titre2</th>
                        <th>Titre3</th>
                        <?php if($_SESSION['role'] < 3){ echo "<th></th><th></th><th></th>"; }?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Info1</td>
                        <td>Info2</td>
                        <td>Info3</td>
                        <?php if($_SESSION['role'] < 3){ ?>
                        <td class="icon_group">
                            <img class="editIcon icon_renom" src="src/pencil.png" alt="Renommer" title="Renommer cette ligne" />
                        </td>
                        <td class="icon_group">
                            <img class="editIcon icon_dupli" src="src/copy.png" alt="Dupliquer" title="Dupliquer cette ligne" />
                        </td>
                        <td class="icon_group">
                            <img class="editIcon icon_suppr" src="src/trash.png" alt="Supprimer" title="Supprimer cette ligne" />
                        </td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td>Info1</td>
                        <td>Info2</td>
                        <td>Info3</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type='module' src='lib/js/listItem/TreeList.js'></script>
<script type='module' src='js/liste_programme.js'></script>

<?php include('includes/footer.php');?>
