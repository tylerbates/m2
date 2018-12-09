define([
    'jquery',
    'Magento_Ui/js/modal/modal'
], function (
    $
) {
    'use strict';

    var mixin = {
        enableAddToCartButton: function () {
            this._super();
            $('<h2>Congratulations!!</h2>').modal().modal('openModal');
        }
    };

    return function (target) {
        $.widget('mage.catalogAddToCart', target, mixin);
        return $.mage.catalogAddToCart;
    }
});
