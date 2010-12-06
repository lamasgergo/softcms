function form_skining(form){
    markRequired(form);
}

function markRequired(form){
    var req = $(form).find('#RequiredFields').val();
    var fields = req.split(',');
    for (var i in fields){
        var field = $.trim(fields[i]);
        $(form).find('[name='+field+']').addClass('required');
    }

}

function formPanels(form){
    var self = $(form);
    self.find('.panel').each(function(){
        var header = $('<div></div>')
            .addClass('ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix')
            .html($(this).find('.title'));
        $(this).find('.title').remove();

        var body = $('<div></div>')
                .addClass('ui-dialog-content ui-widget-content')
                .html($(this).html());
        $(this).empty();
        $(this).append(header);
        $(this).append(body);
    });
}

function send_form(formId, module, component, method, tabLocked){

    var url = '/admin/ajax.php?mod='+module+'&class='+component+'&method='+method;
    if (!tabLocked) tabLocked = false;
    $.ajax({
        type: "POST",
        url: url,
        data: $('#'+formId).serialize(),
        success: function(response){
            if (!response) return;
            eval('var response = '+response+';');
            if(typeof response =='object' || typeof response =='array'){
                alert(response[1]);
                result = response[0];
            } 
            if (result){
                refreshTabTable(module, component, tabLocked);
            }
        }
    });

};

function initEditor(item, toolbar){
    if (CKEDITOR.instances[item]) {
        CKEDITOR.remove(CKEDITOR.instances[item]);
    }

    var edHeight = '200px';

    if (!toolbar){
        toolbar = 'Basic';
    }
    if (toolbar=='Basic') {
        edHeight = '500px';
    }

    $( '#' + item ).ckeditor(function() { /* callback code */ }, {
        toolbar: toolbar,
        width: '100%',
        height: edHeight,
        resize_enabled: false
    });
}

function initGrid(){
    tableToGrid('.grid',{
        height: 'auto',
        multiselect: true
//        pager: $('#gridPager')
    });
    $(".grid").navGrid(".gridPager",{});
}

function removeFile(src, module, component){
/*
    var url = '/admin/ajax.php?mod='+module+'&class='+component+'&method=removeFile';
    $.ajax({
        type: "POST",
        url: url,
        data: {'src': src},
        success: function(response){
            if (!response) return;
            eval('var response = '+response+';');
            if(typeof response =='object' || typeof response =='array'){
                if (response[0]==true){
                    $('img[src="'+src+'"]').parent('.image').remove();
                }
                alert(response[1]);
            }
        }
    });
*/
    $('img[src="'+src+'"]').parent().parent().replaceWith($('<input type="hidden" name="removeSrc[]" value="'+src+'"/>'));
}