define(['uiComponent','jquery', 'mage/url'], function (Component, $, urlBuilder) {
    var koAutocompleteMixin = {
        defaults:{
            /*searchText: '',
            searchUrl: urlBuilder.build('username/index/autocomplete'),
            searchResult: [],
            availableSku: [],*/
            minChars: 5
        },
       /* handleAutocomplete: function() {
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
        }*/
    };

    return function (extender) {
        return extender.extend(koAutocompleteMixin);
    }
});
