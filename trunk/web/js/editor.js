function editorInit(selector){
    $(selector + '[required]').removeAttr('required');
    $(selector).ckeditor({
        customConfig: '/js/ckeditor/config.js'
    });
}
