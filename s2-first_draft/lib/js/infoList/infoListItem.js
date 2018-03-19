export default class infoListItem {
    constructor(parent, displayed_value, id, breadcrum) {
        this.parent = parent;                               //la liste a laquelle chaque item appartient
        this.id = parseInt(id);                             //l'id de chaque item dans la bdd
        this.display = displayed_value;                     //la valeur affiché
        this.breadcrum = breadcrum;                         //chemin d'id menant vers cette liste
        this.class = 'infoListItem-..value..'.strcast({
            "value": Math.random().toString(36).slice(2)    //chaque item de la liste a une classe géneré aléatoirement
        });
    }

    //créer le code html de l'item
    displayItem() {
        if(this.parent.role < 3) {
            this.display += `
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

        return "<tr class='..class..'>..item..</tr>".strcast({
            "class": this.class,
            "item": this.display
        });
    }

    setClick() {
        var p = this;

        document.querySelector('.'+p.class+' .icon_renom').addEventListener("click", ()=>{
            this.editItem();
        });
    }

    editItem(evt) {
        console.log('requested edit for '+this.class);

        window.dispatchEvent(new CustomEvent("infoList Edit",
            { detail: { class: this.class } }
        ));
    }
}
