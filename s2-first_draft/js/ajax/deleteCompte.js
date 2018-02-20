$(document).ready(function () {
    $('#ListeComptes').on('click', "input[name='delete']", function () {
        if (confirm("Voulez-vous vraiment supprimer ce compte ?")) {
            var idd = $(this)[0].id;
            var y = idd.substring('6', idd.length);

            var params = 'idD=' + y;
            //$("#delete_users").submit();

            $.ajax({
                type: 'POST',
                url: 'php/deleteCompte.php',
                data: params,
                success: function () {
                    updateList();
                }
            });
        }
    });
});
