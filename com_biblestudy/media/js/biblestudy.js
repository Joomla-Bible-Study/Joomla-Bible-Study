jQuery(document).ready(function () {
    jQuery('.btnPlay').click(function () {
        var mediaId = jQuery(this).attr('alt');
        var url = jQuery(this).attr('href');

        jQuery('.inlinePlayer:not(#media-' + mediaId + ')').hide();
        jQuery('.inlinePlayer').html('');
        jQuery('#media-' + mediaId).toggle();
        jQuery('#media-' + mediaId).load('index.php?option=com_biblestudy&view=studieslist&controller=studieslist&task=inlinePlayer&tmpl=component');
        return false;
    });

    /**
     * @title Add Study
     */
    jQuery('#addReference').click(function () {
        var newReference = jQuery('#reference').clone();
        var deleteButton = '<a href="#" class="referenceDelete">Delete</a>';

        jQuery(newReference).children('#text').attr('value', '');
        jQuery(newReference).children('#scripture').selectOptions('0');

        jQuery(newReference).append(deleteButton);
        jQuery(newReference).appendTo('#references');

        jQuery(".referenceDelete").bind('click', function () {
            jQuery(this).parent("#reference").remove();
            return false;
        });
        return false;
    });
    jQuery(".referenceDelete").click(function () {
        jQuery(this).parent("#reference").remove();
        return false;
    });

    jQuery('.imgChoose').change(function () {
        var targetImage = jQuery('#img' + jQuery(this).attr('id'));
        var activeDir = targetImage.attr('src').split('/');
        activeDir.pop(); //Remove the previous image

        if (jQuery(this).val().substr(0, 1) == 0) {
            targetImage.hide();
        } else {
            targetImage.show();
        }

        targetImage.attr('src', activeDir.join('/') + '/' + jQuery(this).val());
    });

    /**
     * @title Templating Procedures
     */

        //Determine the type of template, and route to that function
    jQuery('#type').change(function () {
        eval(jQuery('#type option:selected').attr('value') + '()');
    });


    function canvasItemFunctions() {
        jQuery('#canvasDeleteItem').click(function () {
            //Delete Item, and update JSON string

            jQuery(this).parent('#canvasListItem').draggable(
                {
                    handle: 'div#canvasDeleteItem'
                }
            );

        });
    }

    /**
     * @desc Creates Controls for a item on the canvas.
     */
    function canvasItemControls(itemLabel) {
        var itemOptions = '<div id="canvasItemOptions">&nbsp;</div>';
        var moveItem = '<div id="canvasMoveItem">&nbsp;</div>';
        var deleteItem = '<div id="canvasDeleteItem">&nbsp;</div>';

        jQuery('.canvasItem').append(itemOptions);
        jQuery('.canvasItem').append(moveItem);
        jQuery('.canvasItem').append(deleteItem);
        jQuery('.canvasItem').append('<div class="canvasItemName">' + itemLabel + '</div>');

        canvasItemFunctions();
    }


    function tmplList() {
        var canvasListItem = '<div id="canvasListItem" class="canvasItem"></div>';

        jQuery('#tmplCanvas').append(canvasListItem);
        canvasItemControls('List Items');
    }

    function tmplListItem() {
        alert('this is the teacher list setup');
    }

    function tmplSingleItem() {
        alert('this is the teacher list setup');
    }

    function tmplModuleList() {
        alert('this is the teacher list setup');
    }

    function tmplModuleItem() {
        alert('this is the teacher list setup');
    }

    function tmplPopup() {
        alert('this is the teacher list setup');
    }
});
function goTo() {
    var sE = null, url;
    if (document.getElementById) {
        sE = document.getElementById('urlList');
    } else if (document.all) {
        sE = document.all['urlList'];
    }
    if (sE && (url = sE.options[sE.selectedIndex].value)) {
        location.href = url;
    }
}
function ReverseDisplay() {
    var ele = document.getElementById("scripture");
    var text = document.getElementById("heading");
    if (ele.style.display == "block") {
        ele.style.display = "none";
        text.innerHTML = "show";
    }
    else {
        ele.style.display = "block";
        text.innerHTML = "hide";
    }
}

function HideContent(d) {
    document.getElementById(d).style.display = "none";
}
function ShowContent(d) {
    document.getElementById(d).style.display = "block";
}
function ReverseDisplay2(d) {
    if (document.getElementById(d).style.display == "none") {
        document.getElementById(d).style.display = "block";
    }
    else {
        document.getElementById(d).style.display = "none";
    }
}


