<?php
	session_start();

	if(empty($_SESSION['id'])){        // On n'est pas connecté
        header('location: login.php');
    }

    include('includes/header.php');
    include('includes/menu.php');
?>
<div id="main">
    <div class="main_content" id="MySplitter">
        <div class="zone zone_arbor">
            <table class="table form_table col-sm-12" id="liste_program">
            </table>
        </div>
        <div class="zone zone_table">
            <table class="table sep_table col-sm-12" id="table_program">
				<thead>
					<th></th>
                </thead>
            </table>
        </div>
    </div>
</div>

<script type='module' src='js/liste_programme.js'></script>

<?php include('includes/footer.php');?>
