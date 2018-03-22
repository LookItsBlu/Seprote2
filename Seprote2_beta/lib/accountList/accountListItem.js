export default class accountListItem {
    constructor(parent, displayed_value, id) {
        this.parent = parent;                               //la liste a laquelle chaque item appartient
        this.id = parseInt(id);                             //l'id de chaque item dans la bdd
        this.display = displayed_value;                     //la valeur affiché
        this.editing = false;
        this.class = 'accountListItem-..value..'.strcast({
            "value": Math.random().toString(36).slice(2)    //chaque item de la liste a une classe géneré aléatoirement
        });
    }

    //créer le code html de l'item
    displayItem() {
        let action_buttons = `
        <td id='edit'>
            <button class='account_edit'>Éditer</button>
        </td>
        <td id='delete'>
            <button class='account_delete'>Supprimer</button>
        </td>
        `;

        let display_html = '';
        for(let i in this.display)
            if(this.editing)
                display_html += "<td><input type='text' value='"+this.display[i]+"'></td>";
            else
                display_html += '<td>'+this.display[i]+'</td>';

        return "<tr class='..class..'>..item.. ..buttons..</tr>".strcast({
            "class": this.class,
            "item": display_html,
            "buttons": action_buttons
        });
    }

    setClick() {
        document.querySelector('.'+this.class+' .account_edit').addEventListener("click", ()=>{
            this.editItem();
        });
        document.querySelector('.'+this.class+' .account_delete').addEventListener("click", ()=>{
            this.deleteItem();
        });
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
                url: 'lib/accountList/php/accountList.editItem.php',
                data: {
                    'id': this.id,
                    'new_values': this.display
                }
            });
        }

        this.editing = !this.editing;
        window.dispatchEvent(new CustomEvent("accountList Update"));
    }

    deleteItem() {
        if (confirm("Voulez-vous vraiment supprimer ce compte ?")) {
            $.ajax({
                method: 'post',
                url: 'lib/accountList/php/accountList.deleteItem.php',
                data: { 'id': this.id },
                success(data) {
                    notif.sendNotification('success', {
                        title: 'Compte supprimé !',
                        body: 'Le compte a été supprimé avec succès !'
                    }, 5000);

                    window.dispatchEvent(new CustomEvent("accountList Delete",
                        { detail: { id: this.id, class: this.class } }
                    ));
                }
            });
        }
    }
}
