define(['jquery'], function($) {
    $.widget('namespace.autocomplete', {
        options: {
            minChars: null,
            searchResultList: null,
            availableSku: [
                '2444-MB',
                '2444-MH',
                '1231-OK'
            ]
        },
        _create: function () {
            this.options.searchResultList = $('search-result-list');
            $('#search-input').on('keyup', this.processAutoComplete.bind(this));
        },
        processAutoComplete: function (event) {
            let queryText = $(event.target).val();
            this.options.searchResultList.empty();
            let filteredSku = [];
            if(queryText.length >= this.options.minChars) {
                filteredSku = this.options.availableSku.filter(function(item) {
                    return item.indexOf(queryText) != -1;
                })
                console.log(filteredSku);
            }
            if(filteredSku.length) {
                let searchList = filteredSku.map( function(item ) {
                    return $('<li/>').text(item);
                });

                this.options.searchResultList.append(searchList);
            } else {
                this.options.searchResultList.empty();
            }
        }
    });
    return $.namespace.autocomplete;
});
