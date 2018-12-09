define([
    'ko',
    'uiComponent'
], function (
    ko,
    Component
) {
    'use strict';

    return Component.extend({
        selectedName: ko.observable(),
        selectedLastname: ko.observable(),
        selectedEmail: ko.observable(),
        selectedValues: {
            name: this.selectedName(),
            lastname: this.selectedLastname(),
            email: this.selectedEmail()
        },

        text: ko.computed(function() {
            return this.selectedValues.name + ', ' + this.selectedValues.lastname + ', ' + this.selectedValues.email;
        }.bind(this))
    });
});
