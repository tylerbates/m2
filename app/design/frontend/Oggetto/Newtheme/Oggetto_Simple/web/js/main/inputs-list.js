define([
    'ko',
    'uiComponent'
], function (
    ko,
    Component
) {
    'use strict';

    return Component.extend({
        name: ko.observable(),
        lastname: ko.observable(),
        email: ko.observable(),

        text: ko.computed(function() {
            return this.name() + ', ' + this.lastname() + ', ' + this.email();
        }.bind(this))
    });
});
