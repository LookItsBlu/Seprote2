import ListItem from './ListItem.js'

export default class TreeList {
    constructor(div) {
        var p = this;

        p.base = div;
        p.selectedId = -1;
        p.history = [];
        p.depth = -1;
        p.items = new Array();

        p.niveaux = [
            "Année",
            "Formation",
            "Semestre",
            "Période",
            "Module"
        ];

        p.displayed_value = [
            [1, 2],
            1,
            [1, 2],
            [1, 2],
            1
        ];

        p.received_data = [];

        p.nextLevel();

        p.eventListener();
    }

    nextLevel() {
        if (this.depth == this.niveaux.length - 1) {
            return 0;
        } else {
            this.depth++;

            //we're moving deeper into the list, lets add this path to the history
            this.history.push(this.selectedId);

            this.getItems();
        }
    }

    previousLevel() {
        if (this.depth == 0) {
            return 0;
        } else {
            this.depth--;

            //we're going back a level in the list, pop the last visited id
            this.history.pop();
            this.selectedId = this.history[this.history.length - 1];

            this.getItems();
        }
    }

    getItems() {
        var p = this;

        $.ajax({
            method: 'post',
            url: 'lib/listItem/php/treeList.getItems.php',
            data: {
                'depth': p.depth,
                'id': p.selectedId
            },
            success: function (data) {
                p.received_data = JSON.parse(data);
                if (p.received_data.length > 0) {
                    p.createItems();
                }
            }
        });
    }

    createItems() {
        var p = this;

        p.items = new Array();

        p.received_data.forEach(data => {
            var display_val = data;
            var date_debut, date_fin;

            // si la valeur que l'on veut retourner est une liste de 2 valeurs,
            // c'est une année, on va donc rendre ca plus lisible
            if (p.displayed_value[p.depth].constructor === Array) {
                // pour avoir l'année uniquement, utiliser .substring(0, 4)
                date_debut = data[p.displayed_value[p.depth][0]];
                date_fin = data[p.displayed_value[p.depth][1]];

                display_val = '..nom.. ..debut.. - ..fin..'.strcast({
                    'nom': p.niveaux[p.depth],
                    'debut': date_debut,
                    'fin': date_fin
                });
            } else {
                display_val = data[p.displayed_value[p.depth]];
            }

            p.items.push(new ListItem(p, display_val, data[0], p.history));
        });

        this.createTable();
    }

    //création de la table
    createTable() {
        var p = this;

        //titre du niveaux de l'arborescence
        p.base.innerHTML = "<thead><tr><th>..titre..</th></tr></thead>".strcast({
            "titre": p.niveaux[p.depth]
        });

        //créer la liste
        p.base.innerHTML += "<tbody></tbody>";

        //ajoute chaque item dans la liste
        p.items.forEach(elem => {
            p.base.children[1].innerHTML += "..item..".strcast({
                "item": elem.displayItem()
            });
        });

        //set click event
        p.items.forEach(elem => {
            elem.setClick();
        });
        //ajoute un button pour remonter la liste si nous ne somme pas a la base de ce dernier
        if (p.history.length > 1) {
            var backBtn = document.createElement("tr"),
                backBtnCell = document.createElement("td"),
                backImg = document.createElement("img"),
                backTxt = document.createTextNode("Retour");
            backImg.src = "src/arrow-return-left.png";
            backBtn.appendChild(backBtnCell);
            backBtnCell.appendChild(backImg);
            backBtnCell.appendChild(backTxt);
            backBtn.className = 'treelist-history-back';
            p.base.children[1].insertBefore(backBtn, p.base.children[1].children[0]);

            document.querySelector('.treelist-history-back').addEventListener('dblclick', () => {
                p.previousLevel();
            });
        }
    }

    addActiveClass(itemClass) {
        this.items.forEach(elem => {
            if (elem.class == itemClass)
                elem.makeActive(true);
            else if (elem.isActive && elem.class.indexOf(itemClass)<0)
                elem.makeActive(false);
        });
    }

    eventListener() {
        window.addEventListener('TreeItem Click', event => {
            this.addActiveClass(event.detail.item.class);
        });
    }
}
