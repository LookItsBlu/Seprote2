export default class infoListItem {
    constructor(parent, displayed_value, id, breadcrum) {
        this.parent = parent;                               //la liste a laquelle chaque item appartient
        this.id = parseInt(id);                             //l'id de chaque item dans la bdd
        this.display = displayed_value;                     //la valeur affiché
        this.breadcrum = parent.event.breadcrum;            //chemin d'id menant vers cette liste
        this.buttons = '';
        this.editing = false;
        this.class = 'infoListItem-..value..'.strcast({
            "value": Math.random().toString(36).slice(2)    //chaque item de la liste a une classe géneré aléatoirement
        });
    }

    //créer le code html de l'item
    displayItem() {
        if(this.parent.role < 3) {
            this.buttons = `
            <td class="icon_group rename_item">
                <img class="editIcon icon_renom" src="src/pencil.png" alt="Renommer" title="Renommer cette ligne" />
            </td>
            <td class="icon_group duplicate_item">
                <img class="editIcon icon_dupli" src="src/copy.png" alt="Dupliquer" title="Dupliquer cette ligne" />
            </td>
            <td class="icon_group delete_item">
                <img class="editIcon icon_suppr" src="src/trash.png" alt="Supprimer" title="Supprimer cette ligne" />
            </td>
            `;
        }

        let display_html = '';
        for(let i in this.display)
            if(this.editing)
                display_html += "<td><input type='text' value='"+this.display[i]+"'></td>";
            else
                display_html += '<td>'+this.display[i]+'</td>';

        return "<tr class='..class..'>..item.. ..buttons..</tr>".strcast({
            "class": this.class,
            "item": display_html,
            "buttons": this.buttons
        });
    }

    setClick() {
        document.querySelector('.'+this.class+' .rename_item').addEventListener("click", ()=>{
            this.editItem();
        });
        document.querySelector('.'+this.class+' .delete_item').addEventListener("click", ()=>{
            this.deleteItem();
        });
        document.querySelector('.list-item-add').addEventListener("click", ()=>{
            this.addItem();
        });
    }

    editItem() {
        let itemDOM = document.querySelector('.'+this.class);
        if(this.editing) {
            for(let i in this.display) {
                this.display[i] = Array.from(itemDOM.getElementsByTagName('input'))[i].value;
            }
            $.ajax({
                method: 'post',
                url: 'lib/js/infoList/php/infoList.editItem.php',
                data: {
                    'breadcrum': this.breadcrum,
                    'id': this.id,
                    'new_values': this.display
                }
            });
        }

        this.editing = !this.editing;
        window.dispatchEvent(new CustomEvent("infoList Update"));
    }

    deleteItem() {
        //console.log(this.breadcrum, this.id);
        $.ajax({
            method: 'post',
            url: 'lib/js/infoList/php/infoList.deleteItem.php',
            data: {
                'breadcrum': this.breadcrum,
                'id': this.id
            },
            success(data) {
                console.log(JSON.parse(data));
            }
        });

        window.dispatchEvent(new CustomEvent("infoList Update"));
    }

    addItem() {
        console.log('adding item...');
    }
}
