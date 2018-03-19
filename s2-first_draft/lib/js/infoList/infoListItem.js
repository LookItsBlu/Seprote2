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
            <td class="icon_group">
                <img class="editIcon icon_renom" src="src/pencil.png" alt="Renommer" title="Renommer cette ligne" />
            </td>
            <td class="icon_group">
                <img class="editIcon icon_dupli" src="src/copy.png" alt="Dupliquer" title="Dupliquer cette ligne" />
            </td>
            <td class="icon_group">
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
        document.querySelector('.'+this.class+' .icon_renom').addEventListener("click", ()=>{
            this.editItem();
        });
    }

    editItem(evt) {
        let itemDOM = document.querySelector('.'+this.class);
        if(this.editing) {
            for(let i in this.display) {
                this.display[i] = Array.from(itemDOM.getElementsByTagName('input'))[i].value;
                // ajax modification dans la bdd ici
            }
        }

        this.editing = !this.editing;
        window.dispatchEvent(new CustomEvent("infoList Update"));
    }
}
