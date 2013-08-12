/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.height = '480px';
	config.language = 'zh-cn';
	// config.uiColor = '#AADC6E';
	config.removePlugins = 'about,a11yhelp,bidi,filebrowser,forms,iframe,newpage,preview,print,save,scayt,smiley,templates,wsc';
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection' ] },
		{ name: 'tools' },
		{ name: 'others' },
		{ name: 'mode' },
		'/',
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
		{ name: 'links' },
		{ name: 'insert' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'styles' },
		{ name: 'colors' }
	];
};
