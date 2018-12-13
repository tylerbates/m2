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
                selectedValue: '${ $.parentName }:${ $.inputName }'
            }
        },

        selectedValue: ko.observable()
    });
});
