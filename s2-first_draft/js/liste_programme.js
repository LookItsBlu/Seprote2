import TreeList from '../lib/js/listItem/TreeList.js';
// AJOUTER <script type='module' src='lib/js/infoList/InfoList.js'></script>
// DANS liste_programme.php ET DECOMMENTER CE CODE:
//import InfoList from '../lib/js/infoList/InfoList.js';

$(document).ready(()=>{
    //Init list
    new TreeList($('#liste_program')[0]);


    // CODE D'EXAMPLE, CE CODE DOIT ETRE MIS DANS UN NOUVEAU FICHIER
    function eventHandler(e) {
      console.log('click! '+e.detail.item.id);
    }
    window.addEventListener("TreeList Click", eventHandler);
    // CODE D'EXAMPLE, CE CODE DOIT ETRE MIS DANS UN NOUVEAU FICHIER


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
