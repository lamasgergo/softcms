
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
                showNotice(response[1]);
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


function removeFile(src, module, component){
    $('img[src="'+src+'"]').parent().parent().replaceWith($('<input type="hidden" name="removeSrc[]" value="'+src+'"/>'));
}

function showNotice(message){
    var msg = $('<div></div>').addClass('notice ui-corner-all');
    var text = $('<div></div>').addClass('text').html(message).appendTo(msg);

    $('<div class="delete"></div>').appendTo(text).click(function(){
        var current = $(this).parent().parent();
        $(document).find('.notice').each(function(){
            $(this).css('top', parseInt($(this).css('top')) - parseInt(current.height()) - 10);
        });
        current.remove();
    });

    var last = $('.notice:last');
    var top = parseInt(last.css('top'));
    if (top && !isNaN(top)){
        msg.css('top', top+last.height() + 10);
    } else {
        msg.css('top', 10);
    }

    msg.appendTo('body');
}