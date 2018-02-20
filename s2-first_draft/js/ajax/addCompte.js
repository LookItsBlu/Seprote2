$(document).ready(function () {
    $('.addCompte').on('submit', function (e) {
        e.preventDefault();

        var params = 'nom=..nom..&prenom=..prenom..&mail=..mail..&id_role=..idRole..&mdp=..mdp..'.strcast({
            nom: e.target.nom.value,
            prenom: e.target.prenom.value,
            mail: e.target.mail.value,
            idRole: e.target.id_role.value,
            mdp: e.target.mdp.value
        });

        $.ajax({
            type: 'POST',
            url: 'php/addCompte.php',
            data: params,
            success: function (code) {
                var message = {
                    title: '',
                    body: '',
                };

                var notifType = 'error';

                if (code == 1) {
                    //window.location.href = 'gestion_compte.php';
                    notifType = 'success';
                    updateList();
                } else if (code == 0) {
                    message.title = 'Champ(s) vide(s) !';
                    message.body = 'Veuillez remplir tous les champs pour valider la création de ce compte.';
                } else if (code == -1) {
                    message.title = 'Id du rôle incorrect !';
                    message.body = "Veuillez sélectionner l'un des rôles présents dans la liste.";
                } else if (code == -2) {
                    message.title = 'Adresse mail incorrecte !';
                    message.body = 'Veuillez saisir une adresse e-mail conforme comme ci-contre : xx@xx.xx .';
                } else if (code == -3) {
                    message.title = 'Mot de passe trop court !';
                    message.body = 'Veuillez saisir un mot de passe comportant au moins 6 caractères.';
                } else if (code == -4) {
                    message.title = 'Erreur du serveur !';
                    message.body = 'Une erreur a eu lieu lors de la création de ce compte, veuillez réessayer ultérieurement.';
                }
                if (!$.isEmptyObject(message)) {
                    notif.sendNotification(notifType, message, 5000);
                }
            }
        });
    });
});
