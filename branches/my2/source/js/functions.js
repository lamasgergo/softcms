
function send_form(formId, module, component, method, tabLocked){

    var url = '/admin/ajax/index.php?mod='+module+'&class='+component+'&method='+method;
    if (!tabLocked) tabLocked = false;
    $.ajax({
        type: "POST",
        url: url,
        data: $('#'+formId).serialize(),
        success: function(response){
            eval('var response = '+response+';');
            if(typeof response =='object' || typeof response =='array'){
                alert(response[1]);
                result = response[0];
            } 
            if (result){
                refreshTabTable(module, component, method, tabLocked);
            }
        }
    });

};

function initEditorFull(item){
    if (CKEDITOR.instances[item]) {
        CKEDITOR.remove(CKEDITOR.instances[item]);
    }

    $( '#' + item ).ckeditor(function() { /* callback code */ }, { skin : 'office2003', toolbar: 'Full' });
}

function initEditorLite(item){
       if (CKEDITOR.instances[item]) {
        CKEDITOR.remove(CKEDITOR.instances[item]);
    }

    $( '#' + item ).ckeditor(function() { /* callback code */ }, { skin : 'office2003', toolbar: 'Lite' });
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
