(function() {
    tinymce.PluginManager.add('mce_content_reveal', function( editor, url ) {
        editor.addButton( 'mce_content_reveal', {
            title: 'Content Reveal',
            icon: 'icon dashicons-image-flip-vertical',
            onclick: function() {
                selectText = tinymce.activeEditor.selection.getContent({format: 'text'});
                editor.insertContent('[reveal heading="%image% Click here to show/hide contents"]' + selectText + '[/reveal]');
            }
        });
    });
})();