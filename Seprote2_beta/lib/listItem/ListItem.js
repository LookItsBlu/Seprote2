export default class ListItem {
    constructor(parent, displayed_value, id, history) {
        this.parent = parent;                               //la liste a laquelle chaque item appartient
        this.id = parseInt(id);                             //l'id de chaque item dans la bdd
        this.display = displayed_value;                     //la valeur affiché
        this.isActive = false;

        this.breadcrum = history.slice();                   //chemin d'id menant vers cette liste
        this.breadcrum.push(this.id);
        this.breadcrum.shift();

        this.class = 'item-..value..'.strcast({
            "value": Math.random().toString(36).slice(2)    //chaque item de la liste a une classe géneré aléatoirement
        });
    }

    //créer le code html de l'item
    displayItem() {
        return "<tr class='..class..'><td class='col_name'>..name..</td></tr>".strcast({
            "class": this.class,
            "name": this.display
        });
    }

    makeActive(isActive) {
        let itemSelect = document.querySelector('.'+this.class);
        if (isActive) {
            itemSelect.classList.add('treelist-item-active');
            this.isActive = true;
        } else {
            itemSelect.classList.remove('treelist-item-active');
            this.isActive = false;
        }
    }

    setClick() {
        var p = this;

        document.querySelector('.'+p.class).addEventListener("click", ()=>{
            window.dispatchEvent(new CustomEvent("TreeItem Click",
                {
                    detail: {
                        item: { id: this.id, class: this.class, display: this.display },
                        parent: { html: this.parent.base, depth: this.parent.depth },
                        breadcrum: this.breadcrum
                    }
                }
            ));
        });

        document.querySelector('.'+p.class).addEventListener("dblclick", ()=>{
            p.parent.selectedId = p.id;     //l'id de l'élement selectioné est envoyer a l'objet de la liste
            p.parent.nextLevel();           // on avance dans l'arborescence
        });
    }
}
