define(['uiComponent','jquery', 'mage/url'], function (Component, $, urlBuilder) {
    return Component.extend({
        defaults:{
            searchText: '',
            searchUrl: urlBuilder.build('username/index/autocomplete'),
            searchResult: [],
            availableSku: [],
            minChars: 3
        },
        initObservable: function () {
            this._super();
            this.observe(['searchText', 'searchResult']);
            return this;
        },
        initialize: function() {
            this._super();
            this.searchText.subscribe(this.handleAutocomplete.bind(this));
        },
        handleAutocomplete: function (searchValue) {

            if(searchValue.length >= this.minChars) {
                $.ajax({
                    url: this.searchUrl,
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        q: searchValue
                    },
                    complete: function(response) {
                        this.availableSku = response.responseJSON;
                        if(searchValue) {
                            let filteredSku = this.availableSku.filter(function (item) {
                                return item.indexOf(searchValue) != -1;
                            })
                            this.searchResult(filteredSku);
                        } else {
                            this.searchResult([]);
                        }
                    }.bind(this),
                    error: function() {
                        console.log('error');
                    }
                });
            } else {
                this.searchResult([]);
            }



            console.log(this.availableSku);
        }
    });
});
