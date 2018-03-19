import infoListItem from './infoListItem.js'

export default class InfoList {
    constructor(div) {
        this.base = div;

        this.niveaux = [
            //"Année",
            "Formation",
            [ "Debut de semestre", "Fin de semestre" ],
            [ "Debut de période", "Fin de période" ],
            "Module"
        ];
        this.displayed_value = [
            1, [1, 2], [1, 2], 1
        ];

        this.event = {};
        this.fetched = {};

        this.role = -1;
    }

    updateItems(event, new_items) {
        this.event = event;
        this.fetched = new_items;

        this.getRole(this, this.updateList);
    }

    getRole(obj, callback) {
        $.ajax({
            url: 'lib/js/infoList/php/infoList.getRole.php',
            success: function(data){ obj.role = data; callback(obj); }
        });
    }

    updateList(obj) {
        obj.items = new Array();

        obj.fetched.forEach(elem => {
            let display = '';
            let value_to_display = obj.displayed_value[obj.event.parent.depth];
            if(value_to_display.constructor === Array) {
                for(let value of value_to_display) {
                    display += "<td>..value..</td>".strcast({
                        "value": elem[value]
                    });
                }
            } else {
                display += "<td>..value..</td>".strcast({
                    "value": elem[value_to_display]
                });
            }

            obj.items.push(new infoListItem(obj, display, elem[0], obj.event.breadcrum));
        });

        obj.createTable(obj);
    }

    createTable(obj) {
        let tableHTML = '<thead>';

        let value_names = obj.niveaux[obj.event.parent.depth];
        if(value_names.constructor === Array)
            for(let value_name of value_names)
                tableHTML += '<th>'+value_name+'</th>';
        else tableHTML = '<th>'+value_names+'</th>';

        if(obj.role < 3) tableHTML += "<th></th><th></th><th></th>"

        tableHTML += "</thead><tbody>";
        obj.items.forEach(item => {
            tableHTML += item.displayItem();
        });
        tableHTML += "</tbody>";
        obj.base.innerHTML = tableHTML;

        // set clicks
        obj.items.forEach(item => { item.setClick(); });

        // look for events
        obj.checkForEvents();
    }

    checkForEvents() {
        window.addEventListener("infoList Edit", (event)=>{
            event.stopPropagation();
            let tds = [].slice.call($('.'+event.detail.class+' td'));

            tds = tds.slice(0, -3);
            for(let td in tds) {
                tds[td].innerHTML = "<input type='text' value='..oldval..'>".strcast({
                    "oldval": tds[td].innerHTML
                });
            }
        });
    }
}
