define([
    'ko',
    'jquery',
    'Magento_Checkout/js/view/payment/default',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/full-screen-loader',
    'Magento_Checkout/js/action/redirect-on-success',
    'yandexCheckoutUi'
], function (
    ko,
    $,
    Component,
    quote,
    fullScreenLoader,
    redirectOnSuccess
) {
    'use strict';

    return Component.extend({
        defaults: {
            redirectAfterPlaceOrder: false,
            template: 'Oggetto_YandexKassa/payment/cc'
        },

        chargeResult: $.Deferred(),
        paymentToken: ko.observable(false),

        initialize: function() {
            this._super();
            this.initCheckoutUi();
            return this;
        },

        initCheckoutUi: function() {
            this.checkoutUi = YandexCheckoutUI(
                this.getShopId(),
                {
                    amount: quote.getTotals()()['grand_total'],
                    domSelector: '.js-yandex-ui'
                }
            );

            this.checkoutUi.on('yc_success', function(response) {
                console.log(response);
                this.paymentToken(response.data.response.paymentToken);
                this.checkoutUi.chargeSuccessful();
                this.chargeResult.resolve(response);
            }.bind(this));

            this.checkoutUi.on('yc_error', function(response) {
                console.log(response);
                this.paymentToken(false);
                this.checkoutUi.chargeFailful();
                this.chargeResult.reject(response);
            }.bind(this));
        },

        preparePayment: function(data, event) {
            if (this.uiEnabled() && (typeof this.checkoutUi !== 'undefined')) {
                this.checkoutUi.open();
                $.when(this.chargeResult.done(function(response) {
                    this.placeOrder(data, event);
                }.bind(this)).fail(function(response) {
                    this.checkoutUi.close();
                }.bind(this)));
            } else {
                this.placeOrder(data, event);
            }
        },

        getData: function() {
            return {
                'method': this.getCode(),
                'additional_data': {
                    'payment_token': this.paymentToken()
                }
            };
        },

        afterPlaceOrder: function () {
            fullScreenLoader.startLoader();
            window.location.replace(
                window.checkoutConfig.payment[this.getCode()].redirectUrl
            );
        },

        uiEnabled: function () {
            return window.checkoutConfig.payment[this.getCode()].uiEnabled;
        },

        getShopId: function() {
            return window.checkoutConfig.payment[this.getCode()].shopId;
        }
    });
});