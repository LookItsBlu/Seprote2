import infoListItem from './infoListItem.js'

export default class InfoList {
    constructor(div) {
        this.base = div;

        this.niveaux = [
            //"Année",
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

        this.getRole(this, this.createItems);
    }

    getRole(obj, callback) {
        $.ajax({
            url: 'lib/infoList/php/infoList.getRole.php',
            success: function (data) {
                obj.role = data;
                callback(obj);
            }
        });
    }

    createItems(obj) {
        obj.items = new Array();

        let display = [];
        let data_cells = obj.displayed_value[obj.event.parent.depth];
        obj.fetched.forEach(elem => {
            display = [];
            if(data_cells.constructor === Array)
                for(let value of data_cells)
                    display.push(elem[value])
            else
                display.push(elem[data_cells])

            obj.items.push(new infoListItem(obj, display, elem[0]));
        });

        //ajoute un button pour ajouter une nouvelle valeur
        if(obj.role < 3) {
            display = [];
            if(data_cells.constructor === Array)
                for(let value of data_cells) display.push('')
            else display.push('')

            let add_button = new infoListItem(obj, display, -1);
            add_button.makeAddButton();
            obj.items.push(add_button);
        }

        obj.createTable(obj);
    }

    updateList(obj) {

        let tableHTML = '<thead>';

        let value_names = obj.niveaux[obj.event.parent.depth];
        if(value_names.constructor === Array)
            for(let value_name of value_names)
                tableHTML += '<th>'+value_name+'</th>';
        else tableHTML += '<th>'+value_names+'</th>';

        if(obj.role < 3) tableHTML += "<th></th><th></th><th></th>"

        tableHTML += "</thead><tbody>";
        obj.items.forEach(item => { tableHTML += item.displayItem(); });
        tableHTML += "</tbody>";

        obj.base.innerHTML = tableHTML;

        // set clicks
        obj.items.forEach(item => { item.setClick(); });
    }

    createTable(obj) {
        let tableHTML = '<thead>';

        let value_names = obj.niveaux[obj.event.parent.depth];
        if (value_names.constructor === Array)
            for (let value_name of value_names)
                tableHTML += '<th>' + value_name + '</th>';
        else tableHTML = '<th>' + value_names + '</th>';

        if (obj.role < 3) tableHTML += "<th></th><th></th><th></th>"

        tableHTML += "</thead><tbody>";
        obj.items.forEach(item => { tableHTML += item.displayItem(); });
        tableHTML += "</tbody>";

        obj.base.innerHTML = tableHTML;

        // set clicks
        obj.items.forEach(item => {
            item.setClick();
        });

        // look for events
        obj.checkForEvents(obj);
    }

    checkForEvents(obj) {
        window.addEventListener("infoList Update", event => {
            obj.updateList(obj);
        });

        window.addEventListener("infoList Delete", event => {
            obj.items = obj.items.filter(obj => {
                return obj.id !== event.detail.id && obj.class !== event.detail.class;
            });
            obj.updateList(obj);
        });

        window.addEventListener("infoList Refetch", event =>{
            $.ajax({
                method: 'post',
                url: 'lib/infoList/php/infoList.gatherInfo.php',
                data: { 'depth': obj.event.parent.depth, 'id': obj.event.item.id },
                success: function(data){
                    if (data === 'end') return 0;
                    else obj.updateItems(obj.event, JSON.parse(data));
                }
            });
        });
    }
}
