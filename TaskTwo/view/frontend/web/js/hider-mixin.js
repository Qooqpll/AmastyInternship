define(['jquery'], function ($) {
    var widgetMixin = {
        Elements: function () {  // функция, которую мы переопределяем
            this._hideMenu();
            this._super();
        },
        _hideMenu: function () {  // новая функция
            $('.columns').hide();
        }
    };
    return function (targetWidget) {
        $.widget('namespace.wid', targetWidget, widgetMixin);
        return $.namespace.wid;
    }
});
