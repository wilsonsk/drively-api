/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	config.language = 'en';
	config.resize_enabled = false;
	
	// CKFinder Code
	config.filebrowserImageBrowseUrl = '../ckfinder/ckfinder.html?Type=Images';
	config.filebrowserImageUploadUrl = null;
	
	config.filebrowserBrowseUrl = '../ckfinder/ckfinder.html?Type=Documents';
	config.filebrowserUploadUrl = null;
	
	config.extraPlugins = "youtube";
	config.allowedContent = true;
	
	// Menus
	config.toolbar_KanaiTek = 
	[
		['Format','Font','FontSize','TextColor'],
		['Bold','Italic','Underline','Strike','Subscript','Superscript'],
		['NumberedList','BulletedList','-','Outdent','Indent','JustifyCenter'],
		'/',
		['Cut','Copy','PasteText','PasteFromWord','-','Scayt'],
		['Link','Unlink','Anchor'],
		['Undo','Redo','-','SelectAll','RemoveFormat'],
		['Image','Table','HorizontalRule','SpecialChar'],
		['Maximize', 'Source']
	];
	
	config.toolbar_Article = 
	[
		['Format'],
		['Bold','Italic','Underline','Strike','Subscript','Superscript', 'SpecialChar'],
		['NumberedList','BulletedList','JustifyCenter'],
		['Link','Unlink'],
		['Cut','Copy','PasteText','PasteFromWord','-','Scayt'],
		['Undo','Redo','RemoveFormat', 'Maximize', 'Source', 'Advertisement']
	];
	
	config.toolbar_Event = 
	[
		['Format'],
		['Bold','Italic','Underline','Strike','Subscript','Superscript', 'SpecialChar'],
		['NumberedList','BulletedList','JustifyCenter'],
		['Link','Unlink'],
		['Cut','Copy','PasteText','PasteFromWord','-','Scayt'],
		['Undo','Redo','RemoveFormat', 'Maximize', 'Source']
	];
	
	config.toolbar_KanaiTekNote = 
	[
		['TextColor','Bold','Italic'],
		['NumberedList','BulletedList'],
		['PasteText','PasteFromWord'],
		['RemoveFormat']
	];
	
	config.toolbar_KanaiTekBasic = 
	[
		['Format'],
		['TextColor','Bold','Italic'],
		['NumberedList','BulletedList'],
		['PasteText','PasteFromWord','-','Scayt'],
		['HorizontalRule','RemoveFormat'],
		['Link','Unlink','Anchor']
	];
	
	config.toolbar_KanaiTekBasicNoLink = 
	[
		['Format'],
		['TextColor','Bold','Italic', 'Underline'],
		['NumberedList','BulletedList'],
		['PasteText','PasteFromWord','-','Scayt'],
		['HorizontalRule','RemoveFormat']
	];
	
	config.toolbar_KanaiTekSimple = 
	[
		['Format'],
		['TextColor','Bold','Italic','Strike'],
		['NumberedList','BulletedList','-','Outdent','Indent'],
		['Cut','Copy','PasteText','PasteFromWord','-','Scayt'],
		['Undo','Redo','-','HorizontalRule','SpecialChar','-','SelectAll','RemoveFormat'],
		['Link','Unlink','Anchor'],
		['Source']
	];
	
	/*
	config.toolbar_KanaiTekAdvanced = 
	[
		['Cut','Copy','PasteText','PasteFromWord','-','Scayt'],
		['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		['Image','Youtube','Table','HorizontalRule','JustifyLeft','JustifyCenter', 'JustifyRight'],
		['SpecialChar', 'TextColor'],
		'/',
		['Format'],
		['Bold','Italic','Strike','Underline'],
		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		['Link','Unlink','Anchor'],
		['Maximize'], ['Source']
	];
	*/
	
	config.toolbar_KanaiTekAdvanced =
	[
		['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],['Maximize'],['Source'],
		['Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo','-','Scayt','-','Find','Replace','-','SelectAll','RemoveFormat'],
		['Styles','Format','Font','FontSize'],
		['TextColor','BGColor'],
		['Link','Unlink','Anchor'],
		['Image','Youtube','Table','HorizontalRule','Smiley','SpecialChar','PageBreak']

	];
};
