define([], function () {
    'use strict';

    return function (target) {
        console.log('In mixin!');
        return target;
    }
});
