function showBody(){
	document.getElementById('BodyCell').style.visibility='visible';
	document.getElementById('ProgressCell').style.visibility='hidden';
	document.getElementById('ProgressCell').style.height='0';
}
function hideBody(){
	myJsProgressBarHandler.setPercentage('element1','0');
	document.getElementById('BodyCell').style.visibility='hidden';
	document.getElementById('ProgressCell').style.visibility='visible';
	document.getElementById('ProgressCell').style.height=window.innerHeight;
}

function progressStep(pers){
	myJsProgressBarHandler.setPercentage('element1',pers);
}


function initEditorFull(item){
        var oFCKeditor = new FCKeditor( 'Full_Text' ) ;
        oFCKeditor.BasePath = "/admin/source/editors/FCKEditor/" ;

        oFCKeditor.Config["CustomConfigurationsPath"] = oFCKeditor.BasePath+"sconfig.js"  ;
        oFCKeditor.Width = 650;
        oFCKeditor.Height = 400;
        oFCKeditor.Config["AutoDetectLanguage"] = true ;
        oFCKeditor.Config["DefaultLanguage"]    = "ru" ;
        oFCKeditor.ReplaceTextarea() ;


		var oFCKeditor2 = new FCKeditor( 'Short_Text' ) ;
        oFCKeditor2.BasePath = "/admin/source/editors/FCKEditor/" ;

        oFCKeditor2.Config["CustomConfigurationsPath"] = oFCKeditor.BasePath+"sconfig.js"  ;
        oFCKeditor2.ToolbarSet = 'Short';
        oFCKeditor2.Width = 650;
        oFCKeditor2.Height = 300;
        oFCKeditor2.Config["AutoDetectLanguage"] = true ;
        oFCKeditor2.Config["DefaultLanguage"]    = "ru" ;
        oFCKeditor2.ReplaceTextarea() ;
}


function initEditor(item, toolbar){
        var oFCKeditor = new FCKeditor( item ) ;
        oFCKeditor.BasePath = "/admin/source/editors/FCKEditor/" ;

        oFCKeditor.Config["CustomConfigurationsPath"] = oFCKeditor.BasePath+"sconfig.js"  ;
		if (toolbar){
			oFCKeditor2.ToolbarSet = toolbar;
		}
        oFCKeditor.Width = 650;
        oFCKeditor.Height = 400;
        oFCKeditor.Config["AutoDetectLanguage"] = true ;
        oFCKeditor.Config["DefaultLanguage"]    = "ru" ;
        oFCKeditor.ReplaceTextarea() ;
		
}

function EditorSubmit(){
        this.UpdateEditorFormValue = function()
        {
                for ( i = 0; i < parent.frames.length; ++i )
                        if ( parent.frames[i].FCK )
                                parent.frames[i].FCK.UpdateLinkedField();
        }
}
// instantiate the class
var EditorSubmit = new EditorSubmit();
