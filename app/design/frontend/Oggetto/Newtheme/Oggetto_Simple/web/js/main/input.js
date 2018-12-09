define([
    'ko',
    'uiComponent'
], function (
    ko,
    Component
) {
    'use strict';

    return Component.extend({
        defaults: {
            exports: {
                selectedValue: '${ $.parentName }:selectedValues[${ $.inputName }]'
            }
        },

        selectedValue: ko.observable()
    });
});
