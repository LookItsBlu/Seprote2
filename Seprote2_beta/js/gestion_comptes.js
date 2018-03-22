import accountList from '../lib/accountList/accountList.js';

$(document).ready(()=>{
    //Init accountList
    new accountList($('#ListeComptes')[0]);

    // Send form
    $('.addCompte').on('submit', function (e) {
        e.preventDefault();

        window.dispatchEvent(new CustomEvent("accountList Add",
            {
                detail: {
                    nom: e.target.nom.value,
                    prenom: e.target.prenom.value,
                    mail: e.target.mail.value,
                    id_role: e.target.id_role.value,
                    mdp: e.target.mdp.value
                }
            }
        ));
    });
});
