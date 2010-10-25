/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	

    config.toolbar_Basic = [
        ['PasteText','PasteFromWord','-', 'Undo','Redo'],
        ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['Link','Unlink','Anchor'],
        ['Image','Flash','Table'],
        '/',
        ['Styles','Format','Font','FontSize'],
        ['Maximize','About', '-', 'customPageBreak', '-', 'wrpCards', 'wPro', '-','Source']
    ];

    config.toolbar_Lite = [
        ['PasteText','PasteFromWord','-', 'Undo','Redo'],
        ['Bold','Italic'],
        ['NumberedList','BulletedList'],
        ['Link','Unlink','Anchor','-','Image'],
        ['Maximize','-','Source']
    ];

    config.skin = 'office2003';

    config.enterMode = 2;
    config.shiftEnterMode = 1;

    config.defaultLanguage = 'en';

    config.forcePasteAsPlainText = false;


    config.pasteFromWordRemoveFontStyles = true;

    config.resize_enabled = false;

    config.entities = false;
    config.entities_latin = false;
    config.entities_greek = true;
    config.entities_processNumerical=false;
    
    config.autoUpdateElement = true;
	config.format_tags = 'p';
	
};
