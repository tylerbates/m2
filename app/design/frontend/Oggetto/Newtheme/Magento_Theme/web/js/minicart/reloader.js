define([
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function (
    Component,
    customerData
) {
    'use strict';

    return Component.extend({
        reloadMinicart: function() {
            var sections = ['cart'];
            customerData.invalidate(sections);
            customerData.reload(sections, true);
        }
    });
});
