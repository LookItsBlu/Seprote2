import TreeList from '../lib/listItem/TreeList.js';
import InfoList from '../lib/infoList/InfoList.js';

$(document).ready(()=>{
    //Init tree
    new TreeList($('#liste_program')[0]);

    //Init list
    var display_list = new InfoList($('#table_program')[0]);

    //Detect clicks on the tree items, and update right list with new data
    window.addEventListener("TreeItem Click", (event)=>{
        let evt = event.detail;

        $.ajax({
            method: 'post',
            url: 'lib/infoList/php/infoList.gatherInfo.php',
            data: { 'depth': evt.parent.depth, 'id': evt.item.id },
            success: function(data){
                if (data === 'end') return 0;
                else display_list.updateItems(evt, JSON.parse(data));
            }
        });
    });
})
