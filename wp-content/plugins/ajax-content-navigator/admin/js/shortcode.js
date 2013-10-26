(function() {
    tinymce.create('tinymce.plugins.acn', {
        init : function(ed, url) {
            ed.addButton('acn', {
                title : 'Ajax Content Navigator',
                image : url+'/images/shortcode.png',
                onclick : function() {
					ed.selection.setContent('[acn]');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('acn', tinymce.plugins.acn);
})();