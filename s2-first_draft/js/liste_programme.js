import TreeList from '../lib/js/listItem/TreeList.js';
import InfoList from '../lib/js/infoList/InfoList.js';

$(document).ready(()=>{
    //Init tree
    new TreeList($('#liste_program')[0]);

    //Init list
    var display_list = new InfoList($('#table_program')[0]);

    //Detect clicks on the tree items, and
    window.addEventListener("TreeItem Click", (event)=>{
        let evt = event.detail;
        $.ajax({
            method: 'post',
            url: 'lib/js/infoList/php/infoList.gatherInfo.php',
            data: { 'depth': evt.parent.depth, 'id': evt.item.id },
            success: function(data){
                if (data === 'end') return 0;
                else display_list.updateItems(evt, JSON.parse(data));
            }
        });
    });

    //Init Dragbar
    $('.cursor_drag').draggable({
        axis: 'x',
        containment: 'parent',
        helper: 'clone',
        start: function(event, ui) {
            $(this).attr('start_offset', $(this).offset().left);
            $(this).attr('start_next_width', $(this).next().width());
        },
        drag: function(event, ui) {
            var prev_element = $(this).prev();
            var next_element = $(this).next();
            var x_difference = $(this).attr('start_offset') - ui.offset.left;
            prev_element.width(ui.offset.left - prev_element.offset().left);
            next_element.width(parseInt($(this).attr('start_next_width')) + x_difference);
        }
    });
    $('.cursor_drag').dblclick(function() {
        $(this).next().width('75%');
    });
})
