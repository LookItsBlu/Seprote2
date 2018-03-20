export default class infoListItem {
    constructor(parent, displayed_value, id) {
        this.parent = parent;                               //la liste a laquelle chaque item appartient
        this.id = parseInt(id);                             //l'id de chaque item dans la bdd
        this.display = displayed_value;                     //la valeur affiché
        this.breadcrum = parent.event.breadcrum;            //chemin d'id menant vers cette liste
        this.buttons = '';
        this.editing = false;
        this.isAddButton = false;
        this.class = 'infoListItem-..value..'.strcast({
            "value": Math.random().toString(36).slice(2)    //chaque item de la liste a une classe géneré aléatoirement
        });
    }

    makeAddButton() {
        this.editing = true;
        this.isAddButton = true;
    }

    //créer le code html de l'item
    displayItem() {
        if(this.isAddButton) {
            this.buttons = `
            <td class="icon_group list-item-add" colspan=10>
                <img class="editIcon icon_add" src="src/red-plus-add.png" alt="Ajouter" title="Ajouter une ligne" />
                Ajouter
            </td>
            `;
        }
        else if(this.parent.role < 3) {
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
        if(this.isAddButton) {
            document.querySelector('.list-item-add').addEventListener("click", ()=>{
                this.addItem();
            });
        }
        else if(this.parent.role < 3) {
            document.querySelector('.'+this.class+' .rename_item').addEventListener("click", ()=>{
                this.editItem();
            });
            document.querySelector('.'+this.class+' .delete_item').addEventListener("click", ()=>{
                this.deleteItem();
            });
        }
    }

    editItem() {
        let itemDOM = document.querySelector('.'+this.class);
        if(this.editing) {
            // update visible item
            for(let i in this.display) {
                this.display[i] = Array.from(itemDOM.getElementsByTagName('input'))[i].value;
            }
            // ...and send the update to the database
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
        $.ajax({
            method: 'post',
            url: 'lib/js/infoList/php/infoList.deleteItem.php',
            data: {
                'breadcrum': this.breadcrum,
                'id': this.id
            }
        });

        window.dispatchEvent(new CustomEvent("infoList Delete",
            {
                detail: {
                    id: this.id,
                    class: this.class
                }
            }
        ));
    }

    addItem() {
        let itemDOM = document.querySelector('.'+this.class);
        for(let i in this.display) {
            this.display[i] = Array.from(itemDOM.getElementsByTagName('input'))[i].value;
        }

        $.ajax({
            method: 'post',
            url: 'lib/js/infoList/php/infoList.addItem.php',
            data: {
                'breadcrum': this.breadcrum,
                'new_values': this.display
            }
        });
    }
}
