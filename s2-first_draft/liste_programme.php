<?php
	session_start();
    require_once "bdd/BDD.php";
	include('includes/header.php');

	if(!empty($_SESSION['id'])){ // On est connecter
	   include('includes/menu.php');
?>

    <div id="main">
        <div class="main_content">
            <div class="zone zone_arbor">
                <div class="container">
                    <div class="row">
                        <ul>
                            <li>2017-2018</li>
                            <li>2016-2017</li>
                            <li>2015-2016</li>
                            <li>2014-2015</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="zone zone_table">
                <div class="container">
                    <div class="row">
                        <table class="table_program">
                            <thead>
                                <tr>
                                    <th>Titre1</th>
                                    <th>Titre2</th>
                                    <th>Titre3</th>
                                </tr>
                            </thead>
                            <tbody>
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
        </div>
    </div>

    <?php
        include('includes/footer.php');
    }
    else {
        header('location: login.php');
    }
?>
