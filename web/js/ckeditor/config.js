/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	config.toolbar_Full =
	[
	    ['Source','-','Save','NewPage','Preview','-','Templates'],
	    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
	    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	    ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
	    '/',
	    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
	    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	    ['BidiLtr', 'BidiRtl'],
	    ['Link','Unlink','Anchor'],
	    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'],
	    '/',
	    ['Styles','Format','Font','FontSize'],
	    ['TextColor','BGColor'],
	    ['Maximize', 'ShowBlocks','-','About']
	];

	config.toolbar_Default =
	[
	    	    ['Cut','Copy','Paste','PasteText','PasteFromWord', 'SpellChecker'],
	    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	    ['Link','Unlink','Anchor'],
	    ['Image','Flash','HorizontalRule'],
	    ['TextColor'],
	    '/',
	    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript', '-', 'FontSize'],
	    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	    ['-','Source']
	];
	
	
	config.toolbar_Basic = [
	    ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','About']
	];

	config.toolbar = 'Default';

	config.filebrowserBrowseUrl = '/js/ckeditor/plugins/pdw_file_browser/index.php?editor=ckeditor';
        config.filebrowserImageBrowseUrl = '/js/ckeditor/plugins/pdw_file_browser/index.php?editor=ckeditor&filter=image';
        config.filebrowserFlashBrowseUrl = '/js/ckeditor/plugins/pdw_file_browser/index.php?editor=ckeditor&filter=flash';
};
