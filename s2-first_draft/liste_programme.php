<?php
	session_start();
    require_once "bdd/BDD.php";
	include('includes/header.php');

	if(!empty($_SESSION['id'])){ // On est connecter
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
                        <?php for($i=9;$i>0;$i--){ ?>
                        <tr>
                            <td class="col_name">
                                <?php echo "<a>201".$i."-201".($i-1)."</a>";?>
                            </td>
                        </tr>
                        <?php } ?>
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
    <script>
        $('.cursor_drag').draggable({
            axis: 'x',
            containment: 'parent',
            helper: 'clone',
            start: function(event, ui) {
                $(this).attr('start_offset', $(this).offset().left);
                $(this).attr('start_next_width', $(this).next().width());
            },
            drag: function(event, ui) {
                var prev_element = $(this).prev();
                var next_element = $(this).next();
                var x_difference = $(this).attr('start_offset') - ui.offset.left;
                prev_element.width(ui.offset.left - prev_element.offset().left);
                next_element.width(parseInt($(this).attr('start_next_width')) + x_difference);
            }
        });

        /*if ($('.zone').width() <= 50 px) {
            ui.draggable.draggable('option', 'revert', true);
        }*/

    </script>
    <?php
        include('includes/footer.php');
    }
    else {
        header('location: login.php');
    }
?>
