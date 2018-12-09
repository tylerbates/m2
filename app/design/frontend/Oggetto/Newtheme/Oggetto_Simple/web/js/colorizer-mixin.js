define(['jquery'], function ($) {
    'use strict';

    var mixin = {
        setColor: function(element) {
            this._super(element);
            element.css('border-color', this.options.color);
        }
    };

    return function (target) {
        $.widget('mage.colorizer', target, mixin);
        return $.mage.colorizer;
    }
});
