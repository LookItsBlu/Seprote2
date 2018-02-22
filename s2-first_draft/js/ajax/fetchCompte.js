function updateList() {
    $.ajax({
        type: 'POST',
        url: 'php/fetchCompte.php',
        success: function (view) {
            console.log(view);
            view = JSON.parse(view);
            var itemList = [];

            $.each(view, function (i, object) {
                itemList.push("<tr id=" + object.id_u + "><td class='name'>" + object.nom + "</td> <td class='pname'>" + object.prenom + "</td><td class='mail'>" + object.mail + "</td><td class='rol_value'>" + object.nom_r + "</td><td class='dptm'>" + object.nom_d + "</td><td id='edit'><input name='edit' type='button' value='Éditer' id='edit" + object.id_u + "'></td><td id='delete'><input name='delete' type='button' value='Supprimer' id='delete" + object.id_u + "'></td></tr>");
            });
            $('#ListeComptes tbody').html(itemList.join(''));
        }
    });
}
updateList();
