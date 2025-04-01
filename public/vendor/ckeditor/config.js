/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
    config.removePlugins = 'forms';
    config.allowedContent = true;
    config.removePlugins = 'uploadform';
    CKEDITOR.dtd.$removeEmpty['i'] = false;
    CKEDITOR.dtd.$removeEmpty['span'] = false;
    config.enterMode = CKEDITOR.ENTER_BR;
};

CKEDITOR.on( 'dialogDefinition', function( ev )
{
    // Take the dialog name and its definition from the event
    // data.
    var dialogName = ev.data.name;
    var dialogDefinition = ev.data.definition;

    // Check if the definition is from the dialog we're
    // interested on (the Link and Image dialog).
    if ( dialogName == 'link' || dialogName == 'image' )
    {
        // remove Upload tab
        dialogDefinition.removeContents( 'Upload' );
    }
});