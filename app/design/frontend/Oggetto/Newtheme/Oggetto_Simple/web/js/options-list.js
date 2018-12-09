define([
    'uiComponent',
    'ko'
], function (
    Component,
    ko
) {
    'use strict';

    return Component.extend({
        selectedOption: ko.observable()
    });
});
