function form_skining(form){
    markRequired(form);
//    formPanels(form);
//    $("select, input:checkbox, input:radio, input:file, input:text").uniform();
}

function markRequired(form){
    var req = $(form).find('#RequiredFields').val();
    var fields = req.split(',');
    for (var i in fields){
        var field = $.trim(fields[i]);
        $(form).find('[name='+field+']').css('border-left', '2px solid red');
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

    var url = '/admin/ajax/index.php?mod='+module+'&class='+component+'&method='+method;
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

    if (toolbar=='Full') {
        edHeight = '500px';
    }

    $( '#' + item ).ckeditor(function() { /* callback code */ }, {
        skin : 'office2003',
        toolbar: toolbar,
        width: '100%',
        height: edHeight,
        resize_enabled: false
    });
}

//function initEditorFull(item){
//        $(item).fck({
//            path: "/admin/source/editors/FCKEditor/",
//            config: {
//                CustomConfigurationsPath: "/admin/source/editors/FCKEditor/sconfig.js",
//                Width: 650,
//                Height: 400,
//                AutoDetectLanguage: true,
//                DefaultLanguage: 'ru'
//            }
//
//        });
//}
//
//function initEditorLite(item){
//        $(item).fck({
//            path: "/admin/source/editors/FCKEditor/",
//            config: {
//                CustomConfigurationsPath: "/admin/source/editors/FCKEditor/sconfig.js",
//                ToolbarSet : 'Short',
//                Width: 650,
//                Height: 300,
//                AutoDetectLanguage: true,
//                DefaultLanguage: 'ru'
//            }
//
//        });
//}
//
//function EditorSubmit(){
//        this.UpdateEditorFormValue = function()
//        {
//                for ( i = 0; i < parent.frames.length; ++i )
//                        if ( parent.frames[i].FCK )
//                                parent.frames[i].FCK.UpdateLinkedField();
//        }
//}
//// instantiate the class
//var EditorSubmit = new EditorSubmit();
