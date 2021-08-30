define(['jquery'], function ($) {
    $.widget('namespace.wid', {
       options: {
           selector: null,
       },
       _create: function () {
          this.Elements();
       },
        Elements: function () {
            $(this.options.selector).hide();
            $(this.element).hide();
        }
    });
    return $.namespace.wid;
});
