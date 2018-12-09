define([
    'jquery'
], function (
    $
) {
    'use strict';

    return function (config, element) {
        $(element).css('color', config.color);
    };
});
