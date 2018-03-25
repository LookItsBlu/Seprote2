import accountListItem from './accountListItem.js'

export default class accountList {
    constructor(div) {
        this.base = div;

        this.headers = [
            "Nom", "Prénom",
            "Adresse mail",
            "Rôle", "Département"
        ];
        this.displayed_value = [1, 2, 3, 4, 5];

        this.event = {};
        this.fetched = {};

        this.getItems();

        // look for events
        this.checkForEvents();
    }

    getItems() {
        console.log('fetching items...');
        $.ajax({
            context: this,
            method: 'post',
            url: 'lib/accountList/php/accountList.gatherInfo.php',
            success: function (data) {
                this.fetched = JSON.parse(data);
                this.createItems();
            }
        });
    }

    createItems() {
        console.log('creating item objects...');
        this.items = new Array();

        let display = [];
        this.fetched.forEach(elem => {
            display = [];
            for(let value of this.displayed_value) display.push(elem[value])

            this.items.push(new accountListItem(this, display, elem[0]));
        });

        this.createTable();
    }

    createTable() {
        console.log('creating table...');

        let tableHTML = '<thead>';

        for(let header of this.headers) tableHTML += '<th>'+header+'</th>';

        tableHTML += "<th></th><th></th>"

        tableHTML += "</thead><tbody>";
        this.items.forEach(item => { tableHTML += item.displayItem(); });
        tableHTML += "</tbody>";

        this.base.innerHTML = tableHTML;

        // set clicks
        this.items.forEach(item => { item.setClick(); });
    }

    checkForEvents() {
        window.addEventListener("accountList Add", event => {
            let evt = event.detail;
            this.addItem({
                nom: evt.nom,
                prenom: evt.prenom,
                mail: evt.mail,
                id_role: evt.id_role,
                mdp: evt.mdp
            });
        });

        window.addEventListener("accountList Update", event => {
            this.createTable();
        });

        window.addEventListener("accountList Delete", event => {
            this.items = this.items.filter(item => {
                return item.id !== event.detail.id && item.class !== event.detail.class;
            });
            this.getItems();
        });
    }

    addItem(params) {
        let itemDOM = document.querySelector('.'+this.class);
        for(let i in this.display) {
            this.display[i] = Array.from(itemDOM.getElementsByTagName('input'))[i].value;
        }

        $.ajax({
            context: this,
            method: 'post',
            url: 'lib/accountList/php/accountList.addItem.php',
            data: params,
            success(data) {
                let decoded = JSON.parse(data);
                let message = {
                    title: decoded.title,
                    body: decoded.body
                }
                let notifType = decoded.type || 'error';

                if (Object.keys(message).length >= 0) {
                    notif.sendNotification(notifType, message, 5000);
                }

                this.getItems();
            }
        });
    }
}
