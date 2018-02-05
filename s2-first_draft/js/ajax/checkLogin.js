$(document).ready(function(){
    $('#loginForm').on('submit', function(e){
        e.preventDefault();

        var params = 'login=@@login@@&mdp=@@mdp@@'.strcast({
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
                    message.title = 'Connexion Impossible';
                    message.body = 'Login ou Mot de Passe Incorrect';
                }
                else if(code == -1) {
                    message.title = 'Connexion Impossible';
                    message.body = "L'un des 2 champs est vide";
                }

                if(!$.isEmptyObject(message)) {
                    notif.sendNotification( 'error', message, 2000 );
                }
            }
        });
    });
});
