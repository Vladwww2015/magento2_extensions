define([
    'jquery',
    'underscore'
], function($, _){
    "use strict";

    var productUrl = function (config) {
        var productUrl = '';
        if(_.isUndefined(config.product_url) === false) {
            $('#product_url').attr('value', config.product_url);
        }
    };

    return productUrl;
});