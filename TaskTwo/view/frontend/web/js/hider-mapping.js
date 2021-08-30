define(['jquery'], function($) {
    $.widget('namespace.widget', {
        options: {
            selector: 'body',
        },
        _create: function() {
            this.hideAll();
        },
        hideAll: function() {
            $(this.options.selector).hide();
        }
    });
    return $.namespace.widget;

});