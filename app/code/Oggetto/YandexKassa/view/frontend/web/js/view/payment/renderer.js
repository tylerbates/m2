define([
    'uiComponent',
    'Magento_Checkout/js/model/payment/renderer-list'
], function (Component, rendererList) {
    'use strict';

    rendererList.push(
        {
            type: 'yandex_kassa_cc',
            component: 'Oggetto_YandexKassa/js/view/payment/method/cc'
        }
    );

    /** Add view logic here if needed */
    return Component.extend({});
});