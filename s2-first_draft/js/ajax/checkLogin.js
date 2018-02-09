$(document).ready(function(){
    $('#loginForm').on('submit', function(e){
        e.preventDefault();

        var params = 'login=..login..&mdp=..mdp..'.strcast({
            login: e.target.login.value,
            mdp: e.target.mdp.value
        });

        $.ajax({
            type: 'POST',
            url: 'php/checkLogin.php',
            data: params,
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
