import infoListItem from './infoListItem.js'

export default class InfoList {
    constructor(div) {
        this.base = div;

        this.niveaux = [
            //"Année",
            "Formation",
            ["Debut de semestre", "Fin de semestre"],
            ["Debut de période", "Fin de période"],
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

        this.getRole(this, this.createItems);
    }

    getRole(obj, callback) {
        $.ajax({
            url: 'lib/js/infoList/php/infoList.getRole.php',
            success: function (data) {
                obj.role = data;
                callback(obj);
            }
        });
    }

    createItems(obj) {
        obj.items = new Array();

        obj.fetched.forEach(elem => {
            let display = [];
            let value_to_display = obj.displayed_value[obj.event.parent.depth];
<<<<<<< HEAD
            if (value_to_display.constructor === Array) {
                for (let value of value_to_display) {
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
=======
            if(value_to_display.constructor === Array)
                for(let value of value_to_display)
                    display.push(elem[value])
            else
                display.push(elem[value_to_display])

            obj.items.push(new infoListItem(obj, display, elem[0]));
>>>>>>> master/master
        });

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
<<<<<<< HEAD
        if (value_names.constructor === Array)
            for (let value_name of value_names)
                tableHTML += '<th>' + value_name + '</th>';
        else tableHTML = '<th>' + value_names + '</th>';
=======
        if(value_names.constructor === Array)
            for(let value_name of value_names)
                tableHTML += '<th>'+value_name+'</th>';
        else tableHTML += '<th>'+value_names+'</th>';
>>>>>>> master/master

        if (obj.role < 3) tableHTML += "<th></th><th></th><th></th>"

        tableHTML += "</thead><tbody>";

        obj.items.forEach(item => {
            tableHTML += item.displayItem();
        });
        tableHTML += "</tbody>";
        obj.base.innerHTML = tableHTML;

        //ajoute un button pour ajouter une nouvelle valeur
        var addBtn = document.createElement("tr"),
            addBtnCell = document.createElement("td"),
            addImg = document.createElement("img"),
            addTxt = document.createTextNode("Ajouter");
        addImg.src = "src/red-plus-add.png";
        addBtn.appendChild(addBtnCell);
        addBtnCell.appendChild(addImg);
        addBtnCell.appendChild(addTxt);
        addBtnCell.setAttribute("colspan", "10");
        addBtn.className = 'list-item-add';
        obj.base.children[1].appendChild(addBtn);

        // set clicks
        obj.items.forEach(item => {
            item.setClick();
        });

        // look for events
        obj.checkForEvents(obj);
    }

<<<<<<< HEAD
    checkForEvents() {
        window.addEventListener("infoList Edit", (event) => {
            event.stopPropagation();
            let tds = [].slice.call($('.' + event.detail.class + ' td'));

            tds = tds.slice(0, -3);
            for (let td in tds) {
                tds[td].innerHTML = "<input type='text' value='..oldval..'>".strcast({
                    "oldval": tds[td].innerHTML
                });
            }
=======
    checkForEvents(obj) {
        window.addEventListener("infoList Update", (event)=>{
            obj.updateList(obj);
>>>>>>> master/master
        });

        window.addEventListener("infoList Delete", (event)=>{
            obj.items = obj.items.filter(obj => {
                return obj.id !== event.detail.id && obj.class !== event.detail.class;
            });
            obj.updateList(obj);
        });
    }
}
