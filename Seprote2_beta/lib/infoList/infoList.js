import infoListItem from './infoListItem.js'

export default class InfoList {
    constructor(div) {
        this.base = div;

        this.niveaux = [
            "Formation",
            ["Debut de semestre", "Fin de semestre"],
            ["Debut de période", "Fin de période"],
            ["Module", "Code"],
            ["Nom", "Prenom", "Heures de CM", "Heures de TD", "Heures de TP"]
        ];
        this.displayed_value = [
            1, [1, 2], [1, 2], [1, 2], [12, 13, 2, 3, 4]
        ];

        this.event = {};
        this.fetched = {};

        this.role = -1;
    }

    updateItems(event, new_items) {
        this.event = event;
        this.fetched = new_items;

        $.ajax({
            url: 'lib/infoList/php/infoList.getRole.php',
            context: this,
            success: function (data) {
                this.role = data;
                this.createItems();
            }
        });
    }

    createItems() {
        this.items = new Array();

        let display = [];
        let data_cells = this.displayed_value[this.event.parent.depth];
        this.fetched.forEach(elem => {
            display = [];
            if(data_cells.constructor === Array)
                for(let value of data_cells)
                    display.push(elem[value])
            else
                display.push(elem[data_cells])

            this.items.push(new infoListItem(this, display, elem[0]));
        });

        //ajoute un button pour ajouter une nouvelle valeur
        if(this.role < 3) {
            display = [];
            if(data_cells.constructor === Array)
                for(let value of data_cells) display.push('')
            else display.push('')

            let add_button = new infoListItem(this, display, -1);
            add_button.makeAddButton();
            this.items.push(add_button);
        }

        this.createTable();
    }

    updateList() {

        let tableHTML = '<thead>';

        let value_names = this.niveaux[this.event.parent.depth];
        if(value_names.constructor === Array)
            for(let value_name of value_names)
                tableHTML += '<th>'+value_name+'</th>';
        else tableHTML += '<th>'+value_names+'</th>';

        if(this.role < 3) tableHTML += "<th></th><th></th><th></th>"

        tableHTML += "</thead><tbody>";
        this.items.forEach(item => { tableHTML += item.displayItem(); });
        tableHTML += "</tbody>";

        this.base.innerHTML = tableHTML;

        // set clicks
        this.items.forEach(item => { item.setClick(); });
    }

    createTable() {
        let tableHTML = '<thead>';

        let value_names = this.niveaux[this.event.parent.depth];
        if (value_names.constructor === Array)
            for (let value_name of value_names)
                tableHTML += '<th>' + value_name + '</th>';
        else tableHTML = '<th>' + value_names + '</th>';

        if (this.role < 3) tableHTML += "<th></th><th></th><th></th>"

        tableHTML += "</thead><tbody>";
        this.items.forEach(item => { tableHTML += item.displayItem(); });
        tableHTML += "</tbody>";

        this.base.innerHTML = tableHTML;

        // set clicks
        this.items.forEach(item => {
            item.setClick();
        });

        // look for events
        this.checkForEvents();
    }

    checkForEvents() {
        window.addEventListener("infoList Update", event => {
            this.updateList();
        });

        window.addEventListener("infoList Delete", event => {
            this.items = this.items.filter(item => {
                return item.id !== event.detail.id && item.class !== event.detail.class;
            });
            this.updateList();
        });

        window.addEventListener("infoList Refetch", event =>{
            $.ajax({
                method: 'post',
                url: 'lib/infoList/php/infoList.gatherInfo.php',
                data: { 'depth': this.event.parent.depth, 'id': this.event.item.id },
                context: this,
                success: function(data){
                    if (data === 'end') return 0;
                    else this.updateItems(this.event, JSON.parse(data));
                }
            });
        });
    }
}
