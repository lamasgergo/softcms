function closeActiveTab() {
    var selected = $("#backend").data('selected.tabs');

}

function refreshTabTable(module, component, tabLocked) {
    if (!tabLocked) {
        var selected = $("#backend").tabs('option', 'selected');
        $("#backend").tabs('remove', selected);
        $("#backend").find('[href=#tab_' + component + ']').click();
    }

    var selected = $("#backend").data('selected.tabs');

    var link = '/admin/ajax.php?mod=' + module + '&class=' + component + '&method=getTabContent';

    $.get(link, function(data) {
        $('#tab_' + component).find('#grid').empty();
        $('#tab_' + component).find('#grid').html(data);
    });


}
;

var lastIndex = 0;

function addTab(title, action, module, component, id) {
    if (lastIndex != 0) {
        removeDynamicTabs();
    }
    lastIndex = $('#backend').tabs('length');
    var link = '/admin/ajax.php?mod=' + module + '&class=' + component + '&method=showForm&action=' + action;
    if (id) link += "&id=" + id;

    $('#backend').tabs("add", link, title);
    $("#backend").tabs("select", lastIndex);

}
;

function removeTabByTitle(title) {
    var index = 0;
    $("#backend >ul").find('li').each(function() {
        if ($(this).find('span').text() == title) {
            $("#backend").tabs("remove", index);
        }
        index++;
    });
}
;
function removeDynamicTabs() {
    for (i = lastIndex; i < $('#backend').tabs('length'); i++) {
        $("#backend").tabs("remove", i);
    }
}
;


function addFormCallback(module, component) {
    refreshTabTable(module, component);
}
;

function changeFormCallback(module, component, tabLocked) {
    refreshTabTable(module, component, tabLocked);
}
;
function deleteFormCallback(module, component) {
    refreshTabTable(module, component, true);
}
;