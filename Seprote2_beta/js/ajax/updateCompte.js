$(document).ready(function () {
    $('#ListeComptes').on('click', "input[name='edit']", function () {

        console.log($('#name'));
        $("#name").html('<input name="editNom" type="text" value="">');
        $("#pname").html('<input name="editPrenom" type="text" value="">');
        $("#mail").html('<input name="editMail" type="mail" value="">');
        $("#rol_value").html('<select name="editRole" type="text">' + '<option value="2">Gestionnaire</option>' + '<option value="3">Professeur</option>');
        $("#edit").html('<input name="editConf" type="button" value="Confirmer" id="confirmer" class="btnActive">');
        $("#delete").html('<input name="editAnnul" type="button" value="Annuler" id="annuler" class="btnActive">');
    });
});
