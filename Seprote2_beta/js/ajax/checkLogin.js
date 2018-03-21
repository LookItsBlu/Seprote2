$(document).ready(function(){
    $('#loginForm').on('submit', function(e){
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'php/checkLogin.php',
            data: { login: e.target.login.value, mdp: e.target.mdp.value },
            success: function(code) {
                var message = {};

                if(code == 1) {
                    window.location.href = 'index.php';
                }
                else if(code == 0) {
                    message.title = 'Login ou Mot de Passe Incorrect';
                    message.body = 'Connexion Impossible, veuillez réessayer';
                }
                else if(code == -1) {
                    message.title = 'Champ(s) vide';
                    message.body = 'Connexion Impossible, veuillez réessayer';
                }

                if(!$.isEmptyObject(message)) {
                    notif.sendNotification( 'error', message, 5000 );
                }
            }
        });
    });
});
