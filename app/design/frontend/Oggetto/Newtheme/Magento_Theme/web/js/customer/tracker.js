define([
    'Magento_Customer/js/customer-data'
], function(
    customerData
) {
    'use strict';

    var data = customerData.get('customer');
    data.subscribe(function(value) {
        console.log(value);
    });
});
