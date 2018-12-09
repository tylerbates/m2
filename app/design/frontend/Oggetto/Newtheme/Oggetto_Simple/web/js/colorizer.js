define([
    'jquery'
], function (
    $
) {
    'use strict';

    $.widget('mage.colorizer', {
        options: {
            color: '#000000'
        },

        setColor: function(element) {
            element.css('color', this.options.color);
        },

        _create: function() {
            this.setColor(this.element);
        }
    });
});
