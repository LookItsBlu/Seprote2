function updateList() {
    $.ajax({
        type: 'POST',
        url: 'php/fetchCompte.php',
        success: function (view) {
            view = JSON.parse(view);
            var itemList = [];

            $.each(view, function (i, object) {
                itemList.push("<tr><td class='name'>" + object.nom + "</td> <td class='pname'>" + object.prenom + "</td><td class='mail'>" + object.mail + "</td><td class='rol_value'>" + object.nom_r + "</td><td><input name='edit' type='button' value='Éditer' id='" + object.id_u + "'></td><td><input name='delete' type='button' value='Supprimer' id='delete" + object.nom + "'></td></tr>");
            });
            console.log(itemList.join(''));
            $('#ListeComptes tbody').html(itemList.join(''));
        }
    });
}
updateList();
